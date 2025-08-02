<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('externos.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Externos') }}
          </a>
      </li>
      <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Edit') }}
        </a>
    </li>
    @endsection

    <style>

    </style>

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

    <!-- Card Section -->
    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
      <!-- Card -->
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
          <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Editar Usuario Externo') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Formulario para editar usuario externo.') }}
          </p>
        </div>

        <form method="post" action="{{ route('externos.update', $user) }}" enctype="multipart/form-data">
          @csrf
          <!-- Grid -->
          <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
            <div class="sm:col-span-3">
              <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Full name') }}
              </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
              <div class="sm:flex">
                <input name="name" id="af-account-full-name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Maria" value="{{ $user->name }}">
                <input name="lastname" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Boone" value="{{ $user->lastname }}">
              </div>

              <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
              <label for="af-account-email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Email') }}
              </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
              <input name="email" id="af-account-email" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200 text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="maria@site.com" value="{{ $user->email }}">
              <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <!-- End Col -->

            <div class="sm:col-span-3">
              <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Role') }}
              </label>
            </div>

            <div class="sm:col-span-9">
              <!-- Select -->
              <div class="relative">
                <select name="roles[]" multiple data-hs-select='{
                    "placeholder": "Select multiple options...",
                    "toggleTag": "<button type=\"button\"></button>",
                    "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-2 px-4 pe-9 flex text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600",
                    "dropdownClasses": "mt-2 z-50 w-full max-h-[300px] p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto dark:bg-slate-900 dark:border-gray-700",
                    "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-slate-900 dark:hover:bg-slate-800 dark:text-gray-200 dark:focus:bg-slate-800",
                    "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"flex-shrink-0 w-3.5 h-3.5 text-blue-600 dark:text-blue-500\" xmlns=\"http:.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                  }' class="hidden">
                  <option value="">Choose</option>
                  @foreach ($roles as $role)
                  <option value="{{ $role->id }}" @selected(in_array($role->id, $user->roles->pluck('id')->toArray()))>{{ $role->name }}</option>
                  @endforeach
                </select>

                <div class="absolute top-1/2 end-3 -translate-y-1/2">
                  <svg class="flex-shrink-0 w-3.5 h-3.5 text-gray-500 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                </div>
              </div>
              <!-- End Select -->
            </div>

            <div class="sm:col-span-3">
              <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Proveedor') }}
              </label>
            </div>

            <div class="sm:col-span-9">
                <x-select-search
                    id="proveedores"
                    name="proveedores"
                    :items="$proveedores"
                    value-field="NUMERO"
                    label-field="NOMBRE_COMPLETO"
                    placeholder="Busca un proveedor"
                    :selected="@old('proveedores', $user->proveedores->pluck('NUMERO')->toArray())"
                    class="w-full border border-gray-200 rounded-lg py-2 px-3 text-sm"
                />
            </div>

            <div class="sm:col-span-3">
              <label for="af-account-password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Foto') }}
              </label>
            </div>

            <div class="sm:col-span-9">
              <div id="file-upload">
                <!-- Contenedor para la vista previa -->
                <div id="preview-template" class="hidden">
                  <div class="size-20">
                    <img class="w-full object-contain rounded-full" id="preview-image" src="{{ asset($user->foto) }}" alt="Foto de perfil">
                  </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 sm:gap-5">
                  <div id="preview-container">
                    <!-- Mostrar la imagen guardada si existe -->
                    @if($user->foto)
                      <div class="size-20">
                        <img class="w-full object-contain rounded-full" src="{{ asset($user->foto) }}" alt="Foto de perfil">
                      </div>
                    @else
                      <!-- Mostrar el ícono de carga si no hay imagen -->
                      <span id="upload-trigger" class="flex shrink-0 justify-center items-center size-20 border-2 border-dotted border-gray-300 text-gray-400 cursor-pointer rounded-full hover:bg-gray-50 dark:border-neutral-700 dark:text-neutral-600 dark:hover:bg-neutral-700/50">
                        <svg class="shrink-0 size-7" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                          <circle cx="12" cy="12" r="10"></circle>
                          <circle cx="12" cy="10" r="3"></circle>
                          <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"></path>
                        </svg>
                      </span>
                    @endif
                  </div>
                </div>
                <!-- Input de archivo oculto -->
                <label class="block mt-2">
                  <span class="sr-only">Choose profile photo</span>
                  <input name="foto" type="file" class="block w-full text-sm text-gray-500
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
                </label>
                <!-- Campo oculto para almacenar la URL de la imagen guardada -->
              </div>

              <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            </div>
          </div>
          <!-- End Grid -->

          <div class="mt-5 flex justify-end gap-x-2">
            <a href="{{ route('externos.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
              {{ __('Cancel')}}
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

    <!-- Card Section -->
    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
      <!-- Card -->
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
          <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Change Password') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('You can update password.') }}
          </p>
        </div>

        <form method="post" action="{{ route('externos.updatePassword', $user) }}">
          @csrf
          <!-- Grid -->
          <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
            <div class="sm:col-span-3">
              <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                {{ __('Password') }}
              </label>
            </div>
            <!-- End Col -->

            <div class="sm:col-span-9">
              <!-- Strong Password -->
              <div class="flex">
                <div class="relative flex-1">
                  <input name="password" type="password" id="hs-strong-password-with-indicator-and-hint-in-popover" class="py-2 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Enter password">

                  <div id="hs-strong-password-popover" class="hidden absolute z-10 w-full bg-white shadow-md rounded-lg p-4 dark:bg-gray-800 dark:border dark:border-gray-700 dark:divide-gray-700">
                    <div id="hs-strong-password-in-popover" data-hs-strong-password='{
                        "target": "#hs-strong-password-with-indicator-and-hint-in-popover",
                        "hints": "#hs-strong-password-popover",
                        "stripClasses": "hs-strong-password:opacity-100 hs-strong-password-accepted:bg-teal-500 h-2 flex-auto rounded-full bg-blue-500 opacity-50 mx-1",
                        "mode": "popover",
                        "minLength": "8"
                      }' class="flex mt-2 -mx-1">
                    </div>

                    <h4 class="mt-3 text-sm font-semibold text-gray-800 dark:text-white">
                      {{ __('Your password must contain') }}:
                    </h4>

                    <ul class="space-y-1 text-sm text-gray-500">
                      <li data-hs-strong-password-hints-rule-text="min-length" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                        <span class="hidden" data-check>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span data-uncheck>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </span>
                        {{ __('Minimum number of characters is 8') }}.
                      </li>
                      <li data-hs-strong-password-hints-rule-text="lowercase" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                        <span class="hidden" data-check>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span data-uncheck>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </span>
                        {{ __('Should contain lowercase') }}.
                      </li>
                      <li data-hs-strong-password-hints-rule-text="uppercase" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                        <span class="hidden" data-check>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span data-uncheck>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </span>
                        {{ __('Should contain uppercase') }}.
                      </li>
                      <li data-hs-strong-password-hints-rule-text="numbers" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                        <span class="hidden" data-check>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span data-uncheck>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </span>
                       {{ __('Should contain numbers') }}.
                      </li>
                      <li data-hs-strong-password-hints-rule-text="special-characters" class="hs-strong-password-active:text-teal-500 flex items-center gap-x-2">
                        <span class="hidden" data-check>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span data-uncheck>
                          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                        </span>
                        {{ __('Should contain special characters') }}.
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <!-- End Strong Password -->

              <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>
            <!-- End Col -->
          </div>
          <!-- End Grid -->



          <div class="mt-5 flex justify-end gap-x-2">
            <a href="{{ route('externos.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
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

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file-input');
        const uploadTrigger = document.getElementById('upload-trigger');
        const uploadButton = document.getElementById('upload-button');
        const clearButton = document.getElementById('clear-button');
        const previewContainer = document.getElementById('preview-container');
        const previewTemplate = document.getElementById('preview-template');
        const previewImage = document.getElementById('preview-image');

        // Abrir el selector de archivos al hacer clic en el botón o en el área de carga
        uploadTrigger.addEventListener('click', () => fileInput.click());
        uploadButton.addEventListener('click', () => fileInput.click());

        // Manejar la selección de archivos
        fileInput.addEventListener('change', function (event) {
          const file = event.target.files[0];
          if (file && file.type.startsWith('image/')) {
            const img = new Image();
            const objectURL = URL.createObjectURL(file);

            img.onload = function () {
              // Redimensionar la imagen si es demasiado grande
              const MAX_WIDTH = 150; // Ancho máximo de la vista previa
              const MAX_HEIGHT = 150; // Alto máximo de la vista previa
              let width = img.width;
              let height = img.height;

              if (width > height) {
                if (width > MAX_WIDTH) {
                  height *= MAX_WIDTH / width;
                  width = MAX_WIDTH;
                }
              } else {
                if (height > MAX_HEIGHT) {
                  width *= MAX_HEIGHT / height;
                  height = MAX_HEIGHT;
                }
              }

              // Crear un canvas para redimensionar la imagen
              const canvas = document.createElement('canvas');
              canvas.width = width;
              canvas.height = height;
              const ctx = canvas.getContext('2d');
              ctx.drawImage(img, 0, 0, width, height);

              // Convertir el canvas a una URL de datos
              const resizedImageUrl = canvas.toDataURL('image/jpeg', 0.8); // Calidad del 80%

              // Mostrar la vista previa de la imagen redimensionada
              previewImage.src = resizedImageUrl;
              previewContainer.innerHTML = previewTemplate.innerHTML;
              previewContainer.classList.remove('hidden');

              // Liberar la URL del objeto
              URL.revokeObjectURL(objectURL);
            };

            img.src = objectURL;
          } else {
            alert('Por favor, selecciona un archivo de imagen válido.');
          }
        });

        // Limpiar la imagen seleccionada
        clearButton.addEventListener('click', function () {
          fileInput.value = ''; // Limpiar el input de archivo
          previewContainer.innerHTML = ''; // Eliminar la vista previa
          previewContainer.appendChild(uploadTrigger); // Restaurar el ícono de carga
        });
      });
    </script>

  </x-app-layout>
