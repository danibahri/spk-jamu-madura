@extends('layouts.app')

@section('title', 'Hasil Rekomendasi - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <!-- Header -->
        <div class="mb-5 text-center">
            <h2 class="display-5 fw-bold text-success mb-3">
                <i class="fas fa-star me-3"></i>
                Rekomendasi Jamu Untuk Anda
            </h2>
            <p class="lead text-muted">
                Berdasarkan kriteria yang Anda tentukan, berikut adalah {{ !empty($results) ? count($results) : 0 }} jamu
                terbaik
            </p>
        </div>

        <!-- Criteria Summary -->
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-cog me-2"></i>
                    Kriteria yang Digunakan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="criteria-summary">
                            <i class="fas fa-vial text-primary fs-2"></i>
                            <h6 class="mt-2">Kandungan</h6>
                            <span class="badge bg-primary fs-6">{{ round($weights['kandungan'] * 100) }}%</span>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="criteria-summary">
                            <i class="fas fa-heart text-danger fs-2"></i>
                            <h6 class="mt-2">Khasiat</h6>
                            <span class="badge bg-danger fs-6">{{ round($weights['khasiat'] * 100) }}%</span>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="criteria-summary">
                            <i class="fas fa-money-bill-wave text-success fs-2"></i>
                            <h6 class="mt-2">Harga</h6>
                            <span class="badge bg-success fs-6">{{ round($weights['harga'] * 100) }}%</span>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="criteria-summary">
                            <i class="fas fa-calendar-alt text-warning fs-2"></i>
                            <h6 class="mt-2">Kadaluarsa</h6>
                            <span class="badge bg-warning fs-6">{{ round($weights['expired'] * 100) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('smart.index') }}" class="btn btn-outline-success">
                    <i class="fas fa-arrow-left me-2"></i>
                    Ubah Kriteria
                </a>
            </div>
            <div>
                <button class="btn btn-info" onclick="compareSelected()">
                    <i class="fas fa-balance-scale me-2"></i>
                    Bandingkan Terpilih
                </button>
            </div>
        </div>

        <!-- Results -->
        @if (!empty($results) && count($results) > 0)
            <div class="row">
                @foreach ($results as $index => $item)
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 recommendation-card shadow-sm" data-rank="{{ $index + 1 }}">
                            <!-- Rank Badge -->
                            <div class="position-relative">
                                @if ($index < 3)
                                    <div class="rank-badge rank-{{ $index + 1 }}">
                                        <i class="fas fa-trophy"></i>
                                        #{{ $index + 1 }}
                                    </div>
                                @else
                                    <div class="rank-badge rank-other">
                                        #{{ $index + 1 }}
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="card-title text-success fw-bold">
                                            {{ $item['jamu']->nama_jamu }}
                                        </h5>

                                        <div class="mb-3">
                                            <span class="badge bg-secondary">{{ $item['jamu']->kategori }}</span>
                                            @if ($item['jamu']->is_expired)
                                                <span class="badge bg-danger">Kadaluarsa</span>
                                            @else
                                                <span class="badge bg-success">Fresh</span>
                                            @endif
                                        </div>

                                        <p class="card-text text-muted mb-2"> <strong>Kandungan:</strong>
                                            {{ implode(', ', array_slice($item['jamu']->kandungan_array, 0, 3)) }}
                                            @if (!empty($item['jamu']->kandungan_array) && count($item['jamu']->kandungan_array) > 3)
                                                <span class="text-info">+{{ count($item['jamu']->kandungan_array) - 3 }}
                                                    lainnya</span>
                                            @endif
                                        </p>

                                        <p class="card-text text-muted mb-3">
                                            <strong>Khasiat:</strong> {{ Str::limit($item['jamu']->khasiat, 100) }}
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="text-success mb-0">
                                                    Rp {{ number_format($item['jamu']->harga, 0, ',', '.') }}
                                                </h5>
                                                <small class="text-muted">
                                                    Exp:
                                                    {{ $item['jamu']->expired_date ? date('d/m/Y', strtotime($item['jamu']->expired_date)) : '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 text-center">
                                        <!-- SMART Score -->
                                        <div class="smart-score mb-3">
                                            <div class="score-circle">
                                                <span
                                                    class="score-value">{{ number_format($item['score'] * 100, 0) }}</span>
                                                <small class="score-label">SMART</small>
                                            </div>
                                        </div>

                                        <!-- Detail Scores -->
                                        <div class="detail-scores">
                                            <div class="row text-center">
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted">Kandungan</small>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-primary"
                                                            style="width: {{ $item['normalized_scores']['kandungan'] * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ number_format($item['normalized_scores']['kandungan'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted">Khasiat</small>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-danger"
                                                            style="width: {{ $item['normalized_scores']['khasiat'] * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ number_format($item['normalized_scores']['khasiat'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted">Harga</small>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-success"
                                                            style="width: {{ $item['normalized_scores']['harga'] * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ number_format($item['normalized_scores']['harga'] * 100, 0) }}%</small>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <small class="text-muted">Freshness</small>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-warning"
                                                            style="width: {{ $item['normalized_scores']['expired'] * 100 }}%">
                                                        </div>
                                                    </div>
                                                    <small>{{ number_format($item['normalized_scores']['expired'] * 100, 0) }}%</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input compare-check" type="checkbox"
                                            value="{{ $item['jamu']->id }}" id="compare_{{ $item['jamu']->id }}">
                                        <label class="form-check-label text-muted" for="compare_{{ $item['jamu']->id }}">
                                            Bandingkan
                                        </label>
                                    </div>

                                    <div>
                                        <a href="{{ route('jamu.show', $item['jamu']->id) }}"
                                            class="btn btn-sm btn-outline-success me-2">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>

                                        @auth
                                            <button class="btn btn-sm btn-outline-danger favorite-btn"
                                                data-jamu-id="{{ $item['jamu']->id }}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> <!-- Pagination if needed -->
            @if (!empty($results) && count($results) > 10)
                <div class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            <!-- Add pagination logic here -->
                        </ul>
                    </nav>
                </div>
            @endif
        @else
            <div class="py-5 text-center">
                <i class="fas fa-search text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">Tidak Ada Hasil</h4>
                <p class="text-muted">Coba ubah kriteria atau filter pencarian Anda</p>
                <a href="{{ route('smart.index') }}" class="btn btn-success">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Kriteria
                </a>
            </div>
        @endif
    </div>

    <style>
        .recommendation-card {
            transition: all 0.3s ease;
            position: relative;
        }

        .recommendation-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .rank-badge {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            z-index: 10;
            font-size: 0.9rem;
        }

        .rank-1 {
            background: linear-gradient(135deg, #FFD700, #FFA500);
        }

        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0, #A9A9A9);
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32, #8B4513);
        }

        .rank-other {
            background: linear-gradient(135deg, #6c757d, #495057);
        }

        .score-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #20c997);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0 auto;
        }

        .score-value {
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1;
        }

        .score-label {
            font-size: 0.7rem;
            opacity: 0.9;
        }

        .progress-sm {
            height: 4px;
        }

        .criteria-summary {
            padding: 1rem;
        }

        .detail-scores small {
            font-size: 0.7rem;
        }
    </style>

    <script>
        function compareSelected() {
            const selected = document.querySelectorAll('.compare-check:checked');
            if (selected.length < 2) {
                alert('Pilih minimal 2 jamu untuk dibandingkan');
                return;
            }
            if (selected.length > 4) {
                alert('Maksimal 4 jamu dapat dibandingkan');
                return;
            }

            const ids = Array.from(selected).map(cb => cb.value);

            // Create a form to submit to smart.compare route with POST method
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('smart.compare') }}';
            form.target = '_blank';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrfInput);

            // Add jamu IDs
            ids.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'jamus[]';
                input.value = id;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }

        // Favorite functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const jamuId = this.dataset.jamuId;
                    // Add AJAX call to toggle favorite
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
