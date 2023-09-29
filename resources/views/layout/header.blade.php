<div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="{{ url('/') }}" class="flex items-center text-white py-2 pl-3 pr-4">ExpensiMate</a>
    <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-default" aria-expanded="false">
    <span class="sr-only">Open main menu</span>
    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
    </svg>
</button>
<div class="hidden w-full md:block md:w-auto" id="navbar-default">
    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 md:flex-row md:space-x-8 md:mt-0 md:border-0 relative">
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
        <li class="relative">
            <button class="flex items-center focus:outline-none mt-1 lang-dropdown-button">
                <span class="fi fi-gb" id="flag-icon"></span>
            </button>
            <div class="absolute hidden mt-8 w-7 bg-white lang-dropdown-menu" style="left: -1.2px;">
                <ul>
                    <li>
                        <a href="{{ route('lang.switch', 'en') }}" class="block py-2 ml-1 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                            <span class="fi fi-gb" id="flag-en"></span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lang.switch', 'nl') }}" class="block py-2 ml-1 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white">
                            <span class="fi fi-nl" id="flag-nl"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>


<script>
    // Navbar controls:
    const navbarToggle = document.querySelector('[data-collapse-toggle="navbar-default"]');
    const navbarMenu = document.getElementById('navbar-default');
    
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
    
    // Add a click event listener to the button to toggle the navigation menu
    navbarToggle.addEventListener('click', () => {
        navbarMenu.classList.toggle('hidden');
    });

    // Add a click event listener to the language dropdown button to toggle the language dropdown menu
    langDropdownButton.addEventListener('click', () => {
        langDropdownMenu.classList.toggle('hidden');
    });

    // Add a click event listener to switch the flag icon when a language is selected
    langDropdownMenu.addEventListener('click', (event) => {
        const selectedLanguage = event.target.getAttribute('href');
        
        // Update the class of the flag icon based on the selected language URL
        if (selectedLanguage === '{{ route('lang.switch', 'en') }}') {
            flagIcon.classList.remove('fi-nl');
            flagIcon.classList.add('fi-gb');
            setSelectedLanguage('en'); // Store the selected language preference
        } else if (selectedLanguage === '{{ route('lang.switch', 'nl') }}') {
            flagIcon.classList.remove('fi-gb');
            flagIcon.classList.add('fi-nl');
            setSelectedLanguage('nl'); // Store the selected language preference
        }

        // Close the dropdown menu
        langDropdownMenu.classList.add('hidden');
    });
</script>