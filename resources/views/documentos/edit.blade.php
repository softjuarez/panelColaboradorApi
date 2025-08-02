<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('documentos.index') }}">
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

    @if ($errors->any())
        <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
            <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            {{ __('Documento') }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Formulario para editar documento.') }}
                        </p>
                    </div>

                    <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                        <button id="hs-table-dropdown-1" type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            Acciones
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                            </svg>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-10 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700" role="menu" aria-orientation="vertical" aria-labelledby="hs-table-dropdown-1">
                        @if ($documento->estatus == 2)
                          <div class="py-2 first:pt-0 last:pb-0">
                            <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                              Validacion del Documento
                            </span>
                            <button class="w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" data-hs-overlay="#hs-rechazar">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-rose-400"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                              Rechazar
                            </button>

                            <button class="w-full flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" data-hs-overlay="#hs-autorizar">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-teal-400"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                              Autorizar
                            </button>
                          </div>
                        @endif
                          <div class="py-2 first:pt-0 last:pb-0">
                            <span class="block py-2 px-3 text-xs font-medium uppercase text-gray-400 dark:text-neutral-600">
                              Opciones del Documento
                            </span>
                            <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="{{ route('download.file', ['directorio' => base64_encode($documento->pdf)]) }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 18v-6"/><path d="m9 15 3 3 3-3"/></svg>
                              Descargar Documento
                            </a>
                            @if ($documento->estatus == 2)
                            <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="{{ route('documentos.calcular_fecha_pago', $documento) }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M11 10v4h4"/><path d="m11 14 1.535-1.605a5 5 0 0 1 8 1.5"/><path d="M16 2v4"/><path d="m21 18-1.535 1.605a5 5 0 0 1-8-1.5"/><path d="M21 22v-4h-4"/><path d="M21 8.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h4.3"/><path d="M3 10h4"/><path d="M8 2v4"/></svg>
                              Calcular Fechas de Pago
                            </a>
                            @endif
                            <button class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" data-hs-overlay="#hs-documentos">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M12 12v6"/><path d="m15 15-3-3-3 3"/></svg>
                              Retencionar / Exento
                            </button>
                            <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700 dark:focus:text-neutral-300" href="{{ route('ordenes_compra.edit', $documento->ordcom_h) }}">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                              Ir a la Orden de Compra
                            </a>
                          </div>
                        </div>
                    </div>
                </div>
            </div>


            <form method="post" action="{{ route('documentos.update', $documento) }}">
                @csrf
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

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('documentos.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Cancel') }}
                    </a>

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
                </nav>
            </div>

            <div class="mt-3">
                <div id="hs-tab-to-select-1" role="tabpanel" aria-labelledby="hs-tab-to-select-item-1">
                <div class="-m-1.5 overflow-x-auto px-6 md:px-0">
                    <div class="md:flex md:justify-between md:items-center md:border-b border-gray-200 dark:border-gray-700 pb-2">
                        <div>
                        </div>

                        <div>
                            @if ($documento->estatus == 1)
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
                                    {{ __("Sub Total") }}
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-2 text-left">
                            <div class="flex items-center gap-x-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                    {{ __("Descuento") }}
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
                                    <button onclick="obtenerDetalle(2, {{ $detalle->id }})" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Ver</button>
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
                @if ($documento->estatus == 1)
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
    @endif

    @if ($documento->estatus == 2)
    <div id="hs-autorizar" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-autorizar-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-autorizar">
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
                            <h3 id="hs-autorizar-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                Autorización de Documento
                            </h3>
                            <p class="text-gray-700 text-sm">
                                Estás a punto de autorizar permanentemente el documento con el numero <strong>{{ $documento->serie }}</strong>.
                            </p>
                            <p class="text-gray-700 text-sm mt-2">
                                🔒 <strong>Esta acción es irreversible.</strong> Una vez confirmada, no podrás deshacerla. Por favor, procede con precaución.
                            </p>
                            <div class="bg-white p-3 rounded-md mt-3">
                                <p class="text-gray-700 text-sm">
                                    ✅ Antes de continuar, verifica:
                                </p>
                                <ul class="list-disc list-inside text-gray-700 text-sm pl-4">
                                    <li>Que los datos del documento sean correctos.</li>
                                    <li>Que los detalles estén debidamente justificados.</li>
                                    <li>Que el documento cumpla con las políticas y procedimientos establecidos.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-autorizar">
                    Cancelar
                </button>
                <a href="{{ route('documentos.autorizar', $documento) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
                    Autorizar
                </a>
                </div>
            </form>
        </div>
        </div>
    </div>
    @endif

    @if ($documento->estatus == 2)
    <div id="hs-rechazar" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-rechazar-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-rechazar">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            </div>

            <form action="{{ route('documentos.rechazar', $documento)}}" method="post">
                <div class="p-4 sm:p-10 overflow-y-auto">
                    <div class="flex gap-x-4 md:gap-x-7">
                        <!-- Icon -->
                        <span class="shrink-0 inline-flex justify-center items-center size-[46px] sm:w-[62px] sm:h-[62px] rounded-full border-4 border-rose-50 bg-rose-100 text-rose-500 dark:bg-rose-700 dark:border-rose-600 dark:text-rose-100">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        </span>
                        <!-- End Icon -->

                        <div class="grow">
                            <h3 id="hs-rechazar-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                                Rechazo de Documento
                            </h3>
                            <p class="text-gray-700 text-sm">
                                Estás a punto de rechazar el documento con el numero <strong>{{ $documento->serie }}</strong>.
                            </p>
                            <p class="text-gray-700 text-sm mt-2">
                                🔒 <strong>Esta acción es irreversible.</strong> Una vez confirmada, no podrás deshacerla. Por favor, procede con precaución.
                            </p>
                            <div class="bg-white p-3 rounded-md mt-3">
                                <p class="text-gray-700 text-sm">
                                    ❌ Antes de continuar, asegúrate de:
                                </p>
                                <ul class="list-disc list-inside text-gray-700 text-sm pl-4">
                                    <li>Verificar que el rechazo esté debidamente justificado.</li>
                                    <li>Comunicar al solicitante las razones del rechazo.</li>
                                    <li>Confirmar que el documento no cumple con los requisitos necesarios.</li>
                                </ul>
                            </div>

                            @csrf
                            <div class="p-4">
                                <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="input-label" class="block text-sm font-medium mb-2 dark:text-white">Motivo de Rechazo</label>
                                    <textarea name="motivo_rechazo" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:placeholder-neutral-500 dark:text-neutral-400" value="{{ old('motivo_rechazo') }}" placeholder="Motivo del rechazo" autofocus="" required></textarea>
                                    <x-input-error class="mt-2 px-2" :messages="$errors->get('motivo_rechazo')" />
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-rechazar">
                        Cancelar
                    </button>
                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-rose-500 text-white hover:bg-rose-600 disabled:opacity-50 disabled:pointer-events-none">
                        Rechazar
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
    @endif

    <div id="hs-documentos" class="hs-overlay [--overlay-backdrop:static] hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-xml-label" data-hs-overlay-keyboard="false">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
          <div class="flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
              <h3 id="hs-xml-label" class="font-bold text-gray-800 dark:text-white">
                Documentos Retencion y Exento
              </h3>
              <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-documentos">
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
                    <div class="flex items-center gap-x-3">
                        <label for="exento_documento" class="relative inline-block w-9 h-5 cursor-pointer">
                            <input type="checkbox" id="exento_documento" class="peer sr-only">
                            <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                            <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                        </label>
                        <label for="exento_documento" class="text-sm text-gray-500 dark:text-neutral-400">Es Exento?</label>
                    </div>
                </div>

                <div id="errorArchivoContainer" class="mt-4"></div>

                <div id="archivos-cargados" class="p-4 mt-4 bg-gray-100 rounded-md">
                    @if (empty($documento->path_retencion) && empty($documento->path_exento))
                        <p class="text-gray-500 dark:text-neutral-400">No se ha cargado ningún archivo.</p>
                    @else

                        @if (!empty($documento->path_retencion))
                        <div class="flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3">
                            <p class="text-gray-700">Documento de Retencion</p>
                            <div class="flex items-center space-x-3">
                                <button class="text-red-500 hover:text-red-700" onclick="eliminarArchivo(1)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" x2="10" y1="11" y2="17"/>
                                        <line x1="14" x2="14" y1="11" y2="17"/>
                                    </svg>
                                </button>

                                <a href="{{ route('download.file', ['directorio' => base64_encode($documento->path_retencion)]) }}" class="text-blue-500 hover:text-blue-700" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" x2="12" y1="15" y2="3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endif

                        @if (!empty($documento->path_exento))
                        <div class="flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3">
                            <p class="text-gray-700">Documento Exento</p>
                            <div class="flex items-center space-x-3">
                                <button class="text-red-500 hover:text-red-700" onclick="eliminarArchivo(2)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" x2="10" y1="11" y2="17"/>
                                        <line x1="14" x2="14" y1="11" y2="17"/>
                                    </svg>
                                </button>

                                <a href="{{ route('download.file', ['directorio' => base64_encode($documento->path_exento)]) }}" class="text-blue-500 hover:text-blue-700" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                        <polyline points="7 10 12 15 17 10"/>
                                        <line x1="12" x2="12" y1="15" y2="3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endif
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
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-documentos">
                        Cerrar
                    </button>
                    <button id="cargar_adjunto" onclick="subirAdjunto()" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Cargar Adjunto
                    </button>
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
                const exento = document.getElementById('exento_documento').checked ? 'S' : 'N';

                var datos = new FormData();
                datos.append("documento", adjunto);
                datos.append("exento", exento);


                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = '{{ route("documentos.pdf", $documento) }}';

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

            data.archivos.forEach(archivo => {
                if (archivo.cargado) {
                    const archivoContainer = document.createElement('div');
                    archivoContainer.className = 'flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3';

                    const p = document.createElement('p');
                    p.className = 'text-gray-700';
                    p.textContent = `Nombre: ${archivo.nombre}`;

                    const botonesContainer = document.createElement('div');
                    botonesContainer.className = 'flex items-center space-x-3';

                    const botonDescargar = document.createElement('a');
                    botonDescargar.className = 'text-blue-500 hover:text-blue-700';
                    botonDescargar.href = archivo.url_descarga;
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
                        eliminarArchivo(archivo.tipo === 'retencion' ? 1 : 2);
                    });

                    botonesContainer.appendChild(botonEliminar);
                    botonesContainer.appendChild(botonDescargar);

                    archivoContainer.appendChild(p);
                    archivoContainer.appendChild(botonesContainer);
                    archivosCargados.appendChild(archivoContainer);
                }
            });
        }

        function eliminarArchivo($tipo)
        {
            fetch("{{ route('documentos.pdf_eliminar', [$documento, ':tipo']) }}".replace(':tipo', $tipo))
            .then(response => response.json())
            .then(function(responseData) {
                generarListadoArchivos(responseData);
            });
        }
    </script>
</x-app-layout>
