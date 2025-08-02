<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('permissions.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Permissions') }}
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

    <!-- Card Section -->
    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
      <!-- Card -->
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
          <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Edit Permission') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Form to edit permissions.') }}
          </p>
        </div>
    
        <form method="post" action="{{ route('permissions.update', $permission) }}">
          @csrf
          <!-- Grid -->
          <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">  
            <div class="sm:col-span-3">
              <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Name') }} / {{ __('Code') }}
              </label>
            </div>
            <!-- End Col -->
    
            <div class="sm:col-span-9">
              <div class="sm:flex">
                <input name="name" id="af-account-full-name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200  -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Maria" value="{{ $permission->name }}">
                <input name="lastname" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200  -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Boone" value="{{ $permission->code }}" disabled>
              </div>
  
              <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <!-- End Col -->
    
            <div class="sm:col-span-3">
              <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Description') }}
              </label>
            </div>
            <!-- End Col -->
    
            <div class="sm:col-span-9">
                <textarea id="textarea-email-label" name="description" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" rows="3" placeholder="{{ __('Description of this...') }}">{{ old('description', $permission->description) }}</textarea>

            </div>
            <!-- End Col -->
          </div>
          <!-- End Grid -->
    
          <div class="mt-5 flex justify-end gap-x-2">
            <a href="{{ route('permissions.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800  hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
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
  </x-app-layout>