@extends('layouts.app')

@section('title', 'Perbandingan Jamu - SMART Algorithm')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold text-success mb-1">
                            <i class="fas fa-balance-scale me-2"></i>
                            Perbandingan Jamu
                        </h2>
                        <p class="text-muted mb-0">Analisis perbandingan menggunakan algoritma SMART</p>
                    </div>
                    <a href="{{ route('smart.index') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Kriteria
                    </a>
                </div>

                @if (!empty($comparisons) && count($comparisons) >= 2)
                    <!-- Comparison Cards -->
                    <div class="row">
                        @foreach ($comparisons as $index => $comparison)
                            <div
                                class="col-lg-{{ count($comparisons) == 2 ? '6' : (count($comparisons) == 3 ? '4' : '3') }} mb-4">
                                <div class="card comparison-card h-100 {{ $index === 0 ? 'border-success' : '' }}">
                                    @if ($index === 0)
                                        <div class="ribbon">
                                            <span>TERBAIK</span>
                                        </div>
                                    @endif

                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="fw-bold mb-0">{{ $comparison['jamu']->nama }}</h5>
                                            <span class="badge bg-{{ $index === 0 ? 'success' : 'secondary' }} fs-6">
                                                Rank #{{ $index + 1 }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <!-- SMART Score -->
                                        <div class="mb-4 text-center">
                                            <div class="score-circle-large {{ $index === 0 ? 'best-score' : '' }}">
                                                <span
                                                    class="score-value">{{ number_format($comparison['total_score'] * 100, 0) }}</span>
                                                <small class="score-label">SMART Score</small>
                                            </div>
                                        </div>

                                        <!-- Jamu Details -->
                                        <div class="jamu-details mb-4">
                                            <div class="mb-3">
                                                <span class="badge bg-secondary">{{ $comparison['jamu']->kategori }}</span>
                                                @if ($comparison['jamu']->is_expired)
                                                    <span class="badge bg-danger">Kadaluarsa</span>
                                                @else
                                                    <span class="badge bg-success">Fresh</span>
                                                @endif
                                            </div>

                                            <p class="text-muted mb-2">
                                                <strong>Kandungan:</strong><br>
                                                {{ implode(', ', $comparison['jamu']->kandungan_array) }}
                                            </p>

                                            <p class="text-muted mb-3">
                                                <strong>Khasiat:</strong><br>
                                                {{ Str::limit($comparison['jamu']->khasiat, 120) }}
                                            </p>

                                            <div class="price-info">
                                                <h5 class="text-success mb-1">
                                                    Rp {{ number_format($comparison['jamu']->harga, 0, ',', '.') }}
                                                </h5>
                                                <small class="text-muted">
                                                    Exp:
                                                    {{ $comparison['jamu']->expired_date ? date('d/m/Y', strtotime($comparison['jamu']->expired_date)) : '-' }}
                                                </small>
                                            </div>
                                        </div>

                                        <!-- Detailed Scores -->
                                        <div class="criteria-scores">
                                            <h6 class="fw-bold mb-3">Skor per Kriteria:</h6>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Kandungan</small>
                                                    <small
                                                        class="fw-bold">{{ number_format($comparison['scores']['kandungan'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-primary"
                                                        style="width: {{ $comparison['scores']['kandungan'] * 100 }}%">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Khasiat</small>
                                                    <small
                                                        class="fw-bold">{{ number_format($comparison['scores']['khasiat'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-danger"
                                                        style="width: {{ $comparison['scores']['khasiat'] * 100 }}%"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Harga</small>
                                                    <small
                                                        class="fw-bold">{{ number_format($comparison['scores']['harga'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success"
                                                        style="width: {{ $comparison['scores']['harga'] * 100 }}%"></div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Freshness</small>
                                                    <small
                                                        class="fw-bold">{{ number_format($comparison['scores']['expired'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-warning"
                                                        style="width: {{ $comparison['scores']['expired'] * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-light">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('jamu.show', $comparison['jamu']->id) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </a>
                                            @auth
                                                <button class="btn btn-sm btn-outline-danger favorite-btn"
                                                    data-jamu-id="{{ $comparison['jamu']->id }}">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Weights Info -->
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-weight-hanging me-2"></i>
                                Bobot Kriteria yang Digunakan
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <div class="weight-info">
                                        <i class="fas fa-vial text-primary fs-2"></i>
                                        <h5 class="mb-1 mt-2">Kandungan</h5>
                                        <span class="badge bg-primary fs-6">{{ $weights['kandungan'] }}%</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="weight-info">
                                        <i class="fas fa-heart text-danger fs-2"></i>
                                        <h5 class="mb-1 mt-2">Khasiat</h5>
                                        <span class="badge bg-danger fs-6">{{ $weights['khasiat'] }}%</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="weight-info">
                                        <i class="fas fa-money-bill-wave text-success fs-2"></i>
                                        <h5 class="mb-1 mt-2">Harga</h5>
                                        <span class="badge bg-success fs-6">{{ $weights['harga'] }}%</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <div class="weight-info">
                                        <i class="fas fa-clock text-warning fs-2"></i>
                                        <h5 class="mb-1 mt-2">Freshness</h5>
                                        <span class="badge bg-warning fs-6">{{ $weights['expired'] }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="py-5 text-center">
                        <i class="fas fa-exclamation-triangle text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">Data Tidak Lengkap</h4>
                        <p class="text-muted">Minimal 2 jamu diperlukan untuk perbandingan</p>
                        <a href="{{ route('smart.index') }}" class="btn btn-success">
                            <i class="fas fa-arrow-left me-2"></i>
                            Kembali ke Kriteria
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .comparison-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .comparison-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .ribbon {
            position: absolute;
            top: 15px;
            right: -35px;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 5px 40px;
            font-size: 12px;
            font-weight: bold;
            transform: rotate(45deg);
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .score-circle-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: 4px solid #6c757d;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
        }

        .score-circle-large.best-score {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-color: #28a745;
            box-shadow: 0 0 20px rgba(40, 167, 69, 0.3);
        }

        .score-circle-large .score-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #495057;
        }

        .best-score .score-value {
            color: #155724;
        }

        .score-circle-large .score-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #6c757d;
            margin-top: -2px;
        }

        .best-score .score-label {
            color: #155724;
        }

        .progress-sm {
            height: 8px;
        }

        .weight-info {
            padding: 1rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {

            .col-lg-4,
            .col-lg-3 {
                margin-bottom: 1rem;
            }

            .score-circle-large {
                width: 80px;
                height: 80px;
            }

            .score-circle-large .score-value {
                font-size: 1.2rem;
            }
        }
    </style>

    <script>
        // Favorite functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.favorite-btn').forEach(btn => {
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
                                this.classList.toggle('btn-outline-danger');
                                this.classList.toggle('btn-danger');
                            }
                        });
                });
            });
        });
    </script>
@endsection
