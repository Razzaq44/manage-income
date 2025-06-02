<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
</head>

<body>
    <table>
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
                        <td style="background-color: #d1fae5; color: #065f46; width: 180px; height: 24px;">
                            {{ $category }}</td>
                        @foreach ($monthlyReport as $report)
                            <td style="background-color: #d1fae5; color: #065f46; width: 180px; height: 24px;"
                                data-format="#,##0">
                                {{ $report[$category] }}
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach

            <tr>
                <td style="background-color: #10b981; color: #ffffff; font-weight: bold; width: 180px; height: 24px;">
                    Total Income</td>
                @foreach ($monthlyReport as $report)
                    <td data-format="#,##0"
                        style="background-color: #10b981; color: #ffffff; font-weight: bold; width: 180px; height: 24px;">
                        {{ $report['total_income'] }}
                    </td>
                @endforeach
            </tr>

            @foreach ($categories as $category)
                @if (in_array($category, $expenseCategories))
                    <tr>
                        <td style="background-color: #fee2e2; color: #991b1b; width: 180px; height: 24px;">
                            {{ $category }}</td>
                        @foreach ($monthlyReport as $report)
                            <td data-format="#,##0"
                                style="background-color: #fee2e2; color: #991b1b; width: 180px; height: 24px;">
                                {{ $report[$category] }}
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach

            <tr>
                <td style="background-color: #ef4444; color: #ffffff; font-weight: bold; width: 180px; height: 24px;">
                    Total Expense</td>
                @foreach ($monthlyReport as $report)
                    <td style="background-color: #ef4444; color: #ffffff; font-weight: bold; width: 180px; height: 24px;"
                        data-format="#,##0">
                        {{ $report['total_expense'] }}
                    </td>
                @endforeach
            </tr>

            <tr>
                <td>Net Income</td>
                @foreach ($monthlyReport as $report)
                    <td data-format="#,##0">
                        {{ $report['net_income'] }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</body>

</html>
