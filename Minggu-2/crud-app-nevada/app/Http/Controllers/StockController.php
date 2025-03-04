<?php

namespace App\Http\Controllers; // tentukan namespace untuk controller

use App\Models\Stock; // gunakan model Stock
use Illuminate\Http\Request; // gunakan class Request untuk menangani HTTP request

class StockController extends Controller // Mendefinisikan controller StockController
{
    public function index() // Menampilkan semua data stock
    {
        $stocks = Stock::all(); // Mengambil semua data dari tabel stocks
        return view('stocks.index', compact('stocks')); // Mengirim data ke tampilan index
    }

    public function create() // Menampilkan form tambah stock
    {
        return view('stocks.create'); // Mengembalikan tampilan create
    }

    public function store(Request $request) // Menyimpan data stock baru
    {
        $request->validate([
            'name' => 'required', // nama wajib 
            'description' => 'required', // deskripsi wajib 
        ]);

        Stock::create($request->only(['name', 'description'])); // Menyimpan data ke database
        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.'); // muncul dengan pesan sukses
    }

    public function show(Stock $stock) // Menampilkan detail stock
    {
        return view('stocks.show', compact('stock')); // Mengembalikan tampilan detail
    }

    public function edit(Stock $stock) // Menampilkan form edit stock
    {
        return view('stocks.edit', compact('stock')); // Mengembalikan tampilan edit
    }

    public function update(Request $request, Stock $stock) // Mengupdate data stock
    {
        $request->validate([
            'name' => 'required', //  nama wajib diisi
            'description' => 'required', //  deskripsi wajib diisi
        ]);

        $stock->update($request->only(['name', 'description'])); // diperbarui data di database
        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.'); // Redirect dengan pesan sukses
    }

    public function destroy(Stock $stock) // untuk menghapus data stock
    {
        $stock->delete(); // untuk hapus data dari database
        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.'); // Redirect dengan pesan sukses
    }
}
