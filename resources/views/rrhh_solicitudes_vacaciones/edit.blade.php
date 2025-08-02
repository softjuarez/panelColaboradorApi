<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-gray-500" href="{{ route('rrhh_solicitud_vacaciones.index') }}">
            <svg class="flex-shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-600" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            {{ __('Autoriza solicitud de vacaciones') }}
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

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>


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

                    @if (!@empty($solicitud_web->url))
                    <a href="{{ route('download.file', ['directorio' => base64_encode($solicitud_web->url)]) }}" class="py-2 px-3 gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-600 text-white hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Formato de Solicitud') }}
                    </a>
                   @endif

                    <a href="{{ route('rrhh_solicitud_vacaciones.verificar', $solicitud) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-purple-600 text-white hover:bg-purple-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Verificar</a>
                </div>

                <div class="mt-2">
                    <table class="dark:text-gray-200 text-sm">
                        <tr>
                            <td><b>Fecha Inicio:</b></td>
                            <td class="px-6">{{ date('d/m/Y', strtotime($solicitud->FECHA_INICIO)) }}</td>
                            <td><b>Fecha Fin:</b></td>
                            <td class="px-6">{{ date('d/m/Y', strtotime($solicitud->FECHA_FIN)) }}</td>
                        </tr>
                        <tr>
                            <td><b>Dias Otorgados:</b></td>
                            <td class="px-6">{{ number_format($solicitud->DIAS_OTORGADOS, 2, '.', ',') }}</td>
                            <td><b>Fecha Retorno:</b></td>
                            <td class="px-6">{{ date('d/m/Y', strtotime($solicitud->FECHA_RETORNO)) }}</td>
                        </tr>
                        <tr>
                            <td><b>Estado:</b></td>
                            <td class="px-6">{{ $solicitud->obtenerEstado() }}</td>
                            <td><b>Solicitante:</b></td>
                            <td class="px-6">{{ Str::title($solicitud->ficha->NOMBRE) }}</td>
                        </tr>
                        <tr>
                            <td><b>Autorizado:</b></td>
                            <td class="px-6">{{ Str::title($solicitud_web->autoriza->name ?? 'Sin autorizar') }}</td>
                            <td><b>Fecha:</b></td>
                            <td class="px-6">{{ date('d/m/Y H:i', strtotime($solicitud_web->fecha_autoriza)) }}</td>
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
                            <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-body" class="bg-white divide-y divide-gray-200">
                        @foreach ($detalles as $detalle)
                        <tr>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">{{ date('d/m/Y', strtotime($detalle->FECHA_INICIO)) }}</td>
                            <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">{{ number_format($detalle->TOTAL, 2, '.', ',') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
