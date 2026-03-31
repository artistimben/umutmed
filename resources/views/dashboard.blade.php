@extends('layouts.app')

@section('title', 'Hesabım - Umut Medikal')

@section('content')
<h1 class="section-title">Hesabım / Hoş geldiniz, {{ auth()->user()->name }}</h1>

<div class="product-detail-layout" style="grid-template-columns: 1fr 3fr; gap: 4rem;">
    <div class="account-nav-sidebar">
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow);">
            <ul class="footer-links" style="color: var(--text-color);">
                <li style="margin-bottom: 1.5rem; font-weight: 700; color: var(--primary-color);">
                    <i class="fas fa-shopping-bag"></i> Siparişlerim
                </li>
                <li style="margin-bottom: 1.5rem;">
                    <a href="{{ route('wishlist.index') }}"><i class="fas fa-heart"></i> Favorilerim</a>
                </li>
                <li style="margin-bottom: 1.5rem;">
                    <a href="{{ route('profile.edit') }}"><i class="fas fa-user-cog"></i> Profil Ayarları</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: transparent; border: none; cursor: pointer; color: #ff4757; font-weight: 600; padding: 0;">
                            <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <div class="account-content">
        <div style="background: white; padding: 3rem; border-radius: 12px; box-shadow: var(--shadow);">
            <h3>Sipariş Geçmişim</h3>
            
            @if($orders->count() > 0)
                <table class="cart-table" style="box-shadow: none; border: 1px solid #eee;">
                    <thead>
                        <tr>
                            <th>Sipariş No</th>
                            <th>Tarih</th>
                            <th>Tutar</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>{{ number_format($order->total_amount, 2) }} TL</td>
                            <td>
                                <span style="background: {{ $order->status == 'pending' ? '#fff3cd' : '#d4edda' }}; color: {{ $order->status == 'pending' ? '#856404' : '#155724' }}; padding: 0.2rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td><a href="#" class="btn btn-primary btn-sm">Detay</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; padding: 5rem 0; color: var(--text-muted);">Henüz bir siparişiniz bulunmamaktadır.</p>
                <div style="text-align: center;">
                    <a href="{{ route('home') }}" class="btn btn-primary" style="width: auto; padding: 0.8rem 2rem;">Alışverişe Başla</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
