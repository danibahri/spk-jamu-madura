@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid my-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1">Admin Dashboard</h2>
                        <p class="text-muted mb-0">Kelola sistem SPK Jamu Madura</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.jamu.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Tambah Jamu
                        </a>
                        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Artikel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1 text-xs">
                                    Total Jamu
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $stats['total_jamu'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-leaf fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="font-weight-bold text-success text-uppercase mb-1 text-xs">
                                    Total Pengguna
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $stats['total_users'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="font-weight-bold text-info text-uppercase mb-1 text-xs">
                                    Total Artikel
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $stats['total_articles'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning h-100 py-2 shadow">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col me-2">
                                <div class="font-weight-bold text-warning text-uppercase mb-1 text-xs">
                                    Pencarian Hari Ini
                                </div>
                                <div class="h5 font-weight-bold mb-0 text-gray-800">{{ $stats['searches_today'] }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-search fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <!-- Jamu Management -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h6 class="font-weight-bold text-primary m-0">Manajemen Jamu</h6>
                        <a href="{{ route('admin.jamu.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-hover table">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_jamus as $jamu)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/40x40?text=J"
                                                        alt="{{ $jamu->nama_jamu }}" class="me-2 rounded" width="40"
                                                        height="40">
                                                    <div>
                                                        <div class="fw-bold">{{ Str::limit($jamu->nama_jamu, 20) }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $jamu->kategori }}</span>
                                            </td>
                                            <td>Rp {{ number_format($jamu->harga, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($jamu->expired_date > now())
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Expired</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.jamu.edit', $jamu->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.jamu.destroy', $jamu->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Yakin ingin menghapus?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-muted text-center">Belum ada data jamu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h6 class="font-weight-bold text-success m-0">Aktivitas Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-hover table">
                                <thead>
                                    <tr>
                                        <th>Pengguna</th>
                                        <th>Aktivitas</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_activities as $activity)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $activity['user_name'] }}</div>
                                                        <small class="text-muted">{{ $activity['user_email'] }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $activity['action'] }}</span>
                                                @if (isset($activity['details']))
                                                    <br><small class="text-muted">{{ $activity['details'] }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $activity['time'] }}</small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center">Belum ada aktivitas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Popular Categories -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="font-weight-bold text-primary m-0">Kategori Populer</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="categoryChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Search Trends -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="font-weight-bold text-info m-0">Tren Pencarian</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="searchChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h6 class="font-weight-bold text-info m-0">Artikel Terbaru</h6>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-info text-white">Kelola
                            Artikel</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($recent_articles as $article)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <img src="{{ asset($article->featured_image) }}" class="card-img-top"
                                            alt="{{ $article->title }}">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ Str::limit($article->title, 50) }}</h6>
                                            <p class="card-text text-muted small">
                                                {{ Str::limit($article->excerpt, 80) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    {{ $article->created_at->diffForHumans() }}
                                                </small>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('articles.show', $article->slug) }}"
                                                        class="btn btn-sm btn-outline-info" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 py-4 text-center">
                                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada artikel</h5>
                                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Buat Artikel Pertama
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Category Chart
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($category_stats->pluck('kategori')) !!},
                        datasets: [{
                            data: {!! json_encode($category_stats->pluck('count')) !!},
                            backgroundColor: [
                                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                                '#858796', '#5a5c69', '#6f42c1', '#e83e8c', '#fd7e14'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

                // Search Trends Chart
                const searchCtx = document.getElementById('searchChart').getContext('2d');
                new Chart(searchCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($search_trends->pluck('date')) !!},
                        datasets: [{
                            label: 'Pencarian per Hari',
                            data: {!! json_encode($search_trends->pluck('count')) !!},
                            borderColor: '#36b9cc',
                            backgroundColor: 'rgba(54, 185, 204, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .border-left-primary {
                border-left: 0.25rem solid #4e73df !important;
            }

            .border-left-success {
                border-left: 0.25rem solid #1cc88a !important;
            }

            .border-left-info {
                border-left: 0.25rem solid #36b9cc !important;
            }

            .border-left-warning {
                border-left: 0.25rem solid #f6c23e !important;
            }

            .avatar-sm {
                width: 2rem;
                height: 2rem;
            }
        </style>
    @endpush
@endsection
