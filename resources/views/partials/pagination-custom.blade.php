{{-- ============================================
     PARTIAL: PAGINASI KUSTOM
     Ganti default pagination Laravel dengan
     style yang sesuai tabel
     ============================================ --}}

@if($paginator->hasPages())
    <div class="pagination">
        {{-- Previous --}}
        @if($paginator->onFirstPage())
            <button class="page-btn" disabled style="opacity:0.4;cursor:default;">
                <i data-lucide="chevron-left"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn" style="text-decoration:none;">
                <i data-lucide="chevron-left"></i>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach($elements as $element)
            @if(is_string($element))
                <span style="display:flex;align-items:center;padding:0 4px;color:var(--muted);">{{ $element }}</span>
            @endif

            @if(is_array($element))
                @foreach($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <button class="page-btn active">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="page-btn" style="text-decoration:none;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn" style="text-decoration:none;">
                <i data-lucide="chevron-right"></i>
            </a>
        @else
            <button class="page-btn" disabled style="opacity:0.4;cursor:default;">
                <i data-lucide="chevron-right"></i>
            </button>
        @endif
    </div>
@endif