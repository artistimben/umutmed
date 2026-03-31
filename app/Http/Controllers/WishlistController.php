<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $wishlist = \App\Models\Wishlist::where('user_id', auth()->id())->pluck('product_id')->toArray();
        } else {
            $wishlist = session()->get('wishlist', []);
        }
        
        $products = Product::whereIn('id', $wishlist)->with('mainImage')->get();
        
        return view('wishlist.index', compact('products'));
    }

    public function toggle($id)
    {
        if (auth()->check()) {
            $item = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $id)->first();
            if ($item) {
                $item->delete();
                $msg = 'Ürün favorilerden çıkarıldı!';
            } else {
                \App\Models\Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $id
                ]);
                $msg = 'Ürün favorilere eklendi!';
            }
        } else {
            $wishlist = session()->get('wishlist', []);
            if (in_array($id, $wishlist)) {
                $wishlist = array_values(array_diff($wishlist, [$id]));
                $msg = 'Ürün favorilerden çıkarıldı!';
            } else {
                $wishlist[] = (int)$id;
                $msg = 'Ürün favorilere eklendi!';
            }
            session()->put('wishlist', $wishlist);
        }
        
        return back()->with('success', $msg);
    }
}
