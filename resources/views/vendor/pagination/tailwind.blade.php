@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        {{-- Mobile --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#818cf8]/50 bg-white border border-[#818cf8]/50 cursor-default rounded-md leading-5">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-[#818cf8] bg-white border border-[#818cf8] rounded-md hover:bg-[#818cf8]/10 focus:outline-none focus:ring-2 focus:ring-[#818cf8]/50 transition">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-[#818cf8] bg-white border border-[#818cf8] rounded-md hover:bg-[#818cf8]/10 focus:outline-none focus:ring-2 focus:ring-[#818cf8]/50 transition">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-[#818cf8]/50 bg-white border border-[#818cf8]/50 cursor-default rounded-md leading-5">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Desktop --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            {{-- Info --}}
            <p class="text-sm text-gray-700 leading-5">
                {!! __('Showing') !!}
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>

            {{-- Links --}}
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true">
                        <span
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#818cf8]/50 bg-white border border-[#818cf8]/50 rounded-l-md leading-5">
                            &larr;
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#818cf8] bg-white border border-[#818cf8] rounded-l-md hover:bg-[#818cf8]/10 focus:outline-none focus:ring-2 focus:ring-[#818cf8]/50 transition">
                        &larr;
                    </a>
                @endif

                {{-- Numbers --}}
                @foreach ($elements as $element)
                    {{-- Dots --}}
                    @if (is_string($element))
                        <span
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 leading-5">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Pages --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-[#818cf8] text-blue border border-[#818cf8] leading-5">
                                        {{ $page }}
                                    </span>
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-[#818cf8] bg-white border border-[#818cf8] hover:bg-[#818cf8]/10 hover:text-[#818cf8] leading-5 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-[#818cf8] bg-white border border-[#818cf8] rounded-r-md hover:bg-[#818cf8]/10 focus:outline-none focus:ring-2 focus:ring-[#818cf8]/50 transition">
                        &rarr;
                    </a>
                @else
                    <span aria-disabled="true">
                        <span
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-[#818cf8]/50 bg-white border border-[#818cf8]/50 rounded-r-md leading-5">
                            &rarr;
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </nav>
@endif
