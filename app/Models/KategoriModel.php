<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function Laravel\Prompts\password;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'm_kategoris';
    protected $primaryKey = 'kategori_id';
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = ['kategori_id', 'kategori_kode', 'kategori_nama'];
}