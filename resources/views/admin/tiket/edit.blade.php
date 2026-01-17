<x-layouts.admin title="Edit Tiket">
    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-semibold mb-2">Edit Tiket</h1>
        <p class="text-gray-500 mb-6">Event: {{ $event->judul }}</p>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('admin.tiket.update', [$event, $tiket]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Tipe Tiket</span>
                        </label>
                        <select name="tipe" class="select select-bordered w-full @error('tipe') select-error @enderror" required>
                            <option value="">Pilih Tipe</option>
                            <option value="reguler" {{ old('tipe', $tiket->tipe) == 'reguler' ? 'selected' : '' }}>Reguler</option>
                            <option value="premium" {{ old('tipe', $tiket->tipe) == 'premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                        @error('tipe')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Harga</span>
                        </label>
                        <input type="number" name="harga" value="{{ old('harga', $tiket->harga) }}" placeholder="Masukkan harga tiket" class="input input-bordered w-full @error('harga') input-error @enderror" min="0" step="1000" required>
                        @error('harga')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Stok</span>
                        </label>
                        <input type="number" name="stok" value="{{ old('stok', $tiket->stok) }}" placeholder="Masukkan jumlah stok" class="input input-bordered w-full @error('stok') input-error @enderror" min="0" required>
                        @error('stok')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mt-6">
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.tiket.index', $event) }}" class="btn btn-ghost">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
