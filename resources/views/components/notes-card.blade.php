@props(['note'])

<a href="{{ route('notes.edit', $note) }}" class="block">
    <div
        class="rounded-xl shadow-md border bg-white hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 overflow-hidden">

        <div class="p-3"
            style="background-color: {{ $note->color ?? '#4f46e5' }}; color: {{ $note->header_text_color }};">
            <h2 class="text-lg font-semibold truncate">
                {{ $note->title }}
            </h2>
        </div>

        <div class="p-4">
            <p class="text-sm text-gray-600 mt-1 line-clamp-3 min-h-[60px]">
                {{ $note->body }}
            </p>

            <div class="text-xs text-gray-400 mt-4 flex justify-between items-center">
                <span>{{ $note->created_at->format('d M Y') }}</span>

                @if ($note->is_pinned)
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 1a1 1 0 011 1v4.586l2.707-2.707a1 1 0 111.414 1.414L12.414 8H17a1 1 0 110 2h-4.586l2.707 2.707a1 1 0 11-1.414 1.414L11 10.414V15a1 1 0 11-2 0v-4.586l-2.707 2.707a1 1 0 11-1.414-1.414L7.586 10H3a1 1 0 110-2h4.586L4.793 5.293a1 1 0 011.414-1.414L9 6.586V2a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
        </div>
    </div>
</a>
