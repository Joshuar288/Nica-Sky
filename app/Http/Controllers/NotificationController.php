<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $notifications = $request->user()->notifications()->latest()->paginate(15);
        $request->user()->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
