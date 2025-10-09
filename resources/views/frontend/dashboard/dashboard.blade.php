<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Raracoockies Website User Dashboard">
      <meta name="author" content="Askbootstrap">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>User Dashboard - Raracoockies Website</title>

      <link rel="icon" type="image/png" href="{{ asset('frontend/img/logorara.png') }}">

      <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/select2/css/select2.min.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.carousel.css') }}">
      <link rel="stylesheet" href="{{ asset('frontend/vendor/owl-carousel/owl.theme.css') }}">

      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

      <link href="{{ asset('frontend/css/osahan.css') }}" rel="stylesheet">

      @stack('styles')

   </head>
   <body>

   {{-- ===================== HEADER ===================== --}}
   @include('frontend.dashboard.header')

   <div class="container my-5">

        <div class="row">

            @yield('user') </div>
        </div>

   {{-- ===================== FOOTER ===================== --}}
   @include('frontend.dashboard.footer')


   {{-- ===================== GLOBAL SCRIPTS ===================== --}}

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('frontend/vendor/select2/js/select2.min.js') }}"></script>
   <script src="{{ asset('frontend/vendor/owl-carousel/owl.carousel.js') }}"></script>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   <script src="https://js.stripe.com/v3/"></script>

   <script src="{{ asset('frontend/js/custom.js') }}"></script>

   {{-- 1. Setup AJAX CSRF Token (Membutuhkan JQuery) --}}
   <script type="text/javascript">
      $.ajaxSetup({
          headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          }
      });
   </script>

   {{-- 2. Toastr Notifikasi (Membutuhkan Toastr JS) --}}
   <script>
      @if(Session::has('message'))
      var type = "{{ Session::get('alert-type','info') }}"
      switch(type){
         case 'info':
         toastr.info(" {{ Session::get('message') }} ");
         break;

         case 'success':
         toastr.success(" {{ Session::get('message') }} ");
         break;

         case 'warning':
         toastr.warning(" {{ Session::get('message') }} ");
         break;

         case 'error':
         toastr.error(" {{ Session::get('message') }} ");
         break;
      }
      @endif
   </script>

   {{-- 3. Coupon Logic (Membutuhkan JQuery & SweetAlert2) --}}
   <script>
      function ApplyCoupon() {
         var coupon_name = $('#coupon_name').val();
         $.ajax({
            type: "POST",
            dataType: "json",
            data:{coupon_name:coupon_name},
            url:"/apply-coupon",
            success:function(data){
               const Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000
               })

               if (data.status === 'success') {
                  Toast.fire({
                      icon: 'success',
                      title: data.success,
                  });
                  location.reload();
               } else {
                  Toast.fire({
                      icon: 'error',
                      title: data.error,
                  })
               }
            }
         })
      }

      function couponRemove(){
         $.ajax({
            type:"GET",
            dataType:"json",
            url:"/remove-coupon",
            success:function(data){

               const Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000
               })

               if (data.status === 'success') {
                  Toast.fire({
                      icon: 'success',
                      title: data.success,
                  });
                  location.reload();
               } else {
                  Toast.fire({
                      icon: 'error',
                      title: data.error,
                  })
               }
            }
         })
      }
   </script>

   {{-- 4. Stack Scripts Khusus Halaman --}}
   @stack('scripts')


   </body>
</html>
