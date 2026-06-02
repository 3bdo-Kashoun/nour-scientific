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
        {{-- نموذج البحث والفلترة --}}
        <form action="{{ route('products') }}" method="GET" class="search-form" id="search-form">
            <div class="search-wrapper">
                <i class="fas fa-search search-icon"></i>

                {{-- حقل البحث النصي --}}
                <input type="text" name="search" id="search-input"
                       value="{{ request('search') }}"
                       placeholder="ابحث عن منتج..."
                       class="search-input"
                       autocomplete="off">

                {{-- قائمة اختيار التصنيفات --}}
                <select name="category" class="category-select" id="category-select">
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

{{-- حاوية المنتجات التي سيتم تحديثها باستخدام الأجاكس --}}
<main class="container" id="products-wrapper">
    @include('partials.search-result')
</main>

<!-- كود الأجاكس التفاعلي لتحديث المنتجات دون إعادة تحميل الصفحة -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('search-input');
        const categorySelect = document.getElementById('category-select');
        const productsWrapper = document.getElementById('products-wrapper');
        let debounceTimer;

        // دالة جلب المنتجات بالـ AJAX
        function fetchProducts() {
            // تأثير بصري لطيف يعبر عن التحميل (Micro-interaction)
            productsWrapper.style.opacity = '0.4';
            productsWrapper.style.transition = 'opacity 0.2s ease-in-out';

            const searchVal = searchInput.value.trim();
            const catVal = categorySelect.value;

            // بناء الرابط البرمجي مع معاملات الفلترة الحالية
            const params = new URLSearchParams();
            if (searchVal) {
                params.append('search', searchVal);
            }
            if (catVal) {
                params.append('category', catVal);
            }

            const fetchUrl = `{{ route('products') }}?${params.toString()}`;

            // تحديث رابط المتصفح (URL) في الأعلى بدون عمل Refresh للصفحة
            // لكي يستطيع المستخدم نسخ الرابط ومشاركته مع أي أحد بنفس نتائج البحث
            window.history.pushState({ path: fetchUrl }, '', fetchUrl);

            // إرسال طلب AJAX للسيرفر للحصول على جدول المنتجات المفلترة فقط
            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                // استبدال المحتوى القديم بالمحتوى الجديد المفلتر
                productsWrapper.innerHTML = html;
                productsWrapper.style.opacity = '1';
                
                // إعادة تشغيل تأثيرات الظهور (Reveal Animations) إذا كانت مدعومة في القالب العام
                if (typeof checkReveal === 'function') {
                    checkReveal();
                }
            })
            .catch(err => {
                console.error('Error fetching products:', err);
                productsWrapper.style.opacity = '1';
            });
        }

        // 1. فلترة وتحديث فوري عند تغيير التصنيف
        categorySelect.addEventListener('change', function() {
            fetchProducts();
        });

        // 2. تحديث عند الكتابة في مربع البحث مع تأخير (Debounce) لمنع إرسال طلبات مكثفة للسيرفر
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            // انتظر 300 مللي ثانية بعد توقف المستخدم عن الكتابة قبل إرسال الطلب
            debounceTimer = setTimeout(fetchProducts, 300);
        });

        // 3. منع المتصفح من إعادة تحميل الصفحة عند الضغط على Enter في مربع البحث
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchProducts();
        });
    });
</script>
@endsection
