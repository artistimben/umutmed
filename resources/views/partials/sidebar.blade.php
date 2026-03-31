<aside class="category-sidebar" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); height: fit-content; position: sticky; top: 180px;">
    <h3 style="font-size: 1.1rem; margin-bottom: 1.5rem; color: #333; border-bottom: 2px solid var(--primary-color); padding-bottom: 0.5rem; display: inline-block;">Kategoriler</h3>
    <ul style="list-style: none; padding: 0; margin: 0;">
        <li style="margin-bottom: 0.8rem;">
            <a href="{{ route('home') }}" style="text-decoration: none; color: #666; font-weight: 500; display: flex; align-items: center; justify-content: space-between; font-size: 0.95rem;">
                Tüm Ürünler
                <i class="fas fa-chevron-right" style="font-size: 0.7rem; opacity: 0.5;"></i>
            </a>
        </li>
        @foreach($categories as $cat)
        <li style="margin-bottom: 0.8rem;">
            @php $isActive = (request()->is('kategori/'.$cat->slug) || (isset($categorySlug) && $categorySlug == $cat->slug) || (isset($product) && $product->category_id == $cat->id)); @endphp
            <a href="{{ route('products.category', $cat->slug) }}" style="text-decoration: none; color: {{ $isActive ? 'var(--primary-color)' : '#666' }}; font-weight: {{ $isActive ? '700' : '500' }}; display: flex; align-items: center; justify-content: space-between; font-size: 0.95rem;">
                {{ $cat->name }}
                <i class="fas fa-chevron-right" style="font-size: 0.7rem; opacity: 0.5;"></i>
            </a>
        </li>
        @endforeach
    </ul>

    <div style="margin-top: 3rem; background: #f8f9fa; padding: 1.5rem; border-radius: 8px; text-align: center;">
        <i class="fas fa-shipping-fast" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
        <p style="font-size: 0.85rem; font-weight: 600; color: #333;">Hızlı ve Güvenilir Teslimat</p>
    </div>
</aside>
