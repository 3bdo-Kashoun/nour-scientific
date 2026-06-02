<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\News;

class CustomDashboardWidget extends Widget
{
    protected static string $view = 'filament.widgets.custom-dashboard-widget';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        // 1. إحصائيات علوية
        $activeCustomersCount = User::where('is_admin', false)->count();
        $productsCount = Product::count();
        $newsCount = News::count();

        // إجمالي المبيعات من الطلبات التي تم بيعها (sold)
        $totalSales = Order::where('status', 'sold')->sum('total_price');

        // عدد الطلبيات الجديدة اليوم
        $todayOrdersCount = Order::whereDate('created_at', today())->count();

        // حساب نسبة النمو للمبيعات (مقارنة الشهر الحالي بالشهر السابق)
        $thisMonthSales = Order::where('status', 'sold')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_price');
        $lastMonthSales = Order::where('status', 'sold')->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->sum('total_price');
        $salesGrowth = $lastMonthSales > 0 ? (($thisMonthSales - $lastMonthSales) / $lastMonthSales) * 100 : ($thisMonthSales > 0 ? 100.0 : 0.0);

        // عدد المنتجات الجديدة المضافة في آخر 30 يوم
        $newProductsCount = Product::where('created_at', '>=', now()->subDays(30))->count();

        // نسبة نمو العملاء (مقارنة الشهر الحالي بالشهر السابق)
        $thisMonthUsers = User::where('is_admin', false)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $lastMonthUsers = User::where('is_admin', false)->whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $usersGrowth = $lastMonthUsers > 0 ? (($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100 : ($thisMonthUsers > 0 ? 100.0 : 0.0);

        // نسبة نمو الطلبيات (مقارنة الشهر الحالي بالشهر السابق)
        $thisMonthOrders = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)->whereYear('created_at', now()->subMonth()->year)->count();
        $ordersGrowth = $lastMonthOrders > 0 ? (($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : ($thisMonthOrders > 0 ? 100.0 : 0.0);

        // 2. آخر الطلبات للجدول
        $latestOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return [
            'activeCustomersCount' => $activeCustomersCount,
            'productsCount' => $productsCount,
            'newsCount' => $newsCount,
            'totalSales' => $totalSales,
            'latestOrders' => $latestOrders,
            'todayOrdersCount' => $todayOrdersCount,
            'salesGrowth' => $salesGrowth,
            'newProductsCount' => $newProductsCount,
            'usersGrowth' => $usersGrowth,
            'ordersGrowth' => $ordersGrowth,
        ];
    }
}
