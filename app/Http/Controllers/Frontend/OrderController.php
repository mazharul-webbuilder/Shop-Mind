<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\OrderService;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function index()
    {
        $orders = $this->orderService->getUserOrders();
        return view('frontend.order.index', compact('orders'));
    }
}
