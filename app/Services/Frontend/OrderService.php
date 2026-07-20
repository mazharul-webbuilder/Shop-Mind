<?php

namespace App\Services\Frontend;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function placeOrder(array $data, Cart $cart)
    {
        return DB::transaction(function () use ($data, $cart) {
            $totalAmount = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $data['payment_method'] ?? 'cod',
                'payment_status' => 'pending',
                'shipping_address' => $data['shipping_address']
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Clear the cart
            $cart->items()->delete();

            return $order;
        });
    }

    public function getUserOrders()
    {
        return Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->get();
    }
}
