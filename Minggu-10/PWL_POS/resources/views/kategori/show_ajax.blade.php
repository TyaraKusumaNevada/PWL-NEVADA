@empty($kategori)
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
                    Data kategori tidak ditemukan.
                </div>
                <a href="{{ url('/kategori') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm">
                    <tbody style="font-size: 0.95rem;">
                        <tr>
                            <th class="text-muted" style="width: 30%;">ID</th>
                            <td>{{ $kategori->kategori_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Kode Kategori</th>
                            <td>{{ $kategori->kategori_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Nama Kategori</th>
                            <td>{{ $kategori->kategori_nama }}</td>
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
