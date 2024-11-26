<?php

    $isAdministrativo = array(ROLE_ADM,ROLE_DIRADM,ROLE_GERADM,ROLE_SUPADM);
    $isBajada         = array(ROLE_BAJADA,ROLE_DIRBAJADA,ROLE_GERBAJADA,ROLE_SUPBAJADA);
    $isCalibracion    = array(ROLE_CALIB,ROLE_DIRCALIB,ROLE_GERCALIB,ROLE_SUPCALIB);
    $isDeposito       = array(ROLE_DEPO,ROLE_DIRDEPO,ROLE_GERDEPO,ROLE_SUPDEPO);
    $isGestion        = array(ROLE_GESTIONPROY,ROLE_DIRGESTIONPROY,ROLE_GERGESTIONPROY,ROLE_SUPGESTIONPROY,ROLE_AUDGESTIONPROY);
    $isIngreso        = array(ROLE_INGDATOS,ROLE_SUPINGDATOS);
    $isInstalacion    = array(ROLE_INSTA,ROLE_DIRINSTA,ROLE_GERINSTA,ROLE_SUPINSTA);
    $isMantenimiento  = array(ROLE_MANTE,ROLE_DIRMANTE,ROLE_GERMANTE,ROLE_SUPMANTE);
    $isProcesamiento  = array(ROLE_PROCEDATOS,ROLE_GERPROCEDATOS,ROLE_SUPPROCEDATOS);
    $isReparacion     = array(ROLE_REPA,ROLE_DIRREPA,ROLE_GERREPA,ROLE_SUPREPA);
    $isSSGG           = array(ROLE_SSGG,ROLE_DIRSSGG,ROLE_GERSSGG,ROLE_SUPSSGG);
    $isSistemas       = array(ROLE_SIST,ROLE_DIRSIST,ROLE_GERSIST,ROLE_SUPSIST);
    $isAdmin          = array(ROLE_ADMIN,ROLE_SUPERADMIN);
    $isCECASIT        = array(ROLE_CECASIT,ROLE_DIRCECASIT,ROLE_GERCECASIT,ROLE_SUPCECASIT);
    $isSocios          = array(ROLE_SOCIOS,ROLE_DIRSOCIOS,ROLE_GERSOCIOS,ROLE_SUPSOCIOS);

    $isSuperv         = array(ROLE_SUPBAJADA,ROLE_SUPCALIB,ROLE_SUPINSTA,ROLE_SUPMANTE,ROLE_SUPREPA);

    if(!empty($permisosInfo))
{
  foreach ($permisosInfo as $uf)
  {
      $equipos_marcas            = $uf->equipos_marcas;
      $equipos_equipos           = $uf->equipos_equipos;
      $equipos_tipos             = $uf->equipos_tipos;
      $equipos_modelos           = $uf->equipos_modelos;
      $equipos_propietarios      = $uf->equipos_propietarios;

      $componentes_componentes   = $uf->componentes_componentes;
      $componentes_sinAsignar    = $uf->componentes_sinAsignar;
      $componentes_marcas        = $uf->componentes_marcas;
      $componentes_tipos         = $uf->componentes_tipos;

      $bajada_ordServ            = $uf->bajada_ordServ;
      $bajada_ordSR              = $uf->bajada_ordSR;
      $bajada_ordSP              = $uf->bajada_ordSP;
      $bajada_ordProc            = $uf->bajada_ordProc;
      $bajada_ordAnul            = $uf->bajada_ordAnul;
      $bajada_ordCero            = $uf->bajada_ordCero;


      $bajada_grupoSE            = $uf->bajada_grupoSE;
      $bajada_grupoSR            = $uf->bajada_grupoSR;
      $bajada_grupoSP            = $uf->bajada_grupoSP;
      $bajada_grupoC             = $uf->bajada_grupoC;

      $ingreso_pendientes        = $uf->ingreso_pendientes;
      $ingreso_ingresados        = $uf->ingreso_ingresados;
      $ingreso_anulados          = $uf->ingreso_anulados;
      $ingreso_cero              = $uf->ingreso_cero;
      $ingreso_remotos              = $uf->ingreso_remotos;

      $novedades_novedades       = $uf->novedades_novedades;

      $mantenimiento_solicitudes = $uf->mantenimiento_solicitudes;
      $mantenimiento_ordenes     = $uf->mantenimiento_ordenes;

      $reparacion_solicitudes    = $uf->reparacion_solicitudes;
      $reparacion_ordenes        = $uf->reparacion_ordenes;

      $instalacion_solicitudes   = $uf->instalacion_solicitudes;
      $instalacion_ordenes       = $uf->instalacion_ordenes;

      $calibracion_solicitudes   = $uf->calibracion_solicitudes;
      $calibracion_ordenes       = $uf->calibracion_ordenes;
      $calibracion_ordenesP      = $uf->calibracion_ordenesP;

      $calibracion_rechazadas    = $uf->calibracion_rechazadas;
      $calibracion_finalizadas   = $uf->calibracion_finalizadas;
      $calibracion_aprobacion    = $uf->calibracion_aprobacion;

      $flota_flota               = $uf->flota_flota;

      $socios_solicitudes        = $uf->socios_solicitudes;
      $socios_remitos            = $uf->socios_remitos;
      $socios_finalizados        = $uf->socios_finalizados;
      $socios_rechazados         = $uf->socios_rechazados;

      $deposito_ingresos          = $uf->deposito_ingresos;
      $deposito_custodia         = $uf->deposito_custodia;
      $deposito_egreso          = $uf->deposito_egreso;
      $deposito_finalizadas      = $uf->deposito_finalizadas;

      $fotos_desencriptadas      = $uf->fotos_desencriptadas;

      $exportaciones_exportaciones      = $uf->exportaciones_exportaciones;
      $exportaciones_detalles      = $uf->exportaciones_detalles;

      $proyectos_proyectos      = $uf->proyectos_proyectos;
      $proyectos_asignaciones      = $uf->proyectos_asignaciones;
  }

}
    ?>
