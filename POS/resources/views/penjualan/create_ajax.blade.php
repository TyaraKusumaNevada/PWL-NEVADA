<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                {{-- Header Penjualan --}}
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Petugas</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">- Pilih Petugas -</option>
                            @foreach($user as $u)
                                <option value="{{ $u->user_id }}">{{ $u->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Tanggal Penjualan</label>
                        <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    </div>
                </div>

                {{-- Detail Penjualan --}}
                <hr>
                <h6>Detail Barang</h6>
                <table class="table table-bordered" id="table-detail">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th style="width: 40px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="barang_id[]" class="form-control" required>
                                    <option value="">- Pilih Barang -</option>
                                    @foreach($barang as $b)
                                        <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="harga[]" class="form-control" min="1" required>
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control" min="1" required>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger btn-remove-row">&times;</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" id="btn-add-row" class="btn btn-sm btn-secondary">+ Tambah Barang</button>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    // Tambah / Hapus baris detail
    $('#btn-add-row').click(function() {
        let row = $('#table-detail tbody tr:first').clone();
        row.find('select, input').val('');
        $('#table-detail tbody').append(row);
    });
    $('#table-detail').on('click', '.btn-remove-row', function() {
        if ($('#table-detail tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

    // Validasi & AJAX submit
    $('#form-tambah').validate({
        rules: {
            user_id: { required: true, number: true },
            pembeli: { required: true, minlength: 3 },
            penjualan_tanggal: { required: true, date: true },
            'barang_id[]': { required: true, number: true },
            'harga[]': { required: true, number: true, min: 1 },
            'jumlah[]': { required: true, number: true, min: 1 }
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            element.closest('td, .form-group').append(error);
        },
        highlight: function(el) { $(el).addClass('is-invalid'); },
        unhighlight: function(el) { $(el).removeClass('is-invalid'); },

        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(res) {
                    if (res.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message });
                        dataPenjualan.ajax.reload();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: res.message });
                    }
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server.' });
                }
            });
            return false;
        }
    });
});
</script>
