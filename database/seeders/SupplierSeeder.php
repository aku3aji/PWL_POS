<?php

namespace Database\Seeders;

use App\Models\m_supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => 1,
                'supplier_kode' => 'SP001',
                'supplier_nama' => 'PT Otomotif Sejahtera',
                'supplier_alamat' => 'Jakarta, Indonesia',
            ],
            [
                'supplier_id' => 2,
                'supplier_kode' => 'SP002',
                'supplier_nama' => 'CV Motor Prima',
                'supplier_alamat' => 'Bandung, Indonesia',
            ],
            [
                'supplier_id' => 3,
                'supplier_kode' => 'SP003',
                'supplier_nama' => 'PT Sparepart Makmur',
                'supplier_alamat' => 'Surabaya, Indonesia',
            ],
        ];
        DB::table('m_suppliers') -> insert($data);
    }
}
