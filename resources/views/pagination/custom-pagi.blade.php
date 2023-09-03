@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative block py-2 px-3 bg-gray-200 text-gray-500 cursor-not-allowed rounded-l-md">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative block py-2 px-3 bg-white border border-gray-300 text-gray-600 hover:border-gray-400 rounded-l-md">Previous</a>
        @endif

        {{-- Pagination Numbers --}}
        <ul class="flex space-x-2">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="block py-2 px-3 bg-gray-200 text-gray-500 cursor-not-allowed">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="block py-2 px-3 bg-primary text-white rounded-md">{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" class="block py-2 px-3 bg-gray-100 rounded-md text-gray-600 hover:border-gray-400 hover:bg-gray-300 transition-all duration-200">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative block py-2 px-3 bg-white border border-gray-300 text-gray-600 hover:border-gray-400 rounded-r-md">Next</a>
        @else
            <span class="relative block py-2 px-3 bg-gray-200 text-gray-500 cursor-not-allowed rounded-r-md">Next</span>
        @endif
    </nav>

    <p class="text-gray-600 mt-2">
        Menampilkan {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data.
    </p>
@endif
