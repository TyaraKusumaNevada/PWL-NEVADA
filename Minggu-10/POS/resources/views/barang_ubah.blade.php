<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Barang</title>
</head>
<body>
    <h1>Form Ubah Data Barang</h1>
    <a href="/barang">Kembali</a>
    <br><br>
    <form method="post" action="{{ url('barang/ubah_simpan/' . $data->barang_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <select name="kategori_id">
            <option value="{{ $data->kategori_id }}">{{ $data->kategori->kategori_nama }}</option>
            @foreach($kategori as $kategori)
                <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
            @endforeach
        </select>
        <br>
        <label>Kode Barang</label>
        <input type="text" name="barang_kode" placeholder="Masukan Kode" value="{{ $data->barang_kode }}">
        <br>

        <label>Nama Barang</label>
        <input type="text" name="barang_nama" placeholder="Masukan Nama" value="{{ $data->barang_nama }}">
        <br>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" placeholder="Masukan Harga Beli" value="{{ $data->harga_beli }}">
        <br>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" placeholder="Masukan Harga Jual" value="{{ $data->harga_jual }}">
        <br><br>

        <input type="submit" value="Ubah">
    </form>
</body>
</html>
