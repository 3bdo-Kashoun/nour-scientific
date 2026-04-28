<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $fillable = ['title','discreption','image'];
     protected static function booted(): void
    {
        static::created(function (News $news) {
            self::sendAdminNotification('تمت إضافة خبر جديد', 'لخبر: ' . $news->title . ' من قبل: ' . auth()->user()?->name);
        });

        static::updated(function (News $news) {
            self::sendAdminNotification('تم تعديل بيانات الخبر', 'تم تحديث بيانات: ' . $news->title . ' من قبل: ' . auth()->user()?->name);
        });
        static::deleted(function (News $news) {
            self::sendAdminNotification('تم حذف الخبر', 'تم حذف الحدث: ' . $news->title . ' من قبل: ' . auth()->user()?->name);
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
