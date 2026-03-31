@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 style="font-size: 2rem; font-weight: 800; margin: 0;">Cari Hesaplarım</h1>
    <a href="#" style="background: var(--admin-primary); color: white; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 700; text-decoration: none;">+ Yeni Cari Tanımla</a>
</div>

<div style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #f3f4f6; color: #6b7280;">
                <th style="padding: 1rem;">Cari Adı / Şirket</th>
                <th style="padding: 1rem;">Tür</th>
                <th style="padding: 1rem;">Telefon</th>
                <th style="padding: 1rem;">Bakiye</th>
                <th style="padding: 1rem;">İşlem</th>
            </tr>
        </thead>
        <tbody>
            @forelse($accounts as $acc)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 1rem; font-weight: 700; color: var(--admin-primary);">{{ $acc->name }}</td>
                <td style="padding: 1rem; color: #6b7280; text-transform: capitalize;">{{ $acc->type }}</td>
                <td style="padding: 1rem;">{{ $acc->phone ?? 'Belirtilmedi' }}</td>
                <td style="padding: 1rem;">
                    <span style="font-weight: 800; color: {{ $acc->balance < 0 ? '#ef4444' : '#10b981' }};">
                        {{ number_format($acc->balance, 2) }} TL
                    </span>
                </td>
                <td style="padding: 1rem;">
                    <a href="#" title="Detay"><i class="fas fa-eye" style="color: #6b7280; margin-right: 1.5rem;"></i></a>
                    <a href="#" title="Alacak/Borç İşlemi" style="color: #ff9f43;"><i class="fas fa-file-invoice-dollar"></i></a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 5rem 0; color: #999;">
                    <i class="fas fa-address-book" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i><br>
                    Henüz kayıtlı cari hesap bulunamadı.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 2rem;">
        {{ $accounts->links() }}
    </div>
</div>
@endsection
