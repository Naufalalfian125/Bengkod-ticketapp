@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.admin title="Manajemen Event">
    <div class="container mx-auto p-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-semibold">Manajemen Event</h1>
            <a href="{{ route('admin.event.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5v14"></path>
                </svg>
                Tambah Event
            </a>
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
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Tanggal & Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>{{ $events->firstItem() + $loop->index }}</td>
                                    <td>
                                        @if($event->gambar)
                                            <img src="{{ Storage::url($event->gambar) }}" alt="{{ $event->judul }}" class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-400 text-xs">No Image</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="font-semibold">{{ $event->judul }}</td>
                                    <td>{{ $event->kategori->nama }}</td>
                                    <td>{{ $event->lokasi }}</td>
                                    <td>{{ $event->tanggal_waktu->format('d M Y H:i') }}</td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="{{ route('admin.event.edit', $event) }}" class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                            <a href="{{ route('admin.tiket.index', $event) }}" class="btn btn-sm btn-info">
                                                Tiket
                                            </a>
                                            <form action="{{ route('admin.event.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada event</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
