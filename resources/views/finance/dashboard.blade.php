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
    <div class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <section class="bg-white p-6 shadow-md rounded-lg mt-6">
                <h2 class="text-xl font-semibold mb-2">
                    {{ trans('dashboard.finance.fixed_expenses') }}
                </h2>
                <div class="flex flex-wrap -mx-2">
                    @foreach($fixedExpenses as $expense)
                    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/4 px-2 mb-4">
                        <div class="bg-gray-100 p-2 rounded-lg shadow-md">
                            <!-- Card content based on $item -->
                            <h3 class="text-lg font-semibold">
                                {{ $expense->category->category_name }}
                            </h3>
                            <span class="text-gray-600">
                                {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                            </span>
                            <p class="text-gray-500 mt-1 text-xs">
                                {{ $expense->description }}
                            </p>
                            <div class="mt-2 flex justify-end">
                                <a href="{{ route('finance.edit', ['id' => $expense->id]) }}" class="px-2 py-1 text-xs bg-blue-500 text-black rounded-md hover:bg-blue-600">
                                    {{ trans('dashboard.finance.edit') }}
                                </a>
                                <div x-data="{ showModal: false, costIdToDelete: null }">
                                     <!-- Form for deleting the expense -->
                                    <form action="{{ route('finance.remove', ['id' => $expense->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="px-2 py-1 ml-2 text-xs bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('{{ trans('dashboard.finance.delete_text') }}')">
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
    {{-- Variable expenses section --}}
        <div class="flex-1">
            <section class="bg-white p-6 shadow-md rounded-lg mt-6">
                <h2 class="text-xl font-semibold mb-2">
                    {{ trans('dashboard.finance.variable_expenses') }}
                </h2>
                <div class="flex flex-wrap -mx-2">
                    @foreach($variableExpenses as $expense)
                    <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/4 px-2 mb-4">
                        <div class="bg-gray-100 p-2 rounded-lg shadow-md">
                            <!-- Card content based on $item -->
                            <h3 class="text-lg font-semibold">
                                {{ $expense->category->category_name }}
                            </h3>
                            <span class="text-gray-600">
                                {{ trans('dashboard.finance.euro_sign') }} {{ $expense->cost }}
                            </span>
                            <p class="text-gray-500 mt-1 text-xs">
                                {{ $expense->description }}
                            </p>
                            <div class="mt-2 flex justify-end">
                                <a href="{{ route('finance.edit', ['id' => $expense->id]) }}" class="px-2 py-1 text-xs bg-blue-500 text-black rounded-md hover:bg-blue-600">
                                    {{ trans('dashboard.finance.edit') }}
                                </a>
                                <div x-data="{ showModal: false, costIdToDelete: null }">
                                     <!-- Form for deleting the expense -->
                                    <form action="{{ route('finance.remove', ['id' => $expense->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="px-2 py-1 ml-2 text-xs bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('{{ trans('dashboard.finance.delete_text') }}')">
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
        <div class="flex flex-wrap -mx-2">
            @foreach($upcomingExpenses as $expense)
            <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/4 px-2 mb-4">
                <div class="bg-gray-100 p-2 rounded-lg shadow-md relative">
                    <span class="text-xs text-black absolute top-0 right-0 mt-2 mr-2 font-semibold">
                        {{ trans('dashboard.finance.due') }}: {{ $expense->formatted_due_date }}
                    </span>
                    <h3 class="text-lg font-semibold">
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
@endsection
