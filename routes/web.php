<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReimbursmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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

use App\Models\NotifM;
use App\Events\NewNotification;

Route::get('/test-notif', function () {
    $notif = NotifM::create([
        'title' => 'Notifikasi Test',
        'value' => 'Ini adalah notifikasi percobaan untuk staff keuangan.',
        'status' => 0,
        'pengirim' => auth()->id(), // atau ID tertentu
    ]);

    event(new NewNotification($notif)); // Kirim via broadcast

    return back()->with('success', 'Notifikasi test berhasil dikirim!');
});

Auth::routes();

// Route::get('test', function () {
//     try {
//         Mail::to('c9Xb4@example.com')->send(new \App\Mail\SendMail(['name' => 'test']));
//         dd('Berhasil kekirim');
//     } catch (\Throwable $th) {
//         //throw $th;
//         dd($th->getMessage());

//         Log::error($th->getMessage());
//     }
// });

// admin
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/get-data', [DashboardController::class, 'getData'])->name('get-data-ajax');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('reimbursment/pembayaran/{id}', [ReimbursmentController::class, 'pembayaran'])->name('reimbursment.pembayaran');
    Route::patch('reimbursment/pembayaran/{id}', [ReimbursmentController::class, 'proses_pembayaran'])->name('reimbursment.proses-pembayaran');
    // role staff keuangna
    Route::middleware('cek_role:staff keuangan')->group(function () {
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('jabatan', JabatanController::class)->except('show');
        Route::resource('department', DepartmentController::class)->except('show');
        Route::resource('kategori', KategoriController::class)->except('show');
        Route::resource('anggaran', AnggaranController::class)->except('show');

        Route::post('reimbursment/tolak/{id}', [ReimbursmentController::class, 'set_tolak'])->name('reimbursment.tolak');
        Route::post('reimbursment/setujui/{id}', [ReimbursmentController::class, 'set_setujui'])->name('reimbursment.setujui');

        Route::get('laporan/reimbursment', [LaporanController::class, 'index'])->name('laporan.reimbursment');
        Route::post('laporan/reimbursment', [LaporanController::class, 'print'])->name('laporan.reimbursment.print');
    });

    Route::middleware('cek_role:staff umum')->group(function () {
        Route::get('reimbursment/pengajuan', [ReimbursmentController::class, 'pengajuan'])->name('reimbursment.pengajuan');
        Route::post('reimbursment/pengajuan', [ReimbursmentController::class, 'proses_pengajuan'])->name('reimbursment.proses-pengajuan');
    });
    Route::resource('reimbursment', ReimbursmentController::class);
});
