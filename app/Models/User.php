<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser; // 1. استيراد الواجهة
use Filament\Panel;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser // 2. تنفيذ الواجهة هنا
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // تأكد من إضافة الحقل هنا إذا كنت ستستخدم الـ Mass Assignment
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // من الأفضل تحويله لـ boolean لتسهيل التحقق
        ];
    }

    /**
     * 3. إضافة الدالة المسؤولة عن السماح بدخول لوحة التحكم
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // سيعيد true فقط إذا كان المستخدم يحمل قيمة 1 في حقل is_admin
        return (bool) $this->is_admin;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
