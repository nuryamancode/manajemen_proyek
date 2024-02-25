<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerifikasi;
use App\Http\Controllers\Auth\ForgetPassword;
use App\Http\Controllers\Auth\RegisterAccountHD\RegisterController;
use App\Http\Controllers\Auth\ResetPassword;
use App\Http\Controllers\Direktur\DirekturController;
use App\Http\Controllers\Direktur\KalenderProyekController;
use App\Http\Controllers\Direktur\KlienController;
use App\Http\Controllers\Direktur\KuisionerController;
use App\Http\Controllers\Direktur\ManajemenProyekController;
use App\Http\Controllers\Direktur\TugasKaryawanController;
use App\Http\Controllers\General\GeneralController;
use App\Http\Controllers\HR\DataKaryawanController;
use App\Http\Controllers\HR\HRController;
use App\Http\Controllers\HR\ManageUserController;
use App\Http\Controllers\HR\PenilaianController;
use App\Http\Controllers\Karyawan\DaftarTugasController;
use App\Http\Controllers\Karyawan\KaryawanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/maintenance', function () {
    return view('errors.maintenance');
})->middleware('web')->name('maintenance');

Route::middleware(['guest', 'web'])->group(function () {
    Route::get('/', [AuthController::class, 'home'])->name('home');
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'proses_register'])->name('register.create');

    // Account HR & Direktur
    Route::get('/backoffice-register-hr', [RegisterController::class, 'index'])->name('register.account.hr');
    Route::get('/backoffice-register-direktur', [RegisterController::class, 'index2'])->name('register.account.direktur');
    Route::post('/backoffice-register', [RegisterController::class, 'register'])->name('register.send');
    // Account HR & Direktur End

    Route::get('/forget-password', [ForgetPassword::class, 'index'])->name('password.request');
    Route::post('/forget-password', [ForgetPassword::class, 'forget_password_send'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPassword::class, 'index'])->name('password.reset');
    Route::post('/reset-password', [ResetPassword::class, 'reset_password'])->name('password.update');
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/email/verify', [EmailVerifikasi::class, 'index'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerifikasi::class, 'handler_verification'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerifikasi::class, 'resend_email'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'Human Resource') {
            return redirect('/hr');
        } elseif (Auth::user()->role == 'Direktur') {
            return redirect('/direktur');
        } elseif (Auth::user()->role == 'Karyawan') {
            return redirect('/karyawann');
        } else {
            Auth::logout();
            return redirect('/');
        }
    }
})->middleware('web');


Route::middleware(['auth', 'permissions:Karyawan', 'web', 'verified',])->prefix('/karyawann')->name('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index'])->name('.dashboard');
    Route::get('/profil', [KaryawanController::class, 'profil_karyawan'])->name('.profil');
    Route::post('/profil', [KaryawanController::class, 'save_profil_karyawan'])->name('.save.profil');
    Route::put('/profil', [KaryawanController::class, 'update_profil_karyawan'])->name('.update.profil');
    Route::get('/notifikasi', [KaryawanController::class, 'notifikasi'])->name('.notifikasi');
    Route::get('/editprofil', [KaryawanController::class, 'edit_profil_karyawan'])->name('.edit.profil');
    Route::get('/daftartugas', [DaftarTugasController::class, 'index'])->name('.daftartugas');
    Route::get('/daftartugas/detail/{id_tugas}', [DaftarTugasController::class, 'detail_daftar_tugas'])->name('.detail.daftartugas');
    Route::put('/daftartugas/upload/{id_tugas}', [DaftarTugasController::class, 'upload_berkas'])->name('.upload.daftartugas');
    Route::get('/tugas-selesai', [DaftarTugasController::class, 'daftar_tugas_selesai'])->name('.tugas-selesai');
    Route::get('/tugas-selesai/detail/{id_tugas}', [DaftarTugasController::class, 'detail_daftar_tugas_selesai'])->name('.detail.tugas-selesai');
    // Download
    Route::get('/daftartugas/download/{upload_berkas}', [GeneralController::class, 'download_hasil_proyek'])->name('.download.daftartugas');
    Route::get('/proyek/download/{berkas}', [GeneralController::class, 'download_berkas_proyek'])->name('.download.proyek');

    // Notifikasi
    Route::get('/baca-notifikasi/{id_notifikasi}', [GeneralController::class, 'dibaca'])->name('.baca.notifikasi');
    Route::delete('/hapussemua-notifikasi', [GeneralController::class, 'hapusSemuanotifikasi'])->name('.hapus.notifikasi');
});



Route::middleware(['auth', 'permissions:Direktur', 'web'])->prefix('/direktur')->name('direktur')->group(function () {
    // get
    Route::get('/', [DirekturController::class, 'index'])->name('.dashboard');
    Route::get('/edit-profil', [DirekturController::class, 'edit_profil_direktur'])->name('.edit.profil');
    Route::get('/profil', [DirekturController::class, 'profil_direktur'])->name('.profil');
    Route::get('/notifikasi', [DirekturController::class, 'notifikasi'])->name('.notifikasi');
    Route::get('/klien', [KlienController::class, 'index'])->name('.klien');
    Route::get('/klien/{klien}/delete', [KlienController::class, 'delete_klien'])->name('.delete.klien');
    Route::get('/proyek', [ManajemenProyekController::class, 'index'])->name('.proyek');
    Route::get('/proyek/{proyek}/delete', [ManajemenProyekController::class, 'delete_proyek'])->name('.delete.proyek');
    Route::get('/proyek/{id_proyek}', [ManajemenProyekController::class, 'detail_proyek'])->name('.detail.proyek');
    Route::get('/laporan-selesai', [ManajemenProyekController::class, 'laporan'])->name('.laporan.selesai');
    Route::get('/kalender-proyek', [KalenderProyekController::class, '__invoke'])->name('.kalender.proyek');
    Route::get('/kalender-proyek/delete/{calendar}', [KalenderProyekController::class, 'delete_data'])->name('.delete.acara');
    Route::get('/kuisioner-karyawan/kuisioner/{tugas_id}', [KuisionerController::class, 'kuisioner'])->name('.kuisioner');
    Route::get('/status/inprogress/proyek', [ManajemenProyekController::class, 'proses_proyek'])->name('.inprogress.proyek');
    Route::get('/status/done/proyek', [ManajemenProyekController::class, 'done_proyek'])->name('.done.proyek');
    Route::get('/status/revisi/proyek', [ManajemenProyekController::class, 'revisi_proyek'])->name('.revisi.proyek');
    Route::get('/proyek/download/{berkas}', [GeneralController::class, 'download_berkas_proyek'])->name('.download.proyek');
    Route::get('/tugas/download/{uploadberkas}', [GeneralController::class, 'download_hasil_proyek'])->name('.download.tugas');
    Route::get('/baca-notifikasi/{id_notifikasi}', [GeneralController::class, 'dibaca'])->name('.baca.notifikasi');
    Route::get('/tugas/{id_proyek}', [TugasKaryawanController::class, 'tugas'])->name('.tugas');
    Route::get('/tugas/hapus/{tugas}', [TugasKaryawanController::class, 'hapus_tugas'])->name('.hapus.tugas');

    // get


    // post
    Route::post('/klien', [KlienController::class, 'save_klien'])->name('.save.klien');
    Route::post('/proyek', [ManajemenProyekController::class, 'save_proyek'])->name('.save.proyek');
    Route::post('/tugas/fase', [TugasKaryawanController::class, 'simpan_fase'])->name('.save.fase');
    Route::post('/tugas/tambah', [TugasKaryawanController::class, 'tambah_tugas'])->name('.tambah.tugas');
    Route::post('/tampil/tugas', [TugasKaryawanController::class, 'tampilkanDataTugas'])->name('.tampil.tugas');
    Route::post('/kalender-proyek', [KalenderProyekController::class, 'save_data'])->name('.save.acara');
    Route::post('/kuisioner-karyawan/kuisioner/add', [KuisionerController::class, 'hitung_jumlah_kuisioner'])->name('.hitung.kuisioner');
    Route::post('/tugas/{id_proyek}', [TugasKaryawanController::class, 'tugas'])->name('.tugas.submit');
    // post


    // put
    Route::put('/edit-profil', [DirekturController::class, 'update_profil_direktur'])->name('.update.profil');
    Route::put('/klien/{id_klien}', [KlienController::class, 'update_klien'])->name('.update.klien');
    Route::put('/proyek/{id_proyek}', [ManajemenProyekController::class, 'update_proyek'])->name('.update.proyek');
    Route::put('/kalender-proyek/{id_calendar}', [KalenderProyekController::class, 'update_data'])->name('.update.acara');
    Route::put('/status/done/proyek/{id_proyek}', [TugasKaryawanController::class, 'proses_lanjutan_selesai'])->name('.proses.done.proyek');
    Route::put('/status/reject/proyek/{id_proyek}', [TugasKaryawanController::class, 'proses_lanjutan_belumselesai'])->name('.proses.reject.proyek');
    Route::put('/status/review/proyek/{id_tugas}', [TugasKaryawanController::class, 'lihat_tugas'])->name('.proses.review.proyek');
    Route::put('/tugas/{id_proyek}', [TugasKaryawanController::class, 'edit_tugas'])->name('.edit.tugas');
    Route::put('/tugas/selesai/{id_tugas}', [TugasKaryawanController::class, 'tugas_selesai'])->name('.tugas.selesai');
    Route::put('/tugas/belumselesai/{id_tugas}', [TugasKaryawanController::class, 'tugas_belumselesai'])->name('.tugas.belum.selesai');
    Route::put('/proyek/selesai/{proyek_id}', [ManajemenProyekController::class, 'button_proyek_selesai'])->name('.button.proyek.selesai');




    // put

    // delete
    Route::delete('/hapussemua-notifikasi', [GeneralController::class, 'hapusSemuanotifikasi'])->name('.hapus.notifikasi');
    // delete
});





Route::middleware(['auth', 'permissions:Human Resource', 'web'])->prefix('/hr')->name('hr')->group(function () {
    Route::get('/', [HRController::class, 'index'])->name('.dashboard');
    Route::get('/profil', [HRController::class, 'profil_hr'])->name('.profilku');
    Route::post('/profil', [HRController::class, 'ganti_password'])->name('.gantipassword');
    Route::get('/edit-profil', [HRController::class, 'edit_profil_hr'])->name('.edit.profilku');
    Route::put('/profil', [HRController::class, 'update_profil_hr'])->name('.update.profiilku');
    Route::get('/manageuser', [ManageUserController::class, 'manage_user'])->name('.manageuser');
    Route::post('/manageuser', [ManageUserController::class, 'save_data_user'])->name('.manageuser.create');
    Route::put('/manageuser/{id}', [ManageUserController::class, 'update_data_user'])->name('.manageuser.edit');
    Route::get('/manageuser/{user}/delete', [ManageUserController::class, 'delete_data_user'])->name('.manageuser.delete');
    Route::get('/data-karyawan', [DataKaryawanController::class, 'index'])->name('.datakaryawan');
    Route::get('/data-karyawan/{id}', [DataKaryawanController::class, 'delete_data_karyawan'])->name('.datakaryawan.delete');
    Route::get('/data-bidang', [DataKaryawanController::class, 'bidang'])->name('.bidang');
    Route::post('/data-bidang', [DataKaryawanController::class, 'save_bidang'])->name('.save.bidang');
    Route::put('/data-bidang/update/{id_bidang}', [DataKaryawanController::class, 'update_bidang'])->name('.update.bidang');
    Route::get('/data-bidang/delete/{bidang}', [DataKaryawanController::class, 'delete_bidang'])->name('.delete.bidang');
    Route::put('/data-karyawan/add/{id_karyawan}', [DataKaryawanController::class, 'tambah_bidang'])->name('.add.bidang');
    Route::get('/kriteria', [PenilaianController::class, 'kriteria'])->name('.kriteria');
    Route::post('/kriteria/add', [PenilaianController::class, 'add_data_kriteria'])->name('.add.kriteria');
    Route::put('/kriteria/update/{id_kriteria}', [PenilaianController::class, 'update_data_kriteria'])->name('.update.kriteria');
    Route::get('/kriteria/delete/{kriteria}', [PenilaianController::class, 'delete_data_kriteria'])->name('.delete.kriteria');
    Route::get('/sub-kriteria', [PenilaianController::class, 'sub_kriteria'])->name('.sub.kriteria');
    Route::post('/sub-kriteria/add', [PenilaianController::class, 'add_data_sub'])->name('.add.sub.kriteria');
    Route::get('/sub-kriteria/add', [PenilaianController::class, 'add_sub_view'])->name('.add.sub.view');
    Route::put('/sub-kriteria/update/{id_subkriteria}', [PenilaianController::class, 'update_data_sub'])->name('.update.sub.kriteria');
    Route::get('/sub-kriteria/delete/{subKriteria}', [PenilaianController::class, 'delete_data_sub'])->name('.delete.sub.kriteria');
});
