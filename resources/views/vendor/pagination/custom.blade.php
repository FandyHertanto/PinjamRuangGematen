@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif
    </ul>
@endif

<style>
    /* Pagination Styles */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    display: block;
    padding: 8px 12px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    color: #007bff;
}

.pagination .page-item.active .page-link {
    background: #007bff;
    border-color: #007bff;
    color: #fff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
}

</style>