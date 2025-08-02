<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            ['name' => 'Ver Permiso', 'code' => 'show-permission'],
            ['name' => 'Nuevo Permiso', 'code' => 'new-permission'],
            ['name' => 'Editar Permiso', 'code' => 'edit-permission'],
            ['name' => 'Eliminar Permiso', 'code' => 'delete-permission'],
            ['name' => 'Ver Rol', 'code' => 'show-role'],
            ['name' => 'Nuevo Rol', 'code' => 'new-role'],
            ['name' => 'Editar Rol', 'code' => 'edit-role'],
            ['name' => 'Eliminar Rol', 'code' => 'delete-role'],
            ['name' => 'Ver Usuario', 'code' => 'show-user'],
            ['name' => 'Nuevo Usuario', 'code' => 'new-user'],
            ['name' => 'Editar Usuario', 'code' => 'edit-user'],
            ['name' => 'Eliminar Usuario', 'code' => 'delete-user'],
            ['name' => 'Ver Ficha', 'code' => 'show-ficha'],
            ['name' => 'Editar Ficha', 'code' => 'edit-ficha'],
            ['name' => 'Ver Recibo', 'code' => 'show-reporte_recibo'],

            ['name' => 'Ver Requisición', 'code' => 'show-requisicion'],
            ['name' => 'Nueva Requisición', 'code' => 'new-requisicion'],
            ['name' => 'Editar Requisición', 'code' => 'edit-requisicion'],
            ['name' => 'Eliminar Requisición', 'code' => 'delete-requisicion'],


            ['name' => 'Filtro Fichas', 'code' => 'show-multiple_ficha'],
            ['name' => 'Ver Adjuntos', 'code' => 'show-adjunto'],
            ['name' => 'Ver Tipo de Documento', 'code' => 'show-tipo_adjunto'],
            ['name' => 'Nuevo Tipo de Documento', 'code' => 'new-tipo_adjunto'],
            ['name' => 'Editar Tipo de Documento', 'code' => 'edit-tipo_adjunto'],
            ['name' => 'Eliminar Tipo de Documento', 'code' => 'delete-tipo_adjunto'],
            ['name' => 'Ver Configuraciones', 'code' => 'show-configuracion'],
            ['name' => 'Editar Configuraciones', 'code' => 'edit-configuracion'],
            ['name' => 'Ver Tipo Solicitud', 'code' => 'show-tipo_solicitud'],
            ['name' => 'Nueva Tipo Solicitud', 'code' => 'new-tipo_solicitud'],
            ['name' => 'Editar Tipo Solicitud', 'code' => 'edit-tipo_solicitud'],
            ['name' => 'Eliminar Tipo Solicitud', 'code' => 'delete-tipo_solicitud'],
            ['name' => 'Ver Solicitud', 'code' => 'show-solicitud'],
            ['name' => 'Nueva Solicitud', 'code' => 'new-solicitud'],
            ['name' => 'Editar Solicitud', 'code' => 'edit-solicitud'],
            ['name' => 'Eliminar Solicitud', 'code' => 'delete-solicitud'],
            ['name' => 'Ver Autoriza Solicitud', 'code' => 'show-autoriza_solicitud'],
            ['name' => 'Editar Autoriza Solicitud', 'code' => 'edit-autoriza_solicitud'],
            ['name' => 'Ver Periodos de vacaciones', 'code' => 'show-periodo_vacacion'],
            ['name' => 'Ver Solicitud de Vacaciones', 'code' => 'show-solicitud_vacacion'],
            ['name' => 'Nueva Solicitud de Vacaciones', 'code' => 'new-solicitud_vacacion'],
            ['name' => 'Editar Solicitud de Vacaciones', 'code' => 'edit-solicitud_vacacion'],
            ['name' => 'Ver Solicitud de Vacaciones para Autorizar', 'code' => 'show-autoriza_solicitud_vacacion'],
            ['name' => 'Editar Solicitud de Vacaciones para Autorizar', 'code' => 'edit-autoriza_solicitud_vacacion'],
            ['name' => 'Ver Solicitud de Vacaciones para RRHH', 'code' => 'show-rrhh_solicitud_vacacion'],
            ['name' => 'Editar Solicitud de Vacaciones para RRHH', 'code' => 'edit-rrhh_solicitud_vacacion'],
            ['name' => 'Ver Noticias', 'code' => 'show-noticia'],
            ['name' => 'Nueva Noticias', 'code' => 'new-noticia'],
            ['name' => 'Editar Noticias', 'code' => 'edit-noticia'],
            ['name' => 'Eliminar Noticias', 'code' => 'delete-noticia'],
            ['name' => 'Ver Cumpleañeros', 'code' => 'show-birthday'],
            ['name' => 'Ver Aniversarios', 'code' => 'show-anniversary'],

            ['name' => 'Ver Autorización de Requisición Jefe', 'code' => 'show-autoriza-jefe'],
            ['name' => 'Editar Autorización de Requisición Jefe', 'code' => 'edit-autoriza-jefe'],

            ['name' => 'Ver Autorización de Requisición Presupuesto', 'code' => 'show-autoriza-ppto'],
            ['name' => 'Editar Autorización de Requisición Presupuesto', 'code' => 'edit-autoriza-ppto'],

            ['name' => 'Ver Autorización de Requisición Tesoreria', 'code' => 'show-autoriza-tesoreria'],
            ['name' => 'Editar Autorización de Requisición Tesoreria', 'code' => 'edit-autoriza-tesoreria'],

            ['name' => 'Ver Catalogo de Gestores', 'code' => 'show-gestor'],
            ['name' => 'Nueva Catalogo de Gestores', 'code' => 'new-gestor'],
            ['name' => 'Editar Catalogo de Gestores', 'code' => 'edit-gestor'],

            ['name' => 'Ver Autorización de Requisición Compras', 'code' => 'show-autoriza-compra'],
            ['name' => 'Editar Autorización de Requisición Compras', 'code' => 'edit-autoriza-compra'],

            ['name' => 'Ver Autorización de Requisición Gestor', 'code' => 'show-autoriza-gestor'],
            ['name' => 'Editar Autorización de Requisición Gestor', 'code' => 'edit-autoriza-gestor'],

            ['name' => 'Ver Autorización de Requisición Comite', 'code' => 'show-autoriza-comite'],
            ['name' => 'Editar Autorización de Requisición Comite', 'code' => 'edit-autoriza-comite'],

            ['name' => 'Ver Consulta de Requisiciones', 'code' => 'show-consulta_requisicion'],

            ['name' => 'Ver Consulta de bitacora', 'code' => 'show-reporte_bitacora'],
            ['name' => 'Ver Reporte de ficha de responsabilidad', 'code' => 'show-reporte_responsabilidad'],

            ['name' => 'Ver Organigrama', 'code' => 'show-organigrama'],
            ['name' => 'Nueva Organigrama', 'code' => 'new-organigrama'],
            ['name' => 'Editar Organigrama', 'code' => 'edit-organigrama'],

            ['name' => 'Visualizaror de Organigramas', 'code' => 'show-visualizar_organigrama'],

            ['name' => 'Ver Licencia', 'code' => 'show-licencia'],
            ['name' => 'Nueva Licencia', 'code' => 'new-licencia'],
            ['name' => 'Editar Licencia', 'code' => 'edit-licencia'],

            ['name' => 'Ver Autorización de Licencia', 'code' => 'show-autoriza_licencia'],
            ['name' => 'Editar Autorización de Licencia', 'code' => 'edit-autoriza_licencia'],

            ['name' => 'Ver Validacion de Licencia', 'code' => 'show-validar_licencia'],
            ['name' => 'Editar Validacion de Licencia', 'code' => 'edit-validar_licencia'],

            ['name' => 'Ver Orden de compra', 'code' => 'show-orden_compra'],
            ['name' => 'Nueva Orden de compra', 'code' => 'new-orden_compra'],
            ['name' => 'Editar Orden de compra', 'code' => 'edit-orden_compra'],

            ['name' => 'Ver Documentos', 'code' => 'show-documento'],
            ['name' => 'Nueva Documentos', 'code' => 'new-documento'],
            ['name' => 'Editar Documentos', 'code' => 'edit-documento'],

            ['name' => 'Ver Usuarios Externos', 'code' => 'show-externo'],
            ['name' => 'Nueva Usuarios Externos', 'code' => 'new-externo'],
            ['name' => 'Editar Usuarios Externos', 'code' => 'edit-externo'],
            ['name' => 'Eliminar Usuarios Externos', 'code' => 'delete-externo'],

            ['name' => 'Ver Ordenes de Compra Externos', 'code' => 'show-orden_compra_proveedor'],
            ['name' => 'Editar Ordenes de Compra Externos', 'code' => 'edit-orden_compra_proveedor'],

            ['name' => 'Ver Documentos Externos', 'code' => 'show-documento_proveedor'],
            ['name' => 'Nueva Documentos Externos', 'code' => 'new-documento_proveedor'],
            ['name' => 'Editar Documentos Externos', 'code' => 'edit-documento_proveedor'],

            ['name' => 'Ver Feriados', 'code' => 'show-feriado'],
            ['name' => 'Nuevo Feriado', 'code' => 'new-feriado'],
            ['name' => 'Editar Feriados', 'code' => 'edit-feriado'],
            ['name' => 'Eliminar Feriados', 'code' => 'delete-feriado'],

            ['name' => 'Ver Tipo Permiso', 'code' => 'show-tipo_permiso'],
            ['name' => 'Nueva Tipo Permiso', 'code' => 'new-tipo_permiso'],
            ['name' => 'Editar Tipo Permiso', 'code' => 'edit-tipo_permiso'],
            ['name' => 'Eliminar Tipo Permiso', 'code' => 'delete-tipo_permiso'],

            ['name' => 'Ver Solicitud de Permiso', 'code' => 'show-solicitud_permiso'],
            ['name' => 'Nueva Solicitud de Permiso', 'code' => 'new-solicitud_permiso'],
            ['name' => 'Editar Solicitud de Permiso', 'code' => 'edit-solicitud_permiso'],

            ['name' => 'Ver Autoriza Solicitud de Permisos', 'code' => 'show-autoriza_solicitud_permiso'],
            ['name' => 'Editar Autoriza Solicitud de Permisos', 'code' => 'edit-autoriza_solicitud_permiso'],

            ['name' => 'Ver Validacion Solicitud de Permisos', 'code' => 'show-validacion_solicitud_permiso'],
            ['name' => 'Editar Validacion Solicitud de Permisos', 'code' => 'edit-validacion_solicitud_permiso'],

            ['name' => 'Ver Tipo Licencia', 'code' => 'show-tipo_licencia'],
            ['name' => 'Nueva Tipo Licencia', 'code' => 'new-tipo_licencia'],
            ['name' => 'Editar Tipo Licencia', 'code' => 'edit-tipo_licencia'],
            ['name' => 'Eliminar Tipo Licencia', 'code' => 'delete-tipo_licencia'],

        ];






        foreach ($permisos as $permiso) {
            $codigo = $permiso['code'];
            $nombre = $permiso['name'];

            Permission::updateOrCreate(
                ['code' => $codigo],
                ['name' => $nombre, 'created_at' => date('Y-m-dTH:i:s'), 'updated_at' => date('Y-m-dTH:i:s')],
            );
        }
    }
}
