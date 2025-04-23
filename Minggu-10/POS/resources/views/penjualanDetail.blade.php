<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan Detail</title>
</head>
<body>
    <h1>Data Penjualan Detail</h1>
    <a href="{{ url('penjualan-detail/tambah') }}">Tambah Penjualan Detail</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Detail ID</th>
            <th>Penjualan Kode</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Jumlah Barang</th>
            <th>Total Harga</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->detail_id }}</td>
            <td>{{ $d->penjualan->penjualan_kode }}</td>
            <td>{{ $d->barang->barang_nama }}</td>
            <td>{{ 'Rp. '. number_format($d->barang->harga_jual, 0, ',', '.') }}</td>
            <td>{{ $d->jumlah }}</td>
            <td>{{ 'Rp. '. number_format($d->harga, 0, ',', '.') }}</td>
            <td>
                <a href="{{ url('penjualan-detail/ubah/'.$d->detail_id) }}">Edit</a>
                <a href="{{ url('penjualan-detail/hapus/'.$d->detail_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>