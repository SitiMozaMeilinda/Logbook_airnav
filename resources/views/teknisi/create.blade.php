@extends('layouts.airnav')

@section('title', 'Add Data Aktivitas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Tambah Data Aktivitas</h4>
                
                <form action="{{ route('teknisi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="judul_aktivitas" class="form-label fw-semibold">Judul Aktivitas</label>
                            <input type="text" class="form-control" id="judul_aktivitas" name="judul_aktivitas" 
                                   placeholder="Masukkan judul aktivitas" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="divisi" class="form-label fw-semibold">Divisi</label>
                            <select class="form-select" id="divisi" name="divisi" required>
                                <option value="">Pilih Divisi</option>
                                <option value="CNSA">CNSA</option>
                                <option value="Support">Support</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label fw-semibold">Unit</label>
                            <select class="form-select" id="unit" name="unit" required>
                                <option value="">Pilih Unit</option>
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="catatan" class="form-label fw-semibold">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="6" 
                                      placeholder="Masukkan catatan aktivitas..." required></textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label for="foto" class="form-label fw-semibold">Foto Dokumentasi</label>
                            <input type="file" class="form-control" id="foto" name="foto[]" multiple accept="image/*">
                            <div class="form-text">maksimal 5MB per foto</div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Simpan Data
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    const unitOptions = {
        'CNSA': ['Communication', 'Navigation', 'Surveillance', 'Automation'],
        'Support': ['Listrik', 'Mekanikal', 'Bangunan']
    };

    document.getElementById('divisi').addEventListener('change', function() {
        const divisi = this.value;
        const unitSelect = document.getElementById('unit');
        
        unitSelect.innerHTML = '<option value="">Pilih Unit</option>';
        
        if (divisi && unitOptions[divisi]) {
            unitOptions[divisi].forEach(unit => {
                const option = document.createElement('option');
                option.value = unit;
                option.textContent = unit;
                unitSelect.appendChild(option);
            });
        }
    });
</script>
@endsection
@endsection