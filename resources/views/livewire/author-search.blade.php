<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">🔍 Live Author Search</h2>

        <!-- Search Input -->
        <div class="mb-4">
            <input
                type="text"
                wire:model.live="search"
                placeholder="Search authors by name or bio..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- Search Results -->
        <div class="grid gap-4">
            @forelse($authors as $author)
                <div class="bg-white p-4 rounded-lg shadow-sm border cursor-pointer hover:shadow-md transition-shadow"
                     wire:click="selectAuthor({{ $author->id }})">
                    <h3 class="font-semibold text-lg">{{ $author->name }}</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($author->bio, 100) }}</p>
                    <div class="flex gap-4 mt-2 text-sm text-gray-500">
                        <span>📚 {{ $author->books->count() }} books</span>
                        <span>🎬 {{ $author->films->count() }} films</span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    @if($search)
                        No authors found for "{{ $search }}"
                    @else
                        <!-- TODO: Add default message or featured authors -->
                        Type to search for authors...
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    <!-- Selected Author Details -->
    @if($selectedAuthor)
        <div class="mt-8 bg-blue-50 p-6 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold">{{ $selectedAuthor->name }}</h3>
                <button wire:click="clearSelection" class="text-red-500 hover:text-red-700">✕</button>
            </div>

            <p class="text-gray-700 mb-4">{{ $selectedAuthor->bio }}</p>

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Books -->
                <div>
                    <h4 class="font-semibold mb-2">📚 Books ({{ $selectedAuthor->books->count() }})</h4>
                    @foreach($selectedAuthor->books as $book)
                        <div class="bg-white p-3 rounded mb-2">
                            <div class="font-medium">{{ $book->title }}</div>
                            <div class="text-sm text-gray-500">{{ $book->year }}</div>
                        </div>
                    @endforeach
                </div>

                <!-- Films -->
                <div>
                    <h4 class="font-semibold mb-2">🎬 Films ({{ $selectedAuthor->films->count() }})</h4>
                    @foreach($selectedAuthor->films as $film)
                        <div class="bg-white p-3 rounded mb-2">
                            <div class="font-medium">{{ $film->title }}</div>
                            <div class="text-sm text-gray-500">{{ $film->year }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- TODO: Add pagination if dealing with large datasets -->
    <!-- TODO: Add loading states for better UX -->
</div>
