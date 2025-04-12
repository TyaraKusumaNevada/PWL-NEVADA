<body>
    <h1>Form Tambah Data Kategori</h1>
    <form method="post" action="{{ url('kategori/tambah_simpan') }}">
        {{ csrf_field() }}

        <label>Kode Kategori</label>
        <input type="text" name="kategori_kode" placeholder="Masukan Kode Kategori">
        <br>

        <label>Nama Kategori</label>
        <input type="text" name="kategori_nama" placeholder="Masukan Nama Kategori">
        <br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>