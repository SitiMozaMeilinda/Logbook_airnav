@extends('layouts.airnav')

@section('title', 'Tambah Data Pegawai')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card-modern mb-4">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Tambah Data Pegawai</h4>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('manager.storepegawai') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="Masukkan Nama Lengkap Pegawai" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text" name="username" class="form-control"
                               placeholder="Masukkan Username" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Masukkan Password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <!-- =========================
             TABEL HISTORY TEKNISI
        ========================== -->
        <div class="card-modern">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="fas fa-users me-2"></i>Daftar Teknisi Terdaftar
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th> </tr>
                        </thead>
                        <tbody>
                            @forelse($teknisi as $index => $user)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    {{ $user->created_at->format('d-m-Y') }}
                                </td>
                                <td class="text-center">
                                    <form id="delete-form-{{ $user->user_id }}" action="{{ route('manager.hapuspegawai', $user->user_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $user->user_id }}', '{{ $user->name }}')">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted"> Belum ada data teknisi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: "Apakah Anda yakin ingin menghapus teknisi '" + userName + "'? Semua data aktivitas terkait juga akan terhapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            // Membuat pop-up muncul di tengah (default SweetAlert2)
            position: 'center' 
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form berdasarkan ID yang dibuat di poin nomor 2
                document.getElementById('delete-form-' + userId).submit();
            }
        })
    }
</script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false
        });
    </script>
@endif
