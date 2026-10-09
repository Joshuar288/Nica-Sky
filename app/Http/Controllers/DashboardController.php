<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\ShipmentVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            UserRole::Admin => redirect()->route('admin.dashboard'),
            UserRole::Auditor => redirect()->route('auditor.dashboard'),
            default => redirect()->route('home'),
        };
    }

    public function admin(): View
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalCustomers' => User::where('role', UserRole::User->value)->count(),
            'totalProducts' => Product::count(),
            'recommendedProducts' => Product::where('is_recommended', true)->count(),
            'pendingShipments' => ShipmentVerification::where('status', 'pending')->count(),
            'recentUsers' => User::latest()->limit(5)->get(),
            'recentProducts' => Product::with('user')->latest()->limit(5)->get(),
        ]);
    }

    public function auditor(): View
    {
        return view('dashboard.auditor', [
            'pendingCount' => ShipmentVerification::where('status', 'pending')->count(),
            'approvedCount' => ShipmentVerification::where('status', 'approved')->count(),
            'rejectedCount' => ShipmentVerification::where('status', 'rejected')->count(),
            'recentVerifications' => ShipmentVerification::with('seller')->latest()->limit(8)->get(),
        ]);
    }
}
