<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Consulta Requisiciones') }}
        </a>
    </li>
    @endsection

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('Reporte requisiciones') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Puedes generar reporte de requisiciones.') }}
                </p>
            </div>


            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <label for="fecha_inicio" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Rango de Fechas*') }}
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <input name="fecha_inicio" id="fecha_inicio" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Correlativo Inicio" value="{{ date('Y-m-d') }}">
                        <input name="fecha_final" id="fecha_final" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Correlativo Final" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div id="ficha-container" class="sm:col-span-3">
                    <label for="ficha" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Ficha') }}
                    </label>
                </div>

                <div id="ficha-select-container" class="sm:col-span-9">
                    <div class="relative">
                        <select id='ficha' data-hs-select='{
                            "hasSearch": true,
                            "placeholder": "{{ __('Select multiple options...') }}",
                            "toggleTag": "<button type=\"button\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                            }' class="hidden">
                            <option value="0" selected>{{ __('Todos') }}</option>
                            @foreach ($fichas as $item)
                            <option value="{{ $item->NUMERO }}" >{{ $item->NOMBRE }}</option>
                            @endforeach
                        </select>

                        <div class="absolute top-1/2 end-3 -translate-y-1/2">
                            <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Centro de Costo*') }}
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <div class="relative">
                        <select id="centro_costo" data-hs-select='{
                            "hasSearch": true,
                            "placeholder": "{{ __('Select multiple options...') }}",
                            "toggleTag": "<button type=\"button\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                            }' class="hidden">
                            <option value="0" selected>{{ __('Todos') }}</option>
                            @foreach ($centros_costo as $item)
                            <option value="{{ $item->NUMERO }}">{{ rtrim($item->CLAVE) }} - {{ rtrim($item->DESCRIPCION) }}</option>
                            @endforeach
                        </select>

                        <div class="absolute top-1/2 end-3 -translate-y-1/2">
                            <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </div>
                    </div>
                </div>

                <div id="estado-container" class="sm:col-span-3">
                    <label for="estado" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Estado') }}
                    </label>
                </div>

                <div id="estado-select-container" class="sm:col-span-9">
                    <div class="relative">
                        <select id='estado' data-hs-select='{
                            "hasSearch": true,
                            "placeholder": "{{ __('Select multiple options...') }}",
                            "toggleTag": "<button type=\"button\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                            }' class="hidden">
                            <option value="0" selected>{{ __('Todos') }}</option>
                            <option value="b">Autorizacion Jefe</option>
                            <option value="c">Validacion Presupuesto</option>
                            <option value="d">Autorizacion Tesoreria</option>
                            <option value="e">Asignacion de Gestor</option>
                            <option value="f">Gestion Cotizacion</option>
                            <option value="g">Validacion Compras</option>
                            <option value="h">Autorizacion Comite</option>
                        </select>

                        <div class="absolute top-1/2 end-3 -translate-y-1/2">
                            <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('# Requisicion') }}
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <input type="number" id="requisicion" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Lugar de entrega de la requisicion." value="0"/>
                    </div>

                    <x-input-error class="mt-2" :messages="$errors->get('lugar_entrega')" />
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-x-2">
                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Generar Reporte') }}
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let generarReporteBtn = document.querySelector('button[type="submit"]');

            generarReporteBtn.addEventListener('click', function(event) {
                let fechaInicio = document.getElementById('fecha_inicio').value;
                let fechaFin = document.getElementById('fecha_final').value;
                let ficha = document.getElementById('ficha').value;
                let centro_costo = document.getElementById('centro_costo').value;
                let requisicion = document.getElementById('requisicion').value;
                let estado = document.getElementById('estado').value;


                if (!fechaInicio || !fechaFin) {
                    event.preventDefault();
                    alert('Por favor, completa todos los campos obligatorios.');
                    exit;
                }

                if (new Date(fechaInicio) > new Date(fechaFin)) {
                    event.preventDefault();
                    alert('La fecha de inicio no puede ser mayor que la fecha de fin.');
                    exit;
                }

                let url = "{{ route('consulta_requisiciones.index', [':fechaI', ':fechaF', ':ficha', ':centro_costo', ':requisicion', ':estado']) }}";
                url = url.replace(':fechaI', fechaInicio);
                url = url.replace(':fechaF', fechaFin);
                url = url.replace(':ficha', ficha);
                url = url.replace(':centro_costo', centro_costo);
                url = url.replace(':requisicion', requisicion);
                url = url.replace(':estado', estado);

                window.open(url, '_self');
            });
        });
    </script>



</x-app-layout>
