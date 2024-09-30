<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function Laravel\Prompts\password;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barangs';
    protected $primaryKey = 'barang_id';
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = ['barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id'];
}