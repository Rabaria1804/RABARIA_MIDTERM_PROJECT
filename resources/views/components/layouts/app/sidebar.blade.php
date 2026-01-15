<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>

    <body class="min-h-screen bg-[#000000] text-white font-sans antialiased">

        <!-- SIDEBAR DARK MODE -->
        <flux:sidebar 
            sticky
            stashable
            class="border-e border-[#000000] bg-[#3A2F28] text-white shadow-lg"
        >
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo class="w-10 h-10 rounded-lg shadow-inner" />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid text-gray-200">
                    <flux:navlist.item 
                        icon="home" 
                        :href="route('dashboard')" 
                        :current="request()->routeIs('dashboard')" 
                        wire:navigate
                        class="text-gray-300 hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                    >
                        {{ __('Dashboard') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="home" 
                        :href="route('menu')" 
                        :current="request()->routeIs('menu')" 
                        wire:navigate
                        class="text-gray-300 hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                    >
                        {{ __('Menu List') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="home" 
                        :href="route('categories')" 
                        :current="request()->routeIs('categories')" 
                        wire:navigate
                        class="text-gray-300 hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                    >
                        {{ __('Categories') }}
                    </flux:navlist.item>

                    <flux:navlist.item 
                        icon="trash" 
                        :href="route('trash')" 
                        :current="request()->routeIs('trash')" 
                        wire:navigate
                        class="text-gray-300 hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                    >
                        {{ __('Trash') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item 
                    icon="folder-git-2" 
                    href="https://github.com/laravel/livewire-starter-kit" 
                    target="_blank"
                    class="text-gray-300 hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                >
                    {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item 
                    icon="book-open-text" 
                    href="https://laravel.com/docs/starter-kits#livewire" 
                    target="_blank"
                    class="text-gray-300 hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                >
                    {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    class="text-white"
                />

                <flux:menu class="w-[220px] bg-[#1a1a1a] text-gray-200 rounded-xl shadow-lg">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-2 py-2 text-start text-sm hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-700 text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-gray-400">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="border-gray-700" />

                    <flux:menu.radio.group>
                        <flux:menu.item 
                            :href="route('profile.edit')" 
                            icon="cog" 
                            wire:navigate 
                            class="hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                        >
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator class="border-gray-700" />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item 
                            as="button" 
                            type="submit" 
                            icon="arrow-right-start-on-rectangle" 
                            class="w-full hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
