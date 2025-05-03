<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penjualan</title>
</head>
<body>
    <h1>Form Tambah Data Penjualan</h1>
    <form method="post" action="{{ url('penjualan/tambah_simpan') }}">
        {{ csrf_field() }}

        <label>User ID</label>
        <select name="user_id">
            <option value="">-- Pilih User --</option>
            @foreach($users as $user)
                <option value="{{ $user->user_id }}">{{ $user->username }}</option>
            @endforeach
        </select>
        <br>

        <label>Nama Pembeli</label>
        <input type="text" name="pembeli" placeholder="Masukkan Nama Pembeli">
        <br>

        <label>Kode Penjualan</label>
        <input type="text" name="penjualan_kode" placeholder="Masukkan Kode Penjualan">
        <br>

        <label>Tanggal Penjualan</label>
        <input type="datetime-local" name="penjualan_tanggal">
        <br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>