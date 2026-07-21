<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebRoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Http\Controllers\OneSignalController;

Route::get('/test-auth-mail', function () {

    $user = \App\Models\User::first();

    Mail::to('shakdabkhan@gmail.com')->send(
        new \App\Mail\AuthAttemptEmail(
            $user,
            '192.168.1.100',
            'Riyadh, Saudi Arabia'
        )
    );

    dd('MAIL SENT');
});


Route::get('/', [WebRoutController::class, 'getHome']);
Route::get('/railway-test', function () {
    return 'LATEST VERSION 999';
});





Route::get('/cookie-check', function () {
    dd(
        $_COOKIE,
        request()->cookie('guest_id')
    );
});







Route::get('/login', [WebRoutController::class, 'authPage']);
Route::get('/profile', [ProfileController::class, 'getProfileView']);
Route::get('/profile/guest-profile', [WebRoutController::class, 'getGuestProfileView']);


Route::get('/delete-user', [AuthController::class,'deleteUser']);
Route::post('/signup-user', [AuthController::class,'registerUser']);
Route::post('/login', [AuthController::class, 'LoginUser']);
Route::get('/logout', [AuthController::class, 'logoutUser']);
Route::get('/ensure-guest-id', [OrderController::class, 'ensureGuestId']);




Route::get('/shipping-cost', [WebRoutController::class, 'shippingCost'])->name('shipping.cost');
Route::get('/30-days-guarantee', [WebRoutController::class, 'thirtyDaysGuarantee'])->name('guarantee.30days');
Route::get('/privacy-policy', [WebRoutController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/search-product/{tag}', [WebRoutController::class, 'searchByTag']);
Route::get('/find-product/{slug}/{id}', [WebRoutController::class, 'getFindProducts']);
Route::get('/all-blogs', [WebRoutController::class, 'getAllBlogs']);
Route::get('/blog-details/{slug}/{id}', [BlogsController::class, 'blogsDetailsView']);
Route::get('/product-details/{slug}/{id}', [WebRoutController::class, 'getProductDetails']);
Route::get('/about-us', [WebRoutController::class, 'aboutUsView']);
Route::get('/faq', [WebRoutController::class, 'faqView']);
Route::get('/return-policy', [WebRoutController::class, 'returnView']);
Route::get('/shop/{slug}/{id}', [WebRoutController::class, 'shopDetails']);
Route::get('/shop/all', [WebRoutController::class, 'shopAll']);
Route::get('/contact', [WebRoutController::class, 'contactView']);




Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'cartView']);
Route::get('/cart/count', [CartController::class, 'count']);


Route::get('/stripe/checkout', [PaymentController::class, 'checkout'])
    ->name('stripe.checkout');
Route::get('/stripe/success', [PaymentController::class, 'success'])
    ->name('stripe.success');

Route::get('/stripe/cancel', [PaymentController::class, 'cancel'])
    ->name('stripe.cancel');
Route::post('/create-cart-order', [PaymentController::class, 'createCartOrders']);
Route::post('/auth-order/create', [OrderController::class, 'createAuthOrder']);

Route::post('/create-product-order', [OrderController::class, 'createGuestOrder']);



Route::post('/subscribe', [ProfileController::class, 'subscribe']);
Route::post('/subscription/create', [ProfileController::class, 'getSubscription']);
Route::post('/subscription/cancel', [ProfileController::class, 'cancelSubscription']);
Route::post('/onesignal/save', [OneSignalController::class, 'save'])
    ->middleware('auth');


Route::get('/admin/login', [AdminWebController::class, 'showLogin'])->name('admin.login');
Route::get('/admin/forgot/form', [AdminWebController::class, 'showforget'])->name('admin.forgot.form');
Route::post('/admin/login/form', [AuthController::class, 'loginAdmin'])->name('admin.login.form');


Route::middleware(['admin'])->group(function () {
Route::post('/admin/order/{id}/refund', [PaymentController::class, 'refund'])
    ->name('admin.order.refund');
Route::post('/update-status/{id}', [OrderController::class, 'updateOrderStatus']);
Route::get('/admin/orders', [AdminWebController::class, 'getOrdersView']);
Route::get('/admin/settings', [AdminWebController::class, 'getSettingsView']);
Route::get('/admin/users', [AdminWebController::class, 'getSusersView']);

Route::get('/admin', [AdminWebController::class, 'getDashboardView']);
Route::get('/admin/add-product', [AdminWebController::class, 'getAddProduct']);
Route::get('/admin/products/{id}/edit', [ProductController::class, 'editPage']);
Route::get('/admin/add-category', [AdminWebController::class, 'getAddCatrgory']);
Route::get('/admin/update-banner', [AdminWebController::class, 'getUpdateBannerView']);
Route::get('/admin/future-products-management', [AdminWebController::class, 'getFutureProducts']);
Route::get('/admin/testimonialmanagement', [AdminWebController::class, 'getTestimonialmanagement']);
Route::get('/admin/deals-management', [AdminWebController::class, 'getDealsManagement']);
Route::get('/admin/blogs-managements', [AdminWebController::class, 'getBlogsManagements']);
});




Route::get('/check-storage', function () {

    return [

        'storage_exists' => file_exists(storage_path('app/public/categories')),

        'public_storage_exists' => file_exists(public_path('storage')),

        'files' => Storage::disk('public')->files('categories'),

    ];

});

Route::post('/change-currency', function (\Illuminate\Http\Request $request) {

    $request->validate([
        'currency' => 'required'
    ]);

    session([
        'currency' => $request->currency
    ]);

    return response()->json([
        'success' => true
    ]);

})->name('change.currency');
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


