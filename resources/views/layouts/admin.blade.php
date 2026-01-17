<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100">
    <!-- Sidebar -->
    @include('components.admin.sidebar')
    
    <!-- Main Content -->
    <div class="ml-64 flex flex-col min-h-screen">
        <!-- Top Header Bar -->
        <div class="h-1 bg-gray-400"></div>
        
        <!-- Page Content -->
        <div class="flex-1 bg-white">
            {{ $slot }}
        </div>
    </div>

    {{-- Section untuk script tambahan --}}
    @stack('scripts')
</body>

</html>
