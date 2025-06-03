@extends('layouts.app')

@section('title', 'Manajemen Jamu - Admin')

@section('content')
    <div class="container-fluid my-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-gradient-primary rounded-3 p-4 text-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-leaf me-2"></i>Manajemen Jamu
                            </h2>
                            <p class="mb-0 opacity-75">Kelola data produk jamu tradisional dengan mudah</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="{{ route('admin.jamu.create') }}" class="btn btn-success btn-sm shadow-sm">
                                <i class="fas fa-plus me-2"></i>Tambah Jamu
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
                            <div class="rounded-circle bg-primary me-3 bg-opacity-10 p-3">
                                <i class="fas fa-leaf text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $jamus->total() }}</h5>
                                <p class="text-muted small mb-0">Total Jamu</p>
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
                                <h5 class="fw-bold mb-1">{{ $jamus->where('expired_date', '>', now())->count() }}</h5>
                                <p class="text-muted small mb-0">Jamu Aktif</p>
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
                                <i class="fas fa-exclamation-triangle text-warning fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $jamus->where('expired_date', '<=', now())->count() }}</h5>
                                <p class="text-muted small mb-0">Jamu Expired</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info me-3 bg-opacity-10 p-3">
                                <i class="fas fa-tags text-info fa-lg"></i>
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
                            <i class="fas fa-filter text-primary me-2"></i>Filter & Pencarian
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.jamu.index') }}" class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label fw-semibold">Cari Jamu</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="search" name="search"
                                        value="{{ request('search') }}" placeholder="Nama jamu atau kandungan...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label for="kategori" class="form-label fw-semibold">Kategori</label>
                                <select class="form-select" id="kategori" name="kategori">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category }}"
                                            {{ request('kategori') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>
                                        <i class="fas fa-times-circle"></i> Expired
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
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga
                                        Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                        Harga Tertinggi</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <div class="d-flex w-100 gap-2">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="fas fa-search me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.jamu.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-1"></i>Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Jamu List -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 bg-white py-3">
                        <div>
                            <h6 class="fw-bold text-dark m-0">
                                <i class="fas fa-list text-primary me-2"></i>
                                Daftar Jamu
                            </h6>
                            <small class="text-muted">{{ $jamus->total() }} total produk jamu</small>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-info" onclick="exportData()" data-bs-toggle="tooltip"
                                title="Export Data">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <button class="btn btn-sm btn-outline-warning" onclick="bulkAction()"
                                data-bs-toggle="tooltip" title="Bulk Action">
                                <i class="fas fa-tasks me-1"></i>Bulk Action
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-hover mb-0 table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="selectAll"
                                                    onchange="toggleSelectAll()">
                                                <label class="form-check-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th class="fw-semibold border-0 px-4 py-3">Produk Jamu</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Kategori</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Harga</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Kandungan</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Khasiat</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Penilaian</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Status</th>
                                        <th class="fw-semibold border-0 px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jamus as $jamu)
                                        <tr class="border-bottom">
                                            <td class="px-4 py-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input jamu-checkbox"
                                                        name="selected_jamus[]" value="{{ $jamu->id }}">
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-3 bg-primary me-3 bg-opacity-10 p-2">
                                                        <i class="fas fa-leaf text-primary fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $jamu->nama_jamu }}</div>
                                                        <small class="text-muted">ID:
                                                            #{{ str_pad($jamu->id, 4, '0', STR_PAD_LEFT) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="badge bg-secondary text-secondary border-secondary border border-opacity-25 bg-opacity-10 px-3 py-2">
                                                    {{ $jamu->kategori }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="fw-bold text-success fs-6">
                                                    Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-truncate" style="max-width: 180px;"
                                                    data-bs-toggle="tooltip" title="{{ $jamu->kandungan }}">
                                                    <i class="fas fa-pills text-info me-1"></i>
                                                    {{ $jamu->kandungan }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-truncate" style="max-width: 180px;"
                                                    data-bs-toggle="tooltip" title="{{ $jamu->khasiat }}">
                                                    <i class="fas fa-heart text-danger me-1"></i>
                                                    {{ $jamu->khasiat }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex flex-column gap-1">
                                                    <span
                                                        class="badge bg-warning text-warning border-warning border border-opacity-25 bg-opacity-15"
                                                        data-bs-toggle="tooltip" title="Nilai Kandungan">
                                                        <i class="fas fa-flask me-1"></i>{{ $jamu->nilai_kandungan }}
                                                    </span>
                                                    <span
                                                        class="badge bg-info text-info border-info border border-opacity-25 bg-opacity-15"
                                                        data-bs-toggle="tooltip" title="Nilai Khasiat">
                                                        <i class="fas fa-star me-1"></i>{{ $jamu->nilai_khasiat }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($jamu->expired_date > now())
                                                    <span
                                                        class="badge bg-success text-success border-success border border-opacity-25 bg-opacity-15 px-3 py-2">
                                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                                    </span>
                                                    <div class="mt-1">
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            Exp:
                                                            {{ \Carbon\Carbon::parse($jamu->expired_date)->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                @else
                                                    <span
                                                        class="badge bg-danger text-danger border-danger border border-opacity-25 bg-opacity-15 px-3 py-2">
                                                        <i class="fas fa-times-circle me-1"></i>Expired
                                                    </span>
                                                    <div class="mt-1">
                                                        <small class="text-danger">
                                                            <i class="fas fa-calendar-times me-1"></i>
                                                            {{ \Carbon\Carbon::parse($jamu->expired_date)->format('d/m/Y') }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('jamu.show', $jamu->id) }}"
                                                        class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip"
                                                        title="Lihat Detail" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.jamu.edit', $jamu->id) }}"
                                                        class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.jamu.destroy', $jamu->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="tooltip" title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus {{ $jamu->nama_jamu }}?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-4 py-5 text-center">
                                                <div class="py-5">
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-4"
                                                        style="width: 80px; height: 80px;">
                                                        <i class="fas fa-leaf fa-2x text-muted"></i>
                                                    </div>
                                                    <h5 class="text-muted mb-2">Belum ada data jamu</h5>
                                                    <p class="text-muted mb-4">Mulai dengan menambahkan produk jamu pertama
                                                        Anda</p>
                                                    <a href="{{ route('admin.jamu.create') }}"
                                                        class="btn btn-primary btn-lg">
                                                        <i class="fas fa-plus me-2"></i>Tambah Jamu Pertama
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($jamus->hasPages())
                        <div class="card-footer border-0 bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Menampilkan {{ $jamus->firstItem() }} sampai {{ $jamus->lastItem() }}
                                    dari {{ $jamus->total() }} entri
                                </div>
                                <div class="pagination-wrapper">
                                    {{ $jamus->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Bulk Action Modal -->
    <div class="modal fade" id="bulkActionModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-tasks text-primary me-2"></i>Bulk Action
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="bulkActionForm">
                        <div class="mb-4">
                            <label for="bulk_action" class="form-label fw-semibold">Pilih Aksi</label>
                            <select class="form-select" id="bulk_action" name="action" required>
                                <option value="">Pilih aksi yang ingin dilakukan...</option>
                                <option value="delete">
                                    <i class="fas fa-trash"></i> Hapus yang dipilih
                                </option>
                                <option value="update_category">
                                    <i class="fas fa-tags"></i> Update kategori
                                </option>
                                <option value="update_status">
                                    <i class="fas fa-toggle-on"></i> Update status
                                </option>
                            </select>
                        </div>
                        <div id="additional_fields"></div>
                        <div class="alert alert-info d-none" id="bulk_info">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="selected_count">0</span> jamu dipilih untuk diproses
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary" onclick="executeBulkAction()">
                        <i class="fas fa-play me-1"></i>Jalankan Aksi
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
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

            .form-check-input:checked {
                background-color: #4e73df;
                border-color: #4e73df;
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

            function toggleSelectAll() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.jamu-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });

                updateBulkInfo();
            }

            function updateBulkInfo() {
                const checkedBoxes = document.querySelectorAll('.jamu-checkbox:checked');
                const bulkInfo = document.getElementById('bulk_info');
                const selectedCount = document.getElementById('selected_count');

                if (checkedBoxes.length > 0) {
                    selectedCount.textContent = checkedBoxes.length;
                    bulkInfo.classList.remove('d-none');
                } else {
                    bulkInfo.classList.add('d-none');
                }
            }

            // Add event listeners to checkboxes
            document.addEventListener('DOMContentLoaded', function() {
                const checkboxes = document.querySelectorAll('.jamu-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateBulkInfo);
                });
            });

            function bulkAction() {
                const checkedBoxes = document.querySelectorAll('.jamu-checkbox:checked');
                if (checkedBoxes.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Pilih minimal satu jamu untuk melakukan bulk action',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                updateBulkInfo();
                const modal = new bootstrap.Modal(document.getElementById('bulkActionModal'));
                modal.show();
            }

            function exportData() {
                const params = new URLSearchParams(window.location.search);
                params.set('export', 'excel');
                window.location.href = `{{ route('admin.jamu.index') }}?${params.toString()}`;
            }

            document.getElementById('bulk_action').addEventListener('change', function() {
                const additionalFields = document.getElementById('additional_fields');
                const action = this.value;

                additionalFields.innerHTML = '';

                if (action === 'update_category') {
                    additionalFields.innerHTML = `
                        <div class="mb-3">
                            <label for="new_category" class="form-label fw-semibold">Kategori Baru</label>
                            <select class="form-select" id="new_category" name="new_category" required>
                                <option value="">Pilih kategori baru...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    `;
                } else if (action === 'update_status') {
                    additionalFields.innerHTML = `
                        <div class="mb-3">
                            <label for="new_status" class="form-label fw-semibold">Status Baru</label>
                            <select class="form-select" id="new_status" name="new_status" required>
                                <option value="">Pilih status baru...</option>
                                <option value="active">Aktif</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                    `;
                }
            });

            function executeBulkAction() {
                const checkedBoxes = document.querySelectorAll('.jamu-checkbox:checked');
                const action = document.getElementById('bulk_action').value;

                if (!action) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Pilih aksi yang ingin dilakukan',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                const ids = Array.from(checkedBoxes).map(cb => cb.value);

                if (action === 'delete') {
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: `Yakin ingin menghapus ${ids.length} jamu yang dipilih?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Implement AJAX call here for bulk delete
                            console.log('Bulk delete:', ids);

                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('bulkActionModal'));
                            modal.hide();

                            // Show success message
                            Swal.fire('Berhasil!', 'Jamu berhasil dihapus.', 'success');
                        }
                    });
                } else {
                    // Implement AJAX call here for other bulk actions
                    console.log('Bulk action:', action, 'IDs:', ids);

                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('bulkActionModal'));
                    modal.hide();

                    // Show success message
                    Swal.fire('Berhasil!', 'Bulk action berhasil dijalankan.', 'success');
                }
            }
        </script>
    @endpush
@endsection
