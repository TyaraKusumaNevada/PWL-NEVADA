
@extends('layouts.template')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
    <h3 class="card-title">Tambah Stok</h3>
    <div class="card-tools"></div>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ url('stok') }}" class="form-horizontal">
      @csrf

      <!-- Pilih Barang -->
      <div class="form-group row">
      <label class="col-2 control-label col-form-label">Barang</label>
      <div class="col-10">
        <select class="form-control" id="barang_id" name="barang_id" required>
        <option value="">- Pilih Barang -</option>
        @foreach($barang as $item)
      <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
    @endforeach
        </select>
        @error('barang_id')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
      </div>
      </div>

      <!-- Pilih Pengguna -->
      <div class="form-group row">
      <label class="col-2 control-label col-form-label">Pengguna</label>
      <div class="col-10">
        <select class="form-control" id="user_id" name="user_id" required>
        <option value="">- Pilih Pengguna -</option>
        @foreach($user as $item)
      <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
    @endforeach
        </select>
        @error('user_id')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
      </div>
      </div>

      <!-- Pilih Supplier -->
      <div class="form-group row">
      <label class="col-2 control-label col-form-label">Supplier</label>
      <div class="col-10">
        <select class="form-control" id="supplier_id" name="supplier_id" required>
        <option value="">- Pilih Supplier -</option>
        @foreach($supplier as $item)
      <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
    @endforeach
        </select>
        @error('supplier_id')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
      </div>
      </div>


      <!-- Input Tanggal -->
      <div class="form-group row">
      <label class="col-2 control-label col-form-label">Tanggal</label>
      <div class="col-10">
        <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal"
        value="{{ old('stok_tanggal') }}" required>
        @error('stok_tanggal')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
      </div>
      </div>

      <!-- Input Jumlah Stok -->
      <div class="form-group row">
      <label class="col-2 control-label col-form-label">Jumlah Stok</label>
      <div class="col-10">
        <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah" value="{{ old('stok_jumlah') }}"
        required min="1">
        @error('stok_jumlah')
      <small class="form-text text-danger">{{ $message }}</small>
    @enderror
      </div>
      </div>

      <!-- Tombol Simpan & Kembali -->
      <div class="form-group row">
      <label class="col-2 control-label col-form-label"></label>
      <div class="col-10">
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
        <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
      </div>
      </div>

    </form>
    </div>
  </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
