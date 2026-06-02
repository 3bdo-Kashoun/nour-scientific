@extends('layouts.layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('pages/profile.css') }}">
@endpush

@section('content')
<div class="container" style="margin-top: 30px; margin-bottom: 50px;">
    <!-- رأس الصفحة -->
    <div class="profile-header">
        <div class="profile-avatar-wrapper">
            <i class="fa-solid fa-circle-user"></i>
        </div>
        <h1>حسابي</h1>
        <p>إدارة معلوماتك الشخصية وطلبياتك السابقة</p>
    </div>

    <!-- أزرار التبويبات -->
    <div class="profile-tabs">
        <button class="tab-btn active" onclick="switchTab('personal-tab', this)">
            <i class="fa-solid fa-user-gear"></i> البيانات الشخصية
        </button>
        <button class="tab-btn" onclick="switchTab('orders-tab', this)">
            <i class="fa-solid fa-box-open"></i> طلباتي
        </button>
    </div>

    <!-- 1. لوحة البيانات الشخصية -->
    <div id="personal-tab" class="tab-panel active">
        <div class="profile-grid">
            <!-- كارت المعلومات الشخصية -->
            <div class="profile-card">
                <h2 class="card-title">
                    <i class="fa-solid fa-circle-info"></i> المعلومات الشخصية
                </h2>
                
                @if(session('success_info'))
                    <script>
                        Swal.fire({
                            title: 'تم التحديث! 🎉',
                            text: "{{ session('success_info') }}",
                            icon: 'success',
                            confirmButtonText: 'موافق',
                            confirmButtonColor: '#008444'
                        });
                    </script>
                @endif

                <form action="{{ route('profile.update-info') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name"><i class="fa-solid fa-user"></i> الاسم الكامل</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fa-solid fa-envelope"></i> البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-profile-submit">
                        <i class="fa-solid fa-floppy-disk"></i> حفظ التعديلات
                    </button>
                </form>
            </div>

            <!-- كارت تغيير كلمة المرور -->
            <div class="profile-card">
                <h2 class="card-title">
                    <i class="fa-solid fa-key"></i> تغيير كلمة المرور
                </h2>

                @if(session('success_password'))
                    <script>
                        Swal.fire({
                            title: 'تم التغيير! 🔑',
                            text: "{{ session('success_password') }}",
                            icon: 'success',
                            confirmButtonText: 'موافق',
                            confirmButtonColor: '#008444'
                        });
                    </script>
                @endif

                <form action="{{ route('profile.update-password') }}" method="POST" id="password-form">
                    @csrf
                    
                    <div class="form-group">
                        <label for="current_password"><i class="fa-solid fa-lock"></i> كلمة المرور الحالية</label>
                        <input type="password" name="current_password" id="current_password" required>
                        @error('current_password')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password"><i class="fa-solid fa-lock-open"></i> كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" id="new_password" required>
                        @error('new_password')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation"><i class="fa-solid fa-shield-halved"></i> تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>

                    <!-- مقياس قوة كلمة المرور -->
                    <div class="strength-container">
                        <div class="strength-bar-wrapper">
                            <div class="strength-bar" id="strength-bar"></div>
                        </div>
                        <div class="strength-text" id="strength-text">الرجاء إدخال كلمة مرور جديدة.</div>
                    </div>

                    <div class="password-tip">
                        <i class="fa-solid fa-circle-question"></i>
                        <span>نصيحة: استخدم كلمة مرور قوية تحتوي على حروف إنجليزية وأرقام ورموز.</span>
                    </div>

                    <button type="submit" class="btn-profile-submit" id="btn-update-password" disabled>
                        <i class="fa-solid fa-key"></i> تغيير كلمة المرور
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. لوحة طلباتي السابقة -->
    <div id="orders-tab" class="tab-panel">
        <div class="profile-card">
            <h2 class="card-title">
                <i class="fa-solid fa-clock-rotate-left"></i> طلباتي السابقة
            </h2>

            @if($orders->isEmpty())
                <div class="no-orders-box">
                    <i class="fa-solid fa-box-open"></i>
                    <p>ليس لديك أي طلبات سابقة حتى الآن.</p>
                </div>
            @else
                <div class="orders-list">
                    @foreach($orders as $order)
                        <div class="order-item-card">
                            <div class="order-meta-info">
                                <div class="order-code-row">
                                    <span class="order-code">#ORD-{{ sprintf('%03d', $order->id) }}</span>
                                    
                                    {{-- ترجمة وعرض حالات الطلبيات --}}
                                    @if($order->status === 'pending')
                                        <span class="status-badge pending">
                                            <i class="fa-solid fa-spinner fa-spin"></i> قيد التنفيذ
                                        </span>
                                    @elseif($order->status === 'in_delivery')
                                        <span class="status-badge in_delivery">
                                            <i class="fa-solid fa-truck"></i> قيد التوصيل
                                        </span>
                                    @elseif($order->status === 'sold')
                                        <span class="status-badge sold">
                                            <i class="fa-solid fa-circle-check"></i> تم التسليم
                                        </span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="status-badge cancelled">
                                            <i class="fa-solid fa-circle-xmark"></i> ملغية
                                        </span>
                                    @endif
                                </div>
                                <div class="order-date-row">
                                    <span><i class="fa-regular fa-calendar"></i> {{ $order->created_at->format('Y/m/d') }}</span>
                                    <span><i class="fa-solid fa-boxes-stacked"></i> {{ $order->products->sum('pivot.quantity') }} منتجات</span>
                                </div>
                            </div>
                            <div class="order-actions">
                                <span class="order-price">{{ number_format($order->total_price, 2) }} د.ل</span>
                                <button type="button" class="btn-details" onclick="openOrderDetails({{ $order->id }})">
                                    <i class="fa-solid fa-magnifying-glass"></i> التفاصيل
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<!-- نافذة تفاصيل الطلب المنبثقة (Order Details AJAX Modal) -->
<div id="orderDetailsModal" class="details-modal-overlay">
    <div class="details-modal-card">
        <div class="details-modal-header">
            <h3 id="modal-order-title"><i class="fa-solid fa-file-invoice"></i> تفاصيل الطلب</h3>
            <button onclick="closeOrderDetails()" class="details-modal-close">&times;</button>
        </div>
        <div class="details-modal-body">
            <!-- ملخص معلومات الطلب الرئيسي -->
            <div class="details-summary-grid">
                <div class="details-summary-item">
                    <span>تاريخ الطلب:</span>
                    <strong id="modal-order-date">-</strong>
                </div>
                <div class="details-summary-item">
                    <span>حالة الطلب:</span>
                    <strong id="modal-order-status">-</strong>
                </div>
                <div class="details-summary-item">
                    <span>رقم الهاتف:</span>
                    <strong id="modal-order-phone" dir="ltr">-</strong>
                </div>
                <div class="details-summary-item">
                    <span>نوع التوصيل:</span>
                    <strong id="modal-order-delivery">-</strong>
                </div>
            </div>

            <!-- قائمة المنتجات للطلب -->
            <div class="details-products-title">
                <i class="fa-solid fa-flask"></i> المنتجات المطلوبة
            </div>
            
            <div class="details-products-list" id="modal-products-container">
                <!-- سيتم ملؤها عبر AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- الأكواد التفاعلية التابعة للصفحة (Tab Switching + Password strength + AJAX) -->
<script>
    // 1. التنقل بين التبويبات
    function switchTab(tabId, btn) {
        // إخفاء كل اللوحات وإلغاء تفعيل كل الأزرار
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        // تفعيل التبويب المختار
        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

    // 2. التحقق اللحظي وتلوين مؤشر قوة كلمة المرور
    document.addEventListener('DOMContentLoaded', function() {
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('new_password_confirmation');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');
        const submitPasswordBtn = document.getElementById('btn-update-password');

        function validatePassword() {
            const password = newPasswordInput.value;
            const confirmVal = confirmPasswordInput.value;

            if (!password) {
                strengthBar.style.width = '0%';
                strengthText.innerText = 'الرجاء إدخال كلمة مرور جديدة.';
                strengthText.style.color = '#64748b';
                submitPasswordBtn.disabled = true;
                return;
            }

            const hasLetters = /[a-zA-Z]/.test(password);
            const hasNumbers = /[0-9]/.test(password);
            const hasSpecial = /[^a-zA-Z0-9\s]/.test(password);
            const length = password.length;

            // التحقق المبدئي: يجب توافر حروف إنجليزية وأرقام معاً
            if (!hasLetters || !hasNumbers) {
                strengthBar.style.width = '15%';
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.innerText = 'ضعيفة جداً (يجب استخدام حروف إنجليزية وأرقام معاً).';
                strengthText.style.color = '#ef4444';
                submitPasswordBtn.disabled = true;
                return;
            }

            // التحقق من الطول الأدنى 8 رموز
            if (length < 8) {
                strengthBar.style.width = '25%';
                strengthBar.style.backgroundColor = '#ef4444';
                strengthText.innerText = 'ضعيفة (يجب ألا تقل عن 8 رموز).';
                strengthText.style.color = '#ef4444';
                submitPasswordBtn.disabled = true;
                return;
            }

            // حساب درجة القوة بناءاً على المعايير
            let score = 2; // نقطتان أساسيتان: حروف+أرقام ≥ 8 رموز
            if (length >= 10) score++;
            if (length >= 12) score++;
            if (hasSpecial) score++;

            // تلوين وتحديث شريط القوة
            if (score <= 2) {
                strengthBar.style.width = '50%';
                strengthBar.style.backgroundColor = '#f97316'; // برتقالي
                strengthText.innerText = 'متوسطة (يمكن تحسينها بإضافة رموز أو زيادة الطول).';
                strengthText.style.color = '#f97316';
                submitPasswordBtn.disabled = false;
            } else if (score === 3) {
                strengthBar.style.width = '75%';
                strengthBar.style.backgroundColor = '#3b82f6'; // أزرق
                strengthText.innerText = 'قوية.';
                strengthText.style.color = '#3b82f6';
                submitPasswordBtn.disabled = false;
            } else if (score >= 4) {
                strengthBar.style.width = '100%';
                strengthBar.style.backgroundColor = '#22c55e'; // أخضر
                strengthText.innerText = 'قوية جداً! 👍';
                strengthText.style.color = '#22c55e';
                submitPasswordBtn.disabled = false;
            }

            // التحقق من تطابق كلمتي المرور
            if (confirmVal && password !== confirmVal) {
                submitPasswordBtn.disabled = true;
                strengthText.innerText += ' (تنبيه: تأكيد كلمة المرور غير متطابق)';
                strengthText.style.color = '#ef4444';
            }
        }

        newPasswordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validatePassword);
    });

    // 3. جلب تفاصيل الطلب بنظام AJAX وعرض المودال
    function openOrderDetails(orderId) {
        const modal = document.getElementById('orderDetailsModal');
        const container = document.getElementById('modal-products-container');
        
        // مسح محتويات المودال السابقة وإظهار مؤشر التحميل
        container.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 2rem; color: #008444;"></i> جاري تحميل التفاصيل...</div>';
        
        modal.classList.add('show');

        const fetchUrl = `{{ url('/profile/orders') }}/${orderId}`;

        fetch(fetchUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error('Failed to load order details');
            }

            // ملء بيانات الطلب الأساسية في الـ Modal
            document.getElementById('modal-order-title').innerHTML = `<i class="fa-solid fa-file-invoice"></i> تفاصيل الطلب #ORD-${String(data.order.id).padStart(3, '0')}`;
            document.getElementById('modal-order-date').innerText = data.order.created_at;
            document.getElementById('modal-order-phone').innerText = data.order.phone;
            
            // شارات الحالة المترجمة
            let statusText = '';
            if (data.order.status === 'pending') {
                statusText = 'قيد التنفيذ';
            } else if (data.order.status === 'in_delivery') {
                statusText = 'قيد التوصيل';
            } else if (data.order.status === 'sold') {
                statusText = 'تم التسليم';
            } else if (data.order.status === 'cancelled') {
                statusText = 'ملغية';
            }
            document.getElementById('modal-order-status').innerText = statusText;

            // حساب التوصيل
            let deliveryText = '';
            if (data.order.delivery_requested) {
                deliveryText = `توصيل منزلي (+${data.order.delivery_price} د.ل)`;
            } else {
                deliveryText = 'استلام من المقر الرئيسي';
            }
            document.getElementById('modal-order-delivery').innerText = deliveryText;

            // ملء شبكة المنتجات
            let productsHtml = '';
            data.products.forEach(p => {
                const imgSource = p.image ? p.image : '{{ asset("images/default-prod.jpg") }}';
                productsHtml += `
                    <div class="details-product-row">
                        <img src="${imgSource}" alt="${p.name}" class="details-product-image">
                        <div class="details-product-info">
                            <div class="details-product-name">${p.name}</div>
                            <div class="details-product-qty">الكمية: ${p.quantity} × ${p.price} د.ل</div>
                        </div>
                        <div class="details-product-price">${p.total} د.ل</div>
                    </div>
                `;
            });

            // إجمالي السعر أسفل القائمة
            productsHtml += `
                <div style="margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0; display: flex; justify-content: space-between; font-weight: bold; font-size: 1.1rem; color: var(--dark-blue);">
                    <span>المجموع الإجمالي:</span>
                    <span style="color: #008444;">${data.order.total_price} د.ل</span>
                </div>
            `;

            container.innerHTML = productsHtml;
        })
        .catch(err => {
            console.error('Error fetching order details:', err);
            container.innerHTML = '<div style="color: #ef4444; text-align: center; padding: 20px;"><i class="fa-solid fa-circle-exclamation"></i> حدث خطأ أثناء تحميل البيانات. يرجى المحاولة مرة أخرى.</div>';
        });
    }

    function closeOrderDetails() {
        const modal = document.getElementById('orderDetailsModal');
        modal.classList.remove('show');
    }

    // إغلاق مودال الطلب عند الضغط بالخارج
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('orderDetailsModal');
        if (e.target === modal) {
            closeOrderDetails();
        }
    });
</script>
@endsection
