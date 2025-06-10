<div x-data="searchComponent()" x-init="init()" class="relative w-full max-w-md">
    <div class="relative">
        <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
            </svg>
        </span>

        <input x-ref="input" type="text" placeholder="Search notes..."
            class="w-full border rounded-md py-2 ps-10 pe-4 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
            @input="onType" />
    </div>
</div>

<script>
    function searchComponent() {
        return {
            context: '{{ request()->routeIs('notes.archived') ? 'archived' : (request()->routeIs('notes.trash') ? 'trash' : 'index') }}',
            query: '',
            debounceTimer: null,

            init() {
                this.query = this.$refs.input.value.trim();
                this.bindPagination(); // bind initial pagination links
            },

            onType() {
                clearTimeout(this.debounceTimer);
                this.query = this.$refs.input.value;

                this.debounceTimer = setTimeout(() => {
                    this.fetchResults(
                        `/search/notes?q=${encodeURIComponent(this.query)}&context=${this.context}`);
                }, 300);
            },

            fetchResults(url) {
                fetch(url)
                    .then(r => r.text())
                    .then(html => {
                        document.getElementById('notes-container').innerHTML = html;
                        this.bindPagination();
                    });
            },

            bindPagination() {
                // ubah semua link di pagination menjadi AJAX
                document.querySelectorAll('#notes-pagination a').forEach(link => {
                    link.addEventListener('click', e => {
                        e.preventDefault();
                        this.fetchResults(link.getAttribute('href'));
                    });
                });
            }
        }
    }
</script>
