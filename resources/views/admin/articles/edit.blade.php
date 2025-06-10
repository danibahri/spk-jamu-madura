@extends('layouts.app')

@section('title', 'Edit Artikel - Admin')

@section('content')
    <div class="container-fluid my-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-gradient-warning rounded-3 text-dark p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-edit me-2"></i>Edit Artikel
                            </h2>
                            <p class="mb-0 opacity-75">Perbarui konten artikel: {{ $article->title }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-dark btn-sm shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            @if ($article->is_published)
                                <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-info btn-sm shadow-sm"
                                    target="_blank">
                                    <i class="fas fa-eye me-2"></i>Lihat Artikel
                                </a>
                            @endif
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">
                                <i class="fas fa-edit text-warning me-2"></i>
                                Form Edit Artikel
                            </h5>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-{{ $article->is_published ? 'success' : 'warning' }} fs-6">
                                    {{ $article->is_published ? 'Published' : 'Draft' }}
                                </span>
                                @if ($article->published_at)
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        Dipublikasi: {{ $article->published_at->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>
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

                        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" id="articleForm">
                            @csrf
                            @method('PUT')

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
                                                        id="title" name="title"
                                                        value="{{ old('title', $article->title) }}"
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
                                                                {{ old('category', $article->category) == $category ? 'selected' : '' }}>
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
                                                placeholder="Tulis ringkasan singkat artikel untuk menarik perhatian pembaca..." required>{{ old('excerpt', $article->excerpt) }}</textarea>
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
                                                placeholder="Tulis konten artikel yang informatif dan berkualitas..." required>{{ old('content', $article->content) }}</textarea>
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
                                                name="featured_image"
                                                value="{{ old('featured_image', $article->featured_image) }}"
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
                                                    name="is_published" value="1"
                                                    {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="is_published">
                                                    Publikasikan Artikel
                                                </label>
                                                <div class="form-text">
                                                    Centang untuk mempublikasikan artikel. Jika tidak dicentang, artikel
                                                    akan disimpan sebagai draft.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Article Info -->
                                <div class="col-12">
                                    <div class="card border-info">
                                        <div class="card-body">
                                            <h6 class="card-title fw-bold text-info mb-3">
                                                <i class="fas fa-info-circle me-2"></i>Informasi Artikel
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="text-muted small">
                                                        <i class="fas fa-plus me-2"></i>Dibuat
                                                    </div>
                                                    <div class="fw-semibold">
                                                        {{ $article->created_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted small">
                                                        <i class="fas fa-edit me-2"></i>Terakhir diubah
                                                    </div>
                                                    <div class="fw-semibold">
                                                        {{ $article->updated_at->format('d/m/Y H:i') }}</div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-muted small">
                                                        <i class="fas fa-user me-2"></i>Penulis
                                                    </div>
                                                    <div class="fw-semibold">{{ $article->author->name }}</div>
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
                                            <button type="submit" class="btn btn-warning btn-lg text-white">
                                                <i class="fas fa-check me-2"></i>Update Artikel
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
            .bg-gradient-warning {
                background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: #ffc107;
                box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
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
                background-color: #ffc107;
                border-color: #ffc107;
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

            .border-info {
                border-color: #17a2b8 !important;
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

                // Draft button functionality
                document.querySelector('button[name="draft"]').addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('is_published').checked = false;
                    document.getElementById('articleForm').submit();
                });

                // Confirmation for major changes
                const originalPublishedState = {{ $article->is_published ? 'true' : 'false' }};
                document.getElementById('articleForm').addEventListener('submit', function(e) {
                    const currentPublishedState = document.getElementById('is_published').checked;

                    if (originalPublishedState && !currentPublishedState) {
                        if (!confirm(
                                'Anda akan mengubah status artikel dari "Published" menjadi "Draft". Artikel tidak akan terlihat oleh pembaca. Lanjutkan?'
                            )) {
                            e.preventDefault();
                            return false;
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
