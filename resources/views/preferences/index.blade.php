@extends('layouts.app')

@section('title', 'Preferensi Pengguna')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold text-success"><i class="fas fa-cog me-2"></i>Preferensi Pengguna</h2>
                <p class="text-muted">Kustomisasi kriteria pencarian dan bobot penilaian jamu sesuai kebutuhan Anda</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('preferences.store') }}" method="POST">
                    @csrf

                    <!-- Health Condition Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-heartbeat me-2"></i>Kondisi Kesehatan
                        </h5>
                        <div class="bg-light rounded p-3">
                            <div class="mb-3">
                                <label for="health_condition" class="form-label">Kondisi kesehatan yang ingin
                                    diatasi</label>
                                <input type="text" class="form-control" id="health_condition" name="health_condition"
                                    value="{{ old('health_condition', $preference->health_condition ?? '') }}"
                                    placeholder="Contoh: Diabetes, Hipertensi, Kolesterol tinggi">
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Akan membantu menemukan jamu dengan khasiat yang sesuai dengan kondisi kesehatan Anda
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-money-bill-wave me-2"></i>Kisaran Harga
                        </h5>
                        <div class="bg-light rounded p-3">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="min_price" class="form-label">Harga Minimum (Rp)</label>
                                    <input type="number" class="form-control" id="min_price" name="min_price"
                                        value="{{ old('min_price', $preference->min_price ?? '') }}" min="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="max_price" class="form-label">Harga Maksimum (Rp)</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price"
                                        value="{{ old('max_price', $preference->max_price ?? '') }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Preferences -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-tags me-2"></i>Kategori yang Disukai
                        </h5>
                        <div class="bg-light rounded p-3">
                            <div class="row">
                                @foreach ($categories as $category)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferred_categories[]"
                                                value="{{ $category }}" id="category_{{ $loop->index }}"
                                                {{ old('preferred_categories', $preference->preferred_categories ?? []) &&
                                                in_array($category, old('preferred_categories', $preference->preferred_categories ?? []))
                                                    ? 'checked'
                                                    : '' }}>
                                            <label class="form-check-label" for="category_{{ $loop->index }}">
                                                {{ $category }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Allergic Ingredients -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-ban me-2"></i>Kandungan yang Dihindari
                        </h5>
                        <div class="bg-light rounded p-3">
                            <div class="row">
                                @foreach ($kandunganList as $kandungan)
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="allergic_ingredients[]"
                                                value="{{ $kandungan }}" id="kandungan_{{ $loop->index }}"
                                                {{ old('allergic_ingredients', $preference->allergic_ingredients ?? []) &&
                                                in_array($kandungan, old('allergic_ingredients', $preference->allergic_ingredients ?? []))
                                                    ? 'checked'
                                                    : '' }}>
                                            <label class="form-check-label" for="kandungan_{{ $loop->index }}">
                                                {{ $kandungan }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Weights Section -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-success mb-3">
                            <i class="fas fa-balance-scale me-2"></i>Bobot Kriteria
                        </h5>
                        <div class="bg-light rounded p-3">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Atur prioritas setiap kriteria sesuai kebutuhan Anda. Sistem akan menormalisasi secara
                                otomatis
                                sehingga total proporsi selalu seimbang.
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label for="weight_kandungan" class="form-label">
                                        Bobot Kandungan: <span
                                            id="kandungan_display">{{ isset($preference) && $preference ? round($preference->weight_kandungan * 100) : 25 }}</span>%
                                    </label>
                                    <input type="range" class="form-range weight-input" id="weight_kandungan"
                                        name="weight_kandungan" min="0" max="100"
                                        value="{{ isset($preference) && $preference ? round($preference->weight_kandungan * 100) : 25 }}"
                                        oninput="updateWeightDisplay('kandungan', this.value)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight_khasiat" class="form-label">
                                        Bobot Khasiat: <span
                                            id="khasiat_display">{{ isset($preference) && $preference ? round($preference->weight_khasiat * 100) : 25 }}</span>%
                                    </label>
                                    <input type="range" class="form-range weight-input" id="weight_khasiat"
                                        name="weight_khasiat" min="0" max="100"
                                        value="{{ isset($preference) && $preference ? round($preference->weight_khasiat * 100) : 25 }}"
                                        oninput="updateWeightDisplay('khasiat', this.value)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight_harga" class="form-label">
                                        Bobot Harga: <span
                                            id="harga_display">{{ isset($preference) && $preference ? round($preference->weight_harga * 100) : 25 }}</span>%
                                    </label>
                                    <input type="range" class="form-range weight-input" id="weight_harga"
                                        name="weight_harga" min="0" max="100"
                                        value="{{ isset($preference) && $preference ? round($preference->weight_harga * 100) : 25 }}"
                                        oninput="updateWeightDisplay('harga', this.value)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight_expired" class="form-label">
                                        Bobot Kadaluarsa: <span
                                            id="expired_display">{{ isset($preference) && $preference ? round($preference->weight_expired * 100) : 25 }}</span>%
                                    </label>
                                    <input type="range" class="form-range weight-input" id="weight_expired"
                                        name="weight_expired" min="0" max="100"
                                        value="{{ isset($preference) && $preference ? round($preference->weight_expired * 100) : 25 }}"
                                        oninput="updateWeightDisplay('expired', this.value)">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between rounded border bg-white p-3">
                                <div>
                                    <strong>Total Input:</strong>
                                    <span id="total-weight" class="fw-bold fs-5 ms-2">100</span>%
                                </div>
                                <div>
                                    <span class="badge bg-info">
                                        <i class="fas fa-info-circle me-1"></i>Sistem Auto-Normalisasi
                                    </span>
                                </div>
                            </div>

                            @if ($errors->has('weights'))
                                <div class="text-danger mt-2">
                                    {{ $errors->first('weights') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('jamu.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-1"></i>Simpan Preferensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function updateWeightDisplay(criteria, value) {
            document.getElementById(criteria + '_display').textContent = value;
            updateTotalWeight();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const weightInputs = document.querySelectorAll('.weight-input');
            const totalWeightSpan = document.getElementById('total-weight');

            function updateTotalWeight() {
                let total = 0;
                weightInputs.forEach(input => {
                    total += parseInt(input.value) || 0;
                });

                totalWeightSpan.textContent = total;

                // Update color based on total
                if (total === 0) {
                    totalWeightSpan.className = 'fw-bold fs-5 ms-2 text-muted';
                } else {
                    totalWeightSpan.className = 'fw-bold fs-5 ms-2 text-primary';
                }
            }

            weightInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const criteria = this.name.replace('weight_', '');
                    updateWeightDisplay(criteria, this.value);
                });
            });

            // Initial update
            updateTotalWeight();
        });
    </script>
@endsection
