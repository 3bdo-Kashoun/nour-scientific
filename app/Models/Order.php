<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'delivery_requested' => 'boolean',
        'delivery_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    protected static function booted()
    {
        static::updated(function ($order) {
            if ($order->isDirty('status')) {
                $oldStatus = $order->getOriginal('status');
                $newStatus = $order->status;

                $oldDecrements = in_array($oldStatus, ['in_delivery', 'sold']);
                $newDecrements = in_array($newStatus, ['in_delivery', 'sold']);

                if (!$oldDecrements && $newDecrements) {
                    // Transition to decrementing physical stock
                    $clientName = $order->user?->name ?? 'غير معروف';
                    $orderNo = '#ORD-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);

                    foreach ($order->products as $product) {
                        $qty = $product->pivot->quantity;
                        $product->decrement('stock_quantity', $qty);
                        $product->stockMovements()->create([
                            'quantity' => -$qty,
                            'type' => 'out',
                            'reason' => $newStatus === 'sold'
                                ? "بيع مباشر للزبون {$clientName} - طلبية رقم {$orderNo}"
                                : "شحن وتوصيل للزبون {$clientName} - طلبية رقم {$orderNo}",
                        ]);
                    }
                } elseif ($oldDecrements && !$newDecrements) {
                    // Transition to incrementing physical stock (returning to stock)
                    $clientName = $order->user?->name ?? 'غير معروف';
                    $orderNo = '#ORD-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);

                    foreach ($order->products as $product) {
                        $qty = $product->pivot->quantity;
                        $product->increment('stock_quantity', $qty);
                        $product->stockMovements()->create([
                            'quantity' => $qty,
                            'type' => 'in',
                            'reason' => "إرجاع بضاعة صالحة للمخزن بعد إلغاء الطلبية من الزبون {$clientName} - طلبية رقم {$orderNo}",
                        ]);
                    }
                }
            }
        });

        static::deleted(function ($order) {
            $status = $order->status;
            if (in_array($status, ['in_delivery', 'sold'])) {
                $clientName = $order->user?->name ?? 'غير معروف';
                $orderNo = '#ORD-' . str_pad($order->id, 3, '0', STR_PAD_LEFT);

                foreach ($order->products as $product) {
                    $qty = $product->pivot->quantity;
                    $product->increment('stock_quantity', $qty);
                    $product->stockMovements()->create([
                        'quantity' => $qty,
                        'type' => 'in',
                        'reason' => "إرجاع بضاعة صالحة للمخزن بعد حذف الطلبية رقم {$orderNo} للزبون {$clientName}",
                    ]);
                }
            }
        });
    }
}
