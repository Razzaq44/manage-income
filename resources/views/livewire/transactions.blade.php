<div class="flex-1 flex flex-col lg:flex-row gap-12">
    <div class="basis-1/4 flex gap-6 flex-col">
        <h1 class="text-xl font-semibold">Transaction</h1>
        <form class="flex gap-8 flex-col" wire:submit="save">
            <div class="flex-col flex gap-2 w-full">
                <label for="">Date</label>
                <input type="date" class="input w-full" wire:model="date" required>
                @error('date')
                    <p class="label text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex-col flex gap-2">
                <label for="">Category</label>
                <select class="select w-full" wire:model="coa_code" required>
                    <option selected value="">Choose:</option>
                    @foreach ($chartOfAccounts as $coa)
                        <option value="{{ $coa->code }}">{{ $coa->code }} - {{ $coa->name }}</option>
                    @endforeach
                </select>
                @error('coa_code')
                    <p class="label text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex-col flex gap-2">
                <label for="">Amount</label>
                <label class="input w-full">
                    <span class="label">IDR</span>
                    <input type="text" wire:model.live.debounce.500ms="amountFormatted" required />
                    @error('amount')
                        <p class="label text-error">{{ $message }}</p>
                    @enderror
                </label>
            </div>
            <div class="flex-col flex gap-2">
                <label for="">Description</label>
                <textarea class="textarea w-full" wire:model="description" required></textarea>
                @error('description')
                    <p class="label text-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
                    <span wire:loading.remove>Submit</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        </form>
    </div>
    <div class="flex-1 flex gap-6 flex-col">
        <h3 class="text-xl font-semibold">Last Added Transaction</h3>
        <div class="overflow-x-auto">
            <table class="table table-pin-cols">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>COA Code</th>
                        <th>COA Name</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="capitalize">
                    @foreach ($transactions as $transaction)
                        <tr>
                            <th>{{ $transaction->date }}</th>
                            <td>{{ $transaction->coa_code }}</td>
                            <td>{{ $transaction->chartOfAccount->name }}</td>
                            <td>{{ $transaction->description }}</td>
                            <td>IDR {{ number_format($transaction->debit, 0, ',', '.') }}</td>
                            <td>IDR {{ number_format($transaction->credit, 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-circle btn-ghost" wire:click="delete({{ $transaction->id }})"
                                    wire:confirm="Are you sure you want to delete this?">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <button class="btn btn-circle btn-ghost" for="edit"
                                    wire:click="edit({{ $transaction->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path
                                            d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                        <path
                                            d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
