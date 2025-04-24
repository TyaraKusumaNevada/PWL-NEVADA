<body>
    <h1>Form Tambah Data Level</h1>
    <form method="post" action="{{ url('level/tambah_simpan') }}">
        {{ csrf_field() }}

        <label>Kode Level</label>
        <input type="text" name="level_kode" placeholder="Masukan Kode Level">
        <br>

        <label>Nama Level</label>
        <input type="text" name="level_nama" placeholder="Masukan Nama Level">
        <br><br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>