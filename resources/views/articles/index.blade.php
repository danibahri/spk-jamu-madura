@extends('layouts.app')

@section('title', 'Artikel Herbal - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h2 class="display-5 fw-bold text-success mb-3">
                    <i class="fas fa-book-open me-3"></i>
                    Artikel & Edukasi Herbal
                </h2>
                <p class="lead text-muted">
                    Pelajari lebih dalam tentang jamu tradisional Madura dan manfaatnya untuk kesehatan
                </p>
            </div>
            <div class="col-md-4 text-end">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchArticles" placeholder="Cari artikel...">
                    <button class="btn btn-success" type="button" onclick="searchArticles()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Categories Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-wrap gap-2">
                            <span class="fw-bold text-muted me-3">Kategori:</span>
                            <a href="{{ route('articles.index') }}"
                                class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-success' }}">
                                Semua
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('articles.index', ['category' => $category]) }}"
                                    class="btn btn-sm {{ request('category') == $category ? 'btn-success' : 'btn-outline-success' }}">
                                    {{ $category }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Featured Article -->
                @if ($featuredArticle && !request('category') && !request('search'))
                    <div class="card mb-5 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="badge bg-warning text-dark mb-3">
                                        <i class="fas fa-star me-1"></i>
                                        Artikel Pilihan
                                    </div>
                                    <h3 class="card-title fw-bold text-success mb-3">
                                        <a href="{{ route('articles.show', $featuredArticle->slug) }}"
                                            class="text-decoration-none">
                                            {{ $featuredArticle->title }}
                                        </a>
                                    </h3>
                                    <p class="card-text text-muted mb-3">
                                        {{ $featuredArticle->excerpt }}
                                    </p>
                                    <div class="d-flex align-items-center text-muted mb-3">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <span class="me-3">{{ $featuredArticle->created_at->format('d M Y') }}</span>
                                        <i class="fas fa-tag me-2"></i>
                                        <span class="me-3">{{ $featuredArticle->category }}</span>
                                        <i class="fas fa-clock me-2"></i>
                                        <span>{{ $featuredArticle->read_time ?? '5' }} menit baca</span>
                                    </div>
                                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="btn btn-success">
                                        Baca Selengkapnya
                                        <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    @if ($featuredArticle->image)
                                        <img src="{{ $featuredArticle->image }}" class="img-fluid rounded"
                                            alt="{{ $featuredArticle->title }}">
                                    @else
                                        <div class="bg-success d-flex align-items-center justify-content-center rounded text-white"
                                            style="height: 200px;">
                                            <i class="fas fa-leaf fa-3x opacity-75"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Articles List -->
                <div class="row">
                    @forelse($articles as $article)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 article-card border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <span
                                            class="badge bg-{{ $article->category == 'Pengetahuan Umum' ? 'primary' : ($article->category == 'Tips Kesehatan' ? 'success' : 'info') }}">
                                            {{ $article->category }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $article->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    <h5 class="card-title fw-bold mb-3">
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="text-decoration-none text-dark">
                                            {{ $article->title }}
                                        </a>
                                    </h5>

                                    <p class="card-text text-muted mb-3">
                                        {{ Str::limit($article->excerpt, 120) }}
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted small">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $article->read_time ?? '5' }} menit baca
                                        </div>
                                        <a href="{{ route('articles.show', $article->slug) }}"
                                            class="btn btn-outline-success btn-sm">
                                            Baca <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="py-5 text-center">
                                <i class="fas fa-newspaper text-muted" style="font-size: 4rem;"></i>
                                <h4 class="text-muted mt-3">Tidak Ada Artikel</h4>
                                <p class="text-muted">
                                    @if (request('category'))
                                        Tidak ada artikel dalam kategori "{{ request('category') }}"
                                    @elseif(request('search'))
                                        Tidak ada artikel yang cocok dengan pencarian "{{ request('search') }}"
                                    @else
                                        Belum ada artikel yang tersedia
                                    @endif
                                </p>
                                @if (request('category') || request('search'))
                                    <a href="{{ route('articles.index') }}" class="btn btn-success">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Lihat Semua Artikel
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($articles->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $articles->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Popular Articles -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-fire me-2"></i>
                            Artikel Populer
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($popularArticles->count() > 0)
                            @foreach ($popularArticles as $index => $popular)
                                <div
                                    class="d-flex {{ $index < $popularArticles->count() - 1 ? 'pb-3 border-bottom' : '' }} mb-3">
                                    <div class="me-3 flex-shrink-0">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white"
                                            style="width: 30px; height: 30px; font-size: 0.9rem;">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('articles.show', $popular->slug) }}"
                                                class="text-decoration-none">
                                                {{ Str::limit($popular->title, 60) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>
                                            {{ $popular->views ?? rand(100, 1000) }} views
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada artikel populer</p>
                        @endif
                    </div>
                </div>

                <!-- Categories -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tags me-2"></i>
                            Kategori
                        </h5>
                    </div>                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            @if(!empty($categoriesWithCount))
                                @foreach ($categoriesWithCount as $category => $count)
                                    <a href="{{ route('articles.index', ['category' => $category]) }}"
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0">
                                        <span>{{ $category }}</span>
                                        <span class="badge bg-success rounded-pill">{{ $count }}</span>
                                    </a>
                                @endforeach
                            @else
                                <p class="text-muted text-center">Belum ada kategori</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Newsletter Signup -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-envelope me-2"></i>
                            Newsletter
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-3">
                            Dapatkan artikel terbaru tentang jamu dan kesehatan herbal langsung di email Anda!
                        </p>
                        <form id="newsletterForm">
                            @csrf
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email Anda"
                                    required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Berlangganan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('smart.index') }}" class="btn btn-success">
                                <i class="fas fa-calculator me-2"></i>
                                Cari Jamu Terbaik
                            </a>
                            <a href="{{ route('jamu.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-leaf me-2"></i>
                                Jelajahi Jamu
                            </a>
                            @auth
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-tachometer-alt me-2"></i>
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Masuk
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .article-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .badge {
            font-size: 0.75rem;
        }

        @media (max-width: 768px) {
            .display-5 {
                font-size: 2rem;
            }
        }
    </style>

    <script>
        function searchArticles() {
            const searchTerm = document.getElementById('searchArticles').value;
            if (searchTerm.trim()) {
                window.location.href = `{{ route('articles.index') }}?search=${encodeURIComponent(searchTerm)}`;
            }
        }

        // Search on Enter
        document.getElementById('searchArticles').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchArticles();
            }
        });

        // Newsletter form
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('/newsletter/subscribe', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Berhasil berlangganan newsletter!');
                        this.reset();
                    } else {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
        });

        // Auto-focus search if there's a search parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const searchTerm = urlParams.get('search');
            if (searchTerm) {
                document.getElementById('searchArticles').value = searchTerm;
            }
        });
    </script>
@endsection
