@extends('layouts.app')

@section('title', 'SPK Jamu Madura - Sistem Pendukung Keputusan')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Temukan Jamu Madura Terbaik untuk Anda</h1>
                    <p class="lead mb-4">Sistem Pendukung Keputusan berbasis algoritma SMART untuk membantu Anda memilih jamu
                        tradisional Madura yang sesuai dengan kebutuhan kesehatan Anda.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('smart.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-calculator me-2"></i>Mulai Rekomendasi
                        </a>
                        <a href="{{ route('jamu.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-pills me-2"></i>Lihat Semua Jamu
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/jamu.png') }}" alt="Jamu Madura" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-pills fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-primary">{{ $stats['total_jamu'] }}</h3>
                            <p class="text-muted">Jenis Jamu Tersedia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-tags fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-primary">{{ $stats['categories'] }}</h3>
                            <p class="text-muted">Kategori Jamu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="fas fa-newspaper fa-3x"></i>
                            </div>
                            <h3 class="fw-bold text-primary">{{ $stats['articles'] }}</h3>
                            <p class="text-muted">Artikel Edukasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Jamus -->
    <section class="py-5">
        <div class="container">
            <div class="mb-5 text-center">
                <h2 class="fw-bold text-primary">Jamu Unggulan</h2>
                <p class="lead text-muted">Jamu terbaik dengan khasiat tinggi</p>
            </div>

            <div class="row">
                @foreach ($featuredJamus as $jamu)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card jamu-card card-hover h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="category-badge">{{ $jamu->kategori }}</span>
                                    <div class="rating-stars">
                                        @php
                                            $nilai = $jamu->nilai_khasiat;

                                            // rentang target
                                            $min_lama = 80;
                                            $max_lama = 98;
                                            $min_baru = 1;
                                            $max_baru = 5;

                                            // Pengaman: jika nilai di luar rentang, paskan ke min/max
                                            if ($nilai < $min_lama) {
                                                $nilai = $min_lama;
                                            }
                                            if ($nilai > $max_lama) {
                                                $nilai = $max_lama;
                                            }

                                            // Hitung rentang (span) dari masing-masing skala
                                            $rentang_lama = $max_lama - $min_lama; // Hasilnya 18
                                            $rentang_baru = $max_baru - $min_baru; // Hasilnya 4

                                            // Terapkan rumus interpolasi
                                            $skala_float =
                                                $min_baru + (($nilai - $min_lama) / $rentang_lama) * $rentang_baru;

                                            // Bulatkan ke bintang terdekat
                                            $ratingBintang = round($skala_float);
                                        @endphp

                                        {{-- Loop untuk menampilkan bintang --}}
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $ratingBintang)
                                                <i class="fas fa-star" style="color: #ffc107;"></i>
                                            @else
                                                <i class="far fa-star" style="color: #ffc107;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <h5 class="card-title fw-bold">{{ $jamu->nama_jamu }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($jamu->khasiat, 80) }}</p>

                                <div class="mb-3">
                                    <small class="text-muted">Kandungan utama:</small>
                                    <p class="mb-0">{{ Str::limit($jamu->kandungan, 60) }}</p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price-tag">Rp {{ number_format($jamu->harga, 0, ',', '.') }}</span>
                                    <a href="{{ route('jamu.show', $jamu->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('jamu.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-pills me-2"></i>Lihat Semua Jamu
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="mb-5 text-center">
                <h2 class="fw-bold text-primary">Kategori Jamu</h2>
                <p class="lead text-muted">Pilih berdasarkan kebutuhan kesehatan Anda</p>
            </div>

            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <a href="javascript:void(0)" class="text-decoration-none">
                            <div class="card card-hover h-100 border-0 text-center">
                                <div class="card-body">
                                    <div class="text-primary mb-3">
                                        @switch($category)
                                            @case('Kesehatan Wanita')
                                                <i class="fas fa-female fa-3x"></i>
                                            @break

                                            @case('Energi')
                                                <i class="fas fa-bolt fa-3x"></i>
                                            @break

                                            @case('Daya Tahan Tubuh')
                                                <i class="fas fa-shield-alt fa-3x"></i>
                                            @break

                                            @case('Anti Radang')
                                                <i class="fas fa-heartbeat fa-3x"></i>
                                            @break

                                            @default
                                                <i class="fas fa-leaf fa-3x"></i>
                                        @endswitch
                                    </div>
                                    <h5 class="fw-bold text-primary">{{ $category }}</h5>
                                    <p class="text-muted">
                                        @switch($category)
                                            @case('Kesehatan Wanita')
                                                Jamu khusus untuk kesehatan reproduksi wanita
                                            @break

                                            @case('Energi')
                                                Jamu untuk meningkatkan stamina dan vitalitas
                                            @break

                                            @case('Daya Tahan Tubuh')
                                                Jamu untuk memperkuat sistem imun
                                            @break

                                            @case('Anti Radang')
                                                Jamu untuk mengatasi peradangan
                                            @break

                                            @default
                                                Jamu tradisional berkualitas
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recent Articles -->
    <section class="py-5">
        <div class="container">
            <div class="mb-5 text-center">
                <h2 class="fw-bold text-primary">Artikel Terbaru</h2>
                <p class="lead text-muted">Pelajari lebih lanjut tentang jamu tradisional</p>
            </div>

            <div class="row">
                @foreach ($recentArticles as $article)
                    <div class="col-lg-4 mb-4">
                        <div class="card card-hover h-100 border-0">
                            @if ($article->featured_image)
                                <img src="{{ $article->featured_image }}" class="card-img-top"
                                    alt="{{ $article->title }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">{{ $article->category }}</span>
                                    <small class="text-muted">{{ $article->published_at->format('d M Y') }}</small>
                                </div>
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text text-muted">{{ $article->excerpt }}</p>
                                <a href="{{ route('articles.show', $article->slug) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-arrow-right me-1"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('articles.index') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-newspaper me-2"></i>Lihat Semua Artikel
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4">Mulai Mencari Jamu yang Tepat untuk Anda</h2>
            <p class="lead mb-4">Gunakan sistem rekomendasi SMART untuk mendapatkan saran jamu terbaik</p>
            <a href="{{ route('smart.index') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-calculator me-2"></i>Mulai Rekomendasi Sekarang
            </a>
        </div>
    </section>
@endsection
