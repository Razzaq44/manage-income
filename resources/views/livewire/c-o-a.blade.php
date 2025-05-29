<div class="flex-1 flex flex-col lg:flex-row gap-8 xl:gap-12 2xl:gap-16">
    <div class="basis-1/4 flex gap-6 flex-col">
        <div class="flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold">COA Categories</h1>
                <label class="btn btn-circle btn-ghost" for="category">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td class="w-12 text-center">No.</td>
                        <td>Name</td>
                        <td class="w-24 text-center">Action</td>
                    </tr>
                </thead>
                <tbody class="capitalize">
                    @forelse ($categories as $index => $category)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="flex justify-center items-center">
                                <button class="btn btn-circle btn-ghost" onclick="new_category.showModal()">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <label class="btn btn-circle btn-ghost" for="category"
                                    wire:click="editCategory({{ $category->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path
                                            d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                        <path
                                            d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                    </svg>
                                </label>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="3">No Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex-1 flex gap-6 flex-col">
        <div class="flex flex-col gap-6">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-semibold">Chart Of Account</h1>
                <label class="btn btn-circle btn-ghost" for="coa">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path
                            d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                </label>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td class="w-24 text-center">Kode</td>
                        <td>Name</td>
                        <td>Category</td>
                        <td class="w-24 text-center">Action</td>
                    </tr>
                </thead>
                <tbody class="capitalize">
                    @forelse ($coa as $c)
                        <tr>
                            <td class="text-center">{{ $c->code }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->category->name }}</td>
                            <td class="flex justify-center items-center">
                                <button class="btn btn-circle btn-ghost" wire:click="deleteCOA({{ $c->code }})"
                                    wire:confirm="Are you sure you want to delete this?">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <label class="btn btn-circle btn-ghost" for="coa"
                                    wire:click="editCOA({{ $c->code }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path
                                            d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                        <path
                                            d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                    </svg>
                                </label>
                            </td>
                        </tr>
                    @empty
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL --}}
    <input type="checkbox" id="coa" class="modal-toggle" />
    <div role="dialog" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h1 class="text-xl font-semibold mb-4">
                {{ $isEdit ? 'Edit COA' : 'Add New COA' }}
            </h1>
            <form wire:submit="saveCOA" class="grid xl:grid-cols-3 grid-cols-1 gap-8">
                <div class="flex-col flex gap-2 w-full">
                    <label>Code</label>
                    <input type="number" class="input w-full" min="1" wire:model="code" required>
                    @error('code')
                        <p class="label text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-col flex gap-2 w-full">
                    <label>Name</label>
                    <input type="text" class="input w-full" wire:model="coa_name" required>
                    @error('coa_name')
                        <p class="label text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-col flex gap-2 w-full">
                    <label>Category</label>
                    <select class="select w-full" wire:model="coa_category_id" required>
                        <option selected value="">Choose:</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('coa_category_id')
                        <p class="label text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end xl:col-span-3">
                    <button class="btn btn-primary w-full" type="submit" for="coa" wire:loading.attr="disabled">
                        <span wire:loading.remove>Submit</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
        <label class="modal-backdrop" for="coa" wire:click="resetForm">Close</label>
    </div>

    <input type="checkbox" id="category" class="modal-toggle" />
    <div role="dialog" class="modal">
        <div class="modal-box">
            <div class="flex flex-col gap-6">
                <h1 class="text-xl font-semibold">{{ $category_id ? 'Edit Category' : 'Add New Category' }}</h1>
                <form class="flex gap-8 flex-col" wire:submit="saveCategory">
                    <div class="flex-col flex gap-2 w-full">
                        <label for="">Category Name</label>
                        <input type="text" class="input w-full" wire:model="category_name" required>
                        @error('category_name')
                            <p class="label text-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex-col flex gap-2 w-full">
                        <select class="select w-full" wire:model="type_category" required>
                            <option selected value="">Choose:</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button class="btn btn-primary w-full" type="submit" for="coa"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <label class="modal-backdrop" for="category" wire:click="resetForm">Close</label>
    </div>
</div>
