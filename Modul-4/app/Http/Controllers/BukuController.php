<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $daftarBuku = Buku::with('kategori')->get()->map(function ($buku) {
            return [
                'id' => $buku->id,
                'judul' => $buku->judul,
                'penulis' => $buku->penulis,
                'tahun' => $buku->tahun_terbit,
                'kategori' => $buku->kategori->nama,
            ];
        });

        return view('buku.index', ['daftarBuku' => $daftarBuku]);
    }

    public function show($id)
    {
        $data = Buku::with('kategori')->find($id);

        $buku = $data ? [
            'id' => $data->id,
            'judul' => $data->judul,
            'penulis' => $data->penulis,
            'tahun' => $data->tahun_terbit,
            'kategori' => $data->kategori->nama,
        ] : null;

        return view('buku.show', ['buku' => $buku]);
    }
}