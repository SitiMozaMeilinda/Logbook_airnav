@extends('layouts.airnav')

@section('title', 'History Aktivitas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-modern mb-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Filter Data</h4>
                
                <form method="GET" action="{{ route('teknisi.history') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="divisi" class="form-label fw-semibold">Divisi</label>
                            <select class="form-select" id="divisi" name="divisi">
                                <option value="">Semua Divisi</option>
                                <option value="CNSA" {{ request('divisi') == 'CNSA' ? 'selected' : '' }}>CNSA</option>
                                <option value="Support" {{ request('divisi') == 'Support' ? 'selected' : '' }}>Support</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="unit" class="form-label fw-semibold">Unit</label>
                            <select class="form-select" id="unit" name="unit">
                                <option value="">Semua Unit</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="search" class="form-label fw-semibold">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Cari judul aktivitas...">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card-modern">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Riwayat Aktivitas</h4>
                    <a href="{{ route('teknisi.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Data
                    </a>
                </div>

                {{-- Tampilkan pesan sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul Aktivitas</th>
                                <th>Divisi</th>
                                <th>Unit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                            <tr>
                                <td>{{ $activity->created_at->format('d F Y') }}</td>
                                <td>{{ $activity->judul_aktivitas }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $activity->divisi }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $activity->unit }}</span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('teknisi.show', $activity->activity_id) }}" class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('teknisi.edit', $activity->activity_id) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Hapus"
                                                onclick="showDeleteModal({{ $activity->activity_id }}, '{{ addslashes($activity->judul_aktivitas) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data aktivitas</p>
                                    <a href="{{ route('teknisi.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Data Pertama
                                    </a>
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

<!-- Custom Modal untuk Konfirmasi Hapus -->
<div id="customModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 8px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <h4 style="margin-bottom: 15px; color: #333;">Konfirmasi Hapus</h4>
        <p style="margin-bottom: 10px;">Apakah Anda yakin ingin menghapus data aktivitas?</p>
        <p style="font-weight: bold; margin-bottom: 20px; color: #005DAA;" id="modalActivityTitle"></p>
        <p style="color: red; font-size: 14px; margin-bottom: 25px;">Tindakan ini tidak dapat dibatalkan!</p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button id="confirmDeleteBtn" style="background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 500;">Ya, Hapus Data</button>
            <button onclick="closeModal()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 500;">Batal</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const unitOptions = {
        'CNSA': ['Communication', 'Navigation', 'Surveillance', 'Automation'],
        'Support': ['Listrik', 'Mekanikal', 'Bangunan']
    };

    let currentActivityId = null;

    // Fungsi untuk menampilkan modal konfirmasi
    function showDeleteModal(activityId, activityTitle) {
        console.log('Menampilkan modal untuk:', activityId, activityTitle);
        currentActivityId = activityId;
        document.getElementById('modalActivityTitle').textContent = `"${activityTitle}"`;
        document.getElementById('customModal').style.display = 'flex';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        document.getElementById('customModal').style.display = 'none';
        currentActivityId = null;
    }

    // Fungsi untuk menghapus activity
    function deleteActivity() {
        if (!currentActivityId) {
            alert('Error: Activity ID tidak ditemukan');
            return;
        }
        
        console.log('Menghapus activity ID:', currentActivityId);
        
        // Buat form dan submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/history/' + currentActivityId;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        
        console.log('Submit form ke:', form.action);
        form.submit();
    }

    // Setup ketika halaman loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - setup delete functionality');
        
        // Inisialisasi filter unit
        const initialDivisi = "{{ request('divisi') }}";
        const initialUnit = "{{ request('unit') }}";
        
        if (initialDivisi && unitOptions[initialDivisi]) {
            const unitSelect = document.getElementById('unit');
            unitOptions[initialDivisi].forEach(unit => {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                if (unit === initialUnit) {
                    option.selected = true;
                }
                unitSelect.appendChild(option);
            });
        }

        document.getElementById('divisi').addEventListener('change', function() {
            const divisi = this.value;
            const unitSelect = document.getElementById('unit');
            
            unitSelect.innerHTML = '<option value="">Semua Unit</option>';
            
            if (divisi && unitOptions[divisi]) {
                unitOptions[divisi].forEach(unit => {
                    const option = document.createElement('option');
                    option.value = unit;
                    option.textContent = unit;
                    unitSelect.appendChild(option);
                });
            }
        });

        // Setup confirm button
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            console.log('Konfirmasi hapus diklik');
            deleteActivity();
        });

        // Close modal ketika klik di luar
        document.getElementById('customModal').addEventListener('click', function(e) {
            if (e.target.id === 'customModal') {
                closeModal();
            }
        });
    });
</script>
@endsection