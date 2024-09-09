<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'KT001',
                'kategori_nama' => 'Mesin',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'KT002',
                'kategori_nama' => 'Aksesoris',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'KT003',
                'kategori_nama' => 'Kelistrikan',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'KT004',
                'kategori_nama' => 'Ban dan Velg',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'KT005',
                'kategori_nama' => 'Sistem Suspensi',
            ],
        ];
        DB::table('m_kategoris') -> insert($data);
    }
}
