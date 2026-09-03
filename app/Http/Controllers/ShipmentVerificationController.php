<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\ShipmentVerification;
use App\Models\User;
use App\Notifications\ProductPurchasedNotification;
use App\Notifications\ShipmentVerificationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShipmentVerificationController extends Controller
{
    public function store(Request $request, string $notification): RedirectResponse
    {
        $purchase = $request->user()->notifications()->whereKey($notification)->firstOrFail();
        abort_unless($purchase->type === ProductPurchasedNotification::class, 404);

        if (ShipmentVerification::where('purchase_notification_id', $purchase->id)->exists()) {
            return back()->withErrors(['evidence' => 'Este pedido ya tiene una evidencia de envío registrada.']);
        }

        $validated = $request->validate([
            'tracking_number' => ['nullable', 'string', 'max:100'],
            'seller_notes' => ['nullable', 'string', 'max:1000'],
            'evidence' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        $verification = ShipmentVerification::create([
            'purchase_notification_id' => $purchase->id,
            'seller_id' => $request->user()->id,
            'tracking_number' => $validated['tracking_number'] ?? null,
            'seller_notes' => $validated['seller_notes'] ?? null,
            'evidence_path' => $request->file('evidence')->store('shipment-evidence', 'public'),
        ]);

        $reviewers = User::whereIn('role', [UserRole::Auditor->value, UserRole::Admin->value])->get();
        Notification::send($reviewers, new ShipmentVerificationNotification([
            'kind' => 'shipment_submitted',
            'title' => 'Nueva evidencia de envío',
            'verification_id' => $verification->id,
            'seller_name' => $request->user()->name,
        ]));

        return back()->with('success', 'La evidencia fue enviada para revisión.');
    }

    public function evidence(Request $request, ShipmentVerification $shipmentVerification): StreamedResponse
    {
        abort_unless($request->user()->canAudit() || $shipmentVerification->seller_id === $request->user()->id, 403);
        abort_unless(Storage::disk('public')->exists($shipmentVerification->evidence_path), 404);

        return Storage::disk('public')->response($shipmentVerification->evidence_path);
    }

    public function index(): View
    {
        $verifications = ShipmentVerification::with(['seller', 'auditor'])->latest()->paginate(15);

        return view('auditor.shipments.index', compact('verifications'));
    }

    public function review(Request $request, ShipmentVerification $shipmentVerification): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'review_notes' => ['nullable', 'string', 'max:1000', 'required_if:status,rejected'],
        ]);

        abort_if($shipmentVerification->status !== 'pending', 422, 'Esta evidencia ya fue revisada.');

        $shipmentVerification->update([
            'auditor_id' => $request->user()->id,
            'status' => $validated['status'],
            'review_notes' => $validated['review_notes'] ?? null,
            'reviewed_at' => now(),
        ]);

        $shipmentVerification->seller->notify(new ShipmentVerificationNotification([
            'kind' => 'shipment_reviewed',
            'title' => $validated['status'] === 'approved' ? 'Envío verificado' : 'Evidencia de envío rechazada',
            'verification_id' => $shipmentVerification->id,
            'status' => $validated['status'],
            'review_notes' => $validated['review_notes'] ?? null,
        ]));

        return back()->with('success', 'La revisión fue registrada correctamente.');
    }
}
