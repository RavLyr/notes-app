<x-app-layout>  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Your Notes</h1>

                    <a href="{{ route('notes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create New Note</a>
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if ($notes->isEmpty())
                        <p class="mt-4 text-gray-600">No notes found.</p>
                    @else
                        <ul class="mt-4 space-y-4">
                            @foreach ($notes as $note)
                                <li class="border p-4 rounded shadow hover:shadow-md transition">
                                    <h2 class="text-xl font-semibold">{{ $note->title }}</h2>
                                    <p class="mt-2 text-gray-700">{{ Str::limit($note->body, 100) }}</p>

                                    <div class="mt-4 space-x-2">
                                        <a href="{{ route('notes.edit', $note) }}" class="text-blue-500 hover:underline">Edit</a>

                                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this note?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>