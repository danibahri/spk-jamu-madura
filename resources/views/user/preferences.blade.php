@extends('layouts.app')

@section('title', 'Preferensi Saya')

@section('content')
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('preferences.index') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-sliders-h me-2"></i>Preferensi
                    </a>
                    <a href="{{ route('preferences.history') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-history me-2"></i>Riwayat Pencarian
                    </a>
                    <a href="{{ route('favorites.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-heart me-2"></i>Favorit
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Preferensi Saya</h2>
                        <p class="text-muted mb-0">Kelola preferensi kriteria untuk rekomendasi jamu</p>
                    </div>
                    <a href="{{ route('smart.index') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Buat Preferensi Baru
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Current Preferences -->
                @if ($preferences->count() > 0)
                    <div class="row">
                        @foreach ($preferences as $preference)
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold mb-0">
                                            {{ $preference->name ?? 'Preferensi ' . $preference->created_at->format('d M Y') }}
                                        </h6>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="usePreference({{ $preference->id }})">
                                                        <i class="fas fa-play me-2"></i>Gunakan
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="editPreference({{ $preference->id }})">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#"
                                                        onclick="deletePreference({{ $preference->id }})">
                                                        <i class="fas fa-trash me-2"></i>Hapus
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $criteria = json_decode($preference->criteria, true);
                                        @endphp

                                        <!-- Criteria Display -->
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                        <i class="fas fa-money-bill text-success me-2"></i>
                                                        <span class="fw-bold">Harga</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-success"
                                                            style="width: {{ ($criteria['harga'] ?? 0) * 10 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $criteria['harga'] ?? 0 }}/10</small>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                        <i class="fas fa-leaf text-warning me-2"></i>
                                                        <span class="fw-bold">Kandungan</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-warning"
                                                            style="width: {{ ($criteria['kandungan'] ?? 0) * 10 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $criteria['kandungan'] ?? 0 }}/10</small>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                        <i class="fas fa-heart text-danger me-2"></i>
                                                        <span class="fw-bold">Khasiat</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-danger"
                                                            style="width: {{ ($criteria['khasiat'] ?? 0) * 10 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $criteria['khasiat'] ?? 0 }}/10</small>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                        <i class="fas fa-shield-alt text-info me-2"></i>
                                                        <span class="fw-bold">Keamanan</span>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar bg-info"
                                                            style="width: {{ ($criteria['keamanan'] ?? 0) * 10 }}%"></div>
                                                    </div>
                                                    <small class="text-muted">{{ $criteria['keamanan'] ?? 0 }}/10</small>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($preference->filters)
                                            @php
                                                $filters = json_decode($preference->filters, true);
                                            @endphp
                                            <hr>
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-2">Filter Tambahan:</h6>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @if (!empty($filters['kategori']))
                                                        <span class="badge bg-secondary">{{ $filters['kategori'] }}</span>
                                                    @endif
                                                    @if (!empty($filters['harga_max']))
                                                        <span class="badge bg-success">
                                                            Max: Rp {{ number_format($filters['harga_max'], 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $preference->updated_at->diffForHumans() }}
                                            </small>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="usePreference({{ $preference->id }})">
                                                <i class="fas fa-play me-1"></i>Gunakan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($preferences->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $preferences->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="py-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-sliders-h fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">Belum Ada Preferensi</h4>
                        <p class="text-muted mb-4">
                            Anda belum menyimpan preferensi apapun. Mulai dengan membuat preferensi pertama Anda
                            menggunakan sistem rekomendasi SMART.
                        </p>
                        <a href="{{ route('smart.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Buat Preferensi Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Preference Modal -->
    <div class="modal fade" id="editPreferenceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Preferensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editPreferenceForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="preference_name" class="form-label">Nama Preferensi</label>
                            <input type="text" class="form-control" id="preference_name" name="name"
                                placeholder="Contoh: Preferensi Diabetes">
                        </div>
                        <!-- Add other edit fields here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function usePreference(preferenceId) {
                // Redirect to SMART with preference ID
                window.location.href = `{{ route('smart.index') }}?preference=${preferenceId}`;
            }

            function editPreference(preferenceId) {
                // Load preference data and show modal
                fetch(`/preferences/${preferenceId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('preference_name').value = data.name || '';
                        // Populate other fields

                        const modal = new bootstrap.Modal(document.getElementById('editPreferenceModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal memuat data preferensi');
                    });
            }

            function deletePreference(preferenceId) {
                if (confirm('Yakin ingin menghapus preferensi ini?')) {
                    fetch(`/preferences/${preferenceId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Gagal menghapus preferensi');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan');
                        });
                }
            }

            // Edit form submission
            document.getElementById('editPreferenceForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                // Handle form submission

                const modal = bootstrap.Modal.getInstance(document.getElementById('editPreferenceModal'));
                modal.hide();
            });
        </script>
    @endpush
@endsection
