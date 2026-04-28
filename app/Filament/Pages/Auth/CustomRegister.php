<?php
namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register;

class CustomRegister extends Register
{
    // ربط الكلاس بملف الـ View الخاص بك
    protected static string $view = 'filament.custom.register';
}
