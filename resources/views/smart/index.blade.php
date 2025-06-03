@extends('layouts.app')

@section('title', 'SMART Algorithm - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Header -->
                <div class="mb-5 text-center">
                    <h2 class="display-5 fw-bold text-success mb-3">
                        <i class="fas fa-calculator me-3"></i>
                        Sistem Rekomendasi Jamu
                    </h2>
                    <p class="lead text-muted">
                        Gunakan algoritma SMART untuk menemukan jamu tradisional Madura yang sesuai dengan kebutuhan Anda
                    </p>
                </div>

                <!-- Criteria Form -->
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-success py-4 text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-sliders-h me-2"></i>
                            Tentukan Kriteria Prioritas Anda
                        </h4>
                    </div>

                    <div class="card-body p-4">
                        <form id="smartForm" method="POST" action="{{ route('smart.calculate') }}">
                            @csrf

                            <div class="row">
                                <!-- Kandungan Weight -->
                                <div class="col-md-6 mb-4">
                                    <div class="criteria-card h-100">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-vial text-primary fs-4 me-3"></i>
                                            <div>
                                                <h5 class="mb-1">Kandungan Herbal</h5>
                                                <small class="text-muted">Seberapa penting kualitas kandungan?</small>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="kandungan_weight" class="form-label fw-bold">
                                                Bobot: <span id="kandungan_value">25</span>%
                                            </label>                                            <input type="range" class="form-range" id="kandungan_weight"
                                                name="weights[kandungan]" min="0" max="100" value="25"
                                                oninput="updateValue('kandungan', this.value)">
                                        </div>
                                    </div>
                                </div>

                                <!-- Khasiat Weight -->
                                <div class="col-md-6 mb-4">
                                    <div class="criteria-card h-100">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-heart text-danger fs-4 me-3"></i>
                                            <div>
                                                <h5 class="mb-1">Khasiat</h5>
                                                <small class="text-muted">Seberapa penting manfaat kesehatan?</small>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="khasiat_weight" class="form-label fw-bold">
                                                Bobot: <span id="khasiat_value">30</span>%
                                            </label>                                            <input type="range" class="form-range" id="khasiat_weight"
                                                name="weights[khasiat]" min="0" max="100" value="30"
                                                oninput="updateValue('khasiat', this.value)">
                                        </div>
                                    </div>
                                </div>

                                <!-- Harga Weight -->
                                <div class="col-md-6 mb-4">
                                    <div class="criteria-card h-100">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-money-bill-wave text-success fs-4 me-3"></i>
                                            <div>
                                                <h5 class="mb-1">Harga</h5>
                                                <small class="text-muted">Seberapa penting faktor harga?</small>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="harga_weight" class="form-label fw-bold">
                                                Bobot: <span id="harga_value">20</span>%
                                            </label>                                            <input type="range" class="form-range" id="harga_weight" name="weights[harga]"
                                                min="0" max="100" value="20"
                                                oninput="updateValue('harga', this.value)">
                                        </div>
                                    </div>
                                </div>

                                <!-- Expired Weight -->
                                <div class="col-md-6 mb-4">
                                    <div class="criteria-card h-100">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="fas fa-calendar-alt text-warning fs-4 me-3"></i>
                                            <div>
                                                <h5 class="mb-1">Tanggal Kadaluarsa</h5>
                                                <small class="text-muted">Seberapa penting masa simpan?</small>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="expired_weight" class="form-label fw-bold">
                                                Bobot: <span id="expired_value">25</span>%
                                            </label>                                            <input type="range" class="form-range" id="expired_weight"
                                                name="weights[expired]" min="0" max="100" value="25"
                                                oninput="updateValue('expired', this.value)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Filters -->
                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kategori" class="form-label fw-bold">Kategori Jamu</label>                                    <select class="form-select" id="kategori" name="filters[category]">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}">{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="max_harga" class="form-label fw-bold">Budget Maksimal</label>
                                    <select class="form-select" id="max_harga" name="filters[max_price]">
                                        <option value="">Tidak Dibatasi</option>
                                        <option value="50000">≤ Rp 50.000</option>
                                        <option value="100000">≤ Rp 100.000</option>
                                        <option value="200000">≤ Rp 200.000</option>
                                        <option value="500000">≤ Rp 500.000</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-search me-2"></i>
                                    Cari Rekomendasi Jamu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="card border-info mt-4">
                    <div class="card-body">
                        <h5 class="card-title text-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Cara Penggunaan
                        </h5>
                        <ul class="list-unstyled mb-0">
                            <li><i class="fas fa-check text-success me-2"></i>Atur bobot setiap kriteria sesuai prioritas
                                Anda</li>
                            <li><i class="fas fa-check text-success me-2"></i>Pilih kategori dan budget sesuai kebutuhan
                            </li>
                            <li><i class="fas fa-check text-success me-2"></i>Sistem akan memberikan rekomendasi
                                berdasarkan algoritma SMART</li>
                            <li><i class="fas fa-check text-success me-2"></i>Hasil akan diurutkan dari yang paling sesuai
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .criteria-card {
            padding: 1.5rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .criteria-card:hover {
            border-color: #28a745;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.1);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .form-range::-webkit-slider-thumb {
            background: #28a745;
        }

        .form-range::-moz-range-thumb {
            background: #28a745;
        }
    </style>

    <script>
        function updateValue(criteria, value) {
            document.getElementById(criteria + '_value').textContent = value;
        }

        // Auto-save preferences
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('smartForm');
            const ranges = form.querySelectorAll('input[type="range"]');

            ranges.forEach(range => {
                range.addEventListener('change', function() {
                    // Save to localStorage for user preference
                    localStorage.setItem(this.name, this.value);
                });

                // Load from localStorage
                const saved = localStorage.getItem(range.name);
                if (saved) {
                    range.value = saved;
                    updateValue(range.name.replace('_weight', ''), saved);
                }
            });
        });
    </script>
@endsection
