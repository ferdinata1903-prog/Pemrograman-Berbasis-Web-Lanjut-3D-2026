<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;
use App\Http\Controllers\Api\KategoriController;

Route::get('/kategori', [KategoriController::class, 'index']);

Route::apiResource('buku', BukuController::class)->names([
    'index' => 'api.buku.index',
    'store' => 'api.buku.store',
    'show' => 'api.buku.show',
    'update' => 'api.buku.update',
    'destroy' => 'api.buku.destroy',
]);

Route::get('/rekap/buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
Route::get('/rekap/peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);