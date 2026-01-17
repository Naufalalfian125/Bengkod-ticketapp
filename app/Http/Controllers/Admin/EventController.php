<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $events = Event::with('kategori')->latest()->paginate(10);
        return view('admin.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kategoris = Kategori::all();
        return view('admin.event.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_waktu' => 'required|date|after:now',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('events', 'public');
        }

        $validated['user_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('admin.event.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        $kategoris = Kategori::all();
        return view('admin.event.edit', compact('event', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'tanggal_waktu' => 'required|date|after:now',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($event->gambar) {
                Storage::disk('public')->delete($event->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('events', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.event.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        // Delete image if exists
        if ($event->gambar) {
            Storage::disk('public')->delete($event->gambar);
        }

        $event->delete();

        return redirect()->route('admin.event.index')
            ->with('success', 'Event berhasil dihapus.');
    }
}
