<body>
    <h1>Form Tambah Data Stok</h1>
    <form method="post" action="{{ url('stok/tambah_simpan') }}">
        {{ csrf_field() }}

        <label>Barang</label>
        <select name="barang_id">
            <option value="">-- Pilih Barang --</option>
            @foreach($barang as $barang)
                <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
            @endforeach
        </select>
        <br>

        <label>User</label>
        <select name="user_id">
            <option value="">-- Pilih User --</option>
            @foreach($user as $user)
                <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Supplier</label>
        <select name="supplier_id">
            <option value="">-- Pilih Supplier --</option>
            @foreach($supplier as $supplier)
                <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_nama }}</option>
            @endforeach
        </select>
        <br>

        <label>Tanggal Stok</label>
        <input type="datetime-local" name="stok_tanggal">
        <br>

        <label>Jumlah Stok</label>
        <input type="number" name="stok_jumlah" placeholder="Masukan Jumlah Stok">
        <br><br>

        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
</body>