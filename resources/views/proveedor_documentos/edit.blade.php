<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('documentos_proveedor.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Documentos') }}
          </a>
      </li>
      <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Edit') }}
        </a>
      </li>
    @endsection

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            {{ __('Asignar Documento') }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Formulario para asignar documento a una orden de compra.') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($documento->estatus == 1)
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-pdf">Subir Documento</button>

                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-solicitar-revision">Solicitar Revision</button>
                        @endif
                    </div>
                </div>
            </div>


            <form method="post" action="{{ route('documentos_proveedor.update', $documento) }}">
                @csrf
                <div class="py-3 flex items-center text-sm font-bold text-gray-700 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">Datos Generales</div>

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Serie* / # Documento*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input name="serie" id="serie" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Serie" value="{{ @old('serie', $documento->serie) }}">
                            <input name="numero_docto" id="numero_docto" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Numero de Documento" value="{{ @old('numero_docto', $documento->numero_docto) }}">

                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('serie')" />
                        <x-input-error class="mt-2" :messages="$errors->get('numero_docto')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('UUID* / Fecha Documento*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                             <input name="uuid" id="uuid" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Uuid del documento." value="{{ @old('uuid', $documento->uuid) }}"/>
                             <input name="fecha_docto" id="fecha_docto" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Fecha Documento" value="{{ @old('fecha_docto', $documento->fecha_docto) }}">
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('uuid')" />
                        <x-input-error class="mt-2" :messages="$errors->get('fecha_docto')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Vencimiento* / Pago*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                             <input name="fecha_vence" id="fecha_vence" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Fecha Documento" value="{{ @old('fecha_vence', $documento->fecha_vence) }}" disabled>
                             <input name="fecha_pago" id="fecha_pago" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Fecha Documento" value="{{ @old('fecha_pago', $documento->fecha_pago) }}" disabled>
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('fecha_vence')" />
                        <x-input-error class="mt-2" :messages="$errors->get('fecha_pago')" />
                    </div>
                </div>

                <div class="mt-5 flex justify-between">
                    <a href="{{ route('ordenes_proveedor.edit', $documento->orden) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        {{ __('Ir a la Orden') }}
                    </a>

                    <div class="flex items-center gap-x-2">
                        <a href="{{ route('documentos_proveedor.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        {{ __('Regresar') }}
                        </a>
                        @if ($documento->estatus == 1 && empty($documento->xml))
                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('Save') }}
                        </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="p-4 sm:py-8 sm:px-8 bg-white shadow sm:rounded-lg dark:bg-slate-900">
            <div class="block border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-2" aria-label="Tabs" role="tablist" hs-data-tab-select="#tab-select">
                    <button type="button" class="hs-tab-active:bg-white hs-tab-active:dark:bg-slate-900 hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 -mb-px py-3 px-4 inline-flex items-center gap-2 bg-gray-50 dark:bg-slate-900 text-sm font-medium text-center border text-gray-500 rounded-t-lg hover:text-gray-700 active" id="hs-tab-to-select-item-1" data-hs-tab="#hs-tab-to-select-1" aria-controls="hs-tab-to-select-1" role="tab">
                        Detalle
                    </button>

                    <button type="button" class="hs-tab-active:bg-white hs-tab-active:dark:bg-slate-900 hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 -mb-px py-3 px-4 inline-flex items-center gap-2 bg-gray-50 dark:bg-slate-900 text-sm font-medium text-center border text-gray-500 rounded-t-lg hover:text-gray-700" id="hs-tab-to-select-item-2" data-hs-tab="#hs-tab-to-select-2" aria-controls="hs-tab-to-select-2" role="tab">
                        Ret o Ext
                    </button>
                </nav>
            </div>

            <div class="mt-3">
                <div id="hs-tab-to-select-1" role="tabpanel" aria-labelledby="hs-tab-to-select-item-1">
                    <div class="-m-1.5 overflow-x-auto px-6 md:px-0">
                        <div class="md:flex md:justify-between md:items-center md:border-b border-gray-200 dark:border-gray-700 pb-2">
                            <div>
                            </div>

                            <div>
                                @if ($documento->estatus == 1 && empty($documento->xml))
                                <div class="inline-flex gap-x-2">
                                    <a onclick="obtenerDetalle(1)" class="py-3 px-4 flex justify-center items-center h-[2.875rem] w-[2.875rem] text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-circle flex-shrink-0 w-5 h-5"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
                                    </a>
                                </div>
                                @endif
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
                                <div class="flex items-center gap-x-2 justify-end">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Cantidad") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2 justify-end">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Precio") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2 justify-end">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Sub To.") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2 justify-end">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Descuento") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2 justify-end">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Total") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-right"></th>
                            </tr>
                        </thead>

                        <tbody id="tabla-detalles" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($documento->detalles as $detalle)
                            <tr>
                                <td class="h-px w-px">
                                    <div class="px-6 py-1">
                                        <span class="text-sm text-gray-600">{{ substr($detalle->descripcion, 0, 60) }}</span>
                                    </div>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-1 text-right">
                                        <span class="text-sm text-gray-600">{{ number_format($detalle->cantidad, 2, '.', ',') }}</span>
                                    </div>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-1 text-right">
                                        <span class="text-sm text-gray-600">{{ number_format($detalle->precio_uni, 2, '.', ',') }}</span>
                                    </div>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-1 text-right">
                                        <span class="text-sm text-gray-600">{{ number_format(round($detalle->precio_uni * $detalle->cantidad, 2), 2, '.', ',') }}</span>
                                    </div>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-1 text-right">
                                        <span class="text-sm text-gray-600">{{ number_format($detalle->valor_descuento, 2, '.', ',') }}</span>
                                    </div>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-1 text-right">
                                        <span class="text-sm text-gray-600">{{ number_format($detalle->valor_total, 2, '.', ',') }}</span>
                                    </div>
                                </td>

                                <td class="h-px w-px whitespace-nowrap">
                                    <div class="px-6 py-1">
                                        <button onclick="obtenerDetalle(2, {{ $detalle->id }})" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>

                                        @if ($documento->estatus == 1 && empty($documento->xml))
                                        <button onclick="alertDetalle({{ $detalle->id }})" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-red-500 hs-dark-mode-active:hover:text-red-400">Eliminar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                                <td colspan="7" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
                <div id="hs-tab-to-select-2" class="hidden" role="tabpanel" aria-labelledby="hs-tab-to-select-item-2">
                    <div class="-m-1.5 overflow-x-auto px-6 md:px-0">
                        <div class="md:flex md:justify-between md:items-center md:border-b border-gray-200 dark:border-gray-700 pb-2">
                            <div>
                            </div>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="w-full px-6 py-2 text-left">
                                        <div class="flex items-center gap-x-2">
                                            <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                                {{ __("Tipo de adjunto") }}
                                            </span>
                                        </div>
                                    </th>


                                    <th scope="col" class="px-6 py-2 text-right"></th>
                                </tr>
                            </thead>

                            <tbody id="tabla-detalles" class="divide-y divide-gray-200 dark:divide-gray-700">
                                @if (!empty($documento->path_retencion) || !empty($documento->path_exento))

                                    @if (!empty($documento->path_retencion))
                                    <tr>
                                        <td class="h-px w-px">
                                            <div class="px-6 py-1">
                                                <span class="text-sm text-gray-600">Documento de Retencion</span>
                                            </div>
                                        </td>

                                        <td class="h-px w-px whitespace-nowrap">
                                            <div class="px-6 py-1">
                                                <a href="{{ route('download.file', ['directorio' => base64_encode($documento->path_retencion)]) }}" class="text-blue-500 hover:text-blue-700" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                        <polyline points="7 10 12 15 17 10"/>
                                                        <line x1="12" x2="12" y1="15" y2="3"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif

                                    @if (!empty($documento->path_exento))
                                    <tr>
                                        <td class="h-px w-px">
                                            <div class="px-6 py-1">
                                                <span class="text-sm text-gray-600">Documento Exento</span>
                                            </div>
                                        </td>

                                        <td class="h-px w-px whitespace-nowrap">
                                            <div class="px-6 py-1">
                                                <a href="{{ route('download.file', ['directorio' => base64_encode($documento->path_exento)]) }}" class="text-blue-500 hover:text-blue-700" target="_blank">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                                        <polyline points="7 10 12 15 17 10"/>
                                                        <line x1="12" x2="12" y1="15" y2="3"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @else
                                <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                                    <td colspan="2" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_documento_detalle" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-6xl sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)] min-h-[calc(100%-3.5rem)] sm:flex items-center">
          <div class="w-full max-h-full flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="flex justify-between items-center py-3 px-4 border-b ">
              <h3 class="font-bold text-gray-800 ">
                Detalle de requisicion
              </h3>
              <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm " data-hs-overlay="#modal_documento_detalle">
                <span class="sr-only">Close</span>
                <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                </svg>
              </button>
            </div>

            <div class="p-4">
                <div class="flex items-center justify-end gap-x-3 mb-4">
                    <label for="exento" class="relative inline-block w-9 h-5 cursor-pointer">
                        <input type="checkbox" id="exento" class="peer sr-only">
                        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                    </label>
                    <label for="exento" class="text-sm text-gray-500 dark:text-neutral-400">Exento?</label>
                </div>

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('B o S / U. Medida / Cantidad*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <select name="bos" id="bos" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                <option disabled>Seleccionar</option>
                                <option value="B">Bien</option>
                                <option value="S">Servicio</option>
                            </select>
                            <input name="unidad_medida" id="unidad_medida" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Unidad de Medida" onfocus="this.select()">
                            <input name="cantidad" id="cantidad" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Cantidad" value="1" onfocus="this.select()">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('P. Unitario / Impuestos / Descuento') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input name="precio_unitario" id="precio_unitario" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Precio Unitario" value="0" onfocus="this.select()">
                            <input name="impuestos" id="impuestos" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Impuestos" value="0" onfocus="this.select()">
                            <input name="descuento" id="descuento" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Descuentos" value="0" onfocus="this.select()">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Descripcion*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <textarea name="descripcion" id="descripcion" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Descripcion del detalle." onfocus="this.select()"></textarea>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Iva / Total') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input name="valor_iva" id="valor_iva" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="0" disabled>
                            <input name="total" id="total" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="0" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div id="errorContainer" class="px-4 pb-2"></div>

            <div class="flex justify-between items-center gap-x-2 py-3 px-4 border-t">
              <div>
                <svg id="spin-detalle" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat animate-spin w-6 h-6 hidden" viewBox="0 0 16 16">
                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                </svg>
              </div>

              <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#modal_documento_detalle">
                  Cerrar
                </button>
                @if ($documento->estatus == 1 && empty($documento->xml))
                <button id="save-cotizacion" type="button" onclick="generarDetalle()" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  Guardar
                </button>
                @endif
              </div>
            </div>
          </div>
        </div>
    </div>

    @if ($documento->estatus == 1)
    <div id="hs-danger-alert" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-danger-alert-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-danger-alert">
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
                <h3 id="hs-danger-alert-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Eliminar Detalle
                </h3>
                <p class="text-gray-500 dark:text-neutral-500">
                    Elimine permanentemente el detalle. Esta acción no es reversible, por lo que debe proceder con precaución.
                </p>
                </div>
            </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-danger-alert">
                Cancelar
            </button>
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-500 text-white hover:bg-red-600 disabled:opacity-50 disabled:pointer-events-none" onclick="deleteDetalle()">
                Eliminar
            </button>
            </div>
        </div>
        </div>
    </div>

    <div id="hs-solicitar-revision" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-solicitar-revision-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
                <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-solicitar-revision">
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
                    <h3 id="hs-danger-alert-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                        Solicitar Revision
                    </h3>
                    <p class="text-gray-500 dark:text-neutral-500">
                        Solicitar revision del documento. Esta acción no es reversible, por lo que debe proceder con precaución.
                    </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-solicitar-revision">
                    Cancelar
                </button>
                <a href="{{ route('documentos_proveedor.review', $documento) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
                    Solicitar Revision
                </a>
            </div>
        </div>
        </div>
    </div>
    @endif

    <div id="hs-pdf" class="hs-overlay [--overlay-backdrop:static] hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-xml-label" data-hs-overlay-keyboard="false">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
          <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
              <h3 id="hs-xml-label" class="font-bold text-gray-800 dark:text-white">
                Cargar Documento PDF
              </h3>
              <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-pdf">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
            <div class="p-4 overflow-y-auto">
                <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2"  >
                        <input type="file" id="adjunto" name="adjunto" class="block w-full text-sm text-gray-500 border-gray-200
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
                </div>

                <div id="errorArchivoContainer" class="mt-4"></div>

                <div id="archivos-cargados" class="p-4 mt-4 bg-gray-100 rounded-md">
                    @if (empty($documento->pdf))
                        <p class="text-gray-500 dark:text-neutral-400">No se ha cargado ningún archivo.</p>
                    @else
                        <div class="flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3">
                            <p class="text-gray-700">Documento PDF</p>
                            <div class="flex items-center space-x-3">
                                @if ($documento->estatus == 1)
                                <button class="text-red-500 hover:text-red-700" onclick="eliminarArchivo({{ $documento->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" x2="10" y1="11" y2="17"/>
                                        <line x1="14" x2="14" y1="11" y2="17"/>
                                    </svg>
                                </button>
                                @endif

                                <a href="{{ route('download.file', ['directorio' => base64_encode($documento->pdf)]) }}" class="text-blue-500 hover:text-blue-700" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" x2="12" y1="15" y2="3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
            <div class="flex justify-between items-center gap-x-2 py-3 px-4 border-t">
                <div>
                    <svg id="spin2-detalle" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat animate-spin w-6 h-6 hidden" viewBox="0 0 16 16">
                        <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                        <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                    </svg>
                </div>

                <div class="flex items-center justify-end gap-x-2">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-pdf">
                        Cerrar
                    </button>
                    @if ($documento->estatus == 1)
                    <button id="cargar_adjunto" onclick="subirAdjunto()" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Cargar Adjunto
                    </button>
                    @endif
                </div>
            </div>
          </div>
        </div>
    </div>


    <script>
        let detalleSelected = 0;
        let crearOEditar = 0;
        let clickEnabled = true;

        function obtenerDetalle(crearOEditarDetalle, detalleId = 0)
        {
            crearOEditar = crearOEditarDetalle;
            detalleSelected = detalleId;

            const errorContainer = document.getElementById('errorContainer');
            errorContainer.innerHTML = '';

            if (crearOEditarDetalle == 1) {
                document.getElementById('exento').checked = false;
                document.getElementById('bos').value = 'B';
                document.getElementById('unidad_medida').value = '';
                document.getElementById('cantidad').value = '1';
                document.getElementById('descripcion').value = '';
                document.getElementById('precio_unitario').value = '0';
                document.getElementById('impuestos').value = '0';
                document.getElementById('descuento').value = '0';

                calcularTotal();
            } else {
                fetch("{{ route('documentos_proveedor_detalle.edit', ':detalle') }}".replace(':detalle', detalleId))
                    .then(response => response.json())
                    .then(function(data) {
                        document.getElementById('exento').checked = data.detalle.exento_sn == 'S' ? true : false;
                        document.getElementById('bos').value = data.detalle.bien_servicio;
                        document.getElementById('unidad_medida').value = data.detalle.um;
                        document.getElementById('cantidad').value = data.detalle.cantidad;
                        document.getElementById('descripcion').value = data.detalle.descripcion;
                        document.getElementById('precio_unitario').value = data.detalle.precio_uni;
                        document.getElementById('impuestos').value = parseFloat(data.detalle.valor_impuestos).toFixed(2);
                        document.getElementById('descuento').value = parseFloat(data.detalle.valor_descuento).toFixed(2);
                        calcularTotal();
                });
            }

            HSOverlay.open(document.getElementById('modal_documento_detalle'))
        }

        function generarDetalle()
        {
            if (clickEnabled) {
              clickEnabled = false;
              document.getElementById('spin-detalle').classList.remove('hidden');

              const errorContainer = document.getElementById('errorContainer');
              errorContainer.innerHTML = '';

              const datos = JSON.stringify({
                exento: document.getElementById('exento').checked == true ? 'S' : 'N',
                bien_servicio: document.getElementById('bos').value,
                unidad_medida: document.getElementById('unidad_medida').value,
                cantidad: document.getElementById('cantidad').value,
                descripcion: document.getElementById('descripcion').value,
                precio_unitario: document.getElementById('precio_unitario').value,
                valor_impuestos: document.getElementById('impuestos').value,
                descuento: document.getElementById('descuento').value,
              });

              let url = "";
              if (crearOEditar == 1){
                  url = "{{ route('documentos_proveedor_detalle.store', $documento) }}";
              } else {
                  url = "{{ route('documentos_proveedor_detalle.update', ':detalle') }}";
                  url = url.replace(':detalle', detalleSelected);
              }

              let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

              fetch(url, {
                  method: "POST",
                  body: datos,
                  headers: {
                      "X-CSRF-TOKEN": token,
                      "Accept": "application/json",
                      "Content-Type": "application/json"
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
                    this.generarTablaDeDetalles(responseData.detalles);
                    HSOverlay.close(document.getElementById('modal_documento_detalle'))
                  }

                  document.getElementById('spin-detalle').classList.add('hidden');
                  clickEnabled = true;
              });
            }
        }

        function generarTablaDeDetalles(data)
        {
            document.getElementById("tabla-detalles").innerHTML = '';

            if (data.length > 0) {
                for(var i = 0; i <= data.length -1 ; i++) {
                    document.getElementById("tabla-detalles").insertAdjacentHTML("beforeend", `
                        <tr>
                            <td class="h-px w-px">
                                <div class="px-6 py-1">
                                    <span class="text-sm text-gray-600">${ (data[i].descripcion).slice(0, 4) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">${ parseFloat(data[i].cantidad).toFixed(2) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">${ parseFloat(data[i].precio_uni).toFixed(2) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">${ parseFloat(data[i].precio_uni * data[i].cantidad).toFixed(2) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">${ parseFloat(data[i].valor_descuento).toFixed(2) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">${ parseFloat(data[i].valor_total).toFixed(2) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1">
                                <button onclick="obtenerDetalle(2, ${ data[i].id })" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>
                                <button onclick="alertDetalle(${ data[i].id })" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-red-600 hover:text-red-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-red-500 hs-dark-mode-active:hover:text-red-400">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    `);
                }
            } else {
                document.getElementById("tabla-detalles").insertAdjacentHTML("beforeend", `
                    <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                        <td colspan="7" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                    </tr>
                `);
            }
        }

        function alertDetalle(detalleId)
        {
            detalleSelected = detalleId;
            HSOverlay.open('#hs-danger-alert');
        }

        function deleteDetalle()
        {
            let url = "{{ route('documentos_proveedor_detalle.delete', ':detalle') }}";
            url = url.replace(':detalle', detalleSelected);
            fetch(url)
            .then(response => response.json())
            .then(data => {
                detalleSelected = 0;
                this.generarTablaDeDetalles(data.detalles);
                HSOverlay.close('#hs-danger-alert');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        const cantidadInput = document.getElementById('cantidad');
        const precioUnitarioInput = document.getElementById('precio_unitario');
        const impuestosInput = document.getElementById('impuestos');
        const descuentoInput = document.getElementById('descuento');
        const exentoInput = document.getElementById('exento');
        const totalInput = document.getElementById('total');

        cantidadInput.addEventListener('input', calcularTotal);
        precioUnitarioInput.addEventListener('input', calcularTotal);
        descuentoInput.addEventListener('input', calcularTotal);
        impuestosInput.addEventListener('input', calcularTotal);
        exentoInput.addEventListener('input', calcularTotal);

        function calcularTotal()
        {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const precio = parseFloat(precioUnitarioInput.value) || 0;
            const impuestos = parseFloat(impuestosInput.value) || 0;
            const descuento = parseFloat(descuentoInput.value) || 0;

            const total = ((parseFloat(cantidad) * parseFloat(precio)) + parseFloat(impuestos)) - parseFloat(descuento);
            totalInput.value =  total.toFixed(2);

            calculoIva()
        }

        function calculoIva()
        {
            let cantidad = document.getElementById('cantidad').value == '' ? 0 : document.getElementById('cantidad').value;
            let precio = document.getElementById('precio_unitario').value == '' ? 0 : document.getElementById('precio_unitario').value;
            let exento = document.getElementById('exento').checked == true ? 's' : 'n';

            let total = exento == 's' ? 0.00 : (((parseFloat(cantidad) * parseFloat(precio)) / 1.12) * 0.12);

            document.getElementById('valor_iva').value = total.toFixed(2);
        }

        function subirAdjunto()
        {
            const errorContainer = document.getElementById('errorArchivoContainer');
            errorContainer.innerHTML = '';

            if (clickEnabled) {
              clickEnabled = false;
              document.getElementById('spin2-detalle').classList.remove('hidden');

                const adjunto = document.getElementById('adjunto').files[0];
                var datos = new FormData();
                datos.append("documento", adjunto);

                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = '{{ route("documentos_proveedor.pdf", $documento) }}';

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
                        generarListadoArchivos(responseData);
                    }

                    clickEnabled = true;
                    document.getElementById('spin2-detalle').classList.add('hidden');
                });
            }
        }

        function generarListadoArchivos(data)
        {
            document.getElementById("adjunto").value = '';

            const archivosCargados = document.getElementById('archivos-cargados');
            archivosCargados.innerHTML = '';

            const archivoContainer = document.createElement('div');
            archivoContainer.className = 'flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3';

            const p = document.createElement('p');
            p.className = 'text-gray-700';
            p.textContent = `Nombre: Documento PDF`;

            const botonesContainer = document.createElement('div');
            botonesContainer.className = 'flex items-center space-x-3';

            const botonDescargar = document.createElement('a');
            botonDescargar.className = 'text-blue-500 hover:text-blue-700';
            botonDescargar.href = data.url_descarga;
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
                eliminarArchivo(data.documento.id);
            });



            botonesContainer.appendChild(botonEliminar);
            botonesContainer.appendChild(botonDescargar);

            archivoContainer.appendChild(p);
            archivoContainer.appendChild(botonesContainer);
            archivosCargados.appendChild(archivoContainer);

        }

        function eliminarArchivo($file_id)
        {
            fetch("{{ route('documentos_proveedor.pdf_eliminar', ':documento') }}".replace(':documento', $file_id))
            .then(response => response.json())
            .then(function(responseData) {
                document.getElementById("archivos-cargados").innerHTML = '';
            });
        }
    </script>
</x-app-layout>
