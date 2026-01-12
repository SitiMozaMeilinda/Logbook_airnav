@extends('layouts.airnav')

@section('title', 'Dashboard Manager')

@section('content')

<!-- Statistik CNSA -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-satellite-dish me-2"></i>Statistik CNSA
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Communication'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Communication</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Navigation'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Navigation</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Surveillance'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Surveillance</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-primary mb-2">{{ $stats['Automation'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Automation</p>
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
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools me-2"></i>Statistik Support
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-success mb-2">{{ $stats['Listrik'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Listrik</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-success mb-2">{{ $stats['Mekanikal'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Mekanikal</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 border rounded bg-light">
                            <h3 class="text-success mb-2">{{ $stats['Bangunan'] ?? 0 }}</h3>
                            <p class="mb-0 text-muted fw-semibold">Bangunan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection