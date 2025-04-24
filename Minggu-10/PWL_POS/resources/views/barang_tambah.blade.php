<body>
    <h1>Form Tambah Data Barang</h1>
    <form method="post" action="{{ url('barang/tambah_simpan') }}">
        {{ csrf_field() }}

        <select name="kategori_id">
            <option value="">-- Pilih Kategori Barang --</option>
            @foreach($kategori as $kategori)
                <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
            @endforeach
        </select>
        <br>
        <label>Kode Barang</label>
        <input type="text" name="barang_kode" placeholder="Masukan Kode Barang">
        <br>

        <label>Nama Barang</label>
        <input type="text" name="barang_nama" placeholder="Masukan Nama Barang">
        <br>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" placeholder="Masukan Harga Beli">
        <br>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" placeholder="Masukan Harga Jual">
        <br><br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>