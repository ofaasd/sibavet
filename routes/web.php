<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Import all your controllers here
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\MasterData\SubSatuanKerjaController;
use App\Http\Controllers\MasterData\SpesiesController;
use App\Http\Controllers\MasterData\RasController;
use App\Http\Controllers\MasterData\JenisContohController;
use App\Http\Controllers\MasterData\BentukContohController;
use App\Http\Controllers\MasterData\SeksiLaboratoriumController;
use App\Http\Controllers\MasterData\JenisPengujianController;
use App\Http\Controllers\MasterData\CustomerController;
use App\Http\Controllers\MasterData\AsalHewanController;
use App\Http\Controllers\MasterData\PemeriksaController;
use App\Http\Controllers\MasterData\PemilikController;
use App\Http\Controllers\MasterData\PenyakitController;
use App\Http\Controllers\MasterData\ObatController;
use App\Http\Controllers\MasterData\DaftarHargaController;
use App\Http\Controllers\MasterData\OperasiController;
use App\Http\Controllers\MasterData\PegawaiController;
use App\Http\Controllers\MasterData\LogoController;
use App\Http\Controllers\Modul\LaboratoriumController;
use App\Http\Controllers\Laboratorium\KeswanController;
use App\Http\Controllers\Laboratorium\PakanController;
use App\Http\Controllers\Laboratorium\KesmavetController;
use App\Http\Controllers\Modul\PlltController;
use App\Http\Controllers\Modul\KlinikController;
use App\Http\Controllers\Modul\StockController;
use App\Http\Controllers\Laporan\LaporanKlinikController;
use App\Http\Controllers\Laporan\LaporanPlltController;
use App\Http\Controllers\Laporan\LaporanKeswanController;
use App\Http\Controllers\Laporan\LaporanKesmavetController;
use App\Http\Controllers\Laporan\LaporanPakanController;
use App\Http\Controllers\Pengaturan\PenggunaController;
use App\Http\Controllers\Pengaturan\HakAksesController;
use App\Http\Controllers\Pengaturan\LainLainController;
use App\Http\Controllers\Boyolali\MasterData\KelompokKerjaController;
use App\Http\Controllers\Boyolali\MasterData\JenisHasilUjiController;
// Note: Two JenisPengujianController imports, aliasing the second one
use App\Http\Controllers\Boyolali\MasterData\JenisPengujianController as BoyolaliJenisPengujianController;
use App\Http\Controllers\Boyolali\MasterData\SeksiLaboratoriumController as BoyolaliSeksiLaboratoriumController;
use App\Http\Controllers\Boyolali\MasterData\SampelController;
use App\Http\Controllers\Boyolali\LabBoyolaliController;
use App\Http\Controllers\Boyolali\LaporanLabBoyolaliController;
use App\Http\Controllers\Boyolali\BoyolaliController;
use App\Http\Controllers\LandingPageController;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/landing-page-login', [LandingPageController::class, 'login'])->name('login_page');
Route::get('/landing-page-register', [LandingPageController::class, 'register'])->name('register');
Route::get('/form-pendaftaran-periksa', [LandingPageController::class, 'formPendaftaran'])->name('form-pendaftaran-periksa');
Route::get('/tiket-antrian', [LandingPageController::class, 'tiketAntrian'])->name('tiket-antrian');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    // return what you want
});

Route::get('/clear-config', function () {
    Artisan::call('config:cache');
    // return what you want
});

Route::get('statistik', [StatistikController::class, 'index']);


Route::post('beranda/get_jumlah_jenis_pasien', [HomeController::class, 'get_jumlah_jenis_pasien']);
Route::post('beranda/get_jumlah_pelayanan', [HomeController::class, 'get_jumlah_pelayanan']);
Route::post('beranda/get_jumlah_pasien', [HomeController::class, 'get_jumlah_pasien']);


Route::prefix('master-data')->group(function () {
    Route::post('sub-satuan-kerja/cek-validasi', [SubSatuanKerjaController::class, 'cekValidasi']);
    Route::resource('sub-satuan-kerja', SubSatuanKerjaController::class);
    Route::post('spesies/cek-validasi', [SpesiesController::class, 'cekValidasi']);
    Route::resource('spesies', SpesiesController::class);
    Route::post('ras/cek-validasi', [RasController::class, 'cekValidasi']);
    Route::resource('ras', RasController::class);
    Route::post('jenis-contoh/cek-validasi', [JenisContohController::class, 'cekValidasi']);
    Route::resource('jenis-contoh', JenisContohController::class);
    Route::post('bentuk-contoh/cek-validasi', [BentukContohController::class, 'cekValidasi']);
    Route::resource('bentuk-contoh', BentukContohController::class);
    Route::post('seksi-laboratorium/cek-validasi', [SeksiLaboratoriumController::class, 'cekValidasi']);
    Route::resource('seksi-laboratorium', SeksiLaboratoriumController::class);
    Route::post('jenis-pengujian/cek-validasi', [JenisPengujianController::class, 'cekValidasi']);
    Route::resource('jenis-pengujian', JenisPengujianController::class);
    Route::get('customer/area-kelurahan', [CustomerController::class, 'formAreaKelurahan']);
    Route::get('customer/area-kecamatan', [CustomerController::class, 'formAreaKecamatan']);
    Route::get('customer/area-kota', [CustomerController::class, 'formAreaKota']);
    Route::post('customer/cek-validasi', [CustomerController::class, 'cekValidasi']);
    Route::resource('customer', CustomerController::class);
    Route::post('asal-hewan/cek-validasi', [AsalHewanController::class, 'cekValidasi']);
    Route::resource('asal-hewan', AsalHewanController::class);
    Route::post('pemeriksa/cek-validasi', [PemeriksaController::class, 'cekValidasi']);
    Route::resource('pemeriksa', PemeriksaController::class);
    Route::post('pemilik/cek-validasi', [PemilikController::class, 'cekValidasi']);
    Route::post('pemilik/store_pasien', [PemilikController::class, 'store_pasien']);
    Route::post('pemilik/update_pasien', [PemilikController::class, 'update_pasien']);
    Route::post('pemilik/delete_pasien', [PemilikController::class, 'delete_pasien']);
    Route::post('pemilik/get_wilayah', [PemilikController::class, 'get_wilayah']);
    Route::resource('pemilik', PemilikController::class);
    Route::post('penyakit/cek-validasi', [PenyakitController::class, 'cekValidasi']);
    Route::resource('penyakit', PenyakitController::class);
    Route::post('obat/cek-validasi', [ObatController::class, 'cekValidasi']);
    Route::resource('obat', ObatController::class);
    Route::post('daftar_harga/cek-validasi', [DaftarHargaController::class, 'cekValidasi']);
    Route::resource('daftar_harga', DaftarHargaController::class);
    Route::post('operasi/cek-validasi', [OperasiController::class, 'cekValidasi']);
    Route::resource('operasi', OperasiController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::get('logo', [LogoController::class, 'index']);
});



// LABORATORIUM
Route::get('laboratorium/cetak/{id}', [LaboratoriumController::class, 'cetakKartu']);
Route::post('laboratorium/hapus-file', [LaboratoriumController::class, 'hapusFile']);
Route::get('laboratorium/area-file', [LaboratoriumController::class, 'getFile']);
Route::get('laboratorium/area-jenis-pengujian', [LaboratoriumController::class, 'formAreaJenisPengujian']);
Route::get('laboratorium/area-bentuk-contoh', [LaboratoriumController::class, 'formAreaBentukContoh']);
Route::get('laboratorium/area-jenis-contoh', [LaboratoriumController::class, 'formAreaJenisContoh']);
Route::get('laboratorium/customer', [LaboratoriumController::class, 'getCustomer']);
Route::get('laboratorium/nama-laboratorium', [LaboratoriumController::class, 'getLaboratorium']);
Route::post('laboratorium/cek-validasi', [LaboratoriumController::class, 'cekValidasi']);
Route::resource('laboratorium', LaboratoriumController::class);



//LABORATORIUM
Route::prefix('lab')->group(function () {
    Route::get('customer', [KeswanController::class, 'getCustomer']);
    Route::get('keswan/customer', [KeswanController::class, 'getCustomer']);
    Route::get('pakan/customer', [PakanController::class, 'getCustomer']);
    Route::get('kesmavet/customer', [KesmavetController::class, 'getCustomer']);
    Route::post('checknoepid', [KeswanController::class, 'checkNoEpid']);

    Route::group(['middleware' => ['ajax']], function () {
        Route::get('keswan', [KeswanController::class, 'index']);
        Route::get('keswan/form01', [KeswanController::class, 'getForm01']);
        Route::get('keswan/input', [KeswanController::class, 'input']);
        Route::get('keswan/{id}/form01', [KeswanController::class, 'getForm01']);
        Route::get('keswan/{id}/form02', [KeswanController::class, 'getForm02']);
        Route::get('keswan/{id}/form03', [KeswanController::class, 'getForm03']);
        Route::get('keswan/{id}/form04', [KeswanController::class, 'getForm04']);
        Route::get('keswan/{id}/formhasil', [KeswanController::class, 'getFormhasil']);
        Route::post('keswan/form01', [KeswanController::class, 'postForm01']);
        Route::post('keswan/form02', [KeswanController::class, 'postForm02']);
        Route::post('keswan/form03', [KeswanController::class, 'postForm03']);
        Route::post('keswan/form04', [KeswanController::class, 'postForm04']);
        Route::post('keswan/formhasil', [KeswanController::class, 'postFormHasil']);

        Route::get('kesmavet', [KesmavetController::class, 'index']);
        Route::get('kesmavet/form01', [KesmavetController::class, 'getForm01']);
        Route::get('kesmavet/{id}/form01', [KesmavetController::class, 'getForm01']);
        Route::get('kesmavet/{id}/form02', [KesmavetController::class, 'getForm02']);
        Route::get('kesmavet/{id}/form03', [KesmavetController::class, 'getForm03']);
        Route::get('kesmavet/{id}/form04', [KesmavetController::class, 'getForm04']);
        Route::get('kesmavet/{id}/formhasil', [KesmavetController::class, 'getFormhasil']);
        Route::post('kesmavet/form01', [KesmavetController::class, 'postForm01']);
        Route::post('kesmavet/form02', [KesmavetController::class, 'postForm02']);
        Route::post('kesmavet/form03', [KesmavetController::class, 'postForm03']);
        Route::post('kesmavet/form04', [KesmavetController::class, 'postForm04']);
        Route::post('kesmavet/formhasil', [KesmavetController::class, 'postFormHasil']);

        Route::get('pakan', [PakanController::class, 'index']);
        Route::get('pakan/form01', [PakanController::class, 'getForm01']);
        Route::get('pakan/{id}/form01', [PakanController::class, 'getForm01']);
        Route::get('pakan/{id}/form02', [PakanController::class, 'getForm02']);
        Route::get('pakan/{id}/form03', [PakanController::class, 'getForm03']);
        Route::get('pakan/{id}/form04', [PakanController::class, 'getForm04']);
        Route::get('pakan/{id}/formhasil', [PakanController::class, 'getFormhasil']);
        Route::post('pakan/form01', [PakanController::class, 'postForm01']);
        Route::post('pakan/form02', [PakanController::class, 'postForm02']);
        Route::post('pakan/form03', [PakanController::class, 'postForm03']);
        Route::post('pakan/form04', [PakanController::class, 'postForm04']);
        Route::post('pakan/formhasil', [PakanController::class, 'postFormHasil']);
    });

    Route::get('keswan/{id}/cetak01', [KeswanController::class, 'getCetak01']);
    Route::get('keswan/{id}/cetak02', [KeswanController::class, 'getCetak02']);
    Route::get('keswan/{id}/cetak03', [KeswanController::class, 'getCetak03']);
    Route::get('keswan/{id}/cetak04', [KeswanController::class, 'getCetak04']);
    Route::get('keswan/{id}/cetakhasil', [KeswanController::class, 'getCetakHasil']);

    Route::get('kesmavet/{id}/cetak01', [KesmavetController::class, 'getCetak01']);
    Route::get('kesmavet/{id}/cetak02', [KesmavetController::class, 'getCetak02']);
    Route::get('kesmavet/{id}/cetak03', [KesmavetController::class, 'getCetak03']);
    Route::get('kesmavet/{id}/cetak04', [KesmavetController::class, 'getCetak04']);
    Route::get('kesmavet/{id}/cetakhasil', [KesmavetController::class, 'getCetakHasil']);

    Route::get('pakan/{id}/cetak01', [PakanController::class, 'getCetak01']);
    Route::get('pakan/{id}/cetak02', [PakanController::class, 'getCetak02']);
    Route::get('pakan/{id}/cetak03', [PakanController::class, 'getCetak03']);
    Route::get('pakan/{id}/cetak04', [PakanController::class, 'getCetak04']);
    Route::get('pakan/{id}/cetakhasil', [PakanController::class, 'getCetakHasil']);
});



//PLLT
Route::post('pllt/hapus-data-hewan', [PlltController::class, 'hapusDataHewan']);
Route::post('pllt/hapus-data-hewans', [PlltController::class, 'hapusDataHewan']);
Route::get('pllt/area-data-hewan', [PlltController::class, 'getDataHewan']);
Route::get('pllt/area-data-hewans', [PlltController::class, 'getDataHewan']);
Route::post('pllt/tambah-data-hewan', [PlltController::class, 'tambahDataHewan']);
Route::post('pllt/hapus-file', [PlltController::class, 'hapusFile']);
Route::get('pllt/area-file', [PlltController::class, 'getFile']);
Route::get('pllt/area-pemeriksa', [PlltController::class, 'formPemeriksa']);
Route::get('pllt/area-kecamatan-tujuan', [PlltController::class, 'formAreaKecamatanTujuan']);
Route::get('pllt/area-kota-tujuan', [PlltController::class, 'formAreaKotaTujuan']);
Route::get('pllt/area-kecamatan-asal', [PlltController::class, 'formAreaKecamatanAsal']);
Route::get('pllt/area-kota-asal', [PlltController::class, 'formAreaKotaAsal']);
Route::get('pllt/area-jenis-hewan', [PlltController::class, 'formAreaJenisHewan']);
Route::get('pllt/nama-pllt', [PlltController::class, 'getPllt']);
Route::resource('pllt', PlltController::class);



//KLINIK
Route::post('klinik/hapus-data-terapi', [KlinikController::class, 'hapusDataTerapi']);
Route::get('klinik/area-data-terapi', [KlinikController::class, 'getDataTerapi']);
Route::get('klinik/area-data-terapi2', [KlinikController::class, 'getDataTerapi2']);
Route::post('klinik/tambah-data-terapi', [KlinikController::class, 'tambahDataTerapi']);
Route::get('klinik/area-ras', [KlinikController::class, 'formAreaRas']);
Route::get('klinik/area-obat', [KlinikController::class, 'formAreaObat']);
Route::get('klinik/area-vaksin', [KlinikController::class, 'formAreaVaksin']);
Route::get('klinik/area-operasi', [KlinikController::class, 'formAreaOperasi']);
Route::get('klinik/cetak/{id}', [KlinikController::class, 'cetakKartu']);
Route::get('klinik/cetakRM/{id}', [KlinikController::class, 'cetakRM']);
Route::post('klinik/cek-validasi', [KlinikController::class, 'cekValidasi']);
Route::get('klinik/pemilik', [KlinikController::class, 'getPemilik']);
Route::get('klinik/hewan', [KlinikController::class, 'getHewan']);
Route::get('klinik/detailHewan', [KlinikController::class, 'getDetailHewan']);
Route::get('klinik/getJmlPeriksa', [KlinikController::class, 'getJmlPeriksa']);
Route::get('klinik/getNoRm', [KlinikController::class, 'getNoRm']);
Route::get('klinik/nama-klinik', [KlinikController::class, 'getKlinik']);
Route::get('klinik/add/', [KlinikController::class, 'addKlinik']);
Route::get('klinik/create_new/', [KlinikController::class, 'create_new']);
Route::get('klinik/rekap/', [KlinikController::class, 'rekap']);
Route::post('klinik/rekap/', [KlinikController::class, 'rekap']);
Route::get('klinik/pendaftaran/', [KlinikController::class, 'pendaftaran']);
Route::get('klinik/add_pendaftaran/', [KlinikController::class, 'add_pendaftaran']);
Route::get('klinik/edit_pendaftaran/{id}/{from_url}', [KlinikController::class, 'edit_pendaftaran']);
Route::get('klinik/add_pemeriksaan/{id}/{from_url}', [KlinikController::class, 'add_pemeriksaan']);
Route::get('klinik/add_pembayaran/{id}/{from_url}', [KlinikController::class, 'add_pembayaran']);
Route::get('klinik/edit_pembayaran/{id}/{from_url}', [KlinikController::class, 'add_pembayaran']);
Route::get('klinik/cetak/{id}', [KlinikController::class, 'cetak']);
Route::get('klinik/rekap_buku/{id}', [KlinikController::class, 'rekap_buku']);
Route::get('klinik/pendaftaran_pasien/{id}', [KlinikController::class, 'pendaftaran_pasien']);
Route::get('klinik/pemeriksaan/', [KlinikController::class, 'pemeriksaan']);
Route::get('klinik/pembayaran/', [KlinikController::class, 'pembayaran']);
Route::post('klinik/tambahTerapi', [KlinikController::class, 'tambahTerapi']);
Route::post('klinik/simpan_pendaftaran', [KlinikController::class, 'simpan_pendaftaran']);
Route::post('klinik/update_pendaftaran', [KlinikController::class, 'update_pendaftaran']);
Route::post('klinik/hapus_pendaftaran', [KlinikController::class, 'hapus_pendaftaran']);
Route::post('klinik/simpan_pemeriksaan', [KlinikController::class, 'simpan_pemeriksaan']);
Route::post('klinik/simpan_pembayaran', [KlinikController::class, 'simpan_pembayaran']);
Route::post('klinik/cari_layanan', [KlinikController::class, 'cari_layanan']);
Route::get('klinik/detailPeriksa/{id}', [KlinikController::class, 'detailPeriksa']);
Route::get('klinik/editRM/{id}', [KlinikController::class, 'editRM']);
Route::post('klinik/updateRM/{id}', [KlinikController::class, 'updateRM']);
Route::get('klinik/editPeriksa/{terapi_id}/{klinik_id}', [KlinikController::class, 'editPeriksa']);
Route::post('klinik/updateTransaksi', [KlinikController::class, 'updateTransaksi']);
Route::post('klinik/updateObat', [KlinikController::class, 'updateObat']);
Route::post('klinik/hapusRiwayat', [KlinikController::class, 'hapusRiwayat']);
Route::get('klinik/getObatAktif', [KlinikController::class, 'get_obat_aktif']);
Route::resource('klinik', KlinikController::class);


Route::get('stock/index', [StockController::class, 'index']);
Route::post('stock/index', [StockController::class, 'index']);
Route::get('stock/add_stock', [StockController::class, 'add_stock']);
Route::get('stock/tambah_stock', [StockController::class, 'tambah_stock']);
Route::get('stock/tambah_stock_awal', [StockController::class, 'tambah_stock_awal']);
Route::post('stock/simpan_stock', [StockController::class, 'simpan_stock']);
Route::post('stock/simpan_stock_awal', [StockController::class, 'simpan_stock_awal']);
Route::get('stock/edit_stock/{id}', [StockController::class, 'edit_stock']);
Route::get('stock/edit_stock_awal/{id}', [StockController::class, 'edit_stock_awal']);
Route::post('stock/update_stock', [StockController::class, 'update_stock']);
Route::post('stock/update_stock_awal', [StockController::class, 'update_stock_awal']);
Route::post('stock/hapus_stock', [StockController::class, 'hapus_stock']);
Route::post('stock/hapus_stock_awal', [StockController::class, 'hapus_stock_awal']);
Route::get('stock/add_stock_awal', [StockController::class, 'add_stock_awal']);
Route::post('stock/update_stock_opname', [StockController::class, 'update_stock_opname']);
Route::get('stock/export/{bulan}/{tahun}', [StockController::class, 'export']);


Route::prefix('laporan')->group(function () {
    Route::post('lap-klinik', [LaporanKlinikController::class, 'cetakLaporanPasien']);
    Route::get('lap-klinik', [LaporanKlinikController::class, 'formCetak']);
    Route::get('lap-klinik-prev', [LaporanKlinikController::class, 'preview']);
    Route::post('lap-ternak-masuk', [LaporanPlltController::class, 'cetakTernakMasuk']);
    Route::get('lap-ternak-masuk', [LaporanPlltController::class, 'formCetakTernakMasuk']);
    Route::get('lap-ternak-masuk-prev', [LaporanPlltController::class, 'TernakMasukPrev']);
    Route::post('lap-ternak-lewat', [LaporanPlltController::class, 'cetakTernakLewat']);
    Route::get('lap-ternak-lewat', [LaporanPlltController::class, 'formCetakTernakLewat']);
    Route::get('lap-ternak-lewat-prev', [LaporanPlltController::class, 'TernakLewatPrev']);
    Route::post('lap-ternak-keluar', [LaporanPlltController::class, 'cetakTernakKeluar']);
    Route::get('lap-ternak-keluar', [LaporanPlltController::class, 'formCetakTernakKeluar']);
    Route::get('lap-ternak-keluar-prev', [LaporanPlltController::class, 'TernakKeluarPrev']);

    Route::get('lab-keswan/{bulan}/{tahun}/{id}/{tipe}', [LaporanKeswanController::class, 'getLaporanKeswan']);
    Route::get('lab-kesmavet/{bulan}/{tahun}/{id}/{tipe}', [LaporanKesmavetController::class, 'getLaporanKesmavet']);
    Route::get('lab-pakan/{bulan}/{tahun}/{id}/{tipe}', [LaporanPakanController::class, 'getLaporanPakan']);

    Route::post('lab-keswan', [LaporanKeswanController::class, 'postLaporanKeswan']);
    Route::post('lab-pakan', [LaporanPakanController::class, 'postLaporanPakan']);
    Route::post('lab-kesmavet', [LaporanKesmavetController::class, 'postLaporanKesmavet']);

    Route::group(['middleware' => ['ajax']], function () {
        Route::post('lab-keswan/tampil', [LaporanKeswanController::class, 'cetakPengujian']);
        Route::post('lab-pakan/tampil', [LaporanPakanController::class, 'cetakPengujian']);
        Route::post('lab-kesmavet/tampil', [LaporanKesmavetController::class, 'cetakPengujian']);
        Route::get('lab-keswan', [LaporanKeswanController::class, 'formCetakPengujian']);
        Route::get('lab-kesmavet', [LaporanKesmavetController::class, 'formCetakPengujian']);
        Route::get('lab-pakan', [LaporanPakanController::class, 'formCetakPengujian']);
    });
});


Route::prefix('pengaturan')->group(function () {
    Route::get('pengguna/satuan-kerja', [PenggunaController::class, 'formSubSatuanKerja']);
    Route::post('pengguna/cek-validasi', [PenggunaController::class, 'cekValidasi']);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('hak-akses', HakAksesController::class);
});


Route::get('ganti-password', [LainLainController::class, 'formGantiPassword']);
Route::post('ganti-password', [LainLainController::class, 'updatePassword']);
Route::get('informasi-pengguna', [LainLainController::class, 'getInformasiPengguna']);

//BOYOLALI
Route::prefix('boyolali/master-data')->group(function () {
    Route::resource('kelompok-kerja', KelompokKerjaController::class);
    Route::resource('jenis-hasil-uji', JenisHasilUjiController::class);
    Route::resource('jenis-pengujian', BoyolaliJenisPengujianController::class);
    Route::resource('seksi-laboratorium', BoyolaliSeksiLaboratoriumController::class);
    Route::resource('sampel', SampelController::class);
});

Route::prefix('boyolali/lab-boyolali')->group(function () {
    Route::get('get-kota', [LabBoyolaliController::class, 'getKota']);
    Route::get('get-kec', [LabBoyolaliController::class, 'getKec']);
    Route::post('tambah-data-sampel', [LabBoyolaliController::class, 'tambahDataSampel']);
    Route::post('hapus-detail', [LabBoyolaliController::class, 'hapusDetail']);
    Route::post('hapus-data-sampel', [LabBoyolaliController::class, 'hapusDataSampel']);
    Route::get('area-data-sampel', [LabBoyolaliController::class, 'getDataSampel']);
});
Route::resource('boyolali/laporan/lab-boyolali', LaporanLabBoyolaliController::class)->only(['index']); // Assuming formCetak is the index method
Route::resource('boyolali/lab-boyolali', LabBoyolaliController::class);
Route::resource('boyolali', BoyolaliController::class);



require __DIR__.'/auth.php';
