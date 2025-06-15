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

                            <!-- Search Query (Optional) -->
                            <div class="mb-4">
                                <label for="search_query" class="form-label fw-bold">
                                    <i class="fas fa-search me-2"></i>Kata Kunci Pencarian (Opsional)
                                </label>
                                <input type="text" class="form-control" id="search_query" name="search_query"
                                    placeholder="Contoh: diabetes, hipertensi, stamina...">
                                <small class="form-text text-muted">
                                    Masukkan kata kunci untuk mencari jamu dengan khasiat tertentu
                                </small>
                            </div>

                            <hr class="my-4">

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
                                        <div class="mb-3"> <label for="kandungan_weight" class="form-label fw-bold">
                                                Bobot: <span
                                                    id="kandungan_value">{{ isset($userPreference) && $userPreference ? round($userPreference->weight_kandungan * 100) : 25 }}</span>%
                                            </label> <input type="range" class="form-range" id="kandungan_weight"
                                                name="weights[kandungan]" min="0" max="100"
                                                value="{{ isset($userPreference) && $userPreference ? round($userPreference->weight_kandungan * 100) : 25 }}"
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
                                        <div class="mb-3"> <label for="khasiat_weight" class="form-label fw-bold">
                                                Bobot: <span
                                                    id="khasiat_value">{{ isset($userPreference) && $userPreference ? round($userPreference->weight_khasiat * 100) : 30 }}</span>%
                                            </label> <input type="range" class="form-range" id="khasiat_weight"
                                                name="weights[khasiat]" min="0" max="100"
                                                value="{{ isset($userPreference) && $userPreference ? round($userPreference->weight_khasiat * 100) : 30 }}"
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
                                        <div class="mb-3"> <label for="harga_weight" class="form-label fw-bold">
                                                Bobot: <span
                                                    id="harga_value">{{ isset($userPreference) && $userPreference ? round($userPreference->weight_harga * 100) : 20 }}</span>%
                                            </label> <input type="range" class="form-range" id="harga_weight"
                                                name="weights[harga]" min="0" max="100"
                                                value="{{ isset($userPreference) && $userPreference ? round($userPreference->weight_harga * 100) : 20 }}"
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
                                        <div class="mb-3"> <label for="expired_weight" class="form-label fw-bold">
                                                Bobot: <span
                                                    id="expired_value">{{ isset($userPreference) && $userPreference ? round($userPreference->weight_expired * 100) : 25 }}</span>%
                                            </label> <input type="range" class="form-range" id="expired_weight"
                                                name="weights[expired]" min="0" max="100"
                                                value="{{ isset($userPreference) && $userPreference ? round($userPreference->weight_expired * 100) : 25 }}"
                                                oninput="updateValue('expired', this.value)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Filters -->
                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kategori" class="form-label fw-bold">Kategori Jamu</label> <select
                                        class="form-select" id="kategori" name="filters[category]">
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
                            </div> <!-- Actions -->
                            @auth
                                <div class="d-flex mt-4 gap-2">
                                    @if ($userPreference)
                                        <button type="button" class="btn btn-outline-primary" onclick="loadPreferences()">
                                            <i class="fas fa-cog me-2"></i>Gunakan Preferensi Saya
                                        </button>
                                    @endif
                                    <a href="{{ route('preferences.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-sliders-h me-2"></i>Atur Preferensi
                                    </a>
                                </div>
                            @endauth

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

        function loadPreferences() {
            @if (isset($userPreference) && $userPreference)
                const preferences = @json($userPreference);

                // Load weights
                document.getElementById('kandungan_weight').value = Math.round(preferences.weight_kandungan * 100);
                updateValue('kandungan', Math.round(preferences.weight_kandungan * 100));

                document.getElementById('khasiat_weight').value = Math.round(preferences.weight_khasiat * 100);
                updateValue('khasiat', Math.round(preferences.weight_khasiat * 100));

                document.getElementById('harga_weight').value = Math.round(preferences.weight_harga * 100);
                updateValue('harga', Math.round(preferences.weight_harga * 100));

                document.getElementById('expired_weight').value = Math.round(preferences.weight_expired * 100);
                updateValue('expired', Math.round(preferences.weight_expired * 100)); // Load filters if available
                if (preferences.preferred_categories && preferences.preferred_categories.length > 0) {
                    const categorySelect = document.getElementById('kategori');
                    categorySelect.value = preferences.preferred_categories[0];
                }

                if (preferences.max_price) {
                    const maxPriceSelect = document.getElementById('max_harga');
                    maxPriceSelect.value = preferences.max_price;
                }

                // Show success message
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Preferensi berhasil dimuat',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else if (typeof alert !== 'undefined') {
                    alert.success('Berhasil!', 'Preferensi berhasil dimuat');
                }
            @endif
        }

        // Auto-save preferences
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('smartForm');
            const ranges = form.querySelectorAll('input[type="range"]');

            @if (isset($repeatSearch) && $repeatSearch)
                // Load from repeat search data
                const repeatData = @json($repeatSearch);

                if (repeatData.criteria_weights) {
                    Object.keys(repeatData.criteria_weights).forEach(criteria => {
                        const weight = repeatData.criteria_weights[criteria];
                        const weightPercentage = Math.round(weight * 100);
                        const input = document.querySelector(`input[name="weights[${criteria}]"]`);

                        if (input) {
                            input.value = weightPercentage;
                            updateValue(criteria, weightPercentage);
                        }
                    });
                }

                // Load filters if any
                if (repeatData.filters_applied) {
                    Object.keys(repeatData.filters_applied).forEach(filter => {
                        const value = repeatData.filters_applied[filter];
                        const input = document.querySelector(
                            `input[name="filters[${filter}]"], select[name="filters[${filter}]"]`);

                        if (input) {
                            if (input.type === 'checkbox') {
                                input.checked = !!value;
                            } else {
                                input.value = value;
                            }
                        }
                    });
                }

                // Fill search query if available
                if (repeatData.search_query) {
                    const searchInput = document.querySelector('input[name="search_query"]');
                    if (searchInput) {
                        searchInput.value = repeatData.search_query;
                    }
                }

                // Show notification
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Parameter pencarian sebelumnya berhasil dimuat',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            @else
                // Normal behavior - load from localStorage
                ranges.forEach(range => {
                    range.addEventListener('change', function() {
                        // Save to localStorage for user preference
                        localStorage.setItem(this.name, this.value);
                    });

                    // Load from localStorage only if no user preferences
                    @if (!isset($userPreference) || !$userPreference)
                        const saved = localStorage.getItem(range.name);
                        if (saved) {
                            range.value = saved;
                            updateValue(range.name.replace('weights[', '').replace(']', ''), saved);
                        }
                    @endif
                });
            @endif

            // Always add event listeners for real-time updates
            ranges.forEach(range => {
                range.addEventListener('input', function() {
                    const criteria = this.name.replace('weights[', '').replace(']', '');
                    updateValue(criteria, this.value);
                });
            });
        });
    </script>
@endsection
