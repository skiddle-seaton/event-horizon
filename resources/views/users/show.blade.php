<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Event Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center text-gray-900 dark:text-gray-100">

<div class="w-full max-w-3xl mx-auto px-6 py-12 bg-white dark:bg-gray-800 shadow-2xl rounded-3xl">
    {{-- Page Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Customer Profile</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Generated from recent purchase history</p>
    </div>

    {{-- AI Summary --}}
    <div class="mb-10 flex items-start space-x-4">
        <div class="flex-shrink-0">
            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#46c3be]/20 text-2xl">
                🤖
            </div>
        </div>
        <div class="flex-1 p-5 rounded-2xl border border-dashed border-[#46c3be]/40 bg-[#f0fdfa] dark:bg-gray-700 text-sm text-gray-800 dark:text-gray-100 shadow-sm">
            <h4 class="font-semibold text-[#46c3be] mb-1">AI Profile Summary</h4>
            <p class="italic leading-relaxed">
                {{ $summary }}
            </p>
        </div>
    </div>

    {{-- Profile Breakdown --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        {{-- Top Locations --}}
        <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-xl shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase flex items-center space-x-2 mb-3">
                <span>📍</span><span>Top Locations</span>
            </h3>
            <ul class="space-y-1 text-gray-800 dark:text-gray-200 text-sm">
                @forelse($profile['locations']->take(3)->keys() as $location)
                    <li>{{ $location }}</li>
                @empty
                    <li class="italic text-gray-400">No location data</li>
                @endforelse
            </ul>
        </div>

        {{-- Event Types --}}
        <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-xl shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase flex items-center space-x-2 mb-3">
                <span>🎭</span><span>Event Types</span>
            </h3>
            <ul class="space-y-1 text-gray-800 dark:text-gray-200 text-sm">
                @forelse($profile['categories']->take(3)->keys() as $category)
                    <li>{{ $category }}</li>
                @empty
                    <li class="italic text-gray-400">No event type data</li>
                @endforelse
            </ul>
        </div>

        {{-- Genres --}}
        <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-xl shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase flex items-center space-x-2 mb-3">
                <span>🎶</span><span>Genres</span>
            </h3>
            <ul class="space-y-1 text-gray-800 dark:text-gray-200 text-sm">
                @forelse($profile['genres']->take(3)->keys() as $genre)
                    <li>{{ $genre }}</li>
                @empty
                    <li class="italic text-gray-400">No genre data</li>
                @endforelse
            </ul>
        </div>

        {{-- Top Artists --}}
        <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-xl shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase flex items-center space-x-2 mb-3">
                <span>👤</span><span>Top Artists</span>
            </h3>
            <ul class="space-y-1 text-gray-800 dark:text-gray-200 text-sm">
                @forelse($profile['artists']->take(5)->keys() as $artist)
                    <li>{{ Str::title($artist) }}</li>
                @empty
                    <li class="italic text-gray-400">No artist data</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- CTAs --}}
    <div class="flex justify-between items-center gap-4">
        <a href="{{ route('recommendations.index', ['userId' => $userId]) }}"
           class="flex items-center justify-center gap-2 px-6 py-3 rounded-lg font-semibold text-white bg-[#46c3be] hover:scale-105 transition-all duration-200 shadow-md">
            ✨ Find Event Recommendations
        </a>
        <a href="{{ route('home.index') }}"
           class="px-6 py-3 rounded-lg font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition-all duration-200">
            🔍 Search Again
        </a>
    </div>
</div>

</body>
</html>
