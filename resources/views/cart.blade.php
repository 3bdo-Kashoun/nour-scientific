@extends('layouts.layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('pages/cart.css') }}">
@endpush

@section('content')
<div class="container" style="margin-top: 40px; margin-bottom: 60px;">
    @if(count($cartItems) > 0)
        <!-- عنوان الصفحة -->
        <div class="cart-header">
            <i class="fa-solid fa-cart-shopping cart-header-icon"></i>
            <h1>عربة التسوق</h1>
            <p>راجع طلبك وأكمل عملية الشراء</p>
        </div>

        <div class="cart-grid">
            <!-- العمود الأيمن: قائمة المنتجات (أصبح الأول في الترتيب ليعرض على اليمين) -->
            <div class="cart-items-wrapper">
                @foreach($cartItems as $item)
                    @php
                        $product = $item['product'];
                    @endphp
                    <div class="cart-item-card" id="cart-item-{{ $product->id }}" data-price="{{ $product->price }}">
                        <!-- صورة المنتج -->
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="cart-item-img">
                        @else
                            <div class="cart-item-img" style="background: #e2e8f0; display: flex; align-items: center; justify-content: center; border-radius: 12px;">
                                <i class="fa-solid fa-image text-gray-400 text-2xl"></i>
                            </div>
                        @endif

                        <!-- تفاصيل المنتج -->
                        <div class="cart-item-info">
                            <div class="cart-item-header">
                                <div>
                                    <h3 class="cart-item-title">{{ $product->name }}</h3>
                                    <span class="cart-item-code">الكود: {{ $product->code }}</span>
                                </div>
                            </div>
                            
                            <!-- الشارة والجرعة -->
                            <div class="cart-item-meta">
                                <span class="meta-badge">الشركة: {{ $product->company?->name ?? 'غير محدد' }}</span>
                                @if($product->dos_value)
                                    <span class="meta-badge dose">الجرعة: {{ $product->dos_value }} {{ $product->dosage?->unit_name ?? '' }}</span>
                                @endif
                            </div>

                            <div class="cart-item-bottom">
                                <!-- السعر الإجمالي وسعر القطعة -->
                                <div class="cart-item-price-block">
                                    <span class="cart-item-total-price" id="item-total-{{ $product->id }}">{{ number_format($item['total'], 2, '.', '') }} د.ل</span>
                                    <span class="cart-item-unit-price">{{ number_format($product->price, 2) }} د.ل للقطعة</span>
                                </div>

                                <!-- التحكم بالكمية -->
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="updateQty({{ $product->id }}, -1)">-</button>
                                    <span class="qty-value" id="qty-val-{{ $product->id }}">{{ $item['quantity'] }}</span>
                                    <button type="button" class="qty-btn" onclick="updateQty({{ $product->id }}, 1)">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- زر حذف العنصر -->
                        <button type="button" class="btn-remove-item" onclick="removeItem({{ $product->id }})" title="حذف المنتج">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- العمود الأيسر: إكمال الطلب (أصبح الثاني في الترتيب ليعرض على اليسار) -->
            <div class="checkout-wrapper">
                <div class="checkout-card">
                    <h2>إكمال الطلب</h2>
                    
                    <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                        @csrf
                        
                        <!-- رقم الهاتف -->
                        <div class="form-group">
                            <label for="phone"><i class="fa-solid fa-phone"></i> رقم الهاتف</label>
                            <input type="text" name="phone" id="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="+218 91 234 5678" class="form-input" dir="ltr" style="text-align: left;" required>
                        </div>

                        <!-- خيار طلب التوصيل -->
                        <div class="delivery-toggle-container">
                            <span class="delivery-toggle-label"><i class="fa-solid fa-truck"></i> طلب التوصيل؟</span>
                            <label class="switch">
                                <input type="checkbox" name="delivery_requested" value="1" id="delivery_requested" onchange="toggleDelivery(this)">
                                <span class="slider"></span>
                            </label>
                        </div>

                        <!-- عنوان التوصيل (يظهر بحركة انسيابية عند تفعيل التوقل) -->
                        <div class="delivery-address-section" id="delivery-address-wrapper">
                            <div class="form-group">
                                <label for="delivery_address"><i class="fa-solid fa-location-dot"></i> عنوان التوصيل بالتفصيل</label>
                                <textarea name="delivery_address" id="delivery_address" placeholder="المدينة، الشارع، رقم المبنى..." class="form-input" style="height: 100px; resize: none;"></textarea>
                            </div>
                        </div>

                        <!-- ملخص الفاتورة -->
                        <div class="bill-summary">
                            <div class="summary-row">
                                <span>المجموع الفرعي:</span>
                                <span><span id="bill-subtotal">{{ number_format($subtotal, 2, '.', '') }}</span> د.ل</span>
                            </div>
                            <div class="summary-row">
                                <span>رسوم التوصيل:</span>
                                <span><span id="bill-delivery">0.00</span> د.ل</span>
                            </div>
                            <div class="summary-row total">
                                <span>الإجمالي الكلي:</span>
                                <span><span class="total-price-large" id="bill-total">{{ number_format($subtotal, 2, '.', '') }}</span> د.ل</span>
                            </div>
                        </div>

                        <!-- زر إرسال الطلب -->
                        <button type="submit" class="btn-checkout">
                            <i class="fa-solid fa-paper-plane"></i> إكمال الطلب
                        </button>
                    </form>
                    
                    <a href="{{ route('products') }}" class="btn-continue-shopping">متابعة التسوق</a>
                </div>

                <!-- بطاقات الشحن والرسوم التوضيحية -->
                <div class="info-card green">
                    <span class="info-card-title">📦 التوصيل خلال 1-2 أيام</span>
                    <span>توصيل سريع لجميع مناطق ليبيا</span>
                </div>

                <div class="info-card blue">
                    <span class="info-card-title">💰 رسوم التوصيل</span>
                    <span>في حال طلب التوصيل، ستضاف رسوم من 10 إلى 30 دينار ليبي حسب منطقتك.</span>
                </div>
            </div>
        </div>
    @else
        <!-- السلة فارغة -->
        <div class="empty-cart-container">
            <i class="fa-solid fa-cart-shopping empty-cart-icon"></i>
            <h2>سلة المشتريات فارغة</h2>
            <p>يبدو أنك لم تقم بإضافة أي منتجات للسلة بعد.</p>
            <a href="{{ route('products') }}" class="btn-checkout" style="max-width: 250px; margin: 20px auto 0 auto; text-decoration: none;">تصفح المنتجات الآن</a>
        </div>
    @endif
</div>

<!-- كود JavaScript التفاعلي لإدارة العربة -->
<script>
    // تفعيل / إلغاء تفعيل قسم التوصيل
    function toggleDelivery(checkbox) {
        const wrapper = document.getElementById('delivery-address-wrapper');
        const addressInput = document.getElementById('delivery_address');
        const deliveryFeeSpan = document.getElementById('bill-delivery');
        const totalSpan = document.getElementById('bill-total');
        
        let subtotal = parseFloat(document.getElementById('bill-subtotal').innerText);
        
        if (checkbox.checked) {
            wrapper.classList.add('show');
            addressInput.setAttribute('required', 'required');
            deliveryFeeSpan.innerText = '15.00';
            totalSpan.innerText = (subtotal + 15.00).toFixed(2);
        } else {
            wrapper.classList.remove('show');
            addressInput.removeAttribute('required');
            deliveryFeeSpan.innerText = '0.00';
            totalSpan.innerText = subtotal.toFixed(2);
        }
    }

    // تعديل كمية المنتج عبر التحديث التفاؤلي الفوري (Optimistic Update) لسرعة استجابة فائقة
    function updateQty(productId, change) {
        const qtyValSpan = document.getElementById(`qty-val-${productId}`);
        const currentQty = parseInt(qtyValSpan.innerText);
        const newQty = currentQty + change;
        
        if (newQty <= 0) {
            removeItem(productId);
            return;
        }

        // 1. التحديث التفاؤلي الفوري (Optimistic Update) في المتصفح
        qtyValSpan.innerText = newQty;
        
        const itemCard = document.getElementById(`cart-item-${productId}`);
        const unitPrice = parseFloat(itemCard.getAttribute('data-price'));
        const newItemTotal = unitPrice * newQty;
        
        document.getElementById(`item-total-${productId}`).innerText = newItemTotal.toFixed(2) + ' د.ل';
        
        // إعادة حساب الإجمالي في الصفحة محلياً فوراً
        recalculateTotals();

        // 2. إرسال الطلب في الخلفية للمزامنة مع السيرفر وفحص المخزون الفعلي
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: newQty
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // في حال فشل السيرفر (مثلاً الكمية غير متاحة بالمخزن)، نتراجع فوراً
                Swal.fire({
                    title: 'تنبيه!',
                    text: data.error,
                    icon: 'warning',
                    confirmButtonText: 'موافق',
                    confirmButtonColor: '#008444'
                });
                
                qtyValSpan.innerText = currentQty;
                document.getElementById(`item-total-${productId}`).innerText = (unitPrice * currentQty).toFixed(2) + ' د.ل';
                recalculateTotals();
            } else if (data.success) {
                // تحديث القيم المؤكدة من السيرفر
                document.getElementById('bill-subtotal').innerText = data.subtotal;
                const isDelivery = document.getElementById('delivery_requested').checked;
                const subtotalFloat = parseFloat(data.subtotal.replace(/,/g, ''));
                const total = isDelivery ? (subtotalFloat + 15.00) : subtotalFloat;
                document.getElementById('bill-total').innerText = total.toFixed(2);
            }
        })
        .catch(err => {
            console.error(err);
            // تراجع عن التحديث في حال انقطاع الشبكة
            qtyValSpan.innerText = currentQty;
            document.getElementById(`item-total-${productId}`).innerText = (unitPrice * currentQty).toFixed(2) + ' د.ل';
            recalculateTotals();
            
            Swal.fire({
                title: 'خطأ!',
                text: 'حدث خطأ في الاتصال. تم التراجع عن تعديل الكمية.',
                icon: 'error',
                confirmButtonText: 'موافق',
                confirmButtonColor: '#ef4444'
            });
        });
    }

    // دالة إعادة الحساب محلياً فورياً
    function recalculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item-card').forEach(card => {
            const price = parseFloat(card.getAttribute('data-price'));
            const qty = parseInt(card.querySelector('.qty-value').innerText);
            subtotal += price * qty;
        });

        document.getElementById('bill-subtotal').innerText = subtotal.toFixed(2);
        
        const isDelivery = document.getElementById('delivery_requested').checked;
        const deliveryFee = isDelivery ? 15.00 : 0.00;
        document.getElementById('bill-total').innerText = (subtotal + deliveryFee).toFixed(2);
    }

    // حذف منتج من العربة
    function removeItem(productId) {
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: 'هل تريد حذف هذا المنتج من سلة المشتريات؟',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                // إخفاء فوري للعنصر
                const itemCard = document.getElementById(`cart-item-${productId}`);
                const unitPrice = parseFloat(itemCard.getAttribute('data-price'));
                const qtyValSpan = document.getElementById(`qty-val-${productId}`);
                const currentQty = parseInt(qtyValSpan.innerText);
                
                itemCard.style.opacity = '0';
                itemCard.style.transform = 'scale(0.9)';
                
                fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => {
                            itemCard.remove();
                            
                            document.getElementById('bill-subtotal').innerText = data.subtotal;
                            const isDelivery = document.getElementById('delivery_requested').checked;
                            const subtotalFloat = parseFloat(data.subtotal.replace(/,/g, ''));
                            const total = isDelivery ? (subtotalFloat + 15.00) : subtotalFloat;
                            document.getElementById('bill-total').innerText = total.toFixed(2);
                            
                            const headerBadge = document.getElementById('cartCount');
                            if (headerBadge) {
                                headerBadge.innerText = data.cart_count;
                            }

                            if (data.cart_count === 0) {
                                window.location.reload();
                            }
                        }, 300);
                        
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'تم حذف المنتج من السلة.'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    // التراجع عن الإخفاء في حال الفشل
                    itemCard.style.opacity = '1';
                    itemCard.style.transform = 'scale(1)';
                });
            }
        });
    }

    // تفعيل رسائل الخطأ من الـ Session بالصفحة
    @if(session('error_msg'))
        Swal.fire({
            title: 'خطأ في الطلب!',
            text: "{{ session('error_msg') }}",
            icon: 'error',
            confirmButtonText: 'موافق',
            confirmButtonColor: '#ef4444'
        });
    @endif
</script>
@endsection
