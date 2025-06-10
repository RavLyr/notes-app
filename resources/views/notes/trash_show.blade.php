<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ noteColor: '{{ $note->color ?? '#6b7280' }}' }">

                <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                    <div class="p-4 flex justify-between items-center"
                        :style="`background: linear-gradient(to right, ${noteColor}, #374151)`">

                        <a href="{{ url()->previous() }}"
                            class="flex items-center text-white font-bold opacity-80 hover:opacity-100 transition">
                            <svg class="w-4 h-4 mr-2" …>…</svg> Back
                        </a>

                        <div class="flex space-x-2">
                            <form action="{{ route('notes.restore', $note->id) }}" method="POST">
                                @csrf
                                @method('PUT') 
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md text-sm transition">
                                    Restore
                                </button>
                            </form>

                            <form action="{{ route('notes.forceDelete', $note->id) }}" method="POST"
                                onsubmit="return confirm('This action is IRREVERSIBLE. Delete permanently?');">
                                @csrf
                                @method('DELETE') 
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md text-sm transition">
                                    Delete Forever
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="p-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $note->title }}</h1>
                        <p class="text-sm text-gray-500 mb-4">In Trash—will be deleted permanently after 30 days.</p>
                        <div class="prose max-w-none text-gray-800 whitespace-pre-wrap">{{ $note->body }}</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
