<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Activity;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,activity_id',
            'comment' => 'required|string|max:1000'
        ]);

        if (Auth::user()->role !== 'manager') {
            return redirect()->back()->with('error', 'Hanya manager yang dapat menambahkan komentar.');
        }

        $comment = Comment::create([
            'activity_id' => $request->activity_id,
            'manager_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        $activity = Activity::with('user')->find($request->activity_id);
        
        if ($activity && $activity->user) {
            Notification::create([
                'user_id' => $activity->user_id,
                'activity_id' => $activity->activity_id,
                'comment_id' => $comment->comment_id,
                'message' => 'Manager ' . Auth::user()->name . ' memberikan komentar pada aktivitas Anda: "' . $activity->judul_aktivitas . '"',
                'is_read' => false
            ]);
        }

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        if ($comment->manager_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus komentar ini.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}