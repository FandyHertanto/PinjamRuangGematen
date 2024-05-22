<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Barang::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['nama_barang' => 'Meja', 'deskripsi' => 'Deskripsi Meja'],
            ['nama_barang' => 'Kursi', 'deskripsi' => 'Deskripsi Kursi'],
            ['nama_barang' => 'TV', 'deskripsi' => 'Deskripsi TV'],
            ['nama_barang' => 'AC', 'deskripsi' => 'Deskripsi AC'],
            ['nama_barang' => 'Sound System', 'deskripsi' => 'Deskripsi Sound System'],
        ];

        foreach ($data as $barang){
            Barang::create($barang);
        }
    }
}
