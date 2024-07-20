<?php
include 'connection.php';
$current_user = isset($_SESSION['email']) ? $_SESSION['email'] : 'Guest';
?>

<div class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true" id="mobile-menu" style="display: none;">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-gray-800">
        <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" onclick="toggleMobileMenu()">
                <span class="sr-only">Close sidebar</span>
                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-shrink-0 flex items-center px-4 py-4 bg-gray-900">
            <span class="text-white font-bold uppercase">Sidebar</span>
        </div>
        <div class="flex-1 h-0 overflow-y-auto">
            <nav class="px-2 py-4 bg-gray-800">
                <a href="contents.php" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Billing
                </a>
                <a href="inventory.php" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Inventory
                </a>
                <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Settings
                </a>
            </nav>
        </div>
        <div class="px-4 py-4 bg-gray-900 text-white">
            <span>Logged in as: <?php echo htmlspecialchars($current_user); ?></span>
            <form method="POST" action="logout.php">
                <button type="submit" name="logout" class="block mt-2 text-red-500 hover:underline">Logout</button>
            </form>
        </div>
    </div>
    <div class="flex-shrink-0 w-14" aria-hidden="true"></div>
</div>

<div class="hidden md:flex md:fixed md:inset-y-0 md:w-64 md:flex-col bg-gray-800">
    <div class="flex items-center justify-center h-16 bg-gray-900">
        <span class="text-white font-bold uppercase">Sidebar</span>
    </div>
    <div class="flex flex-col flex-1 overflow-y-auto">
        <nav class="flex-1 px-2 py-4 bg-gray-800">
            <a href="contents.php" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                Billing
            </a>
            <a href="inventory.php" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Inventory
            </a>
            <a href="#" class="flex items-center px-4 py-2 mt-2 text-gray-100 hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Settings
            </a>
        </nav>
    </div>
    <div class="px-4 py-4 bg-gray-900 text-white">
        <span>Logged in as: <?php echo htmlspecialchars($current_user); ?></span>
        <form method="POST" action="logout.php">
            <button type="submit" name="logout" class="block mt-2 text-red-500 hover:underline">Logout</button>
        </form>
    </div>
</div>

<script>
function toggleMobileMenu() {
    var menu = document.getElementById('mobile-menu');
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'flex';
    } else {
        menu.style.display = 'none';
    }
}
</script>
