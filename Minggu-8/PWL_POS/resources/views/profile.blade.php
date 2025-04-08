@extends('layouts.template')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- Kartu Profil -->
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-body p-4">
            <div class="d-flex flex-column align-items-center text-center">
              <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('adminlte/dist/img/user2-160x160.jpg') }}"
                   class="rounded-circle shadow-sm mb-3"
                   alt="Foto Profil"
                   width="140" height="140">
              <h4 class="fw-bold">{{ $user->nama }}</h4>
              <p class="text-muted mb-2"><i class="fas fa-user-circle"></i> {{ $user->username }}</p>
              <button id="btnEditProfile" class="btn btn-primary btn-sm mt-2">
                <i class="fas fa-edit"></i> Ubah Profil
              </button>
            </div>
          </div>
        </div>
        <!-- End Kartu Profil -->
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#updateProfileModal').load(url, function () {
            $('#updateProfileModal').modal('show');
        });
    }

    $(document).ready(function(){
        $('#btnEditProfile').click(function(){
            modalAction("{{ url('user/profile_ajax') }}");
        });
    });
</script>
@endpush
