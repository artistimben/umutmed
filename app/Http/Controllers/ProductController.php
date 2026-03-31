<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->input('category');
        $query = Product::with('mainImage')->latest();

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $featuredProducts = $query->limit(12)->get();
        $categories = Category::all();
        
        return view('index', compact('featuredProducts', 'categories', 'categorySlug'));
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'category', 'brand', 'reviews'])->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::with('mainImage')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();
            
        $categories = Category::all();
            
        return view('products.show', compact('product', 'relatedProducts', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::with('mainImage')
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(12);

        $categories = Category::all();
            
        return view('products.search', compact('products', 'query', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with('mainImage')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);
        
        $categories = Category::all();
        
        return view('products.search', [
            'products' => $products,
            'query' => $category->name,
            'categories' => $categories,
            'categorySlug' => $slug
        ]);
    }
}
