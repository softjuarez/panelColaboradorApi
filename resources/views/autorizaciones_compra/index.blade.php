<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Autorizacion de Requisiciones Compra') }}
        </a>
    </li>
    @endsection

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="border-b border-gray-200 dark:border-neutral-700">
            <nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200 active" id="card-type-tab-item-1" aria-selected="true" data-hs-tab="#card-type-tab-preview" aria-controls="card-type-tab-preview" role="tab">
                Asignacion de Gestor
                </button>
                <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-2" aria-selected="false" data-hs-tab="#card-type-tab-2" aria-controls="card-type-tab-2" role="tab">
                Gestion de Cotizaciones
                </button>
                <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-3" aria-selected="false" data-hs-tab="#card-type-tab-3" aria-controls="card-type-tab-3" role="tab">
                Validacion de Compra
                </button>
            </nav>
        </div>


        <div class="bg-white border shadow-sm rounded-b overflow-hidden dark:bg-slate-900 dark:border-gray-700">
            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                <!-- Input -->
                <div class="sm:col-span-1">
                    <div class="flex items-center gap-x-4">
                        <div class="relative flex rounded-lg shadow-sm w-full">
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
                </div>
                <!-- End Input -->
            </div>
            <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
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
                                    {{ __('Gestor') }}
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

                    <tbody id="requisiciones_asignar_gestor" class="divide-y divide-gray-200 dark:divide-gray-700">

                    </tbody>
                </table>
                <!-- End Table -->
            </div>
            <div id="card-type-tab-2" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-2">
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
                                    {{ __('Gestor') }}
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

                    <tbody id="requisiciones_gestion_compra" class="divide-y divide-gray-200 dark:divide-gray-700">

                    </tbody>
                </table>
                <!-- End Table -->
            </div>
            <div id="card-type-tab-3" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-3">
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
                                    {{ __('Gestor') }}
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

                    <tbody id="requisiciones_validacion_compra" class="divide-y divide-gray-200 dark:divide-gray-700">

                    </tbody>
                </table>
                <!-- End Table -->
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            </div>
        </div>



    </div>

    <script>
        let input = document.getElementById('hs-leading-button-add-on-with-icon-and-button');
        const searchButton = document.getElementById('search-button');
        const clearButton = document.getElementById('clear-button');


        function search()
        {
           actualizarTablas();
        }


        function keySearch()
        {
            if (event.key === "Enter") {
                search();
            }
        }

        function toggleClearButton() {
            if (input.value.trim() !== '') {
                clearButton.classList.remove('hidden');
            } else {
                clearButton.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
           actualizarTablas();
        });

        function actualizarTablas()
        {
            const asignar_gestor = document.getElementById('requisiciones_asignar_gestor')
            const gestion_compra = document.getElementById('requisiciones_gestion_compra')
            const validacion_compra = document.getElementById('requisiciones_validacion_compra')

            var url = '{{ route("autoriza-compra.listado", ":search") }}';
            if (input.value == '') {
                url = '{{ route("autoriza-compra.listado") }}';
            } else {
                url = url.replace(':search', input.value == '' ? '' : input.value);
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    fillTable(data.requisiciones_asignar_gestor, asignar_gestor);
                    fillTable(data.requisiciones_gestion_compra, gestion_compra);
                    fillTable(data.requisiciones_validacion_compra, validacion_compra);
                })
                .catch(error => {
                    console.error('Error al obtener los datos:', error);
                });
        }

        toggleClearButton();

        input.addEventListener('input', function () {
            toggleClearButton();
        });

        clearButton.addEventListener('click', function () {
            input.value = '';
            search();
            toggleClearButton()
        });

        searchButton.addEventListener('click', function () {
            const searchTerm = input.value.trim();
            if (searchTerm !== '') {
                search();
            } else {
                alert('Por favor, ingresa un término de búsqueda.');
            }
        });

        function fillTable(data, tbody)
        {
            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                        <td colspan="7">
                            <div class="max-w-sm w-full min-h-[300px] flex flex-col justify-center text-center items-center mx-auto px-6 py-4">
                                <div class="flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-text flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9.5 8h5"/><path d="M9.5 12H16"/><path d="M9.5 16H14"/></svg>
                                </div>
                                <h2 class="mt-5 font-semibold text-gray-800 dark:text-white">
                                    No se encontraron registros
                                </h2>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            const rows = data.map(item => {
                const fecha = item.FECHA ? new Date(item.FECHA).toLocaleDateString('es-ES') : '';
                const solicitante = item.SOLICITANTE ?
                    item.SOLICITANTE.toLowerCase()
                        .split(' ')
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                        .join(' ') : '';
                const comentarios = item.COMENTARIOS ?
                    (item.COMENTARIOS.length > 50 ?
                        item.COMENTARIOS.substring(0, 50) + '...' :
                        item.COMENTARIOS) : '';

                return `
                    <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                        <td class="h-px w-px  align-center">
                            <a class="block py-2 px-6" href="#">
                                <span class="text-sm text-gray-600 dark:text-gray-400">${item.NUMERO || ''}</span>
                            </a>
                        </td>
                        <td class="h-px w-px  align-center">
                            <a class="block py-2 px-6" href="#">
                                <span class="text-sm text-gray-600 dark:text-gray-400">${fecha}</span>
                            </a>
                        </td>
                        <td class="h-px w-px  align-center">
                            <a class="block py-2 px-6" href="#">
                                <span class="text-sm text-gray-600 dark:text-gray-400">${solicitante}</span>
                            </a>
                        </td>
                        <td class="h-px w-px  align-center">
                            <a class="block py-2 px-6" href="#">
                                <span class="text-sm text-gray-600 dark:text-gray-400">${item.gestor_nombre}</span>
                            </a>
                        </td>
                        <td class="h-px w-px  align-center">
                            <a class="block py-2 px-6" href="#">
                                <span class="text-sm text-gray-600 dark:text-gray-400">${item.estado || ''}</span>
                            </a>
                        </td>
                        <td class="h-px w-px  align-center">
                            <a class="block py-2 px-6" href="#">
                                <span class="text-sm text-gray-600 dark:text-gray-400">${comentarios}</span>
                            </a>
                        </td>
                        <td class="h-px w-px whitespace-nowrap align-center text-center">
                            <a class="flex items-center py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="${item.link}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil w-4">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                    <path d="m15 5 4 4"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');

            tbody.innerHTML = rows;
        }
    </script>
</x-app-layout>
