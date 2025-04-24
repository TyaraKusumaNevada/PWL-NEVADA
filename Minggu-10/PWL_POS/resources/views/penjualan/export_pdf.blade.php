<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 10pt; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        h3 { text-align: center; }
    </style>
</head>
<body>
    <h3>LAPORAN PENJUALAN</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Penjualan</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th>Petugas</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($penjualan as $p)
                @foreach ($p->penjualanDetail as $d)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $p->penjualan_kode }}</td>
                        <td>{{ $p->penjualan_tanggal }}</td>
                        <td>{{ $p->pembeli }}</td>
                        <td>{{ $p->user->username ?? '-' }}</td>
                        <td>{{ $d->barang->barang_nama ?? '-' }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>{{ number_format($d->barang->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ number_format($d->harga, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
