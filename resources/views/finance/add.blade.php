@extends('layout')

@section('content')
<form action="{{ route('finance.add') }}" method="POST">
    @csrf

    <!-- Category Select -->
    <div class="mb-4">
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category_id" id="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Type of expense --}}
    <div class="mb-4">
        <label for="expense_type" class="block text-sm font-medium text-gray-700">Expense Type</label>
        <select name="expense_type" id="expense_type" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            @foreach ($expenseTypes as $expenseType)
                <option value="{{ $expenseType }}">{{ ucfirst($expenseType) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Cost -->
    <div class="mb-4">
        <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
        <input type="number" name="cost" id="cost" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
    </div>

    <!-- Due Date -->
    <div class="mb-4">
        <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
        <input type="date" name="due_date" id="due_date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
    </div>

    <!-- Submit Button -->
    <div class="mb-4">
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
            Add Expense
        </button>
    </div>
</form>
@endsection
