<x-app-layout>
    @section('breadcrumbs')
      <li class="text-sm">
          <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="{{ route('solicitud_vacaciones.index') }}">
              <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
              {{ __('Solicitud de vacaciones') }}
          </a>
      </li>
      <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('New') }}
        </a>
      </li>
    @endsection

    <div id="error-container" class="hidden max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto" role="alert">
        <div id="error-child" class="bg-red-100 border border-red-400 text-red-700 rounded-xl shadow px-4 py-1 dark:bg-gray-900 dark:border-red-900 dark:text-red-400">
            <span id="error-message" class="block sm:inline"></span>
        </div>
    </div>

    <div class="max-w-[100rem] flex items-start px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="w-full mx-2 bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="flex items-start justify-between mb-2">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        {{ __('Crear Solicitud de Vacacion') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Formulario para crear solicitud de vacaciones') }}.
                    </p>

                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Tienes <b>{{ $ficha->diasDeVacacionesDisponibles() >= 0 ? $ficha->diasDeVacacionesDisponibles() : 0 }}</b> dias disponibles, para poder generar una solicitud.
                    </p>
                </div>

                <button id="reporte" type="submit" class="py-2 px-3 gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-600 text-white hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Formato de Solicitud') }}
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="md:col-span-4">
                    <label for="para" class="block text-sm font-medium text-gray-700 mb-1">Solicitud de permiso para:</label>
                    <input type="text" id="para" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="md:col-span-4">
                    <label for="detalle" class="block text-sm font-medium text-gray-700 mb-1">Descripcion Detallada:</label>
                    <textarea id="detalle" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </div>
        </div>

        <div class="w-full mx-2 bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-2">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Listado de dias a solicitar</h2>

                    <button id="enviar" type="submit" class="py-2 px-3 gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                        {{ __('Enviar Solicitud') }}
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="md:col-span-3">
                        <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                        <input type="date" id="fecha" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="valor" class="block text-sm font-medium text-gray-700 mb-1">Valor (0.5 o 1)</label>
                        <input type="number" id="valor" min="0.5" max="1" step="0.5" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="1">
                        <p class="text-xs text-gray-500 mt-1">Solo se permiten los valores 0.5 y 1</p>
                    </div>

                    <div class="md:col-span-4">
                        <input type="file" name="small-file-input" id="formato" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                        file:bg-gray-50 file:border-0
                        file:me-4
                        file:py-2 file:px-4
                        dark:file:bg-neutral-700 dark:file:text-neutral-400">
                        <p class="text-xs text-gray-500 mt-1">El archivo de la solicitud firmada es obligatoria*</p>
                    </div>
                </div>

                <button id="agregar" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-6">
                    Agregar a la tabla
                </button>

                <div class="overflow-x-auto">
                    <table id="tabla" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-body" class="bg-white divide-y divide-gray-200">
                            <!-- Los datos se agregarán aquí dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <div id="total" class="mt-4 text-right font-medium text-gray-700">
                    Total: <span id="total-valor">0</span>
                </div>
            </div>
        </div>
    </div>


    <script>
        const maxDiasDisponibles = {{ $ficha->diasDeVacacionesDisponibles() }};
        const storeRoute = "{{ route('solicitud_vacaciones.store') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        let flat;

        const originalArray  = [];

        const fechaInput = document.getElementById('fecha');
        const valorInput = document.getElementById('valor');
        const agregarBtn = document.getElementById('agregar');
        const enviarBtn = document.getElementById('enviar');
        const tablaBody = document.getElementById('tabla-body');
        const totalSpan = document.getElementById('total-valor');
        const errorContainer = document.getElementById('error-container');
        const errorChild = document.getElementById('error-child');
        const errorMessage = document.getElementById('error-message');

        function mostrarError(mensaje)
        {
            errorMessage.textContent = mensaje;
            errorContainer.classList.remove('hidden');

            setTimeout(() => {
                errorContainer.classList.add('hidden');
            }, 5000);
        }

        function calcularTotal()
        {
            return datos.reduce((total, dato) => total + dato.valor, 0);
        }

        function puedeAgregarDias(valor)
        {
            const totalActual = calcularTotal();
            return (totalActual + valor) <= maxDiasDisponibles;
        }

        function agregarDato()
        {
            errorContainer.classList.add('hidden');

            const fechasSeleccionadas = fechaInput.value.split(',');
            const valor = parseFloat(valorInput.value);

            if (valor !== 0.5 && valor !== 1) {
                mostrarError('Por favor ingrese solo 0.5 o 1 como valor');
                return;
            }

            if (fechasSeleccionadas.length === 0 || (fechasSeleccionadas.length === 1 && !fechasSeleccionadas[0])) {
                mostrarError('Por favor seleccione al menos una fecha');
                return;
            }

            const errores = [];
            const fechasValidas = [];

            fechasSeleccionadas.forEach(fecha => {
                const fechaTrimmed = fecha.trim();

                if (!fechaTrimmed) return;

                if (!esFechaValida(fechaTrimmed)) {
                    errores.push(`La fecha ${fechaTrimmed} debe ser posterior al día actual`);
                    return;
                }

                if (fechaYaExiste(fechaTrimmed)) {
                    errores.push(`Ya existe un registro con la fecha ${fechaTrimmed}`);
                    return;
                }

                fechasValidas.push(fechaTrimmed);
            });

            if (errores.length > 0) {
                mostrarError(errores.join('<br>'));
                return;
            }

            const totalDias = valor * fechasValidas.length;
            if (!puedeAgregarDias(totalDias)) {
                mostrarError(`No puede exceder los ${maxDiasDisponibles >= 0 ? maxDiasDisponibles : 0} días disponibles.
                            Está intentando agregar ${totalDias} días.`);
                return;
            }

            fechasValidas.forEach(fecha => {
                datos.push({ fecha, valor });
            });

            actualizarTabla();
            valorInput.value = 1;
            calcularSiguienteFechaDisponible();
        }

        function fechaYaExiste(fecha)
        {
            return datos.some(dato => dato.fecha === fecha);
        }

        function esFechaValida(fecha)
        {
            const fechaIngresada = new Date(fecha);
            return fechaIngresada > hoy;
        }

        async function enviarDatos()
        {

            if (datos.length === 0) {
                mostrarError('No hay datos para enviar');
                return;
            }

            try {
                const archivo = document.getElementById('formato').files[0];
                const formData = new FormData();

                formData.append('formato', archivo);
                formData.append('dias_vacaciones', JSON.stringify(datos));
                formData.append('solicitud_para', document.getElementById('para').value);
                formData.append('detalle_solicitud', document.getElementById('detalle').value);

                const response = await fetch(storeRoute, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Error en la solicitud');
                }

                if (data.success) {
                    mostrarMensajeExito(data.message);

                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                } else {
                    mostrarError(data.message);
                }
            } catch (error) {
                mostrarError(error.message);
            }
        }

        const hoy = new Date();
        const manana = new Date(hoy);
        manana.setDate(manana.getDate() + 1);

        const formatoFechaInput = (date) => date.toISOString().split('T')[0];
        fechaInput.min = formatoFechaInput(manana);
        fechaInput.value = formatoFechaInput(manana);

        function calcularSiguienteFechaDisponible()
        {
            if (datos.length === 0) {
                fechaInput.value = formatoFechaInput(manana);
                flat.setDate(formatoFechaInput(manana));
                return;
            }

            const fechasOrdenadas = datos.map(d => new Date(d.fecha)).sort((a, b) => b - a);
            const ultimaFecha = fechasOrdenadas[0];

            const siguienteFecha = new Date(ultimaFecha);
            siguienteFecha.setDate(siguienteFecha.getDate() + 1);

            fechaInput.value = formatoFechaInput(siguienteFecha);
            flat.setDate(formatoFechaInput(siguienteFecha));
        }

        function mostrarMensajeExito(mensaje)
        {
            errorChild.classList.remove('bg-red-100', 'border-red-400', 'text-red-700');
            errorChild.classList.add('bg-green-100', 'border-green-400', 'text-green-700');
            errorMessage.textContent = mensaje;
            errorContainer.classList.remove('hidden');

            setTimeout(() => {
                errorContainer.classList.add('hidden');
                errorChild.classList.add('bg-red-100', 'border-red-400', 'text-red-700');
                errorChild.classList.remove('bg-green-100', 'border-green-400', 'text-green-700');
            }, 5000);
        }

        function actualizarTabla()
        {
            tablaBody.innerHTML = '';

            let total = 0;

            const datosOrdenados = [...datos].sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

            datosOrdenados.forEach((dato, index) => {
                const originalIndex = datos.findIndex(d => d.fecha === dato.fecha && d.valor === dato.valor);

                const fila = document.createElement('tr');

                const celdaFecha = document.createElement('td');
                celdaFecha.className = 'px-6 py-1 whitespace-nowrap text-sm text-gray-500';
                const [año, mes, dia] = dato.fecha.split('-');

                const diaFormateado = dia.padStart(2, '0');
                const mesFormateado = mes.padStart(2, '0');

                celdaFecha.textContent = `${diaFormateado}/${mesFormateado}/${año}`;



                const celdaValor = document.createElement('td');
                celdaValor.className = 'px-6 py-1 whitespace-nowrap text-sm text-gray-500';
                celdaValor.textContent = dato.valor;

                const celdaAcciones = document.createElement('td');
                celdaAcciones.className = 'px-6 py-1 whitespace-nowrap text-sm text-gray-500';

                const botonEliminar = document.createElement('button');
                botonEliminar.className = 'text-red-600 hover:text-red-900';
                botonEliminar.textContent = 'Eliminar';
                botonEliminar.onclick = () => eliminarDato(originalIndex);

                celdaAcciones.appendChild(botonEliminar);

                fila.appendChild(celdaFecha);
                fila.appendChild(celdaValor);
                fila.appendChild(celdaAcciones);

                tablaBody.appendChild(fila);

                total += dato.valor;
            });

            totalSpan.textContent = total;
        }

        function eliminarDato(index)
        {
            datos.splice(index, 1);
            actualizarTabla();
            calcularSiguienteFechaDisponible();
        }

        agregarBtn.addEventListener('click', agregarDato);
        enviarBtn.addEventListener('click', enviarDatos); // Asegúrate de tener este botón

        valorInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                agregarDato();
            }
        });

        function createObservableArray(array, callback)
        {
            return new Proxy(array, {
                set(target, property, value, receiver) {
                    const oldValue = target[property];
                    const result = Reflect.set(target, property, value, receiver);

                    if (property === 'length' || !isNaN(property)) {
                        callback({
                            type: 'change',
                            target: target,
                            property,
                            oldValue,
                            newValue: value
                        });
                    }

                    return result;
                },
                apply(target, thisArg, argumentsList) {
                    const method = argumentsList.callee;
                    const methodName = method.name;

                    if (['push', 'pop', 'shift', 'unshift', 'splice', 'sort', 'reverse'].includes(methodName)) {
                        const oldArray = [...target];
                        const result = Reflect.apply(target, thisArg, argumentsList);

                        callback({
                            type: 'method',
                            target: target,
                            method: methodName,
                            args: argumentsList,
                            oldArray,
                            newArray: [...target]
                        });

                        return result;
                    }

                    return Reflect.apply(target, thisArg, argumentsList);
                }
            });
        }

        const datos = createObservableArray(originalArray, (change) => {
            console.log('Cambio detectado:', change);
            const fechasOcupadas = datos.map(item => item.fecha);
            flat.set('disable', [
                function(date) {
                    const fechaStr = flat.formatDate(date, 'Y-m-d');
                    return fechasOcupadas.includes(fechaStr);
                }
            ]);
        });

        document.getElementById('reporte').addEventListener('click', function() {
            let para = document.getElementById('para').value
            let detalle = document.getElementById('detalle').value


            if (datos.length === 0) {
                mostrarError('No hay datos para enviar');
                return;
            }

            if (para == '' || detalle == '') {
                mostrarError('Llenar los detalles de la solicitud.');
                return;
            }

            const fechasParam = encodeURIComponent(JSON.stringify(datos));
            const url = "{{ route('solicitud_vacaciones.pdf', ['fechas' => '--FECHAS--', 'permiso' => '--PERMISO--', 'detalle' => '--DETALLE--']) }}"
                .replace('--FECHAS--', fechasParam)
                .replace('--PERMISO--', para)
                .replace('--DETALLE--', detalle);

            window.open(url, '_blank');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flat = flatpickr("#fecha", {
                dateFormat: "Y-m-d",
                mode: "multiple",
                altInput: true,
                altFormat: "d/m/Y",
                minDate: new Date().fp_incr(1),
                disable: [
                ],
            });
        })
    </script>
  </x-app-layout>


