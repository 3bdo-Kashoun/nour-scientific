<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نور العلمية للكيماويات @yield('title')</title>

    <link rel="icon" href="images/nour.jpg">
    <link rel="stylesheet" href="pages/style.css">

    <!-- مكتبة Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- مكتبة SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>

<body>
    <!-- بداية الصفحة -->
    <header id="header">
        <div class="container">
            <!-- nav bar -->
            <nav>
                <div class="logo">
                    <i class="fa-solid fa-flask"></i>
                    نور العلمية
                </div>
                <ul class="nav-links" id="navLinks">
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">الرئيسية</a></li>
                    <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">من نحن</a>
                    </li>
                    <li><a href="{{ url('/products') }}" class="{{ request()->is('products') ? 'active' : '' }}">منتجاتنا</a></li>
                    <li><a href="{{ url('/news') }}" class="{{ request()->is('news') ? 'active' : '' }}">الأخبار
                            والمعارض</a></li>
                    <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">تواصل
                            معنا</a></li>
                </ul>

                <div class="cart-auth-card">
                    @guest
                    @else
                        <!-- === سلة المشتريات === -->
                        <div class="cart-section">
                            <a href="{{ route('cart.index') }}" class="cart-icon" id="cartToggle" style="text-decoration: none; color: inherit;" title="سلة المشتريات">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.116 60.116 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                </svg>
                                <span class="cart-count" id="cartCount">{{ count(session('cart', [])) }}</span>
                            </a>
                        </div>
                        <!-- === نهاية سلة المشتريات === -->
                    @endguest
                    <div class="auth-section">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-login" title="تسجيل الدخول">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>تسجيل الدخول</span>
                            </a>
                        @else
                            <div class="user-menu">
                                <button class="user-name" id="userMenuToggle" title="حسابي">
                                    <i class="fa-solid fa-circle-user"></i> {{ session('name', auth()->user()->name ?? '') }}
                                </button>
                                <div class="dropdown-menu" id="userDropdown">
                                    <a href="{{ route('profile.index') }}" title="المعلومات الشخصية">
                                        <i class="fa-solid fa-id-card"></i> المعلومات الشخصية
                                    </a>
                                    <a href="#" onclick="confirmLogout(event)" title="تسجيل الخروج">
                                        <i class="fa-solid fa-right-to-bracket"></i> تسجيل الخروج
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
                <div class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>
    @yield('content')

    <!-- footer -->
    <footer>
        <!-- عنوان footer -->
        <div class="container">
            <div class="footer-grid reveal">
                <div class="footer-col">
                    <div class="logo" style="color: #fff; margin-bottom: 20px;">
                        <i class="fa-solid fa-flask"></i> نور العلمية
                    </div>
                    <p>شريككم الموثوق لتوريد وتصنيع المواد الكيميائية بأعلى معايير الجودة العالمية.</p>
                </div>
                <!-- الراوبط -->
                <div class="footer-col">
                    <h4>روابط سريعة</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li><a href="{{ url('/about') }}">من نحن</a></li>
                        <li><a href="{{ url('/products') }}">المنتجات</a></li>
                        <li><a href="{{ url('/news') }}">الأخبار</a></li>
                    </ul>
                </div>
                <!-- روابط المنتجات -->
                <div class="footer-col">
                    <h4>منتجاتنا</h4>
                    <ul>
                        <li><a href="pages/proudct.html#CARLO_ERBA">CARLO ERBA</a></li>
                        <li><a href="pages/proudct.html#XS">XS BASIC</a></li>
                        <li><a href="pages/proudct.html#Glentham">Glentham | LIFE SCIENCES</a></li>

                    </ul>
                </div>
                <!-- التواصل -->
                <div class="footer-col">
                    <h4>تواصل معنا</h4>
                    <ul class="contact-info">
                        <li><i class="fas fa-phone"></i>
                            <a href="tel:+218926468875">5788 646 92 218+</a>
                        </li>
                        <li><i class="fas fa-envelope"></i> <a
                                href="mailto:nuralemiacompany@gmail.com">nuralemiacompany@gmail.com</a></li>
                        <li><i class="fas fa-map-marker-alt"></i>
                            <a href="{{ url('/contact') }}#map">ليبيا ، طرابلس شارع شوقي</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>جميع الحقوق محفوظة © 2025 شركة نور العلمية للكيماويات</p>
            </div>
        </div>
    </footer>
    <!-- صفحة java script -->
    <script src="pages/script.js"></script>

    <!-- كود سلة المشتريات وإتمام الطلب -->
    <script>
        function addToCart(event, productId) {
            event.preventDefault();
            
            @guest
                Swal.fire({
                    title: 'تسجيل الدخول مطلوب',
                    text: 'يرجى تسجيل الدخول أولاً لتتمكن من إضافة المنتجات للسلة.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'تسجيل الدخول',
                    cancelButtonText: 'إلغاء',
                    confirmButtonColor: '#008444',
                    cancelButtonColor: '#64748b'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
                return;
            @endguest

            // تعطيل الزر مؤقتاً لتجنب النقرات المتعددة
            const btn = event.currentTarget || event.target;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'جاري الإضافة...';

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;

                if (data.error) {
                    Swal.fire({
                        title: 'تنبيه!',
                        text: data.error,
                        icon: 'warning',
                        confirmButtonText: 'موافق',
                        confirmButtonColor: '#008444'
                    });
                } else if (data.success) {
                    // تحديث العداد
                    const badge = document.getElementById('cartCount');
                    if (badge) {
                        badge.innerText = data.cart_count;
                    }

                    // تنبيه لطيف بالنجاح
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                }
            })
            .catch(err => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                console.error(err);
                Swal.fire({
                    title: 'خطأ!',
                    text: 'حدث خطأ غير متوقع أثناء إضافة المنتج.',
                    icon: 'error',
                    confirmButtonText: 'موافق',
                    confirmButtonColor: '#ef4444'
                });
            });
        }

        // تنبيه نجاح الطلبية عند إعادة التوجيه
        @if(session('success_order'))
            Swal.fire({
                title: 'تم إرسال الطلب بنجاح! 🎉',
                text: "{{ session('success_order') }}",
                icon: 'success',
                confirmButtonText: 'موافق',
                confirmButtonColor: '#008444'
            });
        @endif

        // تنبيه نجاح إنشاء الحساب الجديد
        @if(session('success_register'))
            Swal.fire({
                title: 'مرحباً بك! 🎉',
                text: "{{ session('success_register') }}",
                icon: 'success',
                confirmButtonText: 'ابدأ التصفح',
                confirmButtonColor: '#008444'
            });
        @endif

        // دالة تأكيد تسجيل الخروج
        function confirmLogout(e) {
            if (e) e.preventDefault();
            
            // إغلاق الدروب داون
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) dropdown.classList.remove('show');

            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'هل ترغب حقاً في تسجيل الخروج من حسابك؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'نعم، سجل الخروج',
                cancelButtonText: 'إلغاء',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>
