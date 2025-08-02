<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Requisiciones') }}
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
                                </div>

                                <div class="hs-dropdown [--placement:bottom-right] relative inline-block" data-hs-dropdown-auto-close="inside">
                                    <button id="hs-as-table-table-filter-dropdown" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                      <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M7 12h10"/><path d="M10 18h4"/></svg>
                                      Estados
                                    </button>
                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-48 z-10 bg-white shadow-md rounded-lg mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-as-table-table-filter-dropdown">
                                      <div class="divide-y divide-gray-200 dark:divide-neutral-700">
                                        <label for="hs-as-filters-dropdown-all" class="flex py-2.5 px-3">
                                          <input name="filtro_estado" @checked($estado == 0) onchange="search()" value="0" type="radio" class="shrink-0 mt-0.5 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-all">
                                          <span class="ms-3 text-sm text-gray-800 dark:text-neutral-200">Todos</span>
                                        </label>
                                        <label for="hs-as-filters-dropdown-published" class="flex py-2.5 px-3">
                                          <input name="filtro_estado" @checked($estado == 'A') onchange="search()" value="A" type="radio" class="shrink-0 mt-0.5 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-published">
                                          <span class="ms-3 text-sm text-gray-800 dark:text-neutral-200">Sin Solicitar</span>
                                        </label>
                                        <label for="hs-as-filters-dropdown-pending" class="flex py-2.5 px-3">
                                          <input name="filtro_estado" @checked($estado == 'B') onchange="search()" value="B" type="radio" class="shrink-0 mt-0.5 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-pending">
                                          <span class="ms-3 text-sm text-gray-800 dark:text-neutral-200">Enviadas</span>
                                        </label>
                                        <label for="hs-as-filters-dropdown-pending" class="flex py-2.5 px-3">
                                            <input name="filtro_estado" @checked($estado == 'C') onchange="search()" value="C" type="radio" class="shrink-0 mt-0.5 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-pending">
                                            <span class="ms-3 text-sm text-gray-800 dark:text-neutral-200">Aceptadas</span>
                                        </label>
                                        <label for="hs-as-filters-dropdown-pending" class="flex py-2.5 px-3">
                                            <input name="filtro_estado" @checked($estado == 'D') onchange="search()" value="D" type="radio" class="shrink-0 mt-0.5 border-gray-300 rounded-sm text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-as-filters-dropdown-pending">
                                            <span class="ms-3 text-sm text-gray-800 dark:text-neutral-200">Autorizadas</span>
                                        </label>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Input -->
                            @if (Auth::user()->hasPermission('new-requisicion'))
                            <a href="{{ route('requisiciones.new') }}" class="py-3 px-4 flex justify-center items-center h-[2.875rem] w-[2.875rem] text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle flex-shrink-0 w-5 h-5"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                            </a>
                            @endif
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Numero') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Fecha') }}
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
                                @forelse ($requisiciones as $requisicion)
                                <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $requisicion->NUMERO }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ date('d/m/Y', strtotime($requisicion->FECHA)) }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ Str::of($requisicion->SOLICITANTE)->title() }}</span>
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
                                                colorEstado: '{{ $requisicion->obtenerColorEstado() }}',
                                                estado: '{{ $requisicion->obtenerEstado() }}'
                                            }">
                                                <span
                                                    x-bind:style="colorMap[colorEstado] || { background: '#f3f4f6', color: '#374151' }"
                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-lg text-xs font-medium">
                                                    {{ $requisicion->obtenerEstado() }}
                                                </span>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($requisicion->COMENTARIOS, 50) }}</span>
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
                                                        @if (Auth::user()->hasPermission('edit-requisicion'))
                                                        <a class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('requisiciones.edit', $requisicion) }}">
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
                            {{ $requisiciones->links() }}
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


        function search()
        {
            let filtroEstado = document.querySelector('input[name="filtro_estado"]:checked');

            var url = '{{ route("requisiciones.index", [":estado", ":search"]) }}';
            url = url.replace(':estado', filtroEstado.value);
            url = url.replace(':search', input.value == '' ? '' : input.value);
            window.location.href = url;
        }


        function keySearch()
        {
            if (event.key === "Enter") {
                search();
            }
        }

        // Función para mostrar u ocultar el botón de limpiar
        function toggleClearButton() {
            if (input.value.trim() !== '') {
                clearButton.classList.remove('hidden');
            } else {
                clearButton.classList.add('hidden');
            }
        }

        toggleClearButton();

        // Evento para el input
        input.addEventListener('input', function () {
            toggleClearButton();
        });

        // Evento para el botón de limpiar
        clearButton.addEventListener('click', function () {
            input.value = ''; // Limpiar el input
            search();
        });

        // Evento para el botón de buscar
        searchButton.addEventListener('click', function () {
            const searchTerm = input.value.trim();
            if (searchTerm !== '') {
                search();
            } else {
                alert('Por favor, ingresa un término de búsqueda.'); // Mensaje si el input está vacío
            }
        });
    </script>
</x-app-layout>
