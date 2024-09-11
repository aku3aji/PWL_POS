<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Penjualan 1
            [
                'penjualan_id' => 1,
                'user_id' => 1,
                'pembeli' => 'Budi Santoso',
                'penjualan_kode' => 'TRX001',
                'penjualan_tanggal' => '2024-09-01 09:00:00',
            ],
            // Penjualan 2
            [
                'penjualan_id' => 2,
                'user_id' => 2,
                'pembeli' => 'Andi Wijaya',
                'penjualan_kode' => 'TRX002',
                'penjualan_tanggal' => '2024-09-01 10:00:00',
            ],
            // Penjualan 3
            [
                'penjualan_id' => 3,
                'user_id' => 3,
                'pembeli' => 'Siti Aminah',
                'penjualan_kode' => 'TRX003',
                'penjualan_tanggal' => '2024-09-01 11:00:00',
            ],
            // Penjualan 4
            [
                'penjualan_id' => 4,
                'user_id' => 1,
                'pembeli' => 'Dewi Lestari',
                'penjualan_kode' => 'TRX004',
                'penjualan_tanggal' => '2024-09-01 12:00:00',
            ],
            // Penjualan 5
            [
                'penjualan_id' => 5,
                'user_id' => 2,
                'pembeli' => 'Rian Saputra',
                'penjualan_kode' => 'TRX005',
                'penjualan_tanggal' => '2024-09-01 13:00:00',
            ],
            // Penjualan 6
            [
                'penjualan_id' => 6,
                'user_id' => 3,
                'pembeli' => 'Ratna Dewi',
                'penjualan_kode' => 'TRX006',
                'penjualan_tanggal' => '2024-09-01 14:00:00',
            ],
            // Penjualan 7
            [
                'penjualan_id' => 7,
                'user_id' => 1,
                'pembeli' => 'Fajar Sidik',
                'penjualan_kode' => 'TRX007',
                'penjualan_tanggal' => '2024-09-01 15:00:00',
            ],
            // Penjualan 8
            [
                'penjualan_id' => 8,
                'user_id' => 2,
                'pembeli' => 'Zahra Putri',
                'penjualan_kode' => 'TRX008',
                'penjualan_tanggal' => '2024-09-01 16:00:00',
            ],
            // Penjualan 9
            [
                'penjualan_id' => 9,
                'user_id' => 3,
                'pembeli' => 'Agus Hermawan',
                'penjualan_kode' => 'TRX009',
                'penjualan_tanggal' => '2024-09-01 17:00:00',
            ],
            // Penjualan 10
            [
                'penjualan_id' => 10,
                'user_id' => 1,
                'pembeli' => 'Winda Sari',
                'penjualan_kode' => 'TRX010',
                'penjualan_tanggal' => '2024-09-01 18:00:00',
            ],
        ];

        DB::table('t_penjualans')->insert($data);
    }
}