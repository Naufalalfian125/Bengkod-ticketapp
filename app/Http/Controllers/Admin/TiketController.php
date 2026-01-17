<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Event $event): View
    {
        $tikets = Tiket::where('event_id', $event->id)->latest()->paginate(10);
        return view('admin.tiket.index', compact('event', 'tikets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event): View
    {
        return view('admin.tiket.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'tipe' => 'required|in:reguler,premium',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $validated['event_id'] = $event->id;

        Tiket::create($validated);

        return redirect()->route('admin.tiket.index', $event)
            ->with('success', 'Tiket berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Tiket $tiket): View
    {
        return view('admin.tiket.edit', compact('event', 'tiket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, Tiket $tiket): RedirectResponse
    {
        $validated = $request->validate([
            'tipe' => 'required|in:reguler,premium',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $tiket->update($validated);

        return redirect()->route('admin.tiket.index', $event)
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Tiket $tiket): RedirectResponse
    {
        $tiket->delete();

        return redirect()->route('admin.tiket.index', $event)
            ->with('success', 'Tiket berhasil dihapus.');
    }
}
