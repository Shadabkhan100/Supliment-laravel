<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WebRoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\BlogsController;

Route::get('/', [WebRoutController::class, 'getHome']);
Route::get('/railway-test', function () {
    return 'LATEST VERSION 999';
});
Route::get('/about-us', [WebRoutController::class, 'aboutUsView']);
Route::get('/faq', [WebRoutController::class, 'faqView']);
Route::get('/return-policy', [WebRoutController::class, 'returnView']);
Route::get('/shop/{slug}/{id}', [WebRoutController::class, 'shopDetails']);
Route::get('/contact', [WebRoutController::class, 'contactView']);


Route::get('/find-product/{slug}/{id}', [WebRoutController::class, 'getFindProducts']);
Route::get('/all-blogs', [WebRoutController::class, 'getAllBlogs']);
Route::get('/blog-details/{slug}/{id}', [BlogsController::class, 'blogsDetailsView']);
Route::get('/product-details/{slug}/{id}', [WebRoutController::class, 'getProductDetails']);





Route::get('/shipping-cost', [WebRoutController::class, 'shippingCost'])->name('shipping.cost');
Route::get('/30-days-guarantee', [WebRoutController::class, 'thirtyDaysGuarantee'])->name('guarantee.30days');
Route::get('/privacy-policy', [WebRoutController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/search-product/{tag}', [WebRoutController::class, 'searchByTag']);



Route::get('/admin', [AdminWebController::class, 'getDashboardView']);
Route::get('/admin/add-product', [AdminWebController::class, 'getAddProduct']);
Route::get('/admin/products/{id}/edit', [ProductController::class, 'editPage']);
Route::get('/admin/add-category', [AdminWebController::class, 'getAddCatrgory']);
Route::get('/admin/update-banner', [AdminWebController::class, 'getUpdateBannerView']);
Route::get('/admin/future-products-management', [AdminWebController::class, 'getFutureProducts']);
Route::get('/admin/testimonialmanagement', [AdminWebController::class, 'getTestimonialmanagement']);
Route::get('/admin/deals-management', [AdminWebController::class, 'getDealsManagement']);
Route::get('/admin/blogs-managements', [AdminWebController::class, 'getBlogsManagements']);

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