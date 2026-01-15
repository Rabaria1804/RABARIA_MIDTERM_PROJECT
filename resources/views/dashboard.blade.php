@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl bg-[#000000] text-[#E6DED6] p-6">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">

            <!-- Total Menu Items Card -->
            <div class="relative overflow-hidden rounded-xl border border-[#FFFFFF22] bg-[#3A2F28] p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#E6DED6]">Total Menu Items</p>
                        <h3 class="mt-2 text-3xl font-bold text-[#FAF7F3]">{{ $totalMenus }}</h3>
                    </div>
                    <div class="rounded-full bg-[#D9A86C22] p-3">
                        <svg width="38px" height="38px" viewBox="0 0 1024 1024" fill="#D9A86C" xmlns="http://www.w3.org/2000/svg">
                            <path d="M861.9 383.8H218.1c-36.4 0-66.1-29.8-66.1-66.1V288c0-36.4 29.8-66.1 66.1-66.1h643.8c36.4 0 66.1 29.8 66.1 66.1v29.7c0 36.3-29.8 66.1-66.1 66.1z" fill="#E4C7A6"/>
                            <path d="M822.9 129.2H199.8c-77.2 0-140.4 63.2-140.4 140.4v487.2c0 77.2 63.2 140.4 140.4 140.4h623.1c77.2 0 140.4-63.2 140.4-140.4V269.6c0-77.2-63.2-140.4-140.4-140.4z" fill="#CDAE8C"/>
                            <path d="M400.5 770.6V430.9L534.1 508c14.3 8.3 19.3 26.6 11 41-8.3 14.3 26.6 19.3 41 11l-43.6-25.2v131.8l114.1-65.9-7.5-4.3c-14.3-8.3-19.3-26.6-11-41 8.3-14.3 26.6-19.3 41-11l97.5 56.3-294.1 169.9z" fill="#E9D2B5"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Categories Card -->
            <div class="relative overflow-hidden rounded-xl border border-[#FFFFFF22] bg-[#3A2F28] p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#FAF7F3]">Total Categories</p>
                        <h3 class="mt-2 text-3xl font-bold text-[#FAF7F3]">{{ $totalCategories }}</h3>
                    </div>
                    <div class="rounded-full bg-[#D9A86C22] p-3">
                        <svg width="38px" height="38px" viewBox="0 0 16 16" fill="#D9A86C" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 1H8V15H5V1Z"/>
                            <path d="M0 3H3V15H0V3Z"/>
                            <path d="M12.167 3L9.34302 3.7041L12.1594 15L14.9834 14.2959L12.167 3Z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Deleted Items Card -->
            <div class="relative overflow-hidden rounded-xl border border-[#FFFFFF22] bg-[#3A2F28] p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#FAF7F3]">Items in Trash</p>
                        <h3 class="mt-2 text-3xl font-bold text-[#FAF7F3]">{{ $deletedMenus + $deletedCategories }}</h3>
                        <p class="mt-1 text-xs text-[#E6DED6] opacity-75">{{ $deletedMenus }} menus, {{ $deletedCategories }} categories</p>
                    </div>
                    <div class="rounded-full bg-[#D9A86C22] p-3">
                        <svg class="h-6 w-6" fill="none" stroke="#D9A86C" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="relative overflow-hidden rounded-xl border border-[#FFFFFF22] bg-[#3A2F28] p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#FAF7F3]">Quick Actions</p>
                        <div class="mt-2 flex gap-2">
                            <a href="{{ route('menu') }}" class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700">
                                Menu
                            </a>
                            <a href="{{ route('categories') }}" class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-green-700">
                                Categories
                            </a>
                            @if($deletedMenus + $deletedCategories > 0)
                                <a href="{{ route('trash') }}" class="rounded-lg bg-orange-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-orange-700">
                                    Trash
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Items Section -->
        <div class="grid gap-4 md:grid-cols-2 mt-4">
            <!-- Recent Menu Items -->
            <div class="relative overflow-hidden rounded-xl border border-[#FFFFFF22] bg-[#3A2F28] p-6">
                <h3 class="mb-4 text-lg font-semibold text-[#FAF7F3]">Recent Menu Items</h3>
                <div class="space-y-3">
                    @forelse($menu as $item)
                        <div class="flex items-center gap-3 rounded-lg border border-[#FFFFFF15] bg-[#241E1A] p-3">
                            <div class="flex-shrink-0">
                                @if($item->photo)
                                    <img src="{{ Storage::url($item->photo) }}" alt="{{ $item->dish }}" 
                                        class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $item->initials() }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-[#FAF7F3] truncate">{{ $item->dish }}</p>
                                <p class="text-xs text-[#E6DED6] opacity-75">${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#E6DED6] opacity-75">No menu items yet.</p>
                    @endforelse
                </div>
                <a href="{{ route('menu') }}" class="mt-4 block text-center text-sm text-[#D9A86C] hover:text-[#E4C7A6]">
                    View All Menu Items →
                </a>
            </div>

            <!-- Recent Categories -->
            <div class="relative overflow-hidden rounded-xl border border-[#FFFFFF22] bg-[#3A2F28] p-6">
                <h3 class="mb-4 text-lg font-semibold text-[#FAF7F3]">Recent Categories</h3>
                <div class="space-y-3">
                    @forelse($category as $cat)
                        <div class="flex items-center gap-3 rounded-lg border border-[#FFFFFF15] bg-[#241E1A] p-3">
                            <div class="flex-shrink-0">
                                @if($cat->photo)
                                    <img src="{{ Storage::url($cat->photo) }}" alt="{{ $cat->name }}" 
                                        class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ $cat->initials() }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-[#FAF7F3] truncate">{{ $cat->name }}</p>
                                <p class="text-xs text-[#E6DED6] opacity-75 truncate">{{ Str::limit($cat->description, 30) ?? 'No description' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-[#E6DED6] opacity-75">No categories yet.</p>
                    @endforelse
                </div>
                <a href="{{ route('categories') }}" class="mt-4 block text-center text-sm text-[#D9A86C] hover:text-[#E4C7A6]">
                    View All Categories →
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
