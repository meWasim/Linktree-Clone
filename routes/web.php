<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::view('/admin', 'dashboard');
});
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    //Appearance
    Route::get('/appearance', [ThemeController::class, 'appearance'])->name('themes.appearance');
    Route::post('/appearance', [ThemeController::class, 'updateAppearance'])->name('themes.updateAppearance');
    Route::post('/appearance/remove-profile-image', [ThemeController::class, 'removeProfileImage'])->name('user.remove.profile.image');
    
    // add list
    Route::get('/links', [ListingController::class, 'show'])->name('showListing');
    Route::post('/links/create', [ListingController::class, 'create'])->name('createListing');
    Route::post('/links/update', [ListingController::class, 'update'])->name('updateListing');
    Route::post('/links/delete', [ListingController::class, 'delete'])->name('deleteListing');
    Route::post('/links/visiblity', [ListingController::class, 'linksVisibility'])->name('links.visibility');
    Route::post('/links/upload-thumbnail', [ListingController::class, 'uploadThumbnail'])->name('links.uploadThumbnail');
    Route::post('/links/remove-thumbnail', [ListingController::class, 'removeThumbnail'])->name('links.removeThumbnail');
    
    //social links
    Route::get('/settings', [ListingController::class, 'showLinks'])->name('showLink');
    Route::post('/update-link', [ListingController::class, 'updateLinks'])->name('updateLink');
    Route::post('/delete-link', [ListingController::class, 'deleteLink'])->name('deleteLink');

    Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('setTheme');
    Route::post('/set-custom-theme', [ThemeController::class, 'setCustomTheme'])->name('customTheme');

    Route::post('/generate-qrcode', [ProfileController::class, 'generateQrCode'])->name('generate.qrcode');
});

Route::get('/{urlSlug?}', [ThemeController::class, 'index'])->name('index');
Route::get('/test/best', [ProfileController::class, 'testbest'])->name('testbest');
Route::get('/test/next', [ProfileController::class, 'testnext'])->name('testnext');

