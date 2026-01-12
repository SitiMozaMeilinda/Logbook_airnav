@extends('layouts.airnav')

@section('title', 'Detail Aktivitas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Detail Aktivitas</h4>
                    <a href="{{ route('teknisi.history') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Judul Aktivitas:</strong>
                        <p class="fs-5">{{ $activity->judul_aktivitas }}</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Tanggal:</strong>
                        <p>{{ $activity->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Unit:</strong>
                        <p><span class="badge bg-secondary">{{ $activity->unit }}</span></p>
                    </div>
                    
                    <div class="col-12 mb-4">
                        <strong>Catatan:</strong>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($activity->catatan)) !!}
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <strong>Foto Dokumentasi:</strong>
                        @if($activity->foto && count($activity->foto) > 0)
                            <div class="row mt-3">
                                @foreach($activity->foto as $foto)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $foto) }}" 
                                             class="card-img-top" 
                                             alt="Foto dokumentasi"
                                             style="height: 200px; object-fit: cover; cursor: pointer;"
                                             onclick="openModal('{{ asset('storage/' . $foto) }}')">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>Tidak ada foto dokumentasi
                            </div>
                        @endif
                    </div>
                </div>

                @if($activity->comments->count() > 0)
                <div class="mt-5 pt-4 border-top">
                    <h5 class="mb-4">
                        <i class="fas fa-comments me-2 text-primary"></i>
                        Komentar Manager
                    </h5>
                    
                    <div class="comments-section">
                        @foreach($activity->comments as $comment)
                            <div class="card mb-3 border-warning">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1 text-warning">
                                                <i class="fas fa-user-tie me-1"></i>
                                                {{ $comment->manager->name }} (Manager)
                                            </h6>
                                            <p class="text-muted small mb-2">
                                                {{ $comment->created_at->format('d F Y H:i') }}
                                            </p>
                                            <p class="card-text mb-0">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Preview">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
</script>
@endsection