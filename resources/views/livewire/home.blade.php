<div class="flex-1 overflow-y-clip flex flex-col gap-12">
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold">Month's Report</h1>
        <button wire:click="export" class="btn btn-primary">Export To Excel</button>
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
                    <tr>
                        <td class="font-medium">{{ $category }}</td>
                        @foreach ($monthlyReport as $month => $values)
                            <td class="">
                                {{ isset($values[$category]) ? number_format($values[$category], 0, ',', '.') : '-' }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
