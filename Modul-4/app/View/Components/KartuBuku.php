<?php

namespace App\View\Components;

use Illuminate\View\Component;

class KartuBuku extends Component
{
    public $judul;
    public $penulis;
    public $tahun;

    public function __construct($judul, $penulis, $tahun)
    {
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->tahun = $tahun;
    }

    public function render()
    {
        return view('components.kartu-buku');
    }
}