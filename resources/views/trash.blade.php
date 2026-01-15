@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app :title="__('Trash')">
    <div class="space-y-6 p-6 bg-[#F3EFEA] dark:bg-[#2B231D]">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-2xl border border-neutral-300 bg-[#685549] dark:border-neutral-700 dark:bg-[#3A2F28] shadow-lg">
            <div class="flex h-full flex-col p-6 gap-6">

                <h2 class="text-2xl font-semibold text-white">Trash Management</h2>

                <!-- Deleted Menus Section -->
                <div class="mb-6 rounded-xl border border-neutral-200 bg-neutral-50 p-6 shadow-md dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h3 class="mb-4 text-xl font-semibold text-neutral-900 dark:text-neutral-100">Deleted Menu Items</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full rounded-lg border border-gray-300 shadow-md">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Photo</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Dish</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Category</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Price</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Deleted At</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($deletedMenus as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($item->photo)
                                                <img src="{{ Storage::url($item->photo) }}" alt="{{ $item->dish }}" 
                                                    class="w-10 h-10 rounded-full object-cover mx-auto">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mx-auto text-white font-semibold text-sm">
                                                    {{ $item->initials() }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $item->dish }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $item->category ? $item->category->name : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-black">${{ number_format($item->price, 2) }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $item->deleted_at ? $item->deleted_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <form action="{{ route('trash.menu.restore', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 transition-colors hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                                    Restore
                                                </button>
                                            </form>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('trash.menu.force-delete', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this item? This action cannot be undone!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete Permanently
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No deleted menu items found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Deleted Categories Section -->
                <div class="mb-6 rounded-xl border border-neutral-200 bg-neutral-50 p-6 shadow-md dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h3 class="mb-4 text-xl font-semibold text-neutral-900 dark:text-neutral-100">Deleted Categories</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full rounded-lg border border-gray-300 shadow-md">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Photo</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Category Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Deleted At</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($deletedCategories as $category)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($category->photo)
                                                <img src="{{ Storage::url($category->photo) }}" alt="{{ $category->name }}" 
                                                    class="w-10 h-10 rounded-full object-cover mx-auto">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mx-auto text-white font-semibold text-sm">
                                                    {{ $category->initials() }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $category->name }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ Str::limit($category->description, 50) ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $category->deleted_at ? $category->deleted_at->format('Y-m-d H:i') : 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <form action="{{ route('trash.category.restore', $category->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 transition-colors hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                                    Restore
                                                </button>
                                            </form>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('trash.category.force-delete', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this category? This action cannot be undone!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete Permanently
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No deleted categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layouts.app>
