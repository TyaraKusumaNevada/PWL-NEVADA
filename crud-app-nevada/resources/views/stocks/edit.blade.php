<!DOCTYPE html>
<html>
<head>
    <title>Edit Stock</title> 
</head>
<body>
    <h1>Edit Stock</h1> 

    <form action="{{ route('stocks.update', $stock) }}" method="POST"> {{-- untuk mengedit stock, dikirim ke route 'stocks.update' --}}
        @csrf {{-- Token keamanan csrf --}}
        @method('PUT') {{-- Menggunakan method HTTP PUT untuk memperbarui data --}}

        <label for="name">Name:</label> {{-- Label untuk input nama stok --}}
        <input type="text" name="name" value="{{ $stock->name }}" required> {{-- Input teks dengan nilai nama stok saat ini --}}
        <br>

        <label for="description">Description:</label> {{-- untuk input deskripsi stok --}}
        <textarea name="description" required>{{ $stock->description }}</textarea> {{-- input teks area dengan nilai deskripsi stok saat ini, wajib diisi --}}
        <br>

        <button type="submit">Update Stock</button> {{-- Tombol untuk mengirimkan perubahan --}}
    </form>

    <a href="{{ route('stocks.index') }}">Back to List</a> {{-- Link untuk kembali ke daftar stock --}}
</body>
</html>
