@extends('layouts.layout')
@push('styles')
    <link rel="stylesheet" href="pages/news.css">
@endpush

@section('title', 'اخر الأخبار -')
@section('content')
    <section class="reveal">
        <!-- محتوى وكروت الاخبار -->
        <div class="section-header">
            <i class="fa-regular fa-newspaper" style="font-size: 3rem; color: #2ecc71; margin-bottom: 15px;"></i>
            <h1>أخر أخبار الشركة</h1>
            <p>تابع أحدث المستجدات والإنجازات التي حققتها شركة نور العلمية</p>
        </div>

        <div class="news-grid">
            @foreach ($news as $new)
                <x-news-card :new="$new"/>
            @endforeach

          
        </div>
    </section>
    <section class="exhibitions-section reveal">
        <!-- محتوى وكروت معارض -->
        <div class="section-header">
            <h1>شاركونا في معارضنا القادمة</h1>
            <p>نحن نشارك في أبرز المعارض والمؤتمرات المتخصصة</p>
        </div>

        <div class="partners-grid">
            @foreach ($events as $event)
                <x-exhibition-card :event="$event"/>
            @endforeach



        </div>
    </section>
@endsection
