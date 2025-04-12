<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan di model ini
    protected $primaryKey = 'user_id'; //Mendefinisikan primary key dari tabel yang digunakan

    //=======Jaobsheet 4 Prak 1=======

   protected $fillable = ['username', 'nama', 'password', 'level_id'];

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
}