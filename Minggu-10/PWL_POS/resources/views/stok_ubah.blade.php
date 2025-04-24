<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Stok</title>
</head>
<body>
    <h1>Form Ubah Data Stok</h1>
    <a href="/stok">Kembali</a>
    <br><br>
    <form method="post" action="{{ url('stok/ubah_simpan/' . $data->stok_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Barang</label>
        <select name="barang_id">
            <option value="{{ $data->barang_id }}">
                {{ $data->barang->barang_nama }}
            </option>
            @foreach($barang as $barang)
                <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
            @endforeach
        </select>
        <br>

        <label>User</label>
        <select name="user_id">
            <option value="{{ $data->user_id }}">
                {{ $data->user->nama }}
            </option>
            @foreach($user as $user)
                <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Supplier</label>
        <select name="supplier_id">
            <option value="{{ $data->supplier_id }}">
                {{ $data->supplier->supplier_nama }}
            </option>
            @foreach($supplier as $supplier)
                <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Tanggal Stok</label>
        <input type="datetime-local" name="stok_tanggal" value="{{ date('Y-m-d\TH:i', strtotime($data->stok_tanggal)) }}">
        <br>

        <label>Jumlah Stok</label>
        <input type="number" name="stok_jumlah" placeholder="Masukan Jumlah" value="{{ $data->stok_jumlah }}">
        <br><br>

        <input type="submit" value="Ubah">
    </form>
</body>
</html>