@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 800; margin: 0;">Kategori Yönetimi</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Yeni Kategori Ekle</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Kategori Adı</th>
                <th>Ürün Sayısı</th>
                <th>Slug</th>
                <th style="text-align: right;">İşlem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td style="font-weight: 700; color: var(--admin-primary);">{{ $cat->name }}</td>
                <td><span class="badge badge-blue">{{ $cat->products_count }} Ürün</span></td>
                <td style="color: var(--text-muted);">{{ $cat->slug }}</td>
                <td style="text-align: right;">
                    <a href="#" style="color: #6b7280; margin-right: 1.5rem;"><i class="fas fa-edit"></i></a>
                    <a href="#" style="color: #ef4444;"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
