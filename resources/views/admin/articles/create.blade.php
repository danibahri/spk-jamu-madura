@extends('layouts.app')

@section('title', 'Tambah Artikel - Admin')

@section('content')
    <div class="container-fluid my-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-gradient-success rounded-3 p-4 text-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Artikel Baru
                            </h2>
                            <p class="mb-0 opacity-75">Buat artikel edukasi tentang jamu dan kesehatan herbal</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-light btn-sm shadow-sm">
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
                            Form Artikel Baru
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

                        <form action="{{ route('admin.articles.store') }}" method="POST" id="articleForm">
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
                                                    <label for="title" class="form-label fw-semibold">
                                                        Judul Artikel <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control form-control-lg"
                                                        id="title" name="title" value="{{ old('title') }}"
                                                        placeholder="Masukkan judul artikel yang menarik..." required>
                                                    <div class="form-text">Judul yang baik akan menarik pembaca untuk
                                                        membaca artikel</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="category" class="form-label fw-semibold">
                                                        Kategori <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-select form-select-lg" id="category"
                                                        name="category" required>
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category }}"
                                                                {{ old('category') == $category ? 'selected' : '' }}>
                                                                {{ $category }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Excerpt -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-align-left me-2"></i>Ringkasan Artikel
                                            </h6>
                                            <label for="excerpt" class="form-label fw-semibold">
                                                Excerpt/Ringkasan <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="excerpt" name="excerpt" rows="3"
                                                placeholder="Tulis ringkasan singkat artikel untuk menarik perhatian pembaca..." required>{{ old('excerpt') }}</textarea>
                                            <div class="form-text">Maksimal 500 karakter. Ini akan ditampilkan di halaman
                                                daftar artikel.</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-file-alt me-2"></i>Konten Artikel
                                            </h6>
                                            <label for="content" class="form-label fw-semibold">
                                                Isi Artikel <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control" id="content" name="content" rows="15"
                                                placeholder="Tulis konten artikel yang informatif dan berkualitas..." required>{{ old('content') }}</textarea>
                                            <div class="form-text">
                                                Tulis konten yang berkualitas dan informatif. Gunakan paragraf yang jelas
                                                dan mudah dibaca.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Media -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-image me-2"></i>Media & Gambar
                                            </h6>
                                            <label for="featured_image" class="form-label fw-semibold">
                                                URL Gambar Utama
                                            </label>
                                            <input type="url" class="form-control" id="featured_image"
                                                name="featured_image" value="{{ old('featured_image') }}"
                                                placeholder="https://example.com/gambar-artikel.jpg">
                                            <div class="form-text">
                                                Masukkan URL gambar yang akan dijadikan featured image artikel (opsional).
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Publishing Options -->
                                <div class="col-12">
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-primary mb-3">
                                                <i class="fas fa-cog me-2"></i>Pengaturan Publikasi
                                            </h6>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_published"
                                                    value="1" {{ old('is_published') ? 'checked' : '' }}
                                                    name="is_published">
                                                <label class="form-check-label fw-semibold" for="is_published">
                                                    Publikasikan Artikel
                                                </label>
                                                <div class="form-text">
                                                    Centang untuk langsung mempublikasikan artikel. Jika tidak dicentang,
                                                    artikel akan disimpan sebagai draft.
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
                                            <a href="{{ route('admin.articles.index') }}"
                                                class="btn btn-outline-secondary btn-lg">
                                                <i class="fas fa-times me-2"></i>Batal
                                            </a>
                                        </div>
                                        <div class="d-flex gap-3">
                                            <button type="submit" class="btn btn-outline-primary btn-lg" name="draft"
                                                value="1">
                                                <i class="fas fa-save me-2"></i>Simpan sebagai Draft
                                            </button>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-paper-plane me-2"></i>Simpan & Publikasikan
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

            .form-check-input:checked {
                background-color: #28a745;
                border-color: #28a745;
            }

            #content {
                min-height: 300px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1.1rem;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Character counter for excerpt
                const excerptField = document.getElementById('excerpt');
                const maxLength = 500;

                function updateCounter() {
                    const currentLength = excerptField.value.length;
                    const remaining = maxLength - currentLength;

                    let counterElement = document.getElementById('excerpt-counter');
                    if (!counterElement) {
                        counterElement = document.createElement('small');
                        counterElement.id = 'excerpt-counter';
                        counterElement.className = 'form-text';
                        excerptField.parentNode.appendChild(counterElement);
                    }

                    counterElement.textContent = `${currentLength}/${maxLength} karakter`;
                    counterElement.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
                }

                excerptField.addEventListener('input', updateCounter);
                updateCounter();

                // Auto-save functionality (optional enhancement)
                let autoSaveInterval;
                const formData = new FormData();

                function autoSave() {
                    // Simple auto-save to localStorage
                    const articleData = {
                        title: document.getElementById('title').value,
                        category: document.getElementById('category').value,
                        excerpt: document.getElementById('excerpt').value,
                        content: document.getElementById('content').value,
                        featured_image: document.getElementById('featured_image').value,
                        timestamp: new Date().toISOString()
                    };

                    localStorage.setItem('article_draft', JSON.stringify(articleData));
                }

                // Auto-save every 30 seconds
                setInterval(autoSave, 30000);

                // Restore draft on page load
                const savedDraft = localStorage.getItem('article_draft');
                if (savedDraft && confirm('Ditemukan draft artikel yang belum disimpan. Apakah ingin memulihkannya?')) {
                    const draftData = JSON.parse(savedDraft);
                    document.getElementById('title').value = draftData.title || '';
                    document.getElementById('category').value = draftData.category || '';
                    document.getElementById('excerpt').value = draftData.excerpt || '';
                    document.getElementById('content').value = draftData.content || '';
                    document.getElementById('featured_image').value = draftData.featured_image || '';
                    updateCounter();
                }

                // Clear draft when form is submitted
                document.getElementById('articleForm').addEventListener('submit', function() {
                    localStorage.removeItem('article_draft');
                });

                // Draft button functionality
                document.querySelector('button[name="draft"]').addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('is_published').checked = false;
                    document.getElementById('articleForm').submit();
                });
            });
        </script>
    @endpush
@endsection
