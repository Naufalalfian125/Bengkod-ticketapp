<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;    // WAJIB: Agar baris 18 tidak error
use App\Models\Order;    // WAJIB: Agar baris 20 tidak error
use App\Models\Kategori; // Opsional: Jika ingin menulis simpel seperti Event
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Baris 18
        $totalEvents = Event::count(); 
        
        // Baris 19 (Sudah benar karena pakai Path lengkap)
        $totalCategories = \App\Models\Kategori::count(); 
        
        // Baris 20
        $totalOrders = Order::count(); 

        // Baris 21 (Akan error jika file resources/views/admin/dashboard.blade.php belum dibuat)
        return view('admin.dashboard', compact('totalEvents', 'totalCategories', 'totalOrders'));
    }
}