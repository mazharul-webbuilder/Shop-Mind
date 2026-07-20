<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index(Request $request)
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.product');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'cart' => $cart,
                'cart_count' => $this->cartService->getCartCount()
            ]);
        }

        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $this->cartService->addToCart($request->product_id, $request->quantity ?? 1);

        if ($request->wantsJson()) {
            $cart = $this->cartService->getCart();
            $cart->load('items.product');
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart' => $cart
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $this->cartService->updateQuantity($id, $request->quantity);

        if ($request->wantsJson()) {
            $cart = $this->cartService->getCart();
            $cart->load('items.product');
            return response()->json([
                'success' => true,
                'message' => 'Cart updated!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart' => $cart
            ]);
        }

        return back()->with('success', 'Cart updated!');
    }

    public function remove(Request $request, int $id)
    {
        $this->cartService->removeFromCart($id);

        if ($request->wantsJson()) {
            $cart = $this->cartService->getCart();
            $cart->load('items.product');
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart!',
                'cart_count' => $this->cartService->getCartCount(),
                'cart' => $cart
            ]);
        }

        return back()->with('success', 'Item removed from cart!');
    }
}
