@extends('frontend.dashboard.dashboard')
@section('user')

{{-- Memuat JQuery untuk AJAX --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

{{-- ================================================================= --}}
{{-- STYLING Halaman (CSS INLINE UNTUK KEMUDAHAN) --}}
{{-- ================================================================= --}}
<style>
    /* ---------------------------------------------------- */
    /* 1. ESTETIKA GLOBAL */
    /* ---------------------------------------------------- */
    body {
        background-color: #f4f6f9; /* Background off-white/abu-abu muda */
        font-family: 'Poppins', sans-serif;
    }
    .products-listing {
        padding-top: 40px !important;
        padding-bottom: 40px !important;
    }

    /* ---------------------------------------------------- */
    /* 2. HEADER/BREADCRUMB (Full Background & Teks Premium) */
    /* ---------------------------------------------------- */
    .breadcrumb-osahan {
        padding-top: 120px !important;
        padding-bottom: 120px !important;
        background: linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url('{{ asset('assets/images/header-bg.jpg') }}') center center no-repeat;
        background-size: cover; /* Background Penuh (Fullin) */
        background-attachment: fixed; /* Efek Parallax Ringan */
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .breadcrumb-osahan h1 {
        font-weight: 900;
        letter-spacing: 3px;
        color: #fff;
        font-size: 3.2rem;
        /* Efek Teks Kedalaman Halus */
        text-shadow: 0 4px 8px rgba(0, 0, 0, 0.9), 0 0 10px rgba(255, 255, 255, 0.2);
    }
    .breadcrumb-osahan h6 {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
        font-weight: 300;
    }

    /* ---------------------------------------------------- */
    /* 3. FILTER SIDEBAR (Rapi dan Sticky) */
    /* ---------------------------------------------------- */
    .filters {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
    }
    .filters.sticky-top {
        top: 20px;
    }
    .filters-header {
        background-color: #ffffff;
        border-bottom: 2px solid #eee !important;
    }
    .filters-header h5 {
        font-weight: 700;
        color: #dc3545; /* Warna utama untuk judul filter */
    }
    .filters-card-header h6 a {
        font-weight: 600;
        color: #212529;
        text-decoration: none;
        padding: 10px 0;
        transition: color 0.2s;
    }
    .filters-card-body small.text-black-50 {
        color: #999 !important;
        font-size: 0.85rem;
    }
    .filters-card {
        border-bottom: 1px solid #f0f0f0 !important;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #dc3545;
        border-color: #dc3545;
    }


    /* ---------------------------------------------------- */
    /* 4. CARD PRODUK (DIJAGA SESUAI PERMINTAAN USER) */
    /* ---------------------------------------------------- */
    .list-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px !important;
    }
    .list-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .item-img {
        height: 200px;
        object-fit: cover;
    }
</style>

{{-- ================================================================= --}}
{{-- STRUKTUR HTML YANG DIRAPIKAN --}}
{{-- ================================================================= --}}

<section class="breadcrumb-osahan pt-5 pb-5 bg-dark position-relative text-center">
    <h1 class="text-white">Koleksi Raracookies</h1>
    <h6 class="text-white-50">Kue Kering Premium dengan Rasa Istimewa</h6>
</section>

<section class="section pt-5 pb-5 products-listing">
    <div class="container">

        {{-- HEADER DAN SORTING (DIRAPIKAN) --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mt-0">Produk Kami <small class="h6 mb-0 ml-2 text-muted">Varian Kue</small></h4>

                    {{-- DROPDOWN SORTING --}}
                    <div class="dropdown">
                        <a class="btn btn-outline-secondary dropdown-toggle btn-sm" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Urutkan: <span class="font-weight-bold text-dark">Terpopuler</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                            <a class="dropdown-item" href="#">Terpopuler</a>
                            <a class="dropdown-item" href="#">Terbaru</a>
                            <a class="dropdown-item" href="#">Rating</a>
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-4">
            </div>
        </div>

        <div class="row">

            {{-- KOLOM FILTER (SIDEBAR) --}}
            <div class="col-md-3">
                <div class="filters shadow-sm rounded bg-white mb-4 sticky-top">
                    <div class="filters-header pl-4 pr-4 pt-4 pb-3">
                        <h5 class="m-0">Filter Produk</h5>
                    </div>

                    {{-- Menggunakan satu ID accordion utama yang konsisten --}}
                    <div id="product-filters-accordion">

                        {{-- 1. FILTER JENIS KUE (CATEGORY) --}}
                        @php $categories = App\Models\Category::orderBy('category_name','asc')->limit(10)->get(); @endphp
                        <div class="filters-card p-4">
                            <div class="filters-card-header" id="headingCategory">
                                <h6 class="mb-0">
                                    <a href="#collapseCategory" class="btn-link d-block w-100" data-toggle="collapse" aria-expanded="true" data-parent="#product-filters-accordion" aria-controls="collapseCategory">
                                        Jenis Kue <i class="icofont-arrow-down float-right"></i>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseCategory" class="collapse show" aria-labelledby="headingCategory" data-parent="#product-filters-accordion">
                                <div class="filters-card-body card-shop-filters">
                                    @foreach ($categories as $category)
                                        @php $categoryProductCount = $products->where('category_id',$category->id)->count(); @endphp
                                        <div class="custom-control custom-checkbox my-2">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" id="category-{{$category->id}}" data-type="category" data-id="{{$category->id}}">
                                            <label class="custom-control-label" for="category-{{$category->id}}">{{$category->category_name}} <small class="text-black-50">({{$categoryProductCount}})</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- 2. FILTER ASAL KOTA (CITY) --}}
                        @php $cities = App\Models\City::orderBy('city_name','asc')->limit(10)->get(); @endphp
                        <div class="filters-card p-4">
                            <div class="filters-card-header" id="headingCity">
                                <h6 class="mb-0">
                                    <a href="#collapseCity" class="btn-link d-block w-100 collapsed" data-toggle="collapse" aria-expanded="false" data-parent="#product-filters-accordion" aria-controls="collapseCity">
                                        City <i class="icofont-arrow-down float-right"></i>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseCity" class="collapse" aria-labelledby="headingCity" data-parent="#product-filters-accordion">
                                <div class="filters-card-body card-shop-filters">
                                    @foreach ($cities as $city)
                                        @php $cityProductCount = $products->where('city_id',$city->id)->count(); @endphp
                                        <div class="custom-control custom-checkbox my-2">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" id="city-{{$city->id}}" data-type="city" data-id="{{$city->id}}">
                                            <label class="custom-control-label" for="city-{{$city->id}}">{{$city->city_name}} <small class="text-black-50">({{$cityProductCount}})</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- 3. FILTER MENU (MENU) --}}
                        @php $menus = App\Models\Menu::orderBy('menu_name','asc')->limit(10)->get(); @endphp
                        <div class="filters-card p-4 border-bottom-0">
                            <div class="filters-card-header" id="headingMenu">
                                <h6 class="mb-0">
                                    <a href="#collapseMenu" class="btn-link d-block w-100 collapsed" data-toggle="collapse" aria-expanded="false" data-parent="#product-filters-accordion" aria-controls="collapseMenu">
                                        Menu <i class="icofont-arrow-down float-right"></i>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapseMenu" class="collapse" aria-labelledby="headingMenu" data-parent="#product-filters-accordion">
                                <div class="filters-card-body card-shop-filters">
                                    @foreach ($menus as $menu)
                                        @php $menuProductCount = $products->where('menu_id',$menu->id)->count(); @endphp
                                        <div class="custom-control custom-checkbox my-2">
                                            <input type="checkbox" class="custom-control-input filter-checkbox" id="menu-{{$menu->id}}" data-type="menu" data-id="{{$menu->id}}">
                                            <label class="custom-control-label" for="menu-{{$menu->id}}">{{$menu->menu_name}} <small class="text-black-50">({{$menuProductCount}})</small></label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KOLOM DAFTAR PRODUK --}}
            <div class="col-md-9">
                <div class="row" id="product-list">

                    {{-- LOOPING PRODUK ASLI (TIDAK DIUBAH) --}}
                    @foreach ($products as $product)
                    <div class="col-md-4 col-sm-6 mb-4 pb-2">
                        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                            <div class="list-card-image">
                                <div class="star position-absolute"><span class="badge badge-success"><i class="icofont-star"></i> 3.1 (300+)</span></div>
                                <div class="favourite-heart text-danger position-absolute"><a href="{{ route('res.details',$product->client_id) }}"><i class="icofont-heart"></i></a></div>
                                <div class="member-plan position-absolute"><span class="badge badge-dark">Promoted</span></div>
                                <a href="{{ route('res.details',$product->client_id) }}">
                                <img src="{{ asset($product->image) }}" class="img-fluid item-img">
                                </a>
                            </div>
                            <div class="p-3 position-relative">
                                <div class="list-card-body">
                                <h6 class="mb-1"><a href="{{ route('res.details',$product->client_id) }}" class="text-black"> {{ $product->name}}</a></h6>

                                <p class="text-gray mb-3 time"><span class="bg-light text-dark rounded-sm pl-2 pb-1 pt-1 pr-2"><i class="icofont-wall-clock"></i> 20–25 min</span>
                                    <span class="float-right text-black-50"> Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </p>
                                </div>
                                <div class="list-card-badge">
                                <span class="badge badge-success">OFFER</span> <small>65% off | Use Coupon OSAHAN50</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================= --}}
{{-- LOGIKA JAVASCRIPT/AJAX (DIPERBAIKI) --}}
{{-- ================================================================= --}}
<script>
    $(document).ready(function(){
        $('.filter-checkbox').on('change',function(){
            var filters = {
                categories: [],
                cities: [], // Mengganti 'citits' menjadi 'cities' (penting!)
                menus: []
            };

            // 1. Mengumpulkan filter yang dicentang
            $('.filter-checkbox:checked').each(function(){
                var type = $(this).data('type');
                var id = $(this).data('id');

                // Memastikan penamaan properti di objek filters sudah benar
                if (type === 'category') {
                    filters.categories.push(id);
                } else if (type === 'city') {
                    filters.cities.push(id);
                } else if (type === 'menu') {
                    filters.menus.push(id);
                }
            });

            console.log("Filter yang dikirim:", filters);

            // 2. Kirim request AJAX
            $.ajax({
                url: '{{ route('filter.products') }}',
                method: 'GET',
                data: {
                    categories: filters.categories,
                    cities: filters.cities,
                    menus: filters.menus
                },
                beforeSend: function() {
                    // Tampilkan Loading State
                    $('#product-list').html('<div class="col-12 text-center my-5 py-5"><div class="spinner-border text-danger" role="status" style="width: 3rem; height: 3rem;"><span class="sr-only">Memuat...</span></div><h4 class="mt-3 text-muted">Memuat Kue...</h4></div>');
                },
                success: function(response){
                    $('#product-list').html(response);

                    if (response.trim().length === 0) {
                         $('#product-list').html('<div class="col-12 text-center my-5 py-5"><h3 class="text-danger">Tidak Ditemukan</h3><p class="lead text-muted">Kami tidak menemukan produk yang cocok dengan filter pilihan Anda.</p></div>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                    $('#product-list').html('<div class="col-12 text-center my-5 py-5"><h3 class="text-danger">Error!</h3><p>Gagal memuat produk karena masalah jaringan.</p></div>');
                }
            });
        });
    });
</script>


@endsection
