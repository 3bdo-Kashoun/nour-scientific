<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login;

class CustomLogin extends Login
{
    // هنا نحدد ملف التصميم (Blade) الذي سننشئه لاحقاً
    protected static string $view = 'Filament.login';
}
