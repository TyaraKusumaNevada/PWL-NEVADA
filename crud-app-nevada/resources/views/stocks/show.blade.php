<!DOCTYPE html> 
<html>
<head>
    <title>Stock List</title> 
</head>
<body>
    <h1>Stocks</h1> {{-- heading utamna --}}

    @if(session('success')) {{-- mengecek apakah ada pesan sukses --}}
        <p>{{ session('success') }}</p> {{-- Menampilkan pesan sukses jika ada --}}
    @endif

    <a href="{{ route('stocks.create') }}">Add Stock</a> {{-- Link untuk menambahkan stok baru --}}

    <ul> {{-- Membuka daftar tak berurutan --}}
        @foreach ($stocks as $stock) {{-- Melakukan iterasi setiap stok dalam variabel $stocks --}}
            <li> {{-- Membuka elemen daftar --}}
                {{ $stock->name }} - {{-- Menampilkan nama stok --}}
                <a href="{{ route('stocks.edit', $stock) }}">Edit</a> {{-- Link untuk mengedit stok --}}

                <form action="{{ route('stocks.destroy', $stock) }}" method="POST" style="display:inline;">
                    @csrf {{-- Token keamanan Laravel untuk csrf --}}
                    @method('DELETE') {{-- Mengubah POST menjadi DELETE agar bisa menghapus data --}}
                    <button type="submit">Delete</button> {{-- Tombol untuk menghapus stock --}}
                </form>
            </li> 
        @endforeach {{-- Menutup perulangan foreach --}}
    </ul> 
</body>
</html>
