<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Notifications\ProductPurchasedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $request->session()->get('cart', []);

        $products = Product::with('images')
            ->whereKey(array_keys($cart))
            ->get()
            ->map(function (Product $product) use ($cart) {
                $product->cart_quantity = $cart[$product->id];
                $product->cart_subtotal = $product->price * $product->cart_quantity;

                return $product;
            });

        $total = $products->sum('cart_subtotal');

        return view('cart.index', compact('products', 'total'));
    }

    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'Añade productos antes de continuar al pago.');
        }

        $products = Product::with('images')
            ->whereKey(array_keys($cart))
            ->get()
            ->map(function (Product $product) use ($cart) {
                $product->cart_quantity = $cart[$product->id];
                $product->cart_subtotal = $product->price * $product->cart_quantity;

                return $product;
            });

        $total = $products->sum('cart_subtotal');

        return view('cart.checkout', compact('products', 'total'));
    }

    public function processCheckout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:500'],
            'card_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'regex:/^[0-9 ]{13,23}$/'],
            'expiration' => ['required', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'cvv' => ['required', 'digits_between:3,4'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'El carrito está vacío.');
        }

        $products = Product::with('user')->whereKey(array_keys($cart))->get();

        if ($products->isEmpty()) {
            $request->session()->forget('cart');

            return redirect()->route('cart.index')->with('success', 'Los productos del carrito ya no están disponibles.');
        }

        $cardDigits = preg_replace('/\D/', '', $validated['card_number']);
        $cardLastFour = substr($cardDigits, -4);
        $buyer = $request->user();

        DB::transaction(function () use ($products, $cart, $validated, $cardLastFour, $buyer) {
            $products->groupBy('user_id')->each(function ($sellerProducts) use ($cart, $validated, $cardLastFour, $buyer) {
                $items = $sellerProducts->map(function (Product $product) use ($cart) {
                    $quantity = $cart[$product->id];

                    return [
                        'product_id' => $product->id,
                        'title' => $product->title,
                        'quantity' => $quantity,
                        'unit_price' => (float) $product->price,
                        'subtotal' => (float) $product->price * $quantity,
                    ];
                })->values()->all();

                $sellerProducts->first()->user->notify(new ProductPurchasedNotification([
                    'title' => 'Nueva compra recibida',
                    'buyer' => [
                        'id' => $buyer->id,
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                    ],
                    'delivery_address' => $validated['address'],
                    'payment' => [
                        'status' => 'Pago aprobado',
                        'method' => 'Tarjeta terminada en '.$cardLastFour,
                    ],
                    'items' => $items,
                    'total' => collect($items)->sum('subtotal'),
                ]));
            });
        });

        $request->session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Pago realizado correctamente. Los vendedores fueron notificados.');
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;

        $request->session()->put('cart', $cart);

        return back()->with('success', 'Producto añadido al carrito.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] = $validated['quantity'];
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');

        return back()->with('success', 'Carrito vaciado.');
    }
}
