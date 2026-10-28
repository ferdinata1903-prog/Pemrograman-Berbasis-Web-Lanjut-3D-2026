<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::select('id', 'nama')->get();

        return response()->json(['data' => $kategori], 200);
    }
}