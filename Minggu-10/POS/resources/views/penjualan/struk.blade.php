<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: "DejaVu Sans", sans-serif; font-size: 10pt; }
        .struk-container { width: 100%; }
        h4, p { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 4px; font-size: 10pt; }
        .total { font-weight: bold; border-top: 1px dashed #000; padding-top: 5px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="struk-container">
        <h4>TOKO BAROKAH</h4>
        <p>Jl.Bandung no 09</p>
        <hr>

        <p><strong>Struk Penjualan</strong></p>
        <p>Kode: {{ $penjualan->penjualan_kode }}</p>
        <p>Tanggal: {{ $penjualan->penjualan_tanggal }}</p>
        <p>Pembeli: {{ $penjualan->pembeli }}</p>
        <p>Petugas: {{ $penjualan->user->username ?? '-' }}</p>

        <table>
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp
                @foreach ($penjualan->penjualanDetail as $d)
                    @php $subtotal = $d->harga; $grandTotal += $subtotal; @endphp
                    <tr>
                        <td>{{ $d->barang->barang_nama ?? '-' }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>{{ number_format($d->barang->harga_jual, 0, ',', '.') }}</td>
                        <td>{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
        <p style="text-align:center;">Terima kasih telah berbelanja</p>
    </div>
</body>
</html>
