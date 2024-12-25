<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Thống kê tổng doanh thu theo từng danh mục
        $categoryRevenue = DB::table('order_details')
            ->select('categories.name as category_name', DB::raw('SUM(order_details.price * order_details.quantity) as total_revenue'))
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng
        $totalCustomers = DB::table('orders')
            ->select('user_id')
            ->distinct()
            ->count('user_id');

        // Doanh thu theo ngày, tháng, năm
        $revenueByDate = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total_revenue'))
            ->where('status', 'delivered')
            ->groupBy('date')
            ->get();

        $revenueByMonth = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_price) as total_revenue'))
            ->where('status', 'delivered')
            ->groupBy('year', 'month')
            ->get();

        $revenueByYear = Order::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_price) as total_revenue'))
            ->where('status', 'delivered')
            ->groupBy('year')
            ->get();

        $revenueByPaymentMethod = Order::where('status', 'delivered')
            ->select('payment_method', DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('payment_method')
            ->get();

        $currentYear = Carbon::now()->year;
        $allMonths = collect(range(1, 12))->map(function ($month) use ($currentYear) {
            return [
                'year' => $currentYear,
                'month' => $month,
                'total_revenue' => 0
            ];
        });

        $revenueByMonth = $revenueByMonth->keyBy('month');

        $fullRevenueByMonth = $allMonths->map(function ($month) use ($revenueByMonth) {
            $existingRevenue = $revenueByMonth->get($month['month']);
            return $existingRevenue ? $existingRevenue : $month;
        })->values();

        return view('admin.reports.index', compact(
            'categoryRevenue',
            'totalOrders',
            'totalCustomers',
            'revenueByDate',
            'revenueByMonth',
            'revenueByYear',
            'revenueByPaymentMethod',
            'fullRevenueByMonth'
        ));
    }
}
