@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @empty($penjualan)
            <div class="alert alert-danger">
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ $penjualan->penjualan_id }}</td>
                </tr>
                <tr>
                    <th>Kode Penjualan</th>
                    <td>{{ $penjualan->penjualan_kode }}</td>
                </tr>
                <tr>
                    <th>Pembeli</th>
                    <td>{{ $penjualan->pembeli }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $penjualan->penjualan_tanggal }}</td>
                </tr>
                <tr>
                    <th>User</th>
                    <td>{{ $penjualan->user->username ?? '-' }}</td>
                </tr>
            </table>

            <h5>Detail Penjualan</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->penjualanDetail as $key => $detail)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $detail->barang->barang_nama ?? $detail->barang_id }}</td>
                        <td>{{ $detail->harga }}</td>
                        <td>{{ $detail->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endempty
        <a href="{{ url('penjualan') }}" class="btn btn-default btn-sm mt-2">Kembali</a>
    </div>
</div>
@endsection
