<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pizza;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalPizzas = Pizza::count();
        $totalOrders = Order::count();
        $totalRevenue = OrderDetail::join('pizzas', 'order_details.pizza_id', '=', 'pizzas.pizza_id')
            ->sum(DB::raw('pizzas.price * order_details.quantity'));
        $topPizzaType = Pizza::select('pizza_type_id', DB::raw('COUNT(*) as count'))
            ->groupBy('pizza_type_id')
            ->orderByDesc('count')
            ->first()?->pizza_type_id ?? 'N/A';
        $totalCustomers = Order::distinct('order_id')->count();
        
        return response()->json([
            'total_pizzas' => $totalPizzas,
            'total_orders' => $totalOrders,
            'total_revenue' => round($totalRevenue, 2),
            'top_pizza_type' => $topPizzaType,
            'total_customers' => $totalCustomers,
        ]);
    }
}
