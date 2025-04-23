{{-- IMplementasi js 3 --}}
{{-- <!DOCTYPE html>
<html>
<head>
    <title>Data Level Pengguna</title>
</head>
<body>
    <h1>Data Level Pengguna</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Kode Level</th>
            <th>Nama Level</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->level_id }}</td>
            <td>{{ $d->level_kode }}</td>
            <td>{{ $d->level_nama }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html> --}}

{{-- implementasi js 4 --}}

<!DOCTYPE html>
<html>
<head>
    <title>Data Level</title>
</head>
<body>
    <h1>Data Level</h1>
    <a href="{{ url('level/tambah') }}">Tambah Level</a>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td>ID</td>
            <td>Kode Level</td>
            <td>Nama Level</td>
            <td>Aksi</td>
        </tr>
       @foreach  ($data as $d)
        <tr>
            <td>{{ $d->level_id }}</td>
            <td>{{ $d->level_kode }}</td>
            <td>{{ $d->level_nama }}</td>
            <td>
                <a href="{{ url('level/ubah/'.$d->level_id) }}">Edit</a>
                <a href="{{ url('level/hapus/'.$d->level_id) }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>