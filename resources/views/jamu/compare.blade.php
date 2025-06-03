@extends('layouts.app')

@section('title', 'Perbandingan Jamu')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Perbandingan Jamu</h2>
                        <p class="text-muted mb-0">Bandingkan {{ count($jamus) }} produk jamu yang dipilih</p>
                    </div>
                    <a href="{{ route('jamu.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>

                @if (count($jamus) >= 2)
                    <!-- Comparison Table -->
                    <div class="card shadow-sm">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-hover mb-0 table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th scope="col" class="px-4 py-3">Kriteria</th>
                                            @foreach ($jamus as $jamu)
                                                <th scope="col" class="px-4 py-3 text-center">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <img src="https://via.placeholder.com/60x60?text=J"
                                                            alt="{{ $jamu->nama_jamu }}" class="mb-2 rounded">
                                                        <strong class="text-truncate" style="max-width: 150px;">
                                                            {{ $jamu->nama_jamu }}
                                                        </strong>
                                                    </div>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Kategori -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-tags text-primary me-2"></i>Kategori
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3 text-center">
                                                    <span class="badge bg-secondary">{{ $jamu->kategori }}</span>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Harga -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-money-bill text-success me-2"></i>Harga
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3 text-center">
                                                    <strong class="text-success fs-5">
                                                        Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                                    </strong>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Kandungan -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-leaf text-success me-2"></i>Kandungan
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3">
                                                    <div class="text-sm">{{ $jamu->kandungan }}</div>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Khasiat -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-heart text-danger me-2"></i>Khasiat
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3">
                                                    <div class="text-sm">{{ $jamu->khasiat }}</div>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Efek Samping -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>Efek Samping
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3">
                                                    <div class="text-muted text-sm">
                                                        {{ $jamu->efek_samping ?: 'Tidak ada' }}
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Nilai Kandungan -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-star text-warning me-2"></i>Nilai Kandungan
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3 text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                                            <div class="progress-bar bg-warning"
                                                                style="width: {{ ($jamu->nilai_kandungan / 10) * 100 }}%">
                                                            </div>
                                                        </div>
                                                        <span class="fw-bold">{{ $jamu->nilai_kandungan }}/10</span>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Nilai Khasiat -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-thumbs-up text-primary me-2"></i>Nilai Khasiat
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3 text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <div class="progress me-2" style="width: 60px; height: 8px;">
                                                            <div class="progress-bar bg-primary"
                                                                style="width: {{ ($jamu->nilai_khasiat / 10) * 100 }}%">
                                                            </div>
                                                        </div>
                                                        <span class="fw-bold">{{ $jamu->nilai_khasiat }}/10</span>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Expired Date -->
                                        <tr>
                                            <td class="fw-bold bg-light px-4 py-3">
                                                <i class="fas fa-calendar text-info me-2"></i>Tanggal Expired
                                            </td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3 text-center">
                                                    <span
                                                        class="badge {{ \Carbon\Carbon::parse($jamu->expired_date)->diffInDays() < 30 ? 'bg-danger' : 'bg-success' }}">
                                                        {{ \Carbon\Carbon::parse($jamu->expired_date)->format('d M Y') }}
                                                    </span>
                                                </td>
                                            @endforeach
                                        </tr>

                                        <!-- Actions -->
                                        <tr class="bg-light">
                                            <td class="fw-bold px-4 py-3">Aksi</td>
                                            @foreach ($jamus as $jamu)
                                                <td class="px-4 py-3 text-center">
                                                    <div class="d-flex flex-column gap-2">
                                                        <a href="{{ route('jamu.show', $jamu->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye me-1"></i>Detail
                                                        </a>
                                                        @auth
                                                            <form action="{{ route('favorites.toggle') }}" method="POST"
                                                                class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="jamu_id"
                                                                    value="{{ $jamu->id }}">
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="fas fa-heart me-1"></i>Favorit
                                                                </button>
                                                            </form>
                                                        @endauth
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Cards -->
                    <div class="row mt-4">
                        @php
                            $bestPrice = $jamus->min('harga');
                            $bestKandungan = $jamus->max('nilai_kandungan');
                            $bestKhasiat = $jamus->max('nilai_khasiat');
                            $bestOverall = $jamus
                                ->sortByDesc(function ($jamu) {
                                    return ($jamu->nilai_kandungan + $jamu->nilai_khasiat) / 2;
                                })
                                ->first();
                        @endphp

                        <div class="col-md-3 mb-3">
                            <div class="card bg-success h-100 text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                                    <h6>Harga Terbaik</h6>
                                    <p class="mb-1">{{ $jamus->where('harga', $bestPrice)->first()->nama_jamu }}</p>
                                    <strong>Rp {{ number_format($bestPrice, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-warning text-dark h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-leaf fa-2x mb-2"></i>
                                    <h6>Kandungan Terbaik</h6>
                                    <p class="mb-1">
                                        {{ $jamus->where('nilai_kandungan', $bestKandungan)->first()->nama_jamu }}</p>
                                    <strong>{{ $bestKandungan }}/10</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-primary h-100 text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-thumbs-up fa-2x mb-2"></i>
                                    <h6>Khasiat Terbaik</h6>
                                    <p class="mb-1">
                                        {{ $jamus->where('nilai_khasiat', $bestKhasiat)->first()->nama_jamu }}</p>
                                    <strong>{{ $bestKhasiat }}/10</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="card bg-info h-100 text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-crown fa-2x mb-2"></i>
                                    <h6>Pilihan Terbaik</h6>
                                    <p class="mb-1">{{ $bestOverall->nama_jamu }}</p>
                                    <strong>Score:
                                        {{ number_format(($bestOverall->nilai_kandungan + $bestOverall->nilai_khasiat) / 2, 1) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Actions -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">Ingin rekomendasi yang lebih akurat?</h5>
                                    <p class="card-text">Gunakan sistem rekomendasi SMART untuk mendapatkan hasil yang
                                        disesuaikan dengan preferensi Anda.</p>
                                    <a href="{{ route('smart.index') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-brain me-2"></i>Coba Sistem SMART
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Not enough items to compare -->
                    <div class="py-5 text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h4>Tidak cukup produk untuk dibandingkan</h4>
                        <p class="text-muted">Pilih minimal 2 produk jamu untuk melakukan perbandingan.</p>
                        <a href="{{ route('jamu.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Cari Produk Jamu
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Add any comparison-specific JavaScript here
            document.addEventListener('DOMContentLoaded', function() {
                // Highlight best values in each category
                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td:not(:first-child)');
                    if (cells.length === 0) return;

                    // For numeric values, find the best one
                    const rowType = row.querySelector('td:first-child i').className;

                    if (rowType.includes('fa-money-bill')) {
                        // For price, lower is better
                        let minPrice = Infinity;
                        let minCell = null;

                        cells.forEach(cell => {
                            const priceText = cell.textContent.replace(/[^\d]/g, '');
                            const price = parseInt(priceText);
                            if (price < minPrice) {
                                minPrice = price;
                                minCell = cell;
                            }
                        });

                        if (minCell) {
                            minCell.classList.add('bg-success', 'bg-opacity-25');
                        }
                    } else if (rowType.includes('fa-star') || rowType.includes('fa-thumbs-up')) {
                        // For ratings, higher is better
                        let maxValue = -1;
                        let maxCell = null;

                        cells.forEach(cell => {
                            const valueText = cell.textContent.match(/(\d+(\.\d+)?)/);
                            if (valueText) {
                                const value = parseFloat(valueText[1]);
                                if (value > maxValue) {
                                    maxValue = value;
                                    maxCell = cell;
                                }
                            }
                        });

                        if (maxCell) {
                            maxCell.classList.add('bg-success', 'bg-opacity-25');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
