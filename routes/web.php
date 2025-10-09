<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Client\RestaurantController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\FilterController;

// =========================================================================
// Rute Publik (Index & Dashboard)
// =========================================================================
Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

// =========================================================================
// Rute Khusus User (Middleware 'auth')
// =========================================================================
Route::middleware('auth')->group(function () {
    // Profil dan Keamanan
    Route::post('/profile/store', [UserController::class, 'ProfileStore'])->name('profile.store');
    Route::match(['get', 'post'], '/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::get('/change/password', [UserController::class, 'ChangePassword'])->name('change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

    // Wishlist
    Route::get('/all/wishlist', [HomeController::class, 'AllWishlist'])->name('all.wishlist');
    Route::get('/remove/wishlist/{id}', [HomeController::class, 'RemoveWishlist'])->name('remove.wishlist');

    // Manajemen Pesanan User (Menggunakan ManageOrderController)
    Route::controller(ManageOrderController::class)->group(function(){
        // Order List & Detail
        Route::get('/user/order/list', 'UserOrderList')->name('user.order.list');
        Route::get('/user/order/details/{id}', 'UserOrderDetails')->name('user.order.details');

        // Invoice
        Route::get('/user/invoice/download/{id}', 'UserInvoiceDownload')->name('user.invoice.download');

        // Pembatalan
        Route::post('/user/order/cancel/{id}', 'UserOrderCancel')->name('user.order.cancel');

        // Routes BARU untuk Tracking
        Route::get('/user/track/order', 'UserTrackOrder')->name('user.track.order');
        Route::post('/user/track/by-number', 'TrackByNumber')->name('user.track.by.number');

}); // End Auth Middleware

require __DIR__.'/auth.php';

// =========================================================================
// Rute Khusus Admin (Middleware 'admin')
// =========================================================================
Route::middleware('admin')->group(function () {
    // Admin Dasar
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    // Kategori & Kota
    Route::controller(CategoryController::class)->group(function(){
        Route::get('/all/category', 'AllCategory')->name('all.category');
        Route::get('/add/category', 'AddCategory')->name('add.category');
        Route::post('/store/category', 'StoreCategory')->name('category.store');
        Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
        Route::post('/update/category', 'UpdateCategory')->name('category.update');
        Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');

        Route::get('/all/city', 'AllCity')->name('all.city');
        Route::post('/store/city', 'StoreCity')->name('city.store');
        Route::get('/edit/city/{id}', 'EditCity')->name('edit.city');
        Route::post('/update/city', 'UpdateCity')->name('city.update');
        Route::get('/delete/city/{id}', 'DeleteCity')->name('delete.city');
    });

    // Produk & Restoran (ManageController)
    Route::controller(ManageController::class)->group(function(){
        Route::get('/admin/all/product', 'AdminAllProduct')->name('admin.all.product');
        Route::get('/admin/add/product', 'AdminAddProduct')->name('admin.add.product');
        Route::post('/admin/store/product', 'AdminStoreProduct')->name('admin.product.store');
        Route::get('/admin/edit/product/{id}', 'AdminEditProduct')->name('admin.edit.product');
        Route::post('/admin/update/product', 'AdminUpdateProduct')->name('admin.product.update');
        Route::get('/admin/delete/product/{id}', 'AdminDeleteProduct')->name('admin.delete.product');

        Route::get('/pending/restaurant', 'PendingRestaurant')->name('pending.restaurant');
        Route::get('/clientchangeStatus', 'ClientChangeStatus');
        Route::get('/approve/restaurant', 'ApproveRestaurant')->name('approve.restaurant');

        // Banner
        Route::get('/all/banner', 'AllBanner')->name('all.banner');
        Route::post('/banner/store', 'BannerStore')->name('banner.store');
        Route::get('/edit/banner/{id}', 'EditBanner')->name('edit.banner');
        Route::post('/banner/update', 'BannerUpdate')->name('banner.update');
        Route::get('/delete/banner/{id}', 'DeleteBanner')->name('delete.banner');
    });

    // Manajemen Order Admin (ManageOrderController)
    Route::controller(ManageOrderController::class)->group(function(){
        // Daftar Status Order
        Route::get('/pending/order', 'PendingOrder')->name('pending.order');
        Route::get('/confirm/order', 'ConfirmOrder')->name('confirm.order');
        Route::get('/processing/order', 'ProcessingOrder')->name('processing.order');
        Route::get('/delivered/order', 'DeliveredOrder')->name('delivered.order');
        Route::get('/cancelled/order', 'CancelledOrder')->name('cancelled.order');

        // Detail & Update Status
        Route::get('/admin/order/details/{id}', 'AdminOrderDetails')->name('admin.order.details');
        Route::get('/pending_to_confirm/{id}', 'PendingToConfirm')->name('pending_to_confirm');
        Route::get('/confirm_to_processing/{id}', 'ConfirmToProcessing')->name('confirm_to_processing');
        Route::get('/processing_to_delivered/{id}', 'ProcessingToDiliverd')->name('processing_to_delivered');
    });

    // Laporan
    Route::controller(ReportController::class)->group(function(){
        Route::get('/admin/all/reports', 'AminAllReports')->name('admin.all.reports');
        Route::post('/admin/search/bydate', 'AminSearchByDate')->name('admin.search.bydate');
        Route::post('/admin/search/bymonth', 'AminSearchByMonth')->name('admin.search.bymonth');
        Route::post('/admin/search/byyear', 'AminSearchByYear')->name('admin.search.byyear');
    });

    // Review
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/admin/pending/review', 'AdminPendingReview')->name('admin.pending.review');
        Route::get('/admin/approve/review', 'AdminApproveReview')->name('admin.approve.review');
        Route::get('/reviewchangeStatus', 'ReviewChangeStatus');
    });

}); // End Admin Middleware

// Admin Login/Auth diluar Middleware
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');
Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
Route::get('/admin/forget_password', [AdminController::class, 'AdminForgetPassword'])->name('admin.forget_password');
Route::post('/admin/password_submit', [AdminController::class, 'AdminPasswordSubmit'])->name('admin.password_submit');
Route::get('/admin/reset-password/{token}/{email}', [AdminController::class, 'AdminResetPassword']);
Route::post('/admin/reset_password_submit', [AdminController::class, 'AdminResetPasswordSubmit'])->name('admin.reset_password_submit');

// =========================================================================
// Rute Khusus Client/Restaurant (Middleware 'client', 'status')
// =========================================================================
Route::middleware('client')->group(function () {
    // Client Dasar
    Route::get('/client/dashboard', [ClientController::class, 'ClientDashboard'])->name('client.dashboard');
    Route::get('/client/profile', [ClientController::class, 'ClientProfile'])->name('client.profile');
    Route::post('/client/profile/store', [ClientController::class, 'ClientProfileStore'])->name('client.profile.store');
    Route::get('/client/change/password', [ClientController::class, 'ClientChangePassword'])->name('client.change.password');
    Route::post('/client/password/update', [ClientController::class, 'ClientPasswordUpdate'])->name('client.password.update');

    // Autentikasi Client diluar group middleware 'status'
    Route::get('/client/login', [ClientController::class, 'ClientLogin'])->name('client.login');
    Route::get('/client/register', [ClientController::class, 'ClientRegister'])->name('client.register');
    Route::post('/client/register/submit', [ClientController::class, 'ClientRegisterSubmit'])->name('client.register.submit');
    Route::post('/client/login_submit', [ClientController::class, 'ClientLoginSubmit'])->name('client.login_submit');
    Route::get('/client/logout', [ClientController::class, 'ClientLogout'])->name('client.logout');
});


Route::middleware(['client','status'])->group(function () {

    // Menu (RestaurantController)
    Route::controller(RestaurantController::class)->group(function(){
        Route::get('/all/menu', 'AllMenu')->name('all.menu');
        Route::get('/add/menu', 'AddMenu')->name('add.menu');
        Route::post('/store/menu', 'StoreMenu')->name('menu.store');
        Route::get('/edit/menu/{id}', 'EditMenu')->name('edit.menu');
        Route::post('/update/menu', 'UpdateMenu')->name('menu.update');
        Route::get('/delete/menu/{id}', 'DeleteMenu')->name('delete.menu');

        // Produk
        Route::get('/all/product', 'AllProduct')->name('all.product');
        Route::get('/add/product', 'AddProduct')->name('add.product');
        Route::post('/store/product', 'StoreProduct')->name('product.store');
        Route::get('/edit/product/{id}', 'EditProduct')->name('edit.product');
        Route::post('/update/product', 'UpdateProduct')->name('product.update');
        Route::get('/delete/product/{id}', 'DeleteProduct')->name('delete.product');

        // Galeri
        Route::get('/all/gallery', 'AllGallery')->name('all.gallery');
        Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
        Route::post('/store/gallery', 'StoreGallery')->name('gallery.store');
        Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');
        Route::post('/update/gallery', 'UpdateGallery')->name('gallery.update');
        Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');
    });

    // Kupon
    Route::controller(CouponController::class)->group(function(){
        Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('coupon.store');
        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('coupon.update');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');
    });

    // Order Client (ManageOrderController)
    Route::controller(ManageOrderController::class)->group(function(){
        Route::get('/all/client/orders', 'AllClientOrders')->name('all.client.orders');
        Route::get('/client/order/details/{id}', 'ClientOrderDetails')->name('client.order.details');
        Route::post('/client/update/courier/{id}', 'UpdateCourierInfo')->name('client.update.courier');

        // Rute untuk update info kurir
        Route::post('/client/update/courier/{id}', 'UpdateCourierInfo')->name('client.update.courier');
    });

    // Laporan Client
    Route::controller(ReportController::class)->group(function(){
        Route::get('/client/all/reports', 'ClientAllReports')->name('client.all.reports');
        Route::post('/client/search/bydate', 'ClientSearchByDate')->name('client.search.bydate');
        Route::post('/client/search/bymonth', 'ClientSearchByMonth')->name('client.search.bymonth');
        Route::post('/client/search/byyear', 'ClientSearchByYear')->name('client.search.byyear');
    });

    // Review Client
    Route::controller(ReviewController::class)->group(function(){
        Route::get('/client/all/reviews', 'ClientAllReviews')->name('client.all.reviews');
    });

}); // End Client Middleware with Status

// =========================================================================
// Rute Umum (Untuk Semua User, termasuk Guest)
// =========================================================================
Route::get('/changeStatus', [RestaurantController::class, 'ChangeStatus']);

Route::controller(HomeController::class)->group(function(){
    Route::get('/restaurant/details/{id}', 'RestaurantDetails')->name('res.details');
    Route::post('/add-wish-list/{id}', 'AddWishList'); // Asumsi ini ditangani via AJAX/POST
});

Route::controller(CartController::class)->group(function(){
    Route::get('/add_to_cart/{id}', 'AddToCart')->name('add_to_cart');
    Route::post('/cart/update-quantity', 'updateCartQuanity')->name('cart.updateQuantity');
    Route::post('/cart/remove', 'CartRemove')->name('cart.remove');
    Route::post('/apply-coupon', 'ApplyCoupon');
    Route::get('/remove-coupon', 'CouponRemove');
    Route::get('/checkout', 'ShopCheckout')->name('checkout');
});

Route::controller(OrderController::class)->group(function(){
    Route::post('/cash_order', 'CashOrder')->name('cash_order');
    Route::post('/stripe_order', 'StripeOrder')->name('stripe_order');
});

// Halaman terima kasih
Route::get('/thanks', function() {
    return view('frontend.checkout.thanks');
})->name('thanks');

Route::controller(ReviewController::class)->group(function(){
    Route::post('/store/review', 'StoreReview')->name('store.review');
});

Route::controller(FilterController::class)->group(function(){
    Route::get('/list/restaurant', 'ListRestaurant')->name('list.restaurant');
    Route::get('/filter/products', 'FilterProducts')->name('filter.products');
});
});

