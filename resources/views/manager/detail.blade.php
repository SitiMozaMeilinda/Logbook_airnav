@extends('layouts.airnav')

@section('title', 'Detail Aktivitas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card-modern">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0">Detail Aktivitas</h4>
                    <a href="{{ route('manager.history') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Judul Aktivitas:</strong>
                        <p class="fs-5">{{ $activity->judul_aktivitas }}</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Tanggal Dibuat:</strong>
                        <p>{{ $activity->created_at->format('d F Y') }}</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Unit:</strong>
                        <p><span class="badge bg-secondary">{{ $activity->unit }}</span></p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Dibuat Oleh</label>
                        <p>{{ $activity->user->name ?? 'Unknown' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Terakhir Diupdate</label>
                        <p>{{ $activity->updated_at->format('d F Y') }}</p>
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

                <div class="mt-5 pt-4 border-top">
                    <h5 class="mb-4">Komentar Manager</h5>
                    
                    @auth
                        @if(auth()->user()->role === 'manager')
                        <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="activity_id" value="{{ $activity->activity_id }}">
                            
                            <div class="mb-3">
                                <label for="comment" class="form-label">Tambah Komentar</label>
                                <textarea 
                                    name="comment" 
                                    id="comment" 
                                    rows="3" 
                                    class="form-control"
                                    placeholder="Tulis komentar untuk teknisi..."
                                    required
                                ></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Komentar
                            </button>
                        </form>
                        @endif
                    @endauth

                    <div class="comments-section">
                        @foreach($activity->comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">
                                                {{ $comment->manager->name }}
                                                <span class="badge bg-primary ms-2">Manager</span>
                                            </h6>
                                            <p class="text-muted small mb-2">
                                                {{ $comment->created_at->format('d F Y H:i') }}
                                            </p>
                                            <p class="card-text mb-0">{{ $comment->comment }}</p>
                                        </div>
                                        
                                        @auth
                                            @if(auth()->id() === $comment->manager_id)
                                            <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST" class="ms-2">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Hapus komentar ini?')"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if($activity->comments->isEmpty())
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-comments fa-2x mb-2"></i>
                                <p>Belum ada komentar.</p>
                            </div>
                        @endif
                    </div>
                </div>
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