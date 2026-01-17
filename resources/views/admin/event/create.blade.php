<x-layouts.admin title="Tambah Event">
    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-semibold mb-6">Tambah Event</h1>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Judul Event</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul event" class="input input-bordered w-full @error('judul') input-error @enderror" required>
                        @error('judul')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Kategori</span>
                        </label>
                        <select name="kategori_id" class="select select-bordered w-full @error('kategori_id') select-error @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Deskripsi</span>
                        </label>
                        <textarea name="deskripsi" rows="5" placeholder="Masukkan deskripsi event" class="textarea textarea-bordered w-full @error('deskripsi') textarea-error @enderror" required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Lokasi</span>
                        </label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Masukkan lokasi event" class="input input-bordered w-full @error('lokasi') input-error @enderror" required>
                        @error('lokasi')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Tanggal & Waktu</span>
                        </label>
                        <input type="datetime-local" name="tanggal_waktu" value="{{ old('tanggal_waktu') }}" class="input input-bordered w-full @error('tanggal_waktu') input-error @enderror" required>
                        @error('tanggal_waktu')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text">Gambar</span>
                        </label>
                        <input type="file" name="gambar" accept="image/*" class="file-input file-input-bordered w-full @error('gambar') file-input-error @enderror">
                        @error('gambar')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mt-6">
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.event.index') }}" class="btn btn-ghost">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
