@extends('layouts.app')

@section('title', 'Daftar Jamu - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h2 class="display-5 fw-bold text-success mb-3">
                    <i class="fas fa-leaf me-3"></i>
                    Daftar Jamu Tradisional
                </h2>
                <p class="lead text-muted">
                    Temukan {{ $total }} jamu tradisional Madura berkualitas untuk kesehatan Anda
                </p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('smart.index') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-calculator me-2"></i>
                    Gunakan SMART Algorithm
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('jamu.index') }}" id="filterForm">
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label for="search" class="form-label fw-bold">Cari Jamu</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Nama jamu atau kandungan...">
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">Semua</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"
                                        {{ request('kategori') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="harga_min" class="form-label fw-bold">Harga Min</label>
                            <select class="form-select" id="harga_min" name="harga_min">
                                <option value="">Tidak Dibatasi</option>
                                <option value="0" {{ request('harga_min') == '0' ? 'selected' : '' }}>Gratis</option>
                                <option value="50000" {{ request('harga_min') == '50000' ? 'selected' : '' }}>≥ Rp 50.000
                                </option>
                                <option value="100000" {{ request('harga_min') == '100000' ? 'selected' : '' }}>≥ Rp 100.000
                                </option>
                                <option value="200000" {{ request('harga_min') == '200000' ? 'selected' : '' }}>≥ Rp
                                    200.000</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="harga_max" class="form-label fw-bold">Harga Max</label>
                            <select class="form-select" id="harga_max" name="harga_max">
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

                        <div class="col-md-2 mb-3">
                            <label for="sort" class="form-label fw-bold">Urutkan</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga
                                    Terendah</option>
                                <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>

                        <div class="col-md-1 mb-3">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-filter"></i>
                            </button>
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
        </div>

        <!-- Jamu Grid -->
        <div id="jamuGrid">
            @if ($jamus->count() > 0)
                <div class="row">
                    @foreach ($jamus as $jamu)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 jamu-card shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title text-success fw-bold mb-2">
                                            {{ $jamu->nama_jamu }}
                                        </h5>
                                        @auth
                                            <button class="btn btn-outline-danger btn-sm favorite-btn"
                                                data-jamu-id="{{ $jamu->id }}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        @endauth
                                    </div>

                                    <div class="mb-3">
                                        <span class="badge bg-secondary">{{ $jamu->kategori }}</span>
                                        @if ($jamu->is_expired)
                                            <span class="badge bg-danger">Kadaluarsa</span>
                                        @else
                                            <span class="badge bg-success">Fresh</span>
                                        @endif
                                    </div>

                                    <p class="card-text text-muted mb-2">
                                        <strong>Kandungan utama:</strong><br>
                                        {{ implode(', ', array_slice($jamu->kandungan_array, 0, 3)) }}
                                        @if (count($jamu->kandungan_array) > 3)
                                            <span class="text-info">+{{ count($jamu->kandungan_array) - 3 }}
                                                lainnya</span>
                                        @endif
                                    </p>

                                    <p class="card-text text-muted mb-3">
                                        <strong>Khasiat:</strong> {{ Str::limit($jamu->khasiat, 80) }}
                                    </p>

                                    <!-- Quality Indicators -->
                                    <div class="mb-3">
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="quality-indicator">
                                                    <div class="progress mb-1" style="height: 4px;">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ $jamu->nilai_kandungan * 10 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">Kandungan</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="quality-indicator">
                                                    <div class="progress mb-1" style="height: 4px;">
                                                        <div class="progress-bar bg-success"
                                                            style="width: {{ $jamu->nilai_khasiat * 10 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">Khasiat</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="quality-indicator">
                                                    <div class="progress mb-1" style="height: 4px;">
                                                        <div class="progress-bar bg-warning"
                                                            style="width: {{ $jamu->freshness_score }}%"></div>
                                                    </div>
                                                    <small class="text-muted">Freshness</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="text-success mb-0">
                                                Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                            </h5>
                                            @if ($jamu->expired_date)
                                                <small class="text-muted">
                                                    Exp: {{ date('d/m/Y', strtotime($jamu->expired_date)) }}
                                                </small>
                                            @endif
                                        </div>
                                        <a href="{{ route('jamu.show', $jamu->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-eye me-1"></i>
                                            Detail
                                        </a>
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
        </div>

        <!-- Pagination -->
        @if ($jamus->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $jamus->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <style>
        .jamu-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .jamu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .quality-indicator {
            padding: 0.5rem;
        }

        .badge {
            font-size: 0.75rem;
        }

        .card-title {
            line-height: 1.3;
        }

        .favorite-btn {
            transition: all 0.3s ease;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .jamu-card {
                margin-bottom: 1rem;
            }
        }
    </style>

    <script>
        // Auto-submit form on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const selects = form.querySelectorAll('select');

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });

            // Favorite functionality
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const jamuId = this.dataset.jamuId;

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
                                this.classList.toggle('btn-outline-danger');
                                this.classList.toggle('btn-danger');

                                // Show feedback
                                const toast = document.createElement('div');
                                toast.className = 'toast-notification';
                                toast.textContent = data.favorited ? 'Ditambahkan ke favorit' :
                                    'Dihapus dari favorit';
                                document.body.appendChild(toast);

                                setTimeout(() => {
                                    toast.remove();
                                }, 3000);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            // View toggle (placeholder for future implementation)
            document.getElementById('gridView').addEventListener('click', function() {
                this.classList.add('active');
                document.getElementById('listView').classList.remove('active');
                // Implement grid view
            });

            document.getElementById('listView').addEventListener('click', function() {
                this.classList.add('active');
                document.getElementById('gridView').classList.remove('active');
                // Implement list view
            });
        });
    </script>
@endsection
