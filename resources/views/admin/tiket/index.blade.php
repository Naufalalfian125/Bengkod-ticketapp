<x-layouts.admin title="Manajemen Tiket - {{ $event->judul }}">
    <div class="container mx-auto p-10">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-semibold">Manajemen Tiket</h1>
                <p class="text-gray-500 mt-1">Event: {{ $event->judul }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.event.index') }}" class="btn btn-ghost">
                    Kembali ke Event
                </a>
                <a href="{{ route('admin.tiket.create', $event) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5v14"></path>
                    </svg>
                    Tambah Tiket
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tikets as $tiket)
                                <tr>
                                    <td>{{ $tikets->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="badge {{ $tiket->tipe === 'premium' ? 'badge-warning' : 'badge-info' }}">
                                            {{ ucfirst($tiket->tipe) }}
                                        </span>
                                    </td>
                                    <td class="font-semibold">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                                    <td>{{ $tiket->stok }}</td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.tiket.edit', [$event, $tiket]) }}" class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.tiket.destroy', [$event, $tiket]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada tiket untuk event ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $tikets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
