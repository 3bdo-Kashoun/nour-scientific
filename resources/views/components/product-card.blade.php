@props(['image', 'title', 'company', 'product_code', 'dose', 'category', 'price'])

{{-- دمج الكلاسات الأساسية مع أي كلاسات تأتي من الخارج --}}
<div {{ $attributes->merge(['class' => 'product-card reveal']) }}>
    <div class="product-image">
        {{-- استخدام asset لضمان عمل الرابط دائماً --}}
        <img src="{{asset('storage/' . $image) }}" alt="{{ $title }}">
    </div>

    <div class="product-info">
        <h3>{{ $title }}</h3>


        <div class="product-details">
            <span class="category-badge">{{ $category }}</span>
            <p><strong>شركة:</strong> {{ $company }}</p>
            <p><strong>الكود:</strong> {{ $product_code}}</p>
            <p><strong>الجرعة/الحجم:</strong> {{ $dose }}</p>


            <button class="btn-buy">إضافة للسلة</button>
            <p><strong class="price-tag">السعر:</strong> {{ $price }} د.ل</p>
        {{-- وضع الـ Slot هنا لكي يظهر أي محتوى إضافي داخل الكارت --}}

        @if($slot->isNotEmpty())

                {{ $slot }}

        @endif
        </div>


    </div>
</div>
