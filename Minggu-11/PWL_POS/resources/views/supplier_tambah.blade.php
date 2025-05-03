<body>
    <h1>Form Tambah Data Supplier</h1>
    <form method="post" action="{{ url('supplier/tambah_simpan') }}">
        {{ csrf_field() }}

        <label>Kode Supplier</label>
        <input type="text" name="supplier_kode" placeholder="Masukan Kode Supplier">
        <br>

        <label>Nama Supplier</label>
        <input type="text" name="supplier_nama" placeholder="Masukan Nama Supplier">
        <br>

        <label>Alamat Supplier</label>
        <input type="text" name="supplier_alamat" placeholder="Masukan Alamat Supplier">
        <br><br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>