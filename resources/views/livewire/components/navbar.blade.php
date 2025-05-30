<div class="drawer">
    <div class="drawer-content flex flex-col">
        <div class="navbar bg-base-100 shadow w-full lg:hidden flex">
            <div class="flex-none lg:hidden">
                <label for="my-drawer-2" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block h-6 w-6 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>
            <div class="mx-2 flex-1 px-2 text-xl font-semibold text-center">MI</div>
            {{-- <div class="avatar">
                <div class="w-12 rounded-full">
                    <img src="https://img.daisyui.com/images/profile/demo/yellingcat@192.webp" />
                </div>
            </div> --}}
            <div class="hidden flex-none lg:block">
                <ul class="menu menu-horizontal">
                    <!-- Navbar menu content here -->
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
                </ul>
            </div>
        </div>
    </div>
</div>
