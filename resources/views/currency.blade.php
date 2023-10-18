@extends('layout')

@section('content')
    <table class="w-3/4 text-sm text-left mt-12" id="exchange-rates-table">
        <thead class="text-xs text-silver uppercase bg-oxford dark:bg-oxford dark:text-silver">
            <tr>
                <th scope="col" class="text-center px-6 py-3">Currency</th>
                <th scope="col" class="text-center px-6 py-3"></th>
            </tr>
        </thead>
        <tbody id="exchange-rates">
            <!-- Exchange rates will be populated here -->
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Retrieve the selected currency from localStorage
        const userSelectedCurrency = localStorage.getItem('selectedCurrency') || 'USD';
    
        // Function to display and calculate the currency exchange
        function displayCurrencyExchange(rates) {
            const tableBody = $('#exchange-rates');
            tableBody.empty();
    
            for (const currency in rates) {
                if (rates.hasOwnProperty(currency)) {
                    const rate = rates[currency];
                    // Calculate the exchange rate based on the selected currency
                    const exchangeRate = 1 / rates[userSelectedCurrency];
    
                    // Use the user's selected currency in the row
                    tableBody.append(`
                        <tr class="bg-white border-y dark:bg-white dark:border-black">
                            <td class="border-r border-black px-6 py-3 text-center">${currency}</td>
                            <td class="px-6 py-3 text-center">1 ${userSelectedCurrency} = ${exchangeRate * rate} ${currency}</td>
                        </tr>
                    `);
                }
            }
        }
    
        const API_URL = `https://v6.exchangerate-api.com/v6/75dc88fbc606cc4f18da9627/latest/${userSelectedCurrency}`;
    
        fetch(API_URL)
            .then(response => response.json())
            .then(data => {
                const rates = data.conversion_rates;
                displayCurrencyExchange(rates); // Display and calculate currency exchange
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
    
    
@endsection
