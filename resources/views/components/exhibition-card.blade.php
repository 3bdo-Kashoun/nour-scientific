@props(['event']) 

<div class="exhibition-card">
    <span class="ex-status">{{ $event->status }}</span>


    <span class="ex-date">
        {{ $event->start_date->format('d') }}-{{ $event->end_date->format('d') }}
        {{ $event->start_date->translatedFormat('F Y') }}
    </span>

    <h3 class="ex-title">{{ $event->title }}</h3>

    <div class="ex-details">
        <span><i class="fa-solid fa-location-dot"></i> {{ $event->city }}</span>
        <span><i class="fa-solid fa-store"></i>  {{ $event->booth }}</span>
    </div>
</div>
