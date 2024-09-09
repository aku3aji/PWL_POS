<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Penjualan 1
            [
                'detail_id' => 1,
                'penjualan_id' => 1,
                'barang_id' => 1, // Barang sesuai
                'harga' => 500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 2,
                'penjualan_id' => 1,
                'barang_id' => 2,
                'harga' => 100000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 3,
                'penjualan_id' => 1,
                'barang_id' => 3,
                'harga' => 200000,
                'jumlah' => 1,
            ],

            // Penjualan 2
            [
                'detail_id' => 4,
                'penjualan_id' => 2,
                'barang_id' => 4,
                'harga' => 300000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 5,
                'penjualan_id' => 2,
                'barang_id' => 5,
                'harga' => 150000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 6,
                'penjualan_id' => 2,
                'barang_id' => 6,
                'harga' => 250000,
                'jumlah' => 2,
            ],

            // Penjualan 3
            [
                'detail_id' => 7,
                'penjualan_id' => 3,
                'barang_id' => 7,
                'harga' => 600000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 8,
                'penjualan_id' => 3,
                'barang_id' => 8,
                'harga' => 700000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 9,
                'penjualan_id' => 3,
                'barang_id' => 9,
                'harga' => 800000,
                'jumlah' => 1,
            ],

            // Penjualan 4
            [
                'detail_id' => 10,
                'penjualan_id' => 4,
                'barang_id' => 10,
                'harga' => 900000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 11,
                'penjualan_id' => 4,
                'barang_id' => 11,
                'harga' => 1000000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 12,
                'penjualan_id' => 4,
                'barang_id' => 12,
                'harga' => 1100000,
                'jumlah' => 1,
            ],

            // Penjualan 5
            [
                'detail_id' => 13,
                'penjualan_id' => 5,
                'barang_id' => 13,
                'harga' => 1200000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 14,
                'penjualan_id' => 5,
                'barang_id' => 14,
                'harga' => 1300000,
                'jumlah' => 2,
            ],
            [
                'detail_id' => 15,
                'penjualan_id' => 5,
                'barang_id' => 15,
                'harga' => 1400000,
                'jumlah' => 1,
            ],

            // Penjualan 6
            [
                'detail_id' => 16,
                'penjualan_id' => 6,
                'barang_id' => 1,
                'harga' => 500000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 17,
                'penjualan_id' => 6,
                'barang_id' => 2,
                'harga' => 100000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 18,
                'penjualan_id' => 6,
                'barang_id' => 3,
                'harga' => 200000,
                'jumlah' => 2,
            ],

            // Penjualan 7
            [
                'detail_id' => 19,
                'penjualan_id' => 7,
                'barang_id' => 4,
                'harga' => 300000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 20,
                'penjualan_id' => 7,
                'barang_id' => 5,
                'harga' => 150000,
                'jumlah' => 1,
            ],
            [
                'detail_id' => 21,
                'penjualan_id' => 7,
                'barang_id' => 6,
                'harga' => 250000,
                'jumlah' => 1,
            ],
        ];
        DB::table('t_penjualan_details') -> insert($data);
    }
}
