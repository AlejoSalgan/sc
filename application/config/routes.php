<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "login";
$route['404_override'] = 'errors/page_not_found';
$route['usuarios/(:num)'] = 'usuarios/ver_detalles/$1';
$route['usuarios/editar_usuario'] = 'usuarios/editar_usuario/';
$route['usuarios'] = 'usuarios';
$route['usuarios/crear_usuario'] = 'usuarios/crear_usuario';

/*********** USER DEFINED ROUTES *******************/
$route['recuperar'] = 'recuperar/recuperarPass';
$route['reset'] = 'recuperar/resetPass';

/*********** vista para extraccion de info en produccion *******************/
$route['test'] = 'test';

$route['loginMe'] = 'login/loginMe';
$route['landing'] = 'landing';

// 1. INICIO/Panel de información mantener
$route['dashboard'] = 'dashboard';

$route['logout'] = 'user/logout';
$route['userListing'] = 'user/userListing';
$route['userListing/(:num)'] = "user/userListing/$1";
$route['verPersonal/(:num)'] = "user/verPersonal/$1";

// 52. PERSONAL/Personal/Usuarios mantener
// 53. PERSONAL/Personal/Empleados mantener
$route['userListing/(:num)/(:num)'] = "user/userListing/$1/$2";

$route['agregar_usuario'] = "user/agregar_usuario";
$route['agregar_empleado'] = "user/agregar_empleado";

$route['editar_usuario'] = "user/editar_usuario";
$route['editar_usuario/(:num)'] = "user/editar_usuario/$1";

$route['editar_empleado'] = "user/editar_empleado";
$route['editar_empleado/(:num)'] = "user/editar_empleado/$1";

$route['agregar_editar_usuario'] = "user/agregar_editar_usuario";

$route['ver_permisos'] = "user/ver_permisos";
$route['ver_permisos/(:num)'] = "user/ver_permisos/$1";

$route['agregar_permisos'] = "user/agregar_permisos";

$route['deleteUser'] = "user/deleteUser";
$route['loadChangePass'] = "user/loadChangePass";
$route['changePassword'] = "user/changePassword";

$route['solicitudes_app'] = "user/solicitudes_app";
$route['solicitudes_app/(:num)'] = "user/solicitudes_app/$1";

$route['mensajes_app'] = "user/mensajes_app";

// 54. PERSONAL/Personal/Acceso mantener
$route['acceso_listado'] = "user/acceso_listado";
$route['acceso_listado/(:num)'] = "user/acceso_listado/$1";

$route['agregar_acceso'] = "user/agregar_acceso";

$route['agregar_editar_accesos'] = "user/agregar_editar_accesos";

$route['ver_acceso'] = "user/ver_acceso";
$route['ver_acceso/(:num)'] = "user/ver_acceso/$1";

$route['agregar_permiso'] = "user/agregar_permiso";

$route['eliminar_permiso'] = "user/eliminar_permiso";
$route['eliminar_permiso/(:num)'] = "user/eliminar_permiso/$1";

$route['password_random'] = 'user/password_random';

/*********** EQUIPOS DEFINED ROUTES *******************/

// 2. EQUIPOS/Equipos/Equipos mantener
$route['equiposListing'] = 'equipos/equiposListing'; 

$route['equiposListing/(:num)'] = "equipos/equiposListing/$1";

$route['agregar_equipo'] = "equipos/agregar_equipo";
$route['addNewEquipo'] = "equipos/addNewEquipo";

$route['editar_equipo'] = "equipos/editar_equipo";
$route['editar_equipo/(:num)'] = "equipos/editar_equipo/$1";
$route['editEquipo'] = "equipos/editEquipo";

$route['desactivar_equipo'] = "equipos/desactivar_equipo";

$route['verEquipo/(:num)'] = "equipos/verEquipo/$1";

$route['aprobar_equipo'] = "modeloseq/aprobar_equipo";

$route['solicitud_bajada'] = "equipos/solicitud_bajada";

// xx. EQUIPOS/Equipos/Equipos | "enlace.Ver historial"
$route['historial/historialEqListing/(:num)'] = "historial/historialEqListing/$1";

/*********** COMPONENTES SERIE DEFINED ROUTES *******************/

$route['editEvento'] = "eventos/editEvento";

/*********** COMPONENTES SERIE DEFINED ROUTES *******************/

// 9. EQUIPOS/Componentes/Componentes mantener
$route['componentesListing'] = 'componentes/componentesListing';
$route['componentesListing/(:num)'] = "componentes/componentesListing/$1";
$route['addNewComp'] = "componentes/addNewComp";

$route['addNewComponente'] = "componentes/addNewComponente";
$route['editOldComponente'] = "componentes/editOldComponente";
$route['editOldComponente/(:num)'] = "componentes/editOldComponente/$1";
$route['editComponente'] = "componentes/editComponente";
$route['deleteComponente'] = "componentes/deleteComponente";
$route['deleteCompRelacion'] = "componentes/deleteCompRelacion";

// 10. EQUIPOS/Componentes/Sin asignar mantener
$route['compNoAsigListing'] = "componentes/compNoAsigListing";
$route['compNoAsigListing/(:num)'] = "componentes/compNoAsigListing/$1";

/*********** COMPONENTES SIN SERIE DEFINED ROUTES *******************/

$route['addNewComp2'] = "componentes/addNewComp2";

$route['addNewComponente2'] = "componentes/addNewComponente2";
$route['editOldComponente2'] = "componentes/editOldComponente2";
$route['editOldComponente2/(:num)/(:num)'] = "componentes/editOldComponente2/$1/$2";
$route['editComponente2'] = "componentes/editComponente2";
$route['deleteComponente2'] = "componentes/deleteComponente2";
$route['deleteCompRelacion2'] = "componentes/deleteCompRelacion2";

$route['asigComponente'] = "componentes/asigComponente";
$route['guardarAsigComp'] = "componentes/guardarAsigComp";

/*********** COMPONENTES SIN SERIE DEFINED ROUTES *******************/

$route['addNewComp2'] = "componentes/addNewComp2";

$route['addNewComponente2'] = "componentes/addNewComponente2";
$route['editOldComponente2'] = "componentes/editOldComponente2";
$route['editOldComponente2/(:num)/(:num)'] = "componentes/editOldComponente2/$1/$2";
$route['editComponente2'] = "componentes/editComponente2";
$route['deleteComponente2'] = "componentes/deleteComponente2";
$route['deleteCompRelacion2'] = "componentes/deleteCompRelacion2";

/*********** TIPOS Equipos DEFINED ROUTES *******************/

// 4. EQUIPOS/Equipos/Tipos mantener
$route['tiposeqListing'] = 'tiposeq/tiposeqListing';
$route['tiposeqListing/(:num)'] = "tiposeq/tiposeqListing/$1";
$route['addNewTipoeq'] = "tiposeq/addNewTipoeq";

$route['addNewTipoequipo'] = "tiposeq/addNewTipoequipo";
$route['editOldTipoeq'] = "tiposeq/editOldTipoeq";
$route['editOldTipoeq/(:num)'] = "tiposeq/editOldTipoeq/$1";
$route['editTipoeq'] = "tiposeq/editTipoeq";
$route['deleteTipoeq'] = "tiposeq/deleteTipoeq";

/*********** MARCAS Equipos DEFINED ROUTES *******************/

// 3. EQUIPOS/Equipos/Marcas mantener
$route['marcaseqListing'] = 'marcaseq/marcaseqListing';
$route['marcaseqListing/(:num)'] = "marcaseq/marcaseqListing/$1";

$route['agregar_marcaEQ'] = "marcaseq/agregar_marcaEQ";

$route['editar_marcaEQ'] = "marcaseq/editar_marcaEQ";
$route['editar_marcaEQ/(:num)'] = "marcaseq/editar_marcaEQ/$1";

$route['agregar_editar_marcaEQ'] = "marcaseq/agregar_editar_marcaEQ";
$route['deleteMarcaeq'] = "marcaseq/deleteMarcaeq";

/*********** TIPOS Componentes DEFINED ROUTES *******************/

// 12. EQUIPOS/Componentes/Tipos mantener
$route['tiposcompListing'] = 'tiposcomp/tiposcompListing';
$route['tiposcompListing/(:num)'] = "tiposcomp/tiposcompListing/$1";
$route['addNewTipocomp'] = "tiposcomp/addNewTipocomp";

$route['addNewTipocomponente'] = "tiposcomp/addNewTipocomponente";
$route['editOldTipocomp'] = "tiposcomp/editOldTipocomp";
$route['editOldTipocomp/(:num)'] = "tiposcomp/editOldTipocomp/$1";
$route['editTipocomp'] = "tiposcomp/editTipocomp";
$route['deleteTipocomp'] = "tiposcomp/deleteTipocomp";

/*********** MARCAS Componentes DEFINED ROUTES *******************/

// 11. EQUIPOS/Componentes/Marcas mantener
$route['marcascompListing'] = 'marcascomp/marcascompListing';
$route['marcascompListing/(:num)'] = "marcascomp/marcascompListing/$1";
$route['addNewMarcacomp'] = "marcascomp/addNewMarcacomp";

$route['addNewMarcacomponente'] = "marcascomp/addNewMarcacomponente";
$route['editOldMarcacomp'] = "marcascomp/editOldMarcacomp";
$route['editOldMarcacomp/(:num)'] = "marcascomp/editOldMarcacomp/$1";
$route['editMarcacomp'] = "marcascomp/editMarcacomp";
$route['deleteMarcacomp'] = "marcascomp/deleteMarcacomp";

/*********** MODELOS Equipos DEFINED ROUTES *******************/

// 5. EQUIPOS/Equipos/Modelos mantener
$route['modeloseqListing'] = 'modeloseq/modeloseqListing';
$route['modeloseqListing/(:num)'] = "modeloseq/modeloseqListing/$1";
$route['addNewModeloeq'] = "modeloseq/addNewModeloeq";

$route['addNewModeloequipo'] = "modeloseq/addNewModeloequipo";
$route['editOldModeloeq'] = "modeloseq/editOldModeloeq";
$route['editOldModeloeq/(:num)'] = "modeloseq/editOldModeloeq/$1";
$route['editModeloeq'] = "modeloseq/editModeloeq";
$route['deleteModeloeq'] = "modeloseq/deleteModeloeq";

/*********** Municipios DEFINED ROUTES *******************/

// 2. PROYECTOS/Proyectos
$route['municipiosListing'] = 'municipios/municipiosListing';
$route['municipiosListing/(:num)'] = "municipios/municipiosListing/$1";

// 2. PROYECTOS/Proyectos/*
$route['ver_proyecto/(:num)'] = "municipios/ver_proyecto/$1";

$route['agregar_proyecto'] = "municipios/agregar_proyecto";
$route['agregar_editar_proyecto'] = "municipios/agregar_editar_proyecto";
$route['editar_proyecto/(:num)'] = "municipios/editar_proyecto/$1";
$route['editar_proyecto'] = "municipios/editar_proyecto";

$route['estado_remoto'] = "municipios/estado_remoto";
$route['estado_proyecto'] = "municipios/estado_proyecto";

$route['proyecto_asignaciones/(:num)'] = "municipios/proyecto_asignaciones/$1";
$route['proyecto_asignaciones'] = "municipios/proyecto_asignaciones";

$route['agregar_asignacion'] = "municipios/agregar_asignacion";

$route['getAsignacion/(:num)'] = "municipios/getAsignacion/$1";
$route['getAsignacion'] = "municipios/getAsignacion";

$route['eliminar_asignacion/(:num)'] = "municipios/eliminar_asignacion/$1";
$route['eliminar_asignacion'] = "municipios/eliminar_asignacion";

$route['estado_prioridad/(:num)'] = "municipios/estado_prioridad/$1";
$route['estado_prioridad'] = "municipios/estado_prioridad";

/////////////////////////////////////////////////////////////

$route['addNewMunicipio2'] = "municipios/addNewMunicipio2";
$route['editOldMunicipio'] = "municipios/editOldMunicipio";
$route['editOldMunicipio/(:num)'] = "municipios/editOldMunicipio/$1";
$route['editMunicipio'] = "municipios/editMunicipio";
$route['deleteMunicipio'] = "municipios/deleteMunicipio";
$route['addNewMunicipio'] = "municipios/addNewMunicipio";


/*********** Propietarios DEFINED ROUTES *******************/

// 6. EQUIPOS/Equipos/Propietarios mantener
$route['propietariosListing'] = 'propietarios/propietariosListing';
$route['propietariosListing/(:num)'] = "propietarios/propietariosListing/$1";
$route['addNewPropietario'] = "propietarios/addNewPropietario";

$route['addNewPropietario2'] = "propietarios/addNewPropietario2";
$route['editOldPropietario'] = "propietarios/editOldPropietario";
$route['editOldPropietario/(:num)'] = "propietarios/editOldPropietario/$1";
$route['editPropietario'] = "propietarios/editPropietario";
$route['deletePropietario'] = "propietarios/deletePropietario";

/*********** Ordenes bajada DEFINED ROUTES *******************/

$route['agregar_orden'] = "ordenesb/agregar_orden";
$route['editar_orden'] = "ordenesb/editar_orden";
$route['editar_orden/(:num)'] = "ordenesb/editar_orden/$1";
$route['agregar_editar_ordenes'] = "ordenesb/agregar_editar_ordenes";
$route['verOrdenb/(:num)'] = "ordenesb/verOrdenb/$1";

$route['deleteOrdenesb'] = "ordenesb/deleteOrdenesb";
$route['enviarOrdenesb'] = "ordenesb/enviarOrdenesb";
$route['cancelarEnvOrdenesb'] = "ordenesb/cancelarEnvOrdenesb";
$route['anularOrden'] = "ordenesb/anularOrden";

$route['gruposSR'] = 'ordenesb/gruposSR';
$route['gruposSP'] = 'ordenesb/gruposSP';
$route['gruposPFC'] = 'ordenesb/gruposPFC';

$route['grupos_equipos'] = "ordenesb/grupos_equipos";
$route['grupos_equipos/(:num)'] = "ordenesb/grupos_equipos/$1";
$route['grupos_equipos/(:num)/(:num)/(:num)/(:num-:num-:num)'] = "ordenesb/grupos_equipos/$1/$2/$3/$4";

$route['grupos_edit'] = "ordenesb/grupos_edit";
$route['grupos_edit/(:num)'] = "ordenesb/grupos_edit/$1";
$route['grupos_edit/(:num)/(:num)/(:num)/(:num-:num-:num)'] = "ordenesb/grupos_edit/$1/$2/$3/$4";

$route['gruposEditAprob'] = "ordenesb/gruposEditAprob";

$route['cancelarEnvOrdenesG'] = "ordenesb/cancelarEnvOrdenesG";
$route['cancelarEnvOrdenesG/(:num)'] = "ordenesb/cancelarEnvOrdenesG/$1";
$route['cancelarEnvOrdenesG/(:num)/(:num)/(:num)/(:num-:num-:num)'] = "ordenesb/cancelarEnvOrdenesG/$1/$2/$3/$4";

$route['limpiarCelular'] = "ordenesb/limpiarCelular";

$route['enviarTodo'] = "ordenesb/enviarTodo";
$route['enviarTodo/(:num)'] = "ordenesb/enviarTodo/$1";
$route['enviarTodo/(:num)/(:num)/(:num-:num-:num)'] = "ordenesb/enviarTodo/$1/$2/$3";

$route['actualizar_orden'] = "ordenesb/actualizar_orden";

$route['liberar_bajada/(:num)/(:num)'] = "ordenesb/liberar_bajada/$1/$2";

$route['equipos_enlace'] = "ordenesb/equipos_enlace";

/*********** Protocolos DEFINED ROUTES *******************/

$route['OldProprotocolos_editartocolos'] = "protocolos/protocolos_editar";
$route['protocolos_editar/(:num)'] = "protocolos/protocolos_editar/$1";
$route['editProtocolos'] = "protocolos/editProtocolos";

$route['verProtocolos/(:num)'] = "protocolos/verProtocolos/$1";

$route['anular_protocolo'] = 'protocolos/anular_protocolo';
$route['finalizar_protocolo'] = 'protocolos/finalizar_protocolo';

// fotos desencriptadas
$route['protocolos_decripto'] = 'protocolos/protocolos_decripto';

$route['protocolos_registros'] = 'protocolos/protocolos_registros';

$route['agregar_remoto'] = 'protocolos/agregar_remoto';

$route['addRemoto'] = 'protocolos/addRemoto';

$route['protocolos_equipos'] = 'protocolos/protocolos_equipos';
$route['anular_remoto'] = 'protocolos/anular_remoto';

$route['decripto_remoto'] = 'protocolos/decripto_remoto';

$route['estado_protocolo'] = 'protocolos/estado_protocolo';

$route['dividir_protocolo'] = 'protocolos/dividir_protocolo';
$route['dividir_protocolo/(:num)'] = "protocolos/dividir_protocolo/$1";

$route['enlazar_protocolo'] = 'protocolos/enlazar_protocolo';
$route['enlazar_protocolo/(:num)'] = "protocolos/enlazar_protocolo/$1";

$route['equipos_remotos'] = 'protocolos/equipos_remotos';

// protocolos generados
$route['acomodar_protocolo'] = 'protocolos/acomodar_protocolo';

/*********** Remitos DEFINED ROUTES *******************/

// 48. SOCIOS/Socios/Remitos mantener
$route['remitos_listado']              = 'socios/remitos_listado';
$route['remitos_listado/(:num)']       = "socios/remitos_listado/$1";
$route['recibir_equipo']               = 'socios/recibir_equipo';
$route['nuevo_evento']                 = 'socios/nuevo_evento';
$route['verRemito/(:num)']             = "socios/verRemito/$1";
$route['finalizarRemito']              = 'socios/finalizarRemito';
$route['presupuesto/(:num)']           = 'socios/presupuesto/$1';
$route['guardar_presupuesto']          = 'socios/guardar_presupuesto';
$route['eliminar_presupuesto/(:num)']  = 'socios/eliminar_presupuesto/$1';
$route['solicitar_presupuesto/(:num)'] = 'socios/solicitar_presupuesto/$1';
$route['ver_presupuesto/(:num)']       = 'socios/ver_presupuesto/$1';
$route['aprobar_presupuesto']          = 'socios/aprobar_presupuesto';
$route['cancelar_remito']              = 'socios/cancelar_remito';

$route['descargar_presupuesto']              = 'socios/descargar_presupuesto';

// 47. SOCIOS/Socios/Solicitudes mantener
$route['solicitudes_listado']              = 'socios/solicitudes_listado';
$route['solicitudes_listado/(:num)']       = "socios/solicitudes_listado/$1";

// 49. SOCIOS/Socios/Finalizados mantener
$route['finalizados_listado']              = 'socios/finalizados_listado';
$route['finalizados_listado/(:num)']       = "socios/finalizados_listado/$1";

// 50. SOCIOS/Socios/Rechazadas mantener
$route['rechazados_listado']              = 'socios/rechazados_listado';
$route['rechazados_listado/(:num)']       = "socios/rechazados_listado/$1";

/*********** FLOTA DEFINED ROUTES *******************/

// 51. FLOTA/Vehículos mantener
$route['flotaListing'] = 'flota/flotaListing';
$route['flotaListing/(:num)'] = "flota/flotaListing/$1";
$route['addNewFlota'] = "flota/addNewFlota";

$route['addNewFlotaVeh'] = "flota/addNewFlotaVeh";
$route['editOldFlota'] = "flota/editOldFlota";
$route['editOldFlota/(:num)'] = "flota/editOldFlota/$1";
$route['editFlota'] = "flota/editFlota";
$route['deleteFlota'] = "flota/deleteFlota";

/*********** Ordenes *******************/

// xx. REPORTES/Novedades LAST* 
$route['fallas'] = 'ordenes/reportesFallas';

$route['ver-falla/(:num)'] = "ordenes/verFalla/$1";
$route['ver-desestimado/(:num)'] = "ordenes/verDesestimado/$1";
$route['reportes-desestimados'] = 'ordenes/reportesDesestimados';
$route['reportes-desestimados/(:num)'] = 'ordenes/reportesDesestimados/$1';

// xx. REPORTES/Novedades | click "enlace.Nuevo Reporte"
$route['alta_novedad'] = 'ordenes/altaNovedad';

// xx. REPORTES/Novedades | click "enlace.Nuevo Reporte" | submit POST (crear una solicitud de trabajo)
$route['ordenes/altaNuevaNovedad'] = 'ordenes/altaNuevaNovedad';

// 16. SECTORES/Mantenimiento/Solicitudes  LAST* (crear una orden a partir de una solicitud de trabajo)
$route['mantenimiento/solicitudes'] = 'ordenes/mantenimientoSolicitudes';

// 17. SECTORES/Mantenimiento/Ordenes Abiertas mantener
$route['mantenimiento/ordenes'] = 'ordenes/mantenimientoOrdenes';

$route['mantenimiento/ordenes/(:num)'] = "ordenes/mantenimientoOrdenes/$1";

// 19. SECTORES/Mantenimiento/Ordenes Rechazadas mantener
$route['mantenimiento/rechazadas'] = 'ordenes/mantenimientoRechazadas';

// 18. SECTORES/Mantenimiento/Ordenes Finalizadas mantener
$route['mantenimiento/finalizadas'] = 'ordenes/mantenimientoFinalizadas';
$route['mantenimiento/finalizadas/(:num)'] = "ordenes/mantenimientoFinalizadas/$1";

// 20. SECTORES/Reparaciones/Indicadores mantener 
$route['reparaciones/indicadores'] = 'ordenes/reparacionesIndicadores';

// 21. SECTORES/Reparaciones/Solicitudes mantener 
$route['reparaciones/solicitudes'] = 'ordenes/reparacionesSolicitudes';

// 22. SECTORES/Reparaciones/Ordenes Abiertas mantener
$route['reparaciones/ordenes'] = 'ordenes/reparacionesOrdenes';
$route['reparaciones/ordenes/(:num)'] = "ordenes/reparacionesOrdenes/$1";

// 24. SECTORES/Reparaciones/Ordenes Rechazadas mantener
$route['reparaciones/rechazadas'] = 'ordenes/reparacionesRechazadas';

// 23. SECTORES/Reparaciones/Ordenes Finalizadas mantener 
$route['reparaciones/finalizadas'] = 'ordenes/reparacionesFinalizadas';
$route['reparaciones/finalizadas/(:num)'] = "ordenes/reparacionesFinalizadas/$1";
$route['recibir-socio/(:num)'] = 'ordenes/recibirSocio/$1';

$route['cancelar_orden'] = 'ordenes/cancelar_orden/';

// 25. SECTORES/Reparaciones/Precintos mantener
$route['reparaciones/precintado'] = 'precintos/reparacionesPrecintado';
$route['reparaciones/precintos'] = 'precintos/precintos_carga';
$route['reparaciones/precinto'] = 'precintos/carga_precinto';
$route['reparaciones/precinto-plantilla'] = 'precintos/download_plantilla';

$route['instalaciones/solicitudes'] = 'ordenes/instalacionesSolicitudes';

// 36. INSTALACIONES/Reparaciones Obra Civil/Ordenes Abiertas mantener
$route['instalaciones/ordenes'] = 'ordenes/instalacionesOrdenes';

// 38. INSTALACIONES/Reparaciones Obra Civil/Ordenes Rechazadas mantener
$route['instalaciones/rechazadas'] = 'ordenes/instalacionesRechazadas';

// 37. INSTALACIONES/Reparaciones Obra Civil/Ordenes Finalizadas mantener
$route['instalaciones/finalizadas'] = 'ordenes/instalacionesFinalizadas';

$route['solicitud_deposito'] = 'ordenes/solicitud_deposito';

$route['agregarVisitas'] = 'ordenes/agregarVisitas';

$route['ver-solicitud/(:num)'] = "ordenes/verSolicitud/$1";
$route['ver-orden/(:num)'] = "ordenes/verOrden/$1";
$route['finalizar-orden'] = "ordenes/finalizarOrden";

// 22. SECTORES/Reparaciones/Ordenes Abiertas | submit modal click "btn.Reasignar" (reasignar una orden de trabajo)
$route['reasignar-orden'] = "ordenes/reasignarOrden";

$route['fecha-corte/(:num)'] = "ordenes/fechaCorte/$1";
$route['addfechaCorte'] = "ordenes/addfechaCorte";
$route['enviar-socio/(:num)'] = "ordenes/enviarSocio/$1";

$route['adjuntar_archivo/(:num)'] = "ordenes/adjuntar_archivo/$1";
$route['guardar_archivo'] = "ordenes/guardar_archivo";
$route['cargar_archivo/(:num)'] = "ordenes/cargar_archivo/$1";
$route['descargar_archivo'] = "ordenes/descargar_archivo";
$route['eliminar_archivo/(:num)'] = "ordenes/eliminar_archivo/$1";

/*********** REPARACIOMES DEFINED ROUTES *******************/

$route['ordenes_abiertas'] = "ordenes/ordenes_abiertas";

/*********** Calibración DEFINED ROUTES *******************/
/*SI*/

// 26. SECTORES/Calibraciones/Solicitudes mantener
$route['calibraciones_solicitudes']        = 'calib/calibraciones_solicitudes';
$route['calibraciones_solicitudes/(:num)'] = "calib/calibraciones_solicitudes/$1";

// 27. SECTORES/Calibraciones/Ordenes mantener
$route['calibraciones_ordenes']        = 'calib/calibraciones_ordenes';
$route['calibraciones_ordenes/(:num)'] = "calib/calibraciones_ordenes/$1";

// 28. SECTORES/Calibraciones/Documentación Pendiente mantener
$route['calibraciones_pendientes']        = 'calib/calibraciones_pendientes';
$route['calibraciones_pendientes/(:num)'] = "calib/calibraciones_pendientes/$1";

// 29. SECTORES/Calibraciones/Rechazadas mantener
$route['calibraciones_rechazadas']        = 'calib/calibraciones_rechazadas';
$route['calibraciones_rechazadas/(:num)'] = "calib/calibraciones_rechazadas/$1";

// 30. SECTORES/Calibraciones/Finalizadas mantener
$route['calibraciones_finalizadas']        = 'calib/calibraciones_finalizadas';
$route['calibraciones_finalizadas/(:num)'] = "calib/calibraciones_finalizadas/$1";

$route['agregar_pedidos'] = 'calib/agregar_pedidos';

// 31. SECTORES/Calibraciones/Parciales mantener
$route['calibraciones_parciales'] = 'calib/calibraciones_parciales';

$route['ver_pedido/(:num)'] = "calib/ver_pedido/$1";

//$route['aprobacion_calib/(:num)'] = "calib/aprobacion_calib/$1";
$route['pedido_compra'] = "calib/pedido_compra";
$route['pedido_compra/(:num)'] = "calib/pedido_compra/$1";

$route['agregar_compra'] = 'calib/agregar_compra';

$route['aprobacion_compra'] = "calib/aprobacion_compra";
$route['aprobacion_compra/(:num)'] = "calib/aprobacion_compra/$1";

$route['numeros_parciales'] = "calib/numeros_parciales";

$route['equipos_calibrar'] = "calib/equipos_calibrar";

$route['calibraciones_adjuntar']        = 'calib/calibraciones_adjuntar';
$route['calibraciones_adjuntar/(:num)'] = "calib/calibraciones_adjuntar/$1";

$route['guardar_certificado'] = "calib/guardar_certificado";
$route['cargar_certificado/(:num)'] = "calib/cargar_certificado/$1";
$route['descargar_certificado'] = "calib/descargar_certificado";
$route['eliminar_certificado/(:num)'] = "calib/eliminar_certificado/$1";

/*NO*/
$route['calibListing'] = 'calib/calibListing';
$route['calibListing/(:num)'] = "calib/calibListing/$1";
$route['calibListing/(:num)/(:num)'] = "calib/calibListing/$1/$2";

$route['agregar_SG'] = "calib/agregar_SG";
$route['editar_SG'] = "calib/editar_SG";
$route['editar_SG/(:num)'] = "calib/editar_SG/$1";
$route['agregar_editar_SG'] = "calib/agregar_editar_SG";

$route['editOldCalib'] = "calib/editOldCalib";
$route['editOldCalib/(:num)'] = "calib/editOldCalib/$1";
$route['editCalib'] = "calib/editCalib";
$route['deleteCalib'] = "calib/deleteCalib";
$route['deleteCalib/(:num)'] = "calib/deleteCalib/$1";
$route['verCalib/(:num)'] = "calib/verCalib/$1";

$route['editOldAprob'] = "calib/editOldAprob";
$route['editOldAprob/(:num)'] = "calib/editOldAprob/$1";
$route['editAprob'] = "calib/editAprob";

$route['aprobarSoliG'] = "calib/aprobarSoliG";
$route['aprobarSoliG/(:num)'] = "calib/aprobarSoliG/$1";
$route['solicitarSG'] = "calib/solicitarSG";
$route['solicitarSG/(:num)'] = "calib/solicitarSG/$1";
$route['aprobarSoliSG'] = "calib/aprobarSoliSG";
$route['aprobarSoliSG/(:num)'] = "calib/aprobarSoliSG/$1";
$route['aprobarSoliSG/(:num)/(:num)/(:num)/(:num)'] = "calib/aprobarSoliSG/$1/$2/$3/$4";
$route['espera'] = "calib/espera";
$route['espera/(:num)'] = "calib/espera/$1";
$route['finalizar'] = "calib/finalizar";
$route['finalizar/(:num)'] = "calib/finalizar/$1";

/*
$route['aprobacion_calib'] = "calib/aprobacion_calib";
$route['aprobacion_calib/(:num)'] = "calib/aprobacion_calib/$1";
$route['aprobacion_calib/(:num)/(:num)/(:num)/(:num)'] = "calib/aprobacion_calib/$1/$2/$3/$4";
$route['editSoliAprob'] = "calib/editSoliAprob";
*/

$route['parcialesListing'] = 'calib/parcialesListing';

/*********** Instalación DEFINED ROUTES *******************/

$route['instaListing'] = 'insta/instaListing';
$route['instaListing/(:num)'] = "insta/instaListing/$1";
$route['addNewInsta'] = "insta/addNewInsta";

$route['addNewInstalacion'] = "insta/addNewInstalacion";
$route['editOldInsta'] = "insta/editOldInsta";
$route['editOldInsta/(:num)'] = "insta/editOldInsta/$1";
$route['editInsta'] = "insta/editInsta";
$route['deleteInsta'] = "insta/deleteInsta";
$route['enviarInsta'] = "insta/enviarInsta";
$route['verInsta/(:num)'] = "insta/verInsta/$1";

/*********** Agenda DEFINED ROUTES *******************/

$route['agenda-calendario'] = 'agenda/calendario';
$route['agenda-add'] = 'agenda/add';
$route['agenda-invitaciones'] = 'agenda/invitaciones';

/*********** MAPAS *******************/

// 56. GEOLOCALIZACION/Mapa/Equipos fijos mantener
$route['mapaEquipos'] = 'mapa/mapaEquipos';

// 57. GEOLOCALIZACION/Mapa/Flota vehiculos mantener
$route['mapaFlota'] = 'mapa/mapaFlota';

// 58. GEOLOCALIZACION/Mapa/Equipos moviles mantener
$route['mapa/equipos_moviles'] = 'mapa/mapaEquiposMoviles';

/*********** DEPOSITO *******************/

// 32. SECTORES/Deposito/Ingresos mantener
$route['ingresos_listado'] = 'deposito/ingresos_listado';
$route['ingresos_listado/(:num)'] = "deposito/ingresos_listado/$1";

// 33. SECTORES/Deposito/Custodia mantener
$route['custodia_listado'] = 'deposito/custodia_listado';
$route['custodia_listado/(:num)'] = "deposito/custodia_listado/$1";

// 34. SECTORES/Deposito/Egresos mantener
$route['egresos_listado'] = 'deposito/egresos_listado';
$route['egresos_listado/(:num)'] = "deposito/egresos_listado/$1";

// 35. SECTORES/Deposito/Finalizadas mantener
$route['finalizadas_listado'] = 'deposito/finalizadas_listado';
$route['finalizadas_listado/(:num)'] = "deposito/finalizadas_listado/$1";

$route['recibir_deposito'] = "deposito/recibir_deposito";

$route['agregar_observacion'] = "deposito/agregar_observacion";

$route['deposito_archivos'] = 'deposito/deposito_archivos';
$route['deposito_archivos/(:num)'] = "deposito/deposito_archivos/$1";

$route['guardar_archivos'] = 'deposito/guardar_archivos';
$route['descargar_archivos'] = 'deposito/descargar_archivos';
$route['eliminar_archivos'] = 'deposito/eliminar_archivos';
$route['eliminar_archivos/(:num)'] = "deposito/eliminar_archivos/$1";

$route['cargar_archivos'] = 'deposito/cargar_archivos';
$route['cargar_archivos/(:num)'] = "deposito/cargar_archivos/$1";

$route['equipo_destino'] = 'deposito/equipo_destino';

$route['remito_deposito'] = 'deposito/remito_deposito';
$route['remito_deposito/(:num)'] = "deposito/remito_deposito/$1";

$route['nuevo_ingreso'] = 'deposito/nuevo_ingreso';
$route['destinoDeposito'] = 'deposito/destinoDeposito';
$route['nuevo_recibir'] = 'deposito/nuevo_recibir';

/*********** SSTI *******************/

$route['verExportacion/(:num)'] = "ssti/verExportacion/$1";

$route['ver_fotos'] = 'ssti/ver_fotos';
$route['ver_fotos/(:num)'] = "ssti/ver_fotos/$1";

$route['verAprobadas/(:num)'] = "ssti/verAprobadas/$1";
$route['verDesaprobadas/(:num)'] = "ssti/verDesaprobadas/$1";

$route['ver_fotos_ssti'] = 'ssti/ver_fotos_ssti';

$route['equipos_ssti'] = 'ssti/equipos_ssti';
$route['descargar_productividad'] = 'ssti/descargar_productividad';

$route['estado_entrada'] = 'ssti/estado_entrada';

$route['generacion_salida_edicion'] = 'ssti/generacion_salida_edicion';
$route['usar_generador_salida_edicion'] = 'ssti/usar_generador_salida_edicion';

/*********** Perifericos *******************/

// 13. EQUIPOS/Perifericos/Perifericos mantener
$route['perifericos_listado'] = 'perifericos/perifericos_listado';
$route['perifericos_listado/(:num)'] = "perifericos/perifericos_listado/$1";

$route['agregar_periferico'] = 'perifericos/agregar_periferico';
$route['perifericos_equipos'] = 'perifericos/perifericos_equipos';

$route['agregar_editar_perifericos'] = 'perifericos/agregar_editar_perifericos';

$route['estado_periferico'] = 'perifericos/estado_periferico';

$route['editar_periferico'] = 'perifericos/editar_periferico';
$route['editar_periferico/(:num)'] = "perifericos/editar_periferico/$1";

$route['ver_periferico'] = 'perifericos/ver_periferico';
$route['ver_periferico/(:num)'] = "perifericos/ver_periferico/$1";

$route['estado_comunicacion'] = 'perifericos/estado_comunicacion';

/*********** Archivos *******************/

$route['equipos_archivos/(:num)'] = "archivos/equipos_archivos/$1";

$route['archivo_guardar'] = "archivos/archivo_guardar";

$route['archivo_descargar'] = "archivos/archivo_descargar";

$route['archivo_eliminar/(:num)'] = "archivos/archivo_eliminar/$1";

$route['archivos_cargar/(:num)'] = "archivos/archivos_cargar/$1";

/*********** INSTALACIONES *******************/

// 39. INSTALACIONES/Relevamientos/Solicitudes mantener
$route['instalaciones_solicitudes'] = 'instalaciones/instalaciones_solicitudes';
$route['instalaciones_solicitudes/(:num)'] = "instalaciones/instalaciones_solicitudes/$1";

$route['agregar_solicitud'] = 'instalaciones/agregar_solicitud';

$route['editar_solicitud'] = 'instalaciones/editar_solicitud';
$route['editar_solicitud/(:num)'] = "instalaciones/editar_solicitud/$1";

$route['agregar_editar_solicitudes'] = 'instalaciones/agregar_editar_solicitudes';

$route['insta_agregar_observacion'] = 'instalaciones/insta_agregar_observacion';

$route['cancelar_relevamiento'] = 'instalaciones/cancelar_relevamiento';

$route['aceptar_relevamiento'] = 'instalaciones/aceptar_relevamiento';

$route['ver_relevamiento'] = 'instalaciones/ver_relevamiento';
$route['ver_relevamiento/(:num)'] = "instalaciones/ver_relevamiento/$1";

// 40. INSTALACIONES/Relevamientos/Relevamientos mantener
$route['ordenes_relevamiento'] = 'instalaciones/ordenes_relevamiento';
$route['ordenes_relevamiento/(:num)'] = "instalaciones/ordenes_relevamiento/$1";

$route['finalizar_relevamiento'] = 'instalaciones/finalizar_relevamiento';

$route['relevamiento_archivos'] = 'instalaciones/relevamiento_archivos';
$route['relevamiento_archivos/(:num)'] = "instalaciones/relevamiento_archivos/$1";

// 41. INSTALACIONES/Relevamientos/Finalizadas relevamiento mantener
$route['finalizadas_relevamiento'] = 'instalaciones/finalizadas_relevamiento';
$route['finalizadas_relevamiento/(:num)'] = "instalaciones/finalizadas_relevamiento/$1";

// 45. INSTALACIONES/Equipamientos Desintalacion/Ordenes Desinstalacion mantener
$route['ordenes_desintalacion'] = 'instalaciones/ordenes_desintalacion';
$route['ordenes_desintalacion/(:num)'] = "instalaciones/ordenes_desintalacion/$1";

$route['agregar_orden_desintalacion'] = 'instalaciones/agregar_orden_desintalacion';

$route['desintalacion_equipos'] = 'instalaciones/desintalacion_equipos';

$route['agregar_editar_orden_desintalacion'] = 'instalaciones/agregar_editar_orden_desintalacion';

$route['editar_orden_desintalacion'] = 'instalaciones/editar_orden_desintalacion';
$route['editar_orden_desintalacion/(:num)'] = "instalaciones/editar_orden_desintalacion/$1";

$route['cancelar_desintalacion'] = 'instalaciones/cancelar_desintalacion';

$route['insta_enviar_orden'] = 'instalaciones/insta_enviar_orden';
$route['insta_enviar_orden/(:num)'] = "instalaciones/insta_enviar_orden/$1";

$route['finalizar_desintalacion'] = 'instalaciones/finalizar_desintalacion';

$route['ver_desintalacion'] = 'instalaciones/ver_desintalacion';
$route['ver_desintalacion/(:num)'] = "instalaciones/ver_desintalacion/$1";

// 46. INSTALACIONES/Equipamientos Desintalacion/Finalizadas Desinstalacion mantener
$route['finalizadas_desintalacion'] = 'instalaciones/finalizadas_desintalacion';
$route['finalizadas_desintalacion/(:num)'] = "instalaciones/finalizadas_desintalacion/$1";

$route['desintalacion_archivos'] = 'instalaciones/desintalacion_archivos';
$route['desintalacion_archivos/(:num)'] = "instalaciones/desintalacion_archivos/$1";

$route['verificacion_elementos'] = 'instalaciones/verificacion_elementos';
$route['verificacion_elementos/(:num)'] = "instalaciones/verificacion_elementos/$1";

$route['reutilizacion_elementos'] = 'instalaciones/reutilizacion_elementos';

// 42. INSTALACIONES/Equipamientos Instalacion/Solicitudes instalacion mantener
$route['solicitudes_instalacion'] = 'instalaciones/solicitudes_instalacion';
$route['solicitudes_instalacion/(:num)'] = "instalaciones/solicitudes_instalacion/$1";

$route['agregar_solicitud_insalacion'] = 'instalaciones/agregar_solicitud_insalacion';

$route['add_solicitud_instalacion'] = 'instalaciones/add_solicitud_instalacion';

$route['ver_grupo'] = 'instalaciones/ver_grupo';
$route['ver_grupo/(:num)'] = "instalaciones/ver_grupo/$1";

$route['aprobar_solicitud_instalacion'] = 'instalaciones/aprobar_solicitud_instalacion';
$route['aprobar_solicitud_instalacion/(:num)'] = "instalaciones/aprobar_solicitud_instalacion/$1";

// 43. INSTALACIONES/Equipamientos Instalacion/Ordenes instalacion mantener
$route['ordenes_instalacion'] = 'instalaciones/ordenes_instalacion';
$route['ordenes_instalacion/(:num)'] = "instalaciones/ordenes_instalacion/$1";

$route['ver_instalacion'] = 'instalaciones/ver_instalacion';
$route['ver_instalacion/(:num)'] = "instalaciones/ver_instalacion/$1";

$route['insta_enviar_orden2'] = 'instalaciones/insta_enviar_orden2';
//$route['insta_enviar_orden2/(:num)'] = "instalaciones/insta_enviar_orden2/$1";

$route['finalizar_instalacion'] = 'instalaciones/finalizar_instalacion';

// 44. INSTALACIONES/Equipamientos Instalacion/Finalizadas instalacion mantener
$route['finalizadas_instalacion'] = 'instalaciones/finalizadas_instalacion';
$route['finalizadas_instalacion/(:num)'] = "instalaciones/finalizadas_instalacion/$1";

$route['agregar_visitas'] = 'instalaciones/agregar_visitas';
$route['agregar_visitas/(:num)/(:any)'] = "instalaciones/agregar_visitas/$1/$2";

$route['add_visita_instalacion'] = 'instalaciones/add_visita_instalacion';


$route['agregar_nueva_solicitud_instalacion'] = 'instalaciones/agregar_nueva_solicitud_instalacion';
$route['agregar_nueva_solicitud_instalacion/(:num)'] = "instalaciones/agregar_nueva_solicitud_instalacion/$1";

$route['addEdit_nueva_solicitud_instalacion'] = 'instalaciones/addEdit_nueva_solicitud_instalacion';

$route['eliminar_solicitud_instalacion'] = 'instalaciones/eliminar_solicitud_instalacion';
$route['eliminar_solicitud_instalacion/(:num)'] = "instalaciones/eliminar_solicitud_instalacion/$1";

/*********** Reporte ********************/

// 14. EQUIPOS/Estadísticas/Estadísticas Equipo mantener
$route['estadisticas_equipo'] = 'reportes/estadisticas_equipo';
$route['estadisticas_form'] = 'reportes/estadisticas_form';

// 8. EQUIPOS/Equipos/Cargar Estadísticas NO HAY CONTROLLER 
$route['cargar_estadisticas'] = 'reportes/cargar_estadisticas';

$route['equipos_by_modelo'] = 'reportes/equipos_by_modelo';
$route['equipos_modelos_ssti'] = 'reportes/equipos_modelos_ssti';
$route['estadisticas_excel'] = 'reportes/estadisticas_excel';

$route['trazabilidad_reportes_excel'] = 'reportes/trazabilidad_reportes_excel'; 
$route['reportes_sistemas'] = 'reportes/reportes_sistemas';
$route['exportaciones'] = 'reportes/exportaciones';
$route['salida_de_edicion'] = 'reportes/salida_de_edicion';

/*********** Reporte actas ********************/

$route['reporte_actas'] = 'reporte_actas/index';
$route['busquedaDeSalidaPPSVdePDF'] = 'reporte_actas/busquedaDeSalidaPPSVdePDF';
$route['mostrarEquiposSelect'] = 'reporte_actas/mostrarEquiposSelect';
$route['generarCsv'] = 'reporte_actas/generarCsv';

/*********** Estadisticas ********************/

// 15. EQUIPOS/Estadísticas/Estadísticas Archivos mantener
$route['estadisticas_archivos'] = 'estadisticas/estadisticas_archivos';
$route['estadisticas_archivos/(:num)'] = 'estadisticas/estadisticas_archivos/$1';

$route['confirmar_desencriptacion/(:num)'] = 'estadisticas/confirmar_desencriptacion/$1';

/*********** Verificacion ********************/

$route['preverificacion/(:num)'] = 'verificacion/preverificacion/$1';

$route['procesar_protocolos'] = 'verificacion/procesar_protocolos';

$route['actualizar_entrada_todos'] = 'verificacion/actualizar_entrada_todos';

$route['eliminar_protocolo'] = 'verificacion/eliminar_protocolo';
$route['estado_entrada_preverificacion'] = 'verificacion/estado_entrada_preverificacion';

$route['copiar_registros'] = 'verificacion/copiar_registros';
$route['copiar_registros/(:num)/(:num)'] = 'verificacion/copiar_registros/$1/$2';

$route['asignar_verificador'] = 'verificacion/asignar_verificador';

$route['ver_editadas/(:num)'] = "verificacion/ver_editadas/$1";

$route['cerrar_asignacion'] = 'verificacion/cerrar_asignacion';

$route['verificacion_descartadas'] = 'verificacion/verificacion_descartadas';
$route['verificacion_descartadas/(:num)'] = 'verificacion/verificacion_descartadas/$1';

$route['verificacion_aprobadas'] = 'verificacion/verificacion_aprobadas';
$route['verificacion_aprobadas/(:num)'] = 'verificacion/verificacion_aprobadas/$1';

$route['actualizar_entrada/(:num)'] = "verificacion/actualizar_entrada/$1";

$route['habilitar_verificacion'] = "verificacion/habilitar_verificacion/";

$route['volver_asignar'] = 'verificacion/volver_asignar';

$route['copiar_registros_proyecto'] = 'verificacion/copiar_registros_proyecto';
$route['copiar_registros_proyecto/(:num)'] = 'verificacion/copiar_registros_proyecto/$1';

$route['estadistica_editores'] = 'verificacion/estadistica_editores';

/*********** HISTORIAL DEFINED ROUTES *******************/

/* End of file routes.php */
/* Location: ./application/config/routes.php */

/*********** API *******************/
// return $this->db->last_query();

// componente
$route['api/componente/get'] = 'API/componenteApi/get';

// empresa
$route['api/empresa/get'] = 'API/empresaApi/get';
$route['api/empresa/get_all'] = 'API/empresaApi/get_all';

// equipo
$route['api/equipo/get'] = 'API/equipoApi/get';
$route['api/equipo/get_all'] = 'API/equipoApi/get_all';
$route['api/equipo/get_data_equipo_by_id/(:num)'] = 'API/equipoApi/get_data_equipo_by_id/$1';
$route['api/equipo/get_data_tabla_relacionada'] = 'API/equipoApi/get_data_tabla_relacionada';

// flota
$route['api/flota/get'] = 'API/flotaApi/get';
$route['api/flota/get_all'] = 'API/flotaApi/get_all';
$route['api/flota/get_all_delimited_fields'] = 'API/flotaApi/get_all_delimited_fields';
$route['api/flota/get_dominio_vehiculo_by_id'] = 'API/flotaApi/get_dominio_vehiculo_by_id';
$route['api/flota/get_vehiculos'] = 'API/flotaApi/get_vehiculos_api';

// mensaje
$route['api/mensaje/get'] = 'API/mensajeApi/get';

// municipio
$route['api/municipio/proyecto_listado'] = 'API/municipioApi/proyectoListado';

// reparacion
$route['api/reparacion/get'] = 'API/reparacionApi/get';