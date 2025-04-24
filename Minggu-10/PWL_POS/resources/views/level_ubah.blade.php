<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Level</title>
</head>
<body>
    <h1>Form Ubah Data Level</h1>
    <a href="/level">Kembali</a>
    <br><br>
    <form method="post" action="{{ url('level/ubah_simpan/' . $data->level_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Level</label>
        <input type="text" name="level_kode" placeholder="Masukan Kode" value="{{ $data->level_kode }}">
        <br>

        <label>Nama Level</label>
        <input type="text" name="level_nama" placeholder="Masukan Nama" value="{{ $data->level_nama }}">
        <br><br>

        <input type="submit" value="Ubah">
    </form>
</body>