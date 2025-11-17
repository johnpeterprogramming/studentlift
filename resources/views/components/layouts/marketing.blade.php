
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>

    <body class="bg-zinc-50 text-zinc-900 min-h-screen flex flex-col">
        <!-- Header / Navigation -->
        <header class="border-b border-zinc-200 bg-zinc-50">
            <div class="container mx-auto px-4 flex items-center gap-6 h-16">
                <!-- Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold text-lg">
                    <span>Safe Student Lift</span>
                </a>

                <!-- Primary Nav -->
                <nav class="flex items-center gap-4 text-sm font-medium">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600">Home</a>
                    <a href="{{ route('home') }}#about" class="hover:text-primary-600">About</a>
                    <a href="{{ route('home') }}#reviews" class="hover:text-primary-600">Reviews</a>
                    <a href="{{ route('book') }}" wire:navigate class="hover:text-primary-600">Book</a>

                    <!-- Divider -->
                    <span class="w-px h-6 bg-zinc-300" aria-hidden="true"></span>

                    <x-dropdown>
                        <x-slot name="trigger">
                            <button type="button" class="inline-flex items-center gap-1 hover:text-primary-600">
                                Weekly lifts
                                <x-icon name="chevron-down" class="w-4 h-4" />
                            </button>
                        </x-slot>

                        <x-dropdown.item label="Pricing" href="#" icon="currency-dollar" />
                        <x-dropdown.item label="FAQ" href="#" icon="question-mark-circle" />
                        <x-dropdown.item label="Terms and Conditions" href="#" icon="list-bullet" />
                        <x-dropdown.item label="Route" href="#" icon="map" />
                    </x-dropdown>
                </nav>

                <!-- Flexible spacer -->
                <div class="ml-auto flex items-center gap-4">

                    <!-- TODO: auth/login components -->
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>

        <!-- Global notifications -->
        @persist('notifications')
        <x-notifications />
        @endpersist

        @livewireScripts
    </body>
</html>
