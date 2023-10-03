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
    {{-- Fixed expenses-section  --}}
    <div class="flex flex-col sm:flex-col md:flex-row gap-6">
        <div class="flex-1">
            <section class="bg-white p-2 shadow-md rounded-lg mt-6">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="text-xl font-semibold mb-2 ml-2">
                        {{ trans('dashboard.finance.fixed_expenses') }}
                    </h2>
                    <h3 class="text-xl font-semibold">
                        {{ trans('dashboard.finance.total') . ': ' . trans('dashboard.finance.euro_sign') . ' ' . $totalCost }}
                    </h3>
                </div>
                <div class="overflow-y-auto max-h-[400px] ml-2">
                    <div class="flex flex-wrap -mx-4 mr-1">
                        @foreach($fixedExpenses as $expense)
                        <div class="w-full sm:w-1/4 md:w-1/4 lg:w-1/2 xl:w-1/3 px-4 mb-4"> <!-- Adjust width to xl:w-1/3 and increase padding to px-4 -->
                            <div class="bg-gray-100 p-4 rounded-lg shadow-md"> <!-- Increase padding to p-4 -->
                                <!-- Card content based on $item -->
                                <h3 class="text-lg font-semibold">
                                    {{ $expense->category->category_name }}
                                </h3>
                                <span class="text-gray-600">
                                    {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                                </span>
                                <p class="text-gray-500 mt-1 text-sm"> <!-- Increase text size to text-sm -->
                                    {{ $expense->description }}
                                </p>
                                <div class="mt-2 flex justify-between pr-1"> <!-- Adjust margin and alignment -->
                                    <a href="{{ route('finance.edit', ['id' => $expense->id]) }}" class="mr-1.5 py-1 text-xs bg-blue-500 text-black rounded-md hover:bg-blue-600"> <!-- Increase padding and text size to text-sm -->
                                        {{ trans('dashboard.finance.edit') }}
                                    </a>
                                    
                                    <div x-data="{ showModal: false, costIdToDelete: null }">
                                        <!-- Form for deleting the expense -->
                                        <form action="{{ route('finance.remove', ['id' => $expense->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-0.5 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('{{ trans('dashboard.finance.delete_text') }}')">
                                                {{ trans('dashboard.finance.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
        
    {{-- Variable expenses section --}}
        <div class="flex-1">
            <section class="bg-white p-2 shadow-md rounded-lg mt-6">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="text-xl font-semibold mb-2 ml-2">
                        {{ trans('dashboard.finance.variable_expenses') }}
                    </h2>
                    <h3 class="text-xl font-semibold">
                        {{ trans('dashboard.finance.total') . ': ' . trans('dashboard.finance.euro_sign') . ' ' . $totalVariable }}
                    </h3>
                </div>
                <div class="overflow-y-auto max-h-[400px] ml-2">
                    <div class="flex flex-wrap -mx-4 mr-1"> 
                        @foreach($variableExpenses as $expense)
                        <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/3 px-4 mb-4">
                            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold">
                                    {{ $expense->category->category_name }}
                                </h3>
                                <span class="text-gray-600">
                                    {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                                </span>
                                <p class="text-gray-500 mt-1 text-xs">
                                    {{ $expense->description }}
                                </p>
                                <div class="mt-2 flex justify-between"> <!-- Adjust margin and alignment -->
                                    <a href="{{ route('finance.edit', ['id' => $expense->id]) }}" class="mr-1.5 py-1 text-xs bg-blue-500 text-black rounded-md hover:bg-blue-600"> <!-- Increase padding and text size to text-sm -->
                                        {{ trans('dashboard.finance.edit') }}
                                    </a>
                                    <div x-data="{ showModal: false, costIdToDelete: null }">
                                        <!-- Form for deleting the expense -->
                                        <form action="{{ route('finance.remove', ['id' => $expense->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-0.5 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('{{ trans('dashboard.finance.delete_text') }}')">
                                                {{ trans('dashboard.finance.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

        <section class="bg-white p-6 shadow-md rounded-lg mt-6">
        <h2 class="text-xl font-semibold mb-2">
            {{ trans('dashboard.finance.upcoming') }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($upcomingExpenses as $expense)
            <div class="w-full px-1 mb-4">
                <div class="bg-gray-100 p-2 rounded-lg shadow-md relative">
                        <span class="text-xs text-black absolute top-0 right-0 mt-2.5 mr-2 font-semibold">
                            {{ trans('dashboard.finance.due') }}: {{ $expense->formatted_due_date }}
                        </span>
                        <h3 class="text-sm font-semibold">
                            {{ $expense->category->category_name }}
                        </h3>
                        <span class="text-gray-600">
                            {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                        </span>
                        <p class="text-gray-500 mt-1 text-xs">
                            {{ $expense->description }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

@endsection
