@php
    $record = $getRecord();
@endphp
<div class="relative p-6 flex flex-col items-center justify-between h-full w-full">
    <!-- شارة موردين بالزاوية -->
    <div class="absolute top-4 left-4">
        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/50">
            موردين
        </span>
    </div>

    <!-- صورة الشعار -->
    <div class="w-full flex justify-center mb-5 mt-4">
        <div class="w-32 h-32 flex-shrink-0 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center">
            @if($record->image)
                <img src="{{ asset('storage/' . $record->image) }}" alt="{{ $record->name }}" class="w-full h-full object-cover">
            @else
                <div class="text-gray-300 dark:text-gray-600">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h18v3H3V3z"></path>
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <!-- اسم الشركة -->
    <h3 class="text-xl font-bold text-gray-900 dark:text-white text-center mb-3 line-clamp-1 h-7 overflow-hidden">
        {{ $record->name }}
    </h3>

    <!-- التفاصيل (الدولة، الموقع، الاتصال) -->
    <div class="w-full space-y-2 flex-grow flex flex-col justify-center">
        <!-- الدولة والمدينة -->
        @if($record->country || $record->city)
            <div class="flex items-center justify-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z"></path>
                </svg>
                <span>{{ $record->country }}{{ $record->city ? '، ' . $record->city : '' }}</span>
            </div>
        @endif

        <!-- الموقع الإلكتروني -->
        @if($record->website)
            <div class="flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9s2.015-9 4.5-9m0 0a9.003 9.003 0 018.716 2.253M12 3a9.003 9.003 0 00-8.716 2.253M12 3v18"></path>
                </svg>
                <a href="{{ str_starts_with($record->website, 'http') ? $record->website : 'https://' . $record->website }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline font-medium font-sans">
                    {{ preg_replace('/^https?:\/\/(www\.)?/', '', $record->website) }}
                </a>
            </div>
        @endif

        <!-- البريد والهاتف -->
        <div class="text-center text-xs text-gray-500 dark:text-gray-400 mt-2 space-y-1">
            <div>{{ $record->email }}</div>
            <div style="direction: ltr;">{{ $record->phone }}</div>
        </div>
    </div>
</div>
