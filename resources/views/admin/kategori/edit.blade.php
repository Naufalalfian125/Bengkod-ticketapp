<x-layouts.admin title="Edit Kategori">
    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-semibold mb-6">Edit Kategori</h1>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Nama Kategori</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" placeholder="Masukkan nama kategori" class="input input-bordered w-full @error('nama') input-error @enderror" required>
                        @error('nama')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control mt-6">
                        <div class="flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.kategori.index') }}" class="btn btn-ghost">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
