<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-bold mb-6">History Pembelian Saya</h1>

                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Event</th>
                                    <th>Tanggal Order</th>
                                    <th>Total Harga</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>{{ $orders->firstItem() + $loop->index }}</td>
                                        <td class="font-semibold">{{ $order->event->judul }}</td>
                                        <td>{{ $order->order_date->format('d M Y H:i') }}</td>
                                        <td class="font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <button onclick="document.getElementById('modal-{{ $order->id }}').showModal()" class="btn btn-sm btn-info">
                                                Lihat Detail
                                            </button>
                                            
                                            <!-- Modal -->
                                            <dialog id="modal-{{ $order->id }}" class="modal">
                                                <div class="modal-box">
                                                    <h3 class="font-bold text-lg mb-4">Detail Order</h3>
                                                    <div class="space-y-3">
                                                        <div class="bg-base-200 p-3 rounded-lg">
                                                            <p class="text-sm text-gray-600">Event</p>
                                                            <p class="font-bold text-lg">{{ $order->event->judul }}</p>
                                                        </div>
                                                        <div class="bg-base-200 p-3 rounded-lg">
                                                            <p class="text-sm text-gray-600">Tanggal Order</p>
                                                            <p class="font-semibold">{{ $order->order_date->format('d M Y H:i') }}</p>
                                                        </div>
                                                        <div class="divider"></div>
                                                        <p class="font-semibold text-lg mb-2">Detail Tiket:</p>
                                                        <div class="space-y-2">
                                                            @foreach($order->detailOrders as $detail)
                                                                <div class="flex justify-between items-center p-2 bg-base-200 rounded">
                                                                    <div>
                                                                        <span class="badge {{ $detail->tiket->tipe === 'premium' ? 'badge-warning' : 'badge-info' }}">
                                                                            {{ ucfirst($detail->tiket->tipe) }}
                                                                        </span>
                                                                        <span class="ml-2">{{ $detail->jumlah }}x</span>
                                                                    </div>
                                                                    <span class="font-semibold">Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="divider"></div>
                                                        <div class="flex justify-between items-center p-3 bg-primary/10 rounded-lg">
                                                            <span class="text-lg font-semibold">Total Pembayaran:</span>
                                                            <span class="text-2xl font-bold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-action">
                                                        <form method="dialog">
                                                            <button class="btn">Tutup</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8">
                                            <p class="text-gray-500">Anda belum memiliki pesanan.</p>
                                            <a href="{{ route('event.index') }}" class="btn btn-primary mt-4">Lihat Event</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
