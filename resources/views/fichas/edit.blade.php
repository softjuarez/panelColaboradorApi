<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('fichas.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Fichas') }}
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
      @foreach ($errors->all() as $error)
      <x-toast :show="$error != '' ? true : false" :type="'error'" :message="$error"/>
      @endforeach
    @endif

    <!-- Card Section -->
    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
      <!-- Card -->
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <div class="mb-8">
          <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
            {{ __('Editar Fichas') }}
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Formulario para asignacion de usuario a fichas.') }}
          </p>
        </div>
    
        <div class="grid sm:grid-cols-12 gap-2 sm:gap-2">  
          <div class="sm:col-span-3">
            <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
              <b>{{ __('Nombre') }}:</b> {{ $ficha->NOMBRE }}
            </label>
          </div>
          <div class="sm:col-span-3">
            <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
              <b>{{ __('Telefono') }}:</b> {{ $ficha->TELEFONO }}
            </label>
          </div>
          <div class="sm:col-span-3">
            <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
              <b>{{ __('NIT') }}:</b> {{ $ficha->NIT }}
            </label>
          </div>
          <div class="sm:col-span-3">
            <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
              <b>{{ __('Puesto') }}:</b> {{ $ficha->PUESTO_INGRESA }}
            </label>
          </div>
          <div class="sm:col-span-3">
            <label for="af-account-full-name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
              <b>{{ __('Estado') }}:</b> {{ $ficha->ESTATUS == 'A' ? 'Activo' : 'Inactivo' }}
            </label>
          </div>
        </div>
      </div>
      <!-- End Card -->
    </div>
    <!-- End Card Section -->

    
    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
      <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
        <form id="multi-select-form" method="post" action="{{ route('fichas.update', $ficha) }}">
            @csrf
            <!-- Buscador -->
            <div class="px-2 pb-8">
              <div class="flex rounded-lg">
                <button type="button" class="w-[2.875rem] h-[2.875rem] shrink-0 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-s-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                  <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                  </svg>
                </button>
                <input type="text" id="search" name="hs-leading-button-add-on-with-icon" class="py-3 px-4 block w-full border-gray-200 rounded-e-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
              </div>
            </div>

            <!-- Listado de opciones -->
            <div id="options-container" class="px-2 space-y-4 max-h-64 overflow-y-auto 
                [&::-webkit-scrollbar]:w-2
              [&::-webkit-scrollbar-track]:bg-gray-100
              [&::-webkit-scrollbar-thumb]:bg-gray-300
              dark:[&::-webkit-scrollbar-track]:bg-neutral-700
              dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            </div>
            <x-input-error class="mt-2 px-2" :messages="$errors->get('usuarios')" />
            <x-input-error class="mt-2 px-2" :messages="$errors->get('referencia')" />


            <!-- Botón de enviar -->
            <div class="mt-5 flex justify-between gap-x-2">
              <div>
                @if($ficha->usuarios->count() == 0)
                    <button id="myButton" @click="handleClick" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-static-backdrop-modal" data-hs-overlay="#hs-static-backdrop-modal">
                        {{ __('Asignar Con Nuevo Usuario') }}
                    </button>
                @endif
              </div>
              <div>
                <a href="{{ route('fichas.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  {{ __('Cancel')}}
                </a>
                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  {{ __('Asginar') }}
                </button>
              </div>
            </div>
        </form>
      </div>
    </div>

    <div id="hs-static-backdrop-modal" class="hs-overlay [--overlay-backdrop:static] hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none" role="dialog" tabindex="-1" aria-labelledby="hs-static-backdrop-modal-label" data-hs-overlay-keyboard="false">
      <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
          <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
            <h3 id="hs-static-backdrop-modal-label" class="font-bold text-gray-800 dark:text-white">
              Asignar Usuario Nuevo a Esta Ficha
            </h3>
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-static-backdrop-modal">
              <span class="sr-only">Close</span>
              <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
              </svg>
            </button>
          </div>
          <div class="p-4 overflow-y-auto">
            <p class="mt-1 text-gray-800 dark:text-neutral-400">
              Una vez que el usuario sea creado, <b>no será posible recuperar la contraseña generada</b>. Por favor, asegúrese de guardar la contraseña en un lugar seguro antes de continuar. Si la pierde, no podrá acceder a la cuenta sin restablecer la contraseña manualmente.
            </p>
          </div>
          
          <form action="{{ route('fichas.asignar', $ficha)}}" method="post">
            @csrf
            <div class="p-4">
              <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2">
                  <label for="input-label" class="block text-sm font-medium mb-2 dark:text-white">Correo</label>
                  <input type="email" id="input-label" name="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:placeholder-neutral-500 dark:text-neutral-400" value="{{ $ficha->CORREO }}" autofocus="">
                  <x-input-error class="mt-2 px-2" :messages="$errors->get('email')" />
                </div> 
                <div class="sm:col-span-2">
                  <label for="input-label" class="block text-sm font-medium mb-2 dark:text-white">Contraseña</label>
                  <div class="relative">
                    <input id="hs-toggle-password" name="password" type="password" class="py-3 ps-4 pe-10 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Contraseña" value="">
                    <button type="button" data-hs-toggle-password='{
                        "target": "#hs-toggle-password"
                      }' class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                      <svg class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                        <path class="hs-password-active:hidden" d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                        <path class="hs-password-active:hidden" d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                        <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"></line>
                        <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                        <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"></circle>
                      </svg>
                    </button>
                  </div>  
                  <x-input-error class="mt-2 px-2" :messages="$errors->get('password')" />
                </div> 
              </div>
            </div>
            
            <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
              <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700" data-hs-overlay="#hs-static-backdrop-modal">
                Cerrar
              </button>
              <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                Guardar y Asignar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script>
        // Datos de ejemplo con id y name
        const options = @json($usuarios->toArray());
        const oldSelectedItemsAsNumbers = @json(old('usuarios', $ficha->usuarios->pluck('id')->toArray()));
        const oldSelectedItems = oldSelectedItemsAsNumbers.map(item => Number(item));
        const oldOptionSelected = @json(old('referencia', $ficha->referencia()));


        // Estado de las opciones seleccionadas
        const selectedItems = new Set();
        let featuredItem = null;

        // Función para renderizar las opciones
        function renderOptions(filter = "") {
            const container = document.getElementById("options-container");
            container.innerHTML = ""; // Limpiar el contenedor

            options
                .filter((option) =>
                    option.name.toLowerCase().includes(filter.toLowerCase())
                )
                .forEach((option) => {
                    const isSelected = selectedItems.has(option.id);
                    const isFeatured = featuredItem === option.id;

                    const optionElement = document.createElement("div");
                    optionElement.className =
                        "flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50";
                    
                    optionElement.innerHTML = `
                        <label class="flex items-center space-x-3">
                            <input
                                id="option-${option.id}"
                                type="checkbox"
                                name="usuarios[]"
                                ${isSelected || oldSelectedItems.includes(option.id) ? "checked" : ""}
                                value="${option.id}"
                                class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                            />
                            <span class="text-gray-700">${option.name}</span>
                        </label>
                        <input
                            id="radio-${option.id}"
                            type="radio"
                            name="referencia"
                            ${isFeatured || oldOptionSelected == `${option.id}` ? "checked" : ""}
                            value="${option.id}"
                            class="form-radio shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                        />
                    `;

                    // Manejar cambios en el checkbox
                    const checkbox = optionElement.querySelector('input[type="checkbox"]');

                      checkbox.addEventListener("change", () => {
                          if (checkbox.checked) {
                              selectedItems.add(option.id); // Agregar el ID al conjunto de seleccionados
                          } else {
                              selectedItems.delete(option.id); // Eliminar el ID del conjunto de seleccionados
                              if (featuredItem === option.id) {
                                  featuredItem = null; // Limpiar el featuredItem si estaba seleccionado
                              }
                          }
                          checkbox.checked = selectedItems.has(option.id);
                      });

                    // Manejar cambios en el radio
                    const radio = optionElement.querySelector('input[type="radio"]');
                    radio.addEventListener("change", () => {
                        if (radio.checked) {
                            featuredItem = option.id;
                        }
                    });

                    container.appendChild(optionElement);
                });
        }

        // Inicializar el listado
        renderOptions();

        // Manejar la búsqueda
        const searchInput = document.getElementById("search");
        searchInput.addEventListener("input", (e) => {
            renderOptions(e.target.value);
        });

        // Manejar el envío del formulario
          document.getElementById("multi-select-form").addEventListener("submit", (e) => {
          e.preventDefault();

          console.log("Elementos seleccionados:", Array.from(selectedItems));
          console.log("Elemento destacado:", featuredItem);
      });


      document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById("multi-select-form");
        
        if(form) {
          form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const searchField = document.getElementById("search");
            if(searchField) {
              searchField.value = '';
              renderOptions();
            }
            
            // Crear un nuevo evento de submit para evitar el loop infinito
            const submitEvent = new Event('submit', { cancelable: true });
            form.dispatchEvent(submitEvent);
            
            // Si el evento no fue cancelado por otro listener, enviar el formulario
            if(!submitEvent.defaultPrevented) {
              form.submit();
            }
          });
        }
      });
    </script>
  </x-app-layout>