@if ($notes->isEmpty())
    <p class="mt-4 text-gray-600 col-span-full">
        No notes found{{ request('q') ? ' matching your search' : '' }}.
    </p>
@else
    @foreach ($notes as $note)
        <x-notes-card :note="$note" />
    @endforeach
@endif

@if ($notes->hasPages())
    <div class="mt-8 col-span-full" id="notes-pagination">
        {{ $notes->withQueryString()->links() }}
    </div>
@endif
