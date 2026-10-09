<?php

namespace App\Console\Commands;

use App\Models\ShipmentVerification;
use App\Models\User;
use App\Notifications\ProductPurchasedNotification;
use App\Notifications\PurchaseRefundedNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\DB;

class ExpireUnshippedPurchases extends Command
{
    protected $signature = 'purchases:expire-unshipped';

    protected $description = 'Devuelve los pagos de compras sin comprobante de envío dentro del plazo.';

    public function handle(): int
    {
        $defaultDeadline = (int) config('purchases.shipment_deadline_days', 3);
        $refunded = 0;

        DatabaseNotification::query()
            ->where('type', ProductPurchasedNotification::class)
            ->orderBy('created_at')
            ->cursor()
            ->each(function (DatabaseNotification $notification) use ($defaultDeadline, &$refunded): void {
                $processed = DB::transaction(function () use ($notification, $defaultDeadline): bool {
                    $purchase = DatabaseNotification::query()->lockForUpdate()->find($notification->id);

                    if (! $purchase) {
                        return false;
                    }

                    $data = $purchase->data;

                    if (($data['shipment_status'] ?? 'pending') === 'refunded') {
                        return false;
                    }

                    $deadline = isset($data['shipment_deadline'])
                        ? Carbon::parse($data['shipment_deadline'])
                        : $purchase->created_at->copy()->addDays($defaultDeadline);

                    if ($deadline->isFuture()) {
                        return false;
                    }

                    if (ShipmentVerification::where('purchase_notification_id', $purchase->id)->exists()) {
                        return false;
                    }

                    $buyerId = data_get($data, 'buyer.id');
                    $buyer = $buyerId ? User::find($buyerId) : null;

                    if (! $buyer) {
                        return false;
                    }

                    $refundedAt = now();
                    $data['shipment_status'] = 'refunded';
                    $data['payment']['status'] = 'Pago devuelto';
                    $data['refund'] = [
                        'status' => 'completed',
                        'reason' => 'No se recibió el comprobante de envío dentro del plazo establecido.',
                        'processed_at' => $refundedAt->toISOString(),
                    ];

                    $purchase->data = $data;
                    $purchase->save();

                    $buyer->notify(new PurchaseRefundedNotification([
                        'kind' => 'purchase_refunded',
                        'title' => 'Pago devuelto',
                        'purchase_notification_id' => $purchase->id,
                        'seller_name' => $purchase->notifiable?->name ?? 'Vendedor',
                        'total' => data_get($data, 'total', 0),
                        'items' => data_get($data, 'items', []),
                        'reason' => $data['refund']['reason'],
                        'refunded_at' => $data['refund']['processed_at'],
                    ]));

                    return true;
                });

                if ($processed) {
                    $refunded++;
                }
            });

        $this->info("{$refunded} pago(s) devuelto(s).");

        return self::SUCCESS;
    }
}
