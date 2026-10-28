@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    <h2>Daftar Buku</h2>
    <p class="sub">Data diambil langsung dari API lewat Fetch, tabel diperbarui tanpa reload halaman.</p>

    <div class="form-buku">
        <h3 id="form-judul">Tambah Buku</h3>
        <form id="form-buku">
            <input type="hidden" id="buku_id" value="">

            <select id="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
            </select>

            <input type="text" id="judul" placeholder="Judul buku" required>
            <input type="text" id="penulis" placeholder="Penulis" required>
            <input type="number" id="tahun_terbit" placeholder="Tahun terbit" required>

            <button type="submit" id="submit-btn" class="btn btn-sm">Tambah</button>
            <button type="button" id="batal-btn" class="btn btn-outline btn-sm" style="display:none;">Batal</button>
        </form>
        <p id="form-pesan" style="color: #c0392b; font-weight: 600;"></p>
    </div>

    <table id="tabel-buku" style="width:100%; margin-top:1.5rem; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tabel-body">
            <tr><td colspan="5">Memuat data...</td></tr>
        </tbody>
    </table>
@vite('resources/js/buku.js')
@endsection