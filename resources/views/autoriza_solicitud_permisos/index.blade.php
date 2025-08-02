<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Solicitud de Permisos') }}
        </a>
    </li>
    @endsection

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                        <!-- Header -->
                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                            <!-- Input -->
                            <div class="flex items-start gap-4 sm:col-span-1">
                                <div class="flex items-center gap-x-4">
                                    <div class="relative flex rounded-lg shadow-sm w-full">
                                        <!-- Botón de buscar -->
                                        <div class="relative flex rounded-lg shadow-sm w-full">
                                            <!-- Botón de buscar -->
                                            <button type="button" id="search-button" class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                <svg id="search-icon" class="shrink-0 size-4 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="m21 21-4.3-4.3"></path>
                                                </svg>
                                            </button>

                                            <!-- Input -->
                                            <input type="text" id="hs-leading-button-add-on-with-icon-and-button" name="hs-leading-button-add-on-with-icon-and-button" class="block w-full border-gray-200 text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" onkeyup="keySearch()" value="{{ $search }}" placeholder="{{ __('Search') }}">

                                            <!-- Botón de limpiar (oculto inicialmente) -->
                                            <button type="button" id="clear-button" class="hidden py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none rounded-r-md" onclick="toggleClearButton()">
                                                <svg id="clear-icon" class="shrink-0 size-4 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="m13.5 8.5-5 5"></path>
                                                    <path d="m8.5 8.5 5 5"></path>
                                                    <circle cx="11" cy="11" r="8"></circle>
                                                    <path d="m21 21-4.3-4.3"></path>
                                                </svg>
                                            </button>
                                        </div>



                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" id="estado" class="peer relative w-11 h-6 p-px bg-gray-100 border border-gray-200 text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-100 checked:border-blue-200 focus:checked:border-blue-200 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-800/30 dark:checked:border-blue-800 dark:focus:ring-offset-gray-600

                                        before:inline-block before:size-5 before:bg-white checked:before:bg-blue-600 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-500" onchange="search()" @checked($estado == 1)>
                                        <label for="estado" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Todos</label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Input -->
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Id') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Tipo') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Solicitante') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Estado') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Comentarios') }}
                                        </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($solicitudes as $solicitud)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $solicitud->id }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $solicitud->tipo_solicitud->nombre }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ Str::of($solicitud->ficha->NOMBRE)->title() }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <div x-data="{
                                                colorMap: {
                                                    red: { background: '#fecdd3', color: '#f43f5e' },
                                                    green: { background: '#bbf7d0', color: '#22c55e' },
                                                    blue: { background: '#bae6fd', color: '#0ea5e9' },
                                                    yellow: { background: '#fef08a', color: '#eab308' },
                                                    purple: { background: '#e9d5ff', color: '#a855f7' }
                                                },
                                                colorEstado: '{{ $solicitud->obtenerColorEstado() }}',
                                                estado: '{{ $solicitud->obtenerEstado() }}'
                                            }">
                                                <span
                                                    x-bind:style="colorMap[colorEstado] || { background: '#f3f4f6', color: '#374151' }"
                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium">
                                                    {{ $solicitud->obtenerEstado() }}
                                                </span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($solicitud->descripcion, 50) }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center text-center">
                                        <div class="block py-2 px-6">
                                            <div class="hs-dropdown relative inline-block [--placement:bottom-right]">
                                                <button id="hs-table-dropdown-1" type="button" class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-2 rounded-sm text-gray-700 align-middle focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800">
                                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                                </svg>
                                                </button>
                                                <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-[10rem] z-10 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-gray-700 dark:bg-gray-800 dark:border dark:border-gray-700" aria-labelledby="hs-table-dropdown-1">
                                                    <div class="py-2 first:pt-0 last:pb-0">
                                                        @if (Auth::user()->hasPermission('edit-autoriza_solicitud_permiso'))
                                                        <a class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('autoriza_solicitud_permisos.edit', $solicitud) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil w-4">
                                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                                                <path d="m15 5 4 4"/>
                                                            </svg>
                                                            {{ __('Edit') }}
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td colspan="6">
                                        <div class="max-w-sm w-full min-h-[300px] flex flex-col justify-center text-center items-center mx-auto px-6 py-4">
                                            <div class="flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-text flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9.5 8h5"/><path d="M9.5 12H16"/><path d="M9.5 16H14"/></svg>
                                            </div>

                                            <h2 class="mt-5 font-semibold text-gray-800 dark:text-white">
                                                {{ __('No records found') }}
                                            </h2>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $solicitudes->links() }}
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let input = document.getElementById('hs-leading-button-add-on-with-icon-and-button');
        const searchButton = document.getElementById('search-button');
        const clearButton = document.getElementById('clear-button');
        const estadoCheckbox = document.getElementById('estado');


        function search()
        {
            let filtroEstado = document.querySelector('input[name="filtro_estado"]:checked');

            var url = '{{ route("autoriza_solicitud_permisos.index", [":estado", ":search"]) }}';
            url = url.replace(':search', input.value == '' ? '' : input.value);
            url = url.replace(':estado', estadoCheckbox.checked ? 1 : 0);
            window.location.href = url;
        }


        function keySearch()
        {
            if (event.key === "Enter") {
                search();
            }
        }
    </script>
</x-app-layout>
