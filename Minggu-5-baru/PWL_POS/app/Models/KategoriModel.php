<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';
    public $timestamps = true;

    protected $fillable = [
        'kategori_kode',
        'kategori_nama',
    ];

    // ke tabel barang
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id', 'kategori_id');
    }
}