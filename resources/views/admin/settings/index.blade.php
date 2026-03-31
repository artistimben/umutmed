@extends('layouts.admin')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 2rem;">Trendyol Mağaza Ayarları</h1>

    <div class="card" style="margin-bottom: 2rem; border-left: 5px solid #ff6000;">
        <h3 style="margin-bottom: 1rem;"><i class="fas fa-info-circle" style="color:#ff6000"></i> API Bilgilerine Nasıl Ulaşılır?</h3>
        <p style="color: #666; font-size: 0.95rem; line-height: 1.6;">
            1. <strong>Trendyol Satıcı Paneline</strong> giriş yapın.<br>
            2. Sağ üstteki mağaza ismine tıklayıp <strong>"Hesap Bilgileri"</strong> menüsüne girin.<br>
            3. Açılan sayfada <strong>"Entegrasyon Bilgileri"</strong> sekmesine tıklayın.<br>
            4. Buradaki <strong>Cari ID, API Key</strong> ve <strong>API Secret</strong> anahtarlarını aşağıya yapıştırın.
        </p>
    </div>

    <div class="card">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 0.5rem;">Mağaza Adı</label>
                    <input type="text" value="Umut Medikal" readonly style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; background: #f9f9f9; border-radius: 8px;">
                </div>
                <div>
                    <label style="display: block; font-weight: 700; margin-bottom: 0.5rem;">Cari ID (Seller ID)</label>
                    <input type="text" name="seller_id" value="{{ env('TRENDYOL_SELLER_ID', '680904') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem;">API Key</label>
                <input type="text" name="api_key" value="{{ env('TRENDYOL_API_KEY') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem;">API Secret</label>
                <input type="password" name="api_secret" value="{{ env('TRENDYOL_API_SECRET') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 700; margin-bottom: 0.5rem;">Entegrasyon Referans Kodu</label>
                <input type="text" name="ref_code" value="{{ env('TRENDYOL_INTEGRATION_CODE') }}" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">Ayarları Güncelle</button>
        </form>
    </div>
</div>
@endsection
