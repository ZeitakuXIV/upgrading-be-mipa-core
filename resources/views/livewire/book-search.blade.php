<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-center">📚 Pencarian Buku dengan Livewire</h2>

    <!-- Penjelasan Singkat -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-blue-800 mb-2">💡 Cara Kerja:</h3>
        <ul class="text-sm text-blue-700 space-y-1">
            <li>• Ketik di kotak pencarian untuk mencari buku secara real-time</li>
            <li>• Tidak perlu tekan tombol submit atau reload halaman</li>
            <li>• Livewire otomatis update tampilan ketika kamu mengetik</li>
        </ul>
    </div>

    <!-- Input Pencarian -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Cari Buku (berdasarkan judul):
        </label>
        <input
            type="text"
            wire:model.live="cari"
            placeholder="Ketik judul buku yang ingin dicari..."
            class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >

        <!-- Indikator Loading (opsional) -->
        <div wire:loading class="mt-2 text-sm text-blue-600">
            ⏳ Sedang mencari...
        </div>
    </div>

    <!-- Informasi Hasil -->
    <div class="mb-4">
        @if($cari)
            <p class="text-sm text-gray-600">
                Hasil pencarian untuk: <strong>"{{ $cari }}"</strong> -
                Ditemukan <strong>{{ $books->count() }}</strong> buku
            </p>
        @else
            <p class="text-sm text-gray-600">
                Menampilkan semua buku ({{ $books->count() }} total)
            </p>
        @endif
    </div>

    <!-- Hasil Pencarian -->
    <div class="grid gap-4">
        @forelse($books as $book)
            <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $book->title }}</h3>
                    <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded">{{ $book->year }}</span>
                </div>

                <p class="text-gray-600 text-sm mb-2">
                    <strong>Penulis:</strong> {{ $book->author->name }}
                </p>

                <p class="text-gray-700 text-sm">
                    {{ Str::limit($book->summary, 150) }}
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-gray-500 mb-2">
                    @if($cari)
                        😔 Tidak ada buku yang ditemukan dengan judul "{{ $cari }}"
                    @else
                        📚 Belum ada buku tersedia
                    @endif
                </div>
                @if($cari)
                    <p class="text-sm text-gray-400">Coba gunakan kata kunci yang berbeda</p>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Penjelasan Teknis -->
    <div class="mt-8 bg-gray-50 border rounded-lg p-4">
        <h3 class="font-semibold text-gray-800 mb-2">🔧 Yang Terjadi di Background:</h3>
        <div class="text-sm text-gray-600 space-y-1">
            <p><code class="bg-gray-200 px-2 py-1 rounded">wire:model.live="cari"</code> - Menghubungkan input dengan property <code>$cari</code> di component</p>
            <p><code class="bg-gray-200 px-2 py-1 rounded">updatedCari()</code> - Method yang dipanggil setiap kali user mengetik</p>
            <p><code class="bg-gray-200 px-2 py-1 rounded">render()</code> - Method yang me-refresh tampilan dengan data terbaru</p>
            <p>🔄 Semua proses ini terjadi tanpa reload halaman!</p>
        </div>
    </div>
</div>
