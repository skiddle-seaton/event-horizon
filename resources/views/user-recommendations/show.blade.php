<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Event Horizon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center text-gray-900 dark:text-gray-100">

<div class="w-full max-w-6xl mx-auto px-6 py-12">
    {{-- Page Header --}}
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Recommended Events</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Based on your music and event interests</p>
    </div>

    {{-- Event Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @forelse($events->take(8) as $event)
            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-sm overflow-hidden flex flex-col text-sm">
                {{-- Event Image --}}
                <img src="{{ $event['largeImageUrl'] }}" alt="{{ $event['eventName'] }}"
                     class="w-full h-32 object-cover">

                {{-- Event Content --}}
                <div class="p-3 flex flex-col justify-between flex-grow space-y-3">
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <h3 class="text-sm font-semibold text-[#46c3be] hover:underline leading-snug">
                                {{ $event['eventName'] }}
                            </h3>
                            @if($event['reason'])
                                <div class="relative inline-block">
                                    <button
                                        type="button"
                                        class="info-button text-gray-400 hover:text-gray-600"
                                        data-event-id="{{ $event['id'] }}"
                                        aria-label="Why this event?"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 17v-4m0-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                                        </svg>
                                    </button>
                                    <div
                                        class="tooltip hidden absolute right-0 mt-2 w-56 p-2 text-sm text-white bg-gray-800 rounded shadow-md z-50"
                                        data-event-id="{{ $event['id'] }}"
                                    >
                                        {{ $event['reason'] }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="text-xs text-gray-700 dark:text-gray-300 space-y-1">
                            <div class="flex items-center gap-1">
                                <span class="text-gray-500 dark:text-gray-400">📅</span>
                                <span>{{ $event['startDate']->format('l jS F') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="text-gray-500 dark:text-gray-400">⏰</span>
                                <span>{{ $event['startDate']->format('g:ia') }} - {{ $event['endDate']->format('g:ia') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="text-gray-500 dark:text-gray-400">📍</span>
                                <span>{{ $event['venue']['name'] }}, {{ $event['venue']['town'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="pt-2 mt-auto">
                        <a href="{{ $event['link'] }}" target="_blank"
                           class="inline-block px-2.5 py-1 bg-[#46c3be] text-white text-xs font-semibold rounded-md hover:scale-105 transition-transform flex items-center gap-1">
                            Buy Tickets <span>➜</span>
                        </a>
                    </div>
                </div>

            </div>
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400">No recommendations available at the moment.</p>
        @endforelse
    </div>

    {{-- CTAs --}}
    <div class="mt-10 flex justify-center">
        <a href="{{ route('home.index') }}"
           class="px-6 py-3 rounded-lg font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 dark:text-white dark:bg-gray-700 dark:hover:bg-gray-600 transition-all duration-200">
            🔍 Search Another User
        </a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll(".info-button");
        const tooltips = document.querySelectorAll(".tooltip");

        buttons.forEach(button => {
            button.addEventListener("click", function (e) {
                e.preventDefault();
                const eventId = this.getAttribute("data-event-id");

                // Close all tooltips first
                tooltips.forEach(t => t.classList.add("hidden"));

                // Open the matching one
                const tooltip = document.querySelector(`.tooltip[data-event-id="${eventId}"]`);
                if (tooltip) tooltip.classList.remove("hidden");
            });
        });

        // Close tooltips on outside click
        document.addEventListener("click", function (e) {
            if (!e.target.closest(".info-button") && !e.target.closest(".tooltip")) {
                tooltips.forEach(t => t.classList.add("hidden"));
            }
        });
    });
</script>



</body>
</html>
