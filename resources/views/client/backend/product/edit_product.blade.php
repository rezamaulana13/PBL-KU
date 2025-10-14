@extends('client.client_dashboard')
@section('client')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Edit Produk</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Edit Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-4">

                        <form id="myForm" action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="row">

                                <!-- Kategori -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Menu -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Menu</label>
                                        <select name="menu_id" class="form-select">
                                            <option value="">Pilih Menu</option>
                                            @foreach ($menu as $men)
                                                <option value="{{ $men->id }}" {{ $men->id == $product->menu_id ? 'selected' : '' }}>{{ $men->menu_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Kota -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kota</label>
                                        <select name="city_id" class="form-select">
                                            <option value="">Pilih Kota</option>
                                            @foreach ($city as $cit)
                                                <option value="{{ $cit->id }}" {{ $cit->id == $product->city_id ? 'selected' : '' }}>{{ $cit->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Nama Produk -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input class="form-control" type="text" name="name" value="{{ $product->name }}">
                                    </div>
                                </div>

                                <!-- Harga -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Harga</label>
                                        <input class="form-control rupiah" type="text" name="price" value="{{ number_format($product->price, 0, ',', '.') }}">
                                    </div>
                                </div>

                                <!-- Harga Diskon -->
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Harga Diskon</label>
                                        <input class="form-control rupiah" type="text" name="discount_price" value="{{ number_format($product->discount_price, 0, ',', '.') }}">
                                    </div>
                                </div>

                                <!-- Ukuran -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Ukuran</label>
                                        <input class="form-control" type="text" name="size" value="{{ $product->size }}">
                                    </div>
                                </div>

                                <!-- Stok -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Stok Tersedia</label>
                                        <input class="form-control" type="text" name="qty" value="{{ $product->qty }}">
                                    </div>
                                </div>

                                <!-- Gambar -->
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Gambar Produk</label>
                                        <input class="form-control" type="file" name="image" id="image">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <img id="showImage" src="{{ asset($product->image) }}" alt="" class="rounded p-1 bg-primary" width="110">
                                    </div>
                                </div>

                                <!-- Best Seller -->
                                <div class="col-xl-6 col-md-6 form-check mt-2">
                                    <input class="form-check-input" name="best_seller" type="checkbox" value="1" {{ $product->best_seller == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Best Seller</label>
                                </div>

                                <!-- Most Populer -->
                                <div class="col-xl-6 col-md-6 form-check mt-2">
                                    <input class="form-check-input" name="most_populer" type="checkbox" value="1" {{ $product->most_populer == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label">Most Populer</label>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#image').change(function(e){
            let reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files[0]);
        });

        // Validasi form
        $('#myForm').validate({
            rules: {
                name: { required: true },
                menu_id: { required: true },
            },
            messages: {
                name: { required: 'Nama produk wajib diisi' },
                menu_id: { required: 'Silakan pilih menu' },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) { $(element).addClass('is-invalid'); },
            unhighlight: function(element) { $(element).removeClass('is-invalid'); }
        });

        // Format Rupiah
        $('.rupiah').on('keyup', function(){
            this.value = this.value.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        // Hapus titik sebelum submit
        $('#myForm').on('submit', function(){
            $('.rupiah').each(function(){ this.value = this.value.replace(/\./g, ''); });
        });
    });
</script>
@endsection
