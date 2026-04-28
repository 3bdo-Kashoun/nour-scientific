@props(['title', 'description', 'icon', 'feature1', 'feature2', 'feature3'])
<div class="service-card reveal">
    <div class="service-content">
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
        <ul class="service-list">
            <li><i class="fa-solid fa-circle-check"></i> {{ $feature1 }}</li>
            <li><i class="fa-solid fa-circle-check"></i> {{ $feature2 }}</li>
            <li><i class="fa-solid fa-circle-check"></i> {{ $feature3 }}</li>
        </ul>
    </div>
    <div class="service-icon-large">
        <i class="fa-solid {{ $icon }}"></i>
    </div>
</div>
