@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 800; margin: 0;">Trendyol Entegratör Yanıtı</h1>
    <div style="display: flex; gap: 1rem;">
        <form action="{{ route('admin.integration.sync') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-database"></i> Veritabanına Kaydet / Güncelle
            </button>
        </form>
        <a href="{{ route('admin.settings') }}" class="btn" style="background: #e5e7eb; color: #374151;">Ayarları Düzenle</a>
    </div>
</div>

@if(!$response)
    <div class="card" style="border-left: 5px solid #ef4444; background: #fef2f2;">
        <h3 style="color: #991b1b; margin-bottom: 0.5rem;"><i class="fas fa-exclamation-triangle"></i> Bağlantı Hatası</h3>
        <p style="color: #991b1b;">Trendyol API (apigw) üzerinden veri alınamadı. Lütfen API anahtarlarınızı ve yetkilerinizi kontrol edin.</p>
    </div>
@else
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Listed Products -->
        <div class="card">
            <h3 style="margin-bottom: 1.5rem;">Gelen Ürünler ({{ count($response['content'] ?? []) }})</h3>
            <table>
                <thead>
                    <tr>
                        <th>Barcode</th>
                        <th>Model Kodu</th>
                        <th>Stok</th>
                        <th>Piyasa Fiyatı</th>
                        <th>Satış Fiyatı</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($response['content'] ?? [] as $item)
                    <tr>
                        <td style="font-weight: 700;">{{ $item['barcode'] ?? 'N/A' }}</td>
                        <td>{{ $item['modelCode'] ?? 'N/A' }}</td>
                        <td><span class="badge {{ ($item['quantity'] ?? 0) > 0 ? 'badge-success' : 'badge-danger' }}">{{ $item['quantity'] ?? 0 }}</span></td>
                        <td>{{ number_format($item['listPrice'] ?? 0, 2) }} TL</td>
                        <td style="font-weight: 800; color: #ff6000;">{{ number_format($item['salePrice'] ?? 0, 2) }} TL</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align: center; padding: 3rem;">Veri bulunamadı.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Raw API Data -->
        <div class="card" style="background: #1e293b; color: #f8fafc; font-family: 'Courier New', Courier, monospace; overflow: auto; max-height: 800px;">
            <h3 style="color: #60a5fa; margin-bottom: 1rem; font-family: 'Mukta', sans-serif;">Ham API Yanıtı (JSON)</h3>
            <pre style="font-size: 0.85rem; line-height: 1.4; white-space: pre-wrap;">{{ json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        </div>
    </div>
@endif
@endsection
