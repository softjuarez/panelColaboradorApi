<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('roles.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Roles') }}
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
            <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('Edit Role') }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Formulario para editar Roles') }}.
            </p>
            </div>

            <form method="post" action="{{ route('roles.update', $role) }}">
                @csrf
                <div class="flex items-center justify-end gap-x-3 mb-4">
                    <label for="tipo" class="relative inline-block w-9 h-5 cursor-pointer">
                        <input name="tipo" type="checkbox" id="tipo" class="peer sr-only" @checked($role->type == 'I')>
                        <span class="absolute inset-0 bg-gray-200 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-blue-600 dark:bg-neutral-700 dark:peer-checked:bg-blue-500 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-4 bg-white rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:translate-x-full dark:bg-neutral-400 dark:peer-checked:bg-white"></span>
                    </label>
                    <label for="tipo" class="text-sm text-gray-500 dark:text-neutral-400">Rol Interno?</label>
                </div>

                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Role name') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input name="name" id="name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Edit Users" value="{{ @old('name', $role->name) }}">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div class="sm:col-span-3">
                        <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Permissions') }}
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <x-select-search
                            id="permissions"
                            name="permissions"
                            :items="$permissions"
                            value-field="id"
                            label-field="name"
                            placeholder="Busca permisos"
                            :selected="@old('permissions', $role->permissions->pluck('id')->toArray())"
                            class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                            multiple
                        />
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('roles.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
  </x-app-layout>
