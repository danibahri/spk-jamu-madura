@extends('layouts.app')

@section('title', 'Detail Riwayat Pencarian')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('search-history.index') }}">Riwayat Pencarian</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <h2 class="fw-bold text-success">
                    <i class="fas fa-history me-2"></i>Detail Riwayat Pencarian
                </h2>
                <p class="text-muted">Lihat detail pencarian dan hasil rekomendasi</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <!-- Search Information -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Informasi Pencarian</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-muted">Kata Kunci:</label>
                                <p class="mb-0">{{ $history->search_query ?? 'Tidak ada kata kunci' }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-muted">Waktu Pencarian:</label>
                                <p class="mb-0">{{ $history->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Criteria Weights -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-balance-scale me-2"></i>Bobot Kriteria</h5>
                    </div>
                    <div class="card-body">
                        @if ($history->criteria_weights)
                            <div class="row">
                                @foreach ($history->criteria_weights as $criteria => $weight)
                                    <div class="col-md-3 mb-3">
                                        <div class="text-center">
                                            <div class="bg-light rounded p-3">
                                                <h6 class="fw-bold text-capitalize">{{ str_replace('_', ' ', $criteria) }}
                                                </h6>
                                                <div class="progress mb-2" style="height: 8px;">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ $weight * 100 }}%"></div>
                                                </div>
                                                <span class="badge bg-primary">{{ number_format($weight * 100, 1) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Tidak ada data bobot kriteria.</p>
                        @endif
                    </div>
                </div>

                <!-- Applied Filters -->
                @if ($history->filters_applied && count($history->filters_applied) > 0)
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter yang Diterapkan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($history->filters_applied as $filter => $value)
                                    @if ($value)
                                        <div class="col-md-6 mb-2">
                                            <span
                                                class="badge bg-info me-2">{{ ucfirst(str_replace('_', ' ', $filter)) }}</span>
                                            @if (is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Search Results -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Hasil Rekomendasi</h5>
                    </div>
                    <div class="card-body">
                        @if ($history->results && count($history->results) > 0)
                            <div class="row">
                                @foreach ($history->results as $index => $result)
                                    <div class="col-md-12 mb-3">
                                        <div class="bg-light rounded border p-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="badge bg-success me-2">#{{ $index + 1 }}</span>
                                                        <h6 class="fw-bold mb-0">{{ $result['nama'] ?? 'N/A' }}</h6>
                                                    </div>
                                                    <div class="row text-sm">
                                                        <div class="col-md-4">
                                                            <small class="text-muted">Kategori:</small>
                                                            <p class="mb-1">{{ $result['kategori'] ?? 'N/A' }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted">Harga:</small>
                                                            <p class="mb-1">Rp
                                                                {{ number_format($result['harga'] ?? 0, 0, ',', '.') }}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <small class="text-muted">Score:</small>
                                                            <p class="mb-1">
                                                                <span
                                                                    class="badge bg-primary">{{ number_format(($result['score'] ?? 0) * 100, 2) }}%</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ms-3">
                                                    <a href="{{ route('jamu.show', $result['id'] ?? '#') }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Lihat
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada hasil pencarian yang tersimpan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Actions -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Aksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('search-history.repeat', $history->id) }}" class="btn btn-success">
                                <i class="fas fa-redo me-2"></i>Ulangi Pencarian
                            </a>
                            <a href="{{ route('smart.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Pencarian Baru
                            </a>
                            <hr>
                            <form action="{{ route('search-history.destroy', $history->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-2"></i>Hapus Riwayat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="fw-bold text-success mb-0">{{ count($history->results ?? []) }}</h4>
                                    <small class="text-muted">Hasil</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="fw-bold text-primary mb-0">{{ count($history->criteria_weights ?? []) }}</h4>
                                <small class="text-muted">Kriteria</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
