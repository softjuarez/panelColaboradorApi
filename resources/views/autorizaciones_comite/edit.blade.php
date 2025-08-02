<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-gray-500" href="{{ route('autoriza-comite.index') }}">
            <svg class="flex-shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-600" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            {{ __('Autorizacion de Requisiciones Comite') }}
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
            <div class="mb-2">
                <div class="flex items-start justify-between">
                  <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                      {{ __('Editar Requisicion') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Formulario para editar requisicion') }}.
                    </p>
                  </div>

                  @if ($requisicion->ESTATUS == 'H')
                    <div class="flex items-center gap-2">
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-rose-600 text-white hover:bg-rose-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-rechazar" data-hs-overlay="#hs-rechazar">Rechazar</button>

                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-autorizar" data-hs-overlay="#hs-autorizar">Autorizar</button>
                    </div>
                  @endif

                </div>

                <div class="mt-2">
                  <table class="dark:text-gray-200 text-sm">
                      <tr>
                          <td><b>Numero:</b></td>
                          <td class="px-6">{{ rtrim($requisicion->NUMERO) }}</td>
                          <td><b>Fecha:</b></td>
                          <td class="px-6">{{ date('d/m/Y', strtotime($requisicion->FECHA)) }}</td>
                      </tr>
                      <tr>
                          <td><b>Tipo Cambio:</b></td>
                          <td class="px-6">{{ number_format($requisicion->TIPO_CAMBIO, 2, '.', '') }}</td>
                          <td><b>Total:</b></td>
                          <td class="px-6" id="total-requisicion"></td>
                      </tr>
                      <tr>
                          <td><b>Empresa:</b></td>
                          <td colspan="3" class="px-6">{{ Str::of($requisicion->nombreEmpresa())->title() }}</td>
                      </tr>
                      <tr>
                          <td><b>Solicitante:</b></td>
                          <td colspan="3" class="px-6">{{ Str::of($requisicion->SOLICITANTE)->title() }}</td>
                      </tr>
                      <tr>
                          <td><b>Tipo Compra:</b></td>
                          <td colspan="3" class="px-6">{{ Str::of($requisicion->tipoCompra())->title() }}</td>
                      </tr>
                      <tr class="{{ $requisicion->T_RECHAZO != 'A' ? 'hidden' : '' }}">
                          <td><b>Asignado a:</b></td>
                          <td colspan="3" class="px-6">{{ Str::of($requisicion->usuarioDestino())->title() }}</td>
                      </tr>
                      <tr>
                          <td><b>Lugar de entrega:</b></td>
                          <td colspan="3" class="px-6">{{ Str::of($requisicion->COMENTARIO2)->title() }}</td>
                      </tr>
                      <tr>
                          <td><b>Comentarios:</b></td>
                          <td colspan="3" class="px-6">{{ Str::of($requisicion->COMENTARIOS)->title() }}</td>
                      </tr>
                  </table>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <form method="post" action="{{ route('autoriza-comite.update', $requisicion) }}">
                @csrf

                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        {{ __('Datos Generales') }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Formulario para editar datos generales') }}.
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('autoriza-comite.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        {{ __('Cancel') }}
                        </a>
                        @if ($requisicion->T_RECHAZO == 'H')
                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        {{ __('Save') }}
                        </button>
                        @endif
                    </div>
                </div>

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Renglon de Presupuesto*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <x-select-search
                            id="renglon_presupuesto"
                            name="renglon_presupuesto"
                            :items="$renglones"
                            value-field="DFRECNUM"
                            label-field="CLAVE"
                            placeholder="Busca un centros de costo"
                            :selected="@old('renglon_presupuesto', $requisicion->RENGLON_PRESUPUESTO)"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            disabled
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('renglon_presupuesto')" />
                    </div>

                     <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Centro de Costo*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                         <x-select-search
                            id="centro_costo"
                            name="centro_costo"
                            :items="$centros_costo"
                            value-field="NUMERO"
                            label-field="DESCRIPCION"
                            placeholder="Busca un centros de costo"
                            :selected="@old('centro_costo', rtrim($requisicion->CTROCSTO))"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            disabled
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('centro_costo')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Cuenta Contable') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <x-select-search
                            id="cuenta_contable"
                            name="cuenta_contable"
                            :items="$cuentas"
                            value-field="DFRECNUM"
                            label-field="NOMBRE"
                            placeholder="Busca cuenta contable"
                            :selected="@old('cuenta_contable', $requisicion->CUENTA_CONTABLE)"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('cuenta_contable')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Sedes*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <x-select-search
                            id="sedes"
                            name="sedes"
                            :items="$sedes"
                            value-field="RECNUM"
                            label-field="NOMBRE"
                            placeholder="Busca un colaboradores "
                            :selected="@old('sedes', explode(',', $requisicion->SEDES))"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            multiple
                            disabled
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('sedes')" />
                    </div>

                    <div id="ficha-container" class="sm:col-span-3 {{ $requisicion->T_RECHAZO != 'A' ? 'hidden' : '' }}">
                        <label for="ficha" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Colaborador(es)*') }}
                        </label>
                    </div>

                    <div id="ficha-select-container" class="sm:col-span-9 {{ $requisicion->T_RECHAZO != 'A' ? 'hidden' : '' }}">
                        <x-select-search
                            id="colaborador"
                            name="colaborador"
                            :items="$fichas"
                            value-field="NUMERO"
                            label-field="NOMBRE"
                            placeholder="Busca un colaboradores "
                            :selected="@old('colaborador', explode(',', $requisicion->USUARIO_DESTINO))"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            multiple
                            disabled
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('colaborador')" />
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
              <button type="button" class="hs-tab-active:bg-white hs-tab-active:dark:bg-slate-900 hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 -mb-px py-3 px-4 inline-flex items-center gap-2 bg-gray-50 dark:bg-slate-900 text-sm font-medium text-center border text-gray-500 rounded-t-lg hover:text-gray-700" id="hs-tab-to-select-item-3" data-hs-tab="#hs-tab-to-select-3" aria-controls="hs-tab-to-select-3" role="tab">
                Bitacora
              </button>
              <button type="button" class="hs-tab-active:bg-white hs-tab-active:dark:bg-slate-900 hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 -mb-px py-3 px-4 inline-flex items-center gap-2 bg-gray-50 dark:bg-slate-900 text-sm font-medium text-center border text-gray-500 rounded-t-lg hover:text-gray-700" id="hs-tab-to-select-item-4" data-hs-tab="#hs-tab-to-select-4" aria-controls="hs-tab-to-select-4" role="tab">
                Adjuntos
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
                    <div class="inline-flex gap-x-2">

                    </div>
                  </div>
                </div>
                <!-- End Header -->

                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2" class="w-full px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Descripcion") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" colspan="6" class="px-6 py-1 text-center">
                                <div class="flex items-center justify-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Cantidades") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" rowspan="2" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Precio") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" rowspan="2" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Total") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-1 text-right"></th>
                        </tr>

                        <tr>
                            <th scope="col" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Req.") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Jefe") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Teso.") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Gest.") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Comp.") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-1 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Comi.") }}
                                    </span>
                                </div>
                            </th>

                            <th></th>
                        </tr>
                    </thead>



                    <tbody id="tabla-detalles" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($requisicion->detalles as $detalle)
                        <tr>
                            <td class="h-px w-px">
                            <div class="px-6 py-1">
                                <span class="text-sm text-gray-600">{{ $detalle->DESCRIPCION }}</span>
                            </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_REQ, 2, '.', ',') }}</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1 text-right">
                                <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_AUT1, 2, '.', ',') }}</span>
                            </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_AUT2, 2, '.', ',') }}</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_AUT3, 2, '.', ',') }}</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1 text-right">
                                <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_OC, 2, '.', ',') }}</span>
                            </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_AUT4, 2, '.', ',') }}</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1 text-right">
                                <span class="text-sm text-gray-600">{{ number_format($detalle->PU, 2, '.', ',') }}</span>
                            </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">{{ number_format($detalle->CANT_AUT4 * $detalle->PU, 2, '.', ',') }}</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1">
                                    <button onclick="obtenerDetalleDeReqD({{ $detalle->NUMERO }})" type="button" class="inline-flex items-center gap-x-2 text-sm py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Detalles</button>


                                    <button onclick="obtenerDetalle(2, {{ $detalle->NUMERO }})" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>
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
            <div id="hs-tab-to-select-2" class="hidden" role="tabpanel" aria-labelledby="hs-tab-to-select-item-2">
                <div class="-m-1.5 overflow-x-auto px-6 md:px-0">
                    <div class="md:flex md:justify-between md:items-center md:border-b border-gray-200 dark:border-gray-700 pb-2">
                      <div>
                      </div>

                      <div>
                        <div class="inline-flex gap-x-2">

                        </div>
                      </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                      <thead>
                        <tr>
                          <th scope="col" class="w-full px-6 py-2 text-left">
                              <div class="flex items-center gap-x-2">
                                  <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                      {{ __("Concepto") }}
                                  </span>
                              </div>
                          </th>

                          <th scope="col" class="px-6 py-2 text-left">
                            <div class="flex items-center gap-x-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                    {{ __("Valor") }}
                                </span>
                            </div>
                          </th>

                          <th scope="col" class="px-6 py-2 text-right"></th>
                        </tr>
                      </thead>

                      <tbody id="tabla-detalles-p" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($requisicion->detallesp as $detallep)
                        <tr>
                            <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">{{ $detallep->concepto() }}</span>
                              </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">{{ number_format($detallep->VALOR, 2, '.', ',') }}</span>
                              </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1">
                                <button onclick="obtenerDetalleP(2, {{ $detallep->RECNUM }})" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>

                              </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                          <td colspan="4" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                        </tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
            </div>
            <div id="hs-tab-to-select-3" class="hidden" role="tabpanel" aria-labelledby="hs-tab-to-select-item-3">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                      <tr>
                        <th scope="col" class="px-6 py-2 text-left">
                            <div class="flex items-center gap-x-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                    {{ __("Fecha") }}
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-2 text-left">
                            <div class="flex items-center gap-x-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                    {{ __("Usuario") }}
                                </span>
                            </div>
                        </th>

                        <th scope="col" class="px-6 py-2 text-left">
                          <div class="flex items-center gap-x-2">
                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                  {{ __("Accion") }}
                              </span>
                          </div>
                        </th>

                        <th scope="col" class="px-6 py-2 text-left w-full">
                          <div class="flex items-center gap-x-2">
                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                  {{ __("Descripcion") }}
                              </span>
                          </div>
                        </th>
                      </tr>
                    </thead>

                    <tbody id="tabla-bitacora" class="divide-y divide-gray-200 dark:divide-gray-700">

                    </tbody>
                  </table>
            </div>
            <div id="hs-tab-to-select-4" class="hidden" role="tabpanel" aria-labelledby="hs-tab-to-select-item-4">

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Nombre del Archivo*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input name="nombre" id="nombre_archivo" type="text" class="py-2 px-3  block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="recibo.pdf">
                            <input type="file" name="archivo" id="archivo" class="block w-full border border-gray-200 shadow-sm text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400

                            -mt-px -ms-px last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg relative dark:focus:ring-gray-600


                            file:bg-blue-500 file:text-white file:border-0
                            file:me-4
                            file:py-2 file:px-6
                            dark:file:bg-neutral-700 dark:file:text-neutral-400">
                        </div>
                    </div>
                </div>
                <div class="mt-5 flex justify-end gap-x-2">
                </div>

                <div id="errorArchivoContainer" class="mt-4"></div>

                <div id="archivos-cargados" class="p-4 bg-gray-100 rounded-md"></div>
            </div>
        </div>
    </div>

    <div id="hs-vertically-centered-scrollable-modal-request-quotation" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-6xl sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)] min-h-[calc(100%-3.5rem)] sm:flex items-center">
          <div class="w-full max-h-full flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="flex justify-between items-center py-3 px-4 border-b ">
              <h3 class="font-bold text-gray-800 ">
                Detalle de requisicion
              </h3>
              <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm " data-hs-overlay="#hs-vertically-centered-scrollable-modal-request-quotation">
                <span class="sr-only">Close</span>
                <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                </svg>
              </button>
            </div>

            <div class="p-4">
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                      <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                          {{ __('U. Medida / Cantidad* / Precio Unitario*') }}
                      </label>
                    </div>

                    <div class="sm:col-span-9">
                      <div class="sm:flex">
                          <input name="unidad_medida" id="unidad_medida" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Unidad de Medida" onfocus="this.select()" disabled>
                          <input name="cantidad" id="cantidad" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Cantidad" value="1" onfocus="this.select()">
                          <input name="precio_unitario" id="precio_unitario" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Precio Unitario" value="0" onfocus="this.select()" disabled>
                          <input name="total" id="total" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Precio Unitario" value="0" disabled>
                      </div>
                  </div>

                  <div class="sm:col-span-3">
                    <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Descripcion*') }}
                    </label>
                  </div>

                  <div class="sm:col-span-9">
                      <div class="sm:flex">
                          <textarea name="descripcion" id="descripcion" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Descripcion del detalle." onfocus="this.select()" disabled></textarea>
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
                <button type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-vertically-centered-scrollable-modal-request-quotation">
                  Cerrar
                </button>

                @if ($requisicion->T_RECHAZO == 'A')
                <button id="save-cotizacion" type="button" onclick="generarDetalle()" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  Guardar
                </button>
                @endif
              </div>
            </div>
          </div>
        </div>
    </div>

    <div id="hs-detalle-p" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-6xl sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)] min-h-[calc(100%-3.5rem)] sm:flex items-center">
          <div class="w-full max-h-full flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="flex justify-between items-center py-3 px-4 border-b ">
              <h3 class="font-bold text-gray-800 ">
                Detalle de requisicion
              </h3>
              <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm " data-hs-overlay="#hs-detalle-p">
                <span class="sr-only">Close</span>
                <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                </svg>
              </button>
            </div>

            <div class="p-4">
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Concepto*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select name="concepto" id="concepto" data-hs-select='{
                            "hasSearch": true,
                            "searchPlaceholder": "Search...",
                            "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                            "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                            "placeholder": "Select option...",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }' class="hidden" disabled>
                            @foreach ($conceptos as $item)
                                <option value="{{ $item->NUMERO_INTERNO }}">{{ $item->CLAVE }} - {{ $item->DESCRIPCION }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-3">
                      <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                          {{ __('Valor*') }}
                      </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input name="valor" id="valor" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Precio Unitario" value="0" onfocus="this.select()">
                        </div>
                    </div>
                </div>
            </div>

            <div id="errorContainerP" class="px-4 pb-2"></div>

            <div class="flex justify-between items-center gap-x-2 py-3 px-4 border-t">
              <div>
                <svg id="spin-detalle-p" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat animate-spin w-6 h-6 hidden" viewBox="0 0 16 16">
                    <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                    <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                </svg>
              </div>

              <div class="mt-5 flex justify-end gap-x-2">
                <button type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-detalle-p">
                  Cerrar
                </button>

                <button id="save-cotizacion" type="button" onclick="generarDetalleP()" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  Guardar
                </button>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div id="detalles_requisicion_d" class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-6xl sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)] min-h-[calc(100%-3.5rem)] sm:flex items-center">
          <div class="w-full max-h-full overflow-hidden flex flex-col bg-white border shadow-sm rounded-xl">
            <div class="flex justify-between items-center py-3 px-4 border-b ">
              <h3 class="font-bold text-gray-800 ">
                Detalles
              </h3>
              <button type="button" class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm " data-hs-overlay="#detalles_requisicion_d">
                <span class="sr-only">Close</span>
                <svg class="w-3.5 h-3.5" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.258206 1.00652C0.351976 0.912791 0.479126 0.860131 0.611706 0.860131C0.744296 0.860131 0.871447 0.912791 0.965207 1.00652L3.61171 3.65302L6.25822 1.00652C6.30432 0.958771 6.35952 0.920671 6.42052 0.894471C6.48152 0.868271 6.54712 0.854471 6.61352 0.853901C6.67992 0.853321 6.74572 0.865971 6.80722 0.891111C6.86862 0.916251 6.92442 0.953381 6.97142 1.00032C7.01832 1.04727 7.05552 1.1031 7.08062 1.16454C7.10572 1.22599 7.11842 1.29183 7.11782 1.35822C7.11722 1.42461 7.10342 1.49022 7.07722 1.55122C7.05102 1.61222 7.01292 1.6674 6.96522 1.71352L4.31871 4.36002L6.96522 7.00648C7.05632 7.10078 7.10672 7.22708 7.10552 7.35818C7.10442 7.48928 7.05182 7.61468 6.95912 7.70738C6.86642 7.80018 6.74102 7.85268 6.60992 7.85388C6.47882 7.85498 6.35252 7.80458 6.25822 7.71348L3.61171 5.06702L0.965207 7.71348C0.870907 7.80458 0.744606 7.85498 0.613506 7.85388C0.482406 7.85268 0.357007 7.80018 0.264297 7.70738C0.171597 7.61468 0.119017 7.48928 0.117877 7.35818C0.116737 7.22708 0.167126 7.10078 0.258206 7.00648L2.90471 4.36002L0.258206 1.71352C0.164476 1.61976 0.111816 1.4926 0.111816 1.36002C0.111816 1.22744 0.164476 1.10028 0.258206 1.00652Z" fill="currentColor"/>
                </svg>
              </button>
            </div>

            <div class="p-4 overflow-y-auto">
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-12">
                        <div class="flex justify-end items-center gap-x-3">
                            <label for="sugerido_rec_c" class="relative inline-block w-9 h-5 cursor-pointer">
                              <input type="checkbox" id="sugerido_rec_c" class="peer sr-only">
                              <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                              <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                            </label>
                            <label for="sugerido_rec_c" class="text-sm text-gray-500 dark:text-neutral-400">Sugerido?</label>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Proveedor') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="relative">
                            <select id="proveedor_req_c" name="proveedor_req_c" onchange="proveedorCustom()" disabled data-hs-select='{
                            "hasSearch": true,
                            "searchPlaceholder": "Search...",
                            "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                            "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                            "placeholder": "Select option...",
                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
                            "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                            "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-3.5 text-blue-600 dark:text-blue-500 \" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>",
                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                            }' class="hidden">
                                    <option disabled selected>Seleccionar</option>
                                @foreach ($proveedores as $proveedor )
                                    <option value="{{ $proveedor->NUMERO }}">{{ $proveedor->NOMBRE_COMPLETO }}</option>
                                @endforeach
                            </select>

                            <div class="absolute top-1/2 end-3 -translate-y-1/2">
                                <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                            </div>
                        </div>
                    </div>

                    <div id="contenedor_proveedor_req_c" class="sm:col-span-3 hidden">
                        <label for="nombre_proveedor_req_c" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Nombre') }}
                        </label>
                    </div>

                    <div id="contenedor_select_proveedor_req_c" class="sm:col-span-9 hidden">
                        <div class="sm:flex">
                            <input name="nombre_proveedor_req_c" id="nombre_proveedor_req_c" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Nombre" disabled onfocus="this.select()">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Fecha Entrega / Referencia / PU') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input name="fecha_req_c" id="fecha_req_c" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Fecha" disabled onfocus="this.select()">
                            <input name="referencia_req_c" id="referencia_req_c" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Referencia" disabled onfocus="this.select()">
                            <input name="precio_unitario_req_c" id="precio_unitario_req_c" type="text" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Referencia" value="0" step="any" disabled onfocus="this.select()">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Descripcion*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <textarea name="descripcion_req_c" id="descripcion_req_c" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Descripcion del detalle." disabled onfocus="this.select()"></textarea>
                        </div>
                    </div>
                </div>


                <div id="errorContainerD" class="pb-2"></div>

                <div>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                        <tr>
                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Prioridad") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="w-full px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Proveedor") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Comentarios") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Sugerida Compra") }}
                                    </span>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-2 text-left">
                                <div class="flex items-center gap-x-2">
                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                        {{ __("Sugerida") }}
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

                            <th scope="col" class="px-6 py-2 text-right"></th>
                        </tr>
                        </thead>

                        <tbody id="tabla-detalles-d" class="divide-y divide-gray-200 dark:divide-gray-700">

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-between items-center gap-x-2 py-3 px-4 border-t">
                <div>
                  <svg id="spin-detalle-d" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat animate-spin w-6 h-6 hidden" viewBox="0 0 16 16">
                      <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                      <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                  </svg>
                </div>

                <div class="flex justify-end gap-x-2">
                  <button type="button" class="hs-dropdown-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#detalles_requisicion_d">
                    Cerrar
                  </button>
                </div>
            </div>

          </div>
        </div>
    </div>

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
                            Generar Orden de Compra
                        </h3>
                        <p class="text-gray-700 text-sm">
                            Estás a punto de generar orden de compra permanentemente la requisición con el numero <strong>{{ $requisicion->NUMERO }}</strong>.
                        </p>
                        <p class="text-gray-700 text-sm mt-2">
                            🔒 <strong>Esta acción es irreversible.</strong> Una vez confirmada, no podrás deshacerla. Por favor, procede con precaución.
                        </p>
                        <div class="bg-white p-3 rounded-md mt-3">
                            <p class="text-gray-700 text-sm">
                                ✅ Antes de continuar, verifica:
                            </p>
                            <ul class="list-disc list-inside text-gray-700 text-sm pl-4">
                                <li>Que los datos de la requisición sean correctos.</li>
                                <li>Que los recursos solicitados estén debidamente justificados.</li>
                                <li>Que la requisición cumpla con las políticas y procedimientos establecidos.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
                <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-autorizar">
                    Cancelar
                </button>
                <a href="{{ route('ordenes.create', $requisicion) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
                    Generar OC
                </a>
            </div>
        </div>
        </div>
    </div>

    <div id="hs-rechazar" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-rechazar-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-rechazar">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            </div>

            <form action="{{ route('autoriza-comite.rechazar', $requisicion)}}" method="post">
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
                                Rechazo de Requisición
                            </h3>
                            <p class="text-gray-700 text-sm">
                                Estás a punto de rechazar la requisición con el numero <strong>{{ $requisicion->NUMERO }}</strong>.
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
                                    <li>Confirmar que la requisición no cumple con los requisitos necesarios.</li>
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

    <script>
        let detalleSelected = 0;
        let detalleCSelected = 0;
        let detallePSelected = 0;
        let crearOEditar = 0;
        let crearOEditarP = 0;
        let crearOEditarC = 1;
        let clickEnabled = true;
        let detalleP;
        let detalleCObject;

        function obtenerDetalle(crearOEditarDetalle, detalleId = 0)
        {
            crearOEditar = crearOEditarDetalle;
            detalleSelected = detalleId;

            if (crearOEditarDetalle == 1) {
                document.getElementById('unidad_medida').value = '';
                document.getElementById('cantidad').value = 1;
                document.getElementById('precio_unitario').value = 0;
                document.getElementById('descripcion').value = '';
                calcularTotal();
            } else {
                fetch("{{ route('detalle.compra.edit', ':detalle') }}".replace(':detalle', detalleId))
                .then(response => response.json())
                .then(function(data) {
                    document.getElementById('unidad_medida').value = data.detalle.UNI_MED;
                    document.getElementById('cantidad').value = data.detalle.CANT_AUT4;
                    document.getElementById('precio_unitario').value = data.detalle.PU;
                    document.getElementById('descripcion').value = data.detalle.DESCRIPCION;
                    calcularTotal();
                    obtenerBitacora();
                });
            }



            HSOverlay.open(document.getElementById('hs-vertically-centered-scrollable-modal-request-quotation'))
        }

        function obtenerDetalleDeReqD(detalleId)
        {
            detalleSelected = detalleId;
            crearOEditarC = 1;
            fetch("{{ route('requisiciones_c_detalle.listado', ':detalle') }}".replace(':detalle', detalleId))
            .then(response => response.json())
            .then(function(data) {
                generarTablaDeDetallesRequerimientosD(data.detalles)
            });

            HSOverlay.open(document.getElementById('detalles_requisicion_d'))
        }

        function obtenerDetalleP(crearOEditarDetalle, detalleId = 0)
        {
            crearOEditarP = crearOEditarDetalle;
            detallePSelected = detalleId;

            const select = HSSelect.getInstance('#concepto');
            select.destroy();

            if (crearOEditarDetalle == 1) {
                document.getElementById('valor').value = '';
                document.getElementById('concepto').value = '';
                new HSSelect(document.querySelector('#concepto'));
            } else {
                fetch("{{ route('requisiciones_detalle_p.edit', ':detalle') }}".replace(':detalle', detalleId))
                .then(response => response.json())
                .then(function(data) {
                    document.getElementById('valor').value = data.detalle.VALOR;
                    document.getElementById('concepto').value = data.detalle.CONCPPTO;
                    detalleP = data.detalle
                    new HSSelect(document.querySelector('#concepto'));
                });
            }

            HSOverlay.open(document.getElementById('hs-detalle-p'))
        }

        function generarTablaDeDetallesRequerimientosD(data)
        {
            document.getElementById("tabla-detalles-d").innerHTML = '';

            if (data.length > 0) {
                for(var i = 0; i <= data.length -1 ; i++) {
                    document.getElementById("tabla-detalles-d").insertAdjacentHTML("beforeend", `
                        <tr>
                            <td class="h-px w-px">
                                <div class="px-6 py-1">
                                    <span class="text-sm text-gray-600">${ data[i].PRIORIDAD }</span>
                                </div>
                            </td>

                            <td class="h-px w-px">
                                <div class="px-6 py-1">
                                    <span class="text-sm text-gray-600">${ data[i].PRVEEDOR_NOMBRE }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1">
                                    <span class="text-sm text-gray-600">${ data[i].COMENTARIOS }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1">
                                    <span class="text-sm text-gray-600">${ data[i].AUTORIZA1 == 'S' ? 'Si' : 'No' }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1">
                                    <span class="text-sm text-gray-600">${ data[i].AUTORIZA2 == 'S' ? 'Si' : 'No' }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                                <div class="px-6 py-1 text-right">
                                    <span class="text-sm text-gray-600">${ parseFloat(data[i].PU).toFixed(2) }</span>
                                </div>
                            </td>

                            <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1">
                                <button onclick="editarDetalleC(${data[i].RECNUM})" type="button" class="inline-flex items-center gap-x-2 text-sm py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>

                            </div>
                            </td>
                        </tr>
                    `);
                }
            } else {
                document.getElementById("tabla-detalles-d").insertAdjacentHTML("beforeend", `
                    <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                        <td colspan="6" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                    </tr>
                `);
            }
        }

        function generarDetalleD()
        {
            if (clickEnabled) {
              clickEnabled = false;
              document.getElementById('spin-detalle-d').classList.remove('hidden');

              const errorContainer = document.getElementById('errorContainerD');
              errorContainer.innerHTML = '';

              const datos = JSON.stringify({
                sugerido: document.getElementById('sugerido_rec_c').checked ? 'S' : 'N',
                proveedor: detalleCObject.PRVEEDOR,
                proveedor_nombre: detalleCObject.PRVEEDOR_NOMBRE,
                fecha_entrega: detalleCObject.FECHA,
                referencia: detalleCObject.REFERENCIA_PR,
                precio_unitario: detalleCObject.PU,
                prioridad: detalleCObject.PRIORIDAD,
                descripcion: detalleCObject.COMENTARIOS,
              });

              let url = "";
              if (crearOEditarC == 1){
                  url = "{{ route('requisiciones_c_detalle.store', ':detalle') }}";
                  url = url.replace(':detalle', detalleSelected);
              } else {
                  url = "{{ route('requisiciones_c_detalle.update', ':detalle') }}";
                  url = url.replace(':detalle', detalleCSelected);
              }

              let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

              fetch(url, {
                  method: "POST",
                  body: datos,
                  headers: {
                      "X-CSRF-TOKEN": token,
                      "Accept": "application/json", // Indica que esperas una respuesta JSON
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
                    this.obtenerDetalleDeReqD(detalleSelected);
                    this.obtenerDetalles();
                    limpiarCamposC()
                  }

                  document.getElementById('spin-detalle-d').classList.add('hidden');
                  clickEnabled = true;
              });
            }
        }

        function generarDetalleP()
        {
            if (clickEnabled) {
              clickEnabled = false;
              document.getElementById('spin-detalle-p').classList.remove('hidden');

              const errorContainer = document.getElementById('errorContainerP');
              errorContainer.innerHTML = '';

              const datos = JSON.stringify({
                concepto: detalleP.CONCPPTO,
                valor: document.getElementById('valor').value,
              });

              let url = "";
              if (crearOEditarP == 1){
                  url = "{{ route('requisiciones_detalle_p.store', $requisicion) }}";
              } else {
                  url = "{{ route('requisiciones_detalle_p.update', ':detalle') }}";
                  url = url.replace(':detalle', detallePSelected);
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
                    this.generarTablaDeDetallesRequerimientosP(responseData.detalles);
                    actualizarTotal();
                    HSOverlay.close(document.getElementById('hs-detalle-p'))
                  }

                  document.getElementById('spin-detalle-p').classList.add('hidden');
                  clickEnabled = true;
              });
            }
        }

        function generarTablaDeDetallesRequerimientosP(data)
        {
            document.getElementById("tabla-detalles-p").innerHTML = '';

            if (data.length > 0) {
                for(var i = 0; i <= data.length -1 ; i++) {
                    document.getElementById("tabla-detalles-p").insertAdjacentHTML("beforeend", `
                        <tr>
                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">${ data[i].CONCPPTO2 }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].VALOR).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1">
                              <button onclick="obtenerDetalleP(2, ${ data[i].RECNUM })" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>

                            </div>
                          </td>
                        </tr>
                    `);
                }
            } else {
                document.getElementById("tabla-detalles-p").insertAdjacentHTML("beforeend", `
                    <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                        <td colspan="3" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                    </tr>
                `);
            }
        }

        function generarDetalle()
        {
            if (clickEnabled) {
              clickEnabled = false;
              document.getElementById('spin-detalle').classList.remove('hidden');

              const errorContainer = document.getElementById('errorContainer');
              errorContainer.innerHTML = '';

              const datos = JSON.stringify({
                unidad_medida: document.getElementById('unidad_medida').value,
                cantidad: document.getElementById('cantidad').value,
                precio_unitario: document.getElementById('precio_unitario').value,
                descripcion: document.getElementById('descripcion').value,
              });

              let url = "";
              if (crearOEditar == 1){
                  url = "";
              } else {
                  url = "{{ route('detalle.comite.update', ':detalle') }}";
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
                    this.generarTablaDeDetallesRequerimientos(responseData.detalles);
                    actualizarTotal();
                    obtenerBitacora();
                    HSOverlay.close(document.getElementById('hs-vertically-centered-scrollable-modal-request-quotation'))
                  }

                  document.getElementById('spin-detalle').classList.add('hidden');
                  clickEnabled = true;
              });
            }
        }

        function obtenerDetalles()
        {
            url = "{{ route('detalle.compra.obtener', $requisicion) }}";
            url = url.replace(':detalle', detalleSelected);

            fetch(url)
                .then(response => response.json())
                .then(function(data) {
                    generarTablaDeDetallesRequerimientos(data.detalles);
                    actualizarTotal();
                });
        }

        function generarTablaDeDetallesRequerimientos(data)
        {
            document.getElementById("tabla-detalles").innerHTML = '';

            if (data.length > 0) {
                for(var i = 0; i <= data.length -1 ; i++) {
                    document.getElementById("tabla-detalles").insertAdjacentHTML("beforeend", `
                        <tr>
                          <td class="h-px w-px">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">${ data[i].DESCRIPCION }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].CANT_REQ).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].CANT_AUT1).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].CANT_AUT2).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].CANT_AUT3).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].CANT_OC).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].CANT_AUT4).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].PU).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1 text-right">
                                  <span class="text-sm text-gray-600">${ parseFloat(data[i].PU * data[i].CANT_AUT4).toFixed(2) }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                            <div class="px-6 py-1">
                              <button onclick="obtenerDetalleDeReqD(${ data[i].NUMERO })" type="button" class="inline-flex items-center gap-x-2 text-sm py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Detalles</button>

                              <button onclick="obtenerDetalle(2, ${ data[i].NUMERO })" type="button" class="inline-flex items-center gap-x-2 text-sm ml-2 py-1 xl:py-0 font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none hs-dark-mode-active:text-blue-500 hs-dark-mode-active:hover:text-blue-400'">Editar</button>
                            </div>
                          </td>
                        </tr>
                    `);
                }
            } else {
                document.getElementById("tabla-detalles").insertAdjacentHTML("beforeend", `
                    <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                        <td colspan="5" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                    </tr>
                `);
            }
        }

        function editarDetalleC(id)
        {
            detalleCSelected = id;
            crearOEditarC = 0;

            let select = HSSelect.getInstance('#proveedor_req_c');
            select.destroy();

            let url = "{{ route('requisiciones_c_detalle.edit', ':detalle') }}";
            url = url.replace(':detalle', id);
            fetch(url)
            .then(response => response.json())
            .then(data => {
                document.getElementById('sugerido_rec_c').checked = data.detalle.AUTORIZA2.trim() == 'S' ? true : false,
                document.getElementById('proveedor_req_c').value = data.detalle.PRVEEDOR
                document.getElementById('nombre_proveedor_req_c').value = data.detalle.PRVEEDOR_NOMBRE
                document.getElementById('fecha_req_c').value = data.detalle.FECHA
                document.getElementById('referencia_req_c').value = data.detalle.REFERENCIA_PR
                document.getElementById('precio_unitario_req_c').value = data.detalle.PU
                document.getElementById('descripcion_req_c').value = data.detalle.COMENTARIOS
                detalleCObject = data.detalle

                new HSSelect(document.querySelector('#proveedor_req_c'));
                proveedorCustom()
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function alertDetalle(detalleId)
        {
            detalleSelected = detalleId;
            HSOverlay.open('#hs-danger-alert');
        }

        function alertDetalleP(detalleId)
        {
            detallePSelected = detalleId;
            HSOverlay.open('#hs-danger-alert-p');
        }

        function eliminarDetalleC(id)
        {
            let url = "{{ route('requisiciones_c_detalle.delete', ':detalle') }}";
            url = url.replace(':detalle', id);
            fetch(url)
            .then(response => response.json())
            .then(data => {
                this.obtenerDetalleDeReqD(detalleSelected);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function limpiarCamposC()
        {
            let select = HSSelect.getInstance('#proveedor_req_c');
            select.destroy();

            document.getElementById('sugerido_rec_c').checked = false,
            document.getElementById('proveedor_req_c').value = ''
            document.getElementById('nombre_proveedor_req_c').value = ''
            document.getElementById('fecha_req_c').value = ''
            document.getElementById('referencia_req_c').value = ''
            document.getElementById('precio_unitario_req_c').value = 0
            document.getElementById('descripcion_req_c').value = ''
            detalleCSelected = 0;
            crearOEditarC = 1;
            new HSSelect(document.querySelector('#proveedor_req_c'));
        }

        function deleteDetalleP()
        {
            let url = "{{ route('requisiciones_detalle_p.delete', ':detalle') }}";
            url = url.replace(':detalle', detallePSelected);
            fetch(url)
            .then(response => response.json())
            .then(data => {
                detallePSelected = 0;
                this.generarTablaDeDetallesRequerimientosP(data.detalles);
                actualizarTotal();
                HSOverlay.close('#hs-danger-alert-p');
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        const cantidadInput = document.getElementById('cantidad');
        const precioUnitarioInput = document.getElementById('precio_unitario');
        const totalInput = document.getElementById('total');

        cantidadInput.addEventListener('input', calcularTotal);
        precioUnitarioInput.addEventListener('input', calcularTotal);


        function calcularTotal() {
            const cantidad = parseFloat(cantidadInput.value) || 0;
            const precioUnitario = parseFloat(precioUnitarioInput.value) || 0;
            const total = cantidad * precioUnitario;
            totalInput.value = total.toFixed(2); // Redondeamos a 2 decimales
        }

        actualizarTotal();
        async function actualizarTotal() {
            try {
                const response = await fetch("{{ route('autoriza-comite.obterner_total', $requisicion) }}");
                const data = await response.json();

                document.getElementById('total-requisicion').textContent = '{{ RTRIM($requisicion->MONEDA) }}' + `. ` + data.total.toFixed(2);
            } catch (error) {
                console.error('Error al obtener el total:', error);
            }
        }


        obtenerBitacora();
        function obtenerBitacora(){
            fetch("{{ route('bitacora.requisicion', $requisicion) }}")
                .then(response => response.json())
                .then(function(data) {
                    generarTablaDeBitacora(data);
                });
        }

        function generarTablaDeBitacora(data)
        {
            document.getElementById("tabla-bitacora").innerHTML = '';

            if (data.length > 0) {
                for(var i = 0; i <= data.length -1 ; i++) {
                    document.getElementById("tabla-bitacora").insertAdjacentHTML("beforeend", `
                        <tr>
                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">${ data[i].fecha2 }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">${ data[i].usuario.name }</span>
                              </div>
                          </td>

                          <td class="h-px w-px whitespace-nowrap">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">${ data[i].accion }</span>
                              </div>
                          </td>

                          <td class="h-px w-px">
                              <div class="px-6 py-1">
                                  <span class="text-sm text-gray-600">${ data[i].descripcion }</span>
                              </div>
                          </td>
                        </tr>
                    `);
                }
            } else {
                document.getElementById("tabla-bitacora").insertAdjacentHTML("beforeend", `
                    <tr class="hover:bg-gray-100 hs-dark-mode-active:hover:bg-gray-700">
                        <td colspan="4" class="px-2 py-2 whitespace-nowrap text-sm font-medium text-gray-800 text-center">No hay registros actuales!</td>
                    </tr>
                `);
            }
        }
    </script>

    <script>
        obtenerArchivos();
        function obtenerArchivos()
        {
            fetch("{{ route('archivos.index', $requisicion) }}")
                .then(response => response.json())
                .then(function(data) {
                    generarListadoArchivos(data);
                });
        }

        function generarListadoArchivos(data)
        {
            document.getElementById("nombre_archivo").value = '';
            document.getElementById("archivo").value = '';

            const archivosCargados = document.getElementById('archivos-cargados');
            archivosCargados.innerHTML = '';
            data.forEach(archivo => {
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
            botonDescargar.download = archivo.nombre;
            botonDescargar.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" x2="12" y1="15" y2="3"/>
                </svg>
            `;

            botonesContainer.appendChild(botonDescargar);

            archivoContainer.appendChild(p);
            archivoContainer.appendChild(botonesContainer);
            archivosCargados.appendChild(archivoContainer);
            });
        }

        function cargarArchivo()
        {
            const errorContainer = document.getElementById('errorArchivoContainer');
            errorContainer.innerHTML = '';

            var datos = new FormData();
            const file = document.getElementById("archivo");
            datos.append("nombre", document.getElementById("nombre_archivo").value);
            datos.append("archivo", file.files[0]);

            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch("{{ route('archivos.requisicion', $requisicion) }}", {
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
                    this.obtenerBitacora();
                }
            });
        }

        function eliminarArchivo($file_id)
        {
            fetch("{{ route('archivos.delete', ':file') }}".replace(':file', $file_id))
            .then(response => response.json())
            .then(function(responseData) {
                obtenerArchivos();
                this.obtenerBitacora();
            });
        }

        function proveedorCustom()
        {
            let proveedorSelect = document.getElementById('proveedor_req_c').value;
            let proveedorContainer = document.getElementById('contenedor_proveedor_req_c');
            let proveedorSelectContainer = document.getElementById('contenedor_select_proveedor_req_c');

            if (proveedorSelect == 4) {
                proveedorContainer.classList.remove('hidden');
                proveedorSelectContainer.classList.remove('hidden');
            } else {
                proveedorContainer.classList.add('hidden');
                proveedorSelectContainer.classList.add('hidden');
            }
        }

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.select();
            });
        });
    </script>
</x-app-layout>
