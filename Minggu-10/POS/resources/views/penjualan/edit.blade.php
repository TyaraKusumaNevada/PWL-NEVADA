@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>

    <div class="card-body">
        @empty($penjualan)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
            <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
            <form method="POST" action="{{ url('penjualan/' . $penjualan->penjualan_id) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-2 col-form-label">Tanggal</label>
                    <div class="col-10">
                        <input type="datetime-local" name="penjualan_tanggal" class="form-control"
                            value="{{ old('penjualan_tanggal', date('Y-m-d\TH:i', strtotime($penjualan->penjualan_tanggal))) }}" required>
                        @error('penjualan_tanggal')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Kode</label>
                    <div class="col-10">
                        <input type="text" name="penjualan_kode" class="form-control"
                            value="{{ old('penjualan_kode', $penjualan->penjualan_kode) }}" required>
                        @error('penjualan_kode')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Pembeli</label>
                    <div class="col-10">
                        <input type="text" name="pembeli" class="form-control"
                            value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                        @error('pembeli')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">Kasir</label>
                    <div class="col-10">
                        <select name="user_id" class="form-control" required>
                            <option value="">- Pilih User -</option>
                            @foreach($users as $item)
                                <option value="{{ $item->user_id }}" {{ old('user_id', $penjualan->user_id) == $item->user_id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label"></label>
                    <div class="col-10">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
