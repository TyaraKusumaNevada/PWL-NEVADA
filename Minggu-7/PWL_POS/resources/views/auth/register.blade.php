<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Registration Page</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">

    <div class="register-box">
    <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="#" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Register akun baru</p>

        <form action="{{ route('register') }}" method="POST" id="registerForm">
        @csrf


        <div class="input-group mb-3">
            <select name="level_id" class="form-control" required>
            <option value="">-- Pilih Level --</option>
            @foreach($levels as $level)
                <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
            @endforeach
            </select>
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user-tag"></span>
            </div>
            </div>
        </div>

        <!-- Username -->
        <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required minlength="3">
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
            </div>
        </div>

        <!-- Nama Lengkap -->
        <div class="input-group mb-3">
            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required maxlength="100">
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-id-card"></span>
            </div>
            </div>
        </div>

        <!-- Password -->
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required minlength="6">
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
            </div>
        </div>

        <!-- Konfirmasi Password -->
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required minlength="6">
            <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
            </div>
        </div>

        <!-- Checkbox Terms -->
        <div class="row">
            <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                Saya menyetujui <a href="#">syarat & ketentuan</a>
                </label>
            </div>
            </div>
            <!-- Tombol Submit -->
            <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </div>
        </div>
        </form>

        <a href="{{ route('login') }}" class="text-center">Saya sudah punya akun</a>
    </div>
    </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery Validation Plugin (CDN) -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- SweetAlert2 (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
    $("#registerForm").validate({
        rules: {
            level_id: { required: true },
            username: { required: true, minlength: 3 },
            nama: { required: true, maxlength: 100 },
            password: { required: true, minlength: 6 },
            password_confirmation: { required: true, minlength: 6, equalTo: "[name='password']" },
            terms: { required: true }
        },
        messages: {
            level_id: "Pilih level akun Anda",
            username: {
                required: "Masukkan username",
                minlength: "Username minimal 3 karakter"
            },
            nama: {
                required: "Masukkan nama lengkap",
                maxlength: "Nama tidak boleh lebih dari 100 karakter"
            },
            password: {
                required: "Masukkan password",
                minlength: "Password minimal 6 karakter"
            },
            password_confirmation: {
                required: "Konfirmasi password wajib diisi",
                equalTo: "Password dan konfirmasi harus sama"
            },
            terms: "Anda harus menyetujui syarat & ketentuan"
        },
        errorPlacement: function(error, element) {
            // Menggunakan bawaan Bootstrap untuk pesan error
            error.addClass('invalid-feedback d-block');
            if (element.attr("name") == "terms") {
                error.insertAfter(element.closest('.icheck-primary'));
            } else {
                error.insertAfter(element.closest('.input-group'));
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            // Kirim data melalui Ajax menggunakan $.ajax (sana dengn fitur login)
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registrasi Berhasil',
                            text: response.message,
                            showConfirmButton: true
                        }).then(function() {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registrasi Gagal',
                            text: "Terjadi kesalahan. Pastikan username belum dipakai dan data yang Anda masukkan valid."
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: "Terjadi kesalahan pada sistem. Silakan coba lagi."
                    });
                }


            });
            return false;
        }
    });
    });
</script>
</body>
</html>