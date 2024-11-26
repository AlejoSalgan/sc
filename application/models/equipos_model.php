<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Equipos_model extends CI_Model
{
    

    function equiposListingCount($searchText = '', $searchNum = '', $columna = '',$criterio, $evento = NULL, $userId, $role,$calib = '', $grupoGestor = NULL,$fecha='')
    {
        $sql = "SELECT EM.id FROM (equipos_main as EM)
        LEFT JOIN municipios as Mun ON Mun.id = EM.municipio
        LEFT JOIN equipos_modelos as EMod ON EMod.id = EM.idmodelo
        LEFT JOIN equipos_marcas as EMarc ON EMarc.id = EM.marca
        LEFT JOIN estados as ES ON ES.id = EM.estado
        LEFT JOIN eventos as EV ON EV.id = EM.evento_actual
        LEFT JOIN tbl_users as G ON G.userId = Mun.gestor ";

        if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
        }

        switch ($role) {
          case 60:
          case 61:
          case 62:
          case 63: //Socios.
                  $sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMod.asociado";
                  $sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
             break;

          default:
                  $sql .= " LEFT JOIN equipos_propietarios as P ON P.id = EM.idpropietario ";
            break;
        }

          $sql .= "WHERE EM.eliminado = 0 AND EM.serie NOT LIKE '%-baj%' ";

        switch ($role) {
               case 60:
               case 61:
               case 62:
               case 63:
                       $sql .= " AND U.userId LIKE '%" . $userId . "%'";
                  break;
        }

        if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $sql .= " AND (EM.serie LIKE '%{$searchText}%')";
                    break;

                case 2:
                    $sql .= " AND (EMod.descrip LIKE '%{$searchText}%')";
                    break;

                case 3:
                    $sql .= " AND (EMarc.descrip LIKE '%{$searchText}%')";
                    break;

                case 4:
                    $sql .= " AND (EMod.asociado LIKE '%{$searchText}%')";
                    break;

                case 5:
                    $sql .= " AND (Mun.descrip LIKE '%{$searchText}%')";
                    break;

                case 6:
                    $sql .= " AND (ES.descrip LIKE '%{$searchText}%')";
                    break;

                case 7:
                    $sql .= " AND (EV.descrip LIKE '%{$searchText}%')";
                    break;

                case 8:
                    $sql .= " AND (P.descrip LIKE '%{$searchText}%')";
                    break;

                case 10:
                    $sql .= " AND (EM.ubicacion_calle LIKE '%{$searchText}%')";
                    break;

                default:
                    $sql .= " AND (EMod.descrip LIKE '%{$searchText}%'  OR EM.serie LIKE '%{$searchText}%'  OR Mun.descrip LIKE '%{$searchText}%' OR EMarc.descrip LIKE '%{$searchText}%' OR EMod.asociado LIKE '%{$searchText}%' OR ES.descrip LIKE '%{$searchText}%' OR P.descrip LIKE '%{$searchText}%' OR EV.descrip LIKE '%{$searchText}%' OR EM.ubicacion_calle LIKE '%{$searchText}%')";
                    break;
            }
        }
        if(!empty($searchNum)) {
            $sql .= " AND EM.{$columna} = {$searchNum}";
        }
        if(is_numeric($evento)) {
            $sql .= " AND EM.evento_actual = {$evento}";
        }

        if(!empty($calib)) {
            $sql .= " AND EM.doc_fechavto IS NOT NULL
                      AND EM.doc_fechavto != '0000-00-00'
                      AND EM.activo = 1
                      AND DATEDIFF(NOW(),EM.doc_fechavto) >= -60
                      AND (EM.doc_fechavto > NOW()
                      OR EM.doc_fechavto <= NOW())
            ";
        }

        if(!empty($fecha)) {
            //$sql .= " AND '".$fecha."' >= ts AND estado = 2";
            $sql .= " AND  ts >= '".$fecha."' AND estado = 2";
        }

        if (in_array($role,array(101,102,103,104,105)) && empty($searchText)) {
          $sql .= " AND EM.activo = 1";
        }

        if (empty($searchText)) {
          $sql .= " AND EM.activo = 1";
        }


        if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " ORDER BY MA.prioridad = 1 DESC";
        }

        $query = $this->db->query($sql);
        return count( $query->result() );
    }

    function equiposListing($searchText = '', $page, $segment, $searchNum = '', $columna = '',$criterio, $evento = NULL, $userId, $role, $calib = '', $grupoGestor = NULL, $fecha = '' )
    {
        $sql = "SELECT EM.id, EM.solicitud_bajada, EM.operativo, EM.idmodelo AS idmodelo, EM.serie, EM.ubicacion_calle, EM.ubicacion_altura, EM.activo, EM.requiere_calib, EM.idmodelo AS idmodelo2, EM.doc_fechavto, EM.estado, EM.evento_actual, Mun.descrip, EMod.descrip AS modelo, EMod.asociado AS descripAsociado, EMarc.descrip AS marca,ES.descrip AS descripEstado, EV.descrip AS descripEvento, P.descrip AS descripProp, EM.ts, Mun.gestor, G.name AS nombreGestor, EM.prueba, EM.tipo, ES.id AS lugarID, ET.bajada, CS.prorroga_bajada, EM.tipo_equipo, (SELECT UG.name
        FROM `municipios_asignaciones` as MA2
        LEFT JOIN tbl_users as UG ON UG.userId = MA2.usuario
        WHERE Mun.id = MA2.id_proyecto
        AND UG.roleId = 102 AND MA2.prioridad = 1
        ) AS 'gestor_name',

        (SELECT PE.id_tipo
        FROM `perifericos` as PE
        WHERE EM.id = PE.id_equipo
        AND PE.id_tipo = 2 LIMIT 1
        ) AS 'comunicador',

        (SELECT PE.id_tipo
        FROM `perifericos` as PE
        WHERE EM.id = PE.id_equipo
        AND PE.id_tipo = 1 LIMIT 1
        ) AS 'iluminador'

        FROM (equipos_main as EM)
        LEFT JOIN municipios as Mun ON Mun.id = EM.municipio
        LEFT JOIN equipos_modelos as EMod ON EMod.id = EM.idmodelo
        LEFT JOIN equipos_marcas as EMarc ON EMarc.id = EM.marca
        LEFT JOIN estados as ES ON ES.id = EM.estado
        LEFT JOIN eventos as EV ON EV.id = EM.evento_actual
        LEFT JOIN equipos_tipos as ET ON ET.id = EM.tipo
        LEFT JOIN calibraciones_servicios as CS ON CS.verificacion = EM.doc_certif
        LEFT JOIN tbl_users as G ON G.userId = Mun.gestor";

        if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " LEFT JOIN municipios_asignaciones as MA ON MA.id_proyecto = Mun.id ";
        }

        switch ($role) {
          case 60:
          case 61:
          case 62:
          case 63: //Socios.
                  $sql .= " LEFT JOIN equipos_propietarios as P ON P.descrip = EMod.asociado";
                  $sql .= " LEFT JOIN tbl_users as U ON U.asociado = P.id ";
             break;

          default:
                  $sql .= " LEFT JOIN equipos_propietarios as P ON P.id = EM.idpropietario ";
            break;
        }

          $sql .= " WHERE EM.eliminado = 0 AND EM.serie NOT LIKE '%-baj%' ";

        switch ($role) {
               case 60:
               case 61:
               case 62:
               case 63:
                       $sql .= " AND U.userId LIKE '%" . $userId . "%'";
                  break;
        }

        if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " AND MA.usuario = {$userId}";
        }

        if(!empty($searchText)) {
            switch ($criterio) {
                case 1:
                    $sql .= " AND (EM.serie LIKE '%{$searchText}%')";
                    break;

                case 2:
                    $sql .= " AND (EMod.descrip LIKE '%{$searchText}%')";
                    break;

                case 3:
                    $sql .= " AND (EMarc.descrip LIKE '%{$searchText}%')";
                    break;

                case 4:
                    $sql .= " AND (EMod.asociado LIKE '%{$searchText}%')";
                    break;

                case 5:
                    $sql .= " AND (Mun.descrip LIKE '%{$searchText}%')";
                    break;

                case 6:
                    $sql .= " AND (ES.descrip LIKE '%{$searchText}%')";
                    break;

                case 7:
                    $sql .= " AND (EV.descrip LIKE '%{$searchText}%')";
                    break;

                case 8:
                    $sql .= " AND (P.descrip LIKE '%{$searchText}%')";
                    break;

                case 10:
                    $sql .= " AND (EM.ubicacion_calle LIKE '%{$searchText}%')";
                    break;

                default:
                    $sql .= " AND (EMod.descrip LIKE '%{$searchText}%'  OR EM.serie LIKE '%{$searchText}%'  OR Mun.descrip LIKE '%{$searchText}%' OR EMarc.descrip LIKE '%{$searchText}%' OR EMod.asociado LIKE '%{$searchText}%' OR ES.descrip LIKE '%{$searchText}%' OR P.descrip LIKE '%{$searchText}%' OR EV.descrip LIKE '%{$searchText}%' OR EM.ubicacion_calle LIKE '%{$searchText}%')";
                    break;
            }

        }
        if(is_numeric($searchNum)) {
             $sql .= " AND EM.{$columna} = {$searchNum}";
        }
        if(is_numeric($evento)) {
            $sql .= " AND EM.evento_actual = {$evento}";
        }

        if(!empty($calib)) {
            $sql .= " AND EM.doc_fechavto IS NOT NULL
                      AND EM.doc_fechavto != '0000-00-00'
                      AND EM.activo = 1
                      AND DATEDIFF(NOW(),EM.doc_fechavto) >= -60
                      AND (EM.doc_fechavto > NOW()
                      OR EM.doc_fechavto <= NOW())
            ";
        }

        if(!empty($fecha)) {
            $sql .= " AND  ts >= '".$fecha."' AND estado = 2";
        }

        if (in_array($role,array(101,102,103,104,105)) && empty($searchText)) {
          $sql .= " AND EM.activo = 1";
        }

        if (in_array($role,array(101,102,103,104,105))) {
          $sql .= " ORDER BY MA.prioridad = 1 DESC, EM.serie ASC ";
        } else {
          if (!empty($searchText)) {
            $sql .= " ORDER BY EM.serie ASC ";
          }
        }

        $segment = ( $segment == FALSE ) ? 0 : $segment;
        $sql .= " LIMIT  $segment, $page  ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function getEquiposTipos()
    {
        $this->db->select('id, descrip');
        $this->db->from('equipos_tipos');
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getEquiposTipo($idtipo_ant)
    {
        $this->db->select('descrip');
        $this->db->from('equipos_tipos');
        $this->db->where('id', $idtipo_ant);
        $query = $this->db->get();

        $result = $query->row();
        return $result->descrip;
    }


    function getEquiposMarcas()
    {
        $this->db->select('id, descrip');
        $this->db->from('equipos_marcas');
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getEquiposMarca($idmarca_ant)
    {
        $this->db->select('descrip');
        $this->db->from('equipos_marcas');
        $this->db->where('id', $idmarca_ant);

        $query = $this->db->get();

        $result = $query->row();
        return $result->descrip;
}


    function getEquiposModelos()
    {
            $this->db->select('id, descrip, sigla, sistemas_aprob');
            $this->db->from('equipos_modelos');
            $this->db->order_by('descrip', 'asc');
            $query = $this->db->get();

            return $query->result();
    }

    function getEquiposModelo($idmodelo_ant)
    {
            $this->db->select('descrip');
            $this->db->from('equipos_modelos');
            $this->db->where('id', $idmodelo_ant);

            $query = $this->db->get();

            $result = $query->row();
            return $result->descrip;
    }


    function getEquiposPropietarios($asociado = NULL)
    {
        $this->db->select('id, descrip');
        $this->db->from('equipos_propietarios');
        if ($asociado != NULL) {
            $this->db->where('asociado', $asociado);
        }
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getEquiposPropietario($idpropietario_ant)
    {
            $this->db->select('descrip');
            $this->db->from('equipos_propietarios');
            $this->db->where('id', $idpropietario_ant);

            $query = $this->db->get();

            $result = $query->row();
            return $result->descrip;
    }

    function getEstados()
    {
        $this->db->select('id, descrip');
        $this->db->from('estados');
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getEstadosPorProyectos($proyecto)//Cuantos equipos estan en cada estado segun el proyecto.
    {
        $this->db->select('COUNT(*) as cantidad,E.descrip');
        $this->db->from('equipos_main as EM');
        $this->db->join('estados as E','E.id = EM.estado','left');
        $this->db->where('municipio', $proyecto);
        $this->db->group_by('estado');

        $query = $this->db->get();
        return $query->result();
    }

    function getTiposPorProyectos($proyecto)//Cuantos tipos de equipos hay segun el proyecto.
    {
        $this->db->select('COUNT(*) as cantidad,ET.descrip');
        $this->db->from('equipos_main as EM');
        $this->db->join('equipos_tipos as ET','ET.id = EM.tipo','left');
        $this->db->where('municipio', $proyecto);
        $this->db->group_by('tipo');

        $query = $this->db->get();
        return $query->result();
    }

    function getEquiposPorProyectos($proyecto)//Cuantos equipos hay en el proyecto.
    {
        $this->db->select('COUNT(*) as cantidad');
        $this->db->from('equipos_main as EM');
        $this->db->where('municipio', $proyecto);

        $query = $this->db->get();

        $row = $query->row();
        return $row;
    }

    function getEstado($idestado_ant)
    {
            $this->db->select('descrip');
            $this->db->from('estados');
            $this->db->where('id', $idestado_ant);

            $query = $this->db->get();

            $result = $query->row();
            return $result->descrip;
    }

    function getEvento($idevento_ant)
    {
            $this->db->select('descrip');
            $this->db->from('eventos');
            $this->db->where('id', $idevento_ant);

            $query = $this->db->get();

            $result = $query->row();
            return $result->descrip;
    }

    function getSerie($idequipo)
    {
            $this->db->select('serie');
            $this->db->from('equipos_main');
            $this->db->where('id', $idequipo);
            $query = $this->db->get();

            $result = $query->row();
            return $result->serie;
    }


    function addNewEquipo($equipoInfo)
    {
        $this->db->trans_start();
        $this->db->insert('equipos_main', $equipoInfo);

        $insert_id = $this->db->insert_id();

        $this->db->trans_complete();

        return $insert_id;
    }


    function getAsociados()
    {
        $this->db->select('id, descrip');
        $this->db->from('equipos_propietarios');
        $this->db->where('asociado =', 1);
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }

    function getSocio($id_socio)
    {
            $this->db->select('descrip');
            $this->db->from('equipos_propietarios');
            $this->db->where('asociado =', 1);
            $this->db->where('id', $id_socio);
            $query = $this->db->get();

            $result = $query->row();
            return $result->descrip;
    }


    function getTipoEquipo()
    {
        $this->db->select('id, tipo_equipo');
        $this->db->from('equipos_main');
        $this->db->where('tipo_equipo =', 1);
        $query = $this->db->get();

        return $query->result();
    }

    public function getIDEvento($equipoId){
        $this->db->select('evento_actual');
        $this->db->from('equipos_main');
        $this->db->where('id', $equipoId);

        $query = $this->db->get();
        $result = $query->row();

        return $result->evento_actual;
    }

    public function getIDEstado($equipoId){
        $this->db->select('estado');
        $this->db->from('equipos_main');
        $this->db->where('id', $equipoId);

        $query = $this->db->get();
        $result = $query->row();

        return $result->estado;
    }

    public function getIDmunicipio($equipoId){
        $this->db->select('municipio');
        $this->db->from('equipos_main');
        $this->db->where('id', $equipoId);

        $query = $this->db->get();
        $result = $query->row();

        return $result->municipio;
    }

    public function getPropietario($serie){ //Propietario del equipo.
        $this->db->select('P.descrip');
        $this->db->from('equipos_main as E');
        $this->db->join('equipos_propietarios as P', 'P.id = E.idpropietario','left');
        $this->db->where('E.serie', $serie);

        $query = $this->db->get();
        $result = $query->row();

        return $result->descrip;
    }


    public function getOperativo($id_equipo){
        $this->db->select('operativo');
        $this->db->from('equipos_main');
        $this->db->where('id', $id_equipo);

        $query = $this->db->get();
        $result = $query->row();

        return $result->operativo;
    }

    function getEquipoInfo($equipoId)
    {
        $this->db->select('E.id, E.operativo, E.serie, E.serie_int, E.decriptador, E.ftp_host, E.ftp_user, E.ftp_pass, E.tipo, E.municipio, E.exportable, E.marca, E.modelo, E.idmodelo, E.activo, E.remito, E.ejido_urbano, E.observ, E.fecha_ultmod, E.instalado, E.requiere_calib, E.calibrado, E.evento_actual, E.idpropietario, E.estado, E.ts, ETip.descrip AS descrip_tipo, E.ubicacion_calle, E.ubicacion_altura, E.ubicacion_mano, E.ubicacion_sentido, E.ubicacion_localidad, E.ubicacion_cp, E.ubicacion_velper, E.geo_lat, E.geo_lon, E.doc_certif, E.doc_aprob, E.doc_normasic, E.doc_distancia, E.nro_ot, E.doc_fechacal, E.doc_informe, E.nro_ot, Mun.descrip AS descripMunicipio, P.descrip AS descripPropietario, ES.descrip AS descripEstado, EV.descrip AS descripEvento, E.doc_fechavto, E.vehiculoasig, F.dominio, E.multicarril, E.carril_sentido, EMarc.descrip AS descripMarca, EMod.descrip AS descripModelo, E.pedido, E.ordencompra, G.name AS nombreGestor, G.email as emailGestor, PROP.descrip as prop_descrip, ETip.bajada, E.velocidad_min');
        // , ORD.bajada_lat AS bajadaOrden_lat, ORD.bajada_long AS bajadaOrden_long, ORD.id AS idOrdenes, ORD.protocolo AS protocoloId
        $this->db->from('equipos_main as E');
        $this->db->join('flota_main as F','F.id = E.vehiculoasig','left');
        $this->db->join('equipos_tipos as ETip', 'ETip.id = E.tipo','left');
        // $this->db->join('ordenesb_main as ORD', 'ORD.idequipo = E.id','left');
        $this->db->join('municipios as Mun', 'Mun.id = E.municipio','left');
        $this->db->join('equipos_propietarios as P', 'P.id = E.idpropietario','left'); //P. descrip
        $this->db->join('equipos_modelos as EMod', 'EMod.id = E.idmodelo','left');
        $this->db->join('equipos_marcas as EMarc', 'EMarc.id = E.marca','left');
        $this->db->join('estados as ES', 'ES.id = E.estado','left');
        $this->db->join('eventos as EV', 'EV.id = E.evento_actual','left');
        $this->db->join('tbl_users as G','G.userId = Mun.gestor','left');
        $this->db->join('equipos_propietarios as PROP', 'PROP.id = Mun.adminstracion','left');
        $this->db->where('E.id', $equipoId);
        // $this->db->order_by("ORD.id", "desc");
        $this->db->limit(1);

        $query = $this->db->get();
        $result_query_local = $query->result();

        // bloque para añadir data de ordenesb_main a la consulta local
        $responseAPI = json_decode(callAPI("GET", API_FACTORY["ordenb_get_by_field"]["development"] . "?field=idequipo&operator==&value=$equipoId"));
        usort($responseAPI, function($a, $b) {
            $idA = intval($a->id);
            $idB = intval($b->id);
            // return $idA <=> $idB; // Ordena de manera ASC
            return $idB <=> $idA; // Ordena de manera DESC
        });
        $result_query_local[0]->bajadaOrden_lat = $responseAPI[0]->bajada_lat;
        $result_query_local[0]->bajadaOrden_long = $responseAPI[0]->bajada_long;
        $result_query_local[0]->idOrdenes = $responseAPI[0]->id;
        $result_query_local[0]->protocoloId = $responseAPI[0]->protocolo;
        // fin bloque

        return $result_query_local;
    }

    function equipoInfo($id_equipo) // Informacion por ROW cambiar a futuro en todas las funciones donde llaman a un equipo.
    {
        $this->db->select('E.id, E.operativo, E.activo, E.solicitud_bajada,  E.serie, E.serie_int, E.decriptador, E.ftp_host, E.ftp_user, E.ftp_pass, E.tipo, E.municipio, E.exportable, E.marca, E.modelo, E.idmodelo,  E.remito, E.ejido_urbano, E.observ, E.fecha_ultmod, E.instalado, E.requiere_calib, E.calibrado, E.evento_actual, E.idpropietario, E.estado, E.ts, ETip.descrip AS descrip_tipo, E.ubicacion_calle, E.ubicacion_altura, E.ubicacion_mano, E.ubicacion_sentido, E.ubicacion_localidad, E.ubicacion_cp, E.ubicacion_velper, E.geo_lat, E.geo_lon, E.doc_certif, E.doc_aprob, E.doc_normasic, E.doc_distancia, E.nro_ot, E.doc_fechacal, E.doc_informe, E.nro_ot, Mun.descrip AS descripMunicipio, P.descrip AS descripPropietario, ES.descrip AS descripEstado, EV.descrip AS descripEvento, E.doc_fechavto, E.vehiculoasig, F.dominio, E.multicarril, E.carril_sentido, EMarc.descrip AS descripMarca, EMod.descrip AS descripModelo, E.pedido, E.ordencompra, ORD.bajada_lat AS bajadaOrden_lat, ORD.bajada_long AS bajadaOrden_long, ORD.id AS idOrdenes, ORD.protocolo AS protocoloId, G.name AS nombreGestor, G.email as emailGestor, PROP.descrip as prop_descrip, ETip.bajada');
        $this->db->from('equipos_main as E');
        $this->db->join('flota_main as F','F.id = E.vehiculoasig','left');
        $this->db->join('equipos_tipos as ETip', 'ETip.id = E.tipo','left');
        $this->db->join('ordenesb_main as ORD', 'ORD.idequipo = E.id','left');
        $this->db->join('municipios as Mun', 'Mun.id = E.municipio','left');
        $this->db->join('equipos_propietarios as P', 'P.id = E.idpropietario','left'); //P. descrip
        $this->db->join('equipos_modelos as EMod', 'EMod.id = E.idmodelo','left');
        $this->db->join('equipos_marcas as EMarc', 'EMarc.id = E.marca','left');
        $this->db->join('estados as ES', 'ES.id = E.estado','left');
        $this->db->join('eventos as EV', 'EV.id = E.evento_actual','left');
        $this->db->join('tbl_users as G','G.userId = Mun.gestor','left');
        $this->db->join('equipos_propietarios as PROP', 'PROP.id = Mun.adminstracion','left');
        $this->db->where('E.id', $id_equipo);

        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }


    function getCalibracionInfo($equipoId)
    {
        $this->db->select("id AS id_calib, idequipo, descrip AS descrip_calib, DATE_FORMAT(fecha, '%d-%m-%Y') AS fecha_calib, nro_ot", FALSE);
        $this->db->from('calibraciones');
        $this->db->where('idequipo', $equipoId);
        $this->db->order_by("fecha", "desc");
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->result();
    }


    function getEquipoComponentes($equipoId)
    {
        $this->db->select('C.id, C.serie, C.idequipo, C.descrip, CT.descrip AS descripTipo, CM.descrip AS descripMarca, E.descrip AS evento_actual');
        $this->db->from('componentes_main AS C');
        $this->db->join('componentes_tipo as CT', 'C.idtipo = CT.id','left');
        $this->db->join('componentes_marca as CM', 'C.idmarca = CM.id','left');
        $this->db->join('eventos as E', 'C.evento_actual = E.id','left');
        $this->db->where('idequipo', $equipoId);
        $query = $this->db->get();

        return $query->result();
    }


    function editEquipo($equipoInfo, $equipoId)
    {
        $this->db->where('id', $equipoId);
        $this->db->update('equipos_main', $equipoInfo);

        return TRUE;
    }

    function deleteEquipo($equipoid, $equipoInfo)
    {
        $this->db->where('id', $equipoid);
        $this->db->update('equipos_main', $equipoInfo);

       // return $this->db->affected_rows();
        return $equipoInfo;
    }

    function getEquipos($proyecto = FALSE, $filtro = NULL, $operativo = NULL, $equiposCalibrar = NULL)
    {
    	$this->db->select("equipos_main.id, serie, eventos.descrip, evento_actual, estado, equipos_main.tipo, ubicacion_calle, ubicacion_altura, ubicacion_localidad, doc_fechavto, operativo, ES.descrip as estado_descrip",FALSE);
    	if (!is_null($filtro)) {
    	    $this->db->select("MIN(IFNULL(ordenesb_main.protocolo,'0')) as protocolo, MIN(IFNULL(ordenesb_main.id,'0')), MIN(ordenesb_main.activo) as o_activo",FALSE);
    	}

    	$this->db->join('eventos', 'eventos.id = equipos_main.evento_actual','left');
      $this->db->join('equipos_tipos as ET', 'ET.id = equipos_main.tipo','left');
      $this->db->join('estados as ES', 'ES.id = equipos_main.estado','left');

    	if (!is_null($filtro)) {
    		$this->db->join('ordenesb_main', 'ordenesb_main.idequipo = equipos_main.id','left');
    		$this->db->group_by('id');
    	}
    	if ($proyecto) {
    		$this->db->where('municipio', $proyecto);
    	}
    	$this->db->not_like('equipos_main.serie','-baj');
    	$this->db->where('equipos_main.serie !=','');
    	$this->db->where("(equipos_main.activo = 1 AND equipos_main.eliminado = 0)");

      if ($operativo != NULL) { // Solo equipos operativos para bajada de memoria.
        //Consulto los dias que se extienden para bajar el equipo despues de su vencimiento.
        $this->db->join('calibraciones_servicios', 'calibraciones_servicios.verificacion = equipos_main.doc_certif','left');
        //El equipo tiene que tener operativo 1 para que se puede bajar.
        //La aprobacion del gestor (Solicitud de bajada).
        //Tiene que estar en el proyecto (Estado 2).
        //Tiene que ser un tipo de equipo que se puede bajar (ET.bajada).
        $this->db->where('equipos_main.operativo',$operativo);
        $this->db->where('equipos_main.solicitud_bajada',1);
        $this->db->where('equipos_main.estado',2);
        $this->db->where('ET.bajada',1);
        //En caso ue sea un tipo de velocidad se tiene que verficar la fecha de vencimiento de la calibracion (equiposCalibrar),
        $where = "(
          IF( equipos_main.tipo IN (". implode( ",",$equiposCalibrar ).") , equipos_main.doc_fechavto IS NOT NULL
          AND equipos_main.doc_fechavto != '0000-00-00'
          AND equipos_main.doc_fechavto > '2020-03-18'
          AND DATEDIFF( NOW( ) , equipos_main.doc_fechavto ) <= IF(equipos_main.tipo_equipo != 1, calibraciones_servicios.prorroga_bajada, 0), TRUE))";
        $this->db->where($where);
      }

    	if (!is_null($filtro)) {
        	$this->db->order_by("ISNULL(eventos.descrip)", "asc");
        	$this->db->order_by("eventos.descrip", "asc");
    	}
    	$this->db->order_by("equipos_main.serie", "asc");
    	$query = $this->db->get('equipos_main');

    	return $query->result();
    }





    function getEquipo($idequipo)
    {
    	$this->db->select('em.id as em_id, et.id as et_id, ubicacion_calle, ubicacion_altura, ubicacion_localidad, descrip, ubicacion_velper, multicarril,ubicacion_sentido, doc_fechavto');
    	$this->db->where('em.id',$idequipo);
    	$this->db->join('equipos_tipos as et', 'et.id = em.tipo','inner');
    	$query = $this->db->get('equipos_main as em');
    	$result = $query->result();
    	return $result[0];
    }

    function getEquiposFijos()
    {
        $this->db->select("geo_lat, geo_lon, serie, ubicacion_calle, ubicacion_altura, equipos_main.id, municipios.id as m_id, estados.descrip as descripEstado");
        $this->db->join('municipios','equipos_main.municipio = municipios.id');
        $this->db->join('estados','equipos_main.estado = estados.id');
        $this->db->not_like('equipos_main.serie','-baj');
        $this->db->where('equipos_main.serie !=','');
        $this->db->where('equipos_main.geo_lat !=','');
        $this->db->where('equipos_main.geo_lon !=','');
        $this->db->where('equipos_main.geo_lat !=',0);
        $this->db->where('equipos_main.geo_lon !=',0);
        $this->db->where('municipios.activo',1);

        $this->db->where("(equipos_main.activo = 1 AND equipos_main.eliminado = 0)");

        $this->db->order_by('serie', 'asc');

        $query = $this->db->get('equipos_main');

        return $query->result();
    }

    function getEquiposFijos2()
    {
    	$this->db->select("geo_lat, geo_lon, serie, ubicacion_calle, ubicacion_altura, equipos_main.id, municipios.id as m_id");
  		$this->db->join('municipios','equipos_main.municipio = municipios.id');
  		$this->db->where('tipo_equipo',0);
  		$this->db->where('municipios.activo',1);
  		$this->db->not_like('equipos_main.serie','-baj');
  		$this->db->where('serie !=','');
  		$this->db->where("(equipos_main.activo = 1 AND equipos_main.eliminado = 0)");
    	$this->db->order_by('serie', 'asc');

    	$query = $this->db->get('equipos_main');
    	return $query->result();
    }

    function existeAsociado($equipo_serie)
    {
      $this->db->select('EM.idmodelo, EMod.asociado');
      $this->db->from('equipos_main as EM');
      $this->db->join('equipos_modelos as EMod', 'EMod.id = EM.idmodelo','left');
      $this->db->where('EM.serie',$equipo_serie);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }


    function getRemotos($proyecto = NULL)
    {
      $this->db->select('PE.id, EM.serie, EM.id as id_equipo');
      $this->db->from('perifericos as PE');
      $this->db->join('equipos_main as EM', 'EM.id = PE.id_equipo','left');
      $this->db->where('PE.estado',1);
      $this->db->where('PE.comunicacion',1);
      $this->db->where('EM.municipio',$proyecto);
      $this->db->order_by('EM.serie',"ASC");

      $query = $this->db->get();
      return $query->result();
    }

    function campoCarril(&$carrilSentido){
        $carrilSentido = array_filter(explode(",", $carrilSentido));
        for ($i = 0; $i < count($carrilSentido); $i++) {
            $aux = str_split($carrilSentido[$i], 1);
            if($aux[1] == "A"){
                $aux[0].=" ";
                $aux[1].="sc. ";
                $carrilSentido[$i] = $aux[0].$aux[1];
            }else{
                $aux[0].=" ";
                $aux[1].="esc. ";
                $carrilSentido[$i] = $aux[0].$aux[1];
            }
        }
    }
    function getIDxSerie($serie)
    {
            $this->db->select('id');
            $this->db->from('equipos_main');
            $this->db->where('serie', $serie);
            $query = $this->db->get();

            $result = $query->row();
            return $result->id;
    }



    function traerListaProyecto()
    {
        $this->db->select('E.serie, E.municipio, E.id');
        $this->db->from('equipos_main AS E');
        $this->db->where('E.serie <>', "");
        $this->db->where('E.activo', 1);
        $query = $this->db->get();
        return $query->result();
    }




    function getEquiposBajada()
    {
        $this->db->select('E.serie, E.municipio, E.id');
        $this->db->from('equipos_main AS E');
        $this->db->where('E.activo', 1);
        $this->db->not_like('E.serie','-baj');
        $this->db->where('E.serie !=','');
        $this->db->where("(E.activo = 1 AND E.eliminado = 0)");
        $this->db->where('E.operativo',1);
        $this->db->where('E.estado',2);
        $this->db->where('E.solicitud_bajada',1);

        $query = $this->db->get();
        return $query->result();
    }

    /* ------------- METODOS API ------------- */

    function getAll() {
        $this->db->select('*');
        $this->db->from('equipos_main');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get($queryParams = array()) {

        $fields = $queryParams["fields"] ?? "*";
        $where = $queryParams["where"];
        $wherein = $queryParams["wherein"];
        $joins = $queryParams["joins"]; //lionel
        $orderBy = $queryParams["orderby"];
        
        $fields = is_array($fields) ? join(",", $fields) : $fields;
        // $join = is_array($join) ? join(",", $join) : $join;

        $this->db->select($fields);
        $this->db->from('equipos_main');

        if($joins) { //lionel

            foreach ($joins as $join) {

                $join_explode = explode(",", $join);
                $this->db->join($join_explode[0], $join_explode[1], $join_explode[2]);
                //$this->db->join("empresas", "empresas.sedeId = equipos_main.id", "left");
            }

        }
        if($where) {
            $this->db->where($where[0], $where[1]);
        }
        if($wherein) {
            $this->db->where_in($wherein[0], explode(',', $wherein[1]));
        }
        if($orderBy) {
            $this->db->order_by($orderBy[0], $orderBy[1]);
        }
        $query = $this->db->get();
        // return $joins;
        // return $this->db->last_query();
        
        return $query->result();
    }

    function get_data_tabla_relacionada($queryParams = array())
    {
        $tabla = $queryParams["tabla"];
        $fields = $queryParams["fields"] ?? "*";
        $where = $queryParams["where"];
        $wherein = $queryParams["wherein"];
        $orderBy = $queryParams["orderby"];
        $fields = is_array($fields) ? join(",", $fields) : $fields;
        $this->db->select($fields);
        $this->db->from($tabla);
        if($where) {
            $this->db->where($where[0], $where[1]);
        }
        if($wherein) {
            $this->db->where_in($wherein[0], explode(',', $wherein[1]));
        }
        if($orderBy) {
            $this->db->order_by($orderBy[0], $orderBy[1]);
        }
        $query = $this->db->get();
        // return $this->db->last_query();
        return $query->result();
    }

    function get_data_equipo_by_id($id) {
        $this->db->select('E.id, E.operativo, E.activo, E.solicitud_bajada,  E.serie, E.serie_int, E.decriptador, E.ftp_host, E.ftp_user, E.ftp_pass, E.tipo, E.municipio, E.exportable, E.marca, E.modelo, E.idmodelo,  E.remito, E.ejido_urbano, E.observ, E.fecha_ultmod, E.instalado, E.requiere_calib, E.calibrado, E.evento_actual, E.idpropietario, E.estado, E.ts, ETip.descrip AS descrip_tipo, E.ubicacion_calle, E.ubicacion_altura, E.ubicacion_mano, E.ubicacion_sentido, E.ubicacion_localidad, E.ubicacion_cp, E.ubicacion_velper, E.geo_lat, E.geo_lon, E.doc_certif, E.doc_aprob, E.doc_normasic, E.doc_distancia, E.nro_ot, E.doc_fechacal, E.doc_informe, E.nro_ot, Mun.descrip AS descripMunicipio, P.descrip AS descripPropietario, ES.descrip AS descripEstado, EV.descrip AS descripEvento, E.doc_fechavto, E.vehiculoasig, F.dominio, E.multicarril, E.carril_sentido, EMarc.descrip AS descripMarca, EMod.descrip AS descripModelo, E.pedido, E.ordencompra, G.name AS nombreGestor, G.email as emailGestor, PROP.descrip as prop_descrip, ETip.bajada');
        $this->db->from('equipos_main as E');
        $this->db->join('flota_main as F','F.id = E.vehiculoasig','left');
        $this->db->join('equipos_tipos as ETip', 'ETip.id = E.tipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = E.municipio','left');
        $this->db->join('equipos_propietarios as P', 'P.id = E.idpropietario','left');
        $this->db->join('equipos_modelos as EMod', 'EMod.id = E.idmodelo','left');
        $this->db->join('equipos_marcas as EMarc', 'EMarc.id = E.marca','left');
        $this->db->join('estados as ES', 'ES.id = E.estado','left');
        $this->db->join('eventos as EV', 'EV.id = E.evento_actual','left');
        $this->db->join('tbl_users as G','G.userId = Mun.gestor','left');
        $this->db->join('equipos_propietarios as PROP', 'PROP.id = Mun.adminstracion','left');
        $this->db->where('E.id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        $formatted_response = array(
            'status' => 'success',
            'data' => $result
        );
        return $formatted_response;
    }
}
