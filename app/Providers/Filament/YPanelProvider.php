<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use App\Filament\Pages\Auth\CustomRegister;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;


class YPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
           
            ->colors([
                'primary' => '#028137',
                'secondary' => '#0f172a',
                'edit' => '#155dfc'
            ])
            ->brandName(fn() => new \Illuminate\Support\HtmlString('
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <div class="flex items-center gap-2">
                <i class="fa-solid  fa-users-gear text-primary-600" style="font-size: 1.5rem;"></i>

                <span class="font-bold text-xl tracking-tight">لوحة التحكم الإدارية </span>
            </div>
        '))
            ->brandLogoHeight('3rem')




            ->font('Tajawal', provider: \Filament\FontProviders\GoogleFontProvider::class)
           ->login(null)
           ->registration(null)
            ->authGuard('web')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
    'panels::sidebar.nav.start',
    fn(): string => Blade::render('
        {{-- أضفنا كلاس fi-custom-sidebar-header --}}
        <div class="fi-custom-sidebar-header flex items-center gap-3 px-6 py-4 mb-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-600 shadow-sm">
               <i class="fa-solid fa-gear text-white" style="font-size: 1.5rem;" ></i>
            </div>
            <span class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                لوحة الإدارة
            </span>
        </div>
    ')
)
->renderHook(
    'panels::styles.after',
    fn (): string => '
    <style>
        /* باستخدام CSS Hook: لما يكون السايد بار مصغر، نخفوا النص ونعدلوا المسافات */
        .fi-sidebar-nav .fi-custom-sidebar-header span {
            display: none;
        }
       .fi-sidebar-nav {
    /* الخلفية */
    background-color: #ffffff !important;

    /* الظل الخفيف (نفس shadow-sm) */
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;

    /* الإطار الرقيق (نفس الـ ring-1) */
    /* نستخدم border-inline-end لضمان أن الخط يظهر جهة اليسار في العربي واليمين في الإنجليزي */
    border-inline-end: 1px solid rgba(3, 7, 18, 0.05) !important;

    /* لو تبي تضيف انحناء بسيط للحواف زي التوب بار */
    border-radius: 0.5rem;

    /* مسافة داخلية بسيطة */
    margin: 0.5rem;
}

/* للتوافق مع الوضع الليلي (Dark Mode) */
.dark .fi-sidebar-nav {
    background-color: #111827 !important; /* رمادي غامق gray-900 */
    border-inline-end: 1px solid rgba(255, 255, 255, 0.1) !important;
}
    .dark .fi-topbar nav{
    background-color: #111827 !important; /* رمادي غامق gray-900 */
    border-inline-end: 1px solid rgba(255, 255, 255, 0.1) !important;
}
    .dark .fi-sidebar-header {
    background-color: #111827 !important; /* رمادي غامق gray-900 */
    border-inline-end: 1px solid rgba(255, 255, 255, 0.1) !important;
}

        .fi-sidebar-nav .fi-custom-sidebar-header {
            padding-left: 1rem;
            padding-right: 1rem;
            justify-content: center;
        }

        /* تحسين شكل الأيقونة لما نمرر الماوس (Hover) */
        .fi-custom-sidebar-header:hover .bg-primary-600 {
            background-color: #026d2e; /* تغميق اللون الأخضر شوية */
            transform: scale(1.05);
            transition: all 0.2s;
        }

        /* تخصيص زر تسجيل الدخول للشكل الأخضر الدائري والأيقونة المميزة */
        .fi-simple-page button[type="submit"] {
            background-color: #009639 !important;
            border-color: #009639 !important;
            border-radius: 9999px !important;
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
            box-shadow: 0 4px 12px rgba(0, 150, 57, 0.2) !important;
            transition: all 0.2s ease-in-out !important;
        }

        .fi-simple-page button[type="submit"]:hover {
            background-color: #008030 !important;
            border-color: #008030 !important;
            box-shadow: 0 6px 16px rgba(0, 150, 57, 0.35) !important;
            transform: translateY(-1px) !important;
        }

        .fi-simple-page button[type="submit"] .fi-btn-label {
            font-size: 1.05rem !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.5rem !important;
        }

        .fi-simple-page button[type="submit"] .fi-btn-label::after {
            content: " ➔]" !important;
            font-size: 1.15rem !important;
            font-weight: bold !important;
            display: inline-block !important;
            margin-right: 0.35rem !important;
        }

        /* زر عرض الموقع - متوافق بالكامل مع الوضعين المضيء والليلي */
        .fi-view-site-btn {
            position: relative;
            display: inline-flex !important;
            align-items: center !important;
            padding: 0.35rem 1rem !important;
            font-size: 0.85rem !important;
            font-weight: 700 !important;
            border-radius: 9999px !important;
            border: 2px solid #00a651 !important;
            background-color: #ffffff !important;
            color: #00a651 !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
            text-decoration: none !important;
        }

        .fi-view-site-btn:hover {
            background-color: #00a651 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(0, 166, 81, 0.25) !important;
        }

        .fi-view-site-btn:active {
            transform: scale(0.96) !important;
        }

        .fi-view-site-pulse {
            margin-left: 0.4rem;
            display: inline-block;
            height: 0.5rem;
            width: 0.5rem;
            border-radius: 9999px;
            background-color: #00a651;
            transition: background-color 0.2s;
        }

        .fi-view-site-btn:hover .fi-view-site-pulse {
            background-color: #ffffff !important;
        }

        /* الوضع الليلي (Dark Mode) لزر عرض الموقع */
        .dark .fi-view-site-btn {
            background-color: #1f2937 !important;
            color: #10b981 !important;
            border-color: #10b981 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
        }

        .dark .fi-view-site-btn:hover {
            background-color: #10b981 !important;
            color: #111827 !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3) !important;
        }

        .dark .fi-view-site-pulse {
            background-color: #10b981 !important;
        }

        .dark .fi-view-site-btn:hover .fi-view-site-pulse {
            background-color: #111827 !important;
        }

        /* تخصيص وتكبير عناوين الأقسام وتنسيقها بشكل عصري */
        .fi-section-header-heading {
            font-family: "Tajawal", "Cairo", sans-serif !important;
            font-size: 1.15rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
        }

        .dark .fi-section-header-heading {
            color: #ffffff !important;
        }

        /* تحويل حقول الـ Infolist إلى كروت صغيرة مودرن */
        .fi-in-entry-wrp {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            transition: all 0.2s ease-in-out !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02) !important;
        }

        .dark .fi-in-entry-wrp {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2) !important;
        }

        .fi-in-entry-wrp:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04) !important;
            border-color: #cbd5e1 !important;
        }

        .dark .fi-in-entry-wrp:hover {
            border-color: #4b5563 !important;
        }

        /* تسميات الحقول */
        .fi-in-entry-wrp dt {
            font-family: "Tajawal", sans-serif !important;
            font-size: 0.8rem !important;
            color: #64748b !important;
            font-weight: 700 !important;
            margin-bottom: 6px !important;
        }

        .dark .fi-in-entry-wrp dt {
            color: #9ca3af !important;
        }

        /* قيم الحقول */
        .fi-in-entry-wrp dd {
            font-family: "Tajawal", sans-serif !important;
            font-size: 0.95rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
        }

        .dark .fi-in-entry-wrp dd {
            color: #ffffff !important;
        }

        /* إخفاء السكرول بار الأفقي المزعج في الشاشات الكبيرة للوحة التحكم */
        @media (min-width: 1024px) {
            .fi-ta-content {
                overflow-x: hidden !important;
            }
        }

        /* تخصيص كروت الشركات لتطابق التصميم بدقة */
        .fi-ta-content-grid > div {
            height: 100% !important;
            display: flex !important;
            flex-direction: column !important;
        }

        .fi-ta-content-grid .fi-ta-record {
            border-radius: 1rem !important; /* rounded-2xl */
            border: 1px solid #f3f4f6 !important; /* border-gray-100 */
            background-color: #ffffff !important; /* bg-white */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important; /* shadow-sm */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            overflow: hidden !important;
            height: 100% !important;
        }

        /* تمديد العناصر الداخلية لضمان تساوي الارتفاع بالكامل ومحاذاة الأزرار */
        .fi-ta-content-grid .fi-ta-record > div {
            flex: 1 1 0% !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            height: 100% !important;
            padding: 0 !important;
        }

        .fi-ta-content-grid .fi-ta-record .flex-col {
            flex: 1 1 0% !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            height: 100% !important;
        }

        /* إزالة الهوامش المحيطة بالحاوية الداخلية لكي تلتصق الصورة بالكامل */
        .fi-ta-content-grid .fi-ta-record .py-4 {
            padding: 0 !important;
        }

        /* تثبيت حجم حاوية الصورة ومنعها من التمدد أو الانكماش */
        .fi-ta-content-grid .fi-ta-record .h-48 {
            height: 12rem !important;
            flex-shrink: 0 !important;
        }

        /* جعل صندوق الاختيار معلقاً فوق الكارت بالكامل ولا يؤثر على العرض */
        .fi-ta-content-grid .fi-ta-record-checkbox {
            position: absolute !important;
            top: 1rem !important;
            right: 1rem !important;
            z-index: 20 !important;
            margin: 0 !important;
        }

        .dark .fi-ta-content-grid .fi-ta-record {
            border-color: #1f2937 !important; /* border-gray-800 */
            background-color: #111827 !important; /* bg-gray-900 */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2) !important;
        }

        .fi-ta-content-grid .fi-ta-record:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important; /* hover:shadow-md */
            transform: translateY(-2px) !important;
        }

        /* تنسيق حاوية الإجراءات (الخط الفاصل والأزرار) في كارت الشركة */
        .fi-ta-content-grid .fi-ta-actions {
            border-top: 1px solid #f3f4f6 !important; /* border-t border-gray-100 */
            padding: 1rem 1.5rem 1.25rem 1.5rem !important;
            display: flex !important;
            width: 100% !important;
            align-items: center !important;
            gap: 0.75rem !important;
            justify-content: space-between !important;
            background-color: #fafafa !important; /* خلفية خفيفة مميزة للأزرار */
        }

        .dark .fi-ta-content-grid .fi-ta-actions {
            border-top-color: #1f2937 !important;
            background-color: #182030 !important;
        }
    </style>'
)
->renderHook(
    PanelsRenderHook::USER_MENU_BEFORE,
    fn (): string => Blade::render('
        <div class="flex items-center pr-2">
            <a href="{{ url("/") }}"
               target="_blank"
               class="fi-view-site-btn group">
                <span class="fi-view-site-pulse animate-pulse"></span>
                عرض الموقع
            </a>
        </div>
    '),
)
            ->databaseNotifications()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->navigationGroups([
                'إدارة المبيعات والمخزن',
                'إدارة المخزون',
                'المحتوى التفاعلي',
                'الإدارة والصلاحيات',
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
