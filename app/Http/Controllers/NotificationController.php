<?php

namespace App\Http\Controllers;

use App\Models\ShipmentVerification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()->notifications()->latest()->paginate(15);
        $verifications = ShipmentVerification::where('seller_id', $request->user()->id)
            ->whereIn('purchase_notification_id', $notifications->pluck('id'))
            ->get()
            ->keyBy('purchase_notification_id');
        $request->user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications', 'verifications'));
    }
}
