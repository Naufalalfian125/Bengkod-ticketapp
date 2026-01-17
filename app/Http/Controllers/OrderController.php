<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\Event;
use App\Models\Order;
use App\Models\Tiket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index(): View
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['event', 'detailOrders.tiket'])
            ->latest()
            ->paginate(10);

        return view('order.index', compact('orders'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        // Filter hanya tiket dengan jumlah > 0
        $tiketsData = array_filter($request->tikets ?? [], function($tiket) {
            return isset($tiket['jumlah']) && (int)$tiket['jumlah'] > 0;
        });

        if (empty($tiketsData)) {
            return back()->with('error', 'Silakan pilih minimal 1 tiket untuk dipesan.');
        }

        $validated = $request->validate([
            'tikets' => 'required|array',
            'tikets.*.id' => 'required|exists:tikets,id',
            'tikets.*.jumlah' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $detailOrders = [];

            foreach ($validated['tikets'] as $tiketData) {
                // Skip jika jumlah 0
                if ((int)$tiketData['jumlah'] <= 0) {
                    continue;
                }

                $tiket = Tiket::findOrFail($tiketData['id']);

                if ($tiket->event_id !== $event->id) {
                    throw new \Exception('Tiket tidak sesuai dengan event.');
                }

                $jumlah = (int)$tiketData['jumlah'];

                if ($tiket->stok < $jumlah) {
                    throw new \Exception('Stok tiket ' . ucfirst($tiket->tipe) . ' tidak mencukupi. Stok tersedia: ' . $tiket->stok);
                }

                $subtotal = $tiket->harga * $jumlah;
                $totalHarga += $subtotal;

                $detailOrders[] = [
                    'tiket_id' => $tiket->id,
                    'jumlah' => $jumlah,
                    'subtotal_harga' => $subtotal,
                ];

                // Update stok
                $tiket->decrement('stok', $jumlah);
            }

            if (empty($detailOrders)) {
                throw new \Exception('Silakan pilih minimal 1 tiket untuk dipesan.');
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'event_id' => $event->id,
                'order_date' => now(),
                'total_harga' => $totalHarga,
            ]);

            foreach ($detailOrders as $detail) {
                DetailOrder::create([
                    'order_id' => $order->id,
                    'tiket_id' => $detail['tiket_id'],
                    'jumlah' => $detail['jumlah'],
                    'subtotal_harga' => $detail['subtotal_harga'],
                ]);
            }

            DB::commit();

            return redirect()->route('order.index')
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
