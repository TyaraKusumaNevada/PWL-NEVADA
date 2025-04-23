<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Supplier</title>
</head>
<body>
    <h1>Form Ubah Data Supplier</h1>
    <a href="/supplier">Kembali</a>
    <br><br>
    <form method="post" action="{{ url('supplier/ubah_simpan/' . $data->supplier_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Supplier</label>
        <input type="text" name="supplier_kode" placeholder="Masukan Kode" value="{{ $data->supplier_kode }}">
        <br>

        <label>Nama Supplier</label>
        <input type="text" name="supplier_nama" placeholder="Masukan Nama" value="{{ $data->supplier_nama }}">
        <br>

        <label>Alamat Supplier</label>
        <input type="text" name="supplier_alamat" placeholder="Masukan Alamat" value="{{ $data->supplier_alamat }}">
        <br><br>

        <input type="submit" value="Ubah">
    </form>
</body>
</html>