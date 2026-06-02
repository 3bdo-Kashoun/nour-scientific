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
                        <!-- === سلة المشتريات (تمت الإضافة) === -->
                        <div class="cart-section">
                            <div class="cart-icon" id="cartToggle">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count" id="cartCount">0</span>
                            </div>
                            <!-- القائمة المنسدلة للسلة -->
                            <div class="cart-dropdown" id="cartDropdown">
                                <div class="cart-empty-msg">السلة فارغة حالياً</div>
                                <div class="cart-items-container" id="cartItemsContainer">
                                    <!-- سيتم إضافة المنتجات هنا بواسطة JS -->
                                </div>
                                <div class="cart-footer">
                                    <a href="{{ url('/cart') }}" class="btn-view-cart">عرض السلة وإتمام الشراء</a>
                                </div>
                            </div>
                        </div>
                        <!-- === نهاية سلة المشتريات === -->
                    @endguest
                    <div class="auth-section">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-login">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>تسجيل الدخول</span>
                            </a>
                        @else
                            <div class="user-menu">
                                <button class="user-name" id="userMenuToggle">
                                    <i class="fas fa-user-circle"></i> {{ Session('name') }}
                                </button>
                                <div class="dropdown-menu" id="userDropdown">
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">تسجيل
                                        الخروج</a>
                                    <form id="logout-form" action="{{ route('filament.admin.auth.logout') }}"
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

</body>


</html>
