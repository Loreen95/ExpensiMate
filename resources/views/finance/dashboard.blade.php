@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4 text-white flex justify-center items-center">
        {{ trans('dashboard.finance_dashboard') }}
    </h1>

    <section class="mb-6">
        <h2 class="text-xl font-semibold mb-2 text-white flex justify-center items-center">
            {{ trans('dashboard.monthly_summary') }}
        </h2>
    </section>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <section class="bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-2">
                    {{ trans('dashboard.fixed_expenses') }}
                </h2>
                @foreach($fixedExpenses as $expense)
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">
                                {{ $expense->name }}
                            </h3>
                            <span class="text-gray-600">
                                {{ trans('dashboard.euro_sign') }}{{ $expense->amount }}
                            </span>
                        </div>
                        <p class="text-gray-500 mt-2">
                            {{ $expense->description }}
                        </p>
                        <div class="mt-4 flex justify-end">
                            <button class="px-3 py-2 text-sm bg-blue-500 text-black rounded-md hover:bg-blue-600">
                                {{ trans('dashboard.edit') }}
                            </button>
                            <button class="px-3 py-2 ml-2 text-sm bg-red-500 text-black rounded-md hover:bg-red-600">
                                {{ trans('dashboard.delete') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </section>
        </div>
        

        <div class="flex-1">
            <section class="bg-white p-6 shadow-md rounded-lg">
                <h2 class="text-xl font-semibold mb-2">
                    {{ trans('dashboard.variable_expenses') }}
                </h2>
                <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">
                            {{ trans('dashboard.expense_name') }}
                        </h3>
                        <span class="text-gray-600">
                            {{ trans('dashboard.euro_sign') }}
                        </span>
                    </div>
                    <p class="text-gray-500 mt-2">
                        {{ trans('dashboard.description') }}
                    </p>
                    <div class="mt-4 flex justify-end">
                        <button class="px-3 py-2 text-sm bg-blue-500 text-black rounded-md hover:bg-blue-600">
                            {{ trans('dashboard.edit') }}
                        </button>
                        <button class="px-3 py-2 ml-2 text-sm bg-red-500 text-black rounded-md hover:bg-red-600">
                            {{ trans('dashboard.delete') }}
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <section class="bg-white p-6 shadow-md rounded-lg mt-6">
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
        </div>
    </section>
</div>
@endsection
