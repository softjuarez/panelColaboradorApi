<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Configuraciones') }}
        </a>
    </li>
    @endsection

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('Actualizar Configuraciones') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Formulario para actualizar las configuraciones') }}.
                </p>
            </div>

            <form method="post" action="{{ route('configuraciones.update') }}">
                @csrf
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                    <div class="sm:col-span-3">
                        <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Usuario Destino de Requisicion.') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input name="destino_requisicion" id="destino_requisicion" type="text" class="py-2 px-3 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="" value="{{ @old('destino_requisicion', $configuracion->destino_requisicion) }}">

                        <x-input-error class="mt-2" :messages="$errors->get('destino_requisicion')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="notificar_solicitudes" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Notificar Solicitudes') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input name="notificar_solicitudes" id="notificar_solicitudes" type="text" class="py-2 px-3 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="demo@demo.com;demo2@demo.com" value="{{ @old('notificar_solicitudes', $configuracion->notificar_solicitudes) }}">
                        <x-input-error class="mt-2" :messages="$errors->get('notificar_solicitudes')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="notificar_solicitudes" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Dias Resguardo Fin de Año') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input name="dias_resguardo_fin_anio" id="dias_resguardo_fin_anio" type="number" step="any" class="py-2 px-3 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="{{ @old('dias_resguardo_fin_anio', $configuracion->dias_resguardo_fin_anio) }}">

                        <x-input-error class="mt-2" :messages="$errors->get('dias_resguardo_fin_anio')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="notificar_solicitudes" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Dias Resguardo Semana Santa') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input name="dias_resguardo_semana_santa" id="dias_resguardo_semana_santa" type="number" step="any" class="py-2 px-3 block w-full border-gray-200  text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" value="{{ @old('dias_resguardo_semana_santa', $configuracion->dias_resguardo_semana_santa) }}">

                        <x-input-error class="mt-2" :messages="$errors->get('dias_resguardo_semana_santa')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="dia_pago" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Día de Pago') }}
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <select name="dia_pago" id="dia_pago" class="py-2 px-3 block w-full border-gray-200 text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                            <option value="lunes" @selected('lunes' == $configuracion->dia_pago)>Lunes</option>
                            <option value="martes" @selected('martes' == $configuracion->dia_pago)>Martes</option>
                            <option value="miercoles" @selected('miercoles' == $configuracion->dia_pago)>Miércoles</option>
                            <option value="jueves" @selected('jueves' == $configuracion->dia_pago)>Jueves</option>
                            <option value="viernes" @selected('viernes' == $configuracion->dia_pago)>Viernes</option>
                            <option value="sabado" @selected('sabado' == $configuracion->dia_pago)>Sábado</option>
                            <option value="domingo" @selected('domingo' == $configuracion->dia_pago)>Domingo</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('dia_pago')" />
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                      {{ __('Actualizar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
