
<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-gray-500" href="{{ route('ordenes_proveedor.index') }}">
            <svg class="flex-shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-600" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            {{ __('Ordenes de Compra') }}
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

    <div class="max-w-[100rem] grid grid-cols-1 md:grid-cols-2 gap-4 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    {{ __('Datos de los Documentos') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Datos generales de los documentos aplicados.') }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    @if ($orden->saldo() > 0)
                    <a href="{{ route('documentos_proveedor.new', $orden) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Asignar Documento</a>
                    @endif
                </div>
            </div>

            <div class="mt-2">
                @if($orden->documentos->isNotEmpty())
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('# Doc.') }}</th>
                            <th class="w-1/2 px-4 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('Serie') }}</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">{{ __('Total') }}</th>
                            <th class="px-4 py-2 text-right"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->documentos as $documento)
                        <tr @class([
                                'line-through' => $documento->estatus == 4
                            ])>
                            <td class="px-4  text-sm text-center text-gray-600">{{ $documento->id }}</td>
                            <td class="px-4  text-sm text-gray-600">{{ $documento->serie }}</td>
                            <td class="px-4  text-sm text-right text-gray-600">{{ number_format($documento->valor_gran_total, 2, '.', ',') }}</td>
                            <td class="px-4  text-center items-center flex justify-end">
                                <a href="{{ route('documentos_proveedor.edit', $documento) }}" class="flex items-end justify-center px-2 rounded hover:bg-gray-100 dark:hover:bg-gray-800" title="{{ __('Ver documento') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="lucide lucide-eye text-blue-600">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    <div class="mt-4 text-sm text-gray-600">{{ __('No hay documentos asignados.') }}</div>
                @endif
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    {{ __('Datos de la Orden') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Datos generales de la orden de compra.') }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('ordenes_proveedor.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Cancel') }}
                    </a>
                </div>
            </div>

            <div class="mt-2">
                <table class="dark:text-gray-200 text-sm">
                    <tr>
                        <td><b>Numero:</b></td>
                        <td class="px-6">{{ rtrim($orden->NUMERO) }}</td>
                        <td><b>Fecha:</b></td>
                        <td class="px-6">{{ date('d/m/Y', strtotime($orden->FECHA)) }}</td>
                    </tr>
                    <tr>
                        <td><b>Proveedor:</b></td>
                        <td colspan="3" class="px-6">{{ Str::of($orden->proveedor())->title() }}</td>
                    </tr>
                    <tr>
                        <td><b>Moneda:</b></td>
                        <td colspan="3" class="px-6">{{ Str::of($orden->nombreMoneda())->title() }}</td>
                    </tr>
                    <tr>
                        <td><b>Total:</b></td>
                        <td colspan="3" class="px-6">{{ $orden->VLR_FOB }}</td>
                    </tr>
                    <tr>
                        <td><b>Comentarios:</b></td>
                        <td colspan="3" class="px-6">{{ Str::of($orden->COMENTARIOS)->title() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="p-4 sm:py-8 sm:px-8 bg-white shadow sm:rounded-lg dark:bg-slate-900">
            <div class="-m-1.5 overflow-x-auto px-6 md:px-0">
                <div class="md:flex md:justify-between md:items-center md:border-b border-gray-200 dark:border-gray-700 pb-2">
                    <div>

                    </div>

                    <div>
                        <div class="inline-flex gap-x-2">

                        </div>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="w-full px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Descripcion") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Cantidad") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Precio") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Total") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-right"></th>
                        </tr>
                    </thead>

                    <tbody id="tabla-detalles" class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($orden->detalles as $detalle)
                    <tr>
                        <td class="h-px w-px">
                            <div class="px-6 py-1">
                                <span class="text-sm text-gray-600">{{ $detalle->DESCRIPCION }}</span>
                            </div>
                        </td>

                        <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1 text-right">
                                <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_OC, 2, '.', ',') }}</span>
                            </div>
                        </td>

                        <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1 text-right">
                                <span class="text-sm text-gray-600">{{ number_format($detalle->PRECIO_UNITARIO, 2, '.', ',') }}</span>
                            </div>
                        </td>

                        <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1 text-right">
                                <span class="text-sm text-gray-600">{{ number_format($detalle->VLR_FOB, 2, '.', ',') }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                        <td colspan="6" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
