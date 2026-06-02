<x-mail::message>
# شكراً لتسوقك معنا، {{ $order->user->name }}!

تم استلام طلبك بنجاح وهو الآن **{{ $order->status === 'pending' ? 'قيد الانتظار' : 'جاري المعالجة' }}**.
رقم الطلب الخاص بك هو: **#ORD-{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}**

<x-mail::table>
| المنتج | الكمية | السعر |
|:-------|:------:|:-----:|
@foreach ($order->products as $product)
| {{ $product->name }} | {{ $product->pivot->quantity }} | {{ number_format($product->price, 2) }} د.ل |
@endforeach
</x-mail::table>

@if ($order->delivery_requested)
**سعر التوصيل:** {{ number_format($order->delivery_price, 2) }} د.ل
**عنوان التوصيل:** {{ $order->delivery_address }}
@endif

**الإجمالي الكلي:** {{ number_format($order->total_price, 2) }} د.ل

<x-mail::button :url="url('/profile')">
عرض تفاصيل الطلب
</x-mail::button>

مع تحياتنا،<br>
{{ config('app.name') }}
</x-mail::message>
