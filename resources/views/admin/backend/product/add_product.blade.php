@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Tambah Produk</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tambah Produk</li>
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

<form id="myForm" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
    @csrf

<div class="row">
    <div class="col-xl-3 col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">Nama Kategori</label>
                <select name="category_id" class="form-select">
                    <option>Pilih</option>
                    @foreach ($category as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                    @endforeach
                </select>
            </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="form-group mb-3">
            <label class="form-label">Nama Menu</label>
            <select name="menu_id" class="form-select">
                <option selected="" disabled="">Pilih</option>
                @foreach ($menu as $men)
                <option value="{{ $men->id }}">{{ $men->menu_name }}</option>
                @endforeach
            </select>
        </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Nama Kota</label>
        <select name="city_id" class="form-select">
            <option>Pilih</option>
            @foreach ($city as $cit)
            <option value="{{ $cit->id }}">{{ $cit->city_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Nama Client</label>
        <select name="client_id" class="form-select">
            <option>Pilih</option>
            @foreach ($client as $clie)
            <option value="{{ $clie->id }}">{{ $clie->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-xl-4 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Nama Produk</label>
        <input class="form-control" type="text" name="name">
    </div>
</div>

<div class="col-xl-4 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Harga (Rp)</label>
        <input class="form-control" type="number" name="price">
    </div>
</div>

<div class="col-xl-4 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Harga Diskon (Rp)</label>
        <input class="form-control" type="number" name="discount_price">
    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Ukuran</label>
        <input class="form-control" type="text" name="size">
    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Jumlah Stok</label>
        <input class="form-control" type="number" name="qty">
    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="form-group mb-3">
        <label class="form-label">Gambar Produk</label>
        <input class="form-control" name="image" type="file" id="image">
    </div>
</div>

<div class="col-xl-6 col-md-6">
    <div class="form-group mb-3">
        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" alt="" class="rounded-circle p-1 bg-primary" width="110">
    </div>
</div>

<div class="form-check mt-2">
    <input class="form-check-input" name="best_seller" type="checkbox" value="1">
    <label class="form-check-label">Best Seller</label>
</div>

<div class="form-check mt-2">
    <input class="form-check-input" name="most_populer" type="checkbox" value="1">
    <label class="form-check-label">Paling Populer</label>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
</div>

</div>
</form>
</div>
</div>











                <!-- end tab content -->
            </div>
            <!-- end col -->


            <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        })
    })

</script>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                },
                image: {
                    required : true,
                },
                menu_id: {
                    required : true,
                },

            },
            messages :{
                name: {
                    required : 'Please Enter Name',
                },
                image: {
                    required : 'Please Select Image',
                },
                menu_id: {
                    required : 'Please Select One Menu',
                },


            },
            errorElement : 'span',
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

    function formatRupiah(angka) {
        return angka.replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    document.querySelectorAll('.rupiah').forEach(function(input) {
        input.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
        });
    });

</script>


@endsection
