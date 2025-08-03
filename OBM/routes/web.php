<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;



Route::get('/', [AuthController::class, 'showAdminLogin'])->name('loginForm');
Route::post('admin/login', [AuthController::class, 'adminLogin'])->name('login');
Route::group(['middleware' => 'admin'], function () {
    Route::get('logout', [AuthController::class, 'adminLogout'])->name('logout');
    Route::get('profile', [AuthController::class, 'showAdminProfile'])->name('profile');
    Route::put('profile', [AuthController::class, 'updateAdminProfile'])->name('updateProfile');
    Route::post('addadmin', [AuthController::class, 'addadmin'])->name('addadmin');
    Route::delete('deleteadmin/{adminid}', [AuthController::class, 'deleteadmin'])->name('deleteadmin');


    Route::get('category', [DashboardController::class, 'category'])->name('category');
    Route::get('editcat/{category}', [DashboardController::class, 'editcat'])->name('editcat');
    Route::post('addcat', [DashboardController::class, 'addcat'])->name('addcat');
    Route::put('updatecat/{category}', [DashboardController::class, 'updatecat'])->name('updatecat');
    Route::get('infocat/{category}', [DashboardController::class, 'infocat'])->name('infocat');

    Route::post('addpro', [DashboardController::class, 'addpro'])->name('addpro');
    Route::get('editpro/{product}', [DashboardController::class, 'editpro'])->name('editpro');
    Route::put('updatepro/{product}', [DashboardController::class, 'updatepro'])->name('updatepro');
    Route::get('infopro/{product}', [DashboardController::class, 'infopro'])->name('infopro');
    Route::post('searchpro', [DashboardController::class, 'searchpro'])->name('searchpro');

    Route::get('sales', [DashboardController::class, 'sales'])->name('sales');
    Route::post('adduser', [AuthController::class, 'adduser'])->name('adduser');
    Route::post('searchuser', [DashboardController::class, 'searchuser'])->name('searchuser');
    Route::get('order/{id}', [DashboardController::class, 'order'])->name('order');
    Route::get('infocatsale/{category}', [DashboardController::class, 'infocatsale'])->name('infocatsale');
    Route::post('completeorder', [DashboardController::class, 'completeorder'])->name('completeorder');
    Route::get('/cart/{ido}', [DashboardController::class, 'cart'])->name('cart');
    Route::get('/infoorder/{ido}', [DashboardController::class, 'infoorder'])->name('infoorder');
    Route::post('finishorder', [DashboardController::class, 'finishorder'])->name('finishorder');

    Route::post('/order-product/{order_id}', [DashboardController::class, 'storeProduct']);
    Route::delete('deleteprofromorder/{product}', [DashboardController::class, 'deleteprofromorder'])->name('deleteprofromorder');
    Route::post('searchpro2', [DashboardController::class, 'searchpro2'])->name('searchpro2');
    Route::delete('deleteorder/{order}', [DashboardController::class, 'deleteorder'])->name('deleteorder');
    Route::get('/infofinishedorder/{ido}', [DashboardController::class, 'infofinishedorder'])->name('infofinishedorder');


    Route::get('partnerships', [DashboardController::class, 'partnerships'])->name('partnerships');
    Route::post('addpartner', [DashboardController::class, 'addpartner'])->name('addpartner');
    Route::get('editpar/{partner}', [DashboardController::class, 'editpar'])->name('editpar');
    Route::delete('deletepar/{partner}', [DashboardController::class, 'deletepar'])->name('deletepar');
    Route::put('updatepar/{partner}', [DashboardController::class, 'updatepar'])->name('updatepar');

    Route::get('purchasing', [DashboardController::class, 'purchasing'])->name('purchasing');
    Route::get('/infopurchase/{ido}', [DashboardController::class, 'infopurchase'])->name('infopurchase');
    Route::get('purchase/{id}', [DashboardController::class, 'purchase'])->name('purchase');
    Route::post('/purchase-product/{purchase_id}', [DashboardController::class, 'storeProduct1']);
    Route::post('addsupplier', [DashboardController::class, 'addsupplier'])->name('addsupplier');
    Route::get('/cartpur/{idp}', [DashboardController::class, 'cartpur'])->name('cartpur');
    Route::delete('deleteitemfrompur/{product}', [DashboardController::class, 'deleteitemfrompur'])->name('deleteitemfrompur');
    Route::delete('deletepur/{order}', [DashboardController::class, 'deletepur'])->name('deletepur');
    Route::post('completepur', [DashboardController::class, 'completepur'])->name('completepur');
    Route::get('/infopurchase/{idp}', [DashboardController::class, 'infopurchase'])->name('infopurchase');

    Route::post('/transactions/store', [DashboardController::class, 'storetransaction'])->name('transactions.store');
    Route::get('/partners/{partner}/reset-profit-wallet', [DashboardController::class, 'resetProfitWallet'])->name('partners.resetProfitWallet');

    Route::get('/products/pdf', [DashboardController::class, 'downloadPDF'])->name('products.pdf');

    Route::get('dashmony', [DashboardController::class, 'dashmony'])->name('dashmony');

});


