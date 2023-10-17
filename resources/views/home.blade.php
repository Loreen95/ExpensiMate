@extends('welcome')

@section('content')
<div class="flex flex-col">
    <!-- Hero Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-semibold mb-6">Take Control of Your Finances</h1>
            <p class="text-lg text-gray-300 mb-8">Simplify your financial life with Expensimate</p>
            <a href="#" class="mt-6 inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-8 rounded-full transition duration-300 ease-in-out transform hover:scale-105">Get Started</a>
        </div>
    </div>

    <!-- Key Features Section -->
    <div class="container mx-auto my-16">
        <div class="flex flex-col items-center text-center mb-8">
            <h2 class="text-3xl font-semibold mb-8">Key Features</h2>
            
            <!-- Feature 1 -->
            <div class="mb-8 px-6 pt-5 shadow-lg rounded-lg bg-platinum">
                <div class="bg-red-600 p-6 rounded-full w-20 h-20 flex items-center justify-center mx-auto">
                    <!-- Feature Icon (replace with your icon) -->
                    <i class="fas fa-chart-pie text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mt-3">Expense Tracking</h3>
                <p class="mt-3 text-gray-700">Effortlessly track your expenses and understand where your money goes.</p>
            </div>

            <!-- Feature 2 -->
            <div class="mb-8 px-12 pt-5 shadow-lg rounded-lg bg-platinum">
                <div class="bg-red-600 p-6 rounded-full w-20 h-20 flex items-center justify-center mx-auto">
                    <!-- Feature Icon (replace with your icon) -->
                    <i class="fas fa-chart-pie text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mt-3">Bill Reminders</h3>
                <p class="mt-3 text-gray-700">Never miss a payment with timely bill reminders and notifications.</p>
            </div>

            <!-- Feature 3 -->
            <div class="px-20 pt-5 shadow-lg rounded-lg bg-platinum">
                <div class="bg-red-600 p-6 rounded-full w-20 h-20 flex items-center justify-center mx-auto">
                    <!-- Feature Icon (replace with your icon) -->
                    <i class="fas fa-chart-pie text-4xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mt-6">Budgeting Tools</h3>
                <p class="mt-3 text-gray-700">Create and manage budgets to reach your financial goals.</p>
            </div>
        </div>
    </div>

    <!-- Contact Us Section -->
    <div class="bg-gray-200 py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-semibold mb-8">Contact Us</h2>
            <!-- Contact Form -->
            <div class="w-1/2 mx-auto">
                <form action="#" method="post" class="mb-8">
                    <div class="mb-4">
                        <label for="name" class="block text-xl mb-2 text-gray-600">Your Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-600" placeholder="John Doe">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-xl mb-2 text-gray-600">Your Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-600" placeholder="johndoe@example.com">
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-xl mb-2 text-gray-600">Your Message</label>
                        <textarea id="message" name="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-600" placeholder="Your message here"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
