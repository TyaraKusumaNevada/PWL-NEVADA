<!DOCTYPE html> 
<html>
<head>
    <title>Stock List</title> 
</head>
<body>
    <h1>Stocks</h1> {{-- Heading utama --}}

    @if(session('success')) {{-- cek apa ada pesan sukses dalam session --}}
        <p>{{ session('success') }}</p> {{-- Menampilkan pesan sukses jika ada --}}
    @endif

    <a href="{{ route('stocks.create') }}">Add Stock</a> {{-- Link untuk menambahkan stock baru --}}

    <ul> {{-- Membuka daftar tak berurutan --}}
        @foreach ($stocks as $stock) {{-- Melakukan iterasi untuk setiap stock dalam variabel $stocks --}}
            <li> {{-- Membuka elemen daftar --}}
                {{ $stock->name }} - {{-- Menampilkan nama stock --}}
                <a href="{{ route('stocks.edit', $stock) }}">Edit</a> {{-- Link untuk mengedit stock --}}

                <form action="{{ route('stocks.destroy', $stock) }}" method="POST" style="display:inline;">
                    @csrf {{-- Token keamanan Laravel --}}
                    @method('DELETE') {{-- Mengubah metode POST menjadi DELETE agar bisa menghapus data --}}
                    <button type="submit">Delete</button> {{-- Tombol untuk menghapus stok --}}
                </form>
            </li> {{-- Menutup elemen daftar --}}
        @endforeach {{-- Menutup perulangan foreach --}}
    </ul> {{-- Menutup daftar tak berurutan --}}
</body>
</html>
