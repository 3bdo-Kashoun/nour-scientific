@php
    $record = $getRecord();
@endphp
<div class="relative flex flex-col justify-between h-full w-full">
    <!-- صورة المنتج والجرعة -->
    <div class="relative w-full h-48 flex-shrink-0 bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 overflow-hidden rounded-t-xl flex items-center justify-center">
        <!-- شارة الجرعة بالزاوية اليسرى العليا -->
        @if($record->dos_value && $record->dosage)
            <div class="absolute top-4 left-4 z-10">
                <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-lg bg-emerald-500 text-white shadow-sm font-sans">
                    {{ $record->dos_value }} {{ $record->dosage->unit_name }}
                </span>
            </div>
        @endif

        @if($record->image)
            <img src="{{ asset('storage/' . $record->image) }}" alt="{{ $record->name }}" class="w-full h-full object-cover">
        @else
            <div class="text-gray-300 dark:text-gray-600">
                <!-- أيقونة علبة الدواء / الكرتون -->
                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"></path>
                </svg>
            </div>
        @endif
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <!-- اسم المنتج والكود -->
        <div class="mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                {{ $record->name }}
            </h3>
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold font-sans">
                الكود: {{ $record->code }}
            </span>
        </div>

        <!-- التفاصيل (الشركة، السعر، الكمية، الحالة) -->
        <div class="space-y-2.5 text-sm flex-grow">
            <!-- الشركة -->
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">الشركة:</span>
                <span class="font-bold text-gray-900 dark:text-white">{{ $record->company?->name ?? 'غير محدد' }}</span>
            </div>

            <!-- السعر -->
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">السعر:</span>
                <span class="font-bold text-emerald-600 dark:text-emerald-400 font-sans">
                    {{ number_format($record->price, 2) }} د.ل
                </span>
            </div>

            <!-- الكمية -->
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">الكمية:</span>
                <span class="font-bold text-gray-900 dark:text-white font-sans">{{ $record->stock_quantity }}</span>
            </div>

            <!-- الحالة -->
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">الحالة:</span>
                @if($record->stock_quantity > 0)
                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50">
                        متوفر
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium rounded-full bg-red-50 dark:bg-red-950/30 text-red-700 dark:text-red-400 border border-red-100 dark:border-red-900/50">
                        نفذت الكمية
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
