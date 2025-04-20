@extends('layouts.template')
@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Manajemen Stok</h3>
      <div class="card-tools d-flex flex-wrap gap-2">
    <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-sm btn-info"><i class="fa fa-upload mr-2"></i> Import Stok</button>
    <a href="{{ url('/stok/export_excel') }}" class="btn btn-sm btn-primary"><i class="fa fa-file-excel mr-2"></i> Export Excel</a>
    <a href="{{ url('/stok/export_pdf') }}" class="btn btn-sm btn-warning "><i class="fa fa-file-pdf mr-2"></i> Export PDF</a>
    <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-sm btn-success"><i class="fa fa-plus mr-2"></i> Tambah Stok</button>
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
            <th>User</th>
            <th>Supplier</th>
            <th>Tanggal</th>
            <th>Jumlah Stok</th>
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