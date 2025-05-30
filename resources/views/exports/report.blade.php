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
                <tr>
                    <td style="{{ $getCellClass($categoryTypes[$category] ?? null) }}">{{ $category }}
                    </td>
                    @foreach ($monthlyReport as $month => $values)
                        <td style="{{ $getCellClass($categoryTypes[$category] ?? null) }}" data-format="#,##0">
                            {{ isset($values[$category]) ? $values[$category] : '-' }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
