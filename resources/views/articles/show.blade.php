@extends('layouts.app')

@section('title', $article->title . ' - SPK Jamu Madura')

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('articles.index') }}" class="text-success">Artikel</a></li>
                <li class="breadcrumb-item"><a href="{{ route('articles.index', ['category' => $article->category]) }}"
                        class="text-success">{{ $article->category }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 50) }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Article Header -->
                <div class="article-header mb-5">
                    <div class="mb-3">
                        <span
                            class="badge bg-{{ $article->category == 'Pengetahuan Umum' ? 'primary' : ($article->category == 'Tips Kesehatan' ? 'success' : 'info') }} fs-6">
                            {{ $article->category }}
                        </span>
                    </div>

                    <h1 class="display-5 fw-bold text-dark mb-4">
                        {{ $article->title }}
                    </h1>

                    <div class="article-meta mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center text-muted">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <span class="me-4">{{ $article->created_at->format('d F Y') }}</span>

                                    <i class="fas fa-clock me-2"></i>
                                    <span class="me-4">{{ $article->read_time ?? '5' }} menit baca</span>

                                    <i class="fas fa-eye me-2"></i>
                                    <span>{{ $article->views ?? rand(100, 1000) }} views</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="share-buttons">
                                    <button class="btn btn-outline-primary btn-sm me-2" onclick="shareArticle('facebook')">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <button class="btn btn-outline-info btn-sm me-2" onclick="shareArticle('twitter')">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="shareArticle('whatsapp')">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($article->excerpt)
                        <div class="alert alert-info border-0">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>
                                Ringkasan
                            </h5>
                            <p class="mb-0">{{ $article->excerpt }}</p>
                        </div>
                    @endif
                </div>

                <!-- Article Image -->
                @if ($article->image)
                    <div class="article-image mb-5">
                        <img src="{{ $article->image }}" class="img-fluid rounded shadow" alt="{{ $article->title }}"
                            style="width: 100%; height: 400px; object-fit: cover;">
                    </div>
                @endif

                <!-- Article Content -->
                <div class="article-content">
                    <div class="content-body">
                        {!! nl2br(e($article->content)) !!}
                    </div>
                </div>

                <!-- Tags (if any) -->
                @if ($article->tags)
                    <div class="article-tags border-top mt-5 pt-4">
                        <h5 class="mb-3">
                            <i class="fas fa-tags me-2"></i>
                            Tags
                        </h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (explode(',', $article->tags) as $tag)
                                <span class="badge bg-light text-dark border">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Article Actions -->
                <div class="article-actions border-top mt-5 pt-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-3">Bagikan Artikel Ini</h5>
                            <div class="share-buttons-large">
                                <a href="javascript:void(0)" onclick="shareArticle('facebook')"
                                    class="btn btn-primary mb-2 me-2">
                                    <i class="fab fa-facebook-f me-2"></i>Facebook
                                </a>
                                <a href="javascript:void(0)" onclick="shareArticle('twitter')"
                                    class="btn btn-info mb-2 me-2">
                                    <i class="fab fa-twitter me-2"></i>Twitter
                                </a>
                                <a href="javascript:void(0)" onclick="shareArticle('whatsapp')"
                                    class="btn btn-success mb-2 me-2">
                                    <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                </a>
                                <button onclick="copyLink()" class="btn btn-outline-secondary mb-2">
                                    <i class="fas fa-link me-2"></i>Salin Link
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5 class="mb-3">Aksi Cepat</h5>
                            <div class="quick-actions">
                                <a href="{{ route('smart.index') }}" class="btn btn-success mb-2 me-2">
                                    <i class="fas fa-calculator me-2"></i>Cari Jamu
                                </a>
                                <a href="{{ route('jamu.index') }}" class="btn btn-outline-success mb-2">
                                    <i class="fas fa-leaf me-2"></i>Jelajahi Jamu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Articles -->
                @if ($relatedArticles->count() > 0)
                    <div class="related-articles mt-5 pt-4">
                        <h3 class="mb-4">
                            <i class="fas fa-newspaper me-2"></i>
                            Artikel Terkait
                        </h3>
                        <div class="row">
                            @foreach ($relatedArticles as $related)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-secondary">{{ $related->category }}</span>
                                                <small
                                                    class="text-muted">{{ $related->created_at->diffForHumans() }}</small>
                                            </div>

                                            <h5 class="card-title">
                                                <a href="{{ route('articles.show', $related->slug) }}"
                                                    class="text-decoration-none">
                                                    {{ $related->title }}
                                                </a>
                                            </h5>

                                            <p class="card-text text-muted">
                                                {{ Str::limit($related->excerpt, 100) }}
                                            </p>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ $related->read_time ?? '5' }} menit
                                                </small>
                                                <a href="{{ route('articles.show', $related->slug) }}"
                                                    class="btn btn-outline-success btn-sm">
                                                    Baca
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Table of Contents (if content is long) -->
                @if (strlen($article->content) > 1000)
                    <div class="card sticky-top mb-4 border-0 shadow-sm" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>
                                Daftar Isi
                            </h5>
                        </div>
                        <div class="card-body">
                            <div id="tableOfContents">
                                <!-- Will be populated by JavaScript -->
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Popular Articles -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-fire me-2"></i>
                            Artikel Populer
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($popularArticles->count() > 0)
                            @foreach ($popularArticles->take(5) as $index => $popular)
                                <div class="d-flex {{ $index < 4 ? 'pb-3 border-bottom' : '' }} mb-3">
                                    <div class="me-3 flex-shrink-0">
                                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white"
                                            style="width: 30px; height: 30px; font-size: 0.9rem;">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('articles.show', $popular->slug) }}"
                                                class="text-decoration-none">
                                                {{ Str::limit($popular->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            {{ $popular->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada artikel populer</p>
                        @endif
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-envelope me-2"></i>
                            Newsletter
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-3">
                            Dapatkan artikel terbaru tentang jamu dan kesehatan herbal!
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

                <!-- Category Articles -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-folder me-2"></i>
                            Artikel {{ $article->category }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($categoryArticles->count() > 0)
                            @foreach ($categoryArticles->take(5) as $categoryArticle)
                                <div class="{{ !$loop->last ? 'pb-3 border-bottom' : '' }} mb-3">
                                    <h6 class="mb-1">
                                        <a href="{{ route('articles.show', $categoryArticle->slug) }}"
                                            class="text-decoration-none">
                                            {{ Str::limit($categoryArticle->title, 60) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $categoryArticle->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            @endforeach

                            <div class="mt-3 text-center">
                                <a href="{{ route('articles.index', ['category' => $article->category]) }}"
                                    class="btn btn-outline-secondary btn-sm">
                                    Lihat Semua
                                </a>
                            </div>
                        @else
                            <p class="text-muted text-center">Belum ada artikel lain</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .share-buttons button {
            border-radius: 50px;
        }

        .share-buttons-large a,
        .share-buttons-large button {
            border-radius: 25px;
        }

        .article-meta {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .share-buttons {
                margin-top: 1rem;
            }

            .article-actions .text-end {
                text-align: start !important;
                margin-top: 2rem;
            }
        }
    </style>

    <script>
        // Share functionality
        function shareArticle(platform) {
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $article->title }}');
            const text = encodeURIComponent('{{ Str::limit($article->excerpt, 100) }}');

            let shareUrl = '';

            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${title} ${url}`;
                    break;
            }

            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                showNotification('Link berhasil disalin!', 'success');
            }, function(err) {
                console.error('Error copying link: ', err);
            });
        }

        // Generate table of contents
        document.addEventListener('DOMContentLoaded', function() {
            const content = document.querySelector('.content-body');
            const toc = document.getElementById('tableOfContents');

            if (content && toc) {
                const headings = content.querySelectorAll('h1, h2, h3, h4, h5, h6');

                if (headings.length > 0) {
                    const tocList = document.createElement('ul');
                    tocList.className = 'list-unstyled';

                    headings.forEach((heading, index) => {
                        // Add ID to heading if it doesn't have one
                        if (!heading.id) {
                            heading.id = `heading-${index}`;
                        }

                        const listItem = document.createElement('li');
                        listItem.className = 'mb-2';

                        const link = document.createElement('a');
                        link.href = `#${heading.id}`;
                        link.textContent = heading.textContent;
                        link.className = 'text-decoration-none';

                        listItem.appendChild(link);
                        tocList.appendChild(listItem);
                    });

                    toc.appendChild(tocList);
                } else {
                    toc.innerHTML = '<p class="text-muted text-center">Tidak ada heading ditemukan</p>';
                }
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
                        showNotification('Berhasil berlangganan newsletter!', 'success');
                        this.reset();
                    } else {
                        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
                });
        });

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} notification-toast`;
            notification.textContent = message;
            notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease;
    `;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endsection
