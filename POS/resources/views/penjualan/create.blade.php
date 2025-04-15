@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal" id="formPenjualan">
            @csrf
            <!-- Input Header Penjualan -->
            <div class="form-group row">
                <label class="col-2 control-label">User</label>
                <div class="col-10">
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih User -</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Pembeli</label>
                <div class="col-10">
                    <input type="text" name="pembeli" class="form-control" value="{{ old('pembeli') }}" required>
                    @error('pembeli') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Kode Penjualan</label>
                <div class="col-10">
                    <input type="text" name="penjualan_kode" class="form-control" value="{{ old('penjualan_kode') }}" required>
                    @error('penjualan_kode') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Tanggal</label>
                <div class="col-10">
                    <input type="date" name="penjualan_tanggal" class="form-control" value="{{ old('penjualan_tanggal') }}" required>
                    @error('penjualan_tanggal') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <!-- Input Detail Penjualan -->
            <h5>Detail Penjualan</h5>
            <div id="detail_penjualan_container">
                <div class="detail-row row mb-2">
                    <div class="col-md-3">
                        <label>Barang</label>
                        <select name="barang_id[]" class="form-control barang-select" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $br)
                                <option value="{{ $br->barang_id }}" data-price="{{ $br->harga_jual }}">{{ $br->barang_nama }}</option>
                            @endforeach
                        </select>
                        @error('barang_id.*') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-2">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control jumlah" required>
                        @error('jumlah.*') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-2">
                        <label>Harga</label>
                        <!-- Harga dihitung otomatis -->
                        <input type="text" name="harga[]" class="form-control harga" readonly required>
                        @error('harga.*') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="button" class="btn btn-danger btn-sm hapus-detail">Hapus</button>
                    </div>
                </div>
            </div>
            <!-- Tombol untuk menambah detail -->
            <div class="form-group row">
                <div class="col-12">
                    <button type="button" id="tambah_detail" class="btn btn-warning btn-sm">Tambah Detail</button>
                </div>
            </div>
            <!-- Tombol Submit -->
            <div class="form-group row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a href="{{ url('penjualan') }}" class="btn btn-default btn-sm">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
// Fungsi untuk menghitung harga otomatis berdasarkan harga_jual dan jumlah
function hitungHarga(detailRow) {
    var selectedOption = detailRow.find('.barang-select option:selected');
    var hargaJual = parseFloat(selectedOption.data('price')) || 0;
    var jumlah = parseFloat(detailRow.find('.jumlah').val()) || 0;
    var total = hargaJual * jumlah;
    detailRow.find('.harga').val(total);
}

// Event ketika ada perubahan pada dropdown barang atau input jumlah di tiap baris
$(document).on('change', '.barang-select, .jumlah', function(){
    var row = $(this).closest('.detail-row');
    hitungHarga(row);
});

// Tambah baris detail penjualan
$('#tambah_detail').click(function(){
    var newRow = `<div class="detail-row row mb-2">
                    <div class="col-md-3">
                        <label>Barang</label>
                        <select name="barang_id[]" class="form-control barang-select" required>
                            <option value="">- Pilih Barang -</option>
                            @foreach($barang as $br)
                                <option value="{{ $br->barang_id }}" data-price="{{ $br->harga_jual }}">{{ $br->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah[]" class="form-control jumlah" required>
                    </div>
                    <div class="col-md-2">
                        <label>Harga</label>
                        <input type="text" name="harga[]" class="form-control harga" readonly required>
                    </div>
                    <div class="col-md-2 align-self-end">
                        <button type="button" class="btn btn-danger btn-sm hapus-detail">Hapus</button>
                    </div>
                </div>`;
    $('#detail_penjualan_container').append(newRow);
});

// Hapus baris detail penjualan
$(document).on('click', '.hapus-detail', function(){
    $(this).closest('.detail-row').remove();
});
</script>
@endpush
