<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PelunasanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanPetugasController;
use App\Http\Controllers\LaporanSiswaController;
use App\Http\Controllers\LaporanSPPController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\TelegramController;
use App\Models\Siswa;

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


Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'index'])->name('profile.edit');
    // Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::resource('profile', ProfileController::class);
    Route::resource('profile', ProfileController::class)->parameters([
        'profile' => 'user',
    ]);

    // Dashboard
    Route::get('/', function () {
        return to_route('dashboard');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('filter-dashboard',[DashboardController::class, 'filterData'])->name('dashboard.filter')->middleware('role:Petugas|KepalaSekolah');



    Route::group(['middleware' => ['role:Petugas']], function () {
    // Siswa
        Route::resource('siswa', SiswaController::class);
        Route::get('export-siswa', [SiswaController::class, 'export'])->name('siswa.export');
        Route::get('print-siswa', [SiswaController::class, 'print'])->name('siswa.print');
        Route::post('import', [SiswaController::class, 'import'])->name('siswa.import');
        Route::post('filter-siswa', [SiswaController::class, 'filter'])->name('siswa.filter');

        // Telegram
        Route::post('siswa/update_chatid', [TelegramController::class, 'updateChatId'])->name('siswa.update_chatid');

        Route::get('/send_tagihan', [TelegramController::class, 'send_tagihan']);
        Route::get('/invoice', function () {
            return view('invoice_template');
        });
        // Telegram



        // Tagihan
        Route::resource('tagihan', TagihanController::class);
        Route::post('filter-tagihan', [TagihanController::class, 'filter'])->name('tagihan.filter');
        Route::get('export-tagihan', [TagihanController::class, 'export'])->name('tagihan.export');
        Route::post('import-tagihan', [TagihanController::class, 'import'])->name('tagihan.import');
        Route::get('/{tagihan}/kirim-invoice', [TagihanController::class, 'sendInvoice'])->name('tagihan.sendInvoice');
        Route::get('print-tagihan', [TagihanController::class, 'print'])->name('tagihan.print');

        // Biaya
        Route::resource('biaya', BiayaController::class);
        Route::post('filter-biaya', [BiayaController::class, 'filter'])->name('biaya.filter');

        // Pembayaran
        Route::resource('pembayaran', PembayaranController::class);
        Route::get('pembayaran/verifikasi/{id}', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::post('pembayaran/kuitansi/{id}', [PembayaranController::class, 'kirimKuitansi'])->name('pembayaran.kuitansi');
        Route::post('filter-pembayaran', [PembayaranController::class, 'filter'])->name('pembayaran.filter');

        // New
        Route::post('pembayaran/lebih/{id}', [PembayaranController::class, 'lebih'])->name('lebih');
        Route::post('pembayaran/kurang/{id}', [PembayaranController::class, 'kurang'])->name('kurang');
        // tambahan


        // Laporan Petugas


        Route::resource('petugas', PetugasController::class)->parameters([
            'petugas' => 'petugas'
        ]);
        Route::post('filter-agama-petugas', [PetugasController::class, 'filterAgama'])->name('petugas.filterAgama');
    });


    Route::middleware(['role:KepalaSekolah|Petugas'])->group(function () {
        Route::get('laporan-petugas', [LaporanPetugasController::class, 'index'])->name('laporanPetugas.index');
        Route::get('laporan-petugas/create', [LaporanPetugasController::class, 'create'])->name('laporanPetugas.create');
        Route::get('laporan-petugas/{petugas}', [LaporanPetugasController::class, 'show'])->name('laporanPetugas.show');
        Route::post('filter-laporan-petugas', [LaporanPetugasController::class, 'filter'])->name('laporanPetugas.filter');
        Route::get('laporan-siswa', [LaporanSiswaController::class, 'index'])->name('laporanSiswa.index');
        Route::get('laporan-siswa/create', [laporanSiswaController::class, 'create'])->name('laporanSiswa.create');
        Route::get('laporan-siswa/{laporan_siswa}', [laporanSiswaController::class, 'show'])->name('laporanSiswa.show');
        Route::post('filter-laporan-siswa', [laporanSiswaController::class, 'filter'])->name('laporanSiswa.filter');

        // Laporan SPP
        Route::get('laporan-spp', [LaporanSPPController::class, 'index'])->name('laporanSpp.index');
        Route::get('laporan-spp/create', [LaporanSPPController::class, 'create'])->name('laporanSpp.create');
        Route::post('filter-laporan-spp', [LaporanSPPController::class, 'filter'])->name('laporanSpp.filter');
        Route::get('laporan-spp/export', [LaporanSPPController::class, 'export'])->name('laporanSpp.export');
        Route::get('laporan-spp/print', [LaporanSPPController::class, 'print'])->name('laporanSpp.print');
        Route::get('laporan-spp/{laporan_spp}', [LaporanSPPController::class, 'show'])->name('laporanSpp.show');
        Route::post('laporan-spp/import', [LaporanSPPController::class, 'import'])->name('laporanSpp.import');
        Route::post('filter-laporan-spp', [LaporanSPPController::class, 'filter'])->name('laporanSpp.filter');
    });


    // Laporan Siswa



    // Petugas



    // Orang Tua
    Route::get('pelunasan/{id}', [PelunasanController::class, 'tagihan'])->name('pelunasan.tagihan');
    Route::post('lunasi/{id}', [PelunasanController::class, 'lunasi'])->name('pelunasan.lunasi');
    Route::get('detail-pelunasan/{id}', [PelunasanController::class, 'detailTagihan'])->name('pelunasan.detailTagihan');
    Route::get('ortu/pembayaran', [OrangTuaController::class, 'pembayaran'])->name('ortu.pembayaran');
    Route::get('ortu/pembayaran/{pembayaran}', [OrangTuaController::class, 'show'])->name('ortu.pembayaran.show');
    Route::get('ortu/riwayat-pembayaran', [OrangTuaController::class, 'riwayatPembayaran'])->name('ortu.riwayatPembayaran');
    Route::get('ortu/riwayat-pembayaran/{pembayaran}', [OrangTuaController::class, 'showRiwayatPembayaran'])->name('ortu.show.riwayatPembayaran');

    Route::view('print', 'admin.tagihan.tagihan-invoice-print');
    Route::post('filter-riwayat-pembayaran', [OrangTuaController::class, 'filterRiwayatPembayaran'])->name('ortu.filterRiwayatPembayaran');
    Route::post('filter-status-pembayaran', [OrangTuaController::class, 'filterStatusPembayaran'])->name('ortu.filterStatusPembayaran');

    Route::get('lihat-kuitansi/{tagihan}', [TagihanController::class, 'lihatKuitansi'])->name('tagihan.lihatKuitansi');
    Route::get('download-kuitansi/{tagihan}', [TagihanController::class, 'downloadKuitansi'])->name('tagihan.downloadKuitansi');
    Route::post('validasi-lebih', [OrangTuaController::class, 'validasi'])->name('validasi.lebih');

});


require __DIR__ . '/auth.php';
