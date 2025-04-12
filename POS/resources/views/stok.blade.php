<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
</head>
<body>
    <h1>Data Stok</h1>
    <a href="{{ url('stok/tambah') }}">+ Tambah Stok</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Stok ID</th>
            <th>Barang ID</th>
            <th>User ID</th>
            <th>Supplier ID</th>
            <th>Tanggal </th>
            <th>Jumlah</th>
             <th>Aksi</th>
        </tr>
       @foreach ($data as $d)
        <tr>
            <td>{{ $d->stok_id }}</td>
            <td>{{ $d->barang->barang_nama }}</td>
            <td>{{ $d->user->nama }}</td>
            <td>{{ $d->supplier->supplier_nama }}</td>
            <td>{{ $d->stok_tanggal }}</td>
            <td>{{ $d->stok_jumlah }}</td>
            <td>
                <a href="{{ url('stok/ubah/'.$d->stok_id) }}">Edit</a>
                <a href="{{ url('stok/hapus/'.$d->stok_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>