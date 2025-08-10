<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Demo - Pengenalan Reactive Components</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation -->
        <nav class="mb-8">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('welcome') }}" class="text-blue-500 hover:text-blue-700">🏠 Home</a>
                    <a href="{{ route('authors.index') }}" class="text-blue-500 hover:text-blue-700">👨‍💼 Authors (MVC)</a>
                    <a href="{{ route('books.index') }}" class="text-blue-500 hover:text-blue-700">📚 Books (MVC)</a>
                    <a href="{{ route('films.index') }}" class="text-blue-500 hover:text-blue-700">🎬 Films (MVC)</a>
                    <a href="{{ route('livewire.demo') }}" class="text-purple-500 hover:text-purple-700 font-semibold">⚡ Livewire Demo</a>
                </div>
            </div>
        </nav>

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">⚡ Pengenalan Laravel Livewire</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Belajar membuat komponen reaktif dengan Laravel Livewire.
                Tidak perlu reload halaman, semua interaksi terjadi secara real-time!
            </p>
        </div>

        <!-- Penjelasan Livewire -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-blue-800 mb-4">🤔 Apa itu Livewire?</h2>
            <div class="grid md:grid-cols-2 gap-6 text-blue-700">
                <div>
                    <h3 class="font-semibold mb-2">Konsep Dasar:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>• Framework full-stack untuk Laravel</li>
                        <li>• Membuat interface dinamis dengan PHP (bukan JavaScript!)</li>
                        <li>• Reactive: perubahan data = perubahan tampilan otomatis</li>
                        <li>• Tidak perlu page reload untuk interaksi</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-2">Keuntungan:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>• Tetap di ekosistem Laravel (PHP + Blade)</li>
                        <li>• Tidak perlu belajar JavaScript framework</li>
                        <li>• Real-time updates tanpa AJAX manual</li>
                        <li>• Mudah maintain dan debug</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-8">
            <div class="flex border-b bg-white rounded-t-lg">
                <button onclick="showTab('books')"
                        class="tab-button px-6 py-3 border-b-2 border-blue-500 text-blue-600 font-semibold"
                        id="books-tab">
                    📚 Contoh: Pencarian Buku
                </button>
                <button onclick="showTab('films')"
                        class="tab-button px-6 py-3 border-b-2 border-transparent text-gray-500 hover:text-gray-700"
                        id="films-tab">
                    🎬 Challenge: Pencarian Film
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-b-lg rounded-tr-lg shadow-sm p-6">
            <!-- Books Tab -->
            <div id="books-content" class="tab-content">
                <div class="mb-4 p-4 bg-green-50 rounded-lg">
                    <h3 class="font-semibold text-green-800 mb-2">🎯 Yang Dipelajari:</h3>
                    <ul class="text-sm text-green-700 space-y-1">
                        <li>• <code>wire:model.live</code> - Data binding real-time</li>
                        <li>• <code>updatedPropertyName()</code> - Lifecycle hooks</li>
                        <li>• Method <code>render()</code> - Me-refresh tampilan</li>
                        <li>• Query conditional dengan <code>->when()</code></li>
                    </ul>
                </div>
                @livewire('book-search')
            </div>

            <!-- Films Tab -->
            <div id="films-content" class="tab-content hidden">
                @livewire('film-search')
            </div>
        </div>

        <!-- Learning Summary -->
        <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">📚 Rangkuman Pembelajaran</h3>
            <div class="grid md:grid-cols-3 gap-6 text-sm text-gray-700">
                <div>
                    <h4 class="font-semibold mb-2 text-gray-800">Directive Penting:</h4>
                    <ul class="space-y-1">
                        <li>• <code class="bg-gray-200 px-1 rounded">wire:model</code> - Binding data</li>
                        <li>• <code class="bg-gray-200 px-1 rounded">wire:click</code> - Event handling</li>
                        <li>• <code class="bg-gray-200 px-1 rounded">wire:loading</code> - Loading state</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2 text-gray-800">Lifecycle Methods:</h4>
                    <ul class="space-y-1">
                        <li>• <code class="bg-gray-200 px-1 rounded">mount()</code> - Initialize</li>
                        <li>• <code class="bg-gray-200 px-1 rounded">updated*()</code> - Property changes</li>
                        <li>• <code class="bg-gray-200 px-1 rounded">render()</code> - View update</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2 text-gray-800">Best Practices:</h4>
                    <ul class="space-y-1">
                        <li>• Gunakan <code class="bg-gray-200 px-1 rounded">->when()</code> untuk query conditional</li>
                        <li>• Eager loading dengan <code class="bg-gray-200 px-1 rounded">->with()</code></li>
                        <li>• Beri feedback ke user (loading, empty state)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-yellow-800 mb-3">🚀 Langkah Selanjutnya</h3>
            <div class="text-sm text-yellow-700 space-y-2">
                <p><strong>1. Selesaikan Challenge Film:</strong> Implement method yang belum jadi di FilmSearch component</p>
                <p><strong>2. Buat Component Baru:</strong> Coba buat component Author search sendiri</p>
                <p><strong>3. Tambahkan Fitur:</strong> Pagination, sorting, atau form create/edit</p>
                <p><strong>4. Explore Advanced:</strong> File upload, validation, atau real-time notifications</p>
            </div>
        </div>
    </div>

    @livewireScripts

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.add('hidden'));

            // Remove active state from all tabs
            const tabs = document.querySelectorAll('.tab-button');
            tabs.forEach(tab => {
                tab.classList.remove('border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab content
            document.getElementById(`${tabName}-content`).classList.remove('hidden');

            // Add active state to selected tab
            const activeTab = document.getElementById(`${tabName}-tab`);
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-blue-500', 'text-blue-600');
        }
    </script>
</body>
</html>
