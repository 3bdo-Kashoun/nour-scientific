@props(['icon', 'title', 'datatarget', 'number'])

<div class="stat-card">
    <div class="stat-icon"><i class="fa-solid {{ $icon }}"></i></div>
    <div class="stat-number" data-target="{{ $datatarget }}">{{ $number }}</div>
    <div class="stat-label">{{ $title }}</div>
</div>
