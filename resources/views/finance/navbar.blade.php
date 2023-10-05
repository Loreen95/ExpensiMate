<div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto py-2 bg-blue">
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col ml-6 p-4 md:p-0 mt-4 md:flex-row md:space-x-8 md:mt-0 md:border-0 relative">
            <li>
                <a href=" {{ route('finance.category_add') }} " class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white"> 
                    {{ trans('dashboard.finance.categories') . ' ' . trans('dashboard.finance.add') }} 
                </a>
            </li>
            <li>
                <a href=" {{ route('finance.cost_add') }} " class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white"> 
                    {{ trans('dashboard.finance.expenses') . ' ' . trans('dashboard.finance.add') }} 
                </a>
            </li>
            <li>
                <a href=" {{ route('finance.graph') }} " class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white"> 
                    {{ trans('dashboard.finance.graph') }} 
                </a>
            </li>
            <li>
                <a href=" {{ route('finance.paid-bills') }} " class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white"> 
                    {{ trans('dashboard.finance.paid') }} 
                </a>
            </li>
        </ul>
    </div>
</div>
