<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ]);
        
        ContactMessage::create($validated);
        
        return back()->with('success', 'Mesajınız başarıyla iletildi. En kısa sürede size geri dönüş yapacağız.');
    }
}
