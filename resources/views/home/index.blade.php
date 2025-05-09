<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Event Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center text-gray-900 dark:text-gray-100">

<div class="w-full max-w-lg mx-auto px-6 py-12">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">🎟️ Event Horizon</h1>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Select a test user to explore personalised recommendations
        </p>
    </div>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-4 text-red-600 text-sm text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form --}}
    <form method="GET" onsubmit="event.preventDefault(); redirectToUser(event);">
        <div class="mb-6">
            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                👤 Skiddle User
            </label>
            <select id="user_id" name="user_id" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white focus:outline-none focus:ring-2 focus:ring-[#46c3be] focus:border-[#46c3be] dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
                <option value="">-- Choose a user --</option>
                <option value="7803665">Chris S – Metal and experimental events in Manchester</option>
                <option value="1887026">Jack B – Indie events in Peterborough</option>
                <option value="7743652">Lawrence A – Alternative events in Birmingham</option>
                <option value="4340627">Scott C – Metal events in Preston</option>
            </select>
        </div>

        <button type="submit"
                class="w-full py-3 px-4 rounded-lg text-white font-semibold transition-all duration-200 hover:scale-105 shadow-md cursor-pointer"
                style="background-color: #46c3be;">
            🔍 Search
        </button>
    </form>
</div>

<script>
    function redirectToUser(event) {
        const userId = document.getElementById('user_id').value.trim();
        if (userId) {
            window.location.href = `/users/${userId}`;
        }
    }
</script>
</body>
</html>
