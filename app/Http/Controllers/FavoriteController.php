<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Jamu;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        // Middleware will be handled by routes
    }

    public function index()
    {
        $favorites = Favorite::with('jamu')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jamu_id' => 'required|exists:jamus,id'
        ]);

        $favorite = Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'jamu_id' => $request->jamu_id
        ]);

        if ($favorite->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Jamu berhasil ditambahkan ke favorit'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Jamu sudah ada dalam favorit'
            ]);
        }
    }

    public function destroy($jamuId)
    {
        $deleted = Favorite::where('user_id', Auth::id())
            ->where('jamu_id', $jamuId)
            ->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Jamu berhasil dihapus dari favorit'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Jamu tidak ditemukan dalam favorit'
            ]);
        }
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'jamu_id' => 'required|exists:jamus,id'
        ]);

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('jamu_id', $request->jamu_id)
            ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $message = 'Jamu berhasil dihapus dari favorit';
            $action = 'removed';
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => Auth::id(),
                'jamu_id' => $request->jamu_id
            ]);
            $message = 'Jamu berhasil ditambahkan ke favorit';
            $action = 'added';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'action' => $action
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
