@extends('layout')

@section('content')
<form action="{{ route('finance.cost_add') }}" method="POST">
    @csrf
    <!-- Category Select -->
    <div class="mb-4">
        <label for="category_id" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.finance.categories') }}
        </label>
        <select name="category_id" id="category_id" class="w-48" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ trans('sql_translations.category_option', ['categoryName' => $category->category_name]) }}
                </option>
            @endforeach
        </select>        
    </div>

    {{-- Type of expense --}}
    <div class="mb-4">
        <label for="expense_type" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.finance.expense_type') }}
        </label>
        <select name="expense_type" id="expense_type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <option value="fixed">{{ trans('dashboard.finance.fixed') }}</option>
            <option value="variable">{{ trans('dashboard.finance.variable') }}</option>
        </select>
    </div>
    
    <!-- Cost -->
    <div class="mb-4">
        <label for="cost" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.finance.amount') }}
        </label>
        <input type="number" step="0.01" name="cost" id="cost" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.finance.description') }}
        </label>
        <textarea name="description" id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
    </div>

    <!-- Due Date -->
    <div class="mb-4">
        <label for="due_date" class="block text-sm font-medium text-gray-700">
            {{ trans('dashboard.finance.due') }}
        </label>
        <input type="date" name="due_date" id="due_date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
    </div>

    <!-- Submit Button -->
    <div class="mb-4">
        <button type="submit" class="px-4 py-2 w-full text-sm font-medium text-white bg-green-600 rounded-md hover:bg-blue-600">
            Add Expense
        </button>
    </div>
</form>
@endsection
