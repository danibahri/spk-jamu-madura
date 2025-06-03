@extends('layouts.app')

@section('title', 'Riwayat Pencarian')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold text-success"><i class="fas fa-history me-2"></i>Riwayat Pencarian</h2>
                <p class="text-muted">Lihat dan kelola riwayat pencarian jamu Anda</p>
            </div>
            @if ($histories->count() > 0)
                <div class="col-md-4 text-md-end">
                    <form action="{{ route('search-history.clear') }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua riwayat pencarian?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Semua
                        </button>
                    </form>
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($histories->count() > 0)
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card bg-success h-100 text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-light mb-0">Total Pencarian</h5>
                                    <h3 class="fw-bold mb-0">{{ $histories->total() }}</h3>
                                </div>
                                <i class="fas fa-search fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card bg-primary h-100 text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-light mb-0">Kata Kunci Unik</h5>
                                    <h3 class="fw-bold mb-0">{{ $histories->groupBy('search_query')->count() }}</h3>
                                </div>
                                <i class="fas fa-tag fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card bg-info h-100 text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="fw-light mb-0">Pencarian Hari Ini</h5>
                                    <h3 class="fw-bold mb-0">
                                        {{ $histories->where('created_at', '>=', now()->startOfDay())->count() }}</h3>
                                </div>
                                <i class="fas fa-calendar-day fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Daftar Riwayat Pencarian</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table-hover mb-0 table">
                            <thead class="table-light">
                                <tr>
                                    <th>Kata Kunci</th>
                                    <th>Waktu Pencarian</th>
                                    <th>Filter</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $history)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle me-3 p-2">
                                                    <i class="fas fa-search text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $history->search_query }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <i class="fas fa-clock text-muted me-1"></i>
                                                {{ $history->created_at->format('d M Y, H:i') }}
                                                <div class="text-muted">{{ $history->created_at->diffForHumans() }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($history->filters_applied)
                                                <div class="small">
                                                    @foreach (json_decode($history->filters_applied, true) as $key => $value)
                                                        @if ($value && !in_array($key, ['_token', 'page', 'search']))
                                                            <span class="badge bg-light text-dark me-1">
                                                                {{ $key }}:
                                                                {{ is_array($value) ? implode(', ', $value) : $value }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted small">Tidak ada filter</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('jamu.index', ['search' => $history->search_query]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="fas fa-redo me-1"></i>Cari Lagi
                                                </a>
                                                <form action="{{ route('search-history.destroy', $history->id) }}"
                                                    method="POST" onsubmit="return confirm('Hapus riwayat ini?')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $histories->links() }}
            </div>
        @else
            <div class="card p-5 text-center shadow-sm">
                <div class="py-5">
                    <div class="mb-4">
                        <i class="fas fa-history fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Belum ada riwayat pencarian</h3>
                    <p class="text-muted mb-4">Riwayat pencarian akan muncul setelah Anda melakukan pencarian jamu</p>
                    <a href="{{ route('jamu.index') }}" class="btn btn-success px-4">
                        <i class="fas fa-search me-2"></i>Mulai Pencarian
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
