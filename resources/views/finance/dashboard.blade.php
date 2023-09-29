@extends('layout')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4 text-white flex justify-center items-center">
        {{ trans('dashboard.finance.dashboard') }}
    </h1>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-white flex justify-center items-center">
            {{ trans('dashboard.finance.monthly_summary') }}
        </h2>
    </section>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <section class="bg-white p-6 shadow-md rounded-lg">
                <div class="flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-96 md:mt-0 md:border-0">
                    <h2 class="text-xl font-semibold mb-2 md:mb-0 sm:mb-4">
                        {{ trans('dashboard.finance.fixed_expenses') }}
                    </h2>
                    <h3 class="text-xl font-semibold md:pl-12">
                        {{ trans('dashboard.finance.total') . ': ' . trans('dashboard.finance.euro_sign') . ' ' . $totalCost }}
                    </h3>
                </div>
                @foreach ($fixedExpenses as $expense)
                <div class="bg-gray-100 p-2 rounded-lg shadow-md mb-2">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-semibold">
                            {{ $expense->category->category_name }}
                        </h3>
                        <span class="text-gray-600">
                            {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                        </span>
                    </div>
                    <p class="text-gray-500 mt-1 text-xs">
                        {{ $expense->description }}
                    </p>
                    <div class="mt-2 flex justify-end">
                        <button class="px-2 py-1 text-xs bg-blue-500 text-black rounded-md hover:bg-blue-600">
                            {{ trans('dashboard.finance.edit') }}
                        </button>
                        <button class="px-2 py-1 ml-2 text-xs bg-red-500 text-black rounded-md hover:bg-red-600">
                            {{ trans('dashboard.finance.delete') }}
                        </button>
                    </div>
                </div>
            @endforeach
            </section>
        </div>

        <div class="flex-1">
            <section class="bg-white p-6 shadow-md rounded-lg">
                <div class="flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-96 md:mt-0 md:border-0">
                    <h2 class="text-xl font-semibold mb-2">
                        {{ trans('dashboard.finance.variable_expenses') }}
                    </h2>
                    <h3 class="text-xl font-semibold md:pl-8">
                        {{ trans('dashboard.finance.total') . ': ' . trans('dashboard.finance.euro_sign') . ' ' . $totalVariable }}
                    </h3>
                </div>
                @foreach ($variableExpenses as $expense)
                <div class="bg-gray-100 p-2 rounded-lg shadow-md mb-2">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-semibold">
                            {{ $expense->category->category_name }}
                        </h3>
                        <span class="text-gray-600">
                            {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                        </span>
                    </div>
                    <p class="text-gray-500 mt-1 text-xs">
                        {{ $expense->description }}
                    </p>
                    <div class="mt-2 flex justify-end">
                        <button class="px-2 py-1 text-xs bg-blue-500 text-black rounded-md hover:bg-blue-600">
                            {{ trans('dashboard.finance.edit') }}
                        </button>
                        <button class="px-2 py-1 ml-2 text-xs bg-red-500 text-black rounded-md hover:bg-red-600">
                            {{ trans('dashboard.finance.delete') }}
                        </button>
                    </div>
                </div>
                @endforeach
            </section>
        </div>
    </div>

    {{-- <section class="bg-white p-6 shadow-md rounded-lg mt-6">
        <h2 class="text-xl font-semibold mb-2">
            {{ trans('dashboard.budget_vs_actual') }}
        </h2>
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">
                {{ trans('dashboard.budgeted_expenses') }}</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 text-left">
                            {{ trans('dashboard.expense_category') }}</th>
                        <th class="py-2 px-4 text-left">
                            {{ trans('dashboard.budgeted_amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4">Category 1</td>
                        <td class="py-2 px-4">
                            {{ trans('dashboard.euro_sign') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    
        <div>
            <h3 class="text-lg font-semibold mb-2">
                {{ trans('dashboard.actual_expenses') }}
            </h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 text-left">
                            {{ trans('dashboard.expense_category') }}</th>
                        <th class="py-2 px-4 text-left">
                            {{ trans('dashboard.budgeted_amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-2 px-4">Category 1</td>
                        <td class="py-2 px-4">
                            {{ trans('dashboard.euro_sign') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">
                {{ trans('dashboard.comparison') }}</h3>
            <p class="text-gray-700">
                {{ trans('dashboard.over_budget0') }}
                <span class="text-red-600">
                    {{ trans('dashboard.euro_sign') }}500
                </span>
                {{ trans('dashboard.over_budget1') }}
            </p>
        </div> --}}
    </section>
</div>
@endsection
