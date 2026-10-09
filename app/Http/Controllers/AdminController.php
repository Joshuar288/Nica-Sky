<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function products(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:approved,rejected,pending'],
        ]);

        $products = Product::with(['user', 'category'])
            ->when($validated['q'] ?? null, function ($query, $search) {
                $query->where(function ($nested) use ($search) {
                    $nested->where('title', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($validated['status'] ?? null, fn ($query, $status) => $query->where('moderation_status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function moderateProduct(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'moderation_status' => ['required', 'in:approved,rejected'],
            'moderation_notes' => ['nullable', 'string', 'max:1000', 'required_if:moderation_status,rejected'],
        ]);

        $product->update([
            'moderation_status' => $validated['moderation_status'],
            'moderated_by' => $request->user()->id,
            'moderation_notes' => $validated['moderation_notes'] ?? null,
            'moderated_at' => now(),
        ]);

        return back()->with('success', 'La publicación fue actualizada correctamente.');
    }

    public function destroyProduct(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            if (! str_starts_with($image->rute, 'images/')) {
                Storage::disk('public')->delete($image->rute);
            }
        }

        $product->delete();

        return back()->with('success', 'La publicación fue eliminada.');
    }

    public function users(Request $request): View
    {
        $users = User::with('city')
            ->where('role', '!=', UserRole::Admin->value)
            ->when($request->string('q')->trim()->value(), function ($query, $search) {
                $query->where(fn ($nested) => $nested
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function destroyUser(Request $request, User $user): RedirectResponse
    {
        abort_if($user->id === $request->user()->id || $user->isAdmin(), 403, 'No puedes eliminar una cuenta administrativa.');

        $user->delete();

        return back()->with('success', 'El usuario y sus publicaciones fueron eliminados.');
    }
}
