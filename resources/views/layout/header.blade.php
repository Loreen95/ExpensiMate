<div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="{{ url('/') }}" class="flex items-center text-white py-2 pl-3 pr-4">ExpensiMate</a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-6 md:mt-0 md:border-0 relative">
            @if(Auth::check())
            <li>
                <a href=" {{ route('finance.index') }}" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                    {{ trans('general.finances') }}
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                    {{ trans('general.dashboard') }}
                </a>
            </li>
            @else
            <li>
                <a href="{{ route('register') }}" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                    {{ trans('general.register') }}
                </a>
            </li>
            <li>
                <a href="{{ route('login') }}" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                    {{ trans('general.login') }}
                </a>
            </li>
            @endif
            <li class="relative">
                <button class="flex items-center focus:outline-none mt-1 lang-dropdown-button">
                    <span class="fi fi-gb" id="flag-icon"></span>
                </button>
                <div class="absolute hidden mt-8 w-8 bg-white lang-dropdown-menu" style="left: -1.2px;">
                    <ul class="flex flex-col items-center">
                        <li>
                            <a href="{{ route('lang.switch', 'en') }}" class="block py-2 m-0.5 pl-2 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                                <span class="fi fi-gb" id="flag-en"></span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('lang.switch', 'nl') }}" class="block py-2 m-0.5 pl-2 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                                <span class="fi fi-nl" id="flag-nl"></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="relative">
                <button id="currencyToggle" class="flex items-center focus:outline-none curr-dropdown-button">
                    <span id="curr-icon" class="text-white">Currency</span>
                </button>
                <div id="currencyDropdown" class="absolute hidden mr-12 mt-7 w-16 bg-white curr-dropdown-menu" style="left: -20px; max-height: 150px; overflow-y: auto;">
                    <ul id="currencyList" class="flex flex-col items-center">
                        <!-- Create a container for the selected currency -->
                        <li id="selectedCurrencyContainer" class="py-2 m-0.5 pl-2 pr-4 text-black bg-blue-700 rounded md:bg-transparent md:text-black md:p-0 md:dark:text-black">
                            <span class="currency-label" id="selectedCurrencyLabel">Selected Currency</span>
                        </li>
                        <!-- Add your currency items here -->
                    </ul>
                </div>
            </li>            
        </ul>
    </div>
</div>

<script>

    // Navbar controls:
    const navbarToggle = document.querySelector('[data-collapse-toggle="navbar-default"]');
    const navbarMenu = document.getElementById('navbar-default');

    // Add a click event listener to the button to toggle the navigation menu
    navbarToggle.addEventListener('click', () => {
        navbarMenu.classList.toggle('hidden');
    });

    // Language dropdown controls:
    const langDropdownButton = document.querySelector('.lang-dropdown-button');
    const langDropdownMenu = document.querySelector('.lang-dropdown-menu');
    const flagIcon = document.getElementById('flag-icon'); // Select the flag icon span

    // Function to set the selected language in local storage
    function setSelectedLanguage(selectedLanguage) {
        localStorage.setItem('selectedLanguage', selectedLanguage);
    }

    // Function to get the selected language from local storage
    function getSelectedLanguage() {
        return localStorage.getItem('selectedLanguage');
    }

    // Check if a language preference is stored in local storage
    const storedLanguage = getSelectedLanguage();

    if (storedLanguage === 'en') {
        flagIcon.classList.remove('fi-nl');
        flagIcon.classList.add('fi-gb');
    } else if (storedLanguage === 'nl') {
        flagIcon.classList.remove('fi-gb');
        flagIcon.classList.add('fi-nl');
    }

    langDropdownButton.addEventListener('click', () => {
        langDropdownMenu.classList.toggle('hidden');
    });

    const currencyList = document.getElementById('currencyList');
    const apiKey = '52464bdf1d004996ba82b73e385eba0b'; // Replace with your API key
    const apiUrl = `https://openexchangerates.org/api/currencies.json?app_id=${apiKey}`;
    const currIconSpan = document.getElementById('curr-icon');

    function populateCurrencyDropdown(data) {
        for (const currencyCode in data) {
            if (data.hasOwnProperty(currencyCode)) {
                let html = `
                <li>
                    <a href="#" class="block py-2 m-0.5 pl-2 pr-4 text-black bg-blue-700 rounded md:bg-transparent md:text-black md:p-0 md:dark:text-black" data-currency="${currencyCode}">
                        <span class="currency-label">${currencyCode}</span>
                    </a>
                </li>`;
                currencyList.innerHTML += html;
            }
        }
    }

    // Function to update the selected currency container
    function updateSelectedCurrencyContainer(selectedCurrency) {
        const selectedCurrencyContainer = document.getElementById('selectedCurrencyContainer');
        const selectedCurrencyLabel = document.getElementById('selectedCurrencyLabel');
        selectedCurrencyContainer.classList.add('border-b-2'); // Add a border underneath
        selectedCurrencyLabel.textContent = selectedCurrency; // Update the label
    }


    // Function to set the selected currency in local storage
    function setSelectedCurrency(selectedCurrency) {
        localStorage.setItem('selectedCurrency', selectedCurrency);
    }

    // Function to get the selected currency from local storage
    function getSelectedCurrency() {
        return localStorage.getItem('selectedCurrency');
    }

   // Fetch currency data and populate the dropdown
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            populateCurrencyDropdown(data);

            // Get the selected currency from local storage
            const storedCurrency = getSelectedCurrency();

            // Now that the dropdown is populated, add the click event listeners
            const currencyLinks = currencyList.querySelectorAll('a[data-currency]');
            currencyLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent the default navigation
                    const selectedCurrency = this.getAttribute('data-currency');
                    setSelectedCurrency(selectedCurrency); // Store the selected currency in local storage
                    currIconSpan.textContent = selectedCurrency;
                    updateSelectedCurrencyContainer(selectedCurrency); // Update the selected currency container
                    console.log('Selected Currency: ' + selectedCurrency);
                });

                // If a currency is stored in local storage, set it as the current selection
                if (storedCurrency === link.getAttribute('data-currency')) {
                    currIconSpan.textContent = storedCurrency;
                    updateSelectedCurrencyContainer(storedCurrency);
                }
            });
        })
        .catch(error => {
            console.error('Error fetching currency data:', error);
    });
    // The rest of your event listener code
    const currDropdownButton = document.querySelector('#currencyToggle');
    const currDropdownMenu = document.getElementById('currencyDropdown');

    currDropdownButton.addEventListener('click', () => {
        currDropdownMenu.classList.toggle('hidden');
    });
</script>