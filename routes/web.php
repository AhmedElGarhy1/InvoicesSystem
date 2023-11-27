<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\Invoices\InvoicesController;
use App\Http\Controllers\Invoices\InvoicesArchiveController;
use App\Http\Controllers\Invoices\InvoicesDetailsController;
use App\Http\Controllers\Invoices\InvoicesAttachmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// check status

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// Route::get('/{page}', 'AdminController@index');

// invoices
Route::prefix('invoices')->group(function () {
    Route::get('/list', [InvoicesController::class, 'index'])->name('invoiceslist');
    Route::get('/add', [InvoicesController::class, 'create'])->name('invoicesadd');
    Route::get('/product/{id}', [InvoicesController::class, 'getproduct'])->name('invoiceproduct');
    Route::post('/store', [InvoicesController::class, 'store'])->name('invoicestore');
    Route::post('/destory', [InvoicesController::class, 'destory'])->name('destoryinvoice');

    // update invoices
    Route::get('/edit/{id}', [InvoicesController::class, 'edit'])->name('incoiceedit');
    Route::post('/update/{id}', [InvoicesController::class, 'update'])->name('invoiceupdate');
    Route::get('/edit/form/state/{id}', [InvoicesController::class, 'stateedit'])->name('stateedit');
    Route::post('/update/state/{id}', [InvoicesController::class, 'stateupdate'])->name('stateupdate');

    // invoices details
    Route::get('/details/{id}', [InvoicesDetailsController::class, 'index'])->name('invoicedetails');
    Route::post('/delete', [InvoicesDetailsController::class, 'destroy'])->name('invoicedelete');
    Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'viewfile'])->name('invoiceview');

    // download
    Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'download'])->name('invoicedownload');

    // invoices attachment
    Route::post('/add/new/attachment', [InvoicesAttachmentController::class, 'addattachment'])->name('addattachment');

    // payment state
    Route::prefix('for')->group(function () {
        Route::get('/state1', [InvoicesController::class, 'invoicepaid'])->name('invoicforstate1');
        Route::get('/state2', [InvoicesController::class, 'invoiceunpaid'])->name('invoicforstate2');
        Route::get('/state3', [InvoicesController::class, 'invoicepartpaid'])->name('invoicforstate3');
    });

    // archive invoice
    Route::prefix('archave')->group(function () {
        Route::get('/', [InvoicesArchiveController::class, 'index'])->name('arachaeinvoices');
        Route::post('/form', [InvoicesArchiveController::class, 'archiveinvoices'])->name('arachaeinvoicesform');
        Route::post('/restore', [InvoicesArchiveController::class, 'restoreinvoice'])->name('restoreinvoice');
        Route::post('/delete', [InvoicesArchiveController::class, 'destorearachive'])->name('archaveinvoicedelete');
    });

    // print invoice
    Route::get('/Print/{id}',[InvoicesController::class,'PrintInvoice'])->name('invoiceprint');

});

// sections
Route::prefix('sections')->group(function () {
    Route::get('/list', [SectionsController::class, 'index'])->name('sectionslist');
    Route::post('/store', [SectionsController::class, 'store'])->name('sectionstore');
    Route::get('/edit/{id}', [SectionsController::class, 'edit'])->name('sectionedit');
    Route::post('/update/{id}', [SectionsController::class, 'update'])->name('sectionupdate');
    Route::post('/delete', [SectionsController::class, 'destroy'])->name('sectiondelete');
});

// products
Route::prefix('product')->group(function () {
    Route::get('/list', [ProductController::class, 'index'])->name('productlist');
    Route::post('/store', [ProductController::class, 'store'])->name('productstore');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('productedit');
    Route::post('/update/{id}', [ProductController::class, 'update'])->name('productupdate');
    Route::post('/delete', [ProductController::class, 'destroy'])->name('productdelete');
});



Route::group(['middleware' => ['auth']], function () {
    // roles
    Route::prefix('roles')->group(function () {
        Route::get('/index', [RoleController::class, 'index'])->name('listroles');
        Route::get('/add', [RoleController::class, 'create'])->name('addroles');
        Route::post('/store', [RoleController::class, 'store'])->name('storeroles');
        Route::get('/show/{id}', [RoleController::class, 'show'])->name('showrole');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('editroles');
        Route::PATCH('/update/{id}', [RoleController::class, 'update'])->name('updateroles');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('deleteroles');
    });
    // users
    Route::prefix('users')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('listusers');
        Route::get('/add', [UserController::class, 'create'])->name('addusers');
        Route::post('/store', [UserController::class, 'store'])->name('storeusers');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('showuser');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('editusers');
        Route::PATCH('/update/{id}', [UserController::class, 'update'])->name('updateusers');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('deleteusers');
    });
});
