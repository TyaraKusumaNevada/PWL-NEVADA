<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Penjualan Detail</title>
</head>
<body>
    <h1>Form Ubah Data Penjualan Detail</h1>
    <a href="{{ url('/penjualan-detail') }}">Kembali</a>
    <br><br>

    <form method="post" action="{{ url('penjualan-detail/ubah_simpan/'. $data->detail_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Kode Penjualan</label>
        <select name="penjualan_id">
            <option value="{{ $data->penjualan_id }}">{{ $data->penjualan->penjualan_kode }}</option>
            @foreach($penjualans as $penjualan)
                <option value="{{ $penjualan->penjualan_id }}">{{ $penjualan->penjualan_kode }}</option>
            @endforeach
        </select>
        <br>

        <label>Nama Barang</label>
        <select name="barang_id">
            <option value="{{ $data->barang_id }}">{{ $data->barang->barang_nama }}</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Harga</label>
        <input type="number" name="harga" value="{{ $data->harga }}" placeholder="Masukkan Harga">
        <br>

        <label>Jumlah</label>
        <input type="number" name="jumlah" value="{{ $data->jumlah }}" placeholder="Masukkan Jumlah">
        <br><br>

        <input type="submit" value="Ubah">
    </form>
</body>
</html>