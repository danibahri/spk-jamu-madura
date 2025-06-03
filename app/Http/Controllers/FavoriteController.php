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

    public function index(Request $request)
    {
        $query = Favorite::with('jamu')
            ->where('user_id', Auth::id());

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('jamu', function ($q) use ($search) {
                $q->where('nama_jamu', 'like', "%{$search}%")
                    ->orWhere('khasiat', 'like', "%{$search}%")
                    ->orWhere('kandungan', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->whereHas('jamu', function ($q) use ($request) {
                $q->where('kategori', $request->kategori);
            });
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->join('jamus', 'favorites.jamu_id', '=', 'jamus.id')
                    ->orderBy('jamus.nama_jamu', 'asc')
                    ->select('favorites.*');
                break;
            case 'name_desc':
                $query->join('jamus', 'favorites.jamu_id', '=', 'jamus.id')
                    ->orderBy('jamus.nama_jamu', 'desc')
                    ->select('favorites.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $favorites = $query->paginate(9);

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

    public function toggle(Request $request, $jamuId = null)
    {
        // If jamuId is provided in the route, use it, otherwise get it from the request
        $jamuId = $jamuId ?: $request->jamu_id;

        if (!$jamuId) {
            return response()->json([
                'success' => false,
                'message' => 'ID Jamu tidak ditemukan'
            ], 400);
        }

        // Validate jamu exists
        $jamu = Jamu::find($jamuId);
        if (!$jamu) {
            return response()->json([
                'success' => false,
                'message' => 'Jamu tidak ditemukan'
            ], 404);
        }

        $favorite = Favorite::where('user_id', Auth::id())
            ->where('jamu_id', $jamuId)
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
                'jamu_id' => $jamuId
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
