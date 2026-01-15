@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-layouts.app :title="__('Categories')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6 bg-gray-50 dark:bg-gray-900">

        @if(session('success'))
            <div class="rounded-lg bg-green-100 p-4 text-green-700 dark:bg-green-900/30 dark:text-green-300 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-full flex-1 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <div class="flex h-full flex-col p-8 gap-6">

                <!-- Search and Filter Section -->
                <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900/50">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Search & Filter</h2>
                    
                    <form method="GET" action="{{ route('categories') }}" class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or description" 
                                class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20">
                                Apply Filters
                            </button>
                            <a href="{{ route('categories') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                                Clear
                            </a>
                            <a href="{{ route('categories.export.pdf', request()->query()) }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500/20">
                                Export PDF
                            </a>
                        </div>
                    </form>
                </div>

                <div class="mb-6 rounded-xl border border-gray-200 bg-gray-50 p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900/50">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Add New Category</h2>

                    <form action="{{ route('categories') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div class="grid gap-5 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       placeholder="Enter category name" required
                                       class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                <textarea name="description" rows="1" placeholder="Enter category description"
                                          class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid gap-5 md:grid-cols-3">
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Photo (JPG/PNG, Max 2MB)</label>
                                <input type="file" name="photo" accept="image/jpeg,image/jpg,image/png" 
                                    class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black">
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 shadow">
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Category List Table -->
                <div class="flex-1 overflow-auto">
                    <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Category List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-full rounded-lg border border-gray-200 shadow-md dark:border-gray-700">
                            <thead>
                                <tr class="border-b border-gray-300 bg-gray-100 dark:border-gray-700 dark:bg-gray-800">
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">#</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Photo</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Category Name</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Description</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-black">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($category as $cat)
                                    <tr class="transition-colors hover:bg-gray-50 dark:hover:bg-gray-800/50" id="category-row-{{ $cat->id }}">
                                        <td class="px-4 py-3 text-center text-sm text-black">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 text-center">
                                            @if($cat->photo)
                                                <img src="{{ Storage::url($cat->photo) }}" alt="{{ $cat->name }}" 
                                                    class="w-10 h-10 rounded-full object-cover mx-auto">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mx-auto text-white font-semibold text-sm">
                                                    {{ $cat->initials() }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-black">
                                            <span class="category-name-display">{{ $cat->name }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm text-black">
                                            <span class="category-description-display">{{ Str::limit($cat->description, 50) ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-center text-sm">
                                            <button onclick="editCategory(
                                                            {{ $cat->id }}, 
                                                            '{{ addslashes($cat->name) }}', 
                                                            '{{ addslashes($cat->description ?? '') }}',
                                                            '{{ $cat->photo ? Storage::url($cat->photo) : '' }}')"
                                                    class="text-blue-600 transition-colors hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Edit
                                            </button>
                                            <span class="mx-1 text-gray-400">|</span>
                                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to move this category to trash?')">
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
                                        <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                            No categories found. Add your first category above!
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

    <!-- Edit Category Modal -->
    <div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Edit Category</h2>

            <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                        <input type="text" id="edit_category_name" name="name" required
                               class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea id="edit_description" name="description" rows="3"
                                  class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Photo (JPG/PNG, Max 2MB)</label>
                        <input type="file" id="edit_photo" name="photo" accept="image/jpeg,image/jpg,image/png" 
                            class="w-full rounded-lg border border-gray-300 bg-white text-black px-4 py-2 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-gray-600 dark:bg-gray-800 dark:text-black">
                        <div id="edit_photo_preview" class="mt-2"></div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 shadow">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editCategory(id, name, description, photo) {
            document.getElementById('editCategoryModal').classList.remove('hidden');
            document.getElementById('editCategoryModal').classList.add('flex');
            document.getElementById('editCategoryForm').action = `/categories/${id}`;

            document.getElementById('edit_category_name').value = name;
            document.getElementById('edit_description').value = description || '';
            
            const preview = document.getElementById('edit_photo_preview');
            if (photo) {
                preview.innerHTML = `<img src="${photo}" alt="Current photo" class="w-20 h-20 rounded-full object-cover mt-2">`;
            } else {
                preview.innerHTML = '';
            }
        }

        function closeEditModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
            document.getElementById('editCategoryModal').classList.remove('flex');

            document.getElementById('editCategoryForm').reset();
            document.getElementById('edit_photo_preview').innerHTML = '';
        }
    </script>
</x-layouts.app>
