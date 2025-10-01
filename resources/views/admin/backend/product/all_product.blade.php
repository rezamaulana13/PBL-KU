@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<div class="page-content">
    <div class="container-fluid">

        <!-- Judul Halaman -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Daftar Produk</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <a href="{{ route('admin.add.product') }}" class="btn btn-primary waves-effect waves-light">Tambah Produk</a>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Judul -->

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
            <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Nama Toko / Restoran</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            </thead>

            <tbody>
           @foreach ($product as $key=> $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td><img src="{{ asset($item->image) }}" alt="" style="width: 70px; height:40px;"></td>
                <td>{{ $item->name }}</td>
                <td>{{ $item['client']['name'] }}</td>
                <td>{{ $item->qty }}</td>

                <!-- Format Harga ke Rupiah -->
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>

                <td>
                    @if ($item->discount_price == NULL)
                        <span class="badge bg-danger">Tidak Ada Diskon</span>
                    @else
                        @php
                            $amount = $item->price - $item->discount_price;
                            $discount = ($amount / $item->price) * 100;
                        @endphp
                        <span class="badge bg-success">{{ round($discount) }}%</span><br>
                        <small>Rp {{ number_format($item->discount_price, 0, ',', '.') }}</small>
                    @endif
                </td>

                <td>
                    @if ($item->status == 1)
                        <span class="text-success"><b>Aktif</b></span>
                    @else
                        <span class="text-danger"><b>Tidak Aktif</b></span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('admin.edit.product',$item->id) }}" class="btn btn-info waves-effect waves-light">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="{{ route('admin.delete.product',$item->id) }}" class="btn btn-danger waves-effect waves-light" id="delete">
                        <i class="fas fa-trash"></i>
                    </a>

                    <input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger"
                        data-toggle="toggle" data-on="Aktif" data-off="Tidak Aktif" {{ $item->status ? 'checked' : '' }}>
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

<script type="text/javascript">
    $(function() {
      $('.toggle-class').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var product_id = $(this).data('id');

          $.ajax({
              type: "GET",
              dataType: "json",
              url: '/changeStatus',
              data: {'status': status, 'product_id': product_id},
              success: function(data){

              const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000
              })
              if ($.isEmptyObject(data.error)) {

                      Toast.fire({
                      type: 'success',
                      title: data.success,
                      })

              }else{

             Toast.fire({
                      type: 'error',
                      title: data.error,
                      })
                  }

              }
          });
      })
    })
</script>

@endsection
