<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <h1>Data Barang</h1>
    <a href="{{ url('barang/tambah') }}">Tambah Barang</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Barang ID</th>
            <th>Kategori ID</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Jual</th>
            <th>Harga Beli</th>
            <th>Aksi</th>

        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->barang_id }}</td>
            <td>{{ $d->kategori->kategori_nama }}</td>
            <td>{{ $d->barang_kode }}</td>
            <td>{{ $d->barang_nama }}</td>
            <td>{{ 'Rp. ' . number_format($d->harga_jual, 0, ',', '.') }}</td>
            <td>{{ 'Rp. ' . number_format($d->harga_beli, 0, ',', '.') }}</td>
            <td>
                <a href="{{ url('barang/ubah/'.$d->barang_id) }}">Edit</a>
                <a href="{{ url('barang/hapus/'.$d->barang_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>