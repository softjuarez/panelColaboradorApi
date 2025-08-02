<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('validar_licencias.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Validar Licencias') }}
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
        <div class="border-b border-gray-200 dark:border-neutral-700">
            <nav class="flex gap-x-1 mx-2" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
              <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200 active" id="card-type-tab-item-1" aria-selected="true" data-hs-tab="#card-type-tab-preview" aria-controls="card-type-tab-preview" role="tab">
                Licencia
              </button>
              <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-2" aria-selected="false" data-hs-tab="#card-type-tab-2" aria-controls="card-type-tab-2" role="tab">
                Adjuntos
              </button>
            </nav>
        </div>

        <div>
            <div id="card-type-tab-preview" role="tabpanel" aria-labelledby="card-type-tab-item-1">
                <div class="bg-white rounded-xl rounded-t-none shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="mb-2">
                        <div class="flex items-start justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                                    {{ __('Validar Licencia') }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Formulario para validar licencias') }}.
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                             @if ($licencia->estatus == 'C')
                                <div class="flex items-center gap-2">
                                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-rose-600 text-white hover:bg-rose-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-rechazar" data-hs-overlay="#hs-rechazar">Rechazar</button>

                                    <button type="button"  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-teal-600 text-white hover:bg-teal-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-autorizar" data-hs-overlay="#hs-autorizar">Autorizar</button>
                                </div>
                              @endif
                            </div>
                        </div>


                        <div class="mt-2">
                            <table class="dark:text-gray-200 text-sm">
                                <tr>
                                    <td><b>Id:</b></td>
                                    <td class="px-6">{{ $licencia->id }}</td>
                                    <td><b>Solicitante:</b></td>
                                    <td class="px-6">{{ $licencia->usuario->name }}</td>
                                </tr>
                                <tr>
                                    <td><b>Fecha Inicio:</b></td>
                                    <td class="px-6">{{ date('d/m/Y', strtotime($licencia->fecha_evento)) }}</td>
                                    <td><b>Fecha Fin:</b></td>
                                    <td class="px-6">{{ date('d/m/Y', strtotime($licencia->fecha_fin_evento)) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Estado:</b></td>
                                    <td class="px-6">{{ $licencia->obtenerEstado() }}</td>
                                    <td><b>Tipo:</b></td>
                                    <td class="px-6">{{ $licencia->tipo_licencia->nombre }}</td>
                                </tr>
                                <tr>
                                    <td><b>Descripcion:</b></td>
                                    <td colspan="3" class="px-6">{{ $licencia->descripcion }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end gap-x-2">
                        <a href="{{ route('validar_licencias.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </div>
            <div id="card-type-tab-2" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-2">
                <div class="bg-white rounded-xl rounded-t-none shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="p-4 overflow-y-auto">
                        <div id="archivos-cargados" class="p-4 mt-4 bg-gray-100 rounded-md">
                            @if (!empty($licencia->url))
                            <div class="flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3">
                                <p class="text-gray-700">Nombre: {{ $licencia->url }}</p>
                                <div class="flex items-center space-x-3">
                                    <a class="text-blue-500 hover:text-blue-700" href="{{ route('download.file', ['directorio' => base64_encode($licencia->url)]) }}" download="dev">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                            <polyline points="7 10 12 15 17 10"></polyline>
                                            <line x1="12" x2="12" y1="15" y2="3"></line>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            @else
                                <div class="flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3">
                                    <p class="text-gray-700">No hay adjunto.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (!empty($licencia->razon_rechazo))
    <div id="hs-razon-rechazo" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-razon-rechazo-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-razon-rechazo">
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
                <h3 id="hs-razon-rechazo-label" class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Razon de Rechazo
                </h3>
                <p class="text-gray-500 dark:text-neutral-500">
                    {{ $licencia->razon_rechazo }}
                </p>
                </div>
            </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-razon-rechazo">
                Cancelar
            </button>
            </div>
        </div>
        </div>
    </div>
    @endif

    @if ($licencia->estatus == 'C')
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
                        Autorización de Requisición
                    </h3>
                    <p class="text-gray-700 text-sm">
                        Estás a punto de autorizar permanentemente la requisición con el id <strong>{{ $licencia->id }}, recuerde dejar una respuesta para que pueda autorizar la solicitud</strong>.
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
            <a href="{{ route('validar_licencias.autorizar', $licencia) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
                Autorizar
            </a>
            </div>
        </div>
        </div>
    </div>
    @endif

    @if ($licencia->estatus == 'C')
    <div id="hs-rechazar" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-rechazar-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-rechazar">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            </div>

            <form action="{{ route('validar_licencias.rechazar', $licencia)}}" method="post">
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
                                Estás a punto de rechazar la requisición con el numero <strong>{{ $licencia->id }}</strong>.
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
    @endif
  </x-app-layout>
