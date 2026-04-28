@extends('layouts.layout')
@push('styles')
<link rel="stylesheet" href="pages/proudct.css">
@endpush
@section('content')

<section class="hero container">
    <div class="hero-content reveal">
        <i class="fa-solid fa-flask-vial main-top-icon"></i>
        <h1>منتجاتنا</h1>
        <p>نوفر أفضل المواد الكيميائية لمختلف الصناعات بجودة عالمية</p>
    </div>
</section>

<section class="search-section">
    <div class="container">
        {{-- لاحظ أننا أضفنا سمات HTMX على مستوى الفورم --}}
     <form hx-get="{{ route('products') }}"
      hx-trigger="keyup changed delay:500ms from:#search-input, change from:.category-select, submit"
      hx-target="#products-container"
      hx-select="#products-container" {{-- يضمن جلب الحاوية المطلوبة فقط --}}
      hx-swap="outerHTML transition:true"
      onsubmit="event.preventDefault();"
      class="search-form">



            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>

                {{-- حقل البحث --}}
                <input type="text" name="search" id="search-input"
                       value="{{ request('search') }}"
                       placeholder="ابحث عن منتج..."
                       class="search-input">

               <select name="category" class="category-select" onchange="this.form.submit()">
    <option value="">كل الأنواع</option>
    @foreach ($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
        </option>
    @endforeach
</select>

            </div>
        </form>
    </div>
</section>

<main class="container">
        @include('partials.search-result')
</main>

@endsection


