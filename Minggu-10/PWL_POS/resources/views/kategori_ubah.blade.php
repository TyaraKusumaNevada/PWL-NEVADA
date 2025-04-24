<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Kategori</title>
</head>
<body>
    <h1>Form Ubah Data Kategori</h1>
    <a href="/kategori">Kembali</a>
    <br><br>
    <form method="post" action="{{ url('kategori/ubah_simpan/' . $data->kategori_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Kategori</label>
        <input type="text" name="kategori_kode" placeholder="Masukan Kode" value="{{ $data->kategori_kode }}">
        <br>

        <label>Nama Kategori</label>
        <input type="text" name="kategori_nama" placeholder="Masukan Nama" value="{{ $data->kategori_nama }}">
        <br>

        <input type="submit" value="Ubah">
    </form>
</body>
</html>
</html>