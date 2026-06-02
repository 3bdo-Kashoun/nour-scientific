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
        ];
    }
}
