<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8" x-data="{
            noteColor: '{{ old('color', '#818cf8') }}',
            showPalette: false
        }">

            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <div class="bg-white shadow-xl rounded-lg overflow-hidden">

                    <div class="p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center"
                        :style="`background: linear-gradient(to right, ${noteColor}, #9333ea)`">
                        <a href="{{ route('notes.index') }}"
                            class="flex items-center text-white font-bold opacity-80 hover:opacity-100 transition mb-2 sm:mb-0">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back
                        </a>
                        <button type="submit"
                            class="bg-blue-600 text-white font-bold py-2 px-4 rounded-md text-sm hover:bg-blue-700 transition">
                            Save Note
                        </button>
                    </div>

                    <div class="p-6 space-y-6">
                        <input type="text" name="title" id="title" placeholder="Note Title"
                            value="{{ old('title') }}"
                            class="w-full text-3xl font-bold border-none focus:ring-0 p-0 mb-4" required />

                        <textarea name="body" id="body" rows="10" placeholder="Add your note..."
                            class="w-full text-gray-700 border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition">
              {{ old('body') }}
            </textarea>

                        <input type="hidden" name="color" :value="noteColor">

                        <div class="relative">
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
                                class="absolute bottom-full left-0 mb-2 p-2 bg-white rounded-lg shadow-lg flex flex-wrap gap-2 border"
                                x-transition>
                                @php($colors = ['#f87171', '#fb923c', '#facc15', '#4ade80', '#38bdf8', '#818cf8', '#c084fc'])
                                @foreach ($colors as $color)
                                    <button type="button" @click="noteColor = '{{ $color }}'"
                                        class="w-8 h-8 rounded-full cursor-pointer transform hover:scale-110"
                                        :class="{ 'ring-2 ring-offset-2 ring-blue-500': noteColor === '{{ $color }}' }"
                                        style="background-color: {{ $color }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
