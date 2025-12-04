<!-- Header / Navigation -->
<header class="w-full">

    <nav class="container relative flex flex-wrap items-center justify-between p-8 mx-auto lg:justify-between xl:px-0" x-data="{ open: false }">

        <div class="flex flex-wrap items-center justify-between w-full lg:w-auto">

            <!-- Logo -->
            <a class="flex items-center space-x-2 text-2xl font-medium text-indigo-500 dark:text-gray-100" href="{{ route('home') }}">
                <x-icon solid name="map-pin" class="w-8 h-8" />
                Student Lift
            </a>

            <!-- Toggle Menu for Mobile -->
            <button @click="open = !open" class="px-2 py-1 ml-auto text-gray-500 rounded-md lg:hidden hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:text-gray-300 dark:focus:bg-gray-700">
                <x-icon name="bars-3" class="w-6 h-6" />
            </button>

            <!-- Desktop Navigation (hidden on mobile) -->
            <div class="hidden text-center lg:flex lg:items-center">
                <ul className="items-center justify-end flex-1 pt-6 list-none lg:pt-0 lg:flex">
                    <li class="mr-3 nav__item">
                        <a href="{{ route('home') }}" class="inline-block px-4 py-2 text-lg font-normal rounded-md no-underline text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate>Home</a>
                    </li>
                    <li class="mr-3 nav__item">
                        <a href="{{ route('home') }}#about"class="inline-block px-4 py-2 text-lg font-normal rounded-md no-underline text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate>About</a>
                    </li>
                    <li class="mr-3 nav__item">
                        <a href="{{ route('home') }}#reviews" class="inline-block px-4 py-2 text-lg font-normal rounded-md no-underline text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate>Reviews</a>
                    </li>
                    <li class="mr-3 nav__item">
                        <a href="{{ route('book') }}" class="inline-block px-4 py-2 text-lg font-normal rounded-md no-underline text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate>Book</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile Navigation Panel (hidden on desktop) -->
        <div x-show="open" class="flex flex-wrap w-full my-5 lg:hidden">
            <ul className="items-center justify-end flex-1 pt-6 list-none lg:pt-0 lg:flex">
                <li class="mr-3 nav__item">
                    <a href="{{ route('home') }}"           class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >Home</a>
                </li>
                <li class="mr-3 nav__item">
                    <a href="{{ route('home') }}"           class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >Home</a>
                </li>
                <li class="mr-3 nav__item">
                    <a href="{{ route('home') }}"           class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >Home</a>
                </li>
                <li class="mr-3 nav__item">
                    <a href="{{ route('home') }}"           class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >Home</a>
                </li>
            <a href="{{ route('home') }}#about"     class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >About</a>
            <a href="{{ route('home') }}#reviews"   class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >Reviews</a>
            <a href="{{ route('book') }}"           class="w-full px-4 py-2 -ml-4 text-gray-500 rounded-md dark:text-gray-300 hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-700" wire:navigate >Book</a>
            </ul>
        </div>

    </nav>

</header>
