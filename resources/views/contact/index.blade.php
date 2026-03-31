@extends('layouts.app')

@section('title', 'İletişim - Umut Medikal')

@section('content')
<h1 class="section-title">Bizimle İletişime Geçin</h1>

<div class="product-detail-layout" style="grid-template-columns: 1fr 1.5fr; gap: 4rem;">
    <div class="contact-info">
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow); height: 100%;">
            <h3 style="margin-bottom: 2rem;">İletişim Bilgileri</h3>
            
            <div style="margin-bottom: 2rem;">
                <p style="font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">Adres</p>
                <p>Umut Medikal Ürünleri Satış Merkezi<br>İstanbul, Türkiye</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <p style="font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">Telefon</p>
                <p>+90 212 XXX XX XX</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <p style="font-weight: 700; color: var(--primary-color); margin-bottom: 0.5rem;">E-Posta</p>
                <p>info@umutmedikal.com</p>
            </div>
            
            <div style="margin-top: 3rem;">
                <p style="font-weight: 700; color: var(--primary-color); margin-bottom: 1rem;">Çalışma Saatleri</p>
                <ul class="footer-links" style="color: var(--text-color);">
                    <li>Pazartesi - Cuma: 09:00 - 18:00</li>
                    <li>Cumartesi: 09:00 - 13:00</li>
                    <li>Pazar: Kapalı</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="contact-form">
        <form action="{{ route('contact.store') }}" method="POST" style="background: white; padding: 3rem; border-radius: 12px; box-shadow: var(--shadow);">
            @csrf
            <h3 style="margin-bottom: 2rem;">Mesaj Gönderin</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.8rem; font-weight: 600;">Ad Soyad</label>
                    <input type="text" name="name" required class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.8rem; font-weight: 600;">E-Posta</label>
                    <input type="email" name="email" required class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.8rem; font-weight: 600;">Telefon (İsteğe Bağlı)</label>
                <input type="text" name="phone" class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 8px;">
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.8rem; font-weight: 600;">Mesajınız</label>
                <textarea name="message" required rows="6" class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 8px; resize: none;"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: auto; padding: 1.2rem 3rem; font-size: 1.1rem;">Mesajı Gönder</button>
        </form>
    </div>
</div>
@endsection
