<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get()->map(function($item){
            $item->timeFormat = $item->created_at->format('Y/m/d');
            return $item;
        });
        return Inertia::render('Backend/Product/Index', ['response' => rtFormat($products)]);
    }

    public function product_create()
    {
        return Inertia::render('Backend/Product/CreateProduct');
    }

    public function product_store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255|string',
            'price'=>'required|min:0|numeric',
            'public'=>'required|numeric',
            'desc'=>'max:255',
        ]);

        $product = Product::create([
            'name'=> $request->name,
            'price'=> $request->price,
            'public'=> $request->public,
            'desc'=> $request->desc,
        ]);

        return back()->with(['message' => rtFormat($product, 1)]);
    }
}
