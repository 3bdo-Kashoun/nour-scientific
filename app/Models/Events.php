<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Events extends Model
{
    //
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'city',
        'booth',
        'status',
    ];
    protected static function booted(): void
    {
        static::created(function (Events $event) {
            self::sendAdminNotification('تمت إضافة حدث جديد', 'الحدث: ' . $event->title . ' من قبل: ' . auth()->user()?->name);
        });

        static::updated(function (Events $event) {
            self::sendAdminNotification('تم تعديل بيانات الحدث', 'تم تحديث بيانات: ' . $event->title . ' من قبل: ' . auth()->user()?->name);
        });
        static::deleted(function (Events $event) {
            self::sendAdminNotification('تم حذف الحدث', 'تم حذف الحدث: ' . $event->title . ' من قبل: ' . auth()->user()?->name);
        });
    }
    protected $casts = [
    'start_date' => 'date',
    'end_date' => 'date',
];

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
