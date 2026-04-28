<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Engineer extends Model
{
    protected $fillable = [
        'name',
        'role',
        'phone',
        'email',
    ];

    protected static function booted(): void
    {
        static::created(function (Engineer $engineer) {
            self::sendAdminNotification('تمت إضافة مهندس جديد', 'المهندس: ' . $engineer->name . ' من قبل: ' . auth()->user()?->name);
        });

        static::updated(function (Engineer $engineer) {
            self::sendAdminNotification('تم تعديل بيانات مهندس', 'تم تحديث بيانات: ' . $engineer->name . ' من قبل: ' . auth()->user()?->name);
        });
        static::deleted(function (Engineer $engineer) {
            self::sendAdminNotification('تم حذف مهندس', 'تم حذف المهندس: ' . $engineer->name . ' من قبل: ' . auth()->user()?->name);
        });
    }

    private static function sendAdminNotification(string $title, string $body): void
    {
        $admin = User::find(1);
        if (!$admin) return;

        DB::table('notifications')->insert([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'type' => 'Filament\\Notifications\\DatabaseNotification',
            'notifiable_type' => 'App\\Models\\User',
            'notifiable_id' => $admin->id,
            'data' => json_encode([
                'title' => $title,
                'body' => $body,
                'color' => null,
                'icon' => null,
                'iconColor' => null,
                'status' => null,
                'actions' => [],
                'duration' => 'persistent',
                'view' => 'filament-notifications::notification',
                'viewData' => [],
                'format' => 'filament',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
