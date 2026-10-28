<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori')->withCount('peminjamans');

        if ($request->filled('cari')) {
            $cari = $request->query('cari');
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('penulis', 'like', "%{$cari}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->query('kategori'));
        }

        if ($request->filled('tahun')) {
            $query->where('tahun_terbit', $request->query('tahun'));
        }

        $buku = $query->latest()->paginate(10)->withQueryString();

        return BukuResource::collection($buku);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori_id' => ['required', 'integer', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'min:3', 'max:150'],
            'penulis' => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ], [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tahun_terbit.min' => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
            'tahun_terbit.max' => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
        ], [
            'kategori_id' => 'kategori',
            'judul' => 'judul buku',
            'penulis' => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ]);

        $buku = Buku::create($data);
        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil ditambahkan.',
            'data' => new BukuResource($buku),
        ], 201);
    }

    public function show($id)
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json(['data' => new BukuResource($buku)], 200);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate([
            'kategori_id' => ['required', 'integer', 'exists:kategoris,id'],
            'judul' => ['required', 'string', 'min:3', 'max:150'],
            'penulis' => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ], [
            'required' => ':attribute wajib diisi.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'tahun_terbit.min' => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
            'tahun_terbit.max' => 'Tahun terbit harus antara 1900 sampai ' . date('Y') . '.',
        ], [
            'kategori_id' => 'kategori',
            'judul' => 'judul buku',
            'penulis' => 'penulis',
            'tahun_terbit' => 'tahun terbit',
        ]);

        $buku->update($data);
        $buku->load('kategori');

        return response()->json([
            'message' => 'Buku berhasil diperbarui.',
            'data' => new BukuResource($buku),
        ], 200);
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.'], 200);
    }
}