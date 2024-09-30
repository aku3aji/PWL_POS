<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use function Laravel\Prompts\password;

class SupplierModel extends Model
{
    use HasFactory;

    protected $table = 'm_suppliers';
    protected $primaryKey = 'supplier_id';
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = ['supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat'];
}