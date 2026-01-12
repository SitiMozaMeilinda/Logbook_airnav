<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;
class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik berdasarkan divisi dan unit
        $stats = [
            // CNSA Units
            'Communication' => Activity::where('divisi', 'CNSA')->where('unit', 'Communication')->count(),
            'Navigation' => Activity::where('divisi', 'CNSA')->where('unit', 'Navigation')->count(),
            'Surveillance' => Activity::where('divisi', 'CNSA')->where('unit', 'Surveillance')->count(),
            'Automation' => Activity::where('divisi', 'CNSA')->where('unit', 'Automation')->count(),
            
            // Support Units
            'Listrik' => Activity::where('divisi', 'Support')->where('unit', 'Listrik')->count(),
            'Mekanikal' => Activity::where('divisi', 'Support')->where('unit', 'Mekanikal')->count(),
            'Bangunan' => Activity::where('divisi', 'Support')->where('unit', 'Bangunan')->count(),
            
            // Total per divisi
            'total_cnsa' => Activity::where('divisi', 'CNSA')->count(),
            'total_support' => Activity::where('divisi', 'Support')->count(),
            'total_all' => Activity::count()
        ];

        // Aktivitas terbaru
        $recentActivities = Activity::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('manager.dashboard', compact('stats', 'recentActivities'));
    }

public function history(Request $request)
{
    // 1. Ambil semua user dengan role teknisi untuk ditampilkan di dropdown filter
    $users = User::where('role', 'teknisi')->orderBy('name', 'asc')->get();

    // 2. Query dasar aktivitas
    $query = Activity::with('user', 'comments.manager');

    // Filter berdasarkan Divisi
    if ($request->filled('divisi')) {
        $query->where('divisi', $request->divisi);
    }
    
    // Filter berdasarkan Unit
    if ($request->filled('unit')) {
        $query->where('unit', $request->unit);
    }

    // NEW: Filter berdasarkan Nama Teknisi (user_id)
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }
    
    // Filter berdasarkan Search Judul Aktivitas
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('judul_aktivitas', 'like', "%$search%");
    }

    // Urutkan berdasarkan yang terbaru
    $activities = $query->latest()->get();

    // Kirim data activities dan users ke view
    return view('manager.history', compact('activities', 'users'));
}

    public function show($id)
    {
        $activity = Activity::with(['user', 'comments.manager'])->findOrFail($id);
        return view('manager.detail', compact('activity'));
    }
}