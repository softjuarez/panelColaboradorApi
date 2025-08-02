<?php

use App\Http\Controllers\AdjuntoController;
use App\Http\Controllers\AdjuntoPermisoController;
use App\Http\Controllers\AdjuntoSolicitudController;
use App\Http\Controllers\ArchivoPermisoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\TipoAdjuntoController;
use App\Http\Controllers\ArchivoRequisicionController;
use App\Http\Controllers\TipoSolicitudController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\AutorizaSolicitudController;
use App\Http\Controllers\AutorizaJefeRequisicionHController;
use App\Http\Controllers\AutorizaRequisicionPorLimiteController;
use App\Http\Controllers\BitacoraRequisicionController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\RecibosDePagoController;
use App\Http\Controllers\RequisicionCController;
use App\Http\Controllers\RequisicionDController;
use App\Http\Controllers\RequisicionHController;
use App\Http\Controllers\ArchivoSolicitudController;
use App\Http\Controllers\AutorizacionLicenciaController;
use App\Http\Controllers\AutorizaComiteRequisicionDController;
use App\Http\Controllers\AutorizaComiteRequisicionHController;
use App\Http\Controllers\AutorizaCompraRequisicionDController;
use App\Http\Controllers\AutorizaCompraRequisicionHController;
use App\Http\Controllers\AutorizaGestorRequisicionDController;
use App\Http\Controllers\AutorizaGestorRequisicionHController;
use App\Http\Controllers\AutorizaJefeRequisicionDController;
use App\Http\Controllers\AutorizaPPTORequisicionDController;
use App\Http\Controllers\AutorizaPPTORequisicionHController;
use App\Http\Controllers\AutorizaSolicitudPermisoController;
use App\Http\Controllers\AutorizaSolicitudVacacionesController;
use App\Http\Controllers\AutorizaTesoreriaRequisicionDController;
use App\Http\Controllers\AutorizaTesoreriaRequisicionHController;
use App\Http\Controllers\BandejaDeNoticiaController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\CalendarioAniversarioController;
use App\Http\Controllers\CalendarioCumpleaniosController;
use App\Http\Controllers\ConexionNodoController;
use App\Http\Controllers\ConfiguracionUsuarioController;
use App\Http\Controllers\ConsultaDeRequisicionesController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\IntegranteNodoController;
use App\Http\Controllers\LicenciaController;
use App\Http\Controllers\NodoController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\OrdenDeCompraHController;
use App\Http\Controllers\OrganigramaController;
use App\Http\Controllers\PeriodoVacacionesController;
use App\Http\Controllers\ProveedorDocumentoController;
use App\Http\Controllers\ProveedorDocumentoDetalleController;
use App\Http\Controllers\ProveedorOrdenDeCompraHController;
use App\Http\Controllers\ReporteFichaDeResponsabilidadController;
use App\Http\Controllers\RequisicionPController;
use App\Http\Controllers\ResponsabilidadNodoController;
use App\Http\Controllers\RRHHAutorizaSolicitudVacacionesController;
use App\Http\Controllers\SolicitudPermisosController;
use App\Http\Controllers\SolicitudVacacionesController;
use App\Http\Controllers\TipoLicenciaController;
use App\Http\Controllers\TipoPermisoController;
use App\Http\Controllers\ValidacionLicenciaController;
use App\Http\Controllers\ValidacionSolicitudPermisoController;
use App\Http\Controllers\VisualizadorOrganigramaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(FichaController::class)->group(function () {
        Route::get('/fichas/index/{estado?}/{asignacion?}/{search?}', 'index')->middleware('permission:show-ficha')->name('fichas.index');
        Route::get('/fichas/edit/{ficha}', 'edit')->middleware('permission:edit-ficha')->name('fichas.edit');
        Route::post('/fichas/update/{ficha}', 'update')->middleware('permission:edit-ficha')->name('fichas.update');
        Route::post('/fichas/asignar/{ficha}', 'asignarCreandoUsuario')->middleware('permission:edit-ficha')->name('fichas.asignar');
        Route::get('/fichas/listado', 'listado')->name('fichas.listado');
    });

    Route::controller(RecibosDePagoController::class)->group(function () {
        Route::get('/reporte/recibo/launcher', 'launcher')->middleware('permission:show-reporte_recibo')->name('recibos.lanucher');
        Route::get('/reporte/recibo/{fecha_inicio}/{fecha_fin}', 'generar')->middleware('permission:show-reporte_recibo')->name('recibos.generar');
    });

    Route::controller(BitacoraController::class)->group(function () {
        Route::get('/reporte/bitacora/launcher', 'launcher')->middleware('permission:show-reporte_bitacora')->name('bitacora.lanucher');
        Route::get('/reporte/bitacora/{fecha_inicio}/{fecha_fin}/{ficha}', 'generar')->middleware('permission:show-reporte_bitacora')->name('bitacora.generar');
    });

    Route::controller(ReporteFichaDeResponsabilidadController::class)->group(function () {
        Route::get('/reporte/responsabilidad/launcher', 'launcher')->middleware('permission:show-reporte_responsabilidad')->name('responsabilidad.lanucher');
        Route::get('/reporte/responsabilidad/{fecha_inicio}/{fecha_fin}/{sede}', 'generar')->middleware('permission:show-reporte_responsabilidad')->name('responsabilidad.generar');
    });

    Route::controller(RequisicionHController::class)->group(function () {
        Route::get('/requisiciones/index/{estado?}/{search?}', 'index')->middleware('permission:show-requisicion')->name('requisiciones.index');
        Route::get('/requisiciones/new', 'new')->middleware('permission:new-requisicion')->name('requisiciones.new');
        Route::post('/requisiciones/store', 'store')->middleware('permission:new-requisicion')->name('requisiciones.store');
        Route::get('/requisiciones/edit/{requisicion}', 'edit')->middleware('permission:edit-requisicion')->name('requisiciones.edit');
        Route::post('/requisiciones/update/{requisicion}', 'update')->middleware('permission:edit-requisicion')->name('requisiciones.update');
        Route::get('/requisiciones/cerrar/{requisicion}', 'cerrar')->middleware('permission:edit-requisicion')->name('requisiciones.cerrar');
        Route::get('/requisiciones/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-requisicion')->name('requisiciones.obterner_total');
        Route::get('/requisiciones/reporte/{requisicion}', 'reporte')->middleware('permission:edit-requisicion')->name('requisiciones.reporte');
    });

    Route::controller(RequisicionDController::class)->group(function () {
        Route::get('/requisiciones_detalle/index/{requisicion}', 'index')->middleware('permission:edit-requisicion')->name('requisiciones_detalle.obtener');
        Route::get('/requisiciones_detalle/new/{requisicion}', 'new')->middleware('permission:edit-requisicion')->name('requisiciones_detalle.new');
        Route::post('/requisiciones_detalle/store/{requisicion}', 'store')->middleware('permission:edit-requisicion')->name('requisiciones_detalle.store');
        Route::get('/requisiciones_detalle/edit/{detalle}', 'edit')->middleware('permission:edit-requisicion')->name('requisiciones_detalle.edit');
        Route::post('/requisiciones_detalle/update/{detalle}', 'update')->middleware('permission:edit-requisicion')->name('requisiciones_detalle.update');
        Route::get('/requisiciones_detalle/delete/{detalle}', 'delete')->middleware('permission:edit-requisicion')->name('requisiciones_detalle.delete');
    });

    Route::controller(RequisicionCController::class)->group(function () {
        Route::get('/requisiciones_c_detalle/listado/{requisicion_d}', 'index')->middleware('check.edit.requisicion')->name('requisiciones_c_detalle.listado');
        Route::get('/requisiciones_c_detalle/new/{requisicion_d}', 'new')->middleware('check.edit.requisicion')->name('requisiciones_c_detalle.new');
        Route::post('/requisiciones_c_detalle/store/{requisicion_d}', 'store')->middleware('check.edit.requisicion')->name('requisiciones_c_detalle.store');
        Route::get('/requisiciones_c_detalle/edit/{detalle}', 'edit')->middleware('check.edit.requisicion')->name('requisiciones_c_detalle.edit');
        Route::post('/requisiciones_c_detalle/update/{detalle}', 'update')->middleware('check.edit.requisicion')->name('requisiciones_c_detalle.update');
        Route::get('/requisiciones_c_detalle/delete/{detalle}', 'delete')->middleware('check.edit.requisicion')->name('requisiciones_c_detalle.delete');
    });

    Route::controller(RequisicionPController::class)->group(function () {
        Route::get('/requisiciones_detalle_p/new/{requisicion}', 'new')->middleware('check.edit.requisicion')->name('requisiciones_detalle_p.new');
        Route::post('/requisiciones_detalle_p/store/{requisicion}', 'store')->middleware('check.edit.requisicion')->name('requisiciones_detalle_p.store');
        Route::get('/requisiciones_detalle_p/edit/{detalle}', 'edit')->middleware('check.edit.requisicion')->name('requisiciones_detalle_p.edit');
        Route::post('/requisiciones_detalle_p/update/{detalle}', 'update')->middleware('check.edit.requisicion')->name('requisiciones_detalle_p.update');
        Route::get('/requisiciones_detalle_p/delete/{detalle}', 'delete')->middleware('check.edit.requisicion')->name('requisiciones_detalle_p.delete');
    });

    Route::controller(AutorizaJefeRequisicionHController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/jefe/index/{search?}', 'index')->middleware('permission:show-autoriza-jefe')->name('autoriza-jefe.index');
        Route::get('/requisiciones/autorizacion/jefe/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-jefe')->name('autoriza-jefe.edit');
        Route::post('/requisiciones/autorizacion/jefe/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-jefe')->name('autoriza-jefe.update');
        Route::post('/requisiciones/autorizacion/jefe/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-jefe')->name('autoriza-jefe.autorizar');
        Route::post('/requisiciones/autorizacion/jefe/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-jefe')->name('autoriza-jefe.rechazar');
        Route::get('/requisiciones/autorizacion/jefe/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-autoriza-jefe')->name('autoriza-jefe.obterner_total');
    });

    Route::controller(AutorizaPPTORequisicionHController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/ppto/index/{search?}', 'index')->middleware('permission:show-autoriza-ppto')->name('autoriza-ppto.index');
        Route::get('/requisiciones/autorizacion/ppto/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-ppto')->name('autoriza-ppto.edit');
        Route::post('/requisiciones/autorizacion/ppto/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-ppto')->name('autoriza-ppto.update');
        Route::post('/requisiciones/autorizacion/ppto/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-ppto')->name('autoriza-ppto.autorizar');
        Route::post('/requisiciones/autorizacion/ppto/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-ppto')->name('autoriza-ppto.rechazar');
        Route::get('/requisiciones/autorizacion/ppto/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-autoriza-ppto')->name('autoriza-ppto.obterner_total');
    });

    Route::controller(AutorizaTesoreriaRequisicionHController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/tesoreria/index/{search?}', 'index')->middleware('permission:show-autoriza-tesoreria')->name('autoriza-tesoreria.index');
        Route::get('/requisiciones/autorizacion/tesoreria/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-tesoreria')->name('autoriza-tesoreria.edit');
        Route::post('/requisiciones/autorizacion/tesoreria/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-tesoreria')->name('autoriza-tesoreria.update');
        Route::post('/requisiciones/autorizacion/tesoreria/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-tesoreria')->name('autoriza-tesoreria.autorizar');
        Route::post('/requisiciones/autorizacion/tesoreria/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-tesoreria')->name('autoriza-tesoreria.rechazar');
        Route::get('/requisiciones/autorizacion/tesoreria/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-autoriza-tesoreria')->name('autoriza-tesoreria.obterner_total');
    });

    Route::controller(AutorizaCompraRequisicionHController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/compra/index/{search?}', 'index')->middleware('permission:show-autoriza-compra')->name('autoriza-compra.index');
        Route::get('/requisiciones/autorizacion/compra/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-compra')->name('autoriza-compra.edit');
        Route::post('/requisiciones/autorizacion/compra/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-compra')->name('autoriza-compra.update');
        Route::post('/requisiciones/autorizacion/compra/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-compra')->name('autoriza-compra.autorizar');
        Route::post('/requisiciones/autorizacion/compra/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-compra')->name('autoriza-compra.rechazar');
        Route::get('/requisiciones/autorizacion/compra/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-autoriza-compra')->name('autoriza-compra.obterner_total');
        Route::get('/requisiciones/autorizacion/compra/enviar_a_comite/{requisicion}', 'enviarAComite')->middleware('permission:edit-autoriza-compra')->name('autoriza-compra.enviar_a_comite');
        Route::get('/requisiciones/autorizacion/compra/listado/{search?}', 'obtenerListado')->middleware('permission:show-autoriza-compra')->name('autoriza-compra.listado');
    });

    Route::controller(AutorizaGestorRequisicionHController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/gestor/index/{search?}', 'index')->middleware('permission:show-autoriza-gestor')->name('autoriza-gestor.index');
        Route::get('/requisiciones/autorizacion/gestor/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-gestor')->name('autoriza-gestor.edit');
        Route::post('/requisiciones/autorizacion/gestor/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-gestor')->name('autoriza-gestor.update');
        Route::post('/requisiciones/autorizacion/gestor/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-gestor')->name('autoriza-gestor.autorizar');
        Route::post('/requisiciones/autorizacion/gestor/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-gestor')->name('autoriza-gestor.rechazar');
        Route::get('/requisiciones/autorizacion/gestor/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-autoriza-gestor')->name('autoriza-gestor.obterner_total');
    });

    Route::controller(AutorizaComiteRequisicionHController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/comite/index/{search?}', 'index')->middleware('permission:show-autoriza-comite')->name('autoriza-comite.index');
        Route::get('/requisiciones/autorizacion/comite/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-comite')->name('autoriza-comite.edit');
        Route::post('/requisiciones/autorizacion/comite/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-comite')->name('autoriza-comite.update');
        Route::post('/requisiciones/autorizacion/comite/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-comite')->name('autoriza-comite.autorizar');
        Route::post('/requisiciones/autorizacion/comite/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-comite')->name('autoriza-comite.rechazar');
        Route::get('/requisiciones/autorizacion/comite/total/{requisicion}', 'obtenerTotal')->middleware('permission:edit-autoriza-comite')->name('autoriza-comite.obterner_total');
    });

    Route::controller(AutorizaJefeRequisicionDController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/jefe/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-autoriza-jefe')->name('detalle.jefe.edit');
        Route::post('/requisiciones/autorizacion/jefe/detalle/update/{detalle}', 'update')->middleware('permission:edit-autoriza-jefe')->name('detalle.jefe.update');
    });

    Route::controller(AutorizaPPTORequisicionDController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/ppto/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-autoriza-ppto')->name('detalle.ppto.edit');
        Route::post('/requisiciones/autorizacion/ppto/detalle/update/{detalle}', 'update')->middleware('permission:edit-autoriza-ppto')->name('detalle.ppto.update');
    });

    Route::controller(AutorizaTesoreriaRequisicionDController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/tesoreria/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-autoriza-tesoreria')->name('detalle.tesoreria.edit');
        Route::post('/requisiciones/autorizacion/tesoreria/detalle/update/{detalle}', 'update')->middleware('permission:edit-autoriza-tesoreria')->name('detalle.tesoreria.update');
    });

    Route::controller(AutorizaCompraRequisicionDController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/compra/detalle/index/{requisicion}', 'index')->middleware('permission:edit-autoriza-compra')->name('detalle.compra.obtener');

        Route::get('/requisiciones/autorizacion/compra/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-autoriza-compra')->name('detalle.compra.edit');
        Route::post('/requisiciones/autorizacion/compra/detalle/update/{detalle}', 'update')->middleware('permission:edit-autoriza-compra')->name('detalle.compra.update');
    });

    Route::controller(AutorizaGestorRequisicionDController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/gestor/detalle/index/{requisicion}', 'index')->middleware('permission:edit-autoriza-gestor')->name('detalle.gestor.obtener');

        Route::get('/requisiciones/autorizacion/gestor/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-autoriza-gestor')->name('detalle.gestor.edit');
        Route::post('/requisiciones/autorizacion/gestor/detalle/update/{detalle}', 'update')->middleware('permission:edit-autoriza-gestor')->name('detalle.gestor.update');
    });

    Route::controller(AutorizaComiteRequisicionDController::class)->group(function () {
        Route::get('/requisiciones/autorizacion/comite/detalle/index/{requisicion}', 'index')->middleware('permission:edit-autoriza-comite')->name('detalle.comite.obtener');

        Route::get('/requisiciones/autorizacion/comite/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-autoriza-comite')->name('detalle.comite.edit');
        Route::post('/requisiciones/autorizacion/comite/detalle/update/{detalle}', 'update')->middleware('permission:edit-autoriza-comite')->name('detalle.comite.update');
    });

    Route::controller(OrdenDeCompraHController::class)->group(function () {
        Route::get('/ordenes/compra/index/{search?}', 'index')->middleware('permission:show-orden_compra')->name('ordenes_compra.index');
        Route::get('/ordenes/create/{requisicion}', 'create')->middleware('permission:edit-autoriza-compra')->name('ordenes.create');
        Route::get('/ordenes/compra/edit/{orden}', 'edit')->middleware('permission:edit-orden_compra')->name('ordenes_compra.edit');
        Route::post('/ordenes/compra/update/{orden}', 'update')->middleware('permission:edit-orden_compra')->name('ordenes_compra.update');
        Route::get('/ordenes/reporte/{orden}', 'reporte')->middleware('permission:edit-orden_compra')->name('ordenes_compra.reporte');
        Route::get('/ordenes/procesar/{orden}', 'procesar')->middleware('permission:edit-orden_compra')->name('ordenes_compra.procesar');
    });

    Route::controller(ProveedorOrdenDeCompraHController::class)->group(function () {
        Route::get('/ordenes/proveedor/index', 'index')->middleware('permission:show-orden_compra_proveedor')->name('ordenes_proveedor.index');
        Route::get('/ordenes/proveedor/edit/{orden}', 'edit')->middleware('permission:edit-orden_compra_proveedor')->name('ordenes_proveedor.edit');
    });

    Route::controller(DocumentoController::class)->group(function () {
        Route::get('/documentos/index/{estado?}/{search?}', 'index')->middleware('permission:show-documento')->name('documentos.index');
        Route::get('/documentos/new/{orden}', 'new')->middleware('permission:new-documento')->name('documentos.new');
        Route::post('/documentos/store/{orden}', 'store')->middleware('permission:new-documento')->name('documentos.store');
        Route::get('/documentos/edit/{documento}', 'edit')->middleware('permission:edit-documento')->name('documentos.edit');
        Route::post('/documentos/update/{documento}', 'update')->middleware('permission:edit-documento')->name('documentos.update');
        Route::get('/documentos/fechas/{documento}', 'calcularFechaPago')->middleware('permission:edit-documento')->name('documentos.calcular_fecha_pago');
        Route::get('/documentos/autorizar/{documento}', 'autorizar')->middleware('permission:edit-documento')->name('documentos.autorizar');
        Route::post('/documentos/rechazar/{documento}', 'rechazar')->middleware('permission:edit-documento')->name('documentos.rechazar');
        Route::post('/documentos/pdf/{documento}', 'adjuntarPdf')->middleware('permission:edit-documento')->name('documentos.pdf');
        Route::get('/documentos/pdf/eliminar/{documento}/{tipo}', 'eliminarPdf')->middleware('permission:edit-documento')->name('documentos.pdf_eliminar');

    });

    Route::controller(ProveedorDocumentoController::class)->group(function () {
        Route::get('/documentos/proveedor/index', 'index')->middleware('permission:show-documento_proveedor')->name('documentos_proveedor.index');
        Route::get('/documentos/proveedor/new/{orden}', 'new')->middleware('permission:new-documento_proveedor')->name('documentos_proveedor.new');
        Route::post('/documentos/proveedor/store/{orden}', 'store')->middleware('permission:new-documento_proveedor')->name('documentos_proveedor.store');
        Route::get('/documentos/proveedor/edit/{documento}', 'edit')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor.edit');
        Route::post('/documentos/proveedor/update/{documento}', 'update')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor.update');
        Route::get('/documentos/proveedor/review/{documento}', 'solicitarRevision')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor.review');
        Route::post('/documentos/proveedor/xml/{orden}', 'adjuntarXml')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor.xml');
        Route::post('/documentos/proveedor/pdf/{documento}', 'adjuntarPdf')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor.pdf');
        Route::get('/documentos/proveedor/pdf/eliminar/{documento}', 'eliminarPdf')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor.pdf_eliminar');
    });

    Route::controller(ProveedorDocumentoDetalleController::class)->group(function () {
        Route::get('/documentos/proveedor/detalle/index/{documento}', 'index')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor_detalle.obtener');
        Route::get('/documentos/proveedor/detalle/new/{documento}', 'new')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor_detalle.new');
        Route::post('/documentos/proveedor/detalle/store/{documento}', 'store')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor_detalle.store');
        Route::get('/documentos/proveedor/detalle/edit/{detalle}', 'edit')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor_detalle.edit');
        Route::post('/documentos/proveedor/detalle/update/{detalle}', 'update')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor_detalle.update');
        Route::get('/documentos/proveedor/detalle/delete/{detalle}', 'delete')->middleware('permission:edit-documento_proveedor')->name('documentos_proveedor_detalle.delete');
    });

    Route::controller(AutorizaRequisicionPorLimiteController::class)->group(function () {
        Route::get('/requisiciones/autorizacion-por-limite/index/{search?}', 'index')->middleware('permission:show-autoriza-por-limite-requisicion')->name('autoriza-por-limite-requisicion.index');
        Route::get('/requisiciones/autorizacion-por-limite/edit/{requisicion}', 'edit')->middleware('permission:edit-autoriza-por-limite-requisicion')->name('autoriza-por-limite-requisicion.edit');
        Route::post('/requisiciones/autorizacion-por-limite/update/{requisicion}', 'update')->middleware('permission:edit-autoriza-por-limite-requisicion')->name('autoriza-por-limite-requisicion.update');
        Route::post('/requisiciones/autorizacion-por-limite/autorizar/{requisicion}', 'autorizar')->middleware('permission:edit-autoriza-por-limite-requisicion')->name('autoriza-por-limite-requisicion.autorizar');
        Route::post('/requisiciones/autorizacion-por-limite/rechazar/{requisicion}', 'rechazar')->middleware('permission:edit-autoriza-por-limite-requisicion')->name('autoriza-por-limite-requisicion.rechazar');
    });

    Route::controller(AdjuntoController::class)->group(function () {
        Route::get('/adjuntos/index/{search?}', 'index')->middleware('permission:show-adjunto')->name('adjuntos.index');
        Route::post('/adjuntos/store/{ficha}', 'store')->middleware('permission:edit-ficha')->name('adjuntos.store');
        Route::get('/adjuntos/listado/{ficha}', 'listado')->middleware('permission:edit-ficha')->name('adjuntos.listado');
        Route::get('/adjuntos/eliminar/{adjunto}', 'delete')->middleware('permission:edit-ficha')->name('adjuntos.delete');
    });

    Route::controller(AdjuntoPermisoController::class)->group(function () {
        Route::post('/adjuntos/permiso/store/{solicitud}', 'store')->middleware('permission:edit-autoriza_solicitud_permiso')->name('adjuntos.permiso.store');
        Route::get('/adjuntos/permiso/listado/{solicitud}', 'listado')->middleware('permission:edit-autoriza_solicitud_permiso')->name('adjuntos.permiso.listado');
        Route::get('/adjuntos/permiso/eliminar/{adjunto}', 'delete')->middleware('permission:edit-autoriza_solicitud_permiso')->name('adjuntos.permiso.delete');
    });

    Route::controller(AdjuntoSolicitudController::class)->group(function () {
        Route::post('/adjuntos/solicitud/store/{solicitud}', 'store')->middleware('permission:edit-autoriza_solicitud')->name('adjuntos.solicitud.store');
        Route::get('/adjuntos/solicitud/listado/{solicitud}', 'listado')->middleware('permission:edit-autoriza_solicitud')->name('adjuntos.solicitud.listado');
        Route::get('/adjuntos/solicitud/eliminar/{adjunto}', 'delete')->middleware('permission:edit-autoriza_solicitud')->name('adjuntos.solicitud.delete');
    });

    Route::controller(TipoAdjuntoController::class)->group(function () {
        Route::get('/tipo_adjuntos/index', 'index')->middleware('permission:show-tipo_adjunto')->name('tipo_adjuntos.index');
        Route::get('/tipo_adjuntos/new', 'new')->middleware('permission:new-tipo_adjunto')->name('tipo_adjuntos.new');
        Route::post('/tipo_adjuntos/store', 'store')->middleware('permission:new-tipo_adjunto')->name('tipo_adjuntos.store');
        Route::get('/tipo_adjuntos/edit/{tipo_adjunto}', 'edit')->middleware('permission:edit-tipo_adjunto')->name('tipo_adjuntos.edit');
        Route::post('/tipo_adjuntos/update/{tipo_adjunto}', 'update')->middleware('permission:edit-tipo_adjunto')->name('tipo_adjuntos.update');
        Route::get('/tipo_adjuntos/delete/{tipo_adjunto}', 'delete')->middleware('permission:delete-tipo_adjunto')->name('tipo_adjuntos.delete');
    });

    Route::controller(TipoSolicitudController::class)->group(function () {
        Route::get('/tipo_solicitudes/index', 'index')->middleware('permission:show-tipo_solicitud')->name('tipo_solicitudes.index');
        Route::get('/tipo_solicitudes/new', 'new')->middleware('permission:new-tipo_solicitud')->name('tipo_solicitudes.new');
        Route::post('/tipo_solicitudes/store', 'store')->middleware('permission:new-tipo_solicitud')->name('tipo_solicitudes.store');
        Route::get('/tipo_solicitudes/edit/{tipo_solicitud}', 'edit')->middleware('permission:edit-tipo_solicitud')->name('tipo_solicitudes.edit');
        Route::post('/tipo_solicitudes/update/{tipo_solicitud}', 'update')->middleware('permission:edit-tipo_solicitud')->name('tipo_solicitudes.update');
        Route::get('/tipo_solicitudes/delete/{tipo_solicitud}', 'delete')->middleware('permission:delete-tipo_solicitud')->name('tipo_solicitudes.delete');
    });

    Route::controller(TipoPermisoController::class)->group(function () {
        Route::get('/tipo_permisos/index', 'index')->middleware('permission:show-tipo_permiso')->name('tipo_permisos.index');
        Route::get('/tipo_permisos/new', 'new')->middleware('permission:new-tipo_permiso')->name('tipo_permisos.new');
        Route::post('/tipo_permisos/store', 'store')->middleware('permission:new-tipo_permiso')->name('tipo_permisos.store');
        Route::get('/tipo_permisos/edit/{tipo_permiso}', 'edit')->middleware('permission:edit-tipo_permiso')->name('tipo_permisos.edit');
        Route::post('/tipo_permisos/update/{tipo_permiso}', 'update')->middleware('permission:edit-tipo_permiso')->name('tipo_permisos.update');
        Route::get('/tipo_permisos/delete/{tipo_permiso}', 'delete')->middleware('permission:delete-tipo_permiso')->name('tipo_permisos.delete');
    });

    Route::controller(TipoLicenciaController::class)->group(function () {
        Route::get('/tipo_licencias/index', 'index')->middleware('permission:show-tipo_licencia')->name('tipo_licencias.index');
        Route::get('/tipo_licencias/new', 'new')->middleware('permission:new-tipo_licencia')->name('tipo_licencias.new');
        Route::post('/tipo_licencias/store', 'store')->middleware('permission:new-tipo_licencia')->name('tipo_licencias.store');
        Route::get('/tipo_licencias/edit/{tipo_licencia}', 'edit')->middleware('permission:edit-tipo_licencia')->name('tipo_licencias.edit');
        Route::post('/tipo_licencias/update/{tipo_licencia}', 'update')->middleware('permission:edit-tipo_licencia')->name('tipo_licencias.update');
        Route::get('/tipo_licencias/delete/{tipo_licencia}', 'delete')->middleware('permission:delete-tipo_licencia')->name('tipo_licencias.delete');
    });

    Route::controller(GestorController::class)->group(function () {
        Route::get('/gestores/index', 'index')->middleware('permission:show-gestor')->name('gestores.index');
        Route::get('/gestores/new', 'new')->middleware('permission:new-gestor')->name('gestores.new');
        Route::post('/gestores/store', 'store')->middleware('permission:new-gestor')->name('gestores.store');
        Route::get('/gestores/edit/{gestor}', 'edit')->middleware('permission:edit-gestor')->name('gestores.edit');
        Route::post('/gestores/update/{gestor}', 'update')->middleware('permission:edit-gestor')->name('gestores.update');
    });

    Route::controller(SolicitudController::class)->group(function () {
        Route::get('/solicitudes/index/{search?}', 'index')->middleware('permission:show-solicitud')->name('solicitudes.index');
        Route::get('/solicitudes/new', 'new')->middleware('permission:new-solicitud')->name('solicitudes.new');
        Route::post('/solicitudes/store', 'store')->middleware('permission:new-solicitud')->name('solicitudes.store');
        Route::get('/solicitudes/edit/{solicitud}', 'edit')->middleware('permission:edit-solicitud')->name('solicitudes.edit');
        Route::post('/solicitudes/update/{solicitud}', 'update')->middleware('permission:edit-solicitud')->name('solicitudes.update');
        Route::get('/solicitudes/delete/{solicitud}', 'delete')->middleware('permission:delete-solicitud')->name('solicitudes.delete');
        Route::get('/solicitudes/cerrar/{solicitud}', 'cerrar')->middleware('permission:edit-solicitud')->name('solicitudes.cerrar');
    });

    Route::controller(AutorizaSolicitudController::class)->group(function () {
        Route::get('/autoriza_solicitudes/index/{estado?}/{search?}', 'index')->middleware('permission:show-autoriza_solicitud')->name('autoriza_solicitudes.index');
        Route::get('/autoriza_solicitudes/edit/{solicitud}', 'edit')->middleware('permission:edit-autoriza_solicitud')->name('autoriza_solicitudes.edit');
        Route::post('/autoriza_solicitudes/update/{solicitud}', 'update')->middleware('permission:edit-autoriza_solicitud')->name('autoriza_solicitudes.update');
        Route::get('/solicitudes/autorizacion/autorizar/{solicitud}', 'autorizar')->middleware('permission:edit-autoriza_solicitud')->name('autoriza_solicitudes.autorizar');
        Route::post('/solicitudes/autorizacion/rechazar/{solicitud}', 'rechazar')->middleware('permission:edit-autoriza_solicitud')->name('autoriza_solicitudes.rechazar');
    });

    Route::controller(AutorizaSolicitudPermisoController::class)->group(function () {
        Route::get('/autoriza_solicitud_permisos/index/{estado?}/{search?}', 'index')->middleware('permission:show-autoriza_solicitud_permiso')->name('autoriza_solicitud_permisos.index');
        Route::get('/autoriza_solicitud_permisos/edit/{solicitud}', 'edit')->middleware('permission:edit-autoriza_solicitud_permiso')->name('autoriza_solicitud_permisos.edit');
        Route::post('/autoriza_solicitud_permisos/update/{solicitud}', 'update')->middleware('permission:edit-autoriza_solicitud_permiso')->name('autoriza_solicitud_permisos.update');
        Route::get('/solicitudes/permiso/autorizar/{solicitud}', 'autorizar')->middleware('permission:edit-autoriza_solicitud_permiso')->name('autoriza_solicitud_permisos.autorizar');
        Route::post('/solicitudes/permiso/rechazar/{solicitud}', 'rechazar')->middleware('permission:edit-autoriza_solicitud_permiso')->name('autoriza_solicitud_permisos.rechazar');
    });

    Route::controller(ValidacionSolicitudPermisoController::class)->group(function () {
        Route::get('/validacion_solicitud_permisos/index/{estado?}/{search?}', 'index')->middleware('permission:show-validacion_solicitud_permiso')->name('validacion_solicitud_permisos.index');
        Route::get('/validacion_solicitud_permisos/edit/{solicitud}', 'edit')->middleware('permission:edit-validacion_solicitud_permiso')->name('validacion_solicitud_permisos.edit');
        Route::get('/solicitudes/validacion/autorizar/{solicitud}', 'verificar')->middleware('permission:edit-validacion_solicitud_permiso')->name('validacion_solicitud_permisos.autorizar');
    });

    Route::controller(SolicitudVacacionesController::class)->group(function () {
        Route::get('/solicitud_vacaciones/index', 'index')->middleware('permission:show-solicitud_vacacion')->name('solicitud_vacaciones.index');
        Route::get('/solicitud_vacaciones/new', 'new')->middleware('permission:new-solicitud_vacacion')->name('solicitud_vacaciones.new');
        Route::post('/solicitud_vacaciones/store', 'store')->middleware('permission:new-solicitud_vacacion')->name('solicitud_vacaciones.store');
        Route::get('/solicitud_vacaciones/edit/{solicitud}', 'edit')->middleware('permission:edit-solicitud_vacacion')->name('solicitud_vacaciones.edit');
        Route::get('/solicitud_vacaciones/pdf/{fechas}/{permiso}/{detalle}', 'solicitudEnPDF')->middleware('permission:new-solicitud_vacacion')->name('solicitud_vacaciones.pdf');
    });

    Route::controller(AutorizaSolicitudVacacionesController::class)->group(function () {
        Route::get('/autoriza_solicitud_vacaciones/index', 'index')->middleware('permission:show-autoriza_solicitud_vacacion')->name('autoriza_solicitud_vacaciones.index');
        Route::get('/autoriza_solicitud_vacaciones/edit/{solicitud}', 'edit')->middleware('permission:edit-autoriza_solicitud_vacacion')->name('autoriza_solicitud_vacaciones.edit');
        Route::get('/autoriza_solicitud_vacaciones/rechazar/fecha/{solicitud}/{detalle}', 'rechazar')->middleware('permission:edit-autoriza_solicitud_vacacion')->name('autoriza_solicitud_vacaciones.rechazar_fecha');
        Route::post('/autoriza_solicitud_vacaciones/autorizar/{solicitud}', 'autorizaSolicitud')->middleware('permission:edit-autoriza_solicitud_vacacion')->name('autoriza_solicitud_vacaciones.autorizar');
        Route::post('/autoriza_solicitud_vacaciones/rechazar/{solicitud}', 'rechazaSolicitud')->middleware('permission:edit-autoriza_solicitud_vacacion')->name('autoriza_solicitud_vacaciones.rechazar');
    });

    Route::controller(RRHHAutorizaSolicitudVacacionesController::class)->group(function () {
        Route::get('/rrhh_solicitud_vacaciones/index', 'index')->middleware('permission:show-rrhh_solicitud_vacacion')->name('rrhh_solicitud_vacaciones.index');
        Route::get('/rrhh_solicitud_vacaciones/edit/{solicitud}', 'edit')->middleware('permission:edit-rrhh_solicitud_vacacion')->name('rrhh_solicitud_vacaciones.edit');
        Route::get('/rrhh_solicitud_vacaciones/verificar/{solicitud}', 'verificar')->middleware('permission:edit-rrhh_solicitud_vacacion')->name('rrhh_solicitud_vacaciones.verificar');
    });

    Route::controller(PeriodoVacacionesController::class)->group(function () {
        Route::get('/periodo_vacaciones/index', 'index')->middleware('permission:show-periodo_vacacion')->name('periodo_vacaciones.index');
        Route::get('/periodo_vacaciones/calcular', 'calcular')->middleware('permission:show-periodo_vacacion')->name('periodo_vacaciones.calcular');
    });

    Route::controller(BitacoraRequisicionController::class)->group(function () {
        Route::get('/bitacora/requisicion/{requisicion}', 'index')->middleware('check.edit.requisicion')->name('bitacora.requisicion');
    });

    Route::controller(ArchivoRequisicionController::class)->group(function () {
        Route::get('/archivos/requisicion/{requisicion}', 'index')->middleware('check.edit.requisicion')->name('archivos.index');
        Route::post('/archivos/requisicion/store/{requisicion}', 'store')->middleware('check.edit.requisicion')->name('archivos.requisicion');
        Route::get('/archivos/eliminar/{archivo}', 'delete')->middleware('check.edit.requisicion')->name('archivos.delete');
    });

    Route::controller(ConsultaDeRequisicionesController::class)->group(function () {
        Route::get('/consulta/requisicion/launcher', 'launcher')->middleware('permission:show-consulta_requisicion')->name('consulta_requisiciones.lanucher');
        Route::get('/consulta/requisicion/{fecha_inicio}/{fecha_fin}/{ficha}/{centros_costo}/{requisicion}/{estado}', 'index')->middleware('permission:show-consulta_requisicion')->name('consulta_requisiciones.index');
        Route::get('/consulta/requisicion/show/{requisicion}/{fi_param}/{ff_param}/{ficha_param}/{cc_param}/{req_param}/{estado_param}', 'show')->middleware('permission:show-consulta_requisicion')->name('consulta_requisiciones.show');
    });

    Route::controller(ArchivoSolicitudController::class)->group(function () {
        Route::get('/archivos/solicitud/{solicitud}', 'listado')->middleware('permission:edit-solicitud')->name('archivos.solicitud.listado');
        Route::post('/archivos/solicitud/store/{solicitud}', 'store')->middleware('permission:edit-solicitud')->name('archivos.solicitud.store');
        Route::get('/archivos/solicitud/eliminar/{archivo}', 'delete')->middleware('permission:edit-solicitud')->name('archivos.solicitud.delete');
    });

    Route::controller(SolicitudPermisosController::class)->group(function () {
        Route::get('/solicitud/permisos/index/{search?}', 'index')->middleware('permission:show-solicitud_permiso')->name('solicitud_permisos.index');
        Route::get('/solicitud/permisos/new', 'new')->middleware('permission:new-solicitud_permiso')->name('solicitud_permisos.new');
        Route::post('/solicitud/permisos/store', 'store')->middleware('permission:new-solicitud_permiso')->name('solicitud_permisos.store');
        Route::get('/solicitud/permisos/edit/{solicitud}', 'edit')->middleware('permission:edit-solicitud_permiso')->name('solicitud_permisos.edit');
        Route::post('/solicitud/permisos/update/{solicitud}', 'update')->middleware('permission:edit-solicitud_permiso')->name('solicitud_permisos.update');
        Route::get('/solicitud/permisos/delete/{solicitud}', 'delete')->middleware('permission:delete-solicitud_permiso')->name('solicitud_permisos.delete');
        Route::get('/solicitud/permisos/cerrar/{solicitud}', 'cerrar')->middleware('permission:edit-solicitud_permiso')->name('solicitud_permisos.cerrar');
    });

    Route::controller(ArchivoPermisoController::class)->group(function () {
        Route::get('/archivos/permiso/{solicitud}', 'listado')->middleware('permission:edit-solicitud_permiso')->name('archivos.permiso.listado');
        Route::post('/archivos/permiso/store/{solicitud}', 'store')->middleware('permission:edit-solicitud_permiso')->name('archivos.permiso.store');
        Route::get('/archivos/permiso/eliminar/{archivo}', 'delete')->middleware('permission:edit-solicitud_permiso')->name('archivos.permiso.delete');
    });

    Route::controller(ConfiguracionController::class)->group(function () {
        Route::get('/configuraciones/index', 'index')->middleware('permission:show-configuracion')->name('configuraciones.index');
        Route::post('/configuraciones/update', 'update')->middleware('permission:edit-configuracion')->name('configuraciones.update');
    });

    Route::controller(NoticiaController::class)->group(function () {
        Route::get('/noticias/index', 'index')->middleware('permission:show-noticia')->name('noticias.index');
        Route::get('/noticias/new', 'new')->middleware('permission:new-noticia')->name('noticias.new');
        Route::post('/noticias/store', 'store')->middleware('permission:new-noticia')->name('noticias.store');
        Route::get('/noticias/edit/{noticia}', 'edit')->middleware('permission:edit-noticia')->name('noticias.edit');
        Route::post('/noticias/update/{noticia}', 'update')->middleware('permission:new-noticia')->name('noticias.update');
        Route::get('/noticias/delete/{delete}', 'delete')->middleware('permission:delete-noticia')->name('noticias.delete');
    });

    Route::controller(OrganigramaController::class)->group(function () {
        Route::get('/organigramas/index', 'index')->middleware('permission:show-organigrama')->name('organigramas.index');
        Route::get('/organigramas/new', 'new')->middleware('permission:new-organigrama')->name('organigramas.new');
        Route::post('/organigramas/store', 'store')->middleware('permission:new-organigrama')->name('organigramas.store');
        Route::get('/organigramas/edit/{organigrama}', 'edit')->middleware('permission:edit-organigrama')->name('organigramas.edit');
    });

    Route::controller(VisualizadorOrganigramaController::class)->group(function () {
        Route::get('/visualizador-organigramas/index', 'index')->middleware('permission:show-visualizar_organigrama')->name('visualizador_organigramas.index');
        Route::get('/visualizador-organigramas/show/{organigrama}', 'show')->middleware('permission:show-visualizar_organigrama')->name('visualizador_organigramas.show');
    });

    Route::controller(NodoController::class)->group(function () {
        Route::get('/nodos/index/{organigrama}', 'index')->middleware('check.data.organigrama')->name('nodos.index');
        Route::post('/nodos/store/{organigrama}', 'store')->middleware('check.data.organigrama')->name('nodos.store');
        Route::post('/nodos/update/{nodo}', 'update')->middleware('check.data.organigrama')->name('nodos.update');
        Route::get('/nodos/delete/{nodo}', 'delete')->middleware('check.data.organigrama')->name('nodos.delete');
        Route::post('/nodos/update/position/{nodo}', 'updatePosition')->middleware('check.data.organigrama')->name('nodos.update.position');
    });

    Route::controller(ConexionNodoController::class)->group(function () {
        Route::get('/conexiones/index/{organigrama}', 'index')->middleware('check.data.organigrama')->name('conexiones.index');
        Route::post('/conexiones/store/{organigrama}', 'store')->middleware('check.data.organigrama')->name('conexiones.store');
        Route::get('/conexiones/delete/{conexion}', 'delete')->middleware('check.data.organigrama')->name('conexiones.delete');
    });

    Route::controller(IntegranteNodoController::class)->group(function () {
        Route::get('/integrantes/index/{nodo}', 'index')->middleware('check.data.organigrama')->name('integrantes.index');
        Route::post('/integrantes/store/{nodo}', 'store')->middleware('check.data.organigrama')->name('integrantes.store');
        Route::post('/integrantes/update/{integrante}', 'update')->middleware('check.data.organigrama')->name('integrantes.update');
        Route::get('/integrantes/delete/{integrante}', 'delete')->middleware('check.data.organigrama')->name('integrantes.delete');
    });

    Route::controller(ResponsabilidadNodoController::class)->group(function () {
        Route::get('/responsabilidades/index/{nodo}', 'index')->middleware('check.data.organigrama')->name('responsabilidades.index');
        Route::post('/responsabilidades/store/{nodo}', 'store')->middleware('check.data.organigrama')->name('responsabilidades.store');
        Route::post('/responsabilidades/update/{responsabilidad}', 'update')->middleware('check.data.organigrama')->name('responsabilidades.update');
        Route::get('/responsabilidades/delete/{responsabilidad}', 'delete')->middleware('check.data.organigrama')->name('responsabilidades.delete');
    });

    Route::controller(BandejaDeNoticiaController::class)->group(function () {
        Route::get('/noticias/bandeja', 'index')->name('noticias.bandeja');
        Route::get('/noticias/listado', 'obtenerNotificaciones')->name('noticias.listado');
        Route::post('/noticias/vista', 'marcarVista')->name('noticias.vista');
    });

    Route::controller(ConfiguracionUsuarioController::class)->group(function () {
        Route::post('/configuracion/bandeja_noticias', 'mostrarBandejaNoticias')->name('configuracion.bandeja_noticias');
    });

    Route::controller(CalendarioAniversarioController::class)->group(function () {
        Route::get('/aniversarios/index', 'index')->middleware('permission:show-anniversary')->name('aniversarios.index');
        Route::get('/aniversarios/listado', 'obtenerAniversarios')->middleware('permission:show-anniversary')->name('aniversarios.listado');
    });

    Route::controller(CalendarioCumpleaniosController::class)->group(function () {
        Route::get('/cumpleanios/index', 'index')->middleware('permission:show-birthday')->name('cumpleanios.index');
        Route::get('/cumpleanios/listado', 'obtenerCumpleanios')->middleware('permission:show-birthday')->name('cumpleanios.listado');
    });

    Route::controller(LicenciaController::class)->group(function () {
        Route::get('/licencias/index/{search?}', 'index')->middleware('permission:show-licencia')->name('licencias.index');
        Route::get('/licencias/new', 'new')->middleware('permission:new-licencia')->name('licencias.new');
        Route::post('/licencias/store', 'store')->middleware('permission:new-licencia')->name('licencias.store');
        Route::get('/licencias/edit/{licencia}', 'edit')->middleware('permission:edit-licencia')->name('licencias.edit');
        Route::post('/licencias/update/{licencia}', 'update')->middleware('permission:edit-licencia')->name('licencias.update');
        Route::get('/licencias/cerrar/{licencia}', 'cerrar')->middleware('permission:edit-licencia')->name('licencias.cerrar');
        Route::get('/licencias/reporte/{licencia}', 'solicitudEnPDF')->middleware('permission:edit-licencia')->name('licencias.reporte');
        Route::post('/licencias/adjunto/{licencia}', 'adjunto')->middleware('permission:edit-licencia')->name('licencias.adjunto');
    });

    Route::controller(AutorizacionLicenciaController::class)->group(function () {
        Route::get('/autoriza_licencia/index/{search?}', 'index')->middleware('permission:show-autoriza_licencia')->name('autoriza_licencias.index');
        Route::get('/autoriza_licencia/edit/{licencia}', 'edit')->middleware('permission:edit-autoriza_licencia')->name('autoriza_licencias.edit');
        Route::post('/autoriza_licencia/update/{licencia}', 'update')->middleware('permission:edit-autoriza_licencia')->name('autoriza_licencias.update');
        Route::get('/licencia/autorizar/{licencia}', 'autorizar')->middleware('permission:edit-autoriza_licencia')->name('autoriza_licencias.autorizar');
        Route::post('/licencia/rechazar/{licencia}', 'rechazar')->middleware('permission:edit-autoriza_licencia')->name('autoriza_licencias.rechazar');
    });

    Route::controller(ValidacionLicenciaController::class)->group(function () {
        Route::get('/validar_licencia/index/{search?}', 'index')->middleware('permission:show-validar_licencia')->name('validar_licencias.index');
        Route::get('/validar_licencia/edit/{licencia}', 'edit')->middleware('permission:edit-validar_licencia')->name('validar_licencias.edit');
        Route::post('/validar_licencia/update/{licencia}', 'update')->middleware('permission:edit-validar_licencia')->name('validar_licencias.update');
        Route::get('/validar_licencia/autorizar/{licencia}', 'autorizar')->middleware('permission:edit-validar_licencia')->name('validar_licencias.autorizar');
        Route::post('/validar_licencia/rechazar/{licencia}', 'rechazar')->middleware('permission:edit-validar_licencia')->name('validar_licencias.rechazar');
    });

    Route::controller(FeriadoController::class)->group(function () {
        Route::get('/feriados/index', 'index')->middleware('permission:show-feriado')->name('feriados.index');
        Route::get('/feriados/new', 'new')->middleware('permission:new-feriado')->name('feriados.new');
        Route::post('/feriados/store', 'store')->middleware('permission:new-feriado')->name('feriados.store');
        Route::get('/feriados/edit/{feriado}', 'edit')->middleware('permission:edit-feriado')->name('feriados.edit');
        Route::post('/feriados/update/{feriado}', 'update')->middleware('permission:edit-feriado')->name('feriados.update');
        Route::get('/feriados/delete/{feriado}', 'delete')->middleware('permission:delete-feriado')->name('feriados.delete');
    });


    Route::get('/descargar-archivo/{archivo}', function ($archivo) {
        if (!auth()->check()) {
            abort(403, 'No tienes permiso para acceder a este archivo');
        }

        $rutaArchivo = storage_path('app/archivos_requisicion/' . $archivo);

        if (!file_exists($rutaArchivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($rutaArchivo);
    })->middleware('auth')->name('descargar.archivo');


    Route::get('/descargar-adjunto/{ficha}/{archivo}', function ($ficha, $archivo) {
        if (!auth()->check()) {
            abort(403, 'No tienes permiso para acceder a este archivo');
        }

        $rutaArchivo = storage_path('app/adjuntos/' . $ficha . '/' . $archivo);

        if (!file_exists($rutaArchivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($rutaArchivo);
    })->middleware('auth')->name('descargar.adjunto');

    Route::get('/ficha/seleccionar/{ficha}', function ($ficha) {
        $fichas = Auth::user()->fichas;
        if (!$fichas->contains($ficha)) {
            return redirect()->route('dashboard')->with(['status' => 'error', 'message' => 'Ficha not found!']);
        }

        DB::table('ficha_activa')->updateOrInsert(
            ['usuario_id' => Auth::id()],
            ['ficha_id' => $ficha]
        );

        return back()->with(['status' => 'success', 'message' => 'Ficha was successfully selected!']);

    })->name('fichas.seleccionar');

    Route::get('/download/file/{directorio?}', function ($directorio) {
        if (!auth()->check()) {
            abort(403, 'No tienes permiso para acceder a este archivo');
        }

        $rutaArchivo = storage_path("app/" . base64_decode($directorio));

        if (!file_exists($rutaArchivo)) {
            abort(404, 'Archivo no encontrado');
        }

        return response()->download($rutaArchivo);
    })->middleware('auth')->name('download.file');
});

require __DIR__.'/auth.php';
