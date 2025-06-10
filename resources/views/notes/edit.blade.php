<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8" x-data="{
            noteColor: '{{ old('color', $note->color) }}',
            isPinned: {{ $note->is_pinned ? 'true' : 'false' }},
            isArchived: {{ $note->is_archived ? 'true' : 'false' }},
            showPalette: false
        }">

            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <form x-ref="deleteForm" action="{{ route('notes.destroy', $note) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
                <form action="{{ route('notes.update', $note) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-4 flex justify-between items-center"
                        :style="`background: linear-gradient(to right, ${noteColor}, #9333ea)`">
                        <a href="{{ url()->previous() }}"
                            class="flex items-center text-white font-bold opacity-80 hover:opacity-100 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Back
                        </a>

                        <div class="flex space-x-4">
                            <button type="button"
                                @click="
                    fetch('{{ route('notes.togglePin', $note) }}', {
                      method: 'POST',
                      headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                      }
                    })
                    .then(r => r.json())
                    .then(d => {
                      isPinned = d.is_pinned;
                      Toastify({ text: d.message, duration: 3000, gravity:'bottom', position:'right', backgroundColor:'#38bdf8' }).showToast();
                    })
                  "
                                :title="isPinned ? 'Unpin Note' : 'Pin Note'" class="text-white hover:opacity-100">
                                <svg class="w-5 h-5" :class="isPinned ? 'text-yellow-400' : 'opacity-80'"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 1a1 1 0 011 1v4.586l2.707-2.707a1 1 0 111.414 1.414L12.414 8H17a1 1 0 110 2h-4.586l2.707 2.707a1 1 0 11-1.414 1.414L11 10.414V15a1 1 0 11-2 0v-4.586l-2.707 2.707a1 1 0 11-1.414-1.414L7.586 10H3a1 1 0 110-2h4.586L4.793 5.293a1 1 0 011.414-1.414L9 6.586V2a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <button type="button"
                                @click="
                    fetch('{{ route('notes.toggleArchive', $note) }}', {
                      method: 'POST',
                      headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                      }
                    })
                    .then(r => r.json())
                    .then(d => {
                      isArchived = d.is_archived;
                      Toastify({ text: d.message, duration: 3000, gravity:'bottom', position:'right', backgroundColor:'#38bdf8' }).showToast();
                    })
                  "
                                :title="isArchived ? 'Unarchive Note' : 'Archive Note'"
                                class="text-white hover:opacity-100">
                                <svg class="w-5 h-5" :class="isArchived ? 'text-green-400' : 'opacity-80'"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </button>

                            <button type="button" @click="if(confirm('Delete this note?')) $refs.deleteForm.submit()"
                                title="Delete Note" class="text-white hover:text-red-400">
                                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <button type="submit"
                                class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition">
                                Save Changes
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <input type="text" name="title" placeholder="Note Title"
                            value="{{ old('title', $note->title) }}"
                            class="w-full text-3xl font-bold border-none focus:ring-0 mb-4" />

                        <textarea name="body" rows="10" placeholder="Add your note..."
                            class="w-full text-gray-700 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 p-3">{{ old('body', $note->body) }}</textarea>

                        <input type="hidden" name="color" x-model="noteColor" />
                    </div>

                    <div class="relative p-4">
                        <button type="button" @click="showPalette = !showPalette"
                            class="flex items-center text-sm font-medium text-gray-600 hover:text-black">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01">
                                </path>
                            </svg>
                            Change Color
                        </button>

                        <div x-show="showPalette" @click.away="showPalette = false"
                            class="absolute bottom-full left-0 mb-2 p-2 bg-white rounded-lg shadow-lg flex space-x-2 border"
                            x-transition>
                            @php($colors = ['#f87171', '#fb923c', '#facc15', '#4ade80', '#38bdf8', '#818cf8', '#c084fc'])
                            @foreach ($colors as $color)
                                <button type="button" @click="noteColor = '{{ $color }}'"
                                    class="w-8 h-8 rounded-full cursor-pointer transition transform hover:scale-110"
                                    :class="{ 'ring-2 ring-offset-2 ring-blue-500': noteColor === '{{ $color }}' }"
                                    style="background-color: {{ $color }}">
                                </button>
                            @endforeach
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</x-app-layout>
