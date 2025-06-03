@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <ul class="pagination justify-content-center">

            {{-- Tombol Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="fas fa-chevron-left"></i>
                        <span class="d-none d-md-inline ms-1">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <i class="fas fa-chevron-left"></i>
                        <span class="d-none d-md-inline ms-1">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Halaman 1 --}}
            <li class="page-item {{ $paginator->currentPage() == 1 ? 'active' : '' }}">
                @if ($paginator->currentPage() == 1)
                    <span class="page-link">1</span>
                @else
                    <a class="page-link" href="{{ $paginator->url(1) }}">1</a>
                @endif
            </li>

            {{-- Titik-titik --}}
            @if ($paginator->currentPage() > 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif

            {{-- Halaman Sekarang --}}
            @if ($paginator->currentPage() != 1)
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $paginator->currentPage() }}</span>
                </li>
            @endif

            {{-- Tombol Selanjutnya --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                        <span class="d-none d-md-inline me-1">Selanjutnya</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">
                        <span class="d-none d-md-inline me-1">Selanjutnya</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif

        </ul>
        {{-- Lompat ke Halaman --}}
        @if ($paginator->lastPage() > 10)
            <div class="mt-3 text-center">
                <label class="form-label small text-muted">Lompat ke halaman:</label>
                <select class="form-select form-select-sm d-inline-block ms-1 w-auto"
                    onchange="window.location.href=this.value">
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <option value="{{ $paginator->url($i) }}"
                            {{ $i == $paginator->currentPage() ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        @endif
    </nav>
@endif
