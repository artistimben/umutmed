<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);
        
        $validated['product_id'] = $id;
        $validated['user_id'] = auth()->id();
        $validated['is_approved'] = false; // Default to unapproved
        
        Review::create($validated);
        
        return back()->with('success', 'Yorumunuz başarıyla iletildi. Onaylandıktan sonra yayınlanacaktır.');
    }
}
