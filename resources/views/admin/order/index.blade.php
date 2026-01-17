<x-layouts.admin title="History Pembelian">
    <div class="p-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">History Pembelian</h1>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Pembeli</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Event</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal Pembelian</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total Harga</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="border-b border-gray-200">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $orders->firstItem() + $loop->index }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $order->event->judul }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $order->order_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <button onclick="document.getElementById('modal-{{ $order->id }}').showModal()" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                                        Detail
                                    </button>
                                    
                                    <!-- Modal -->
                                    <dialog id="modal-{{ $order->id }}" class="modal">
                                        <div class="modal-box">
                                            <h3 class="font-bold text-lg mb-4">Detail Order</h3>
                                            <div class="space-y-2">
                                                <p><strong>User:</strong> {{ $order->user->name }}</p>
                                                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                                                <p><strong>Event:</strong> {{ $order->event->judul }}</p>
                                                <p><strong>Tanggal Order:</strong> {{ $order->order_date->format('d M Y H:i') }}</p>
                                                <div class="divider"></div>
                                                <p class="font-semibold">Tiket yang dibeli:</p>
                                                <ul class="list-disc list-inside">
                                                    @foreach($order->detailOrders as $detail)
                                                        <li>
                                                            {{ $detail->tiket->tipe }} - 
                                                            {{ $detail->jumlah }}x - 
                                                            Rp {{ number_format($detail->subtotal_harga, 0, ',', '.') }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="divider"></div>
                                                <p class="text-lg font-bold">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada order</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
