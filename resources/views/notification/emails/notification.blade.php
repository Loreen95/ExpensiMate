<!DOCTYPE html>
<html>
<head>
    <title>{{ $frequency === 'daily' ? 'Daily Notifications' : 'Weekly Notifications' }}</title>
</head>
<body>
    <h1>{{ $frequency === 'daily' ? 'Daily Notifications' : 'Weekly Notifications' }}</h1>
    <p>{{ $emailContent }}</p>
    @if($upcomingExpenses->isEmpty())
        <p>{{ trans('dashboard.finance.no_bills_found') }}</p>
    @else
        <div class="flex justify-center items-center relative overflow-x-auto">
            <table class="w-3/4 text-sm text-left">
                <thead class="text-xs text-silver uppercase bg-oxford dark:bg-oxford dark:text-silver">
                    <tr>
                        <th scope="col" class="text-center px-6 py-3">{{ trans('dashboard.finance.category') }}</th>
                        <th scope="col" class="text-center px-6 py-3">{{ trans('dashboard.finance.amount') }}</th>
                        <th scope="col" class="text-center px-6 py-3">{{ trans('dashboard.finance.description') }}</th>
                        <th scope="col" class="text-center px-6 py-3">{{ trans('dashboard.finance.paydate') }}</th>
                        <th scope="col" class="text-center px-6 py-3">{{ trans('dashboard.finance.status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Display upcoming expenses --}}
                    @foreach($upcomingExpenses as $expense)
                        <tr class="bg-white border-y dark:bg-white dark:border-black">
                            <td class="border-r border-black px-6 py-3 text-center">{{ $expense->category->category_name }}</td>
                            <td class="border-r border-black px-6 py-3 text-center">&euro; {{ number_format($expense->cost, 2) }}</td>
                            <td class="border-r border-black px-6 py-3 text-center">{{ $expense->description ?: '-' }}</td>
                            <td class="border-r border-black px-6 py-3 text-center">{{ $expense->formatted_due_date }}</td>
                            <td class="px-6 py-3 text-center"><span class="badge bg-warning text-yellow-600">{{ trans('dashboard.finance.upcoming') }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</body>
</html>
