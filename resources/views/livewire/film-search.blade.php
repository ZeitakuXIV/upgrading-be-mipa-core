<div class="max-w-4xl mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-center">🎬 Pencarian Film dengan Livewire</h2>

    <!-- Penjelasan Singkat -->
    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-purple-800 mb-2">💡 Cara Kerja (Simple Implementation):</h3>
        <ul class="text-sm text-purple-700 space-y-1">
            <li>• Ketik di kotak pencarian untuk mencari film secara real-time</li>
            <li>• Tidak perlu tekan tombol submit atau reload halaman</li>
            <li>• Livewire otomatis update tampilan ketika kamu mengetik</li>
            <li>• <strong>Pattern sama seperti BookSearch</strong> - simple dan mudah dipahami</li>
        </ul>
    </div>

    <!-- Input Pencarian -->
    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Cari Film (berdasarkan judul):
        </label>
        <input
            type="text"
            wire:model.live="cari"
            placeholder="Ketik judul film yang ingin dicari..."
            class="w-full px-4 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
        >

        <!-- Indikator Loading (opsional) -->
        <div wire:loading class="mt-2 text-sm text-purple-600">
            ⏳ Sedang mencari...
        </div>
    </div>

    <!-- Hasil Pencarian -->
    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold">
                @if($cari)
                    Hasil pencarian "{{ $cari }}" ({{ count($films) }} film)
                @else
                    Semua Film ({{ count($films) }} film)
                @endif
            </h3>
            @if($cari)
                <button 
                    wire:click="$set('cari', '')"
                    class="text-sm text-purple-600 hover:text-purple-800"
                >
                    ✕ Clear
                </button>
            @endif
        </div>

        @if(count($films) > 0)
            <!-- Grid Layout untuk Film -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($films as $film)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <h4 class="font-semibold text-gray-900 mb-2">
                            🎬 {{ $film->title }}
                        </h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><strong>Tahun:</strong> {{ $film->year }}</p>
                            <p><strong>Sutradara/Author:</strong> {{ $film->author->name }}</p>
                            @if($film->synopsis)
                                <p class="text-gray-700 text-xs mt-2">
                                    {{ \Illuminate\Support\Str::limit($film->synopsis, 100) }}
                                </p>
                            @endif
                        </div>
                        
                        <!-- Link ke detail film -->
                        <div class="mt-3">
                            <a 
                                href="{{ route('films.show', $film->id) }}"
                                class="text-purple-600 hover:text-purple-800 text-sm font-medium"
                            >
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Pesan jika tidak ada hasil -->
            <div class="text-center py-8 text-gray-500">
                @if($cari)
                    <div class="mb-4">
                        <div class="text-4xl mb-2">🔍</div>
                        <p class="text-lg font-medium">Film tidak ditemukan</p>
                        <p class="text-sm">Coba kata kunci yang berbeda</p>
                    </div>
                @else
                    <div class="mb-4">
                        <div class="text-4xl mb-2">🎬</div>
                        <p class="text-lg font-medium">Belum ada film</p>
                        <p class="text-sm">Database film masih kosong</p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Learning Notes untuk Students -->
    <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-4">
        <h3 class="font-semibold text-gray-800 mb-2">🔧 Implementation Notes:</h3>
        <div class="text-sm text-gray-700 space-y-1">
            <p>• <strong>Component:</strong> <code>app/Livewire/FilmSearch.php</code></p>
            <p>• <strong>View:</strong> <code>resources/views/livewire/film-search.blade.php</code></p>
            <p>• <strong>Property:</strong> <code>public $cari = '';</code> - reactive property</p>
            <p>• <strong>Wire Model:</strong> <code>wire:model.live="cari"</code> - real-time binding</p>
            <p>• <strong>Pattern:</strong> Same as BookSearch - simple dan educational</p>
        </div>
    </div>
</div>
