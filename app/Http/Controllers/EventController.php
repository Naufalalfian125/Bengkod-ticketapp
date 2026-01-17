<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the events for users.
     */
    public function index(Request $request): View
    {
        // Tampilkan semua event yang belum lewat (tanggal >= sekarang)
        $query = Event::with(['kategori', 'tikets'])
            ->where('tanggal_waktu', '>=', now()->subDay()); // Beri toleransi 1 hari

        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%');
            });
        }

        $events = $query->latest('tanggal_waktu')->paginate(12);
        $kategoris = Kategori::all();

        return view('event.index', compact('events', 'kategoris'));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event): View
    {
        $event->load(['kategori', 'tikets']);
        return view('event.show', compact('event'));
    }
}
