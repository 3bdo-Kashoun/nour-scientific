{{-- حاوية لعرض المنتجات --}}
<div id="products-container" class="products-grid">
    @if($products->count() > 0)
        @foreach($products as $item)
            <div class="reveal active"> {{-- كلاس active لضمان الظهور الفوري --}}
                <x-product-card
                    :title="$item->name"
                    {{-- جلب اسم الشركة واسم التصنيف عبر العلاقات --}}
                    :company="$item->company?->name ?? 'غير محدد'"
                    :category="$item->category?->name ?? 'عام'"
                    {{-- التعديل ليتوافق مع اسم العمود في الصورة: code --}}
                    :product_code="$item->code"
                    {{-- التعديل ليتوافق مع اسم العمود في الصورة: dos_value --}}
                    :dose="$item->dos_value"
                    :image="$item->image"
                    :price="$item->price"
                />
            </div>
        @endforeach
    @else
        <div class="no-products">
            <p>عذراً، لا توجد منتجات تطابق بحثك.</p>
        </div>
    @endif
</div>
