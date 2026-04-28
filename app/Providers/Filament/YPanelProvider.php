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
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
    </style>'
)
->renderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn (): string => Blade::render('
                <div class="flex items-center pr-2">
                    <a href="{{ url("/") }}"
                       target="_blank"
                       class="relative inline-flex items-center px-4 py-1.5 text-sm font-bold tracking-wide transition-all duration-200
                              text-[#00a651] bg-white border-2 border-[#00a651] rounded-full
                              hover:bg-[#00a651] hover:text-white shadow-sm hover:shadow-md
                              active:scale-95 group">

                        <span class="ml-1.5 flex h-2 w-2 rounded-full bg-[#00a651] group-hover:bg-white animate-pulse"></span>
                        عرض الموقع
                    </a>
                </div>
            '),
        )
            ->databaseNotifications()
            ->databaseNotificationsPolling('2s')
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
    'إدارة المخزون',
    'المحتوى التفاعلي',
    'الإدارة والصلاحيات',
])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
