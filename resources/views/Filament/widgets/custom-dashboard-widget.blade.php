<div class="ns-dashboard">
    <style>
    .ns-dashboard {
        font-family: 'Tajawal', sans-serif;
        direction: rtl;
        width: 100%;
        margin-top: 0.5rem;
    }

    /* 1. Stats Grid */
    .ns-stats-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        width: 100%;
    }

    @media (min-width: 768px) {
        .ns-stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 1024px) {
        .ns-stats-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    .ns-stat-card {
        background-color: #ffffff;
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dark .ns-stat-card {
        background-color: #111827;
        border-color: rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
    }

    .ns-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
    }

    .ns-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .ns-stat-icon {
        width: 3.25rem;
        height: 3.25rem;
        border-radius: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ns-svg-icon {
        width: 1.65rem;
        height: 1.65rem;
    }

    .ns-stat-icon-green {
        background-color: rgba(34, 197, 94, 0.12);
        color: #22c55e;
    }
    .ns-stat-icon-blue {
        background-color: rgba(59, 130, 246, 0.12);
        color: #3b82f6;
    }
    .ns-stat-icon-purple {
        background-color: rgba(168, 85, 247, 0.12);
        color: #a855f7;
    }
    .ns-stat-icon-orange {
        background-color: rgba(249, 115, 22, 0.12);
        color: #f97316;
    }

    .ns-stat-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.25rem 0.65rem;
        border-radius: 9999px;
        background-color: rgba(34, 197, 94, 0.1);
        color: #16a34a;
    }

    .ns-stat-body {
        display: flex;
        flex-direction: column;
    }

    .ns-stat-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.35rem;
        font-weight: 600;
    }

    .dark .ns-stat-label {
        color: #94a3b8;
    }

    .ns-stat-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.2;
    }

    .dark .ns-stat-value {
        color: #f8fafc;
    }

    /* 2. Action/Quick Links Grid */
    .ns-action-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        width: 100%;
    }

    @media (min-width: 768px) {
        .ns-action-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    .ns-action-card {
        border-radius: 1.25rem;
        padding: 2rem;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 13.5rem;
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ns-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
    }

    .ns-action-card-purple {
        background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%);
    }

    .ns-action-card-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .ns-action-card-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .ns-action-bg-icon-svg {
        position: absolute;
        top: 1rem;
        left: 1rem;
        width: 5.5rem;
        height: 5.5rem;
        opacity: 0.15;
        pointer-events: none;
    }

    .ns-action-header {
        display: flex;
        flex-direction: column;
        margin-top: auto;
        margin-bottom: 1.5rem;
    }

    .ns-action-title {
        font-size: 1.65rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
    }

    .ns-action-subtitle {
        font-size: 0.95rem;
        opacity: 0.9;
        font-weight: 600;
    }

    .ns-action-btn {
        background-color: #ffffff;
        border-radius: 0.75rem;
        padding: 0.6rem 1.25rem;
        font-weight: 700;
        font-size: 0.85rem;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        align-self: flex-start;
        text-decoration: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .ns-action-card-purple .ns-action-btn { color: #7e22ce; }
    .ns-action-card-blue .ns-action-btn { color: #1d4ed8; }
    .ns-action-card-green .ns-action-btn { color: #059669; }

    .ns-action-btn:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        background-color: #f8fafc;
    }

    .ns-action-btn:active {
        transform: scale(0.97);
    }

    /* 3. Bottom Orders Card */
    .ns-orders-card {
        background-color: #ffffff;
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.03);
        margin-bottom: 1.5rem;
        width: 100%;
    }

    .dark .ns-orders-card {
        background-color: #111827;
        border-color: rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
    }

    .ns-orders-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 1.25rem;
    }

    .dark .ns-orders-title {
        color: #f8fafc;
    }

    .ns-table-container {
        width: 100%;
        overflow-x: auto;
    }

    .ns-orders-table {
        width: 100%;
        border-collapse: collapse;
        text-align: right;
    }

    .ns-orders-table th {
        padding: 1rem;
        font-size: 0.875rem;
        font-weight: 700;
        color: #64748b;
        border-bottom: 2px solid #f1f5f9;
    }

    .dark .ns-orders-table th {
        color: #94a3b8;
        border-bottom-color: #334155;
    }

    .ns-orders-table td {
        padding: 1.1rem 1rem;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
    }

    .dark .ns-orders-table td {
        color: #cbd5e1;
        border-bottom-color: #1f2937;
    }

    .ns-orders-table tr:last-child td {
        border-bottom: none;
    }

    .ns-orders-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .dark .ns-orders-table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }

    /* 4. Badges */
    .ns-badge {
        display: inline-block;
        padding: 0.35rem 0.85rem;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 9999px;
        text-align: center;
    }

    .ns-badge-pending {
        background-color: #fef3c7;
        color: #d97706;
    }

    .dark .ns-badge-pending {
        background-color: rgba(217, 119, 6, 0.15);
        color: #fbbf24;
    }

    .ns-badge-cancelled {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .dark .ns-badge-cancelled {
        background-color: rgba(220, 38, 38, 0.15);
        color: #f87171;
    }

    .ns-badge-delivery {
        background-color: #dbeafe;
        color: #2563eb;
    }

    .dark .ns-badge-delivery {
        background-color: rgba(37, 99, 235, 0.15);
        color: #60a5fa;
    }

    .ns-badge-sold {
        background-color: #dcfce7;
        color: #16a34a;
    }

    .dark .ns-badge-sold {
        background-color: rgba(22, 163, 74, 0.15);
        color: #4ade80;
    }
    </style>

    {{-- 1. Stats Grid --}}
    <div class="ns-stats-grid">
        {{-- إجمالي المبيعات --}}
        <div class="ns-stat-card">
            <div class="ns-stat-header">
                <div class="ns-stat-icon ns-stat-icon-green">
                    <svg class="ns-svg-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="ns-stat-badge" style="{{ $salesGrowth < 0 ? 'background-color: rgba(239, 68, 68, 0.1); color: #ef4444;' : '' }}">
                    {{ $salesGrowth >= 0 ? '+' : '' }}{{ number_format($salesGrowth, 1) }}%
                </span>
            </div>
            <div class="ns-stat-body">
                <span class="ns-stat-label">إجمالي المبيعات</span>
                <span class="ns-stat-value">{{ number_format($totalSales, 0) }} د.ل</span>
            </div>
        </div>

        {{-- عدد المنتجات --}}
        <div class="ns-stat-card">
            <div class="ns-stat-header">
                <div class="ns-stat-icon ns-stat-icon-blue">
                    <svg class="ns-svg-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="ns-stat-badge">
                    +{{ $newProductsCount }} جديد
                </span>
            </div>
            <div class="ns-stat-body">
                <span class="ns-stat-label">عدد المنتجات</span>
                <span class="ns-stat-value">{{ $productsCount }}</span>
            </div>
        </div>

        {{-- العملاء النشطين --}}
        <div class="ns-stat-card">
            <div class="ns-stat-header">
                <div class="ns-stat-icon ns-stat-icon-purple">
                    <svg class="ns-svg-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20H22V18C22 15.7909 20.2091 14 18 14C17.0767 14 16.2233 14.3142 15.5434 14.8415M17 20H7M17 20V18C17 16.7118 16.3981 15.5641 15.4566 14.8415M7 20H2V18C2 15.7909 3.79086 14 6 14C6.92329 14 7.77666 14.3142 8.45662 14.8415M7 20V18C7 16.7118 7.6019 15.5641 8.54338 14.8415M8.54338 14.8415C9.40193 14.1206 10.4907 13.682 11.682 13.682C12.8732 13.682 13.962 14.1206 14.8206 14.8415M12 10C13.6569 10 15 8.65685 15 7C15 5.34315 13.6569 4 12 4C10.3431 4 9 5.34315 9 7C9 8.65685 10.3431 10 12 10Z"></path>
                    </svg>
                </div>
                <span class="ns-stat-badge" style="{{ $usersGrowth < 0 ? 'background-color: rgba(239, 68, 68, 0.1); color: #ef4444;' : '' }}">
                    {{ $usersGrowth >= 0 ? '+' : '' }}{{ number_format($usersGrowth, 1) }}%
                </span>
            </div>
            <div class="ns-stat-body">
                <span class="ns-stat-label">العملاء النشطين</span>
                <span class="ns-stat-value">{{ $activeCustomersCount }}</span>
            </div>
        </div>

        {{-- معدل النمو --}}
        <div class="ns-stat-card">
            <div class="ns-stat-header">
                <div class="ns-stat-icon ns-stat-icon-orange">
                    <svg class="ns-svg-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 12l3-3 3 3 4-4M8 21h12a2 2 0 002-2V7a2 2 0 00-2-2H8a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <span class="ns-stat-badge" style="{{ $ordersGrowth < 0 ? 'background-color: rgba(239, 68, 68, 0.1); color: #ef4444;' : '' }}">
                    {{ $ordersGrowth >= 0 ? '+' : '' }}{{ number_format($ordersGrowth, 1) }}%
                </span>
            </div>
            <div class="ns-stat-body">
                <span class="ns-stat-label">معدل النمو (الطلبيات)</span>
                <span class="ns-stat-value">{{ number_format($ordersGrowth, 1) }}%</span>
            </div>
        </div>
    </div>

    {{-- 2. Actions Grid --}}
    <div class="ns-action-grid">
        {{-- كارت المستخدمين البنفسجي --}}
        <div class="ns-action-card ns-action-card-purple">
            <svg class="ns-action-bg-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
            </svg>
            <div class="ns-action-header">
                <span class="ns-action-title">المستخدمين</span>
                <span class="ns-action-subtitle">{{ $activeCustomersCount }} مستخدم نشط</span>
            </div>
            <a href="/admin/users" class="ns-action-btn">
                إدارة المستخدمين
            </a>
        </div>

        {{-- كارت آخر الأخبار الأزرق --}}
        <div class="ns-action-card ns-action-card-blue">
            <svg class="ns-action-bg-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
            </svg>
            <div class="ns-action-header">
                <span class="ns-action-title">آخر الأخبار</span>
                <span class="ns-action-subtitle">{{ $newsCount }} أخبار جديدة</span>
            </div>
            <a href="/admin/news" class="ns-action-btn">
                إدارة الأخبار
            </a>
        </div>

        {{-- كارت نشاط اليوم الأخضر --}}
        <div class="ns-action-card ns-action-card-green">
            <svg class="ns-action-bg-icon-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <div class="ns-action-header">
                <span class="ns-action-title">نشاط اليوم</span>
                <span class="ns-action-subtitle">{{ $todayOrdersCount }} طلب جديد اليوم</span>
            </div>
            <a href="/admin/orders" class="ns-action-btn">
                عرض التفاصيل
            </a>
        </div>
    </div>

    {{-- 3. Bottom Table Card --}}
    <div class="ns-orders-card">
        <h2 class="ns-orders-title">آخر الطلبات</h2>
        <div class="ns-table-container">
            <table class="ns-orders-table">
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>العميل</th>
                        <th>المبلغ</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestOrders as $order)
                        <tr>
                            <td>#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->user?->name ?? 'عميل مجهول' }}</td>
                            <td>{{ number_format($order->total_price, 2) }} د.ل</td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="ns-badge ns-badge-pending">قيد الانتظار</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="ns-badge ns-badge-cancelled">ملغية</span>
                                @elseif($order->status === 'in_delivery')
                                    <span class="ns-badge ns-badge-delivery">قيد التوصيل</span>
                                @elseif($order->status === 'sold')
                                    <span class="ns-badge ns-badge-sold">مكتمل</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: #94a3b8;">
                                لا توجد طلبات مسجلة حالياً في النظام.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
