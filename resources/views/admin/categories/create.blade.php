@extends('layouts.admin')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem;">Yeni Kategori Ekle</h1>

    <div class="card">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem; color: #444;">Kategori Adı</label>
                <input type="text" name="name" required placeholder="Örn: Cerrahi Maskeler" style="width: 100%; padding: 1rem; border: 2px solid #f3f4f6; border-radius: 10px; font-size: 1rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--admin-primary)'" onblur="this.style.borderColor='#f3f4f6'">
                @error('name')
                    <div style="color: #ef4444; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Kategoriyi Kaydet</button>
                <a href="{{ route('admin.categories') }}" style="padding: 0.8rem 1.5rem; border: 2px solid #f3f4f6; border-radius: 10px; font-weight: 700; color: #6b7280;">Vazgeç</a>
            </div>
        </form>
    </div>
</div>
@endsection
