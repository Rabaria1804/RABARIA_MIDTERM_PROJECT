@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app :title="__('Menu Items')">
    <div class="space-y-6 p-6 bg-[#F3EFEA] dark:bg-[#2B231D]">

        <div class="relative h-full flex-1 overflow-hidden rounded-2xl border border-neutral-300 bg-[#685549] dark:border-neutral-700 dark:bg-[#3A2F28] shadow-lg">
            <div class="flex h-full flex-col p-6 gap-6">

                @if(session('success'))
                    <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search and Filter Section -->
                <div class="mb-6 rounded-xl border border-neutral-200 bg-neutral-50 p-6 shadow-md dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-xl font-semibold text-neutral-900 dark:text-neutral-100">Search & Filter</h2>
                    
                    <form method="GET" action="{{ route('menu') }}" class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by dish name or description" 
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Filter by Category</label>
                            <select name="category_id" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <option value="">All Categories</option>
                                @foreach($category as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Apply Filters
                            </button>
                            <a href="{{ route('menu') }}" class="rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow hover:bg-neutral-50 dark:border-neutral-600 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700">
                                Clear
                            </a>
                            <a href="{{ route('menu.export.pdf', request()->query()) }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500/20">
                                Export PDF
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Add New Dish Form -->
                <div class="mb-6 rounded-xl border border-neutral-200 bg-neutral-50 p-6 shadow-md dark:border-neutral-700 dark:bg-neutral-900/50">
                    <h2 class="mb-4 text-xl font-semibold text-neutral-900 dark:text-neutral-100">Add New Dish</h2>

                    <form action="{{ route('menu') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-2">
                        @csrf
                        
                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Dish Name</label>
                            <input type="text" name="dish" value="{{ old('dish') }}" placeholder="Enter dish name" required 
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            @error('dish')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Price</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="Enter price" required 
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                            <select name="category_id" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                <option value="">Select Category</option>
                                @foreach($category as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                            <textarea name="description" rows="2" placeholder="Enter dish description" 
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Photo (JPG/PNG, Max 2MB)</label>
                            <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png" 
                                class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 px-6 py-2 text-sm font-medium text-white shadow-lg transition-all hover:from-blue-600 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Add Dish
                            </button>
                        </div>

                    </form>
                </div>

                <!-- Menu Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-xl font-semibold text-white">Menu List</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full rounded-lg border border-gray-300 shadow-md">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Photo</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Dish</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Category</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Price</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                @forelse($menu as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" id="menu-row-{{ $item->id }}">
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
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ Str::limit($item->description, 50) ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editDish({{ $item->id }}, '{{ addslashes($item->dish) }}', '{{ $item->category_id ?? 'null' }}', '{{ $item->price }}', '{{ addslashes($item->description ?? '') }}', '{{ $item->photo ? Storage::url($item->photo) : '' }}')" 
                                                class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-neutral-400">|</span>
                                            <form action="{{ route('menu.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this dish to trash?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-btn text-red-600 transition-colors hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                                            No dishes found. Add your first dish above!
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

    <!-- Edit Modal -->
    <div id="editDishModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-[9999]">
        <div class="w-full max-w-2xl rounded-2xl border border-neutral-200 bg-white p-6 shadow-lg dark:border-neutral-700 dark:bg-neutral-800">
            <h2 class="mb-4 text-xl font-semibold text-neutral-900 dark:text-neutral-100">Edit Dish</h2>

            <form id="editDishForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Dish Name</label>
                        <input type="text" id="edit_dish_name" name="dish" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Category</label>
                        <select id="edit_category" name="category_id" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm">
                            <option value="">Select Category</option>
                            @foreach($category as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Price</label>
                        <input type="number" step="0.01" id="edit_price" name="price" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                        <textarea id="edit_description" name="description" rows="2" class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-neutral-700 dark:text-neutral-300">Photo (JPG/PNG, Max 2MB)</label>
                        <input type="file" id="edit_photo" name="photo" accept="image/jpeg,image/jpg,image/png" 
                            class="w-full rounded-lg border border-neutral-300 bg-white px-4 py-2 text-sm text-black shadow-sm">
                        <div id="edit_photo_preview" class="mt-2"></div>
                    </div>
                </div>

                <div class="md:col-span-2 mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditDishModal()" class="rounded-lg border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 dark:border-neutral-600 dark:text-neutral-300 dark:hover:bg-neutral-700">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-lg bg-gradient-to-r from-blue-500 to-blue-700 px-4 py-2 text-sm font-medium text-white shadow-lg hover:from-blue-600 hover:to-blue-800">
                        Update Dish
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function editDish(id, dish, category_id, price, description, photo) {
            document.getElementById('editDishModal').classList.remove('hidden');
            document.getElementById('editDishModal').classList.add('flex');
            document.getElementById('editDishForm').action = `/menu/${id}`;

            document.getElementById('edit_dish_name').value = dish;
            document.getElementById('edit_category').value = category_id;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_description').value = description || '';
            
            const preview = document.getElementById('edit_photo_preview');
            if (photo) {
                preview.innerHTML = `<img src="${photo}" alt="Current photo" class="w-20 h-20 rounded-full object-cover mt-2">`;
            } else {
                preview.innerHTML = '';
            }
        }

        function closeEditDishModal() {
            document.getElementById('editDishModal').classList.add('hidden');
            document.getElementById('editDishModal').classList.remove('flex');
            document.getElementById('editDishForm').reset();
            document.getElementById('edit_photo_preview').innerHTML = '';
        }
    </script>

</x-layouts.app>
