<div class="modal-dialog">
    <div class="modal-content">
        <form id="formUpdatePhoto" action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                   <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="foto">Pilih Foto (jpg, jpeg, png)</label>
                    <input type="file" name="foto" id="foto" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Foto</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Proses form submit menggunakan AJAX
    $('#formUpdatePhoto').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                if(response.status === 'success'){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // Update foto di tampilan profil jika ada elemen <img> yang sesuai
                    $('img[alt="Foto Profil"]').attr('src', response.foto_path);
                    $('#updateProfileModal').modal('hide');
                }
            },
            error: function(xhr){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengunggah foto!'
                });
            }
        });
    });
</script>
