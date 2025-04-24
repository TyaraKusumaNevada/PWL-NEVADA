<body>
    <h1>Form Tambah Data User</h1>
    <form method="post" action="{{ url('user/tambah_simpan') }}">

        {{ csrf_field() }}

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukan Username">
        <br>
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukan Nama">
        <br>
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password">
        <br>
        <select name="level_id">
            <option value="">-- Pilih Level --</option>
            @foreach($levels as $level)
                <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
            @endforeach
        </select>
        <br><br>
        <input type="submit" class="btn btn-success" value="Simpan">

    </form>
</body>