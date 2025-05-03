<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penjualan Detail</title>
</head>
<body>
    <h1>Form Tambah Data Penjualan Detail</h1>
    <form method="post" action="{{ url('penjualan-detail/tambah_simpan/') }}">
        {{ csrf_field() }}

        <label>Kode Penjualan</label>
        <select>
            <option value="">-- Pilih Penjualan --</option>
            @foreach($penjualans as $penjualan)
                <option value="{{ $penjualan->penjualan_id }}">{{ $penjualan->penjualan_kode }}</option>
            @endforeach
        </select>
        <br>

        <label>Nama Barang</label>
        <select>
            <option value="">-- Pilih Barang --</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Harga</label>
        <input type="number" name="harga" placeholder="Masukkan Harga">
        <br>

        <label>Jumlah</label>
        <input type="number" name="jumlah" placeholder="Masukkan Jumlah">
        <br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>