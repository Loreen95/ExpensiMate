<div class="js-cookie-consent cookie-consent absolute top-0 inset-x-0" id="cookie-consent-dialog">
    <div class="w-full mx-auto">
        <div class="p-2 bg-neutral">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-full md:w-4/5">
                    <p class="ml-3 text-black cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="w-full md:w-1/5 mt-2 md:mt-0">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer ml-28 flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-text bg-white border border-black hover:bg-white" id="accept-cookies-button">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>