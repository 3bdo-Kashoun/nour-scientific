@props(['new'])

<div class="news-card">
    <div class="news-image">
        {{-- نستخدموا المسار اللي مخزن في الداتا بيز مع سياق الـ storage --}}
        <img src="{{ $new->image ? asset('storage/' . $new->image) : asset('images/default-news.jpg') }}"
             alt="{{ $new->title }}">
    </div>

    <div class="news-content">
        <h3 class="news-title">{{ $new->title }}</h3>
        <p class="news-desc">{{ $new->discreption }}</p>
    </div>
</div>
