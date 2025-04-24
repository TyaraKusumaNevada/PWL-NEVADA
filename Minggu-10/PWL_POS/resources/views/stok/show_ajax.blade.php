@empty($stok)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data stok tidak ditemukan.
                </div>
                <a href="{{ url('/stok') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tbody style="font-size: 0.95rem;">
                        <tr>
                            <th class="text-muted" style="width: 30%;">ID</th>
                            <td>{{ $stok->stok_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Barang</th>
                            <td>{{ $stok->barang->barang_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">User</th>
                            <td>{{ $stok->user->username ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Supplier</th>
                            <td>{{ $stok->supplier->supplier_nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tanggal</th>
                            <td>{{ $stok->stok_tanggal }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Jumlah</th>
                            <td>{{ $stok->stok_jumlah }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-info">Tutup</button>
            </div>
        </div>
    </div>
@endempty
