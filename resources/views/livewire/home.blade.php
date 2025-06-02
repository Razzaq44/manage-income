<div class="flex-1 overflow-y-clip flex flex-col gap-12">
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold">Month's Report</h1>
        <div class="flex gap-1 items-center">
            <div class="flex gap-2 items-center">
                <input type="month" wire:model.live="startMonth" class="input" />
                @error('startMonth')
                    <p class="label text-error">{{ $message }}</p>
                @enderror
                <input type="month" wire:model.live="endMonth" class="input" />
                @error('endMonth')
                    <p class="label text-error">{{ $message }}</p>
                @enderror
            </div>
            <button wire:click="export" class="btn btn-primary">Export To Excel</button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-pin-rows table-pin-cols">
            <thead>
                <tr>
                    <th class="font-bold">Category</th>
                    @foreach ($monthlyReport as $month => $values)
                        <th>{{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    @if (in_array($category, $incomeCategories))
                        <tr>
                            <td>{{ $category }}</td>
                            @foreach ($monthlyReport as $report)
                                <td>
                                    {{ number_format($report[$category] ?? 0, 0, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach

                <tr>
                    <td>Total Income</td>
                    @foreach ($monthlyReport as $report)
                        <td>
                            {{ number_format($report['total_income'] ?? 0, 0, ',', '.') }}
                        </td>
                    @endforeach
                </tr>

                @foreach ($categories as $category)
                    @if (in_array($category, $expenseCategories))
                        <tr>
                            <td>{{ $category }}</td>
                            @foreach ($monthlyReport as $report)
                                <td>
                                    {{ number_format($report[$category] ?? 0, 0, ',', '.') }}
                                </td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach

                <tr>
                    <td>Total Expense</td>
                    @foreach ($monthlyReport as $report)
                        <td>
                            {{ number_format($report['total_expense'] ?? 0, 0, ',', '.') }}
                        </td>
                    @endforeach
                </tr>

                <tr>
                    <td>Net Income</td>
                    @foreach ($monthlyReport as $report)
                        <td>
                            {{ number_format($report['net_income'] ?? 0, 0, ',', '.') }}
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
</div>
