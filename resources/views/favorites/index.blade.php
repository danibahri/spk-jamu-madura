@extends('layouts.app')

@section('title', 'Jamu Favorit Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Jamu Favorit Saya</h1>
        <p class="text-gray-600">Koleksi jamu tradisional yang telah Anda simpan sebagai favorit</p>
    </div>

    @if($favorites && $favorites->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $favorite)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $favorite->jamu->nama }}</h3>
                            <form action="{{ route('favorites.destroy', $favorite->jamu->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" 
                                        onclick="return confirm('Hapus dari favorit?')">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2h8a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Kategori:</span> {{ $favorite->jamu->kategori }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Kandungan:</span> {{ $favorite->jamu->kandungan }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Khasiat:</span> {{ $favorite->jamu->khasiat }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Harga:</span> 
                                <span class="text-green-600 font-semibold">Rp {{ number_format($favorite->jamu->harga, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">
                                Ditambahkan {{ $favorite->created_at->diffForHumans() }}
                            </span>
                            <a href="{{ route('jamu.show', $favorite->jamu->id) }}" 
                               class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 transition-colors duration-200">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($favorites->hasPages())
            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" 
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada jamu favorit</h3>
            <p class="text-gray-500 mb-6">Mulai jelajahi koleksi jamu kami dan simpan yang Anda sukai!</p>
            <a href="{{ route('jamu.index') }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition-colors duration-200 inline-block">
                Jelajahi Jamu
            </a>
        </div>
    @endif
</div>
@endsection
