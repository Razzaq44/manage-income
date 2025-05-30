<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    {{-- {!! app('seotools')->generate() !!} --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col h-screen">
            <livewire:components.navbar />
            <main class="p-4 md:p-6 flex-1">
                @if (!empty($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif

            </main>
        </div>
        <div class="drawer-side shadow-sm">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-base-100 text-base-content min-h-full w-80 pt-6 p-0">
                <h1 class="divider text-2xl font-semibold mb-8 mt-2">Manage Income</h1>
                <!-- Sidebar content here -->
                <li class="px-4 md:px-6">
                    <a class="py-3 mb-2 @if (Route::is('home')) bg-neutral text-neutral-content @endif"
                        href="/" wire:navigate>Reports
                    </a>
                </li>
                <li class="px-4 md:px-6">
                    <a class="py-3 mb-2" href="/transaction" wire:current="bg-neutral text-neutral-content">
                        Transaction
                    </a>
                </li>
                <li class="px-4 md:px-6">
                    <a class="py-3 mb-2 flex gap-2" href="/coa" wire:navigate
                        wire:current="bg-neutral text-neutral-content">
                        Chart Of Account
                    </a>
                </li>
                <li class="flex-1 bg-transparent"></li>
                <li class="">

                </li>
            </ul>
        </div>

    </div>
    <livewire:components.toast />
    @livewireScripts
</body>

</html>
