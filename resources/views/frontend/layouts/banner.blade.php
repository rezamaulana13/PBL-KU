<section class="pt-5 pb-5 homepage-search-block position-relative">
    <div class="banner-overlay"></div>
    <div class="container">
       <div class="row d-flex align-items-center py-lg-4">
          <div class="col-lg-8 mx-auto">
             <div class="homepage-search-title text-center">
                <h1 class="mb-2 display-4 text-shadow text-white font-weight-normal"><span class="font-weight-bold">Raracookies</span></h1>
                <h5 class="mb-5 text-shadow text-white-50 font-weight-normal">Raracoockies dibuat dengan tangan terampil, menggunakan bahan-bahan terbaik dan berkualitas yang siap untuk menemani anda setiap tawa dan cerita seluruh warga indonesia!</h5>
             </div>
             <div class="homepage-search-form">
                <form class="form-noborder">
                   <div class="form-row">
                      <div class="col-lg-3 col-md-3 col-sm-12 form-group">
                         <div class="location-dropdown">
                            <i class="icofont-location-arrow"></i>
                            <select class="custom-select form-control-lg">
                               <option> Pilih Kue Kering </option>
                               <option> Terlaris </option>
                               <option> Termurah </option>
                               <option> Terbaru </option>
                               <option> Promo </option>
                               <option> Lainnya </option>
                            </select>
                         </div>
                      </div>
                      <div class="col-lg-7 col-md-7 col-sm-12 form-group">
                         <input type="text" placeholder="Enter your delivery location" class="form-control form-control-lg">
                         <a class="locate-me" href="#"><i class="icofont-ui-pointer"></i> Delete</a>
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-12 form-group">
                         <a href="listing.html" class="btn btn-primary btn-block btn-lg btn-gradient">Cari</a>
                         <!--<button type="submit" class="btn btn-primary btn-block btn-lg btn-gradient">Search</button>-->
                      </div>
                   </div>
                </form>
             </div>
             <h6 class="mt-4 text-shadow text-white font-weight-normal">Nastar, Kastengel, Putri Salju</h6>
             <div class="owl-carousel owl-carousel-category owl-theme">
    @php
       $products = App\Models\Product::latest()->limit(8)->get();
    @endphp
              @foreach ($products  as $product)
              <div class="item">
                   <div class="osahan-category-item">
                      <a href="#">
                         <img class="img-fluid" src="{{ asset($product->image ) }}" alt="">
                         <h6>{{ Str::limit($product->name, 8)  }}</h6>
                         <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                      </a>
                   </div>
                </div>
                @endforeach



             </div>
          </div>

       </div>
    </div>
 </section>

