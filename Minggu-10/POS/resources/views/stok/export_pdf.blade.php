<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {
    font-family: "Times New Roman", Times, serif;
    margin: 6px 20px 5px 20px;
    line-height: 15px;
}
table {
    width: 100%;
    border-collapse: collapse;
}

/* Border hanya untuk tabel data stok */
.table-bordered td, 
.table-bordered th {
    border: 1px solid black;
    padding: 4px 3px;
}

th {
    text-align: left;
}
.border-bottom-header {
    border-bottom: 1px solid black;
}
.text-center {
    text-align: center;
}
.text-right {
    text-align: right;
}
</style>
</head>
<body>

<!-- Header tanpa border kotak -->
<table class="border-bottom-header">
    <tr>
        <td width="15%" class="text-center">
            <img src="{{ asset('polinema-bw.jpeg') }}" class="image" style="height: 80px;">
        </td>
        <td width="85%" class="text-center">
            <div><strong>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</strong></div>
            <div><strong>POLITEKNIK NEGERI MALANG</strong></div>
            <div>Jl. Soekarno-Hatta No. 9 Malang 65141</div>
        </td>
    </tr>
</table>

<h3 class="text-center">LAPORAN DATA STOK</h3>

<!-- Tabel stok dengan border -->
<table class="table-bordered">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>User</th>
            <th>Supplier</th>
        </tr>
    </thead>
    <tbody>
        @foreach($stok as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->stok_tanggal }}</td>
            <td>{{ $item->barang->barang_nama ?? '-' }}</td>
            <td class="text-right">{{ number_format($item->stok_jumlah, 0, ',', '.') }}</td>
            <td>{{ $item->user->nama ?? '-' }}</td>
            <td>{{ $item->supplier->supplier_nama ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
