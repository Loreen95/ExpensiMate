@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4 text-white flex justify-center items-center">
        {{ trans('dashboard.finance.paid1') }} {{ trans('dashboard.finance.bills') }}
    </h1>

        @if($paidExpenses->isEmpty())
            <p>No paid bills found.</p>
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
                        @foreach($paidExpenses as $expense)
                            <tr class="bg-white border-y dark:bg-white dark:border-black">
                                <td class="border-r border-black px-6 py-3 text-center">{{ $expense->category->category_name }}</td>
                                <td class="border-r border-black px-6 py-3 text-center">&euro; {{ number_format($expense->cost, 2) }}</td>
                                <td class="border-r border-black px-6 py-3 text-center">{{ $expense->description ?: '-' }}</td>
                                <td class="border-r border-black px-6 py-3 text-center">{{ $expense->formatted_due_date }}</td>
                                <td class="px-6 py-3 text-center"><span class="badge bg-success text-green-600">{{ trans('dashboard.finance.paid') }} </span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>            
        </div>
        @endif
    </div>
@endsection
