<nav class="navbar navbar-expand-lg navbar-light bg-light osahan-nav shadow-sm sticky-top">
    <div class="container">

        {{-- LOGO --}}
        <a class="navbar-brand" href="{{ route('index') }}">
            <img alt="logo" src="{{ asset('frontend/img/logorara.png') }}" width="90">
        </a>

        {{-- TOGGLE BUTTON (Mobile) --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- NAV LINKS --}}
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto align-items-center">

                {{-- HOME --}}
                <li class="nav-item active me-3">
                    <a class="nav-link fw-bold" href="{{ route('index') }}">Home</a>
                </li>

                {{-- PROMO --}}
                <li class="nav-item me-3">
                    <a class="nav-link text-danger fw-bold" href="offers.html">
                        <i class="icofont-sale-discount me-1"></i> Promo
                        <span class="badge badge-danger rounded-pill ms-1">Baru</span>
                    </a>
                </li>

                {{-- PRODUK --}}
                <li class="nav-item me-3">
                    <a class="nav-link fw-bold" href="{{ route('list.restaurant') }}">Produk</a>
                </li>

                {{-- AUTENTIKASI --}}
                @auth
                    @php
                        $profileData = Auth::user();
                    @endphp
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img alt="Profile"
                                 src="{{ $profileData->photo ? url('upload/user_images/'.$profileData->photo) : url('upload/no_image.jpg') }}"
                                 class="nav-osahan-pic rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                            Akun
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow border-0">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i class="icofont-food-cart me-2 text-primary"></i> Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('user.logout') }}">
                                <i class="icofont-logout me-2"></i> Logout
                            </a>
                        </div>
                    </li>
                @else
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth

                {{-- KERANJANG --}}
                @php
                    $cart = session()->get('cart', []);
                    $total = 0;
                    $groupedCart = [];
                    foreach ($cart as $item) {
                        $groupedCart[$item['client_id']][] = $item;
                        $total += $item['price'] * $item['quantity'];
                    }
                    $clients = App\Models\Client::whereIn('id', array_keys($groupedCart))->get()->keyBy('id');
                @endphp

                <li class="nav-item dropdown dropdown-cart ms-3">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-basket me-1"></i> Keranjang
                        <span class="badge bg-danger ms-1 rounded-pill">{{ count($cart) }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-cart-top p-0 dropdown-menu-right shadow-lg border-0"
                         style="min-width: 320px;">

                        {{-- CART HEADER --}}
                        @foreach ($groupedCart as $clientId => $items)
                            @if (isset($clients[$clientId]))
                                @php $client = $clients[$clientId]; @endphp
                                <div class="dropdown-cart-top-header bg-light p-3 border-bottom d-flex align-items-center">
                                    <img class="img-fluid rounded-circle me-3" alt="{{ $client->name }}"
                                         src="{{ $client->photo ? asset('upload/client_images/' . $client->photo) : asset('upload/no_image.jpg') }}"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $client->name }}</h6>
                                        <p class="text-muted small mb-0">{{ $client->address }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        {{-- CART BODY --}}
                        <div class="dropdown-cart-top-body p-3" style="max-height: 200px; overflow-y: auto;">
                            @if (!empty($cart))
                                @foreach ($cart as $item)
                                    <p class="mb-2 d-flex justify-content-between">
                                        <span class="text-dark">
                                            <i class="icofont-ui-press text-danger food-item me-1"></i>
                                            {{ $item['name'] }} <span class="text-muted small">x {{ $item['quantity'] }}</span>
                                        </span>
                                        <span class="text-dark fw-bold">
                                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                        </span>
                                    </p>
                                @endforeach
                            @else
                                <p class="text-muted text-center">Keranjang kosong</p>
                            @endif
                        </div>

                        {{-- CART FOOTER --}}
                        <div class="dropdown-cart-top-footer border-top p-3 d-flex justify-content-between">
                            <p class="mb-0 fw-bold text-secondary">Sub Total</p>
                            <span class="text-dark fw-bold">
                                Rp {{ number_format(Session::get('coupon')['discount_amount'] ?? $total, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- CHECKOUT BUTTON --}}
                        <div class="p-3">
                            <a class="btn btn-success btn-block fw-bold" href="{{ route('checkout') }}">
                                <i class="fas fa-arrow-right me-2"></i> Lanjut ke Checkout
                            </a>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
