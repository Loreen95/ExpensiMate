@extends('layout')

@section('content')
<form action="{{ route('finance.edit', ['id' => $expense->id]) }}" method="POST">
    @csrf
    @method('PUT') <!-- Use PUT method for updating -->

    <!-- Expense Category -->
    <div class="mb-4">
        <label for="category_id" class="block text-sm font-medium text-gray-700">{{ trans('dashboard.finance.category') }}</label>
        <select name="category_id" id="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $expense->category_id ? 'selected' : '' }}>
                    {{ $expense->category->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Expense Cost -->
    <div class="mb-4">
        <label for="cost" class="block text-sm font-medium text-gray-700">{{ trans('dashboard.finance.amount') }}</label>
        <input type="number" name="cost" id="cost" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" value="{{ $expense->cost }}">
    </div>

    <!-- Expense Description -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">{{ trans('dashboard.finance.description') }}</label>
        <textarea name="description" id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">{{ $expense->description }}</textarea>
    </div>

    <!-- Expense Due date -->
    <div class="mb-4">
        <label for="due_date" class="block text-sm font-medium text-gray-700">{{ trans('dashboard.finance.due') }}</label>
        <input type="date" name="due_date" id="due_date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" value="{{ $expense->due_date }}">
    </div>

    <!-- Submit Button -->
    <div class="mb-4">
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
            Update Expense
        </button>
    </div>
</form>

@endsection