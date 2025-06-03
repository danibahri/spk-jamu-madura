@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-lock fa-5x text-warning"></i>
                        </div>

                        <h1 class="display-4 text-danger">403</h1>
                        <h2 class="mb-4">Akses Ditolak</h2>

                        <div class="alert alert-warning" role="alert">
                            <strong>Maaf!</strong> Anda tidak memiliki izin untuk mengakses halaman ini.
                            <br>
                            Hanya administrator yang dapat mengakses panel admin.
                        </div>

                        <div class="mb-4">
                            <p class="text-muted">
                                Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem.
                            </p>
                        </div>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('home') }}" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Kembali ke Beranda
                            </a>

                            @auth
                                <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard User
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .fa-lock {
            opacity: 0.7;
        }

        .display-4 {
            font-weight: bold;
        }

        .gap-3 {
            gap: 1rem !important;
        }
    </style>
@endpush
