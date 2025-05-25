@extends('client.client_dashboard')
@section('client')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Client All Report</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
<div class="row">

    <div class="col">
        <div class="card">
            <div class="card-body">
<div>

    <div class="">
        <div class="row" >

<div class="col-sm-4">
    <div class="card">
        <form id="myForm" action="{{ route('client.search.bydate') }}" method="post" enctype="multipart/form-data">
        @csrf

    <div class="row">
        <div class="col-lg-12">
            <div>
                <h4>Search By Date</h4>
                <div class="form-group mb-3">
                    <label for="example-text-input" class="form-label">Date</label>
                    <input class="form-control" type="date" name="date"  id="example-text-input">
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Cari</button>
                </div>

            </div>
        </div>
    </div>
    </form>
</div>
</div>
<div class="col-sm-4">
    <div class="card">
        <form id="myForm" action="{{ route('client.search.bymonth') }}" method="post" enctype="multipart/form-data">
        @csrf

    <div class="row">
        <div class="col-lg-12">
            <div>
                <h4>Search By Month</h4>
                <div class="form-group mb-3">
                    <label for="example-text-input" class="form-label">Select Month:</label>
                    <select name="month" class="form-select">
                        <option selected>Pilih Bulan</option>
                        <option value="Janurary">Janurari</option>
                        <option value="February">Februari</option>
                        <option value="March">Maret</option>
                        <option value="April">April</option>
                        <option value="May">Mei</option>
                        <option value="June">Juni</option>
                        <option value="July">Juli</option>
                        <option value="August">Augustus</option>
                        <option value="September">September</option>
                        <option value="October">Oktober</option>
                        <option value="November">November</option>
                        <option value="December">Desember</option>
                    </select>
                    <label for="example-text-input" class="form-label">Pilih Tahun:</label>
                    <select name="year_name" class="form-select">
                        <option selected>Pilih Tahun</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Cari</button>
                </div>

            </div>
        </div>
    </div>
    </form>
</div>
</div>
<div class="col-sm-4">
    <div class="card">
        <form id="myForm" action="{{ route('client.search.byyear') }}" method="post" enctype="multipart/form-data">
        @csrf

    <div class="row">
        <div class="col-lg-12">
            <div>
                <h4>Search By Year</h4>
                <div class="form-group mb-3">
                    <label for="example-text-input" class="form-label">Pilih Tahun Year:</label>
                    <select name="year" class="form-select">
                        <option selected>Select Year</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Cari</button>
                </div>

            </div>
        </div>
    </div>
    </form>
</div>
</div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div> <!-- end col -->


</div> <!-- end row -->


    </div> <!-- container-fluid -->
</div>


@endsection
