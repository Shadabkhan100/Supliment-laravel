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
use App\Http\Controllers\PageSettingController;
use App\Http\Controllers\BundleOrders;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FutureProductController;
use App\Http\Controllers\TestimonialsController;


Route::get('/test-promotion-mail', function () {
    try {

        $promotionText = 'TEST PROMOTION - 50% OFF';

        Mail::to('shakdabkhan@gmail.com')->send(
            new \App\Mail\PromotionMail(
                $promotionText
            )
        );

        return response()->json([
            'status' => true,
            'message' => 'Promotion email sent successfully.',
            'recipient' => 'shakdabkhan@gmail.com',
            'promotion_text' => $promotionText
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'status' => false,
            'message' => 'Promotion email sending failed.',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }

});
Route::get('/', [WebRoutController::class, 'getHome']);
Route::get('/railway-test', function () {
    return 'LATEST VERSION 999';
});
Route::get('/cookie-check', function () {
   dd(request()->cookie('guest_id'));
});






Route::get('/reset-password', [AuthController::class, 'resetPasswordView'])
    ->name('reset.password');

Route::post('/reset-password/send-otp', [AuthController::class, 'sendResetOtp'])
    ->name('reset.password.send.otp');

Route::post('/reset-password/verify-otp', [AuthController::class, 'verifyResetOtp'])
    ->name('reset.password.verify.otp');

Route::post('/reset-password/update', [AuthController::class, 'updateResetPassword'])
    ->name('reset.password.update');





Route::get('/login', [WebRoutController::class, 'authPage']);
Route::get('/profile', [ProfileController::class, 'getProfileView']);
Route::get('/profile/guest-profile', [WebRoutController::class, 'getGuestProfileView']);
Route::get('/delete-user', [AuthController::class,'deleteUser']);
Route::post('/signup-user', [AuthController::class,'registerUser']);
Route::post('/login', [AuthController::class, 'LoginUser'])->name('login');
Route::get('/logout', [AuthController::class, 'logoutUser']);
Route::get('/ensure-guest-id', [OrderController::class, 'ensureGuestId']);
Route::get('/shipping-cost', [WebRoutController::class, 'shippingCost'])->name('shipping.cost');
Route::get('/30-days-guarantee', [WebRoutController::class, 'thirtyDaysGuarantee'])->name('guarantee.30days');
Route::get('/privacy-policy', [WebRoutController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/search-product/{tag}', [WebRoutController::class, 'searchByTag']);
Route::get('/search-reasult', [WebRoutController::class, 'searchResult']);

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
Route::get('/make-your-own-offer', [WebRoutController::class, 'mixMatchView']);
Route::post('/post-comment/contact', [ContactController::class, 'postComment'])
    ->name('post-comment.contact');
Route::post('/cart/add', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'cartView']);
Route::get('/cart/count', [CartController::class, 'count']);
Route::post('/cart-items/updates/{cartId}/{status}', [CartController::class, 'updateCartItemQuantity'])
    ->name('cart.items.update.quantity');
Route::get('/stripe/checkout', [PaymentController::class, 'checkout'])
    ->name('stripe.checkout');
Route::get('/stripe/success', [PaymentController::class, 'success'])
    ->name('stripe.success');
Route::get('/stripe/cancel', [PaymentController::class, 'cancel'])
    ->name('stripe.cancel');
Route::post('/create-cart-order', [PaymentController::class, 'createCartOrders']);
Route::post('/auth-order/create', [OrderController::class, 'createAuthOrder']);
Route::post('/user/use-promo/{code}', [OrderController::class, 'usePromo']);
Route::post('/order/bundle-order/create', [BundleOrders::class, 'createBundleOrder']);
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
Route::delete('/admin/users/{id}', [AdminWebController::class, 'deleteUser'])
    ->name('admin.users.delete');

Route::post(
    '/testimonials/edit/{id}',
    [TestimonialsController::class, 'update']
)->name('testimonials.update');
Route::post('/future-product/edit/{id}', [FutureProductController::class, 'update'])
    ->name('future-product.update');
Route::get('/admin/messages', [AdminWebController::class, 'getContactMessages']);
Route::delete(
    '/user-contact/message-delete/{id}',
    [AdminWebController::class, 'messageDelete']
)->name('user-contact.message-delete');
Route::post(
    '/admin/bundle-status/update/{id}/{status}',
    [AdminWebController::class, 'updateStatus']
);
Route::get('delete/admin/{id}', [AdminWebController::class, 'deleteAdmin']);
Route::post('/admin/web-setting/add', [PageSettingController::class, 'webSettingUpdate'])
    ->name('admin.web-setting.add');
Route::post('/admin/order/{id}/refund', [PaymentController::class, 'refund'])
    ->name('admin.order.refund');
Route::post('/update-status/{id}', [OrderController::class, 'updateOrderStatus']);
Route::get('/admin/orders', [AdminWebController::class, 'getOrdersView']);
Route::get('/admin/settings', [AdminWebController::class, 'getSettingsView']);
Route::get('/admin/users', [AdminWebController::class, 'getUsersView']);
Route::get('/admin', [AdminWebController::class, 'getDashboardView']);
Route::get('/admin/add-product', [AdminWebController::class, 'getAddProduct']);
Route::get('/admin/bundle-orders', [AdminWebController::class, 'getBundleView']);
Route::get('/admin/products/{id}/edit', [AdminWebController::class, 'editPage']);
Route::post('/product/pack/add/{p_id}', [AdminWebController::class, 'addProductPack']);
Route::post('/product/pack/delete/{p_id}/{index}', [AdminWebController::class, 'deleteProductPack']);
Route::post('/product/pack/update/{p_id}/{index}', [AdminWebController::class, 'updateProductPack']);
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


