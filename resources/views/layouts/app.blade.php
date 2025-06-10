<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'SPK Jamu Madura')</title> <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/favorites.css') }}">
        <link rel="stylesheet" href="{{ asset('css/jamu-cards.css') }}">
        <style>
            .navbar-brand {
                font-weight: bold;
                color: #2d5a3d !important;
            }

            .hero-section {
                background: linear-gradient(135deg, #2d5a3d 0%, #4a7c59 100%);
                color: white;
                padding: 100px 0;
            }

            .card-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .btn-primary {
                background-color: #2d5a3d;
                border-color: #2d5a3d;
            }

            .btn-primary:hover {
                background-color: #1e3a29;
                border-color: #1e3a29;
            }

            .text-primary {
                color: #2d5a3d !important;
            }

            .footer {
                background-color: #2d5a3d;
                color: white;
            }

            .jamu-card {
                border: none;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .category-badge {
                background-color: #4a7c59;
                color: white;
                padding: 4px 8px;
                border-radius: 12px;
                font-size: 0.8rem;
            }

            .price-tag {
                font-size: 1.2rem;
                font-weight: bold;
                color: #2d5a3d;
            }

            .rating-stars {
                color: #ffc107;
            }
        </style>
        @stack('styles')
    </head>

    <body> <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-leaf text-success me-2"></i><span class="text-success">SPK</span> Jamu Madura
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="navbar-collapse collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}"
                                href="{{ route('home') }}">
                                <i class="fas fa-home text-secondary me-1"></i>Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('jamu.*') && !request()->routeIs('admin.*') ? 'active fw-bold' : '' }}"
                                href="{{ route('jamu.index') }}">
                                <i class="fas fa-pills text-success me-1"></i>Jamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('smart.*') ? 'active fw-bold' : '' }}"
                                href="{{ route('smart.index') }}">
                                <i class="fas fa-calculator text-primary me-1"></i>Rekomendasi SMART
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('articles.*') && !request()->routeIs('admin.*') ? 'active fw-bold' : '' }}"
                                href="{{ route('articles.index') }}">
                                <i class="fas fa-newspaper text-info me-1"></i>Artikel
                            </a>
                        </li>

                        @auth
                            @if (Auth::user()->role === 'admin')
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active fw-bold text-danger' : '' }}"
                                        href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-tools text-danger me-1"></i>Admin
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                                href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-tachometer-alt text-primary me-2"></i>Dashboard
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('admin.jamu.*') ? 'active' : '' }}"
                                                href="{{ route('admin.jamu.index') }}">
                                                <i class="fas fa-pills text-success me-2"></i>Kelola Jamu
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ request()->routeIs('admin.articles.*') ? 'active' : '' }}"
                                                href="{{ route('admin.articles.index') }}">
                                                <i class="fas fa-newspaper text-info me-2"></i>Kelola Artikel
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('preferences.index') }}">
                                            <i class="fas fa-cog me-2"></i>Preferensi
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('favorites.index') }}">
                                            <i class="fas fa-heart text-danger me-2"></i>Favorit
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('search-history.index') }}">
                                            <i class="fas fa-history text-info me-2"></i>Riwayat Pencarian
                                        </a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt text-secondary me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i>Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i>Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show m-0" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer mt-5 py-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <h5><i class="fas fa-leaf me-2"></i>SPK Jamu Madura</h5>
                        <p class="text-light">Sistem Pendukung Keputusan untuk memilih jamu tradisional Madura yang
                            tepat sesuai kebutuhan kesehatan Anda.</p>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <h6>Menu</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Beranda</a>
                            </li>
                            <li><a href="{{ route('jamu.index') }}" class="text-light text-decoration-none">Jamu</a>
                            </li>
                            <li><a href="{{ route('smart.index') }}"
                                    class="text-light text-decoration-none">Rekomendasi</a></li>
                            <li><a href="{{ route('articles.index') }}"
                                    class="text-light text-decoration-none">Artikel</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <h6>Kategori Jamu</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-light text-decoration-none">Kesehatan Wanita</a></li>
                            <li><a href="#" class="text-light text-decoration-none">Energi</a></li>
                            <li><a href="#" class="text-light text-decoration-none">Daya Tahan Tubuh</a></li>
                            <li><a href="#" class="text-light text-decoration-none">Anti Radang</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 mb-3">
                        <h6>Kontak</h6>
                        <p class="text-light mb-1"><i class="fas fa-envelope me-2"></i>info@spkjamu.com</p>
                        <p class="text-light mb-1"><i class="fas fa-phone me-2"></i>(021) 123-4567</p>
                        <p class="text-light"><i class="fas fa-map-marker-alt me-2"></i>Madura, Jawa Timur</p>
                    </div>
                </div>
                <hr class="border-light">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-light mb-0">&copy; 2025 SPK Jamu Madura. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </footer> <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Custom Scripts -->
        <script src="{{ asset('js/favorites.js') }}"></script>

        <script>
            // CSRF Token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Auto dismiss alerts
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        </script>

        @include('sweetalert::alert')
        @stack('scripts')
    </body>

</html>
