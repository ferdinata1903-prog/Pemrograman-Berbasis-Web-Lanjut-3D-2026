@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    @if ($buku)
        <article class="detail">
            <div class="detail-cover">{{ mb_strtoupper(mb_substr($buku['judul'], 0, 1)) }}</div>

            <div class="detail-info">
                <span class="badge">{{ $buku['kategori'] }}</span>
                <h2>{{ $buku['judul'] }}</h2>
                <p class="meta"><span>Penulis</span>{{ $buku['penulis'] }}</p>
                <p class="meta"><span>Tahun Terbit</span>{{ $buku['tahun'] }}</p>
                <p class="meta"><span>Kategori</span>{{ $buku['kategori'] }}</p>

                <a href="{{ route('buku.index') }}" class="btn btn-outline">← Kembali ke Daftar Buku</a>
            </div>
        </article>
    @else
        <div class="kosong">
            <h2>Oops!</h2>
            <p>Data buku tidak ditemukan.</p>
            <a href="{{ route('buku.index') }}" class="btn">← Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection