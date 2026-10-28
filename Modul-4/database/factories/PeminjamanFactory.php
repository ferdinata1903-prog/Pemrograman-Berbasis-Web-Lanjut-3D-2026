<?php

namespace Database\Factories;

use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'anggota_id' => Anggota::inRandomOrder()->first()->id,
            'buku_id' => Buku::inRandomOrder()->first()->id,
            'tanggal_pinjam' => fake()->dateTimeBetween('-1 month', 'now'),
            'tanggal_kembali' => fake()->boolean(60) ? fake()->dateTimeBetween('now', '+1 month') : null,
        ];
    }
}