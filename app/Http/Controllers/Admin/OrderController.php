<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return Inertia::render('Admin/Orders/Index', [
            'orders' => $orders,
        ]);
    }

    public function show(Order $order)
    {
        $order->load('user', 'address', 'items.productVariant.product', 'items.productVariant.taille', 'items.productVariant.color');
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order,
        ]);
    }
}
