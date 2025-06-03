@extends('layouts.app')

@section('title', 'Daftar Jamu - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <div class="hero-section-jamu rounded-4 mb-5 p-5 shadow"
            style="background: linear-gradient(135deg, #4CAF50, #2E7D32);">
            <div class="row align-items-center">
                <div class="col-md-8 text-white">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-leaf me-3"></i>
                        Jamu Tradisional Madura
                    </h1>
                    <p class="lead text-white-50 mb-4">
                        Temukan {{ $total }} jamu tradisional Madura berkualitas untuk kesehatan Anda
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge text-success fs-6 rounded-pill bg-white px-3 py-2 shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> 100% Herbal Alami
                        </span>
                        <span class="badge text-success fs-6 rounded-pill bg-white px-3 py-2 shadow-sm">
                            <i class="fas fa-leaf me-1"></i> Resep Tradisional
                        </span>
                        <span class="badge text-success fs-6 rounded-pill bg-white px-3 py-2 shadow-sm">
                            <i class="fas fa-heart me-1"></i> Teruji Turun Temurun
                        </span>
                    </div>
                </div>
                <div class="col-md-4 mt-md-0 mt-4 text-end">
                    <div class="d-grid gap-3">
                        <a href="{{ route('smart.index') }}" class="btn btn-light btn-lg rounded-pill shadow">
                            <i class="fas fa-calculator me-2"></i>
                            Gunakan SMART Algorithm
                        </a>
                        <a href="{{ route('jamu.compare') }}"
                            class="btn btn-outline-light btn-lg rounded-pill border-white">
                            <i class="fas fa-balance-scale me-2"></i>
                            Bandingkan Jamu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow-lg">
            <div class="card-header bg-gradient py-3 text-center text-white">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filter & Pencarian Jamu
                </h5>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="{{ route('jamu.index') }}" id="filterForm">
                    <!-- Search Row -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label for="search" class="form-label fw-bold text-success">
                                <i class="fas fa-search me-1"></i>Cari Jamu
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-success border-success text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control border-success" id="search" name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama jamu, kandungan, atau khasiat...">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="sort" class="form-label fw-bold text-success">
                                <i class="fas fa-sort me-1"></i>Urutkan
                            </label>
                            <select class="form-select form-select-lg border-success" id="sort" name="sort">
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="khasiat" {{ request('sort') == 'khasiat' ? 'selected' : '' }}>Khasiat Terbaik
                                </option>
                                <option value="kandungan" {{ request('sort') == 'kandungan' ? 'selected' : '' }}>Kandungan
                                    Terbaik</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Row -->
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label for="kategori" class="form-label fw-bold text-success">
                                <i class="fas fa-tag me-1"></i>Kategori
                            </label>
                            <select class="form-select border-success" id="kategori" name="kategori">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"
                                        {{ request('kategori') == $category ? 'selected' : '' }}>
                                        {{ ucfirst($category) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="harga_min" class="form-label fw-bold text-success">
                                <i class="fas fa-money-bill me-1"></i>Harga Minimum
                            </label>
                            <select class="form-select border-success" id="harga_min" name="harga_min">
                                <option value="">Tidak Dibatasi</option>
                                <option value="0" {{ request('harga_min') == '0' ? 'selected' : '' }}>Gratis</option>
                                <option value="50000" {{ request('harga_min') == '50000' ? 'selected' : '' }}>≥ Rp 50.000
                                </option>
                                <option value="100000" {{ request('harga_min') == '100000' ? 'selected' : '' }}>≥ Rp
                                    100.000</option>
                                <option value="200000" {{ request('harga_min') == '200000' ? 'selected' : '' }}>≥ Rp
                                    200.000</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="harga_max" class="form-label fw-bold text-success">
                                <i class="fas fa-money-bill me-1"></i>Harga Maximum
                            </label>
                            <select class="form-select border-success" id="harga_max" name="harga_max">
                                <option value="">Tidak Dibatasi</option>
                                <option value="50000" {{ request('harga_max') == '50000' ? 'selected' : '' }}>≤ Rp 50.000
                                </option>
                                <option value="100000" {{ request('harga_max') == '100000' ? 'selected' : '' }}>≤ Rp
                                    100.000</option>
                                <option value="200000" {{ request('harga_max') == '200000' ? 'selected' : '' }}>≤ Rp
                                    200.000</option>
                                <option value="500000" {{ request('harga_max') == '500000' ? 'selected' : '' }}>≤ Rp
                                    500.000</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-filter me-1"></i>
                                    Terapkan Filter
                                </button>
                                <a href="{{ route('jamu.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i>
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if (request()->hasAny(['search', 'kategori', 'harga_min', 'harga_max', 'sort']))
                        <div class="border-top mt-3 pt-3">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <small class="text-muted me-2">Filter aktif:</small>

                                @if (request('search'))
                                    <span class="badge bg-primary">
                                        Pencarian: "{{ request('search') }}"
                                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                            class="text-decoration-none ms-1 text-white">×</a>
                                    </span>
                                @endif

                                @if (request('kategori'))
                                    <span class="badge bg-success">
                                        Kategori: {{ request('kategori') }}
                                        <a href="{{ request()->fullUrlWithQuery(['kategori' => null]) }}"
                                            class="text-decoration-none ms-1 text-white">×</a>
                                    </span>
                                @endif

                                @if (request('harga_min') || request('harga_max'))
                                    <span class="badge bg-warning text-dark">
                                        Harga:
                                        @if (request('harga_min'))
                                            ≥ Rp {{ number_format(request('harga_min'), 0, ',', '.') }}
                                        @endif
                                        @if (request('harga_min') && request('harga_max'))
                                            -
                                        @endif
                                        @if (request('harga_max'))
                                            ≤ Rp {{ number_format(request('harga_max'), 0, ',', '.') }}
                                        @endif
                                        <a href="{{ request()->fullUrlWithQuery(['harga_min' => null, 'harga_max' => null]) }}"
                                            class="text-dark text-decoration-none ms-1">×</a>
                                    </span>
                                @endif

                                <a href="{{ route('jamu.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Reset Filter
                                </a>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="row mb-4">
            <div class="col-md-6">
                <p class="text-muted mb-0">
                    Menampilkan {{ $jamus->firstItem() ?? 0 }}-{{ $jamus->lastItem() ?? 0 }}
                    dari {{ $jamus->total() }} jamu
                </p>
            </div>
            <div class="col-md-6 text-end">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active" id="gridView">
                        <i class="fas fa-th"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="listView">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>
        </div> <!-- Jamu Grid -->
        <div id="jamuGrid">
            @if ($jamus->count() > 0)
                <div class="row" id="jamuContainer">
                    @foreach ($jamus as $jamu)
                        <div class="col-lg-4 col-md-6 jamu-item mb-4">
                            <div class="card h-100 jamu-card shadow-sm">
                                <div class="position-relative overflow-hidden">
                                    <div class="jamu-image-placeholder">
                                        <i class="fas fa-leaf fa-3x text-success opacity-50"></i>
                                    </div>
                                    @if ($jamu->is_expired)
                                        <span class="position-absolute badge bg-danger start-0 top-0 m-2">
                                            <i class="fas fa-clock me-1"></i>Kadaluarsa
                                        </span>
                                    @else
                                        <span class="position-absolute badge bg-success start-0 top-0 m-2">
                                            <i class="fas fa-check me-1"></i>Fresh
                                        </span>
                                    @endif

                                    @auth
                                        <button
                                            class="position-absolute btn {{ $jamu->isFavorited() ? 'btn-danger' : 'btn-outline-danger' }} btn-sm favorite-toggle-btn end-0 top-0 m-2"
                                            data-jamu-id="{{ $jamu->id }}"
                                            title="{{ $jamu->isFavorited() ? 'Hapus dari favorit' : 'Tambahkan ke favorit' }}">
                                            <i class="{{ $jamu->isFavorited() ? 'fas' : 'far' }} fa-heart"></i>
                                        </button>
                                    @endauth
                                </div>

                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <h5 class="card-title text-success fw-bold lh-sm mb-2">
                                            {{ $jamu->nama_jamu }}
                                        </h5>
                                        <span class="badge bg-secondary mb-2">{{ $jamu->kategori }}</span>
                                    </div>

                                    <div class="mb-3">
                                        <p class="card-text text-muted small mb-2">
                                            <i class="fas fa-seedling text-success me-1"></i>
                                            <strong>Kandungan:</strong><br>
                                            <span class="ms-3">
                                                {{ implode(', ', array_slice($jamu->kandungan_array, 0, 3)) }}
                                                @if (count($jamu->kandungan_array) > 3)
                                                    <span
                                                        class="text-info fw-bold">+{{ count($jamu->kandungan_array) - 3 }}
                                                        lainnya</span>
                                                @endif
                                            </span>
                                        </p>

                                        <p class="card-text text-muted small mb-3">
                                            <i class="fas fa-heart-pulse text-danger me-1"></i>
                                            <strong>Khasiat:</strong>
                                            <span class="ms-1">{{ Str::limit($jamu->khasiat, 100) }}</span>
                                        </p>
                                    </div>

                                    <!-- Quality Indicators with improved styling -->
                                    <div class="mb-4">
                                        <div class="row g-2 text-center">
                                            <div class="col-4">
                                                <div class="quality-indicator bg-light rounded p-2">
                                                    <div class="progress mb-1" style="height: 6px;">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ $jamu->nilai_kandungan * 10 }}%"></div>
                                                    </div>
                                                    <small
                                                        class="text-muted fw-bold">{{ number_format($jamu->nilai_kandungan, 1) }}/10</small>
                                                    <div><small class="text-muted">Kandungan</small></div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="quality-indicator bg-light rounded p-2">
                                                    <div class="progress mb-1" style="height: 6px;">
                                                        <div class="progress-bar bg-success"
                                                            style="width: {{ $jamu->nilai_khasiat * 10 }}%"></div>
                                                    </div>
                                                    <small
                                                        class="text-muted fw-bold">{{ number_format($jamu->nilai_khasiat, 1) }}/10</small>
                                                    <div><small class="text-muted">Khasiat</small></div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="quality-indicator bg-light rounded p-2">
                                                    <div class="progress mb-1" style="height: 6px;">
                                                        <div class="progress-bar bg-warning"
                                                            style="width: {{ $jamu->freshness_score }}%"></div>
                                                    </div>
                                                    <small
                                                        class="text-muted fw-bold">{{ $jamu->freshness_score }}%</small>
                                                    <div><small class="text-muted">Freshness</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="text-success fw-bold mb-1">
                                                Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                            </h5>
                                            @if ($jamu->expired_date)
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    Exp: {{ date('d/m/Y', strtotime($jamu->expired_date)) }}
                                                </small>
                                            @endif
                                        </div>
                                        <a href="{{ route('jamu.show', $jamu->id) }}"
                                            class="btn btn-success btn-sm px-3">
                                            <i class="fas fa-eye me-1"></i>
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- List View (Hidden by default) -->
                <div class="d-none" id="jamuList">
                    @foreach ($jamus as $jamu)
                        <div class="card jamu-card-list mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="jamu-image-placeholder-small">
                                            <i class="fas fa-leaf fa-2x text-success opacity-50"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title text-success fw-bold mb-1">{{ $jamu->nama_jamu }}</h5>
                                        <div class="mb-2">
                                            <span class="badge bg-secondary me-2">{{ $jamu->kategori }}</span>
                                            @if ($jamu->is_expired)
                                                <span class="badge bg-danger">Kadaluarsa</span>
                                            @else
                                                <span class="badge bg-success">Fresh</span>
                                            @endif
                                        </div>
                                        <p class="text-muted small mb-2">
                                            <strong>Khasiat:</strong> {{ Str::limit($jamu->khasiat, 120) }}
                                        </p>
                                        <div class="row">
                                            <div class="col-4">
                                                <small class="text-muted">Kandungan:
                                                    {{ number_format($jamu->nilai_kandungan, 1) }}/10</small>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted">Khasiat:
                                                    {{ number_format($jamu->nilai_khasiat, 1) }}/10</small>
                                            </div>
                                            <div class="col-4">
                                                <small class="text-muted">Fresh: {{ $jamu->freshness_score }}%</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <h5 class="text-success fw-bold mb-1">
                                            Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                        </h5>
                                        @if ($jamu->expired_date)
                                            <small class="text-muted">
                                                Exp: {{ date('d/m/Y', strtotime($jamu->expired_date)) }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('jamu.show', $jamu->id) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                Detail
                                            </a>
                                            @auth
                                                <button class="btn btn-outline-danger btn-sm favorite-btn"
                                                    data-jamu-id="{{ $jamu->id }}">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-5 text-center">
                    <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Tidak Ada Jamu Ditemukan</h4>
                    <p class="text-muted">Coba ubah filter pencarian atau kata kunci Anda</p>
                    <a href="{{ route('jamu.index') }}" class="btn btn-success">
                        <i class="fas fa-refresh me-2"></i>
                        Reset Pencarian
                    </a>
                </div>
            @endif
        </div> <!-- Pagination -->
        @if ($jamus->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <div class="pagination-wrapper">
                    <div class="pagination-info mb-3 text-center">
                        <small class="text-muted">
                            Halaman {{ $jamus->currentPage() }} dari {{ $jamus->lastPage() }}
                            ({{ $jamus->total() }} total jamu)
                        </small>
                    </div>
                    <div class="custom-pagination">
                        {{ $jamus->appends(request()->query())->links('pagination::custom-jamu') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
    <style>
        .hero-section-jamu .badge {
            transition: transform 0.2s ease;
        }

        .hero-section-jamu .badge:hover {
            transform: scale(1.05);
        }

        .hero-section-jamu {
            position: relative;
            z-index: 1;
        }

        .jamu-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            overflow: hidden;
        }

        .jamu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
            border-color: #28a745;
        }

        .jamu-card-list {
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .jamu-card-list:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
            border-left: 4px solid #28a745;
        }

        .jamu-image-placeholder {
            height: 150px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px 10px 0 0;
        }

        .jamu-image-placeholder-small {
            height: 80px;
            width: 100%;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .quality-indicator {
            transition: all 0.3s ease;
        }

        .quality-indicator:hover {
            transform: scale(1.05);
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .card-title {
            line-height: 1.3;
            font-size: 1.1rem;
        }

        .favorite-btn {
            transition: all 0.3s ease;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .favorite-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #1e7e34 0%, #17a2b8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
        }

        .progress {
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.6s ease;
        }

        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 9999;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            animation: slideInToast 0.3s ease;
        }

        @keyframes slideInToast {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutToast {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .btn-group .btn {
            transition: all 0.3s ease;
        }

        .btn-group .btn.active {
            background: #28a745;
            border-color: #28a745;
            color: white;
            transform: scale(1.05);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .jamu-card {
                margin-bottom: 1.5rem;
            }

            .hero-section-jamu {
                padding: 40px 15px;
                text-align: center;
            }

            .hero-section-jamu .col-md-4 {
                margin-top: 20px;
            }

            .quality-indicator {
                padding: 0.3rem;
            }

            .card-title {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section-jamu h1 {
                font-size: 2rem;
            }

            .hero-section-jamu .lead {
                font-size: 1rem;
            }

            .badge {
                font-size: 0.7rem;
                margin-bottom: 0.25rem;
            }
        }

        /* Enhanced Pagination Styles */
        .pagination-wrapper {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            max-width: 600px;
            margin: 0 auto;
        }

        .pagination-info {
            font-weight: 500;
            color: #6c757d;
        }

        .custom-pagination .pagination {
            margin-bottom: 0;
            justify-content: center;
        }

        .custom-pagination .page-link {
            border: 2px solid transparent;
            border-radius: 10px;
            margin: 0 3px;
            padding: 10px 15px;
            font-weight: 500;
            color: #28a745;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .custom-pagination .page-link:hover {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-color: #28a745;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
        }

        .custom-pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-color: #28a745;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.4);
            position: relative;
        }

        .custom-pagination .page-item.active .page-link:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .custom-pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #e9ecef;
            cursor: not-allowed;
        }

        .custom-pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: none;
            background-color: #f8f9fa;
            color: #adb5bd;
        }

        .custom-pagination .page-link:focus {
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
            outline: none;
        }

        /* First/Last page styling */
        .custom-pagination .page-item:first-child .page-link,
        .custom-pagination .page-item:last-child .page-link {
            font-weight: 600;
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            border-color: #6c757d;
        }

        .custom-pagination .page-item:first-child .page-link:hover,
        .custom-pagination .page-item:last-child .page-link:hover {
            background: linear-gradient(135deg, #495057 0%, #343a40 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(108, 117, 125, 0.3);
        }

        /* Responsive pagination */
        @media (max-width: 768px) {
            .pagination-wrapper {
                padding: 15px;
                margin: 0 15px;
                border-radius: 10px;
            }

            .custom-pagination .page-link {
                padding: 8px 12px;
                font-size: 0.9rem;
                margin: 0 1px;
            }

            .pagination-info {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .pagination-wrapper {
                padding: 10px;
            }

            .custom-pagination .page-link {
                padding: 6px 10px;
                font-size: 0.8rem;
                margin: 0;
            }

            .pagination-info {
                font-size: 0.8rem;
                margin-bottom: 15px !important;
            }

            /* Hide some pagination links on very small screens */
            .custom-pagination .page-item:not(.active):not(:first-child):not(:last-child):not(.previous):not(.next) {
                display: none;
            }
        }

        /* Pagination animation */
        .custom-pagination .page-item {
            animation: fadeInPagination 0.5s ease forwards;
            opacity: 0;
        }

        .custom-pagination .page-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .custom-pagination .page-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .custom-pagination .page-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .custom-pagination .page-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .custom-pagination .page-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        @keyframes fadeInPagination {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Quick Jump Styling */
        .pagination-jump {
            animation: fadeInPagination 0.6s ease forwards;
        }

        .pagination-jump .form-select {
            border: 2px solid #28a745;
            border-radius: 8px;
            padding: 4px 8px;
            background-color: white;
            color: #28a745;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination-jump .form-select:focus {
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
            border-color: #20c997;
            outline: none;
        }

        .pagination-jump .form-select:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
        }

        /* Enhanced pagination spacing */
        .custom-pagination .pagination .page-item+.page-item {
            margin-left: 0;
        }

        /* Better dots styling */
        .custom-pagination .page-item.disabled .page-link {
            background-color: transparent;
            border-color: transparent;
            font-weight: bold;
            color: #28a745;
        }

        /* Active page enhanced styling */
        .custom-pagination .page-item.active .page-link {
            position: relative;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-color: #28a745;
            color: white;
            font-weight: 600;
            transform: scale(1.1);
        }

        .custom-pagination .page-item.active .page-link::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #28a745, #20c997, #28a745);
            border-radius: 12px;
            z-index: -1;
            animation: activePageGlow 2s ease-in-out infinite alternate;
        }

        @keyframes activePageGlow {
            0% {
                opacity: 0.7;
                transform: scale(1);
            }

            100% {
                opacity: 1;
                transform: scale(1.02);
            }
        }

        /* Scroll to top button */
        .scroll-to-top {
            animation: bounceIn 0.5s ease;
        }

        .scroll-to-top:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4) !important;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Loading states */
        .pagination-wrapper.loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .pagination-wrapper.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #28a745;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Pagination tooltips */
        .tooltip {
            font-size: 0.9rem;
        }

        .tooltip-inner {
            background-color: #28a745;
            border-radius: 6px;
            font-weight: 500;
        }

        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #28a745;
        }

        /* Improved pagination accessibility */
        .pagination .page-link:focus {
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
            z-index: 2;
        }

        .pagination .page-link:focus-visible {
            outline: 2px solid #28a745;
            outline-offset: 2px;
        }

        /* Page transition effects */
        .jamu-item {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .jamu-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .jamu-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .jamu-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .jamu-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .jamu-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        .jamu-item:nth-child(6) {
            animation-delay: 0.6s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Keyboard shortcut styling */
        kbd {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
            color: #495057;
            font-family: 'Courier New', monospace;
            font-size: 0.8em;
            font-weight: 600;
            padding: 2px 6px;
            text-shadow: 0 1px 0 #fff;
        }

        .pagination-info kbd {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-color: #28a745;
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.2);
        }
    </style>
    <script>
        // Auto-submit form on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const selects = form.querySelectorAll('select');

            // Auto-submit on filter change
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });

            // Favorite functionality with improved feedback
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const jamuId = this.dataset.jamuId;
                    const originalIcon = this.innerHTML;

                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;

                    fetch(`/favorites/toggle/${jamuId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update all buttons with same jamu ID
                                document.querySelectorAll(`[data-jamu-id="${jamuId}"]`).forEach(
                                    button => {
                                        button.classList.toggle('btn-outline-danger');
                                        button.classList.toggle('btn-danger');

                                        if (data.favorited) {
                                            button.innerHTML =
                                                '<i class="fas fa-heart"></i>';
                                            button.classList.remove('btn-outline-danger');
                                            button.classList.add('btn-danger');
                                        } else {
                                            button.innerHTML =
                                                '<i class="far fa-heart"></i>';
                                            button.classList.remove('btn-danger');
                                            button.classList.add('btn-outline-danger');
                                        }
                                        button.disabled = false;
                                    });

                                // Show enhanced feedback
                                showToast(
                                    data.favorited ?
                                    `✓ ${data.jamu_name} ditambahkan ke favorit` :
                                    `✗ ${data.jamu_name} dihapus dari favorit`,
                                    data.favorited ? 'success' : 'warning'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Restore original state on error
                            this.innerHTML = originalIcon;
                            this.disabled = false;
                            showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
                        });
                });
            });

            // View toggle functionality
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const jamuGrid = document.getElementById('jamuContainer');
            const jamuList = document.getElementById('jamuList');

            gridView.addEventListener('click', function() {
                if (!this.classList.contains('active')) {
                    // Switch to grid view
                    this.classList.add('active');
                    listView.classList.remove('active');

                    jamuList.classList.add('d-none');
                    jamuGrid.classList.remove('d-none');

                    localStorage.setItem('jamuViewMode', 'grid');

                    // Add animation
                    jamuGrid.style.opacity = '0';
                    setTimeout(() => {
                        jamuGrid.style.opacity = '1';
                        jamuGrid.style.transition = 'opacity 0.3s ease';
                    }, 50);
                }
            });

            listView.addEventListener('click', function() {
                if (!this.classList.contains('active')) {
                    // Switch to list view
                    this.classList.add('active');
                    gridView.classList.remove('active');

                    jamuGrid.classList.add('d-none');
                    jamuList.classList.remove('d-none');

                    localStorage.setItem('jamuViewMode', 'list');

                    // Add animation
                    jamuList.style.opacity = '0';
                    setTimeout(() => {
                        jamuList.style.opacity = '1';
                        jamuList.style.transition = 'opacity 0.3s ease';
                    }, 50);
                }
            });

            // Remember user's view preference
            const savedViewMode = localStorage.getItem('jamuViewMode');
            if (savedViewMode === 'list') {
                listView.click();
            }

            // Enhanced search functionality
            const searchInput = document.getElementById('search');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (this.value.length >= 3 || this.value.length === 0) {
                            form.submit();
                        }
                    }, 500);
                });
            }

            // Add click handlers for cards
            document.querySelectorAll('.jamu-card, .jamu-card-list').forEach(card => {
                card.addEventListener('click', function(e) {
                    // Don't trigger if clicking on buttons
                    if (e.target.closest('button') || e.target.closest('a')) {
                        return;
                    }

                    const detailLink = this.querySelector('a[href*="/jamu/"]');
                    if (detailLink) {
                        window.location.href = detailLink.href;
                    }
                });

                // Add keyboard support
                card.setAttribute('tabindex', '0');
                card.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        this.click();
                    }
                });
            });
        });

        // Enhanced toast notification function
        function showToast(message, type = 'success') {
            // Remove existing toasts
            document.querySelectorAll('.toast-notification').forEach(toast => toast.remove());

            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'times-circle'} me-2"></i>
                    <span>${message}</span>
                </div>
            `;

            // Apply type-specific styling
            if (type === 'warning') {
                toast.style.background = '#ffc107';
                toast.style.color = '#212529';
            } else if (type === 'error') {
                toast.style.background = '#dc3545';
            }

            document.body.appendChild(toast);

            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.style.animation = 'slideOutToast 0.3s ease';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }, 4000);
        }

        // Enhanced Pagination Functionality
        function initializePagination() {
            // Add smooth scrolling to pagination links
            document.querySelectorAll('.pagination .page-link').forEach(link => {
                if (!link.href) return;

                link.addEventListener('click', function(e) {
                    // Show loading state
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                    // Add loading class to pagination wrapper
                    const paginationWrapper = document.querySelector('.pagination-wrapper');
                    if (paginationWrapper) {
                        paginationWrapper.style.opacity = '0.7';
                        paginationWrapper.style.pointerEvents = 'none';
                    }
                });
            });

            // Add keyboard navigation for pagination
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey) {
                    const currentUrl = new URL(window.location.href);
                    const currentPage = parseInt(currentUrl.searchParams.get('page')) || 1;

                    if (e.key === 'ArrowLeft') {
                        // Go to previous page
                        e.preventDefault();
                        const prevLink = document.querySelector(
                            '.pagination .page-item:not(.disabled) .page-link[rel="prev"]');
                        if (prevLink) {
                            window.location.href = prevLink.href;
                        }
                    } else if (e.key === 'ArrowRight') {
                        // Go to next page
                        e.preventDefault();
                        const nextLink = document.querySelector(
                            '.pagination .page-item:not(.disabled) .page-link[rel="next"]');
                        if (nextLink) {
                            window.location.href = nextLink.href;
                        }
                    }
                }
            });

            // Add pagination info tooltips
            document.querySelectorAll('.pagination .page-link').forEach(link => {
                if (link.textContent.trim() && !isNaN(link.textContent.trim())) {
                    const pageNum = link.textContent.trim();
                    link.setAttribute('title', `Pergi ke halaman ${pageNum}`);
                    link.setAttribute('data-bs-toggle', 'tooltip');
                }
            });

            // Initialize Bootstrap tooltips if available
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        }

        // Show scroll to top button when user scrolls down
        function initializeScrollToTop() {
            // Create scroll to top button
            const scrollBtn = document.createElement('button');
            scrollBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
            scrollBtn.className = 'btn btn-success scroll-to-top';
            scrollBtn.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 1000;
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: none;
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                transition: all 0.3s ease;
            `;

            scrollBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            document.body.appendChild(scrollBtn);

            // Show/hide button based on scroll position
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollBtn.style.display = 'flex';
                    scrollBtn.style.alignItems = 'center';
                    scrollBtn.style.justifyContent = 'center';
                } else {
                    scrollBtn.style.display = 'none';
                }
            });
        }

        // Page load progress indicator
        function showPageLoadProgress() {
            // Create progress bar
            const progressBar = document.createElement('div');
            progressBar.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 0%;
                height: 4px;
                background: linear-gradient(90deg, #28a745, #20c997);
                z-index: 9999;
                transition: width 0.3s ease;
            `;
            document.body.appendChild(progressBar);

            // Animate progress
            let width = 0;
            const interval = setInterval(() => {
                width += Math.random() * 15;
                if (width >= 90) {
                    clearInterval(interval);
                }
                progressBar.style.width = Math.min(width, 90) + '%';
            }, 100);

            // Complete when page loads
            window.addEventListener('load', () => {
                clearInterval(interval);
                progressBar.style.width = '100%';
                setTimeout(() => {
                    progressBar.style.opacity = '0';
                    setTimeout(() => {
                        if (progressBar.parentNode) {
                            progressBar.remove();
                        }
                    }, 300);
                }, 200);
            });
        }

        // Initialize all enhancements when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // ...existing code...

            // Initialize new features
            initializePagination();
            initializeScrollToTop();

            // Show keyboard shortcuts help
            console.log('🔥 Jamu SPK - Keyboard Shortcuts:');
            console.log('Ctrl + ← : Previous Page');
            console.log('Ctrl + → : Next Page');
        });

        // Show page load progress for navigation
        if (document.readyState === 'loading') {
            showPageLoadProgress();
        }
    </script>
@endsection
