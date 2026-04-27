<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CustomerController,
    KeluhanController,    
    TandaterController,
    TeknisiController,
    UserController,
    FinalController,
    FinanceController,
    BarangController
};

Route::middleware('guest')->group(function() {
    Route::get('/login', [UserController::class, 'Login'])->name('tampil.login');
    Route::post('/PostLog', [UserController::class, 'Log'])->name('AddLog');

    Route::get('/logAdmin', [UserController::class, 'adminLog'])->name('tampil.admin');
    Route::post('/adminLog', [UserController::class, 'loginAdmin'])->name('req.admin');

    Route::get('/logTek', [UserController::class, 'tekLogin'])->name('tamtek');
    Route::post('/tekLog', [UserController::class, 'loginTeknisi'])->name('req.teknisi');    

    Route::get('/logFin', [UserController::class, 'finLog'])->name('tampil.finance');        
    Route::post('/finLog', [UserController::class, 'loginFinance'])->name('req.finance');

    //posted    
    Route::get('/regis', [UserController::class, 'regis'])->name('tampil.regis');
    Route::post('/PostReg', [UserController::class, 'Reg'])->name('AddReg');    
});

Route::middleware('auth.validation')->group(function() {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/AllGet/{id}', [FinalController:: class, 'getAlltheData'])->name('get.all');
    Route::get('/', 
        [TandaterController::class, 'index'])
    ->name('DataCust');
    Route::get('/list/{id}', [TandaterController::class, 'TampilId'])->name('TampilId');

    Route::group(['middleware' => ['role:user']], function(){                
        Route::post('/AddTT', [TandaterController::class, 'create'])->name('AddTT');        
        Route::get('/tandaterima', [TandaterController::class, 'tampilTT'])->name('tampil.tandater');
        Route::get('/search-customer', [FinalController::class, 'search'])->name('customer.search');
        Route::post('/customer-stat/{id}', [CustomerController::class, 'Tutup'])->name('cust.stat');
        Route::post('edited-name', [TandaterController::class, 'edited_name'])->name('edited.name');

        Route::get('/customer', [TandaterController::class, 'tampilCust'])->name('DataMer');
        Route::post('/cust', [CustomerController::class, 'create'])->name('AddCust');        
        Route::post('/edit-barang', [BarangController::class, 'edit'])->name('edit.barang');        
        Route::get('/search', [BarangController::class, 'searchSN'])->name('cari.barang');
        Route::post('/search', [BarangController::class, 'searchBySN'])->name('cari.barangs');                
    });

    Route::group(['middleware' => ['role:finance']], function(){
        Route::get('/cetak-list', [FinalController::class, 'cetaklist'])->name('cetak.list');        
        Route::get('/Finance/{id}', [TandaterController::class, 'viewFinance'])->name('list.finance');
        Route::get('/Finance', [TandaterController::class, 'fin'])->name('DataFin');      
        Route::post('/Final', [FinalController::class, 'create'])->name('final');                
        Route::get('/cetak/{id}', [FinalController::class, 'tampil'])->name('tampil.cetak');    
        Route::post('/transaksi', [FinalController::class, 'Transaksi'])->name('post.barang');                 
        Route::get('/edit-tr/{id}', [FinalController::class, 'editTran'])->name('edit.trans');        
        Route::delete('/delete-tr/{id}', [FinalController::class, 'deleteTransaksi'])->name('delete.tras');
        Route::get('/transaksi-Data', [FinalController::class, 'DataTransaksi'])->name('ExportTransaksiData');
        //pdf                
    });

    Route::group(['middleware' => ['role:teknisi']], function(){
        Route::get('/keluhan/{id}', [TandaterController::class, 'show'])->name('tampil.id');
        Route::get('/keluhan', [TandaterController::class, 'kel'])->name('DataKel'); 
        Route::get('/detailKeluhan/{id}', [TandaterController::class, 'detKel'])->name('detKel');       
        Route::post('/addTeknis', [TandaterController::class, 'cukel'])->name('addTeknisi');        
    });

    
    Route::group(['middleware' => ['role:admin']], function(){        
        Route::get('/listCetak', [FinalController::class, 'listTak'])->name('listTak');
    });         
        Route::post('/edit-tanggal', [FinalController::class, 'editTanggal'])->name('edit.tanggal');
        Route::post('/edit-all', [FinalController::class, 'editall'])->name('edit.all');                  
        //Route::get('/admin', [UserController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/transaksi-Data', [FinalController::class, 'DataTransaksi'])->name('ExportTransaksiData');
        //Route::get('/AllGetTR/{id}', [FinalController:: class, 'getAlltheData'])->name('get.all.data');
        Route::post('/checking', [FinalController::class, 'checking'])->name('check');
        //pdf        
        Route::get('/tekn-do', [FinalController::class, 'TeknExport'])->name('tekn.do');
        Route::get('/trans-do', [FinalController::class, 'TransExport'])->name('trans.do');
        Route::get('/kwitansi/{id}', [FinalController::class, 'kwitansi'])->name('kwitansi');
        Route::get('/sph/{id}', [FinalController::class, 'sph']); 
        Route::get('/penawaran/{id}', [FinalController::class, 'penawaran'])->name('penawaran');      
    
        Route::post('/downloadPdf', [FinalController::class, 'downPdf'])->name('downPdf');   
        Route::get('/teknisi/{id}', [FinalController::class, 'listTek'])->name('list.teknisis');
        Route::get('/invoice/{id}', [FinalController::class, 'invoice'])->name('Invoice');
        Route::get('/bap/{id}', [FinalController::class, 'bap'])->name('bap');
        Route::get('/kwitansi/{id}', [FinalController::class, 'kwitansi'])->name('kwitansi');
        Route::get('/sph/{id}', [FinalController::class, 'sph']);        
        Route::get('/penawaran/{id}', [FinalController::class, 'penawaran'])->name('penawaran'); 
        Route::post('/edit-tanggal', [FinalController::class, 'editTanggal'])->name('edit.tanggal');

        Route::post('/edit-all', [FinalController::class, 'editall'])->name('edit.all');
        Route::get('/teknisi', [FinalController::class, 'Teknisi'])->name('tampil.teknisi');                
        Route::get('/edit-tr/{id}', [FinalController::class, 'editTran'])->name('edit.trans');
        Route::post('/paid-tr/{id}', [FinalController::class, 'paidTr'])->name('paid');        
        Route::post('/edit-final', [FinalController::class, 'edit'])->name('edit.status');
        Route::delete('/delete-keluhan/{id}', [FinalController::class, 'deleteKeluhan'])->name('delete.keluhan');                                 
        Route::post('/search-date', [FinalController::class, 'searchDate'])->name('cari.tanggal');
});