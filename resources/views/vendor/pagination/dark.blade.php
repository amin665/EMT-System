@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination">
        <div class="text-sm text-gray-400">
            <span>عرض</span>
            <span class="font-semibold text-gray-100">{{ $paginator->firstItem() }}</span>
            <span>إلى</span>
            <span class="font-semibold text-gray-100">{{ $paginator->lastItem() }}</span>
            <span>من</span>
            <span class="font-semibold text-gray-100">{{ $paginator->total() }}</span>
        </div>
        <div class="pagination-links">
            @if ($paginator->onFirstPage())
                <span class="pagination-link is-disabled">السابق</span>
            @else
                <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">السابق</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination-link is-disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-link is-active">{{ $page }}</span>
                        @else
                            <a class="pagination-link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next">التالي</a>
            @else
                <span class="pagination-link is-disabled">التالي</span>
            @endif
        </div>
    </nav>
@endif
