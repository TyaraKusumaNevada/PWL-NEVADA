<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Authenticatable


class UserModel extends Authenticatable implements JWTSubject
{
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    use HasFactory;
    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan di model ini
    protected $primaryKey = 'user_id'; //Mendefinisikan primary key dari tabel yang digunakan

    //=======Jaobsheet 4 Prak 1=======

    protected $fillable = ['username', 'nama', 'password', 'level_id'];

    protected $hidden = ['password']; // jangan di tampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash


//    ===Jobsheet 4 Prakt 2.7====
   
   public function level(): BelongsTo //Menunjukkan bahwa setiap user memiliki relasi belongsTo dengan tabel LevelModel, dihubungkan melalui level_id.
   {
       return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
   }

   public function stok(): HasMany {
       return $this->hasMany(StokModel::class, 'user_id', 'user_id');
   }

   public function penjualan(): HasMany {
       return $this->hasMany(PenjualanModel::class, 'user_id', 'user_id');
   }

    /**
     * Mendapatkan nama role
     */
    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }

    // mendapat kode role
    public function getRole()
    {
        return $this->level->level_kode;
    }

}