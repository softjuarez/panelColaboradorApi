<x-app-layout>
  @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('gestores.index') }}">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Catalogo de Gestores') }}
        </a>
    </li>
    <li class="text-sm">
      <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
          <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          {{ __('Edit') }}
      </a>
    </li>
  @endsection

  <!-- Card Section -->
  <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
    <!-- Card -->
    <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
      <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
          {{ __('Gestores') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
          {{ __('Formulario para editar gestores') }}.
        </p>
      </div>

      <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

  
      <form method="post" action="{{ route('gestores.update', $gestor) }}">
        @csrf

        <div class="flex items-center justify-end mb-2 gap-x-3">
          <label for="hs-sm-switch" class="relative inline-block w-11 h-6 cursor-pointer">
            <input name="estado" type="checkbox" id="hs-sm-switch" class="peer sr-only" @checked($gestor->estatus == 'A')>
            <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
            <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
          </label>
          <label for="hs-sm-switch" class="text-sm text-gray-500 dark:text-neutral-400">De Alta</label>
        </div>
        <!-- Grid -->
        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">  
          <div class="sm:col-span-3">
            <label for="usuario" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
              {{ __('Usuario') }}
            </label>
          </div>
          <!-- End Col -->
  
          <div class="sm:col-span-9">
            <div class="sm:flex">
              <div class="relative w-full">
                <select name="usuario" data-hs-select='{
                  "hasSearch": true,
                  "placeholder": "{{ __('Select multiple options...') }}",
                  "toggleTag": "<button type=\"button\"></button>",
                  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                  "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                  "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                  }' class="hidden" disabled>
                  <option value="">{{ __('Choose') }}</option>
                  @foreach ($users as $item)
                  <option value="{{ $item->id }}" @selected($item->id == @old('usuario', $gestor->user_id))>{{ $item->name }}</option>
                  @endforeach
                </select>
                <div class="absolute top-1/2 end-3 -translate-y-1/2">
                  <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                </div>
              </div>
            </div>

            <x-input-error class="mt-2" :messages="$errors->get('usuario')" />
          </div>
          <!-- End Col -->
        </div>
      
        <!-- End Grid -->
  
        <div class="mt-5 flex justify-end gap-x-2">
          <a href="{{ route('gestores.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            {{ __('Cancel') }}
          </a>
          <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            {{ __('Save') }}
          </button>
        </div>
      </form>
    </div>
    <!-- End Card -->
  </div>
  <!-- End Card Section -->
</x-app-layout>