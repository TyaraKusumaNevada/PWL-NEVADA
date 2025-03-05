<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_barang', function (Blueprint $table) {
            $table->id('barang_id'); // Kolom primary key menggunakan nama 'barang_id'
        $table->unsignedBigInteger('kategori_id'); // Foreign key
        $table->string('barang_kode', 10);
        $table->string('barang_nama', 100);
        $table->integer('harga_beli');
        $table->integer('harga_jual');
        $table->timestamps();

        // Foreign key harus mengacu ke kolom 'id' di m_kategori
        $table->foreign('kategori_id')->references('id')->on('m_kategori');
            
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barang');
    }
};
