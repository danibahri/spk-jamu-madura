@extends('layouts.app')

@section('title', 'Manajemen Artikel - Admin')

@section('content')
    <div class="container-fluid my-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-gradient-info rounded-3 p-4 text-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-newspaper me-2"></i>Manajemen Artikel
                            </h2>
                            <p class="mb-0 opacity-75">Kelola artikel dan konten edukasi dengan mudah</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('admin.articles.create') }}" class="btn btn-success btn-sm shadow-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Artikel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info me-3 bg-opacity-10 p-3">
                                <i class="fas fa-newspaper text-info fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $articles->total() }}</h5>
                                <p class="text-muted small mb-0">Total Artikel</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success me-3 bg-opacity-10 p-3">
                                <i class="fas fa-check-circle text-success fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $articles->where('is_published', true)->count() }}</h5>
                                <p class="text-muted small mb-0">Artikel Published</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning me-3 bg-opacity-10 p-3">
                                <i class="fas fa-edit text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $articles->where('is_published', false)->count() }}</h5>
                                <p class="text-muted small mb-0">Draft</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary me-3 bg-opacity-10 p-3">
                                <i class="fas fa-tags text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ count($categories) }}</h5>
                                <p class="text-muted small mb-0">Kategori</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 bg-white pb-0">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="fas fa-filter text-info me-2"></i>Filter & Pencarian
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.articles.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label fw-semibold">Cari Artikel</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Judul atau konten artikel...">
                            </div>
                            <div class="col-md-3">
                                <label for="category" class="form-label fw-semibold">Kategori</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                                        Published</option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sort" class="form-label fw-semibold">Urutkan</label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama
                                    </option>
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z
                                    </option>
                                    <option value="category" {{ request('sort') == 'category' ? 'selected' : '' }}>
                                        Kategori</option>
                                </select>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <div class="d-flex w-100 gap-2">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Article List -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white py-3">
                        <div>
                            <h6 class="fw-bold text-dark m-0">
                                <i class="fas fa-list text-info me-2"></i>
                                Daftar Artikel
                            </h6>
                            <small class="text-muted">{{ $articles->total() }} total artikel</small>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-hover table-borderless table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold border-0 px-4 py-3">Artikel</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Kategori</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Penulis</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Status</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Tanggal</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($articles as $article)
                                        <tr class="border-bottom">
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-3 bg-info me-3 bg-opacity-10 p-2">
                                                        <i class="fas fa-newspaper text-info fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">
                                                            {{ Str::limit($article->title, 50) }}</div>
                                                        <small
                                                            class="text-muted">{{ Str::limit($article->excerpt, 80) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="badge bg-primary text-primary border-primary border border-opacity-25 bg-opacity-10 px-3 py-2">
                                                    {{ $article->category }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="fas fa-user text-white" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-dark small">
                                                            {{ $article->author->name }}</div>
                                                        <small class="text-muted">{{ $article->author->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($article->is_published)
                                                    <span
                                                        class="badge bg-success text-success border-success border border-opacity-25 bg-opacity-15 px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>Published
                                                    </span>
                                                    @if ($article->published_at)
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar me-1"></i>
                                                                {{ $article->published_at->format('d/m/Y') }}
                                                            </small>
                                                        </div>
                                                    @endif
                                                @else
                                                    <span
                                                        class="badge bg-warning text-warning border-warning border border-opacity-25 bg-opacity-15 px-3 py-2">
                                                        <i class="fas fa-edit me-1"></i>Draft
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-muted small">
                                                    <div><i
                                                            class="fas fa-plus me-1"></i>{{ $article->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div><i
                                                            class="fas fa-edit me-1"></i>{{ $article->updated_at->format('d/m/Y') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="btn-group" role="group">
                                                    @if ($article->is_published)
                                                        <a href="{{ route('articles.show', $article->slug) }}"
                                                            class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                            title="Lihat Artikel" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                                                        class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.articles.destroy', $article->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus {{ $article->title }}?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-5 text-center">
                                                <div class="py-5">
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-4"
                                                        style="width: 80px; height: 80px;">
                                                        <i class="fas fa-newspaper fa-2x text-muted"></i>
                                                    </div>
                                                    <h5 class="text-muted mb-2">Belum ada artikel</h5>
                                                    <p class="text-muted mb-4">Mulai dengan membuat artikel pertama Anda
                                                    </p>
                                                    <a href="{{ route('admin.articles.create') }}"
                                                        class="btn btn-info btn-lg">
                                                        <i class="fas fa-plus me-2"></i>Tambah Artikel Pertama
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($articles->hasPages())
                        <div class="card-footer border-0 bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Menampilkan {{ $articles->firstItem() }} sampai {{ $articles->lastItem() }}
                                    dari {{ $articles->total() }} entri
                                </div>
                                <div class="pagination-wrapper">
                                    {{ $articles->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .bg-gradient-info {
                background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(54, 185, 204, 0.05);
                transition: background-color 0.15s ease-in-out;
            }

            .btn-group .btn {
                margin-right: 2px;
            }

            .btn-group .btn:last-child {
                margin-right: 0;
            }

            .pagination-wrapper .pagination {
                margin-bottom: 0;
            }

            .badge {
                font-size: 0.75rem;
                font-weight: 500;
            }

            .card {
                transition: box-shadow 0.15s ease-in-out;
            }

            .card:hover {
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Initialize tooltips
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        </script>
    @endpush
@endsection
