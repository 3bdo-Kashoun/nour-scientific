<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
     public function index(Request $request)
{
    // استخدم with لجلب العلاقات دفعة واحدة وتسريع الموقع
    $query = Product::with(['company', 'category']);

    // بحث النص
    $query->when($request->search, function ($q, $search) {
        $q->where(function ($sub) use ($search) {
            $sub->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('company', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        });
    });

    // فلترة الأصناف (بناءً على الـ ID الممرر من الـ Select)
    $query->when($request->category, function ($q, $category) {
        $q->where('category_id', $category);
    });

    $products = $query->get();

    // إذا كان الطلب أجاكس (HTMX) نرجع الجزئية فقط
    if ($request->header('HX-Request')) {
        return view('partials.search-result', compact('products'))->render();
    }

    $categories = category::all();
    return view('products', compact('products', 'categories'));
}
}
