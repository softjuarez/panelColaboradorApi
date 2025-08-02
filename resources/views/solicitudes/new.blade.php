<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('solicitudes.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Solicitudes') }}
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
                    {{ __('Crear Solicitud') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Formulario para crear solicitudes') }}.
                </p>
            </div>
        
            <form method="post" action="{{ route('solicitudes.store') }}">
                @csrf
                <div class="py-3 flex items-center text-sm font-bold text-gray-700 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">Datos Generales</div>
        
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Tipo Solicitud* / Fecha Evento') }}
                        </label>
                    </div>
            
                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <select name="tipo" id="tipo" class="py-2 px-3  block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600">
                                <option selected disabled>Seleccionar</option>
                                @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}" @selected($tipo->id == @old('tipo'))>{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                            <input name="fecha" id="fecha" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Dias Credito" value="{{ @old('fecha') }}">
                        </div>
            
                        <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
                        <x-input-error class="mt-2" :messages="$errors->get('tipo')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                            {{ __('Descripcion*') }}
                        </label>
                    </div>
            
                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <textarea name="descripcion" id="descripcion" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Descripcion de la solicitud.">{{ @old('descripcion') }}</textarea>
                        </div>
            
                        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('solicitudes.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>