<x-app-layout>
    @section('breadcrumbs')
    <li class="text-sm">
        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-none focus:text-blue-600 dark:focus:text-blue-500" href="#">
            <svg class="flex-shrink-0 mx-2 overflow-visible h-4 w-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            {{ __('Periodo de Vacaciones') }}
        </a>
    </li>
    @endsection

    <x-toast :show="session('status') != '' ? true : false" :type="session('status')" :message="session('message')"/>

    <div class="max-w-[70rem] px-4 py-2 sm:px-6 lg:px-8 lg:py-2 mx-auto">
        <!-- Card -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-slate-900 dark:border-gray-700">
                        <!-- Header -->
                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-gray-700">
                            <!-- Input -->
                            <div class="flex items-start gap-4 sm:col-span-1">
                                <div class="flex items-center gap-x-4">
                                    <div class="relative flex rounded-lg shadow-sm w-full">
                                        <!-- Botón de buscar -->


                                    </div>
                                </div>
                            </div>
                            <!-- End Input -->

                            <a href="{{ route('periodo_vacaciones.calcular') }}" class="py-3 px-4 flex justify-center items-center h-[2rem] w-[2rem] text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">


                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-ccw-icon lucide-refresh-ccw flex-shrink-0 w-5 h-5"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                            </a>
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Periodo') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center justify-end gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Dias a Gozar') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center justify-end gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Res. Semana S.') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center justify-end gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Res. Fin A.') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center justify-end gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Dias Gozados') }}
                                        </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center justify-end gap-x-2">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-gray-200">
                                            {{ __('Saldo') }}
                                        </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($periodos as $periodo)
                                    @if(!$loop->last)
                                    <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                        <td class="h-px w-px whitespace-nowrap align-center">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $periodo->PERIODO }}</span>
                                            </a>
                                        </td>
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->DIA_GOZAR, 0) }}</span>
                                            </a>
                                        </td>
                                        @if ($periodo->esPeriodoActual())
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->esAplicableResguardoSemanaSanta() ? $configuracion->dias_resguardo_semana_santa : 0, 0) }}</span>
                                            </a>
                                        </td>
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->esAplicableResguardoFinDeAnio() ? $configuracion->dias_resguardo_fin_anio : 0, 0) }}</span>
                                            </a>
                                        </td>
                                        @else
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ 0 }}</span>
                                            </a>
                                        </td>
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ 0 }}</span>
                                            </a>
                                        </td>
                                        @endif
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->DIA_GOZADOS, 0) }}</span>
                                            </a>
                                        </td>
                                        @if ($periodo->esPeriodoActual())
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format(($periodo->DIA_GOZAR - $periodo->DIA_GOZADOS) - ($periodo->esAplicableResguardoSemanaSanta() ? $configuracion->dias_resguardo_semana_santa : 0) - ($periodo->esAplicableResguardoFinDeAnio() ? $configuracion->dias_resguardo_fin_anio : 0), 0) }}</span>
                                            </a>
                                        </td>
                                        @else
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->DIA_GOZAR - $periodo->DIA_GOZADOS, 0) }}</span>
                                            </a>
                                        </td>
                                        @endif
                                        <td class="h-px w-px whitespace-nowrap align-center text-center">
                                            <div class="block py-2 px-6">

                                            </div>
                                        </td>
                                    </tr>
                                    @endif

                                    @if($loop->last && $periodo->esPeriodoActual())
                                    <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                        <td class="h-px w-px whitespace-nowrap align-center">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $periodo->PERIODO }}</span>
                                            </a>
                                        </td>
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->DIA_GOZAR, 0) }}</span>
                                            </a>
                                        </td>
                                        @if ($periodo->esPeriodoActual())
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->esAplicableResguardoSemanaSanta() ? $configuracion->dias_resguardo_semana_santa : 0, 0) }}</span>
                                            </a>
                                        </td>
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->esAplicableResguardoFinDeAnio() ? $configuracion->dias_resguardo_fin_anio : 0, 0) }}</span>
                                            </a>
                                        </td>
                                        @else
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ 0 }}</span>
                                            </a>
                                        </td>
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ 0 }}</span>
                                            </a>
                                        </td>
                                        @endif
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->DIA_GOZADOS, 0) }}</span>
                                            </a>
                                        </td>
                                        @if ($periodo->esPeriodoActual())
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format(($periodo->DIA_GOZAR - $periodo->DIA_GOZADOS) - ($periodo->esAplicableResguardoSemanaSanta() ? $configuracion->dias_resguardo_semana_santa : 0) - ($periodo->esAplicableResguardoFinDeAnio() ? $configuracion->dias_resguardo_fin_anio : 0), 0) }}</span>
                                            </a>
                                        </td>
                                        @else
                                        <td class="h-px w-px whitespace-nowrap align-center text-right">
                                            <a class="block py-2 px-6" href="#">
                                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ number_format($periodo->DIA_GOZAR - $periodo->DIA_GOZADOS, 0) }}</span>
                                            </a>
                                        </td>
                                        @endif
                                        <td class="h-px w-px whitespace-nowrap align-center text-center">
                                            <div class="block py-2 px-6">

                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                @empty
                                <tr class="bg-white hover:bg-gray-50 dark:bg-slate-900 dark:hover:bg-slate-800">
                                    <td colspan="5">
                                        <div class="max-w-sm w-full min-h-[300px] flex flex-col justify-center text-center items-center mx-auto px-6 py-4">
                                            <div class="flex justify-center items-center w-[46px] h-[46px] bg-gray-100 rounded-lg dark:bg-gray-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-notebook-text flex-shrink-0 w-6 h-6 text-gray-600 dark:text-gray-400"><path d="M2 6h4"/><path d="M2 10h4"/><path d="M2 14h4"/><path d="M2 18h4"/><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9.5 8h5"/><path d="M9.5 12H16"/><path d="M9.5 16H14"/></svg>
                                            </div>

                                            <h2 class="mt-5 font-semibold text-gray-800 dark:text-white">
                                                {{ __('No records found') }}
                                            </h2>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $periodos->links() }}
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
