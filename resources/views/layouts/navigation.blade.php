<header class="sticky top-0 inset-x-0 flex flex-wrap sm:justify-start sm:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 sm:py-4 dark:bg-gray-800 dark:border-gray-700">
    <nav class="flex basis-full items-center w-full mx-auto px-4 sm:px-6 md:px-8 max-w-[100rem]" aria-label="Global">
        <div class="lg:me-0 lg:hidden">
            <button type="button" class="hs-collapse-toggle p-2 inline-flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-gray-700 dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#docs-sidebar" aria-controls="docs-sidebar" aria-label="Toggle navigation">
                <svg class="hs-collapse-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                <svg class="hs-collapse-open:block hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <div class="w-full flex items-center ms-auto justify-between sm:gap-x-3 sm:order-3">
            <div class="flex items-center ">
                <button type="button" class="hs-collapse-toggle hidden lg:inline-flex p-2 justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-gray-700 dark:text-white dark:hover:bg-white/10 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#docs-sidebar" aria-controls="docs-sidebar" aria-label="Toggle navigation">
                    <svg class="hs-collapse-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
                    <svg class="hs-collapse-open:block hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>

                <div class="flex items-center justify-between pl-3 ml-3 border-l sm:border-gray-300 hs-dark-mode-active:border-gray-700">
                    <a class="flex-none text-xl font-semibold dark:text-white" href="#" aria-label="Brand">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 hs-dark-mode-active:text-white" />
                    </a>
                </div>
            </div>

            <div class="flex flex-row items-center justify-end gap-2">
                @if (auth()->user()->type == 'I')
                <div class="flex items-center">
                    <span class="mr-2 text-gray-700 dark:text-white">{{ Str::title(auth()->user()->nombreDeFichaActiva()) }}</span>
                    <div class="hs-dropdown relative [--auto-close:inside] inline-flex">
                        <button id="hs-dropdown-preview-navbar" type="button" class="hs-dropdown-toggle  group relative flex justify-center items-center size-8 text-xs rounded-full text-gray-800 hover:bg-gray-100 focus:bg-gray-100 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            <span class="">
                              <svg class=" size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </span>
                        </button>

                        <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-full md:w-[450px] transition-[opacity,margin] duration opacity-0 hidden z-30 overflow-hidden border border-gray-200 bg-white rounded-xl shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)] dark:bg-neutral-800 dark:border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-preview-navbar">
                            <!-- Tab -->
                            <div class="p-3 pb-0 flex flex-wrap justify-between items-center gap-3 border-b border-gray-200 dark:border-neutral-700">
                                <!-- Nav Tab -->
                                <nav class="flex  gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                                    <button type="button" class="hs-tab-active:after:bg-gray-800 hs-tab-active:text-gray-800 px-2 py-1.5 mb-2 relative inline-flex justify-center items-center gap-x-2 text-nowrap  hover:bg-gray-100 text-gray-500 hover:text-gray-800 text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 after:absolute after:-bottom-2 after:inset-x-2 after:z-10 after:h-0.5 after:pointer-events-none dark:hs-tab-active:text-neutral-200 dark:hs-tab-active:after:bg-neutral-400 dark:text-neutral-500 dark:hover:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 active " id="hs-pmn-item-free" aria-selected="true" data-hs-tab="#hs-pmn-free" aria-controls="hs-pmn-free" role="tab">
                                        Fichas Asignadas
                                    </button>
                                </nav>
                                <!-- End Nav Tab -->
                            </div>

                            <div id="hs-pmn-free" class="" role="tabpanel" aria-labelledby="hs-pmn-item-free">
                                <div class="grid py-2">
                                    @forEach(auth()->user()->fichas as $ficha)
                                        <a class="px-4 py-1 flex items-center justify-between odd:bg-white even:bg-gray-100 hover:bg-gray-50 text-gray-700 dark:text-white" href="{{ route('fichas.seleccionar', $ficha) }}">
                                            {{ $ficha->NOMBRE }}
                                            <div class="flex items-center gap-1">
                                                @if ($ficha->pivot->referencia == 's')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-user-round text-gray-700"><path d="M18 20a6 6 0 0 0-12 0"/><circle cx="12" cy="10" r="4"/><circle cx="12" cy="12" r="10"/></svg>
                                                @endif
                                                @if (auth()->user()->fichaActiva() == $ficha->NUMERO)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check text-gray-700"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                                @endif
                                            </div>
                                        </a>
                                    @endforEach
                                </div>
                            </div>
                            <!-- End Header -->
                        </div>
                    </div>
                </div>
                @endif

                <div class="hs-dropdown relative inline-flex [--auto-close:inside] [--placement:bottom-right]">
                    @if(auth()->user()->foto)
                    <div class="h-[2.375rem] w-[2.375rem]">
                        <img class="w-full object-contain rounded-full" src="{{ asset(auth()->user()->foto) }}" alt="Foto de perfil">
                    </div>
                    @else
                        <button id="hs-dropdown-with-header" type="button" class="w-10 h-9 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent dark:border-transparent text-gray-800  disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:focus:outline-none ">
                            <span class="inline-flex items-center justify-center h-[2.375rem] w-[2.375rem] rounded-full bg-blue-600 dark:bg-gray-700 hover:bg-blue-700 dark:hover:bg-gray-600">
                                <span class="font-bold text-white leading-none dark:text-gray-200">{{ Str::of(auth()->user()->name)->charAt(0) }}</span>
                            </span>
                        </button>
                    @endif

                    <div class="hs-dropdown-menu transition-[opacity,margin] duration-400 hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem] bg-white shadow-md rounded-lg p-2 dark:bg-gray-800 dark:border dark:border-gray-700" aria-labelledby="hs-dropdown-with-header">
                        <div class="py-3 px-5 -m-2 bg-gray-100 rounded-t-lg dark:bg-gray-700">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Signed in as') }}</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-300">{{ auth()->user()->email }}</p>
                        </div>
                        <div class="mt-2 py-2 first:pt-0 last:pb-0">
                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('profile.edit') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 w-4 h-4 lucide lucide-circle-user-round">
                                    <path d="M18 20a6 6 0 0 0-12 0"/>
                                    <circle cx="12" cy="10" r="4"/>
                                    <circle cx="12" cy="12" r="10"/>
                                </svg>
                                {{ __('Profile') }}
                            </a>

                            <div class="flex items-center justify-between gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                <div class="flex items-center gap-x-3.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon flex-shrink-0 w-4 h-4 "><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                                    {{ __('Dark Mode') }}
                                </div>

                                <div class="flex items-center">
                                    <input data-hs-theme-switch type="checkbox" id="hs-small-switch" class="relative w-9 h-5 p-px bg-gray-100 border-transparent text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-600 checked:border-blue-600 focus:checked:border-blue-600 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-600

                                    before:inline-block before:w-[1rem] before:h-[1rem] before:bg-white checked:before:bg-blue-200 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-gray-400 dark:checked:before:bg-blue-200" id="darkSwitch">
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 w-4 h-4 lucide lucide-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" x2="9" y1="12" y2="12"/>
                                    </svg>
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<div id="docs-sidebar" class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 start-0 bottom-0 z-[60] w-64 bg-white border-e border-gray-200 pt-7 pb-10 overflow-y-auto   [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-center px-6">
        <a class="flex-none text-xl font-semibold dark:text-white" href="#" aria-label="Brand">
            <x-application-isologo class="block h-16 w-auto fill-current text-gray-800 hs-dark-mode-active:text-white" />
        </a>
    </div>
    <nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
        <ul class="space-y-1.5">
            <li>
                <a class="flex items-center gap-x-3.5 py-2 px-2.5 bg-gray-100 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:bg-gray-900 dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('dashboard') }}">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    {{ __('Dashboard') }}
                </a>
            </li>

            @if (Auth::user()->hasPermission('show-user') || Auth::user()->hasPermission('show-role') || Auth::user()->hasPermission('show-permission'))
            <li class="hs-accordion" id="users-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    {{ __('Users') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="users-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-user'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('users.index') }}">
                                {{ __('Listado') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-externo'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('externos.index') }}">
                                {{ __('Externos') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-role'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('roles.index') }}">
                                {{ __('Roles') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-permission'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('permissions.index') }}">
                                {{ __('Permissions') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->hasPermission('show-ficha') || Auth::user()->hasPermission('show-tipo_adjunto') || Auth::user()->hasPermission('show-tipo_solicitud') || Auth::user()->hasPermission('show-noticia') || Auth::user()->hasPermission('show-gestor') || Auth::user()->hasPermission('show-tipo_permiso'))
            <li class="hs-accordion" id="catalogos-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-user w-4 h-4"><path d="M15 13a3 3 0 1 0-6 0"/><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><circle cx="12" cy="8" r="2"/></svg>

                    {{ __('Catalogos') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="catalogos-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-ficha'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('fichas.index') }}">
                                {{ __('Fichas') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-tipo_adjunto'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('tipo_adjuntos.index') }}">
                                {{ __('Tipo de documentos') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-tipo_solicitud'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('tipo_solicitudes.index') }}">
                                {{ __('Tipo de Solicitudes') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-tipo_permiso'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('tipo_permisos.index') }}">
                                {{ __('Tipo de Permisos') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-tipo_licencia'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('tipo_licencias.index') }}">
                                {{ __('Tipo de Licencias') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-noticia'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('noticias.index') }}">
                                {{ __('Noticias') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-gestor'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('gestores.index') }}">
                                {{ __('Gestores') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->hasPermission('show-reporte_recibo') || Auth::user()->hasPermission('show-adjunto') || Auth::user()->hasPermission('show-periodo_vacacion') || Auth::user()->hasPermission('show-anniversary') || Auth::user()->hasPermission('show-birthday') || Auth::user()->hasPermission('show-reporte_bitacora') || Auth::user()->hasPermission('show-reporte_responsabilidad'))
            <li class="hs-accordion" id="reportes-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt-text w-4 h-4"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M14 8H8"/><path d="M16 12H8"/><path d="M13 16H8"/></svg>

                    {{ __('Consultas') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="reportes-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-reporte_recibo'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('recibos.lanucher') }}">
                                {{ __('Recibos de Pago') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-adjunto'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('adjuntos.index') }}">
                                {{ __('Documentos') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-periodo_vacacion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('periodo_vacaciones.index') }}">
                                {{ __('Vacaciones') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-anniversary'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('aniversarios.index') }}">
                                {{ __('Aniversarios') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-birthday'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('cumpleanios.index') }}">
                                {{ __('Cumpleaños') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-reporte_bitacora'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('bitacora.lanucher') }}">
                                {{ __('Bitacora') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-reporte_responsabilidad'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('responsabilidad.lanucher') }}">
                                {{ __('Ficha de Responsabilidad') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if ( Auth::user()->hasPermission('show-solicitud') || Auth::user()->hasPermission('show-solicitud_vacacion') || Auth::user()->hasPermission('show-autoriza_solicitud_vacacion') || Auth::user()->hasPermission('show-rrhh_solicitud_vacacion') || Auth::user()->hasPermission('show-solicitud_permiso'))
            <li class="hs-accordion" id="transacciones-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right-left w-4 h-4"><path d="m16 3 4 4-4 4"/><path d="M20 7H4"/><path d="m8 21-4-4 4-4"/><path d="M4 17h16"/></svg>
                    {{ __('Gestión Humana') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="transacciones-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-solicitud'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('solicitudes.index') }}">
                                {{ __('Solicitudes Varias') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza_solicitud'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza_solicitudes.index') }}">
                                {{ __('Gestión de solicitudes GH') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-solicitud_vacacion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('solicitud_vacaciones.index') }}">
                                {{ __('Solicitud de Vacaciones') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza_solicitud_vacacion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza_solicitud_vacaciones.index') }}">
                                {{ __('Autoriza Solicitud de Vacaciones') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-rrhh_solicitud_vacacion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('rrhh_solicitud_vacaciones.index') }}">
                                {{ __('Gestión de vacaciones GH') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-licencia'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('licencias.index') }}">
                                {{ __('Solicitud de Licencias') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza_licencia'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza_licencias.index') }}">
                                {{ __('Autoriza Solicitud de Licencias') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-validar_licencia'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('validar_licencias.index') }}">
                                {{ __('Gestión de Solicitud de Licencias GH') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-solicitud_permiso'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('solicitud_permisos.index') }}">
                                {{ __('Solicitud de Permisos') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza_solicitud_permiso'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza_solicitud_permisos.index') }}">
                                {{ __('Autoriza Solicitud de Vacaciones') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-validacion_solicitud_permiso'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('validacion_solicitud_permisos.index') }}">
                                {{ __('Gestión de Validacion Solicitud de Permisos GH') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->hasPermission('show-requisicion') || Auth::user()->hasPermission('show-autoriza-jefe') || Auth::user()->hasPermission('show-autoriza-ppto') || Auth::user()->hasPermission('show-autoriza-tesoreria') || Auth::user()->hasPermission('show-autoriza-compra') || Auth::user()->hasPermission('show-autoriza-gestor') || Auth::user()->hasPermission('show-autoriza-comite') || Auth::user()->hasPermission('show-consulta_requisicion'))
            <li class="hs-accordion" id="transacciones-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="18" height="14" x="3" y="5" rx="2" ry="2"/><path d="M7 15h4M15 15h2M7 11h2M13 11h4"/></svg>
                    {{ __('Gestión Compras') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="transacciones-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-requisicion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('requisiciones.index') }}">
                                {{ __('Solicitud') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza-jefe'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza-jefe.index') }}">
                                {{ __('Autorización Jefe') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza-ppto'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza-ppto.index') }}">
                                {{ __('Validación Presupuesto') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza-tesoreria'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza-tesoreria.index') }}">
                                {{ __('Autorización Tesorería') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza-compra'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza-compra.index') }}">
                                {{ __('Validación Compras') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza-gestor'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza-gestor.index') }}">
                                {{ __('Gestión Cotizaciones') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-autoriza-comite'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('autoriza-comite.index') }}">
                                {{ __('Autorización Comite') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-consulta_requisicion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('consulta_requisiciones.lanucher') }}">
                                {{ __('Consulta de Requisiciones') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif



            @if (Auth::user()->hasPermission('show-orden_compra') || Auth::user()->hasPermission('show-documento'))
            <li class="hs-accordion" id="transacciones-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>

                    {{ __('Gestion Proveedor') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="transacciones-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-orden_compra'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('ordenes_compra.index') }}">
                                {{ __('Ordenes') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-documento'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('documentos.index') }}">
                                {{ __('Documentos') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->hasPermission('show-orden_compra_proveedor'))
            <li class="hs-accordion" id="transacciones-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>

                    {{ __('Gestion Financiera') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="transacciones-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-orden_compra_proveedor'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('ordenes_proveedor.index') }}">
                                {{ __('Ordenes') }}
                            </a>
                        </li>
                        @endif
                        @if (Auth::user()->hasPermission('show-documento_proveedor'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('documentos_proveedor.index') }}">
                                {{ __('Documentos') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->hasPermission('show-organigrama') || Auth::user()->hasPermission('show-visualizar_organigrama'))
            <li class="hs-accordion" id="transacciones-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-git-fork-icon lucide-git-fork w-4 h-4"><circle cx="12" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><circle cx="18" cy="6" r="3"/><path d="M18 9v2c0 .6-.4 1-1 1H7c-.6 0-1-.4-1-1V9"/><path d="M12 12v3"/></svg>
                    {{ __('Organigramas') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="transacciones-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-organigrama'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('organigramas.index') }}">
                                {{ __('Editar Organigramas') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-visualizar_organigrama'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('visualizador_organigramas.index') }}">
                                {{ __('Ver Organigramas') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->hasPermission('show-configuracion') || Auth::user()->hasPermission('show-feriado'))
            <li class="hs-accordion" id="transacciones-accordion">
                <button type="button" class="hs-accordion-toggle hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:hs-accordion-active:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 w-4 h-4"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><circle cx="12" cy="12" r="4"/></svg>
                    {{ __('Configuraciones') }}

                    <svg class="hs-accordion-active:block ms-auto hidden w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 15-6-6-6 6"/>
                    </svg>

                    <svg class="hs-accordion-active:hidden ms-auto block w-4 h-4 text-gray-600 group-hover:text-gray-500 dark:text-gray-400" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div id="transacciones-accordion" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden">
                    <ul class="pt-2 ps-2">
                        @if (Auth::user()->hasPermission('show-configuracion'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('configuraciones.index') }}">
                                {{ __('Sistema') }}
                            </a>
                        </li>
                        @endif

                        @if (Auth::user()->hasPermission('show-feriado'))
                        <li>
                            <a class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-900  dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{ route('feriados.index') }}">
                                {{ __('Feriados') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if (auth()->user()->type == 'I')
            <li>
                <a href="{{ route('noticias.bandeja') }}" class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 w-4 h-4"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
                    {{ __('Noticias') }}
                </a>
            </li>
            @endif

            <li>
                <a class="w-full flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-slate-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 dark:text-slate-400 dark:hover:text-slate-300 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#" data-hs-overlay="#hs-modal-upgrade-to-pro">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info flex-shrink-0 w-4 h-4">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4"/>
                        <path d="M12 8h.01"/>
                    </svg>
                    {{ __('About SID') }}
              </a>
            </li>
        </ul>
    </nav>
</div>

<div id="hs-modal-upgrade-to-pro" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
      <div class="bg-white border border-gray-200 rounded-xl shadow-sm pointer-events-auto dark:bg-gray-800 dark:border-gray-700">
        <div class="p-4 sm:p-7">
          <div class="text-center">
            <x-application-isologo class="inline-flex justify-center h-12 w-auto fill-current text-gray-800 hs-dark-mode-active:text-white" />
            <div class="max-w-sm mx-auto">
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    © {{ date('Y') }} <a href="https://sidgt.com/" class="hover:underline" target="_blank">Delta</a>. {{ __('All rights reserved.') }}
                </p>
            </div>
            <div class="mt-5 text-gray-600 dark:text-gray-400">
                <h2>{{ __('You can contact our customer service by') }}</h2>
            </div>
          </div>

          <div class="mt-4 divide-y divide-gray-200 dark:divide-gray-700">
            <!-- Icon -->
            <div class="flex gap-x-7 py-3 first:pt-0 last:pb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mt-1 w-7 h-7 text-gray-600 dark:text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-incoming">
                    <polyline points="16 2 16 8 22 8"/>
                    <line x1="22" x2="16" y1="2" y2="8"/>
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>

                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('Telephone') }}:
                    </h3>
                    <p class="text-sm text-gray-500">
                        +(502) 3028-1454
                    </p>
                </div>
            </div>
            <!-- End Icon -->

            <!-- Icon -->
            <div class="flex gap-x-7 py-3 first:pt-0 last:pb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mt-1 w-7 h-7 text-gray-600 dark:text-gray-400" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail">
                    <rect width="20" height="16" x="2" y="4" rx="2"/>
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                </svg>

                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('Email') }}:
                    </h3>
                    <p class="text-sm text-gray-500">
                        soporte.udv@sidgt.com
                    </p>
                </div>
            </div>

            <div class="flex gap-x-7 py-3 first:pt-0 last:pb-0">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-1 w-7 h-7 text-gray-600 dark:text-gray-400"><path d="M16 14v2.2l1.6 1"/><path d="M16 2v4"/><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M3 10h5"/><path d="M8 2v4"/><circle cx="16" cy="16" r="6"/></svg>

                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-200">
                        {{ __('Horario de atención') }}:
                    </h3>
                    <p class="text-sm text-gray-500">
                         De lunes a viernes de 8:00 a 17:30 horas
                    </p>
                </div>
            </div>
            <!-- End Icon -->
          </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end items-center gap-x-2 p-4 sm:px-7 border-t dark:border-gray-700">
          <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow-sm  disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-modal-upgrade-to-pro">
            {{ __('Close') }}
          </button>
        </div>
        <!-- End Footer -->
      </div>
    </div>
</div>

<script>
    const HSThemeAppearance = {
        init() {
            const defaultTheme = 'default'
            let theme = localStorage.getItem('hs_theme') || defaultTheme

            if (document.querySelector('html').classList.contains('dark')) return
            this.setAppearance(theme)
        },
        _resetStylesOnLoad() {
            const $resetStyles = document.createElement('style')
            $resetStyles.innerText = `*{transition: unset !important;}`
            $resetStyles.setAttribute('data-hs-appearance-onload-styles', '')
            document.head.appendChild($resetStyles)
            return $resetStyles
        },
        setAppearance(theme, saveInStore = true, dispatchEvent = true) {
            const $resetStylesEl = this._resetStylesOnLoad()

            if (saveInStore) {
                localStorage.setItem('hs_theme', theme)
            }

            if (theme === 'auto') {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default'
            }

            document.querySelector('html').classList.remove('dark')
            document.querySelector('html').classList.remove('default')
            document.querySelector('html').classList.remove('auto')

            document.querySelector('html').classList.add(this.getOriginalAppearance())

            setTimeout(() => {
                $resetStylesEl.remove()
            })

            if (dispatchEvent) {
                window.dispatchEvent(new CustomEvent('on-hs-appearance-change', {detail: theme}))
            }
        },
        getAppearance() {
            let theme = this.getOriginalAppearance()
            if (theme === 'auto') {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default'
            }
            return theme
        },
        getOriginalAppearance() {
            const defaultTheme = 'default'
            return localStorage.getItem('hs_theme') || defaultTheme
        }
    }
    HSThemeAppearance.init()

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (HSThemeAppearance.getOriginalAppearance() === 'auto') {
            HSThemeAppearance.setAppearance('auto', false)
        }
    })

    window.addEventListener('load', () => {
        const $clickableThemes = document.querySelectorAll('[data-hs-theme-click-value]')
        const $switchableThemes = document.querySelectorAll('[data-hs-theme-switch]')

        $clickableThemes.forEach($item => {
            $item.addEventListener('click', () => HSThemeAppearance.setAppearance($item.getAttribute('data-hs-theme-click-value'), true, $item))
        })

        $switchableThemes.forEach($item => {
            $item.addEventListener('change', (e) => {
                HSThemeAppearance.setAppearance(e.target.checked ? 'dark' : 'default')
            })

            $item.checked = HSThemeAppearance.getAppearance() === 'dark'
        })

        window.addEventListener('on-hs-appearance-change', e => {
            $switchableThemes.forEach($item => {
                $item.checked = e.detail === 'dark'
            })
        })
    })
</script>
  <!-- End Modal -->
