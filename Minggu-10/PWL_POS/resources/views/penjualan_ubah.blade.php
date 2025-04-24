<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Penjualan</title>
</head>
<body>
    <h1>Form Ubah Data Penjualan</h1>
    <a href="{{ url('penjualan/') }}">Kembali</a>
    <br><br>

    <form method="post" action="{{ url('penjualan/ubah_simpan/' . $data->penjualan_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>User ID</label>
        <select name="user_id">
            <option value="{{ $data->user_id }}">{{ $data->user->nama }}</option>
            @foreach($users as $user)
                <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Nama Pembeli</label>
        <input type="text" name="pembeli" placeholder="Masukkan Nama Pembeli" value="{{ $data->pembeli }}">
        <br>

        <label>Kode Penjualan</label>
        <input type="text" name="penjualan_kode" placeholder="Masukkan Kode Penjualan" value="{{ $data->penjualan_kode }}">
        <br>

        <label>Tanggal Penjualan</label>
        <input type="datetime-local" name="penjualan_tanggal" value="{{ date('Y-m-d\TH:i', strtotime($data->penjualan_tanggal)) }}">

        <br><br>
        <input type="submit" value="Ubah">
    </form>
</body>
</html>