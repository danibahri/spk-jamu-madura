@extends('layouts.app')

@section('title', $jamu->nama_jamu . ' - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <!-- Back Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jamu.index') }}" class="text-success">Daftar Jamu</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $jamu->nama_jamu }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Header Card -->
                <div class="card mb-4 border-0 shadow-lg">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="display-6 fw-bold text-success mb-3">
                                    {{ $jamu->nama_jamu }}
                                </h1>

                                <div class="mb-3">
                                    <span class="badge bg-secondary fs-6 me-2">{{ $jamu->kategori }}</span>
                                    @if ($jamu->is_expired)
                                        <span class="badge bg-danger fs-6">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Kadaluarsa
                                        </span>
                                    @else
                                        <span class="badge bg-success fs-6">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Fresh
                                        </span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center">
                                    <h2 class="text-success mb-0 me-3">
                                        Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                    </h2>
                                    @if ($jamu->expired_date)
                                        <small class="text-muted me-3">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Exp: {{ date('d/m/Y', strtotime($jamu->expired_date)) }}
                                        </small>
                                    @endif
                                    @auth
                                        <button
                                            class="btn {{ $jamu->isFavorited() ? 'btn-danger' : 'btn-outline-danger' }} favorite-toggle-btn"
                                            data-jamu-id="{{ $jamu->id }}"
                                            title="{{ $jamu->isFavorited() ? 'Hapus dari favorit' : 'Tambahkan ke favorit' }}">
                                            <i class="{{ $jamu->isFavorited() ? 'fas' : 'far' }} fa-heart"></i>
                                            {{ $jamu->isFavorited() ? 'Favorit' : 'Tambah ke Favorit' }}
                                        </button>
                                    @endauth
                                </div>
                            </div>

                            <div class="col-md-4 text-center">
                                <!-- Quality Score -->
                                <div class="quality-score mb-3">
                                    <div class="score-circle-large">
                                        <span
                                            class="score-value">{{ number_format(($jamu->nilai_kandungan + $jamu->nilai_khasiat) * 5, 0) }}</span>
                                        <small class="score-label">Quality Score</small>
                                    </div>
                                </div>

                                @auth
                                    <button class="btn btn-outline-danger favorite-btn mb-2"
                                        data-jamu-id="{{ $jamu->id }}">
                                        <i class="fas fa-heart me-2"></i>
                                        Favorit
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kandungan Section -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-vial me-2"></i>
                            Kandungan Herbal
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($jamu->kandungan_array as $kandungan)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="kandungan-item">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-leaf text-success me-2"></i>
                                            <span class="fw-bold">{{ trim($kandungan) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-light mt-3 rounded p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong class="text-primary">Nilai Kandungan:</strong>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $jamu->nilai_kandungan * 10 }}%">
                                            {{ $jamu->nilai_kandungan }}/10
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong class="text-success">Nilai Khasiat:</strong>
                                    <div class="progress mt-2">
                                        <div class="progress-bar bg-success"
                                            style="width: {{ $jamu->nilai_khasiat * 10 }}%">
                                            {{ $jamu->nilai_khasiat }}/10
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Khasiat Section -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-heart me-2"></i>
                            Khasiat & Manfaat
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="khasiat-content">
                            <p class="lead">{{ $jamu->khasiat }}</p>
                        </div>
                    </div>
                </div>

                <!-- Efek Samping Section -->
                @if ($jamu->efek_samping)
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Efek Samping & Peringatan
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Perhatian:</strong> Harap konsultasikan dengan ahli herbal atau dokter sebelum
                                mengonsumsi.
                            </div>
                            <p>{{ $jamu->efek_samping }}</p>
                        </div>
                    </div>
                @endif

                <!-- Related Jamu -->
                @if ($relatedJamus->count() > 0)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">
                                <i class="fas fa-sitemap me-2"></i>
                                Jamu Serupa
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($relatedJamus as $related)
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 bg-light border-0">
                                            <div class="card-body p-3">
                                                <h6 class="card-title text-success">
                                                    <a href="{{ route('jamu.show', $related->id) }}"
                                                        class="text-decoration-none">
                                                        {{ $related->nama_jamu }}
                                                    </a>
                                                </h6>
                                                <p class="card-text small text-muted mb-2">
                                                    {{ Str::limit($related->khasiat, 80) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-success fw-bold">
                                                        Rp {{ number_format($related->harga, 0, ',', '.') }}
                                                    </small>
                                                    <span class="badge bg-secondary">{{ $related->kategori }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        @auth
                            <div class="d-grid gap-2">
                                <button class="btn btn-success favorite-btn-lg" data-jamu-id="{{ $jamu->id }}">
                                    <i class="fas fa-heart me-2"></i>
                                    Tambah ke Favorit
                                </button>

                                <a href="{{ route('smart.index') }}" class="btn btn-primary">
                                    <i class="fas fa-calculator me-2"></i>
                                    Cari Rekomendasi Serupa
                                </a>

                                <button class="btn btn-info" onclick="shareJamu()">
                                    <i class="fas fa-share-alt me-2"></i>
                                    Bagikan
                                </button>
                            </div>
                        @else
                            <div class="text-center">
                                <p class="text-muted mb-3">Masuk untuk menggunakan fitur lengkap</p>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-success">
                                        <i class="fas fa-sign-in-alt me-2"></i>
                                        Masuk
                                    </a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-success">
                                        <i class="fas fa-user-plus me-2"></i>
                                        Daftar
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="stat-item">
                                    <h3 class="text-primary mb-1">{{ count($jamu->kandungan_array) }}</h3>
                                    <small class="text-muted">Kandungan Herbal</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="stat-item">
                                    <h3 class="text-success mb-1">{{ $jamu->nilai_khasiat }}/10</h3>
                                    <small class="text-muted">Rating Khasiat</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <h3 class="text-warning mb-1">{{ $jamu->freshness_score }}%</h3>
                                    <small class="text-muted">Freshness</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-item">
                                    <h3 class="text-info mb-1">{{ $jamu->kategori }}</h3>
                                    <small class="text-muted">Kategori</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-lightbulb me-2"></i>
                            Tips Penggunaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Konsultasi dengan ahli herbal
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Perhatikan tanggal kadaluarsa
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Ikuti petunjuk penggunaan
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Simpan di tempat sejuk
                            </li>
                            <li>
                                <i class="fas fa-check text-success me-2"></i>
                                Hentikan jika ada reaksi alergi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .score-circle-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #20c997);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0 auto;
        }

        .score-circle-large .score-value {
            font-size: 2rem;
            font-weight: bold;
            line-height: 1;
        }

        .score-circle-large .score-label {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .kandungan-item {
            padding: 0.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 0.5rem;
        }

        .stat-item {
            padding: 1rem 0;
        }

        .khasiat-content {
            line-height: 1.6;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .score-circle-large {
                width: 80px;
                height: 80px;
            }

            .score-circle-large .score-value {
                font-size: 1.5rem;
            }
        }
    </style>

    <script>
        // Favorite functionality
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteButtons = document.querySelectorAll('.favorite-btn, .favorite-btn-lg');

            favoriteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
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
                                favoriteButtons.forEach(button => {
                                    if (data.favorited) {
                                        button.classList.remove('btn-outline-danger');
                                        button.classList.add('btn-danger');
                                        button.innerHTML =
                                            '<i class="fas fa-heart me-2"></i>Hapus dari Favorit';
                                    } else {
                                        button.classList.remove('btn-danger');
                                        button.classList.add('btn-outline-danger');
                                        button.innerHTML =
                                            '<i class="fas fa-heart me-2"></i>Tambah ke Favorit';
                                    }
                                });

                                // Show notification
                                showNotification(
                                    data.favorited ? 'Ditambahkan ke favorit' :
                                    'Dihapus dari favorit',
                                    'success'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Terjadi kesalahan', 'error');
                        });
                });
            });
        });

        function shareJamu() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $jamu->nama_jamu }} - SPK Jamu Madura',
                    text: 'Lihat jamu tradisional berkualitas: {{ $jamu->nama_jamu }}',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showNotification('Link berhasil disalin!', 'success');
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
