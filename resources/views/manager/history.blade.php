@extends('layouts.airnav')

@section('title', 'History Aktivitas - Manager')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-modern mb-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Filter Data</h4>
                
                <form method="GET" action="{{ route('manager.history') }}">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="divisi" class="form-label fw-semibold">Divisi</label>
                            <select class="form-select" id="divisi" name="divisi">
                                <option value="">Semua Divisi</option>
                                <option value="CNSA" {{ request('divisi') == 'CNSA' ? 'selected' : '' }}>CNSA</option>
                                <option value="Support" {{ request('divisi') == 'Support' ? 'selected' : '' }}>Support</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="unit" class="form-label fw-semibold">Unit</label>
                            <select class="form-select" id="unit" name="unit">
                                <option value="">Semua Unit</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="teknisi" class="form-label fw-semibold">Teknisi</label>
                            <select class="form-select" id="teknisi" name="user_id">
                                <option value="">Semua Teknisi</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->user_id }}" {{ request('user_id') == $user->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="search" class="form-label fw-semibold">Kata Kunci</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                value="{{ request('search') }}" placeholder="Cari judul...">
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
                    <span class="badge bg-info text-white">Manager View</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul Aktivitas</th>
                                <th>Divisi</th>
                                <th>Unit</th>
                                <th>Dibuat Oleh</th>
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
                                    <span class="badge bg-success text-white">{{ $activity->user->name ?? 'Unknown' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('manager.show', $activity->activity_id) }}" 
                                       class="btn btn-primary btn-sm" 
                                       title="Detail">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data aktivitas</p>
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

@section('scripts')
<script>
    const unitOptions = {
        'CNSA': ['Communication', 'Navigation', 'Surveillance', 'Automation'],
        'Support': ['Listrik', 'Mekanikal', 'Bangunan']
    };

    document.addEventListener('DOMContentLoaded', function() {
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
    });
</script>
@endsection