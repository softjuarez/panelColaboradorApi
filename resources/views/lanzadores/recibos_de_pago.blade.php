<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Reporte Recibo de Pago') }}
        </a>
    </li>
    @endsection

    <div class="max-w-[100rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('Reporte Recibo de Pago') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Puedes generar reporte de recibos por fechas.') }}
                </p>
            </div>


            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                <div class="sm:col-span-3">
                    <label for="fecha_inicio" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200">
                        {{ __('Rango de Fechas') }}
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <div class="sm:flex">
                        <input name="fecha_inicio" id="fecha_inicio" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Correlativo Inicio" value="{{ date('Y-m-d') }}">
                        <input name="fecha_final" id="fecha_final" type="date" class="py-2 px-3 block w-full border-gray-200 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" placeholder="Correlativo Final" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-x-2">
                <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    {{ __('Generar Reporte') }}
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let generarReporteBtn = document.querySelector('button[type="submit"]');

            generarReporteBtn.addEventListener('click', function(event) {
                let fechaInicio = document.getElementById('fecha_inicio').value;
                let fechaFin = document.getElementById('fecha_final').value;


                if (!fechaInicio || !fechaFin) {
                    event.preventDefault(); // Prevenir que se envíe el formulario si no pasa la validación
                    alert('Por favor, completa todos los campos obligatorios.');
                    exit;
                }

                if (new Date(fechaInicio) > new Date(fechaFin)) {
                    event.preventDefault(); // Prevenir el envío del formulario si la fecha es inválida
                    alert('La fecha de inicio no puede ser mayor que la fecha de fin.');
                    exit;
                }

                let url = "{{ route('recibos.generar', [':fechaI', ':fechaF']) }}";
                url = url.replace(':fechaI', fechaInicio);
                url = url.replace(':fechaF', fechaFin);

                window.open(url, '_blank');
            });
        });
    </script>



</x-app-layout>
