<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    // disini harus ditentukan atribut yang dapat diisi secara banyak
    protected $fillable = ['name', 'description'];
}
