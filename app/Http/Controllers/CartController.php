<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::with(['company', 'dosage'])->whereIn('id', $productIds)->get();

        $cartItems = [];
        $subtotal = 0;
        foreach ($products as $product) {
            $qty = $cart[$product->id];
            $itemTotal = $product->price * $qty;
            $subtotal += $itemTotal;
            $cartItems[] = [
                'product' => $product,
                'quantity' => $qty,
                'total' => $itemTotal
            ];
        }

        return view('cart', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $qty = (int)$request->input('quantity', 1);

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'المنتج غير موجود'], 404);
        }

        // حساب الكمية المعلقة لحساب المخزن الفعال
        $pendingQty = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.status', 'pending')
            ->where('order_product.product_id', $productId)
            ->sum('order_product.quantity');
        
        $effectiveStock = $product->stock_quantity - $pendingQty;

        $cart = session()->get('cart', []);
        $currentInCart = isset($cart[$productId]) ? $cart[$productId] : 0;
        $newQty = $currentInCart + $qty;

        if ($newQty > $effectiveStock) {
            return response()->json([
                'error' => "عذراً، الكمية المطلوبة غير متوفرة. المتاح الفعلي للطلب هو {$effectiveStock} قطعة (نظراً لوجود حجوزات قيد الانتظار)."
            ], 422);
        }

        $cart[$productId] = $newQty;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'تمت إضافة المنتج إلى السلة بنجاح!',
            'cart_count' => count($cart)
        ]);
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $newQty = (int)$request->input('quantity');

        if ($newQty <= 0) {
            return response()->json(['error' => 'الكمية يجب أن تكون أكبر من الصفر'], 422);
        }

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'المنتج غير موجود'], 404);
        }

        // حساب الكمية المعلقة لحساب المخزن الفعال
        $pendingQty = DB::table('order_product')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->where('orders.status', 'pending')
            ->where('order_product.product_id', $productId)
            ->sum('order_product.quantity');
        
        $effectiveStock = $product->stock_quantity - $pendingQty;

        if ($newQty > $effectiveStock) {
            return response()->json([
                'error' => "عذراً، لا يمكن زيادة الكمية لهذا الحد. المتاح الفعلي للطلب هو {$effectiveStock} قطعة."
            ], 422);
        }

        $cart = session()->get('cart', []);
        $cart[$productId] = $newQty;
        session()->put('cart', $cart);

        // حساب المجموع الكلي
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $subtotal = 0;
        foreach ($cart as $id => $q) {
            if (isset($products[$id])) {
                $subtotal += $products[$id]->price * $q;
            }
        }

        return response()->json([
            'success' => true,
            'item_total' => number_format($product->price * $newQty, 2),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($subtotal, 2)
        ]);
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $subtotal = 0;
        foreach ($cart as $id => $q) {
            if (isset($products[$id])) {
                $subtotal += $products[$id]->price * $q;
            }
        }

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($subtotal, 2)
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'delivery_address' => 'required_if:delivery_requested,1|nullable|string',
        ], [
            'phone.required' => 'رقم الهاتف مطلوب لإتمام عملية الشراء.',
            'delivery_address.required_if' => 'عنوان التوصيل مطلوب عند اختيار خدمة التوصيل.',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error_msg', 'سلة المشتريات فارغة حالياً!');
        }

        $subtotal = 0;
        $itemsToAttach = [];

        // التأكد من المخزن الفعلي لكافة المنتجات في السلة
        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product) {
                return back()->with('error_msg', 'أحد المنتجات في السلة غير متوفر حالياً.');
            }

            $pendingQty = DB::table('order_product')
                ->join('orders', 'order_product.order_id', '=', 'orders.id')
                ->where('orders.status', 'pending')
                ->where('order_product.product_id', $productId)
                ->sum('order_product.quantity');
            
            $effectiveStock = $product->stock_quantity - $pendingQty;

            if ($qty > $effectiveStock) {
                return back()->with('error_msg', "عذراً، نفدت الكمية المطلوبة للمنتج ({$product->name}). المتاح الفعلي للطلب حالياً هو {$effectiveStock} قطعة فقط (لوجود طلبات قيد الانتظار).");
            }

            $subtotal += $product->price * $qty;
            $itemsToAttach[$productId] = [
                'quantity' => $qty,
                'price' => $product->price
            ];
        }

        $deliveryRequested = $request->input('delivery_requested') == '1';
        $deliveryPrice = $deliveryRequested ? 15.00 : 0.00;
        $totalPrice = $subtotal + $deliveryPrice;

        $order = DB::transaction(function () use ($itemsToAttach, $request, $deliveryRequested, $deliveryPrice, $totalPrice) {
            $newOrder = Order::create([
                'user_id' => Auth::id(),
                'phone' => $request->input('phone'),
                'delivery_requested' => $deliveryRequested,
                'delivery_price' => $deliveryPrice,
                'delivery_address' => $deliveryRequested ? $request->input('delivery_address') : null,
                'status' => 'pending',
                'total_price' => $totalPrice,
            ]);

            foreach ($itemsToAttach as $productId => $pivotData) {
                $newOrder->products()->attach($productId, $pivotData);
            }

            return $newOrder;
        });

        // مسح الجلسة بعد نجاح الطلب
        session()->forget('cart');

        // إرسال بريد إلكتروني بتأكيد الطلب
        try {
            \Illuminate\Support\Facades\Mail::to(Auth::user()->email)->send(new \App\Mail\OrderPlaced($order));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('فشل إرسال بريد تأكيد الطلب: ' . $e->getMessage());
        }

        return redirect()->route('products')->with('success_order', 'تم إرسال طلبك بنجاح! طلبك الآن قيد المراجعة والانتظار.');
    }
}
