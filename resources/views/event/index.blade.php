@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form method="GET" action="{{ route('event.index') }}" class="flex gap-4 flex-wrap">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari event..." class="input input-bordered w-full">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <select name="kategori" class="select select-bordered w-full">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cari</button>
                    @if(request()->has('search') || request()->has('kategori'))
                        <a href="{{ route('event.index') }}" class="btn btn-ghost">Reset</a>
                    @endif
                </form>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error mb-4">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Event Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="card bg-base-100 shadow-xl">
                        @if($event->gambar)
                            <figure>
                                <img src="{{ Storage::url($event->gambar) }}" alt="{{ $event->judul }}" class="w-full h-48 object-cover">
                            </figure>
                        @endif
                        <div class="card-body">
                            <h2 class="card-title">{{ $event->judul }}</h2>
                            <p class="text-sm text-gray-500">{{ $event->kategori->nama }}</p>
                            <p class="text-sm">{{ Str::limit($event->deskripsi, 100) }}</p>
                            <div class="text-sm space-y-1">
                                <p><strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                                <p><strong>Tanggal:</strong> {{ $event->tanggal_waktu->format('d M Y H:i') }}</p>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <a href="{{ route('event.show', $event) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Tidak ada event yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
