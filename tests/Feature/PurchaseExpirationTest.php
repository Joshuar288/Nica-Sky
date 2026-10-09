<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\User;
use App\Notifications\ProductPurchasedNotification;
use App\Notifications\PurchaseRefundedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseExpirationTest extends TestCase
{
    use RefreshDatabase;

    public function test_expired_purchase_without_shipping_evidence_is_returned_to_buyer(): void
    {
        $city = City::create([
            'name_departament' => 'Managua',
            'name_city' => 'Managua',
        ]);
        $buyer = User::factory()->create(['city_id' => $city->id, 'phone' => '88888888']);
        $seller = User::factory()->create(['city_id' => $city->id, 'phone' => '88888889']);

        $seller->notify(new ProductPurchasedNotification([
            'kind' => 'purchase_received',
            'shipment_status' => 'pending',
            'shipment_deadline' => now()->subMinute()->toISOString(),
            'buyer' => ['id' => $buyer->id],
            'items' => [['title' => 'Producto', 'quantity' => 1, 'subtotal' => 100]],
            'total' => 100,
            'payment' => ['status' => 'Pago aprobado'],
        ]));

        $purchase = $seller->notifications()->latest()->firstOrFail();

        $this->artisan('purchases:expire-unshipped')
            ->expectsOutput('1 pago(s) devuelto(s).')
            ->assertSuccessful();

        $purchase->refresh();

        $this->assertSame('refunded', $purchase->data['shipment_status']);
        $this->assertSame('Pago devuelto', $purchase->data['payment']['status']);
        $this->assertDatabaseHas('notifications', [
            'notifiable_id' => $buyer->id,
            'type' => PurchaseRefundedNotification::class,
        ]);
    }
}
