<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Fichas') }}
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
                            <div class="sm:col-span-1">
                                <div class="flex items-center gap-x-4"> 
                                    <div class="relative flex rounded-lg shadow-sm w-full">
                                        <!-- Botón de buscar -->
                                        <button type="button" id="search-button" class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                            <svg id="search-icon" class="shrink-0 size-4 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <path d="m21 21-4.3-4.3"></path>
                                            </svg>
                                        </button>
                                
                                        <!-- Input -->
                                        <input type="text" id="hs-leading-button-add-on-with-icon-and-button" name="hs-leading-button-add-on-with-icon-and-button" class="block w-full border-gray-200 text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" onkeyup="keySearch()" value="{{ $search }}">
                                
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
                                    
                                    <div class="flex items-center">
                                        <input type="checkbox" id="estado" class="peer relative w-11 h-6 p-px bg-gray-100 border border-gray-200 text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-100 checked:border-blue-200 focus:checked:border-blue-200 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-800/30 dark:checked:border-blue-800 dark:focus:ring-offset-gray-600

                                        before:inline-block before:size-5 before:bg-white checked:before:bg-blue-600 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-500" onchange="search()" @checked($estado == 1)>
                                        <label for="estado" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Activos</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" id="asignacion" class="peer relative w-11 h-6 p-px bg-gray-100 border border-gray-200 text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-blue-600 disabled:opacity-50 disabled:pointer-events-none checked:bg-none checked:text-blue-100 checked:border-blue-200 focus:checked:border-blue-200 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-800/30 dark:checked:border-blue-800 dark:focus:ring-offset-gray-600

                                        before:inline-block before:size-5 before:bg-white checked:before:bg-blue-600 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 dark:before:bg-neutral-400 dark:checked:before:bg-blue-500" onchange="search()" @checked($asignacion == 1)>
                                        <label for="asignacion" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Con Asignacion</label>
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
                                            {{ __('Name') }}
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
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <div class="flex items-center justify-center gap-x-2">
                                            <span class="text-xs text-center font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                                {{ __('Asignaciones') }}
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                    </th>
                                </tr>
                            </thead>
                
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($fichas as $ficha)    
                                <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                        <div class="flex items-center gap-x-3">
                                            <span class="inline-flex items-center justify-center h-[2.375rem] w-[2.375rem] rounded-full bg-blue-600 dark:bg-gray-700">
                                                <span class="font-bold text-white leading-none dark:text-gray-200">{{ Str::of($ficha->NOMBRE)->charAt(0) }}</span>
                                            </span>
                                            <div class="grow">
                                                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-200">{{ $ficha->NOMBRE }}</span>
                                                <span class="block text-sm text-gray-500">{{ $ficha->PUESTO_INGRESA }}</span>
                                            </div>
                                        </div>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $ficha->ESTATUS == 'A' ? 'Activo' : 'Inactivo' }}</span>
                                        </a>
                                    </td>
                                    <td class="h-px w-px whitespace-nowrap align-center text-center">
                                        <a class="block py-2 px-6" href="#">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 flex justify-center">
                                                @if($ficha->usuarios->count() > 0)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                @endif
                                            </span>
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
                                                        @if (Auth::user()->hasPermission('edit-ficha'))
                                                        <a class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="{{ route('fichas.edit', $ficha) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil w-4">
                                                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                                                <path d="m15 5 4 4"/>
                                                            </svg>
                                                            {{ __('Edit') }}
                                                        </a>

                                                        <a onclick="obtenerDatosFicha({{$ficha->NUMERO}}, '{{ $ficha->NOMBRE }}')" class="flex items-center gap-x-3 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 cursor-pointer" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-static-backdrop-modal" data-hs-overlay="#hs-static-backdrop-modal">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                                                            {{ __('Adjuntos') }}
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
                                    <td colspan="4">
                                        <div class="max-w-sm w-full min-h-[300px] flex flex-col justify-center text-center items-center mx-auto px-6 py-4">
                                            <div class="flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-plus flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400">
                                                    <path d="M2 21a8 8 0 0 1 13.292-6"/>
                                                    <circle cx="10" cy="8" r="5"/>
                                                    <path d="M19 16v6"/>
                                                    <path d="M22 19h-6"/>
                                                </svg>
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
                            {{ $fichas->links() }}
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="hs-static-backdrop-modal" class="hs-overlay [--overlay-backdrop:static] hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-static-backdrop-modal-label" data-hs-overlay-keyboard="false">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
          <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
              <h3 id="hs-static-backdrop-modal-label" class="font-bold text-gray-800 dark:text-white">
                Adjuntos para <b id="nombre_ficha"></b>
              </h3>
              <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-static-backdrop-modal">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
            <div class="p-4 overflow-y-auto">
                <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="py-2 sm:py-2 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Nombre del archivo">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="tipo_adjunto" class="block text-sm font-medium text-gray-700">Tipo Adjunto</label>
                        <select type="text" id="tipo_adjunto" name="tipo_adjunto" class="py-2 sm:py-2 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Nombre del archivo">
                            <option value="">Seleccionar</option>
                            @foreach ($tipo_adjuntos as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2"  >
                        <label for="adjunto" class="block text-sm font-medium text-gray-700">Adjunto</label>
                        <input type="file" id="adjunto" name="adjunto" class="block w-full text-sm text-gray-500     border-gray-200
                            file:me-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-600 file:text-white
                            hover:file:bg-blue-700
                            file:disabled:opacity-50 file:disabled:pointer-events-none
                            dark:text-neutral-500
                            dark:file:bg-blue-500
                            dark:hover:file:bg-blue-400
                        ">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="chequeo" name="chequeo" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="chequeo" class="ml-2 block text-sm text-gray-900">Publico</label>
                    </div>
                </div>


                <div id="errorArchivoContainer" class="mt-4"></div>

                <div id="archivos-cargados" class="p-4 mt-4 bg-gray-100 rounded-md"></div>

                <div class="flex items-center justify-between mt-4">
                    <button id="btnAnterior" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                          </svg>
                    </button>
                    <span id="numeroPagina" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:text-white dark:focus:bg-neutral-500">1</span>
                    <button id="btnSiguiente" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                          </svg>
                    </button>
                </div>
            </div>
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
              <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-static-backdrop-modal">
                Cerrar
              </button>
              <button onclick="subirAdjunto()" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                Cargar Adjunto
              </button>
            </div>
          </div>
        </div>
    </div>

    <script>
        let input = document.getElementById('hs-leading-button-add-on-with-icon-and-button');
        const searchButton = document.getElementById('search-button');
        const clearButton = document.getElementById('clear-button');
        const estadoCheckbox = document.getElementById('estado');
        const asignacionCheckbox = document.getElementById('asignacion');
        let ficha_seleccionada = 0;
        let nombre_ficha = '';
        let paginaActual = 1;
        const elementosPorPagina = 5;

        function search() 
        {
            var url = '{{ route("fichas.index", [":estado", ":asignacion",":search"]) }}';
            url = url.replace(':search', input.value == '' ? '' : input.value);
            url = url.replace(':estado', estadoCheckbox.checked ? 1 : 0);
            url = url.replace(':asignacion', asignacionCheckbox.checked ? 1 : 0);
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

        function obtenerDatosFicha(ficha, nombre) {
            ficha_seleccionada = ficha; 
            nombre_ficha = nombre;
            document.getElementById('nombre_ficha').innerHTML = nombre;
            cargarPagina(paginaActual);
        }

        function cargarPagina(pagina) {
            var url = '{{ route("adjuntos.listado", ":ficha") }}';
            url = url.replace(':ficha', ficha_seleccionada);
            url += `?page=${pagina}&per_page=${elementosPorPagina}`;

            fetch(url)
                .then(response => response.json())
                .then(function(data) {
                    generarListadoArchivos(data.archivos);
                    actualizarBotonesPaginacion(data.pagination);
                });
        }
                
        function subirAdjunto() 
        {
            const errorContainer = document.getElementById('errorArchivoContainer');
            errorContainer.innerHTML = '';

            const nombre = document.getElementById('nombre').value;
            const adjunto = document.getElementById('adjunto').files[0];
            const chequeo = document.getElementById('chequeo').checked ? 'S' : 'N';
            const tipo = document.getElementById('tipo_adjunto').value;

            var datos = new FormData();
            datos.append('nombre', nombre);
            datos.append('chequeo', chequeo);
            datos.append("adjunto", adjunto);   
            datos.append("tipo_adjunto", tipo);  
            
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');         
            var url = '{{ route("adjuntos.store", ":ficha") }}';
            url = url.replace(':ficha', ficha_seleccionada);

            fetch(url, {
                method: "POST",
                body: datos,
                headers: {
                    "X-CSRF-TOKEN": token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json()) 
            .then(function(responseData) {
                const allErrors = Object.values(responseData.errors).flat();
                
                if (allErrors.length > 0) {
                    errorContainer.innerHTML = `
                        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            ${allErrors.map((error) => `<li>${error}</li>`).join('')}
                        </ul>
                    `;
                } else {
                    generarListadoArchivos(responseData.archivos);
                }
            });
        }

        function generarListadoArchivos(data) 
        {
            document.getElementById("nombre").value = '';
            document.getElementById("adjunto").value = '';
            document.getElementById('chequeo').checked = false;
            document.getElementById('tipo_adjunto').value = '';


            const archivosCargados = document.getElementById('archivos-cargados');
            archivosCargados.innerHTML = '';
            data.forEach(archivo => {
                const archivoContainer = document.createElement('div');
            archivoContainer.className = 'flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3';

            const p = document.createElement('p');
            p.className = 'text-gray-700';
            p.textContent = `Nombre: ${archivo.nombre} - Acceso: ${archivo.para_todos == 'N' ? 'Privado' : 'Publico'}`;

            const botonesContainer = document.createElement('div');
            botonesContainer.className = 'flex items-center space-x-3';

            const botonDescargar = document.createElement('a');
            botonDescargar.className = 'text-blue-500 hover:text-blue-700';
            botonDescargar.href = archivo.url_descarga;
            botonDescargar.download = archivo.nombre;
            botonDescargar.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" x2="12" y1="15" y2="3"/>
                </svg>
            `;

            const botonEliminar = document.createElement('button');
            botonEliminar.className = 'text-red-500 hover:text-red-700';
            botonEliminar.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    <line x1="10" x2="10" y1="11" y2="17"/>
                    <line x1="14" x2="14" y1="11" y2="17"/>
                </svg>
            `;

            botonEliminar.addEventListener('click', () => {
                eliminarArchivo(archivo.id);
            });



            botonesContainer.appendChild(botonEliminar);

            botonesContainer.appendChild(botonDescargar);

            archivoContainer.appendChild(p);
            archivoContainer.appendChild(botonesContainer);
            archivosCargados.appendChild(archivoContainer);
            });
        }

        function eliminarArchivo($file_id)
        {
            fetch("{{ route('adjuntos.delete', ':file') }}".replace(':file', $file_id))
            .then(response => response.json()) 
            .then(function(responseData) {
                obtenerDatosFicha(ficha_seleccionada, nombre_ficha);
            });
        }

        function actualizarBotonesPaginacion(pagination) 
        {
            const btnAnterior = document.getElementById('btnAnterior');
            const btnSiguiente = document.getElementById('btnSiguiente');
            const numeroPagina = document.getElementById('numeroPagina'); // Elemento para mostrar el número de página

            // Ocultar o mostrar los botones según el total de registros
            if (pagination.total <= 5) {
                btnAnterior.style.display = 'none';
                btnSiguiente.style.display = 'none';
                numeroPagina.style.display = 'none'; // También ocultar el número de página
            } else {
                btnAnterior.style.display = 'inline-block'; // o 'block', dependiendo de tu diseño
                btnSiguiente.style.display = 'inline-block'; // o 'block', dependiendo de tu diseño
                numeroPagina.style.display = 'inline-block'; // Mostrar el número de página

                // Actualizar el número de página
                numeroPagina.textContent = pagination.current_page;

                // Habilitar o deshabilitar los botones
                btnAnterior.disabled = pagination.current_page <= 1;
                btnSiguiente.disabled = pagination.current_page >= pagination.last_page;
            }
        }

        document.getElementById('btnAnterior').addEventListener('click', function() {
            if (paginaActual > 1) {
                paginaActual--;
                cargarPagina(paginaActual);
            }
        });

        document.getElementById('btnSiguiente').addEventListener('click', function() {
            paginaActual++;
            cargarPagina(paginaActual);
        });
    </script>
</x-app-layout>
