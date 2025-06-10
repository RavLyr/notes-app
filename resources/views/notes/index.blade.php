<x-app-layout>
    <x-slot name="header">
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center justify-between gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Notes') }}
                </h2>

                <div class="flex flex-col sm:flex-row flex-wrap items-start sm:items-center gap-4 w-full sm:w-auto">
                    <nav class="flex flex-wrap gap-2 sm:gap-4" aria-label="Tabs">
                        <a href="{{ route('notes.index') }}"
                            class="px-3 py-2 font-medium text-sm rounded-md whitespace-nowrap {{ request()->routeIs('notes.index') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                            All Notes
                        </a>
                        <a href="{{ route('notes.archived') }}"
                            class="px-3 py-2 font-medium text-sm rounded-md whitespace-nowrap {{ request()->routeIs('notes.archived') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                            Archived
                        </a>
                        <a href="{{ route('notes.trash') }}"
                            class="px-3 py-2 font-medium text-sm rounded-md whitespace-nowrap {{ request()->routeIs('notes.trash') ? 'bg-blue-100 text-blue-700' : 'text-gray-500 hover:text-gray-700' }}">
                            Trash
                        </a>
                    </nav>

                    <div class="w-full sm:w-auto">
                        <x-search-bar />
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Your Notes</h1>

                    <div id="notes-container"
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @if ($notes->isEmpty())
                            <p class="mt-4 text-gray-600 col-span-full">No notes found in this section.</p>
                        @else
                            @foreach ($notes as $note)
                                <x-notes-card :note="$note" />
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('notes.create') }}" title="Create New Note"
        class="fixed bottom-8 right-8 w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg hover:bg-blue-700 transition-colors duration-300">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
        </svg>
    </a>
</x-app-layout>
