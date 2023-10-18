<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    //
    public function index()
    {
        return view('currency');
    }

    public function selectCurrency()
    {
        // Fetch the list of available currencies from your exchange rate API
        $apiUrl = 'https://v6.exchangerate-api.com/v6/75dc88fbc606cc4f18da9627/latest/USD';

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();
            $currencies = array_keys($data['conversion_rates']);
        } else {
            // Handle the case where the API request fails
            $currencies = []; // Empty array as a fallback
        }

        return response()->json($currencies);
    }

    public function update(Request $request, $currency)
    {   
        $selectedCurrency = $request->input('currency', 'USD'); // Default to USD if not provided

        // Store the selected currency in the user's session
        $request->session()->put('selectedCurrency', $selectedCurrency);

        // You can also update the user's record in the database if needed

        return response()->json(['message' => 'Currency updated successfully']);
    }

    // public function currencyPage()
    // {
    //     $selectedCurrency = localStorage.getItem('selectedCurrency'); // Get the selected currency from local storage

    //     return view('currency', ['selectedCurrency' => $selectedCurrency]);
    // }
}
