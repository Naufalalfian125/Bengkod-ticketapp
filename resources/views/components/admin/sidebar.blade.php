<div class="w-64 bg-gray-300 h-screen flex flex-col fixed left-0 top-0 z-50">
    <!-- Logo Section -->
    <div class="w-full bg-gray-200 flex items-center justify-center p-6 border-b border-gray-300">
        <span class="text-gray-700 font-medium text-lg">Logo</span>
    </div>

    <!-- Menu Items -->
    <ul class="flex-1 mt-4 px-4 space-y-2">
        <!-- Dashboard Item -->
        <li>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 text-gray-900 font-semibold' : 'text-gray-700 hover:bg-gray-200' }}">
                <!-- Home icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 19h3v-5q0-.425.288-.712T10 13h4q.425 0 .713.288T15 14v5h3v-9l-6-4.5L6 10zm-2 0v-9q0-.475.213-.9t.587-.7l6-4.5q.525-.4 1.2-.4t1.2.4l6 4.5q.375.275.588.7T20 10v9q0 .825-.588 1.413T18 21h-4q-.425 0-.712-.288T13 20v-5h-2v5q0 .425-.288.713T10 21H6q-.825 0-1.412-.587T4 19m8-6.75" />
                </svg>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>

        <!-- Kategori item -->
        <li>
            <a href="{{ route('admin.kategori.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.kategori.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'text-gray-700 hover:bg-gray-200' }}">
                <!-- icon Kategori (Grid/Squares) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span class="text-sm">Manajemen Kategori</span>
            </a>
        </li>

        <!-- Event item -->
        <li>
            <a href="{{ route('admin.event.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.event.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'text-gray-700 hover:bg-gray-200' }}">
                <!-- icon Event (Ticket/Calendar) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 5v2m0 4v2m0 4v2M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4V7a2 2 0 0 1 2-2"></path>
                </svg>
                <span class="text-sm">Manajemen Event</span>
            </a>
        </li>

        <!-- History item -->
        <li>
            <a href="{{ route('admin.order.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.order.*') ? 'bg-gray-200 text-gray-900 font-semibold' : 'text-gray-700 hover:bg-gray-200' }}">
                <!-- Clock/History icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span class="text-sm">History Pembelian</span>
            </a>
        </li>
    </ul>

    <!-- Logout Button -->
    <div class="p-4 border-t border-gray-400 mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-100 border border-red-300 rounded-lg text-red-700 hover:bg-red-200 transition-colors font-medium">
                <!-- Logout icon (Door/Exit) -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 17v-2h4v-2h-4v-2l-5 3l5 3m9-12H5q-.825 0-1.413.588T3 7v10q0 .825.587 1.413T5 19h14q.825 0 1.413-.587T21 17v-3h-2v3H5V7h14v3h2V7q0-.825-.587-1.413T19 5z" />
                </svg>
                <span class="text-sm">Logout</span>
            </button>
        </form>
    </div>
</div>