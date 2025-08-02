<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('autoriza_solicitud_permisos.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Autorizar Solicitud de Permisos') }}
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
                Solicitud
              </button>
              <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-2" aria-selected="false" data-hs-tab="#card-type-tab-2" aria-controls="card-type-tab-2" role="tab">
                Adjuntos
              </button>
              <button type="button" class="hs-tab-active:bg-white hs-tab-active:border-b-transparent hs-tab-active:text-blue-600 dark:hs-tab-active:bg-neutral-800 dark:hs-tab-active:border-b-gray-800 dark:hs-tab-active:text-white -mb-px py-3 px-4 inline-flex items-center gap-x-2 bg-gray-50 text-sm font-medium text-center border border-gray-200 text-gray-500 rounded-t-lg hover:text-gray-700 focus:outline-hidden focus:text-gray-700 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:border-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200 dark:focus:text-neutral-200" id="card-type-tab-item-3" aria-selected="false" data-hs-tab="#card-type-tab-3" aria-controls="card-type-tab-3" role="tab">
                Documentos
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
                                    {{ __('Editar Solicitud de Permiso') }}
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Formulario para editar solicitud de permisos') }}.
                                </p>
                            </div>

                            <div class="flex items-center gap-2">
                              @if ($solicitud->estatus == 'B')
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
                                    <td class="px-6">{{ $solicitud->id }}</td>
                                    <td><b>Solicitante:</b></td>
                                    <td class="px-6">{{ $solicitud->ficha->NOMBRE }}</td>
                                </tr>
                                <tr>
                                    <td><b>Atendio:</b></td>
                                    <td class="px-6">{{ $solicitud->atendio->name ?? 'Sin atender' }}</td>
                                    <td><b>Fecha Solicitado:</b></td>
                                    <td class="px-6">{{ date('d/m/Y', strtotime($solicitud->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Tipo:</b></td>
                                    <td class="px-6">{{ $solicitud->tipo_solicitud->nombre }}</td>
                                    <td><b>Descripcion:</b></td>
                                    <td class="px-6">{{ $solicitud->descripcion }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <form method="post" action="{{ route('autoriza_solicitud_permisos.update', $solicitud) }}">
                        @csrf
                        <div class="py-3 flex items-center text-sm font-bold text-gray-700 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">Datos Generales</div>

                        <div class="grid sm:grid-cols-12 gap-2 sm:gap-3 my-2">
                            <div class="sm:col-span-3">
                                <label for="af-account-serie-marca" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                                    {{ __('Respuesta*') }}
                                </label>
                            </div>

                            <div class="sm:col-span-9">
                                <div class="sm:flex">
                                    <textarea name="respuesta" id="respuesta" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0  sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Respuesta de la solicitud.">{{ @old('respuesta', $solicitud->respuesta) }}</textarea>
                                </div>

                                <x-input-error class="mt-2" :messages="$errors->get('respuesta')" />
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end gap-x-2">
                            <a href="{{ route('autoriza_solicitud_permisos.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('Cancel') }}
                            </a>
                            @if ($solicitud->estatus == 'B')
                            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            {{ __('Save') }}
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div id="card-type-tab-2" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-2">
                <div class="bg-white rounded-xl rounded-t-none shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="p-4 mt-4 bg-gray-100 rounded-md">
                        @foreach ($solicitud->adjuntos as $adjunto)
                        <div class="flex items-center justify-between py-2 px-4 bg-white shadow rounded-lg mb-3">
                            <p class="text-gray-700">Nombre: {{ $adjunto->nombre }}</p>
                            <div class="flex items-center space-x-3">
                                <a class="text-blue-500 hover:text-blue-700" href="{{ route('descargar.adjunto', [$solicitud->ficha_crea, basename($adjunto->url)]) }}" download="dev">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" x2="12" y1="15" y2="3"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="card-type-tab-3" class="hidden" role="tabpanel" aria-labelledby="card-type-tab-item-3">
                <div class="bg-white rounded-xl rounded-t-none shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="p-4 overflow-y-auto">
                        <div class="w-full grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="py-2 sm:py-2 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Nombre del archivo">
                            </div>
                            <div class="sm:col-span-2">
                                <label for="tipo_adjunto" class="block text-sm font-medium text-gray-700">Tipo Adjunto</label>
                                <select type="text" id="tipo_adjunto" name="tipo_adjunto" class="py-2 sm:py-2 px-4 block w-full border-gray-200 rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Nombre del archivo">
                                    <option value="">Seleccionar</option>
                                    @foreach ($tipo_adjuntos as $tipo)
                                        <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2"  >
                                <label for="adjunto" class="block text-sm font-medium text-gray-700">Adjunto</label>
                                <input type="file" id="adjunto" name="adjunto" class="block w-full text-sm text-gray-500     border-gray-200
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
                            </div>
                        </div>


                        <div id="errorArchivoContainer" class="mt-4"></div>

                        <div id="archivos-cargados" class="p-4 mt-4 bg-gray-100 rounded-md"></div>

                        <div class="flex items-center justify-between mt-4">
                            <button id="btnAnterior" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                            </button>
                            <span id="numeroPagina" class="min-h-9.5 min-w-9.5 flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-600 dark:text-white dark:focus:bg-neutral-500">1</span>
                            <button id="btnSiguiente" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if ($solicitud->estatus == 'B')
                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
                        <button onclick="subirAdjunto()" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                          Cargar Adjunto
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @if ($solicitud->estatus == 'B')
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
                        Autorización de Solicitud de Permiso
                    </h3>
                    <p class="text-gray-700 text-sm">
                        Estás a punto de autorizar permanentemente la Solicitud de Permiso con el id <strong>{{ $solicitud->id }}, recuerde dejar una respuesta para que pueda autorizar la solicitud</strong>.
                    </p>
                    <p class="text-gray-700 text-sm mt-2">
                        🔒 <strong>Esta acción es irreversible.</strong> Una vez confirmada, no podrás deshacerla. Por favor, procede con precaución.
                    </p>
                    <div class="bg-white p-3 rounded-md mt-3">
                        <p class="text-gray-700 text-sm">
                            ✅ Antes de continuar, verifica:
                        </p>
                        <ul class="list-disc list-inside text-gray-700 text-sm pl-4">
                            <li>Que los datos de la solicitud de permiso sean correctos.</li>
                            <li>Que los recursos solicitados estén debidamente justificados.</li>
                            <li>Que la solicitud de permiso cumpla con las políticas y procedimientos establecidos.</li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>

            <div class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t dark:bg-neutral-950 dark:border-neutral-800">
            <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" data-hs-overlay="#hs-autorizar">
                Cancelar
            </button>
            <a href="{{ route('autoriza_solicitud_permisos.autorizar', $solicitud) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-teal-500 text-white hover:bg-teal-600 disabled:opacity-50 disabled:pointer-events-none">
                Autorizar
            </a>
            </div>
        </div>
        </div>
    </div>
    @endif

    @if ($solicitud->estatus == 'B')
    <div id="hs-rechazar" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto" role="dialog" aria-labelledby="hs-rechazar-label">
        <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">
            <div class="absolute top-2 end-2">
            <button type="button" class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600" aria-label="Close" data-hs-overlay="#hs-rechazar">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
            </div>

            <form action="{{ route('autoriza_solicitud_permisos.rechazar', $solicitud)}}" method="post">
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
                                Rechazo de Solicitud de Permiso
                            </h3>
                            <p class="text-gray-700 text-sm">
                                Estás a punto de rechazar la solicitud de permiso con el numero <strong>{{ $solicitud->id }}</strong>.
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
                                    <li>Confirmar que la solicitud de permiso no cumple con los requisitos necesarios.</li>
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


    <script>
        let paginaActual = 1;
        const elementosPorPagina = 5;

        cargarPagina(paginaActual)

        function cargarPagina(pagina) {
            var url = '{{ route("adjuntos.permiso.listado", $solicitud) }}';
            url += `?page=${pagina}&per_page=${elementosPorPagina}`;

            fetch(url)
                .then(response => response.json())
                .then(function(data) {
                    generarListadoArchivos(data.archivos);
                    actualizarBotonesPaginacion(data.pagination);
                });
        }

        function subirAdjunto()
        {
            const errorContainer = document.getElementById('errorArchivoContainer');
            errorContainer.innerHTML = '';

            const nombre = document.getElementById('nombre').value;
            const adjunto = document.getElementById('adjunto').files[0];
            const tipo = document.getElementById('tipo_adjunto').value;

            var datos = new FormData();
            datos.append('nombre', nombre);
            datos.append("adjunto", adjunto);
            datos.append("tipo_adjunto", tipo);


            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = '{{ route("adjuntos.permiso.store", $solicitud) }}';

            fetch(url, {
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
                }
            });
        }

        function generarListadoArchivos(data)
        {
            document.getElementById("nombre").value = '';
            document.getElementById("adjunto").value = '';
            document.getElementById('tipo_adjunto').value = '';

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

            @if ($solicitud->estatus == 'B')
            const botonEliminar = document.createElement('button');
            botonEliminar.className = 'text-red-500 hover:text-red-700';
            botonEliminar.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    <line x1="10" x2="10" y1="11" y2="17"/>
                    <line x1="14" x2="14" y1="11" y2="17"/>
                </svg>
            `;

            botonEliminar.addEventListener('click', () => {
                eliminarArchivo(archivo.id);
            });



            botonesContainer.appendChild(botonEliminar);
            @endif

            botonesContainer.appendChild(botonDescargar);

            archivoContainer.appendChild(p);
            archivoContainer.appendChild(botonesContainer);
            archivosCargados.appendChild(archivoContainer);
            });
        }

        function eliminarArchivo(file_id)
        {
            fetch("{{ route('adjuntos.permiso.delete', ':file') }}".replace(':file', file_id))
            .then(response => response.json())
            .then(function(responseData) {
                cargarPagina();
            });
        }

        function actualizarBotonesPaginacion(pagination)
        {
            const btnAnterior = document.getElementById('btnAnterior');
            const btnSiguiente = document.getElementById('btnSiguiente');
            const numeroPagina = document.getElementById('numeroPagina'); // Elemento para mostrar el número de página

            // Ocultar o mostrar los botones según el total de registros
            if (pagination.total <= 5) {
                btnAnterior.style.display = 'none';
                btnSiguiente.style.display = 'none';
                numeroPagina.style.display = 'none'; // También ocultar el número de página
            } else {
                btnAnterior.style.display = 'inline-block'; // o 'block', dependiendo de tu diseño
                btnSiguiente.style.display = 'inline-block'; // o 'block', dependiendo de tu diseño
                numeroPagina.style.display = 'inline-block'; // Mostrar el número de página

                // Actualizar el número de página
                numeroPagina.textContent = pagination.current_page;

                // Habilitar o deshabilitar los botones
                btnAnterior.disabled = pagination.current_page <= 1;
                btnSiguiente.disabled = pagination.current_page >= pagination.last_page;
            }
        }

        document.getElementById('btnAnterior').addEventListener('click', function() {
            if (paginaActual > 1) {
                paginaActual--;
                cargarPagina(paginaActual);
            }
        });

        document.getElementById('btnSiguiente').addEventListener('click', function() {
            paginaActual++;
            cargarPagina(paginaActual);
        });
    </script>

  </x-app-layout>
