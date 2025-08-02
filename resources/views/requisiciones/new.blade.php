<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('requisiciones.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Requisiciones') }}
          </a>
      </li>
      <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('New') }}
        </a>
      </li>
    @endsection

    @if ($errors->has('ficha_activa'))
        <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto" role="alert">
            <div class="bg-red-100 border border-red-400 text-red-700 rounded-xl shadow p-4 dark:bg-gray-900 dark:border-red-900 dark:text-red-400">
                <span class="block sm:inline">{{ $errors->first('ficha_activa') }}</span>
            </div>
        </div>
    @endif

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-2">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    {{ __('Crear Requisicion') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Formulario para crear requisicion') }}.
                </p>
            </div>

            <form method="post" action="{{ route('requisiciones.store') }}">
                @csrf
                <div class="py-3 flex items-center text-sm font-bold text-gray-700 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">Datos Generales</div>

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Empresa* / Fecha*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <select name="empresa" id="empresa" class="py-2 px-3  block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                <option selected disabled>Seleccionar</option>
                                @foreach ($empresas as $empresa)
                                <option value="{{ $empresa->NUMERO }}" @selected($empresa->NUMERO == @old('empresa', 1))>{{ $empresa->NOMBRE_COMPLETO }}</option>
                                @endforeach
                            </select>
                            <input name="fecha" id="fecha" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Dias Credito" value="{{ @old('fecha', date('Y-m-d')) }}">
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
                        <x-input-error class="mt-2" :messages="$errors->get('empresa')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Moneda* / Tipo de cambio*') }}
                        </label>
                    </div>



                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <select name="moneda" id="moneda" class="py-2 px-3  block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                <option selected disabled>Seleccionar</option>
                                @foreach ($monedas as $moneda)
                                  <option value="{{ $moneda->CLAVE }}" @selected(rtrim($moneda->CLAVE) == @old('moneda', 'Q'))>{{ $moneda->NOMBRE_CORTO }}</option>
                                @endforeach
                            </select>

                            <input name="tipo_cambio" id="tipo_cambio" type="number" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Tipo de cambio" min="1" value="{{ @old('tipo_cambio', 1) }}">
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('tipo_cambio')" />
                        <x-input-error class="mt-2" :messages="$errors->get('moneda')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="tipo_compra" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Tipo de compra*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select name="tipo_compra" id="tipo_compra" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <option selected disabled>Seleccionar</option>
                            <option value="B" @selected(@old('tipo_compra') == 'B')>Bien</option>
                            <option value="S" @selected(@old('tipo_compra') == 'S')>Servicio</option>
                            <option value="A" @selected(@old('tipo_compra') == 'A')>Activo</option>
                            <option value="M" @selected(@old('tipo_compra') == 'M')>Mixto</option>
                        </select>

                        <x-input-error class="mt-2" :messages="$errors->get('tipo_compra')" />
                    </div>

                    <div id="ficha-container" class="sm:col-span-3 hidden">
                        <label for="ficha" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Colaborador(es)*') }}
                        </label>
                    </div>

                    <div id="ficha-select-container" class="sm:col-span-9 hidden">
                        <x-select-search
                            id="colaborador"
                            name="colaborador"
                            :items="$fichas"
                            value-field="NUMERO"
                            label-field="NOMBRE"
                            placeholder="Busca un colaboradores "
                            :selected="@old('colaborador')"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            multiple
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('colaborador')" />
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
                            :selected="@old('sedes')"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            multiple
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('sedes')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="centro_costo" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
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
                            :selected="@old('sedes')"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('centro_costo')" />
                    </div>

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
                            :selected="@old('renglon_presupuesto')"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('renglon_presupuesto')" />
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
                            :selected="@old('cuenta_contable')"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                        />

                        <x-input-error class="mt-2" :messages="$errors->get('cuenta_contable')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Lugar de Entrega') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <textarea name="lugar_entrega" id="lugar_entrega" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Lugar de entrega de la requisicion.">{{ @old('lugar_entrega') }}</textarea>
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('lugar_entrega')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Comentarios*') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <textarea name="comentarios" id="comentarios" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Comentarios de la requisicion.">{{ @old('comentarios') }}</textarea>
                        </div>

                        <x-input-error class="mt-2" :messages="$errors->get('comentarios')" />
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('requisiciones.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoCompraSelect = document.getElementById('tipo_compra');
            const fichaContainer = document.getElementById('ficha-container');
            const fichaSelectContainer = document.getElementById('ficha-select-container');

            function toggleFichaField() {
                if (tipoCompraSelect.value === 'A') {
                    fichaContainer.classList.remove('hidden');
                    fichaSelectContainer.classList.remove('hidden');
                } else {
                    fichaContainer.classList.add('hidden');
                    fichaSelectContainer.classList.add('hidden');
                    document.getElementById('ficha').value = '';
                }
            }

            tipoCompraSelect.addEventListener('change', toggleFichaField);
            toggleFichaField();
        });

        function handleSubmitButtonLoading(button, loadingText = 'Procesando...')
        {
            const form = button.closest('form');
            if (!form) return;

            const originalHTML = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ${loadingText}
            `;
        }

        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    handleSubmitButtonLoading(submitButton, 'Enviando...');
                }
            });
        });

    </script>
  </x-app-layout>
