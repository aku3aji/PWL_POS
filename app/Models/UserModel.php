<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier(){
        return $this->getKey(); //mengembalikan primary key dari UserModel sebagai identifier untuk JWT
    }

    public function getJWTCustomClaims(){
        return [];  //memungkinkan penambahan klaim khusus ke payload JWT
    }

    //use HasFactory;

    protected $table = 'm_user';        //mendefinisikan nama tabel yang digunakan UserModel
    protected $primaryKey = 'user_id';  //mendefinisikan primary key dari tabel yang digunakan
    protected $fillable = [
        'level_id',
        'username',
        'nama',
        'password',
        'avatar',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn($avatar) => url('/storage/posts/' . $avatar)
        );
    }

    //Relasi tabel m_user ke m_level (many-to-one)
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    //Mendapatkan nama role
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    //Memeriksa bila user memiliki role tertentu
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    //Mendapatkan kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }
}