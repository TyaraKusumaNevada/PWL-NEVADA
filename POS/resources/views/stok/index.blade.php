@extends('layouts.template')
@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Manajemen Stok</h3>
      <div class="card-tools d-flex gap-2">
        {{-- Tombol Tambah Stok --}}
        <a class="btn btn-sm btn-primary" href="{{ url('stok/create') }}">Tambah Stok</a>
        <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Ajax</button>
      </div>
    </div>

    <div class="card-body">
      {{-- Notifikasi sukses atau error --}}
      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      {{-- Filter Barang --}}
      <div class="row mb-3">
        <div class="col-md-6">
          <div class="form-group row">
            <label class="col-4 col-form-label">Filter Barang:</label>
            <div class="col-8">
              <select class="form-control" id="barang_id" name="barang_id">
                <option value="">- Semua -</option>
                @foreach($barang as $item)
                  <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                @endforeach
              </select>
              <small class="form-text text-muted">Pilih barang untuk melihat stok terkait.</small>
            </div>
          </div>
        </div>
      </div>



      {{-- Tabel Data Stok --}}
      <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
        <thead>
          <tr>
            <th>ID</th>
            <th>Barang</th>
            <th>Jumlah Stok</th>
            <th>Supplier</th>
            <th>Tanggal</th>
            <th>Pengguna</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    var dataStok;
    $(document).ready(function() {
        dataStok = $('#table_stok').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "{{ url('stok/list') }}", // Pastikan route ini sesuai
                "type": "POST",
                "data": function (d) {
                    d.barang_id   = $('#barang_id').val();
                    d.user_id     = $('#user_id').val();
                    d.supplier_id = $('#supplier_id').val();
                }
            },
            searchDelay: 1000,
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "barang.barang_nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "user.username",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "supplier.supplier_nama",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "stok_tanggal",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "stok_jumlah",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Reload DataTables jika filter berubah
        $('#barang_id, #user_id, #supplier_id').on('change', function() {
            dataStok.ajax.reload();
        });

    });
</script>
@endpush