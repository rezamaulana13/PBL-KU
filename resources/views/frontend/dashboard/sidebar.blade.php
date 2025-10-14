@php
    $profileData = Auth::user();
    use Illuminate\Support\Str;

    $currentRoute = Route::currentRouteName();

    // Ambil cart dari session
    $cart = session()->get('cart', []);
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
@endphp

<div class="col-md-3">
    <div class="osahan-account-page-left shadow-sm rounded bg-white h-100">

        {{-- BAGIAN PROFIL PENGGUNA --}}
        <div class="border-bottom p-4">
            <div class="osahan-user text-center">
                <div class="osahan-user-media">
                    <img class="mb-3 rounded-pill shadow-sm mt-1"
                         src="{{ $profileData->photo ? url('upload/user_images/'.$profileData->photo) : url('upload/profile.jpg') }}"
                         alt="{{ $profileData->name ?? 'User Photo' }}"
                         style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="osahan-user-media-body">
                        <h6 class="mb-2">{{ $profileData->name ?? 'User' }}</h6>
                        <p class="mb-1">{{ $profileData->phone ?? '-' }}</p>
                        <p>{{ $profileData->email ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- START MENU LIST --}}
        <ul class="nav nav-tabs flex-column border-0 pt-4 pl-4 pb-4" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'dashboard' ? 'active' : '' }}"
                   href="{{ route('dashboard') }}" aria-selected="true">
                   <i class="icofont-user"></i> Profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'user.track.order' ? 'active' : '' }}"
                   href="{{ route('user.track.order') }}" aria-selected="true">
                   <i class="icofont-location-pin"></i> Pelacakan Pesanan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Str::startsWith($currentRoute, 'user.order') && $currentRoute !== 'user.track.order' ? 'active' : '' }}"
                   href="{{ route('user.order.list') }}" aria-selected="true">
                   <i class="icofont-food-cart"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'all.wishlist' ? 'active' : '' }}"
                   href="{{ route('all.wishlist') }}" aria-selected="true">
                   <i class="icofont-heart"></i> Favorit
                </a>
            </li>
            <hr class="mx-3 my-2">

            {{-- CART SIDEBAR --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#sidebarCart" role="button" aria-expanded="false" aria-controls="sidebarCart">
    <i class="icofont-shopping-cart"></i> Keranjang
    <span class="badge bg-danger ms-1 rounded-pill">{{ count($cart) }}</span>
</a>
                <div class="collapse mt-2" id="sidebarCart">
                    <div class="card card-body p-2" style="max-height: 250px; overflow-y: auto;">
                        @if(!empty($cart))
                            @foreach($cart as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>{{ $item['name'] }}</strong> <br>
                                        <small>x {{ $item['quantity'] }}</small>
                                    </div>
                                    <div>
                                        Rp {{ number_format($item['price'] * $item['quantity'],0,',','.') }}
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total</span>
                                <span>Rp {{ number_format($total,0,',','.') }}</span>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn btn-success btn-sm w-100 mt-2">
                                Checkout
                            </a>
                        @else
                            <p class="text-center text-muted mb-0">Keranjang kosong</p>
                        @endif
                    </div>
                </div>
            </li>

            <hr class="mx-3 my-2">

            {{-- Other tabs like Offers, Payments, Addresses --}}
            <li class="nav-item">
                <a class="nav-link" id="offers-tab" data-toggle="tab" href="#offers" role="tab" aria-controls="offers" aria-selected="false">
                   <i class="icofont-sale-discount"></i> Offers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="payments-tab" data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
                   <i class="icofont-credit-card"></i> Payments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="addresses-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="addresses" aria-selected="false">
                   <i class="icofont-location-pin"></i> Addresses
                </a>
            </li>

            <hr class="mx-3 my-2">

            <li class="nav-item">
                <a class="nav-link {{ $currentRoute === 'change.password' ? 'active' : '' }}"
                   href="{{ route('change.password') }}">
                   <i class="icofont-key"></i> Change Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="icofont-sign-out"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</div>
