<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>
    <h1>Data Supplier</h1>
    <a href="{{ url('supplier/tambah') }}">+ Tmabah Supplier</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>Supplier ID</th>
            <th>Kode Supplier</th>
            <th>Nama Supplier</th>
            <th>Alamat Supplier</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->supplier_id }}</td>
            <td>{{ $d->supplier_kode }}</td>
            <td>{{ $d->supplier_nama }}</td>
            <td>{{ $d->supplier_alamat }}</td>
            <td>
                <a href="{{ url('supplier/ubah/'.$d->supplier_id) }}">Edit</a>
                <a href="{{ url('supplier/hapus/'.$d->supplier_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
    </table>
</body>
</html>