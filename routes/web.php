
<?php

use App\Http\Controllers\RawatInapController;
use App\Http\Controllers\RawatJalanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForecastingController;
use App\Http\Controllers\PenggunaController;
use App\Models\RawatInap;
use App\Models\RawatJalan;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Hapus bagian ->middleware(['isLogin', ...])
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/rawatinap', [RawatInapController::class, 'index']);
Route::get('/rawatinap/tambah', [RawatInapController::class, 'create']);
Route::post('/rawatinap/store', [RawatInapController::class, 'store']);
Route::get('/rawatinap/edit/{id}', [RawatInapController::class, 'edit']);
Route::put('/rawatinap/update/{id}', [RawatInapController::class, 'update']);
Route::post('/rawatinap/import', [RawatInapController::class, 'import']);
Route::get('/rawatinap/hapus/{id}', [RawatInapController::class, 'hapus']);

Route::get('/rawatjalan', [RawatJalanController::class, 'index']);
Route::get('/rawatjalan/tambah', [RawatJalanController::class, 'create']);
Route::post('/rawatjalan/store', [RawatJalanController::class, 'store']);
Route::get('/rawatjalan/edit/{id}', [RawatJalanController::class, 'edit']);
Route::put('/rawatjalan/update/{id}', [RawatJalanController::class, 'update']);
Route::post('/rawatjalan/import', [RawatJalanController::class, 'import']);
Route::get('/rawatjalan/hapus/{id}', [RawatJalanController::class, 'hapus']);

Route::get('forecasting', [ForecastingController::class, 'index'])->name('forecasting');
Route::post('/forecasting', [ForecastingController::class, 'trendMoment'])->name('tmforecasting');

Route::get('/pengguna', [PenggunaController::class, 'index']);

Route::get('/get-years/{item}', function ($item) {
    if ($item == 'rawat_inap') {
        $years = RawatInap::select('tahun')->groupBy('tahun')->get();
    } elseif ($item == 'rawat_jalan') {
        $years = RawatJalan::select('tahun')->groupBy('tahun')->get();
    } else {
        $years = collect();
    }
    return response()->json(['years' => $years]);
});
