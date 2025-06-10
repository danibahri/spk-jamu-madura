@extends('layouts.app')

@section('title', 'Tambah Jamu - Admin')

@section('content')
    <div class="container-fluid my-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-gradient-success rounded-3 p-4 text-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Jamu Baru
                            </h2>
                            <p class="mb-0 opacity-75">Tambahkan produk jamu tradisional Madura ke database</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.jamu.index') }}" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card border-0 shadow-lg">
                    <div class="card-header border-0 bg-white py-4">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-edit text-success me-2"></i>
                            Form Jamu Baru
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm">
                                <h6 class="alert-heading mb-2">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan
                                </h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.jamu.store') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- Basic Information -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-8">
                                                    <label for="nama_jamu" class="form-label fw-semibold">
                                                        Nama Jamu <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="nama_jamu" name="nama_jamu" value="{{ old('nama_jamu') }}"
                                                        placeholder="Contoh: Jamu Sinom Asli" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="kategori" class="form-label fw-semibold">
                                                        Kategori <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select form-select-lg" id="kategori"
                                                        name="kategori" required>
                                                        <option value="">Pilih Kategori</option>
                                                        <option value="Kesehatan Wanita"
                                                            {{ old('kategori') == 'Kesehatan Wanita' ? 'selected' : '' }}>
                                                            Kesehatan Wanita</option>
                                                        <option value="Energi"
                                                            {{ old('kategori') == 'Energi' ? 'selected' : '' }}>Energi
                                                        </option>
                                                        <option value="Daya Tahan Tubuh"
                                                            {{ old('kategori') == 'Daya Tahan Tubuh' ? 'selected' : '' }}>
                                                            Daya Tahan Tubuh</option>
                                                        <option value="Anti Radang"
                                                            {{ old('kategori') == 'Anti Radang' ? 'selected' : '' }}>Anti
                                                            Radang</option>
                                                        <option value="Pencernaan"
                                                            {{ old('kategori') == 'Pencernaan' ? 'selected' : '' }}>
                                                            Pencernaan</option>
                                                        <option value="Detoksifikasi"
                                                            {{ old('kategori') == 'Detoksifikasi' ? 'selected' : '' }}>
                                                            Detoksifikasi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Composition & Benefits -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-leaf me-2"></i>Komposisi & Khasiat
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="kandungan" class="form-label fw-semibold">
                                                        Kandungan/Bahan <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control" id="kandungan" name="kandungan" rows="4"
                                                        placeholder="Contoh: Kunyit, Temulawak, Asam Jawa, Gula Aren..." required>{{ old('kandungan') }}</textarea>
                                                    <div class="form-text">Pisahkan dengan koma untuk setiap bahan</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="khasiat" class="form-label fw-semibold">
                                                        Khasiat/Manfaat <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control" id="khasiat" name="khasiat" rows="4"
                                                        placeholder="Contoh: Meningkatkan daya tahan tubuh, melancarkan pencernaan..." required>{{ old('khasiat') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price & Quality Ratings -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-star me-2"></i>Harga & Penilaian
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <label for="harga" class="form-label fw-semibold">
                                                        Harga (Rp) <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" class="form-control form-control-lg"
                                                        id="harga" name="harga" value="{{ old('harga') }}"
                                                        min="0" step="1000" placeholder="25000" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nilai_kandungan" class="form-label fw-semibold">
                                                        Nilai Kandungan <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select form-select-lg" id="nilai_kandungan"
                                                        name="nilai_kandungan" required>
                                                        <option value="">Pilih Nilai</option>
                                                        <option value="1"
                                                            {{ old('nilai_kandungan') == '1' ? 'selected' : '' }}>1 -
                                                            Sangat Rendah</option>
                                                        <option value="2"
                                                            {{ old('nilai_kandungan') == '2' ? 'selected' : '' }}>2 -
                                                            Rendah</option>
                                                        <option value="3"
                                                            {{ old('nilai_kandungan') == '3' ? 'selected' : '' }}>3 -
                                                            Sedang</option>
                                                        <option value="4"
                                                            {{ old('nilai_kandungan') == '4' ? 'selected' : '' }}>4 -
                                                            Tinggi</option>
                                                        <option value="5"
                                                            {{ old('nilai_kandungan') == '5' ? 'selected' : '' }}>5 -
                                                            Sangat Tinggi</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="nilai_khasiat" class="form-label fw-semibold">
                                                        Nilai Khasiat <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select form-select-lg" id="nilai_khasiat"
                                                        name="nilai_khasiat" required>
                                                        <option value="">Pilih Nilai</option>
                                                        <option value="1"
                                                            {{ old('nilai_khasiat') == '1' ? 'selected' : '' }}>1 - Sangat
                                                            Rendah</option>
                                                        <option value="2"
                                                            {{ old('nilai_khasiat') == '2' ? 'selected' : '' }}>2 - Rendah
                                                        </option>
                                                        <option value="3"
                                                            {{ old('nilai_khasiat') == '3' ? 'selected' : '' }}>3 - Sedang
                                                        </option>
                                                        <option value="4"
                                                            {{ old('nilai_khasiat') == '4' ? 'selected' : '' }}>4 - Tinggi
                                                        </option>
                                                        <option value="5"
                                                            {{ old('nilai_khasiat') == '5' ? 'selected' : '' }}>5 - Sangat
                                                            Tinggi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-info me-2"></i>Informasi Tambahan
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="deskripsi" class="form-label fw-semibold">
                                                        Deskripsi Produk
                                                    </label>
                                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                                                        placeholder="Deskripsi lengkap tentang jamu ini...">{{ old('deskripsi') }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cara_penggunaan" class="form-label fw-semibold">
                                                        Cara Penggunaan
                                                    </label>
                                                    <textarea class="form-control" id="cara_penggunaan" name="cara_penggunaan" rows="4"
                                                        placeholder="Contoh: Diminum 2x sehari setelah makan...">{{ old('cara_penggunaan') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Safety & Expiry -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-shield-alt me-2"></i>Keamanan & Masa Berlaku
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="efek_samping" class="form-label fw-semibold">
                                                        Efek Samping
                                                    </label>
                                                    <textarea class="form-control" id="efek_samping" name="efek_samping" rows="3"
                                                        placeholder="Contoh: Tidak boleh dikonsumsi ibu hamil...">{{ old('efek_samping') }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="expired_date" class="form-label fw-semibold">
                                                        Tanggal Kadaluarsa <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date" class="form-control form-control-lg"
                                                        id="expired_date" name="expired_date"
                                                        value="{{ old('expired_date') }}"
                                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                                    <div class="form-text">Harus lebih dari hari ini</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-5">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('admin.jamu.index') }}"
                                                class="btn btn-outline-secondary btn-lg">
                                                <i class="fas fa-times me-2"></i>Batal
                                            </a>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-save me-2"></i>Simpan Jamu
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .bg-gradient-success {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #28a745;
                box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            }

            .card {
                transition: transform 0.2s ease-in-out;
            }

            .card:hover {
                transform: translateY(-2px);
            }

            .form-label.fw-semibold {
                color: #495057;
                margin-bottom: 0.5rem;
            }

            .form-text {
                font-size: 0.875rem;
                color: #6c757d;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1.1rem;
            }

            #harga {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Format harga input
                const hargaInput = document.getElementById('harga');
                hargaInput.addEventListener('input', function() {
                    // Remove non-numeric characters
                    let value = this.value.replace(/[^0-9]/g, '');
                    this.value = value;
                });

                // Set minimum date for expired_date
                const expiredDateInput = document.getElementById('expired_date');
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                expiredDateInput.min = tomorrow.toISOString().split('T')[0];

                // Auto-resize textareas
                const textareas = document.querySelectorAll('textarea');
                textareas.forEach(textarea => {
                    textarea.addEventListener('input', function() {
                        this.style.height = 'auto';
                        this.style.height = this.scrollHeight + 'px';
                    });
                });

                // Form validation enhancement
                const form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let hasErrors = false;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            hasErrors = true;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });

                    if (hasErrors) {
                        e.preventDefault();
                        alert('Mohon lengkapi semua field yang wajib diisi!');
                        return false;
                    }

                    // Check expiry date
                    const expiredDate = new Date(expiredDateInput.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (expiredDate <= today) {
                        e.preventDefault();
                        alert('Tanggal kadaluarsa harus lebih dari hari ini!');
                        expiredDateInput.focus();
                        return false;
                    }

                    return true;
                });
            });
        </script>
    @endpush
@endsection
