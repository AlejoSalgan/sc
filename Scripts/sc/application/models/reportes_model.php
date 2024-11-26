<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Reportes_model extends CI_Model
{

    function getReporteRapido($modelo = NULL, $tipo = NULL, $marca = NULL, $municipio = NULL, $calibra_vence = NULL, $serie = NULL, $estado = NULL, $fecha_desde = NULL, $fecha_hasta = NULL, $propietario = NULL, $evento = NULL, $administracion = NULL, $activo = NULL, $role, $userId)
    {
        $this->db->select("
        IF (Mun.descrip IS NULL ,'A designar' , Mun.descrip) as Proyecto,
        E.serie AS Serie, EMod.descrip AS Modelo,
        ETip.descrip AS Tipo, EMar.descrip AS Marca,
        IF (P.descrip IS NULL ,'A designar' , P.descrip) as Propietario,
        IF (PROP.descrip IS NULL ,'A designar' , PROP.descrip) as Administrador,
        ES.descrip AS Lugar,
        IF (Even.descrip IS NULL ,'A designar' , Even.descrip) as Evento_actual,
        IF (E.ubicacion_calle IS NULL ,'A designar' ,  E.ubicacion_calle) as Direccion,
        IF (E.Ubicacion_altura IS NULL ,'A designar' , E.Ubicacion_altura) as Altura,
        IF (E.ubicacion_sentido = 5 ,'Ascendente' , IF (E.ubicacion_sentido = 6 ,'Descendente' , 'A designar')) as Sentido,
        IF (E.activo = 1 ,'Activo' , 'Inactivo') as Activo,
        IF (E.remito = 0 ,'Sin numero de remito' , E.remito) as Remito,
        IF (E.pedido IS NULL ,'A designar' , E.pedido) as Pedido,
        IF (E.ordencompra IS NULL ,'Sin numero de Orden de Compra' , E.ordencompra) as Orden_Compra,
        IF (E.ejido_urbano = 1 ,'Dentro' , 'Fuera') as Ejido_Urbano,
        IF (E.doc_fechacal = '0000-00-00' ,'Sin fecha de Calibración' , E.doc_fechacal) as Fecha_Calibracion,
        IF (E.doc_fechavto = '0000-00-00' ,'Sin fecha de Vencimiento' , E.doc_fechavto) as Fecha_Vencimiento,
        E.ts AS Ultima_Modificacion, E.observ AS Observaciones", FALSE);
        $this->db->from('equipos_main AS E');
        $this->db->join('municipios as Mun', 'Mun.id = E.municipio','left');
        $this->db->join('equipos_modelos as EMod', 'EMod.id = E.idmodelo','left');
        $this->db->join('equipos_tipos as ETip', 'ETip.id = E.tipo','left');
        $this->db->join('equipos_marcas as EMar', 'EMar.id = E.marca','left');
        $this->db->join('eventos as Even', 'Even.id = E.evento_actual','left');
        $this->db->join('estados as ES', 'ES.id = E.estado','left');

        switch ($role) {
          case 60:
          case 61:
          case 62:
          case 63: //Socios.
                  $this->db->join('equipos_propietarios as P', 'P.descrip = EMod.asociado','left');
                  $this->db->join('tbl_users as U', 'U.asociado = P.id','left');
             break;

          default:
                  $this->db->join('equipos_propietarios as P', 'P.id = E.idpropietario','left');
            break;
        }

        $this->db->join('equipos_propietarios as PROP', 'PROP.id = Mun.adminstracion','left');
        $this->db->join('tbl_users as UG', 'UG.userId = Mun.gestor','left');

        $this->db->where('E.eliminado','0');
        $this->db->not_like('E.serie', '-baj');

        if( $calibra_vence > 0 ) {
            $fechaHoy = date('Y-m-j');
            $nuevafecha = strtotime ( "+$calibra_vence day" , strtotime ( $fechaHoy ) ) ;
            $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
            $this->db->where('E.doc_fechavto >=', $fechaHoy);
            $this->db->where('E.doc_fechavto <=', $nuevafecha);
            $this->db->where('E.doc_fechavto !=', '0000-00-00');
        }

        if( $municipio > -1 ) {
            $this->db->where('E.municipio', $municipio);
        }
        else{
            switch ($role) {
                case 100: // Gestión de Proyectos - Dirección (Directores)
                        $this->db->where("Mun.director LIKE '%" . $userId . "%'");
                   break;
               case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                        $this->db->where("Mun.gerente LIKE '%" . $userId . "%'");
                   break;
                case 102: //Gestión de Proyectos - Supervisión (Gestores)
                        $this->db->where("Mun.gestor LIKE '%" . $userId . "%'");
                   break;
                case 103: //Gestión de Proyectos (Ayudantes)
                        $this->db->where("Mun.ayudantes LIKE '%" . $userId . "%'");
                   break;
                case 104: //Gestión de Proyectos - Auditoria
                        $this->db->where("Mun.auditor LIKE '%" . $userId . "%'");
                   break;
                case 60:
                case 61:
                case 62:
                case 63:
                       $this->db->where("U.userId LIKE '%" . $userId . "%'");
                  break;
            }
        }
        if( $tipo > 0 ) {
            $this->db->where('E.tipo', $tipo);
        }
        if( $marca > 0 ) {
            $this->db->where('E.marca', $marca);
        }
        if( $modelo > 0 ) {
            $this->db->where('E.idmodelo', $modelo);
        }
        if( strlen($serie) > 0 ) {
            $this->db->like('E.serie', $serie);
        }
        if( $estado > 0 ) {
            $this->db->where('E.estado', $estado);
        }
        if( $evento > 0 ) {
            $this->db->where('E.evento_actual', $evento);
        }
        if( $propietario > 0 ) {
            $this->db->where('P.id', $propietario);
        }
        if( strlen($fecha_desde) == 10 ) {
            $this->db->where('E.ts >=', $fecha_desde);
        }
        if( strlen($fecha_hasta) == 10 ) {
            $this->db->where('E.ts <=', $fecha_hasta);
        }
        if( $administracion > 0 ) {
            $this->db->where('PROP.id', $administracion);
        }
        if( $activo != NULL ) {
            $this->db->where('E.activo', $activo);
        }

        $this->db->order_by("E.serie", "asc"); //campo ts timestamp

        $query = $this->db->get();
        return $query->result();
    }


    function getReporteReparaciones($fecha_desde2 = NULL, $fecha_hasta2 = NULL, $fecha_desde4 = NULL, $fecha_hasta4 = NULL, $role, $userId, $reportes_reparaciones = NULL)
    {
        switch ($reportes_reparaciones) {
          case '100':
                $this->db->select("RM.serie as Serie, RE.orden as Orden, DATE_FORMAT(RE.fecha, '%d/%m/%Y') as Apertura, 'Orden Abierta' as Cierre , FM.descrip as 'Tipo de Falla',
                    IF (DM.descrip IS NULL,'Sin Diagnóstico', DM.descrip) as Diagnóstico, TIMESTAMPDIFF(DAY,MIN(RE.fecha),NOW()) as 'Demora Días',
                    RE.observ as Comentarios", FALSE);
                $this->db->from('reparacion_estados as RE');
                $this->db->join('reparacion_main as RM', 'RE.orden = RM.id','left');
                $this->db->join('fallas_main as FM', 'RM.falla = FM.id','left');
                $this->db->join('diagnosticos_main as DM', 'RM.diagnostico = DM.id','left');
                $this->db->join('ordenes_tipo_estados as OTE', 'RE.tipo = OTE.id ','left');
                $this->db->join('equipos_main as EM', 'EM.serie = RM.serie','left');
                $this->db->join('equipos_propietarios as P', 'P.id = EM.idpropietario','left');

                $ord_tipo = array(1,2,7,8,12);
                $this->db->where_not_in('RM.ultimo_estado', $ord_tipo);
                $this->db->where('P.id', 3);
                $this->db->where('RM.tipo', 'R');

                $this->db->group_by('RM.serie');
                $this->db->order_by('RM.serie', 'asc');

                $query = $this->db->get();
                return $query->result();

          case '101':
                $sql = "SELECT RM.serie AS Serie, RE.orden AS Orden, RE3.fecha AS 'Fecha de apertura', RE.fecha AS 'Fecha de cierre',
                        FM.descrip AS 'Tipo de falla', DM.descrip AS Diagnóstico, RE.observ AS Observaciones
                        FROM reparacion_estados AS RE
                        LEFT JOIN reparacion_estados AS RE2 ON (RE.orden = RE2.orden AND RE.id < RE2.id)
                        INNER JOIN reparacion_estados AS RE3 ON (RE.orden = RE3.orden)
                        LEFT JOIN reparacion_main AS RM ON RE.orden = RM.id
                        LEFT JOIN fallas_main AS FM ON RM.falla = FM.id
                        LEFT JOIN diagnosticos_main AS DM ON DM.id = RM.diagnostico
                        LEFT JOIN equipos_main AS EM ON EM.serie = RM.serie
                        LEFT JOIN equipos_propietarios AS EP  ON EP.id = EM.idpropietario
                        WHERE RM.ultimo_estado = 7 AND EM.idpropietario = 3 AND RE2.orden IS NULL AND RM.tipo = 'R'";

                if (!empty($fecha_desde2)){
                    $sql .= " AND RE3.fecha >='" .$fecha_desde2."'" ;
                }
                if (!empty($fecha_hasta2)){
                    $sql .= " AND RE.fecha <='" .$fecha_hasta2."'" ;
                }

                $sql .= " GROUP BY RE.orden
                          ORDER BY RE.orden, RE.fecha";

                $query = $this->db->query($sql);
                return $query->result();

          case '102':
                $this->db->select("MUN.descrip AS Municipio, RM.serie as Serie, RE.orden as Orden, DATE_FORMAT(RE.fecha, '%d/%m/%Y') as Apertura, 'Orden Abierta' as Cierre , FM.descrip as 'Tipo de Falla',
                    IF (DM.descrip IS NULL,'Sin Diagnóstico', DM.descrip) as Diagnóstico, TIMESTAMPDIFF(DAY,MIN(RE.fecha),NOW()) as 'Demora Días',
                    RE.observ as Comentarios", FALSE);
                $this->db->from('reparacion_estados as RE');
                $this->db->join('reparacion_main as RM', 'RE.orden = RM.id','left');
                $this->db->join('fallas_main as FM', 'RM.falla = FM.id','left');
                $this->db->join('diagnosticos_main as DM', 'RM.diagnostico = DM.id','left');
                $this->db->join('ordenes_tipo_estados as OTE', 'RE.tipo = OTE.id ','left');
                $this->db->join('equipos_main as EM', 'EM.serie = RM.serie','left');
                $this->db->join('equipos_propietarios as P', 'P.id = EM.idpropietario','left');
                $this->db->join('municipios as MUN', 'MUN.id = RM.idproyecto','left');

                $ord_tipo = array(1,2,7,8,12);
                $this->db->where_not_in('RM.ultimo_estado', $ord_tipo);
                $this->db->where('RM.tipo', 'R');

                switch ($role) {
                    case 100: // Gestión de Proyectos - Dirección (Directores)
                            $this->db->where("MUN.director LIKE '%" . $userId . "%'");
                       break;
                    case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                            $this->db->where("MUN.gerente LIKE '%" . $userId . "%'");
                       break;
                    case 102: //Gestión de Proyectos - Supervisión (Gestores)
                            $this->db->where("MUN.gestor LIKE '%" . $userId . "%'");
                       break;
                    case 103: //Gestión de Proyectos (Ayudantes)
                            $this->db->where("MUN.ayudantes LIKE '%" . $userId . "%'");
                       break;
                    case 104: //Gestión de Proyectos - Auditoria
                            $this->db->where("MUN.auditor LIKE '%" . $userId . "%'");
                       break;
                }

                $this->db->group_by('RM.serie');
                $this->db->order_by('RM.serie', 'asc');

                $query = $this->db->get();
                return $query->result();

          case '103':
                $sql = "SELECT mun.descrip AS Municipio, RM.serie AS Serie, RE.orden AS Orden, RE3.fecha AS 'Fecha de apertura', RE.fecha AS 'Fecha de cierre',
                        FM.descrip AS 'Tipo de falla', DM.descrip AS Diagnóstico, RE.observ AS Observaciones
                        FROM reparacion_estados AS RE
                        LEFT JOIN reparacion_estados AS RE2 ON (RE.orden = RE2.orden AND RE.id < RE2.id)
                        INNER JOIN reparacion_estados AS RE3 ON (RE.orden = RE3.orden)
                        LEFT JOIN reparacion_main AS RM ON RE.orden = RM.id
                        LEFT JOIN fallas_main AS FM ON RM.falla = FM.id
                        LEFT JOIN diagnosticos_main AS DM ON DM.id = RM.diagnostico
                        LEFT JOIN equipos_main AS EM ON EM.serie = RM.serie
                        LEFT JOIN equipos_propietarios AS EP  ON EP.id = EM.idpropietario
                        LEFT JOIN municipios AS mun ON mun.id = RM.idproyecto
                        WHERE RM.ultimo_estado = 7 AND RE2.orden IS NULL AND RM.tipo = 'R'";

                if (!empty($fecha_desde4)){
                    $sql .= " AND RE3.fecha >='" .$fecha_desde4."'" ;
                }
                if (!empty($fecha_hasta4)){
                    $sql .= " AND RE.fecha <='" .$fecha_hasta4."'" ;
                }

                switch ($role) {
                    case 100: // Gestión de Proyectos - Dirección (Directores)
                        $this->db->where("MUN.director LIKE '%" . $userId . "%'");
                        break;
                    case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                        $this->db->where("MUN.gerente LIKE '%" . $userId . "%'");
                        break;
                    case 102: //Gestión de Proyectos - Supervisión (Gestores)
                        $this->db->where("MUN.gestor LIKE '%" . $userId . "%'");
                        break;
                    case 103: //Gestión de Proyectos (Ayudantes)
                        $this->db->where("MUN.ayudantes LIKE '%" . $userId . "%'");
                        break;
                    case 104: //Gestión de Proyectos - Auditoria
                        $this->db->where("MUN.auditor LIKE '%" . $userId . "%'");
                        break;
                }

                $sql .= " GROUP BY RE.orden
                          ORDER BY RE.orden, RE.fecha";

                $query = $this->db->query($sql);
                return $query->result();
        }
    }

    function getReporteCalib($fecha_proxima = NULL, $role = NULL, $userId = NULL, $reportes_calibraciones = NULL)
    {
        switch ($reportes_calibraciones) {
            case '300':
                $this->db->select("
                IF (Mun.descrip IS NULL ,'A designar' , Mun.descrip) as Proyecto,
                E.serie AS Serie, EMod.descrip AS Modelo,
                IF (E.ubicacion_calle IS NULL ,'A designar' , E.ubicacion_calle) as Direccion,
                IF (E.Ubicacion_altura IS NULL ,'A designar' , E.Ubicacion_altura) as Altura,
                IF (E.ubicacion_sentido = 5 ,'Ascendente' , IF (E.ubicacion_sentido = 6 ,'Descendente' , 'A designar')) as Sentido,
                E.multicarril as Cantidad_de_Carriles,
                IF (E.carril_sentido IS NULL ,'A designar' , E.carril_sentido) as Carril_controla,
                IF (E.ubicacion_velper = 0 ,'A designar', CONCAT(E.ubicacion_velper, ' KM/H')) as Velocidad_permitida,
                ETip.descrip AS Tipo, EMar.descrip AS Marca,
                ES.descrip AS Lugar,
                IF (Even.descrip IS NULL ,'A designar' , Even.descrip) as Evento_actual,
                IF (E.activo = 1 ,'Activo' , 'Inactivo') as Activo,
                IF (E.ejido_urbano = 1 ,'Dentro' , 'Fuera') as Ejido_Urbano,
                IF (E.doc_fechacal = '0000-00-00' ,'Sin fecha de Calibración' , E.doc_fechacal) as Fecha_Calibracion,
                IF (E.doc_fechavto = '0000-00-00' ,'Sin fecha de Vencimiento' , E.doc_fechavto) as Fecha_Vencimiento,
                IF ('Distancia_INTI'  = 'Distancia_INTI' ,NULL,NULL ) as 'Distancia_INTI' ,
                IF ('Horario'  = 'Horario' ,NULL,NULL ) as 'Horario' ,
                E.ts AS Ultima_Modificacion,
                E.observ AS Observaciones", FALSE);
                $this->db->from('equipos_main AS E');
                $this->db->join('municipios as Mun', 'Mun.id = E.municipio','left');
                $this->db->join('equipos_modelos as EMod', 'EMod.id = E.idmodelo','left');
                $this->db->join('equipos_tipos as ETip', 'ETip.id = E.tipo','left');
                $this->db->join('equipos_marcas as EMar', 'EMar.id = E.marca','left');
                $this->db->join('eventos as Even', 'Even.id = E.evento_actual','left');
                $this->db->join('estados as ES', 'ES.id = E.estado','left');
                $this->db->join('tbl_users as UG', 'UG.userId = Mun.gestor','left');
                $this->db->where('E.eliminado','0');
                $this->db->not_like('E.serie', '-baj');

                if ($fecha_proxima != NULL) {
                  $fechaHoy = date('Y-m-j');
                  $this->db->where('E.doc_fechavto >=', $fechaHoy);
                  $this->db->where('E.doc_fechavto <=', $fecha_proxima);
                }

                $this->db->where('E.doc_fechavto !=', '0000-00-00');

                switch ($role) {
                    case 100: // Gestión de Proyectos - Dirección (Directores)
                            $this->db->where("Mun.director LIKE '%" . $userId . "%'");
                       break;
                   case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                            $this->db->where("Mun.gerente LIKE '%" . $userId . "%'");
                       break;
                    case 102: //Gestión de Proyectos - Supervisión (Gestores)
                            $this->db->where("Mun.gestor LIKE '%" . $userId . "%'");
                       break;
                    case 103: //Gestión de Proyectos (Ayudantes)
                            $this->db->where("Mun.ayudantes LIKE '%" . $userId . "%'");
                       break;
                    case 104: //Gestión de Proyectos - Auditoria
                            $this->db->where("Mun.auditor LIKE '%" . $userId . "%'");
                       break;
                }

                $this->db->order_by('Mun.descrip', 'asc');

                $query = $this->db->get();
                return $query->result();
      }
    }

    function getReporteBajada($fecha_desde3 = NULL, $fecha_hasta3 = NULL, $fecha_desde5 = NULL, $fecha_hasta5 = NULL, $role, $userId, $reportes_bajada = NULL, $municipio2 = NULL)
    {
        switch ($reportes_bajada) {
            case '200':
                $sql = "SELECT mun.descrip AS 'Proyecto', obm.protocolo AS 'Protocolo', em.serie AS 'Equipo',
                      obm.fecha_alta AS 'Fecha Creación Orden', obm.bajada_fecha AS 'Fecha Bajada',
                      obm.subida_fecha AS 'Fecha Ingreso de Datos', obm.bajada_desde AS 'Fecha Desde',
                      obm.bajada_hasta AS 'Fecha Hasta', IF (obm.subida_fotos IS NULL, obm.bajada_archivos, obm.subida_fotos)
                      AS 'Cantidad de Archivos', IF ((obm.bajada_archivos / eqm.divide_x) IS NULL, '0',
                      TRUNCATE((obm.bajada_archivos / eqm.divide_x),0)) AS 'Cantidad de Registros',
                      obm.bajada_observ AS 'Observaciones Bajada', pe.estado AS 'Estado Protocolo',
                      ep.descrip AS 'Orden Cargada por'
                      FROM ordenesb_main AS obm
                      LEFT JOIN municipios AS mun ON mun.id = obm.idproyecto
                      LEFT JOIN equipos_main AS em ON em.id = obm.idequipo
                      LEFT JOIN protocolos_estados AS pe ON pe.id_tipo = obm.subida_estado
                      LEFT JOIN equipos_modelos AS eqm ON eqm.id = em.idmodelo
                      LEFT JOIN tbl_users AS tu ON tu.userId = obm.tecnico
                      LEFT JOIN equipos_propietarios AS ep ON ep.id = tu.asociado
                      WHERE (pe.id_tipo = 1 OR pe.id_tipo = 2 OR pe.id_tipo = 4)";

                if( $municipio2 > -1 ) {
                    $sql.= "AND obm.idproyecto =" .$municipio2." ";
                }
                else{
                    switch ($role) {
                        case 100: // Gestión de Proyectos - Dirección (Directores)
                            $sql .= " AND mun.director LIKE '%" . $userId . "%'";
                            break;
                        case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                            $sql .= " AND mun.gerente LIKE '%" . $userId . "%'";
                            break;
                        case 102: //Gestión de Proyectos - Supervisión (Gestores)
                            $sql .= " AND mun.gestor LIKE '%" . $userId . "%'";
                            break;
                        case 103: //Gestión de Proyectos (Ayudantes)
                            $sql .= " AND mun.ayudantes LIKE '%" . $userId . "%'";
                            break;
                        case 104: //Gestión de Proyectos - Auditoria
                            $sql .= " AND mun.auditor LIKE '%" . $userId . "%'";
                            break;
                    }
                }

                if (!empty($fecha_desde3)){
                    $sql.= "AND obm.bajada_fecha >='" .$fecha_desde3."' ";
                }
                if (!empty($fecha_hasta3)){
                    $sql.= "AND obm.bajada_fecha <='" .$fecha_hasta3." 23:59:59'";
                }

                $sql .= " ORDER BY obm.bajada_fecha ASC";

                $query = $this->db->query($sql);
                return $query->result();

            case '201':
                $sql = "SELECT mun.descrip AS 'Proyecto',
                        COUNT(obm.bajada_archivos) AS 'Cantidad de bajadas APP',
                        SUM(obm.bajada_archivos) AS 'Archivos bajados APP',
                        COUNT(obm.subida_fotos) AS 'Cantidad de subidas al sistema',
                        IF(SUM(obm.subida_fotos) IS NULL,'0',SUM(obm.subida_fotos)) AS 'Archivos ingresados al sistema',
                        IF (SUM(obm.bajada_archivos) - SUM(obm.subida_fotos) IS NULL,'0',SUM(obm.bajada_archivos) - SUM(obm.subida_fotos))
                        AS 'Diferencia entre bajados e ingresados'
                        FROM ordenesb_main AS obm
                        LEFT JOIN municipios AS mun ON mun.id = obm.idproyecto
                        WHERE obm.bajada_fecha BETWEEN '".$fecha_desde5."' AND '".$fecha_hasta5." 23:59:59'
                        AND obm.idproyecto not in (0,10)
                        GROUP BY obm.idproyecto
                        ORDER BY mun.descrip";

                $query = $this->db->query($sql);
                return $query->result();
        }
    }

    function rapidoReparaciones($role = NULL,$userId = NULL)
    {
      $sql = "SELECT `rm`.`id` AS Nº_Orden,
      `rm`.`serie` AS Equipo, `mu`.`descrip` AS Proyecto, `em`.`ubicacion_calle` AS Direccion,
      `em`.`ubicacion_altura` AS Altura,
      `re`.`fecha` AS Fecha,
      `fm`.`descrip` AS Tipo_Falla,
      `rc`.`descrip` AS Categoria,
      `es`.`descrip` AS Lugar
      FROM (`reparacion_main` AS rm)
      INNER JOIN `reparacion_estados` AS re ON `rm`.`id` = `re`.`orden`
      LEFT JOIN `fallas_main` AS fm ON `fm`.`id` = `rm`.`falla`
      LEFT JOIN `municipios` AS mu ON `mu`.`id` = `rm`.`idproyecto`
      LEFT JOIN `equipos_main` AS em ON `em`.`serie` = `rm`.`serie`
      LEFT JOIN `ordenes_tipo_estados` AS ote ON `ote`.`id` = `rm`.`ultimo_estado`
      LEFT JOIN `reparacion_categorias` AS rc ON `rc`.`id` = `rm`.`ultimo_categoria`
      LEFT JOIN `estados` AS es ON `em`.`estado` = `es`.`id`
      LEFT JOIN `diagnosticos_main` AS dm ON `dm`.`id` = `rm`.`diagnostico`
      LEFT JOIN `ordenes_visitas` AS ov ON `ov`.`id_orden` = `rm`.`id` AND ov.id =
      (SELECT MAX(id) FROM ordenes_visitas)
      WHERE `rm`.`ultimo_estado` IN(3,4,5,6,9,10,11,14,15,16) AND `re`.`tipo` IN(3,4,5,6,9,10,11,14,15,16) AND `em`.`eliminado` = 0 AND `rm`.`tipo` = 'R'";

      if ($role != NULL) {
        switch ($role) {
            case 100: // Gestión de Proyectos - Dirección (Directores)
                $sql .= " AND mu.director LIKE '%".$userId."%'";
                break;
            case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                $sql .= " AND mu.gerente LIKE '%".$userId."%'";
                break;
            case 102: //Gestión de Proyectos - Supervisión (Gestores)
                $sql .= " AND mu.gestor LIKE '%".$userId."%'";
                break;
            case 103: //Gestión de Proyectos (Ayudantes)
                $sql .= " AND mu.ayudantes LIKE '%".$userId."%'";
                break;
            case 104: //Gestión de Proyectos - Auditoria
                $sql .= " AND mu.auditor LIKE '%".$userId."%'";
                break;
        }
      }

      $sql .= " GROUP BY `re`.`orden`";
      $query = $this->db->query($sql);

      return $query->result();

    }


    function getOrdenesCalibraciones($proyecto,$tipo_orden,$tipo_servicio,$tipo_equipo)
    {
      $this->db->select('C.id as Nº_Orden, CTO.estado as Tipo_Orden, C.fecha_visita as Fecha_visita, EM.serie as Equipo, MUN.descrip as Proyecto, C.direccion as Direccion, ET.descrip as Tipo_Equipo, C.velocidad as Velocidad,
      CS.verificacion as Tipo_Servicio, PR.descrip as Prioridad, C.distancia_inti as Distancia_INTI, C.horario_calib as Horario_Calibracion, C.fecha_desde as Fecha_Desde, C.fecha_hasta as Fecha_Hasta,
      C.fecha_pasadas as Fecha_Pasadas, C.fecha_simulacion as Fecha_Simulacion, C.fecha_informe as Fecha_Informe, C.fecha_certificado as Fecha_Certificado, C.pasadas_aprob as Pasadas, C.simulacion_aprob as Simulacion');
      $this->db->from('calibraciones as C');
      $this->db->join('calibraciones_servicios as CS', 'CS.id = C.tipo_servicio','left');
      $this->db->join('calibraciones_tipo_orden as CTO', 'CTO.id_tipoOrden = C.tipo_orden','left');
      $this->db->join('prioridades as PR', 'PR.id = C.prioridad','left');
      $this->db->join('municipios as MUN', 'MUN.id = C.idproyecto','left');
      $this->db->join('equipos_main as EM', 'EM.id = C.idequipo','left');
      $this->db->join('equipos_tipos as ET', 'ET.id = C.tipo_equipo','left');

      if ($proyecto > 0) {
        $this->db->where('C.idproyecto',$proyecto);
      }
      if ($tipo_orden > 0) {
        $this->db->where('C.tipo_orden',$tipo_orden);
      }
      if ($tipo_servicio > 0) {
        $this->db->where('C.tipo_servicio',$tipo_servicio);
      }
      if ($tipo_equipo > 0) {
        $this->db->where('C.tipo_equipo',$tipo_equipo);
      }

      $query = $this->db->get();
      return $query->result();
    }

    function getOrdenesInstalaciones($proyecto, $tipo_orden, $role, $userId, $fecha_desde = NULL, $fecha_hasta = NULL)
    {
      //die(var_dump($tipo_orden));
      $sql .= "SELECT RM.id as 'Nº_orden', RM.tipo as 'Tipo_Orden', OTE.descrip as 'Ultimo_estado', F.descrip as 'Falla',
      MU.descrip as 'Proyecto', RM.serie as 'Equipo', RC.descrip as 'Ultima_categoria',
            (SELECT fecha FROM reparacion_estados as RE WHERE RM.id = RE.orden ORDER BY RE.id ASC LIMIT 1) as 'Primera_fecha',
            (SELECT observ FROM reparacion_estados as RE WHERE RM.id = RE.orden ORDER BY RE.id ASC LIMIT 1) as 'Primera_observacion',
            (SELECT U.name FROM reparacion_estados as RE LEFT JOIN tbl_users as U ON U.userId = RE.usuario WHERE RM.id = RE.orden ORDER BY RE.id ASC LIMIT 1) as 'Usuario_primer_reporte',
            (SELECT fecha FROM reparacion_estados as RE WHERE RM.id = RE.orden  ORDER BY RE.id DESC LIMIT 1) as 'Ultima_fecha',
            (SELECT observ FROM reparacion_estados as RE WHERE RM.id = RE.orden  ORDER BY RE.id DESC LIMIT 1) as 'Ultima_observacion',
            (SELECT U.name FROM reparacion_estados as RE LEFT JOIN tbl_users as U ON U.userId = RE.usuario WHERE RM.id = RE.orden  ORDER BY RE.id DESC LIMIT 1) as 'Usuario_ultimo_reporte'
            FROM reparacion_main as RM
            INNER JOIN reparacion_estados AS RE1 ON RM.id = RE1.orden
            LEFT JOIN ordenes_tipo_estados AS OTE ON OTE.id = RM.ultimo_estado
            LEFT JOIN fallas_main AS F ON F.id = RM.falla
            LEFT JOIN municipios AS MU ON MU.id = RM.idproyecto
            LEFT JOIN reparacion_categorias AS RC ON RC.id = RM.ultimo_categoria ";

      $sql .= "WHERE EXISTS (SELECT * FROM reparacion_estados as RE WHERE RM.id = RE.orden AND RE.asignado_categoria = 3) ";

      if ($tipo_orden != 0) {
        $sql .= "AND RM.ultimo_estado IN (".$tipo_orden.") ";
      }

      if ($proyecto > 0) {
        $sql .= "AND RM.idproyecto = ".$proyecto." ";
      }

      if ($role != NULL) {
        switch ($role) {
            case 100: // Gestión de Proyectos - Dirección (Directores)
                $sql .= " AND MU.director LIKE '%".$userId."%'";
                break;
            case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                $sql .= " AND MU.gerente LIKE '%".$userId."%'";
                break;
            case 102: //Gestión de Proyectos - Supervisión (Gestores)
                $sql .= " AND MU.gestor LIKE '%".$userId."%'";
                break;
            case 103: //Gestión de Proyectos (Ayudantes)
                $sql .= " AND MU.ayudantes LIKE '%".$userId."%'";
                break;
            case 104: //Gestión de Proyectos - Auditoria
                $sql .= " AND MU.auditor LIKE '%".$userId."%'";
                break;
        }
      }

      if ($fecha_desde != NULL) {
        $sql.= "AND RE1.fecha BETWEEN '".$fecha_desde."' AND '".$fecha_hasta."'";
      }

      $sql .= " GROUP BY RE1.orden
                ORDER BY RE1.orden, RE1.fecha";

      $query = $this->db->query($sql);
      return $query->result();
    }

    function getUltimaBajada($proyecto, $fecha_maxima, $role, $userId)
    {
      $sql = "SELECT PM.equipo_serie as Equipo, MUN.descrip as Proyecto, MAX(PM.fecha) as Ultima_bajada, DATEDIFF('$fecha_maxima',MAX(PM.fecha)) as Dias
          FROM `protocolos_main` as PM
          LEFT JOIN municipios as MUN ON MUN.id = PM.municipio ";

      if ($proyecto > 0) {
        $sql .= "WHERE PM.municipio = $proyecto";
      } else {
        $sql .= "WHERE PM.municipio > 0";
      }

      if ($role != NULL) {
        switch ($role) {
            case 100: // Gestión de Proyectos - Dirección (Directores)
                $sql .= " AND MUN.director LIKE '%".$userId."%'";
                break;
            case 101: //Gestión de Proyectos - Gerencia (Gerencia)
                $sql .= " AND MUN.gerente LIKE '%".$userId."%'";
                break;
            case 102: //Gestión de Proyectos - Supervisión (Gestores)
                $sql .= " AND MUN.gestor LIKE '%".$userId."%'";
                break;
            case 103: //Gestión de Proyectos (Ayudantes)
                $sql .= " AND MUN.ayudantes LIKE '%".$userId."%'";
                break;
            case 104: //Gestión de Proyectos - Auditoria
                $sql .= " AND MUN.auditor LIKE '%".$userId."%'";
                break;
        }
      }

      $sql .= " GROUP BY Equipo
          HAVING Ultima_bajada < '$fecha_maxima'
          ORDER BY Dias ASC, Proyecto ASC, Equipo ASC";

      $query = $this->db->query($sql);
      return $query->result();
    }


    function getEquiposDiasOperativos($fecha_desde, $fecha_hasta, $proyecto = FALSE, $tipo_equipo = FALSE, $serie = FALSE)
    {
        $sql = "SELECT m.descrip AS proyecto, em.serie AS equipo, IF(TRIM(em.ubicacion_calle) = '','-',em.ubicacion_calle) AS ubicacion, IF(TRIM(em.ubicacion_altura) = '','-',em.ubicacion_altura) AS altura, IF(em.ubicacion_velper = 0,'-',CONCAT(em.ubicacion_velper,' km/h')) AS vel_per, IF(em.doc_fechacal = '0000-00-00','-',DATE_FORMAT(em.doc_fechacal,'%d/%m/%Y')) AS fecha_cal, IF(em.doc_fechavto = '0000-00-00','-',DATE_FORMAT(em.doc_fechavto,'%d/%m/%Y')) AS vto_cal,
                DATEDIFF(IF(IFNULL(rm.fecha_finalizada,'{$fecha_hasta}')>'{$fecha_hasta}','{$fecha_hasta}',IFNULL(rm.fecha_finalizada,'{$fecha_hasta}')),IF(MIN(re.fecha)<'{$fecha_desde}','{$fecha_desde}',MIN(re.fecha))) AS dias_reparacion,
                ROUND((DATEDIFF(IF(IFNULL(rm.fecha_finalizada,'{$fecha_hasta}')>'{$fecha_hasta}','{$fecha_hasta}',IFNULL(rm.fecha_finalizada,'{$fecha_hasta}')),IF(MIN(re.fecha)<'{$fecha_desde}','{$fecha_desde}',MIN(re.fecha))))*100/(DATEDIFF('{$fecha_hasta}','{$fecha_desde}'))) AS porcentaje
                FROM equipos_main AS em
                JOIN reparacion_main AS rm ON em.serie = rm.serie
                JOIN reparacion_estados AS re ON rm.id = re.orden
                JOIN municipios AS m ON m.id = em.municipio
                WHERE em.eliminado = 0 AND em.serie NOT LIKE '%-baj%' AND m.activo = 1 AND rm.tipo = 'R' AND re.tipo = 3 AND
                (re.fecha BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}' OR rm.fecha_finalizada BETWEEN '{$fecha_desde}' AND '{$fecha_hasta}' OR '{$fecha_desde}' BETWEEN re.fecha AND rm.fecha_finalizada OR '{$fecha_hasta}' BETWEEN re.fecha AND rm.fecha_finalizada) ";

        if ($proyecto != FALSE) {
            $sql .= "AND em.municipio = {$proyecto} ";
        }

        if ($tipo_equipo != FALSE) {
            $sql .= "AND em.tipo = {$tipo_equipo} ";
        }

        if ($serie != FALSE) {
            $sql .= "AND rm.serie = {$serie} ";
        }

        $sql .= "GROUP BY re.orden
                ORDER BY m.descrip, em.serie";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_estadisticas_modelo($municipio,$idmodelo,$fecha_desde,$fecha_hasta){
        $this->db->select('*');
        $this->db->from('estadistica_info');
        $this->db->where('id_proyecto',$municipio);
        $this->db->where('id_modelo',$idmodelo);
        $this->db->where('fecha_ultima_medicion >=', $fecha_desde);
        $this->db->where('fecha_ultima_medicion <=', $fecha_hasta);
        $query = $this->db->get();
        return $query->result();
        //SELECT * FROM (`estadistica_info`) WHERE `id_proyecto` = '7' AND `id_modelo` = '2' AND `fecha_ultima_medicion` >= '2021/12/01' AND `fecha_ultima_medicion` <= '2021/12/30'
    }

    function listado_equipos_byModelo($proyecto = NULL, $modelo = NULL)
  {
    $this->db->select('equipos_modelos.id, equipos_main.serie, equipos_modelos.descrip');
    $this->db->from('municipios');
    $this->db->join('equipos_main', 'equipos_main.municipio = municipios.id ');
    $this->db->join('equipos_modelos', 'equipos_modelos.id = equipos_main.idmodelo');
    $this->db->where('municipios.id', $proyecto);
    $this->db->where('equipos_modelos.id', $modelo);
    $this->db->group_by('equipos_main.serie', 'ASC');

    $query = $this->db->get();
    return $query->result();
  }
  
  function listado_modelos($proyecto = NULL)
  {
    $this->db->select('equipos_modelos.id, equipos_modelos.descrip');
    $this->db->from('municipios');
    $this->db->join('equipos_main', 'equipos_main.municipio = municipios.id ');
    $this->db->join('equipos_modelos', 'equipos_modelos.id = equipos_main.idmodelo');
    $this->db->where('municipios.id', $proyecto);
    $this->db->group_by('equipos_modelos.id', 'ASC');

    $query = $this->db->get();
    return $query->result();
  }

  function estadisticas_vel($serie,$fecha_desde,$fecha_hasta)
  {
    $this->db->select(' OM.protocolo , PM.fecha , EV.carril , EV.velocidad , EV.fecha_toma');
    $this->db->from('ordenesb_main AS OM');
    $this->db->join('protocolos_main AS PM', 'PM.id = OM.protocolo','left');
    $this->db->join('estadisticas_archivos AS EA', 'OM.id = EA.id_orden','right');
    $this->db->join('estadisticas_velocidad AS EV', 'EV.id_archivo= EA.id','left');
    $this->db->where('OM.idequipo', $serie);
    $this->db->where('OM.transferido_tipo != 2');
    $this->db->where('PM.fecha >=', $fecha_desde);
    $this->db->where('PM.fecha <=', $fecha_hasta);

    $query = $this->db->get();
    return $query->result();
  }

  function estadisticas_enf($serie,$fecha_desde,$fecha_hasta){
    $this->db->select(' OM.protocolo , PM.fecha ,EE.livianos,EE.pesados , EE.livianos_exc ,EE.pesados_exc , EE.errores , EE.ultima_medicion , EA.protocolo');
    $this->db->from('ordenesb_main AS OM');
    $this->db->join('protocolos_main AS PM', 'PM.id = OM.protocolo','left');
    $this->db->join('estadisticas_archivos AS EA', 'OM.id = EA.id_orden','right');
    $this->db->join('estadisticas_enforcer AS EE', 'EE.id_archivo= EA.id','left');
    $this->db->where('EA.procesado = 1 ');
    $this->db->where('OM.idequipo', $serie);
    $this->db->where('OM.transferido_tipo != 2');
    $this->db->where('PM.fecha >=', $fecha_desde);
    $this->db->where('PM.fecha <=', $fecha_hasta);
    $this->db->order_by('EA.protocolo' , 'asc');
    $this->db->order_by('EE.ultima_medicion' , 'asc');

    $query = $this->db->get();
    return $query->result();
    }

    function reportes_sistemas($fecha_desde, $fecha_hasta)
    {
        $this->db->select("SUM(PM.cantidad) AS cantidad_archivos_mrm,SUM(OM.subida_envios / EMOD.divide_x ) as registros, SUM(PM.info_editables) AS editables, SUM(PM.info_filtro_velocidad) AS info_filtro_velocidad, SUM(OM.subida_envios) as envios_ingreso, SUM(OM.subida_ingresados) as envios_ingresados");
        $this->db->from('protocolos_main AS PM');
        $this->db->join('ordenesb_main AS OM ','OM.protocolo = PM.id','left');
        $this->db->join('equipos_main AS EM ',' EM.id = PM.idequipo','left');
        $this->db->join('equipos_modelos AS EMOD ',' EMOD.id = EM.idmodelo','left');
        $this->db->where('PM.remoto', '0') ;
        $this->db->where('PM.fecha >=', $fecha_desde);
        $this->db->where('PM.fecha <=', $fecha_hasta);

        $query = $this->db->get();
        return $query->result();
    }


    
  //-------------------QUERYS PARA SALIDA DE EDICION----------------------


 public function getProtocoloSalidaEdicion($municipio, $incorporacion_estado, $decripto, $estado)
 {
     $sql = "SELECT id FROM protocolos_main WHERE municipio = $municipio AND incorporacion_estado = $incorporacion_estado AND decripto = $decripto AND estado = $estado;";
     $query = $this->db->query($sql);
     $protocolos = $query->result();

     return $protocolos;
 }

 public function getSerie($protocolo)
{

 $sql = "SELECT equipo_serie FROM protocolos_main WHERE id = $protocolo;";
    
$query = $this->db->query($sql);
$serie = $query->result();
return $serie;

}

public function getMunicipioEdicion($protocolo){
    $sql = "SELECT municipio FROM protocolos_main WHERE id = $protocolo";
    $query = $this->db->query($sql);
    return $query->result()[0]->municipio;
}

public function updateProtocoloMain($protocolo)
{
    $sql = "UPDATE protocolos_main SET incorporacion_estado = 63 WHERE id = $protocolo";
    $query = $this->db->query($sql);
    $query->result;   
}

public function salida_edicion($incorporacion_estado, $decripto, $estado ,$municipio)
{
    
    $sql = "SELECT id, municipio, equipo_serie,fecha_inicial, fecha_final, cantidad, numero_exportacion ,archivos, registros, idexportacion, info_editables, info_edicion, info_aprobados, info_descartados, info_verificacion FROM protocolos_main WHERE municipio = $municipio AND incorporacion_estado = $incorporacion_estado AND decripto = $decripto AND estado = $estado;"; //LIMIT 10;

    $query = $this->db->query($sql);
    $protocolos = $query->result();

    return $protocolos;
}

//esta no haria falta
public function getTipoEquipo($protocolo)
{
    $sql =  "SELECT tipo FROM equipos_main LEFT JOIN protocolos_main ON protocolos_main.idequipo = equipos_main.id WHERE protocolos_main.id = $protocolo;";
    $query = $this->db->query($sql);
    $tipoEquipo = $query->result();
    return $tipoEquipo; 
}







}
