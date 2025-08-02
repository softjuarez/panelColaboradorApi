<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-gray-500" href="{{ route('solicitud_vacaciones.index') }}">
            <svg class="flex-shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-600" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            {{ __('Solicitud de vacaciones') }}
        </a>
    </li>
    <li class="text-sm">
        <a class="flex items-center text-gray-500" href="#">
            <svg class="flex-shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-600" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            {{ __('Editar') }}
        </a>
    </li>
    @endsection

    <div class="max-w-[100rem] flex items-start px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="w-full mx-2 bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        {{ __('Ver solicitud') }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Ver informacion de la solicitud') }}.
                        </p>
                    </div>

                    @if (!empty($solicitud->razon_rechazo))
                    <button type="button" class="m-1 ms-0 py-2 px-3 relative inline-flex justify-center items-center text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-razon-rechazo" data-hs-overlay="#hs-razon-rechazo">
                        Razon de Rechazo
                        <span class="flex absolute top-0 end-0 size-3 -mt-1.5 -me-1.5">
                        <span class="animate-ping absolute inline-flex size-full rounded-full bg-red-400 opacity-75 dark:bg-red-600"></span>
                        <span class="relative inline-flex rounded-full size-3 bg-red-500"></span>
                        </span>
                    </button>
                    @endif

                    @if (!empty($solicitud->razon_autoriza))
                    <button type="button" class="m-1 ms-0 py-2 px-3 relative inline-flex justify-center items-center text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-razon-autoriza" data-hs-overlay="#hs-razon-autoriza">
                        Razon de Autorizacion
                        <span class="flex absolute top-0 end-0 size-3 -mt-1.5 -me-1.5">
                        <span class="animate-ping absolute inline-flex size-full rounded-full bg-teal-400 opacity-75 dark:bg-teal-600"></span>
                        <span class="relative inline-flex rounded-full size-3 bg-teal-500"></span>
                        </span>
                    </button>
                    @endif

                    @if (!@empty($solicitud->url))
                    <a href="{{ route('download.file', ['directorio' => base64_encode($solicitud->url)]) }}" class="py-2 px-3 gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-600 text-white hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Formato de Solicitud') }}
                    </a>
                    @endif
                </div>

                <div class="mt-2">
                <table class="dark:text-gray-200 text-sm">
                    <tr>
                        <td><b>Fecha Inicio:</b></td>
                        <td class="px-6">{{ date('d/m/Y', strtotime($solicitud->fecha_inicio)) }}</td>
                        <td><b>Fecha Fin:</b></td>
                        <td class="px-6">{{ date('d/m/Y', strtotime($solicitud->fecha_fin)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Dias Otorgados:</b></td>
                        <td class="px-6">{{ number_format($solicitud->dias_otorgados, 2, '.', ',') }}</td>
                        <td><b>Fecha Retorno:</b></td>
                        <td class="px-6">{{ date('d/m/Y', strtotime('+1 day'. $solicitud->fecha_fin)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Autorizado:</b></td>
                        <td class="px-6">{{ Str::title($solicitud->autoriza->name ?? 'Sin autorizar') }}</td>
                        <td><b>Fecha Autorizado:</b></td>
                        <td class="px-6">{{ $solicitud->fecha_autoriza ? date('d/m/Y H:i', strtotime($solicitud->fecha_autoriza)) : 'Sin Autorizar' }}</td>
                    </tr>
                    <tr>
                        <td><b>Verificado:</b></td>
                        <td class="px-6">{{ Str::title($solicitud->verifica->name ?? 'Sin verificar') }}</td>
                        <td><b>Fecha Verificado:</b></td>
                        <td class="px-6">{{ $solicitud->fecha_verifica ? date('d/m/Y H:i', strtotime($solicitud->fecha_verifica)) : 'Sin Verificar' }}</td>
                    </tr>
                    <tr>
                        <td><b>Estado:</b></td>
                        <td class="px-6">{{ $solicitud->obtenerEstado() }}</td>
                        <td></td>
                        <td class="px-6"></td>
                    </tr>
                </table>
                </div>
            </div>
        </div>

        <div class="w-full mx-2 bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-2">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Listado de dias a solicitar</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="tabla" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-body" class="bg-white divide-y divide-gray-200">
                        @foreach ($solicitud->detalles as $detalle)
                        <tr>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">{{ date('d/m/Y', strtotime($detalle->fecha)) }}</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">{{ $detalle->obtenerEstado()   }}</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">{{ number_format($detalle->valor, 2, '.', ',') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @if (!empty($solicitud->razon_rechazo))
    <div id="hs-razon-rechazo" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-razon-rechazo-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-razon-rechazo">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            </div>

            <div class="p-4 sm:p-10 overflow-y-auto">
            <div class="flex gap-x-4 md:gap-x-7">
                <!-- Icon -->
                <span class="shrink-0 inline-flex justify-center items-center size-[46px] sm:w-[62px] sm:h-[62px] rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                </span>
                <!-- End Icon -->

                <div class="grow">
                <h3 id="hs-razon-rechazo-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Razon de Rechazo
                </h3>
                <p class="text-gray-500 dark:text-neutral-500">
                    {{ $solicitud->razon_rechazo }}
                </p>
                </div>
            </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-razon-rechazo">
                Cancelar
            </button>
            </div>
        </div>
        </div>
    </div>
    @endif

    @if (!empty($solicitud->razon_autoriza))
    <div id="hs-razon-autoriza" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-razon-autoriza-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-razon-autoriza">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            </div>

            <div class="p-4 sm:p-10 overflow-y-auto">
            <div class="flex gap-x-4 md:gap-x-7">
                <!-- Icon -->
                <span class="shrink-0 inline-flex justify-center items-center size-[46px] sm:w-[62px] sm:h-[62px] rounded-full border-4 border-teal-50 bg-teal-100 text-teal-500 dark:bg-teal-700 dark:border-teal-600 dark:text-teal-100">
                <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                </span>
                <!-- End Icon -->

                <div class="grow">
                <h3 id="hs-razon-autoriza-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Razon de autorizacion
                </h3>
                <p class="text-gray-500 dark:text-neutral-500">
                    {{ $solicitud->razon_autoriza }}
                </p>
                </div>
            </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-razon-autoriza">
                Cancelar
            </button>
            </div>
        </div>
        </div>
    </div>
    @endif
</x-app-layout>
