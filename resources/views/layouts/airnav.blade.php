<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - AirNav Indonesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --airnav-blue: #005DAA;
            --airnav-dark: #0077c8;
            --airnav-gradient: linear-gradient(135deg, #0053a0, #0077c8);
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --bg-light: #f8fafc;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
            --border-radius: 0px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-light);
            color: var(--text-primary);
        }
        
        .sidebar {
            min-height: 100vh;
            background: var(--airnav-blue);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: var(--card-shadow);
        }
        
        .logo-container {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: var(--airnav-blue);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo span {
            font-weight: 700;
            font-size: 1.4rem;
            color: white;
        }
        
        .sidebar-nav {
            padding: 1rem;
            flex-grow: 1;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.9rem 1rem;
            margin: 0.3rem 0;
            border-radius: var(--border-radius);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            border: none;
            background: transparent;
            width: 100%;
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
        }
        
        .nav-link i {
            width: 24px;
            font-size: 1.2rem;
            margin-right: 12px;
        }
        
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            padding: 0.8rem 1rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            font-weight: 500;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
        }

        .logout-btn:hover {
            color: #fee2e2;
            background: rgba(239, 68, 68, 0.2);
        }

        .logout-btn i {
            margin-right: 10px;
            width: 20px;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
        }
        
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 24px;
        }
        
        .status-badge {
            padding: 8px 16px;
            font-size: 0.85em;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        .status-submitted { 
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }
        
        .status-revised { 
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        
        .status-approved { 
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }
        
        .header-logo {
            background: var(--airnav-gradient);
            padding: 30px;
            color: white;
            margin-bottom: 24px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            text-align: center;
        }
        
        .card-modern {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .table-modern {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 1px solid #e5e7eb;
        }

        .table-modern thead {
            background: var(--airnav-gradient);
            color: white;
        }

        .table-modern th {
            border: none;
            padding: 16px;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-modern td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        .table-modern th:not(:last-child),
        .table-modern td:not(:last-child) {
            border-right: 1px solid #e5e7eb;
        }
        
        .btn-group-sm > .btn,
        .btn-sm {
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
            border-radius: var(--border-radius);
        }

        .btn-outline-info {
            color: #0dcaf0;
            border-color: #0dcaf0;
        }

        .btn-outline-warning {
            color: #ffc107;
            border-color: #ffc107;
        }

        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }

        .alert {
            min-width: 400px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
        }

        .preview-image {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        .badge {
            font-size: 0.75em;
            font-weight: 600;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--airnav-gradient);
            color: white;
            font-size: 0.875rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: var(--border-radius);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--airnav-blue);
            border-radius: var(--border-radius);
        }
        
        .sidebar-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .text-primary {
            color: var(--airnav-blue) !important;
        }
        
        .card-body {
            padding: 2rem 1rem;
        }

        .form-control,
        .form-select,
        .input-group-text,
        .modal-content,
        .btn:not(.logout-btn):not(.nav-link) {
            border-radius: var(--border-radius) !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .btn-group-sm > .btn {
                padding: 0.25rem 0.4rem;
                font-size: 0.8rem;
            }
            
            .table-modern th,
            .table-modern td {
                padding: 12px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <div class="logo">
                <img src="/images/logo.jpg" alt="Airnav Logo" class="sidebar-logo">
                <span>E-LogBook</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <a class="nav-link {{ Request::is('*dashboard*') ? 'active' : '' }}" 
               href="{{ Auth::user()->role == 'manager' ? route('manager.dashboard') : route('teknisi.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            
            @if(Auth::user()->role === 'teknisi')
            <a class="nav-link {{ Request::is('*add-data*') ? 'active' : '' }}" 
               href="{{ route('teknisi.create') }}">
                <i class="fas fa-plus-circle"></i>
                <span>Add Data</span>
            </a>
            @endif
            
            <a class="nav-link {{ Request::is('*history*') ? 'active' : '' }}" 
               href="{{ Auth::user()->role == 'manager' ? route('manager.history') : route('teknisi.history') }}">
                <i class="fas fa-history"></i>
                <span>History</span>
            </a>
            
            @if(Auth::user()->role === 'manager')
            <a class="nav-link {{ Request::is('manager/tambah-data-pegawai') ? 'active' : '' }}"
            href="{{ route('manager.tambahdatapegawai') }}">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Data Pegawai</span>
            </a>
            @endif

        </nav>
        
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
            <div class="container-fluid">
                <span class="navbar-brand fw-bold">@yield('title')</span>
                <div class="navbar-nav ms-auto">
                    <span class="navbar-text">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ Auth::user()->name }} 
                        <span class="badge bg-primary ms-2">{{ ucfirst(Auth::user()->role) }}</span>
                    </span>
                </div>
            </div>
        </nav>

        <div class="container-fluid animate-fadeIn">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>