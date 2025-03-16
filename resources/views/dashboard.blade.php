<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        @include('shared.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            @include('shared.navbar')
            
            <!-- Content Area -->
            <div class="p-5">
                <h2 class="text-2xl font-bold">Welcome to Your Dashboard</h2>
                <p class="mt-2 text-gray-600">Manage your data and settings here.</p>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('menu-btn').addEventListener('click', function() {
            const sidebar = document.querySelector('div.w-64');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>
</html>
