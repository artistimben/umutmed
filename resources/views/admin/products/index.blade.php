@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 800; margin: 0;">Ürün Yönetimi</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Yeni Ürün Ekle</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Görsel</th>
                <th>Ürün Adı</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Fiyat</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ $product->mainImage ? $product->mainImage->image_url : 'https://via.placeholder.com/100x100?text=Urun' }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                </td>
                <td style="font-weight: 600;">{{ $product->title }}</td>
                <td style="color: var(--text-muted);">{{ $product->category ? $product->category->name : 'Genel' }}</td>
                <td><span class="badge {{ $product->stock > 5 ? 'badge-success' : 'badge-danger' }}">{{ $product->stock }} Adet</span></td>
                <td style="font-weight: 700;">{{ number_format($product->price, 2) }} TL</td>
                <td>
                    <a href="#" style="color: var(--admin-primary); margin-right: 1rem;"><i class="fas fa-edit"></i></a>
                    <a href="#" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 2rem;">
        {{ $products->links() }}
    </div>
</div>
@endsection
