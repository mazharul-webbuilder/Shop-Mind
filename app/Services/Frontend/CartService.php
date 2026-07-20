<?php

namespace App\Services\Frontend;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function addToCart(int $productId, int $quantity = 1)
    {
        $cart = $this->getCart();

        $cartItem = $cart->items()->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        return $cart;
    }

    public function getCartCount()
    {
        $cart = $this->getCart();
        return $cart->items()->sum('quantity');
    }

    public function removeFromCart(int $cartItemId)
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $cartItemId)->delete();
    }

    public function updateQuantity(int $cartItemId, int $quantity)
    {
        $cart = $this->getCart();
        $cart->items()->where('id', $cartItemId)->update(['quantity' => $quantity]);
    }
}
