@extends('layout')

@section('content')
<form action="{{ route('finance.category_add') }}" method="POST">
    @csrf

    <!-- Category Name -->
    <div class="mb-4">
        <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
        <input type="text" name="category_name" id="category_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm" required>
    </div>

    <!-- Submit Button -->
    <div class="mb-4">
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">
            Add Category
        </button>
    </div>
</form>
@endsection