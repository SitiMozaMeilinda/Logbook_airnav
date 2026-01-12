<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeknisiController extends Controller
{
    public function create()
    {
        return view('teknisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_aktivitas' => 'required|string|max:255',
            'divisi' => 'required|in:CNSA,Support',
            'unit' => 'required|in:Communication,Navigation,Surveillance,Automation,Listrik,Mekanikal,Bangunan',
            'catatan' => 'required|string',
            'foto' => 'nullable|array',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            $fotoPaths = [];
            if ($request->hasFile('foto')) {
                foreach ($request->file('foto') as $foto) {
                    $fotoPaths[] = $foto->store('activities', 'public');
                }
            }

            $user = Auth::user();
            
            $activity = new Activity();
            $activity->judul_aktivitas = $request->judul_aktivitas;
            $activity->divisi = $request->divisi;
            $activity->unit = $request->unit;
            $activity->catatan = $request->catatan;
            $activity->foto = !empty($fotoPaths) ? $fotoPaths : null;
            $activity->user_id = $user->user_id ?? $user->id;
            
            $activity->save();

            return redirect()->route('teknisi.history')->with('success', 'Data berhasil disimpan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function dashboard()
    {
        $activities = Activity::query()
                            ->latest()
                            ->take(5)
                            ->get();

        $unitStats = Activity::query()
                        ->selectRaw('unit, count(*) as total')
                        ->groupBy('unit')
                        ->get();

        $stats = [];
        foreach ($unitStats as $stat) {
            $stats[$stat->unit] = $stat->total;
        }

        return view('teknisi.dashboard', compact('activities', 'stats'));
    }

    public function index(Request $request)
    {
        $query = Activity::query();

        if ($request->has('divisi') && $request->divisi != '') {
            $query->where('divisi', $request->divisi);
        }
        
        if ($request->has('unit') && $request->unit != '') {
            $query->where('unit', $request->unit);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul_aktivitas', 'like', "%$search%");
        }

        $activities = $query->latest()->get();

        return view('teknisi.history', compact('activities'));
    }

    public function show(Activity $activity)
    {
        $activity->load(['user', 'comments.manager']);
        
        if (Auth::check()) {
            Notification::where('user_id', Auth::id())
                       ->where('activity_id', $activity->activity_id)
                       ->where('is_read', false)
                       ->update(['is_read' => true]);
        }

        return view('teknisi.detail', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        return view('teknisi.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'judul_aktivitas' => 'required|string|max:255',
            'divisi' => 'required|in:CNSA,Support',
            'unit' => 'required',
            'catatan' => 'required|string',
            'new_foto' => 'nullable|array',
            'new_foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $currentPhotos = $activity->foto ?? [];

        if ($request->has('deleted_photos')) {
            $deletedPhotos = json_decode($request->deleted_photos, true) ?? [];
            
            foreach ($deletedPhotos as $index) {
                if (isset($currentPhotos[$index])) {
                    Storage::disk('public')->delete($currentPhotos[$index]);
                    unset($currentPhotos[$index]);
                }
            }
            $currentPhotos = array_values($currentPhotos);
        }

        $newPhotoPaths = [];
        if ($request->hasFile('new_foto')) {
            foreach ($request->file('new_foto') as $foto) {
                $newPhotoPaths[] = $foto->store('activities', 'public');
            }
        }

        $allPhotos = array_merge($currentPhotos, $newPhotoPaths);

        $activity->update([
            'judul_aktivitas' => $request->judul_aktivitas,
            'divisi' => $request->divisi,
            'unit' => $request->unit,
            'catatan' => $request->catatan,
            'foto' => $allPhotos
        ]);

        return redirect()->route('teknisi.history')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('teknisi.history')->with('success', 'Data berhasil dihapus!');
    }
}