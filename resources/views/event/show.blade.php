@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <a href="{{ route('event.index') }}" class="btn btn-ghost mb-4">
                        ← Kembali ke Daftar Event
                    </a>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Event Info -->
                        <div>
                            @if($event->gambar)
                                <img src="{{ Storage::url($event->gambar) }}" alt="{{ $event->judul }}" class="w-full h-64 object-cover rounded-lg mb-4">
                            @endif
                            <h1 class="text-3xl font-bold mb-4">{{ $event->judul }}</h1>
                            <div class="space-y-2 mb-4">
                                <p><strong>Kategori:</strong> {{ $event->kategori->nama }}</p>
                                <p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                                <p><strong>Tanggal & Waktu:</strong> {{ $event->tanggal_waktu->format('d M Y H:i') }}</p>
                            </div>
                            <div class="divider"></div>
                            <h3 class="text-xl font-semibold mb-2">Deskripsi</h3>
                            <p class="text-gray-700">{{ $event->deskripsi }}</p>
                        </div>

                        <!-- Tiket Form -->
                        <div>
                            <h2 class="text-2xl font-bold mb-4">Pilih Tiket</h2>
                            
                            @if($event->tikets->isEmpty())
                                <div class="alert alert-warning">
                                    <span>Tiket belum tersedia untuk event ini.</span>
                                </div>
                            @else
                                <form action="{{ route('order.store', $event) }}" method="POST" id="orderForm" onsubmit="return validateForm()">
                                    @csrf
                                    <div class="space-y-4" id="tiketContainer">
                                        @foreach($event->tikets as $tiket)
                                            <div class="card bg-base-100 border-2 hover:border-primary transition">
                                                <div class="card-body">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex-1">
                                                            <h3 class="card-title">
                                                                Tiket {{ ucfirst($tiket->tipe) }}
                                                                <span class="badge {{ $tiket->tipe === 'premium' ? 'badge-warning' : 'badge-info' }}">
                                                                    {{ $tiket->tipe }}
                                                                </span>
                                                            </h3>
                                                            <p class="text-2xl font-bold text-primary mt-2">
                                                                Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                                            </p>
                                                            <p class="text-sm text-gray-500 mt-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                                </svg>
                                                                Stok tersedia: {{ $tiket->stok }} tiket
                                                            </p>
                                                        </div>
                                                        <div class="form-control ml-4">
                                                            <label class="label">
                                                                <span class="label-text font-semibold">Jumlah</span>
                                                            </label>
                                                            <input 
                                                                type="number" 
                                                                name="tikets[{{ $loop->index }}][jumlah]" 
                                                                id="jumlah-{{ $tiket->id }}"
                                                                min="0" 
                                                                max="{{ $tiket->stok }}"
                                                                value="0"
                                                                class="input input-bordered w-24 tiket-jumlah text-center"
                                                                data-harga="{{ $tiket->harga }}"
                                                                data-tipe="{{ $tiket->tipe }}"
                                                                data-tiket-id="{{ $tiket->id }}"
                                                                data-stok="{{ $tiket->stok }}"
                                                                onchange="updateTotal()"
                                                                oninput="validateJumlah(this)"
                                                            >
                                                            <input type="hidden" name="tikets[{{ $loop->index }}][id]" value="{{ $tiket->id }}">
                                                            <label class="label">
                                                                <span class="label-text-alt text-error" id="error-{{ $tiket->id }}" style="display: none;"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-6 p-6 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-lg border-2 border-primary/20">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="text-xl font-semibold">Total Pembayaran:</span>
                                            <span class="text-3xl font-bold text-primary" id="totalHarga">Rp 0</span>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-full btn-lg" id="submitBtn" disabled>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            Pesan Tiket Sekarang
                                        </button>
                                        <p class="text-xs text-center text-gray-500 mt-2">
                                            Pastikan jumlah tiket yang dipilih sudah benar sebelum melakukan pemesanan
                                        </p>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateJumlah(input) {
            const jumlah = parseInt(input.value) || 0;
            const stok = parseInt(input.dataset.stok);
            const tiketId = input.dataset.tiketId;
            const errorElement = document.getElementById('error-' + tiketId);
            
            if (jumlah < 0) {
                input.value = 0;
                errorElement.style.display = 'none';
            } else if (jumlah > stok) {
                input.value = stok;
                errorElement.textContent = 'Maksimal ' + stok + ' tiket';
                errorElement.style.display = 'block';
                setTimeout(() => {
                    errorElement.style.display = 'none';
                }, 3000);
            } else {
                errorElement.style.display = 'none';
            }
            
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            const inputs = document.querySelectorAll('.tiket-jumlah');
            const submitBtn = document.getElementById('submitBtn');
            let hasSelection = false;

            inputs.forEach(input => {
                const jumlah = parseInt(input.value) || 0;
                const harga = parseFloat(input.dataset.harga);
                total += jumlah * harga;
                if (jumlah > 0) {
                    hasSelection = true;
                }
            });

            document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
            submitBtn.disabled = !hasSelection || total === 0;
        }

        function validateForm() {
            const inputs = document.querySelectorAll('.tiket-jumlah');
            let hasValidSelection = false;

            inputs.forEach(input => {
                const jumlah = parseInt(input.value) || 0;
                if (jumlah > 0) {
                    hasValidSelection = true;
                }
            });

            if (!hasValidSelection) {
                alert('Silakan pilih minimal 1 tiket untuk dipesan.');
                return false;
            }

            return true;
        }

        // Initialize
        updateTotal();
    </script>
</x-app-layout>
