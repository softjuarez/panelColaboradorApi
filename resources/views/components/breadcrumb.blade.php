<div class="max-w-[100rem] px-5 py-4 pt-6 lg:pt-10 sm:px-7 lg:px-9 lg:py-4 mx-auto">
    
    <ol class="flex items-center whitespace-nowrap" aria-label="Breadcrumb">
        <li class="flex items-center">
            <a class="text-sm text-gray-500 dark:text-white hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('dashboard')}}">
                <div class="flex">
                    <svg class="me-3 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    {{ __('Go Home') }}
                </div>
            </a>
        </li>
        @yield('breadcrumbs')
    </ol>
</div>