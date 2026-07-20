<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\CartService;
use App\Services\Frontend\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly OrderService $orderService
    ) {
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty.');
        }

        return view('frontend.checkout.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        if (!Auth::check()) {
            return redirect()->route('frontend.login')->with('info', 'Please login to place an order.');
        }

        $cart = $this->cartService->getCart();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('frontend.cart.index')->with('error', 'Your cart is empty.');
        }

        $order = $this->orderService->placeOrder($request->all(), $cart);

        return redirect()->route('frontend.orders.index')->with('success', 'Order placed successfully! Order Number: ' . $order->order_number);
    }
}
