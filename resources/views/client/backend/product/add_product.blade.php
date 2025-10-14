@extends('client.client_dashboard')
@section('client')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tambah Produk</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tambah Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Produk -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <form id="myForm" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <!-- Kategori -->
                                <div class="col-md-4">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" class="form-select">
                                        <option disabled selected>Pilih</option>
                                        @foreach($category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Menu -->
                                <div class="col-md-4">
                                    <label class="form-label">Menu</label>
                                    <select name="menu_id" class="form-select">
                                        <option disabled selected>Pilih</option>
                                        @foreach($menu as $men)
                                            <option value="{{ $men->id }}">{{ $men->menu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Kota -->
                                <div class="col-md-4">
                                    <label class="form-label">Kota</label>
                                    <select name="city_id" class="form-select">
                                        <option disabled selected>Pilih</option>
                                        @foreach($city as $cit)
                                            <option value="{{ $cit->id }}">{{ $cit->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Nama Produk -->
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control">
                                </div>

                                <!-- Ukuran -->
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Ukuran</label>
                                    <input type="text" name="size" class="form-control">
                                </div>

                                <!-- Harga -->
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Harga</label>
                                    <input type="text" name="price" id="price" class="form-control" onkeyup="formatRupiah(this)">
                                </div>

                                <!-- Harga Diskon -->
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Harga Diskon</label>
                                    <input type="text" name="discount_price" id="discount_price" class="form-control" onkeyup="formatRupiah(this)">
                                </div>

                                <!-- Stok -->
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Stok Tersedia</label>
                                    <input type="number" name="qty" class="form-control">
                                </div>

                                <!-- Gambar -->
                                <div class="col-md-4 mt-3">
                                    <label class="form-label">Gambar Produk</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>

                                <div class="col-md-4 mt-3">
                                    <img id="showImage" src="{{ url('upload/profile.jpg') }}" alt="Preview" width="110" class="rounded">
                                </div>

                                <!-- Checkbox Best Seller & Most Populer -->
                                <div class="col-md-12 mt-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="best_seller" value="1" class="form-check-input" id="best_seller">
                                        <label class="form-check-label" for="best_seller">Best Seller</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="most_populer" value="1" class="form-check-input" id="most_populer">
                                        <label class="form-check-label" for="most_populer">Most Populer</label>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    // Preview Gambar
    $('#image').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    // Validasi
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {required:true},
                image: {required:true},
                menu_id: {required:true},
                category_id: {required:true},
            },
            messages: {
                name: {required:'Harap isi nama produk'},
                image: {required:'Harap pilih gambar'},
                menu_id: {required:'Harap pilih menu'},
                category_id: {required:'Harap pilih kategori'},
            },
            errorElement:'span',
            errorPlacement:function(error,element){
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight:function(element){$(element).addClass('is-invalid');},
            unhighlight:function(element){$(element).removeClass('is-invalid');}
        });
    });

    // Format Rupiah
    function formatRupiah(input){
        let value = input.value.replace(/[^,\d]/g,'');
        let formatted = new Intl.NumberFormat('id-ID', {style:'currency', currency:'IDR', minimumFractionDigits:0}).format(value);
        input.value = formatted;
    }
</script>
@endsection
