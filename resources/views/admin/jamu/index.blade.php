@extends('layouts.app')

@section('title', 'Manajemen Jamu - Admin')

@section('content')
    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">Manajemen Jamu</h2>
                        <p class="text-muted mb-0">Kelola data produk jamu tradisional</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <a href="{{ route('admin.jamu.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Tambah Jamu
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.jamu.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="search" class="form-label">Cari Jamu</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Nama jamu...">
                            </div>
                            <div class="col-md-2">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori">
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
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="sort" class="form-label">Urutkan</label>
                                <select class="form-control" id="sort" name="sort">
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
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.jamu.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-refresh me-1"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jamu List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h6 class="font-weight-bold text-primary m-0">
                            Daftar Jamu ({{ $jamus->total() }} total)
                        </h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-info" onclick="exportData()">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <button class="btn btn-sm btn-warning" onclick="bulkAction()">
                                <i class="fas fa-tasks me-1"></i>Bulk Action
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table-hover mb-0 table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                        </th>
                                        <th class="px-4 py-3">Jamu</th>
                                        <th class="px-4 py-3">Kategori</th>
                                        <th class="px-4 py-3">Harga</th>
                                        <th class="px-4 py-3">Kandungan</th>
                                        <th class="px-4 py-3">Khasiat</th>
                                        <th class="px-4 py-3">Nilai</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jamus as $jamu)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <input type="checkbox" name="selected_jamus[]" value="{{ $jamu->id }}"
                                                    class="jamu-checkbox">
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://via.placeholder.com/50x50?text=J"
                                                        alt="{{ $jamu->nama_jamu }}" class="me-3 rounded" width="50"
                                                        height="50">
                                                    <div>
                                                        <div class="fw-bold">{{ $jamu->nama_jamu }}</div>
                                                        <small class="text-muted">ID: {{ $jamu->id }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="badge bg-secondary">{{ $jamu->kategori }}</span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <strong class="text-success">
                                                    Rp {{ number_format($jamu->harga, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-truncate" style="max-width: 150px;"
                                                    title="{{ $jamu->kandungan }}">
                                                    {{ $jamu->kandungan }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-truncate" style="max-width: 150px;"
                                                    title="{{ $jamu->khasiat }}">
                                                    {{ $jamu->khasiat }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="d-flex gap-1">
                                                    <span class="badge bg-warning" title="Nilai Kandungan">
                                                        K: {{ $jamu->nilai_kandungan }}
                                                    </span>
                                                    <span class="badge bg-info" title="Nilai Khasiat">
                                                        F: {{ $jamu->nilai_khasiat }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($jamu->expired_date > now())
                                                    <span class="badge bg-success">Aktif</span>
                                                    <br><small class="text-muted">
                                                        Exp:
                                                        {{ \Carbon\Carbon::parse($jamu->expired_date)->format('d/m/Y') }}
                                                    </small>
                                                @else
                                                    <span class="badge bg-danger">Expired</span>
                                                    <br><small class="text-danger">
                                                        {{ \Carbon\Carbon::parse($jamu->expired_date)->format('d/m/Y') }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('jamu.show', $jamu->id) }}"
                                                        class="btn btn-sm btn-outline-info" title="Lihat Detail"
                                                        target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.jamu.edit', $jamu->id) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.jamu.destroy', $jamu->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Hapus"
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
                                                <div class="py-4">
                                                    <i class="fas fa-leaf fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Belum ada data jamu</h5>
                                                    <p class="text-muted">Mulai dengan menambahkan produk jamu pertama Anda
                                                    </p>
                                                    <a href="{{ route('admin.jamu.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus me-2"></i>Tambah Jamu
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
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan {{ $jamus->firstItem() }} sampai {{ $jamus->lastItem() }}
                                    dari {{ $jamus->total() }} entri
                                </div>
                                {{ $jamus->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div class="modal fade" id="bulkActionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="bulkActionForm">
                        <div class="mb-3">
                            <label for="bulk_action" class="form-label">Pilih Aksi</label>
                            <select class="form-control" id="bulk_action" name="action" required>
                                <option value="">Pilih aksi...</option>
                                <option value="delete">Hapus yang dipilih</option>
                                <option value="update_category">Update kategori</option>
                                <option value="update_status">Update status</option>
                            </select>
                        </div>
                        <div id="additional_fields"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="executeBulkAction()">Jalankan</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleSelectAll() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.jamu-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
            }

            function bulkAction() {
                const checkedBoxes = document.querySelectorAll('.jamu-checkbox:checked');
                if (checkedBoxes.length === 0) {
                    alert('Pilih minimal satu jamu untuk melakukan bulk action');
                    return;
                }

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
                <label for="new_category" class="form-label">Kategori Baru</label>
                <select class="form-control" id="new_category" name="new_category" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        `;
                }
            });

            function executeBulkAction() {
                const checkedBoxes = document.querySelectorAll('.jamu-checkbox:checked');
                const action = document.getElementById('bulk_action').value;

                if (!action) {
                    alert('Pilih aksi yang ingin dilakukan');
                    return;
                }

                const ids = Array.from(checkedBoxes).map(cb => cb.value);

                if (action === 'delete') {
                    if (!confirm(`Yakin ingin menghapus ${ids.length} jamu yang dipilih?`)) {
                        return;
                    }
                }

                // Implement AJAX call here for bulk actions
                console.log('Bulk action:', action, 'IDs:', ids);

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('bulkActionModal'));
                modal.hide();
            }
        </script>
    @endpush
@endsection
