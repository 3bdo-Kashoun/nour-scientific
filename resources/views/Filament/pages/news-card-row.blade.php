@php
    $record = $getRecord();
@endphp
<div class="relative flex flex-col justify-between h-full w-full">
    <!-- صورة الخبر -->
    <div class="relative w-full h-48 flex-shrink-0 bg-gray-50 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 overflow-hidden rounded-t-xl flex items-center justify-center">
        @if($record->image)
            <img src="{{ asset('storage/' . $record->image) }}" alt="{{ $record->title }}" class="w-full h-full object-cover">
        @else
            <div class="text-gray-300 dark:text-gray-600">
                <!-- أيقونة خبر/جريدة كبديل -->
                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5-6h7.5m-7.5 3h7.5m-7.5 3h7.5m3-6h3m-3 3h3m-3 3h3M6.75 21h10.5a2.25 2.25 0 002.25-2.25V4.5A2.25 2.25 0 0017.25 2.25H6.75A2.25 2.25 0 004.5 4.5v14.25A2.25 2.25 0 006.75 21z"></path>
                </svg>
            </div>
        @endif
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <!-- تاريخ الخبر -->
        <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 mb-2 justify-start">
            <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path>
            </svg>
            <span class="font-sans">{{ $record->created_at?->format('Y/m/d') }}</span>
        </div>

        <!-- عنوان الخبر -->
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-snug text-center">
            {{ $record->title }}
        </h3>

        <!-- وصف مختصر للخبر -->
        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed text-center">
            {{ $record->discreption }}
        </p>
    </div>
</div>
