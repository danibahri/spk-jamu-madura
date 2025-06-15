<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;

class SearchHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $histories = Auth::user()->searchHistories()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('search-history.index', compact('histories'));
    }

    public function show($id)
    {
        $history = Auth::user()->searchHistories()->findOrFail($id);

        return view('search-history.show', compact('history'));
    }

    public function destroy($id)
    {
        $history = Auth::user()->searchHistories()->findOrFail($id);
        $history->delete();

        return redirect()->route('search-history.index')
            ->with('success', 'Riwayat pencarian berhasil dihapus!');
    }

    public function clear()
    {
        Auth::user()->searchHistories()->delete();

        return redirect()->route('search-history.index')
            ->with('success', 'Semua riwayat pencarian berhasil dihapus!');
    }

    public function repeat($id)
    {
        $history = Auth::user()->searchHistories()->findOrFail($id);

        // Redirect to SMART algorithm with same parameters
        return redirect()->route('smart.index')
            ->with('repeat_search', $history)
            ->with('success', 'Parameter pencarian berhasil dimuat ulang!');
    }
}
