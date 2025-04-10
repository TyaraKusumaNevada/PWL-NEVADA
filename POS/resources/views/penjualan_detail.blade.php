<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan Detail</title>
</head>
<body>
    <h1>Data Penjualan Detail</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Detail ID</th>
            <th>Penjualan ID</th>
            <th>Barang ID</th>
            <th>Jumlah Barang</th>
            <th>Harga Barang</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->detail_id }}</td>
            <td>{{ $d->penjualan_id }}</td>
            <td>{{ $d->barang_id }}</td>
            <td>{{ $d->jumlah_barang }}</td>
            <td>{{ $d->harga_barang }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>