@extends('layouts.airnav')

@section('title', 'Dashboard Teknisi')

@section('content')

<!-- Notifikasi Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bell me-2"></i>Notifikasi Terbaru
                    @php
                        $unreadCount = Auth::user()->notifications()->where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @php
                    $notifications = Auth::user()->notifications()->where('is_read', false)->latest()->take(5)->get();
                @endphp
                
                @if($notifications->count() > 0)
                    <div class="list-group">
                        @foreach($notifications as $notification)
                        <a href="/history/{{ $notification->activity_id }}" 
                           class="list-group-item list-group-item-action {{ $notification->is_read ? '' : 'list-group-item-warning' }} p-3">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1 me-3">
                                    <h6 class="mb-2">
                                        @if(!$notification->is_read)
                                        <span class="badge bg-danger me-2">BARU</span>
                                        @endif
                                        {{ $notification->message }}
                                    </h6>
                                    <p class="mb-0 text-muted small">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <small class="text-muted">
                                    Klik untuk melihat
                                </small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-bell-slash fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Tidak ada notifikasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Statistik CNSA -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-satellite-dish me-2"></i>CNSA
                </h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Communication'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Communication</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Navigation'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Navigation</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Surveillance'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Surveillance</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Automation'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Automation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Support -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="fas fa-tools me-2"></i>Support
                </h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-success mb-2">{{ $stats['Listrik'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Listrik</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-success mb-2">{{ $stats['Mekanikal'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Mekanikal</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3 border rounded bg-light">
                            <h3 class="text-success mb-2">{{ $stats['Bangunan'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted">Bangunan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection