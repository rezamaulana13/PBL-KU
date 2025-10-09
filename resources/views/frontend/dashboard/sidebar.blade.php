@php
    // Ambil data profil pengguna yang sedang login
    $profileData = Auth::user();
    // Gunakan Illuminate\Support\Str untuk memudahkan pengecekan rute
    use Illuminate\Support\Str;

    // Tentukan route saat ini untuk membandingkan
    $currentRoute = Route::currentRouteName();
@endphp

<div class="col-md-3">
    <div class="osahan-account-page-left shadow-sm rounded bg-white h-100">

        {{-- BAGIAN PROFIL PENGGUNA --}}
        <div class="border-bottom p-4">
            <div class="osahan-user text-center">
                <div class="osahan-user-media">
                    {{-- URL Foto Profil dengan fallback 'profile.jpg' --}}
                    <img class="mb-3 rounded-pill shadow-sm mt-1"
                        src="{{(!empty($profileData->photo))
                            ? url('upload/user_images/'.$profileData->photo)
                            : url('upload/profile.jpg')}}"
                        alt="{{ $profileData->name ?? 'User Photo' }}"
                        style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="osahan-user-media-body">
                        <h6 class="mb-2">{{$profileData->name ?? 'User'}}</h6>
                        <p class="mb-1">{{$profileData->phone ?? '-'}}</p>
                        <p>{{$profileData->email ?? '-'}}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- START MENU LIST --}}
        <ul class="nav nav-tabs flex-column border-0 pt-4 pl-4 pb-4" id="myTab" role="tablist">

            {{-- 1. Profil / Dashboard (Halaman Pengaturan Akun) --}}
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}"
                   href="{{ route('dashboard') }}" aria-selected="true">
                   <i class="icofont-user"></i> Profil
                </a>
            </li>

            {{-- 2. PELACAKAN PESANAN (Diasumsikan sebagai halaman terpisah/Route) --}}
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'user.track.order' ? 'active' : '' }}"
                   href="{{ route('user.track.order') }}" aria-selected="true">
                   <i class="icofont-location-pin"></i> Pelacakan Pesanan
                </a>
            </li>

            {{-- 3. Orders (Aktif jika rute dimulai dengan 'user.order.' dan bukan 'user.track.order') --}}
            <li class="nav-item">
                <a class="nav-link {{ Str::startsWith($currentRoute, 'user.order') && $currentRoute !== 'user.track.order' ? 'active' : '' }}"
                   href="{{ route('user.order.list') }}" aria-selected="true">
                   <i class="icofont-food-cart"></i> Orders
                </a>
            </li>

            {{-- 4. Favourites (Wishlist) --}}
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'all.wishlist' ? 'active' : '' }}"
                   href="{{ route('all.wishlist') }}" aria-selected="true">
                   <i class="icofont-heart"></i> Favorit
                </a>
            </li>

            <hr class="mx-3 my-2">

            {{-- 5. Offers (Menggunakan Logika TAB) --}}
            <li class="nav-item">
                <a class="nav-link" id="offers-tab" data-toggle="tab" href="#offers" role="tab" aria-controls="offers" aria-selected="false">
                   <i class="icofont-sale-discount"></i> Offers
                </a>
            </li>

            {{-- 6. Payments (Menggunakan Logika TAB) --}}
            <li class="nav-item">
                <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
                   <i class="icofont-credit-card"></i> Payments
                </a>
            </li>

            {{-- 7. Addresses (Menggunakan Logika TAB) --}}
            <li class="nav-item">
                <a class="nav-link" id="addresses-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="addresses" aria-selected="false">
                   <i class="icofont-location-pin"></i> Addresses
                </a>
            </li>

            <hr class="mx-3 my-2">

            {{-- 8. Change Password --}}
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'change.password' ? 'active' : '' }}"
                   href="{{ route('change.password') }}" aria-selected="true">
                   <i class="icofont-key"></i> Change Password
                </a>
            </li>

            {{-- 9. Logout (Menggunakan form POST Laravel untuk keamanan) --}}
            <li class="nav-item">
                <a class="nav-link" href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   aria-selected="false">
                   <i class="icofont-sign-out"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
