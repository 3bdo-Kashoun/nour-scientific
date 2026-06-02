@php
    $record = $getRecord();
@endphp

<div class="fi-order-details-container">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800;900&display=swap');

        .fi-order-details-container {
            font-family: 'Tajawal', 'Cairo', sans-serif !important;
            direction: rtl !important;
        }

        /* حاوية الجدول */
        .invoice-table-wrapper {
            overflow: hidden;
            border-radius: 16px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03) !important;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .dark .invoice-table-wrapper {
            border-color: #374151 !important;
            background-color: #111827;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2) !important;
        }

        /* الجدول */
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        /* رأس الجدول */
        .invoice-thead th {
            background: linear-gradient(135deg, #028137, #009639) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            padding: 16px 20px !important;
            border-bottom: 2px solid #008030 !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* صفوف الجدول */
        .invoice-row {
            border-bottom: 1px solid #f1f5f9 !important;
            transition: all 0.2s ease;
        }

        .dark .invoice-row {
            border-bottom: 1px solid #1f2937 !important;
        }

        .invoice-row:nth-child(even) {
            background-color: #f8fafc;
        }

        .dark .invoice-row:nth-child(even) {
            background-color: rgba(31, 41, 55, 0.4);
        }

        .invoice-row:hover {
            background-color: #f0fdf4 !important;
        }

        .dark .invoice-row:hover {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }

        /* الخلايا */
        .invoice-td {
            padding: 16px 20px !important;
            font-size: 0.95rem !important;
            color: #334155 !important;
            vertical-align: middle;
        }

        .dark .invoice-td {
            color: #d1d5db !important;
        }

        .product-name-cell {
            font-weight: 700 !important;
            color: #0f172a !important;
        }

        .dark .product-name-cell {
            color: #ffffff !important;
        }

        /* بادج الكمية */
        .quantity-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            font-size: 0.95rem !important;
            font-weight: 800 !important;
            border-radius: 9999px !important;
            background-color: #e6f6ec !important;
            color: #008030 !important;
            border: 1px solid #b3e6c4 !important;
            box-shadow: 0 2px 4px rgba(0, 128, 48, 0.05) !important;
        }

        .dark .quantity-badge {
            background-color: rgba(16, 185, 129, 0.15) !important;
            color: #34d399 !important;
            border-color: rgba(16, 185, 129, 0.25) !important;
        }

        /* أرقام الأسعار */
        .price-text {
            font-weight: 700 !important;
            color: #475569 !important;
        }

        .dark .price-text {
            color: #9ca3af !important;
        }

        .subtotal-text {
            font-weight: 800 !important;
            color: #0f172a !important;
        }

        .dark .subtotal-text {
            color: #ffffff !important;
        }

        /* التذييل للجدول */
        .invoice-tfoot tr {
            border-top: 1px solid #e2e8f0 !important;
        }

        .dark .invoice-tfoot tr {
            border-top: 1px solid #374151 !important;
        }

        .tfoot-label {
            font-size: 0.95rem !important;
            font-weight: 700 !important;
            color: #64748b !important;
            padding: 14px 20px !important;
        }

        .dark .tfoot-label {
            color: #9ca3af !important;
        }

        .tfoot-value {
            font-size: 1.05rem !important;
            font-weight: 800 !important;
            color: #1e293b !important;
            padding: 14px 20px !important;
        }

        .dark .tfoot-value {
            color: #f3f4f6 !important;
        }

        /* صف الإجمالي النهائي الملون والفاخر */
        .grand-total-row {
            background: linear-gradient(135deg, #e6f6ec, #dcfce7) !important;
            border-top: 2px solid #00a651 !important;
        }

        .dark .grand-total-row {
            background: linear-gradient(135deg, #11291b, #064e3b) !important;
            border-top: 2px solid #10b981 !important;
        }

        .grand-total-label {
            font-size: 1.05rem !important;
            font-weight: 900 !important;
            color: #008030 !important;
            padding: 18px 20px !important;
        }

        .dark .grand-total-label {
            color: #34d399 !important;
        }

        .grand-total-value {
            font-size: 1.35rem !important;
            font-weight: 900 !important;
            color: #028137 !important;
            padding: 18px 20px !important;
        }

        .dark .grand-total-value {
            color: #10b981 !important;
        }
    </style>

    <div class="invoice-table-wrapper">
        <table class="invoice-table">
            <thead class="invoice-thead">
                <tr>
                    <th style="text-align: center; width: 60px;">#</th>
                    <th>المنتج</th>
                    <th style="text-align: center; width: 100px;">الكمية</th>
                    <th style="text-align: left; width: 160px;">سعر الوحدة</th>
                    <th style="text-align: left; width: 200px;">الإجمالي الفرعي</th>
                </tr>
            </thead>
            <tbody>
                @foreach($record->products as $index => $product)
                    <tr class="invoice-row">
                        <td class="invoice-td" style="text-align: center; color: #94a3b8; font-weight: 500;">
                            {{ $index + 1 }}
                        </td>
                        <td class="invoice-td product-name-cell">
                            {{ $product->name }}
                        </td>
                        <td class="invoice-td" style="text-align: center;">
                            <span class="quantity-badge">
                                {{ $product->pivot->quantity }}
                            </span>
                        </td>
                        <td class="invoice-td price-text" style="text-align: left;">
                            {{ number_format($product->pivot->price, 2) }} د.ل
                        </td>
                        <td class="invoice-td subtotal-text" style="text-align: left;">
                            {{ number_format($product->pivot->quantity * $product->pivot->price, 2) }} د.ل
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="invoice-tfoot">
                <tr>
                    <td colspan="3" class="tfoot-label" style="text-align: right;">إجمالي المنتجات</td>
                    <td colspan="2" class="tfoot-value" style="text-align: left;">
                        {{ number_format($record->total_price - $record->delivery_price, 2) }} د.ل
                    </td>
                </tr>
                @if($record->delivery_requested)
                    <tr>
                        <td colspan="3" class="tfoot-label" style="text-align: right;">سعر التوصيل</td>
                        <td colspan="2" class="tfoot-value" style="text-align: left;">
                            {{ number_format($record->delivery_price, 2) }} د.ل
                        </td>
                    </tr>
                @endif
                <tr class="grand-total-row">
                    <td colspan="3" class="grand-total-label" style="text-align: right;">
                        <span>الإجمالي الكلي للطلب</span>
                    </td>
                    <td colspan="2" class="grand-total-value" style="text-align: left;">
                        {{ number_format($record->total_price, 2) }} د.ل
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
