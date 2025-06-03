@extends('layouts.app')

@section('title', 'Jamu Favorit Saya')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="fw-bold text-success mb-2">
                    <i class="fas fa-heart me-2"></i>Jamu Favorit Saya
                </h1>
                <p class="text-muted">Koleksi jamu tradisional yang telah Anda simpan sebagai favorit</p>
            </div>
            @if ($favorites && $favorites->count() > 0)
                <span class="badge bg-success fs-5 px-3 py-2">{{ $favorites->total() }} Item</span>
            @endif
        </div>

        @if ($favorites && $favorites->count() > 0)
            <div class="row g-4">
                @foreach ($favorites as $favorite)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 jamu-card border-0 shadow-sm">
                            <!-- Image Section -->
                            <div class="position-relative rounded-top overflow-hidden">
                                <div class="jamu-image-placeholder bg-gradient bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="fas fa-leaf fa-3x text-success opacity-50"></i>
                                </div>
                                <!-- Remove Favorite Button - Positioned on Image -->
                                <div class="position-absolute end-0 top-0 p-2">
                                    <form class="delete-favorite-form d-inline" data-jamu-id="{{ $favorite->jamu->id }}"
                                        action="{{ route('favorites.destroy', $favorite->jamu->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-light rounded-circle border-0 bg-white shadow-sm"
                                            style="width: 35px; height: 35px;" title="Hapus dari favorit">
                                            <i class="fas fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column p-4">
                                <!-- Title and Category -->
                                <div class="mb-3">
                                    <h5 class="card-title text-success fw-bold mb-2 line-clamp-2">
                                        {{ $favorite->jamu->nama_jamu }}
                                    </h5>
                                    <span class="badge bg-secondary rounded-pill">{{ $favorite->jamu->kategori }}</span>
                                </div>

                                <!-- Content Details -->
                                <div class="flex-grow-1 mb-3">
                                    <!-- Kandungan -->
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-seedling text-success me-2 mt-1 flex-shrink-0"></i>
                                            <div class="flex-grow-1">
                                                <strong class="text-dark">Kandungan:</strong>
                                                <p class="text-muted small mb-0 line-clamp-2">
                                                    {{ $favorite->jamu->kandungan }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Khasiat -->
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-medkit text-success me-2 mt-1 flex-shrink-0"></i>
                                            <div class="flex-grow-1">
                                                <strong class="text-dark">Khasiat:</strong>
                                                <p class="text-muted small mb-0 line-clamp-2">
                                                    {{ $favorite->jamu->khasiat }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="price-section">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-tag text-success me-2"></i>
                                            <span class="fw-bold text-success fs-6">
                                                Rp {{ number_format($favorite->jamu->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Section -->
                                <div class="card-footer-custom border-top pt-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Time Added -->
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $favorite->created_at->diffForHumans() }}
                                        </small>

                                        <!-- Action Buttons -->
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('jamu.show', $favorite->jamu->id) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                            <button class="btn btn-sm btn-success favorite-toggle-btn"
                                                data-jamu-id="{{ $favorite->jamu->id }}" title="Favorit">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($favorites->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-lg">
                            {{-- Previous Page Link --}}
                            @if ($favorites->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">&laquo;</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $favorites->previousPageUrl() }}"
                                        rel="prev">&laquo;</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @for ($i = 1; $i <= $favorites->lastPage(); $i++)
                                <li class="page-item {{ $favorites->currentPage() == $i ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $favorites->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor

                            {{-- Next Page Link --}}
                            @if ($favorites->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $favorites->nextPageUrl() }}" rel="next">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">&raquo;</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="empty-state py-5">
                        <div class="mb-4">
                            <i class="fas fa-heart fa-4x text-muted opacity-50"></i>
                        </div>
                        <h3 class="text-muted mb-3">Belum ada jamu favorit</h3>
                        <p class="text-muted mb-4">Mulai jelajahi koleksi jamu kami dan simpan yang Anda sukai!</p>
                        <a href="{{ route('jamu.index') }}" class="btn btn-success btn-lg px-4">
                            <i class="fas fa-leaf me-2"></i>Jelajahi Jamu
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Custom CSS untuk memperbaiki tampilan */
        .jamu-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .jamu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer-custom {
            background: transparent;
            border-top: 1px solid #e9ecef !important;
            margin-top: auto;
        }

        .price-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .btn-group .btn {
            border-radius: 0.375rem !important;
        }

        .btn-group .btn:not(:last-child) {
            margin-right: 0.25rem;
        }

        .pagination-lg .page-link {
            padding: 0.75rem 1rem;
        }

        .empty-state i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.5;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                opacity: 0.5;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem !important;
            }

            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                margin-right: 0 !important;
                margin-bottom: 0.25rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
@endsection
