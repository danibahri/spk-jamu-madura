@extends('layouts.app')

@section('title', 'Dashboard - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <!-- Welcome Header -->
        <div class="row mb-5">
            <div class="col-md-8">
                <h2 class="display-5 fw-bold text-success mb-3">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Selamat Datang, {{ auth()->user()->name }}!
                </h2>
                <p class="lead text-muted">
                    Kelola preferensi dan riwayat pencarian jamu tradisional Anda
                </p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('smart.index') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-search me-2"></i>
                    Cari Jamu Sekarang
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-3 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-heart fa-2x mb-3"></i>
                        <h3 class="mb-1">{{ $stats['favorites'] }}</h3>
                        <p class="mb-0">Jamu Favorit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-history fa-2x mb-3"></i>
                        <h3 class="mb-1">{{ $stats['searches'] }}</h3>
                        <p class="mb-0">Riwayat Pencarian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-info text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-sliders-h fa-2x mb-3"></i>
                        <h3 class="mb-1">{{ $stats['preferences'] }}</h3>
                        <p class="mb-0">Preferensi Tersimpan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-day fa-2x mb-3"></i>
                        <h3 class="mb-1">{{ $stats['days_active'] }}</h3>
                        <p class="mb-0">Hari Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Recent Search History -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-success d-flex justify-content-between align-items-center text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Pencarian Terbaru
                        </h5>
                        <a href="{{ route('user.search-history') }}" class="btn btn-sm btn-light">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($recentSearches->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($recentSearches as $search)
                                    <div class="list-group-item border-0 px-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="text-success mb-1">
                                                    @if ($search->search_query)
                                                        "{{ $search->search_query }}"
                                                    @else
                                                        Pencarian SMART Algorithm
                                                    @endif
                                                </h6>
                                                <p class="text-muted small mb-1">
                                                    @if ($search->filters)
                                                        @php $filters = json_decode($search->filters, true) @endphp
                                                        Kategori: {{ $filters['kategori'] ?? 'Semua' }} |
                                                        Budget:
                                                        {{ $filters['max_harga'] ? 'Rp ' . number_format($filters['max_harga'], 0, ',', '.') : 'Tidak dibatasi' }}
                                                    @endif
                                                </p>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $search->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="badge bg-primary">{{ $search->results_count }} hasil</span>
                                                @if ($search->filters)
                                                    <button class="btn btn-sm btn-outline-success ms-2"
                                                        onclick="repeatSearch({{ $search->id }})">
                                                        <i class="fas fa-redo"></i> Ulangi
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <i class="fas fa-search text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">Belum Ada Riwayat Pencarian</h5>
                                <p class="text-muted">Mulai cari jamu untuk melihat riwayat di sini</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Favorite Jamus -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-danger d-flex justify-content-between align-items-center text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-heart me-2"></i>
                            Jamu Favorit
                        </h5>
                        <a href="{{ route('user.favorites') }}" class="btn btn-sm btn-light">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($favorites->count() > 0)
                            <div class="row">
                                @foreach ($favorites as $favorite)
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-light h-100 border-0">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title text-success mb-2">
                                                        <a href="{{ route('jamu.show', $favorite->jamu->id) }}"
                                                            class="text-decoration-none">
                                                            {{ $favorite->jamu->nama_jamu }}
                                                        </a>
                                                    </h6>
                                                    <button class="btn btn-sm btn-outline-danger remove-favorite"
                                                        data-favorite-id="{{ $favorite->id }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>

                                                <div class="mb-2">
                                                    <span class="badge bg-secondary">{{ $favorite->jamu->kategori }}</span>
                                                    @if ($favorite->jamu->is_expired)
                                                        <span class="badge bg-danger">Kadaluarsa</span>
                                                    @else
                                                        <span class="badge bg-success">Fresh</span>
                                                    @endif
                                                </div>

                                                <p class="card-text small text-muted mb-2">
                                                    {{ Str::limit($favorite->jamu->khasiat, 80) }}
                                                </p>

                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="text-success fw-bold">
                                                        Rp {{ number_format($favorite->jamu->harga, 0, ',', '.') }}
                                                    </span>
                                                    <small class="text-muted">
                                                        Ditambahkan {{ $favorite->created_at->diffForHumans() }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <i class="fas fa-heart text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">Belum Ada Jamu Favorit</h5>
                                <p class="text-muted">Tambahkan jamu ke favorit untuk melihatnya di sini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('smart.index') }}" class="btn btn-success">
                                <i class="fas fa-calculator me-2"></i>
                                Cari dengan SMART Algorithm
                            </a>
                            <a href="{{ route('jamu.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-list me-2"></i>
                                Jelajahi Semua Jamu
                            </a>
                            <a href="{{ route('user.preferences') }}" class="btn btn-outline-primary">
                                <i class="fas fa-cog me-2"></i>
                                Kelola Preferensi
                            </a>
                            <a href="{{ route('articles.index') }}" class="btn btn-outline-info">
                                <i class="fas fa-book me-2"></i>
                                Baca Artikel Herbal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Saved Preferences -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-bookmark me-2"></i>
                            Preferensi Tersimpan
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($savedPreferences->count() > 0)
                            @foreach ($savedPreferences as $pref)
                                <div class="preference-item bg-light mb-3 rounded p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $pref->name ?? 'Preferensi #' . $pref->id }}</h6>
                                            <small class="text-muted">
                                                Kandungan: {{ $pref->kandungan_weight }}% |
                                                Khasiat: {{ $pref->khasiat_weight }}% |
                                                Harga: {{ $pref->harga_weight }}%
                                            </small>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('smart.index', ['pref_id' => $pref->id]) }}">
                                                        <i class="fas fa-play me-2"></i>Gunakan
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-danger"
                                                        onclick="deletePreference({{ $pref->id }})">
                                                        <i class="fas fa-trash me-2"></i>Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada preferensi tersimpan</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-newspaper me-2"></i>
                            Artikel Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($recentArticles->count() > 0)
                            @foreach ($recentArticles as $article)
                                <div class="article-item mb-3">
                                    <h6 class="mb-1">
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="text-decoration-none">
                                            {{ $article->title }}
                                        </a>
                                    </h6>
                                    <p class="small text-muted mb-1">
                                        {{ Str::limit($article->excerpt, 80) }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $article->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                @if (!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada artikel</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Remove favorite functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.remove-favorite').forEach(btn => {
                btn.addEventListener('click', function() {
                    const favoriteId = this.dataset.favoriteId;

                    if (confirm('Apakah Anda yakin ingin menghapus dari favorit?')) {
                        fetch(`/favorites/${favoriteId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('.col-md-6').remove();
                                    showNotification('Berhasil dihapus dari favorit',
                                    'success');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('Terjadi kesalahan', 'error');
                            });
                    }
                });
            });
        });

        function repeatSearch(searchId) {
            fetch(`/user/repeat-search/${searchId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function deletePreference(prefId) {
            if (confirm('Apakah Anda yakin ingin menghapus preferensi ini?')) {
                fetch(`/user/preferences/${prefId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} notification-toast`;
            notification.textContent = message;
            notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        .preference-item {
            transition: all 0.3s ease;
        }

        .preference-item:hover {
            background-color: #e9ecef !important;
        }

        .article-item {
            padding-bottom: 0.5rem;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endsection
