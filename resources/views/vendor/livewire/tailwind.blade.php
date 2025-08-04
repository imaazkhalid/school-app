@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }
    $scrollIntoViewJsSnippet = ($scrollTo !== false)
        ? <<<JS
           (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
        JS
        : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
            {{-- Mobile Pagination --}}
            <div class="flex justify-between flex-1 sm:hidden items-center gap-3">
                @if ($paginator->onFirstPage())
                    <span class="flex justify-center items-center h-8 px-4 rounded-md text-zinc-300 dark:text-zinc-500 bg-white border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 cursor-not-allowed">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="flex justify-center items-center h-8 px-4 rounded-md text-zinc-700 dark:text-zinc-400 bg-white border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white transition-colors duration-150 ease-in-out">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif

                @if ($paginator->hasMorePages())
                    <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" class="flex justify-center items-center h-8 px-4 rounded-md text-zinc-700 dark:text-zinc-400 bg-white border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white transition-colors duration-150 ease-in-out">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="flex justify-center items-center h-8 px-4 rounded-md text-zinc-300 dark:text-zinc-500 bg-white border border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 cursor-not-allowed">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </div>

            {{-- Desktop Pagination --}}
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400 text-xs font-medium whitespace-nowrap">
                        @if ($paginator->firstItem())
                            {{ __('Showing') }}
                            <span class="font-medium">{{ $paginator->firstItem() }}</span>
                            {{ __('to') }}
                            <span class="font-medium">{{ $paginator->lastItem() }}</span>
                            {{ __('of') }}
                            <span class="font-medium">{{ $paginator->total() }}</span>
                            {{ __('results') }}
                        @else
                            {{ $paginator->count() }} {{ __('results') }}
                        @endif
                    </p>
                </div>

                <div>
                    <span class="inline-flex rounded-md p-[1px] bg-white border border-zinc-200 dark:bg-white/10 dark:border-white/10 shadow-sm">
                        {{-- Previous Page Link --}}
                        <span>
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                    <span class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500 cursor-not-allowed">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @else
                                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                        </svg>
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="flex justify-center items-center h-6 px-2 text-xs font-medium text-zinc-400 dark:text-zinc-400 cursor-default">
                                        {{ $element }}
                                    </span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span class="cursor-default flex justify-center items-center text-xs h-6 px-2 rounded-[6px] font-medium dark:text-white text-zinc-800">
                                                    {{ $page }}
                                                </span>
                                            </span>
                                        @else
                                            <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex items-center justify-center text-xs h-6 px-2 rounded-[6px] text-zinc-400 font-medium dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        <span>
                            @if ($paginator->hasMorePages())
                                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" class="flex justify-center items-center size-6 rounded-[6px] text-zinc-400 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-white/20 hover:text-zinc-800 dark:hover:text-white">
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                    <span class="flex justify-center items-center size-6 rounded-[6px] text-zinc-300 dark:text-zinc-500 cursor-not-allowed">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
