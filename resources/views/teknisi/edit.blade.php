@extends('layouts.airnav')

@section('title', 'Edit Aktivitas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Edit Data Aktivitas</h4>
                
                <form action="{{ route('teknisi.update', $activity) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="judul_aktivitas" class="form-label fw-semibold">Judul Aktivitas</label>
                            <input type="text" class="form-control" id="judul_aktivitas" name="judul_aktivitas" 
                                   value="{{ $activity->judul_aktivitas }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="divisi" class="form-label fw-semibold">Divisi</label>
                            <select class="form-select" id="divisi" name="divisi" required>
                                <option value="CNSA" {{ $activity->divisi == 'CNSA' ? 'selected' : '' }}>CNSA</option>
                                <option value="Support" {{ $activity->divisi == 'Support' ? 'selected' : '' }}>Support</option>
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
                            <textarea class="form-control" id="catatan" name="catatan" rows="6" required>{{ $activity->catatan }}</textarea>
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-semibold">Foto Saat Ini</label>
                            @if($activity->foto && count($activity->foto) > 0)
                                <div class="row mt-2">
                                    @foreach($activity->foto as $index => $foto)
                                    <div class="col-md-4 mb-3 photo-container" data-photo-index="{{ $index }}">
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $foto) }}" 
                                                 class="card-img-top" 
                                                 alt="Foto {{ $loop->iteration }}"
                                                 style="height: 150px; object-fit: cover;">
                                            <div class="card-body text-center">
                                                <small class="text-muted d-block">Foto {{ $loop->iteration }}</small>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger mt-1"
                                                        onclick="showDeleteConfirmation({{ $index }})">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="deleted_photos" id="deleted_photos" value="">
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>Tidak ada foto
                                </div>
                            @endif
                        </div>

                        <div class="col-12 mb-4">
                            <label for="new_foto" class="form-label fw-semibold">Tambah Foto Baru</label>
                            <input type="file" class="form-control" id="new_foto" name="new_foto[]" multiple accept="image/*">
                            <div class="form-text">Pilih foto baru (bisa lebih dari 1)</div>
                            
                            <div id="photoPreview" class="row mt-3 d-none">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Preview Foto Baru:</label>
                                    <div class="row" id="previewContainer"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Update
                                </button>
                                <a href="{{ route('teknisi.history') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Foto -->
<div id="deletePhotoModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus foto ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeletePhoto">Ya, Hapus</button>
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

    let deletedPhotos = [];
    let currentDeleteIndex = null;

    document.addEventListener('DOMContentLoaded', function() {
        const divisi = "{{ $activity->divisi }}";
        const unit = "{{ $activity->unit }}";
        const unitSelect = document.getElementById('unit');
        
        document.getElementById('divisi').value = divisi;
        
        if (divisi && unitOptions[divisi]) {
            unitOptions[divisi].forEach(unitOption => {
                const option = document.createElement('option');
                option.value = unitOption;
                option.textContent = unitOption;
                if (unitOption === unit) {
                    option.selected = true;
                }
                unitSelect.appendChild(option);
            });
        }

        // Event listener untuk konfirmasi hapus
        document.getElementById('confirmDeletePhoto').addEventListener('click', function() {
            if (currentDeleteIndex !== null) {
                // Sembunyikan foto dari tampilan
                const photoElement = document.querySelector(`.photo-container[data-photo-index="${currentDeleteIndex}"]`);
                if (photoElement) {
                    photoElement.style.display = 'none';
                }
                
                // Tambahkan ke array foto yang dihapus
                if (!deletedPhotos.includes(currentDeleteIndex)) {
                    deletedPhotos.push(currentDeleteIndex);
                }
                
                // Update input hidden
                document.getElementById('deleted_photos').value = JSON.stringify(deletedPhotos);
                
                // Tutup modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('deletePhotoModal'));
                modal.hide();
                currentDeleteIndex = null;
            }
        });
    });

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

    function showDeleteConfirmation(index) {
        currentDeleteIndex = index;
        const modal = new bootstrap.Modal(document.getElementById('deletePhotoModal'));
        modal.show();
    }

    document.getElementById('new_foto').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewContainer');
        const photoPreview = document.getElementById('photoPreview');
        
        previewContainer.innerHTML = '';
        
        if (this.files.length > 0) {
            photoPreview.classList.remove('d-none');
            
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height: 120px; object-fit: cover;">
                            <div class="card-body text-center p-2">
                                <small class="text-muted">Foto ${i + 1}</small>
                            </div>
                        </div>
                    `;
                    previewContainer.appendChild(col);
                }
                
                reader.readAsDataURL(file);
            }
        } else {
            photoPreview.classList.add('d-none');
        }
    });
</script>
@endsection
@endsection