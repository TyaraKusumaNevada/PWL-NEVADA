<!DOCTYPE html>
<html>
<head>
    <title>Add Stock</title> 
</head>
<body>
    <h1>Add Stock</h1> 

    <form action="{{ route('stocks.store') }}" method="POST"> {{-- Formulir untuk menambahkan stok, nantinya dikirim ke route 'stocks.store' --}}
        @csrf {{-- Token keamanam csrf --}}
        
        <label for="name">Name:</label> {{-- untuk input nama stok --}}
        <input type="text" name="name" required> {{-- Input teks untuk nama stok (wajib isi) --}}
        <br>
        
        <label for="description">Description:</label> {{-- untuk input deskripsi stok --}}
        <textarea name="description" required></textarea> {{-- Input teks area untuk deskripsi stok, wajib diisi --}}
        <br>

        <button type="submit">Add Stock</button> {{-- Tombol umtuk kirim formulir --}}
    </form>

    <a href="{{ route('stocks.index') }}">Back to List</a> {{-- Link untuk kembali ke daftar stok --}}
</body>
</html>
