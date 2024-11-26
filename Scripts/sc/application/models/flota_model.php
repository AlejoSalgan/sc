<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Flota_model extends CI_Model
{

    function getVehiculos($destino = NULL, $mapaEM = NULL) //destino 1.- "bajada de memoria"; $mapaEM (Equipos moviles).
    {
        $this->db->select('F.id, F.dominio, F.marca, F.modelo, EM.serie, MUN.descrip as proyecto');
        $this->db->from('flota_main as F');
        $this->db->join('equipos_main as EM','EM.vehiculoasig = F.id','left');
        $this->db->join('municipios as MUN','EM.municipio = MUN.id','left');
        if (!is_null($destino)) {
            if (is_array($destino)) {
                $this->db->where_in('destino', $destino);
            } else {
                $this->db->where('destino =', $destino);
            }
        }
        if ($mapaEM == 1) {
          $this->db->where('EM.tipo_equipo',1);
          $this->db->where('EM.vehiculoasig !=','0');
          $this->db->not_like('EM.serie','-baj');
          $this->db->where('EM.serie !=','');
          $this->db->where('EM.estado',2);
          $this->db->where('EM.evento_actual',40);
          $this->db->where("(EM.activo = 1 AND EM.eliminado = 0)");
        }

        $this->db->order_by("dominio", "asc");
        $query = $this->db->get();

        return $query->result();
    }

    function getDominio($id = NULL)
    {
        $this->db->select('dominio');
        $this->db->from('flota_main');

        if ($id != NULL) {
          $this->db->where('id =', $id);
          $query = $this->db->get();
          $result = $query->row();

          return $result->dominio;
        } else {
          return FALSE;
        }
    }

    function getDestinos()
    {
        $this->db->select('id, descrip');
        $this->db->from('flota_destinos');
        $this->db->order_by("descrip", "asc");
        $query = $this->db->get();

        return $query->result();
    }

    function flotaListingCount($searchText = '')
    {
        $this->db->select('F.id');
        $this->db->from('flota_main as F');
        $this->db->join('flota_asig as FA', 'FA.dominio = F.dominio','left');
        $this->db->join('tbl_users as U', 'U.userId = FA.idchofer1','left');
        $this->db->join('municipios as P', 'P.id = FA.idproyecto','left');

        if(!empty($searchText)) {
            $this->db->like('F.dominio', $searchText);
        }

        $this->db->order_by("F.dominio", "asc");

        $query = $this->db->get();

        return count($query->result());
    }

    function flotaListing($searchText = '', $page, $segment)
    {
        $this->db->select('F.id, EP.descrip as descrip_propietario, F.dominio, F.movilnro, F.marca, F.modelo, F.activo, EM.serie ,U.name AS chofer1, P.descrip AS descripProyecto, FD.descrip AS descripDestino');
        $this->db->from('flota_main as F');
        $this->db->join('flota_asig as FA', 'FA.dominio = F.dominio','left');
        $this->db->join('flota_destinos as FD', 'FD.id = F.destino','left');
        $this->db->join('tbl_users as U', 'U.userId = FA.idchofer1','left');
        $this->db->join('equipos_propietarios as EP', 'EP.id = F.propietario','left');
        $this->db->join('equipos_main as EM', 'EM.vehiculoasig = F.id','left');
        $this->db->join('municipios as P', 'P.id = FA.idproyecto','left');


        if(!empty($searchText)) {
           $this->db->like('F.dominio', $searchText);
           $this->db->or_like('FD.descrip', $searchText);
        }

        $this->db->order_by("F.dominio", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();

        return $query->result();
    }

	function getFlotaInfo($flotaId)
    {
        $this->db->select("F.id, F.dominio, F.movilnro, F.marca, F.modelo, F.motor, F.chasis ,F.anio, F.segmento, F.propietario, F.destino, F.activo, F.nro_poliza, F.tipo_poliza, DATE_FORMAT(F.fecha_autoparte, '%d-%m-%Y') AS fecha_autoparte, DATE_FORMAT(F.venc_cedulaverde, '%d-%m-%Y') AS venc_cedulaverde, DATE_FORMAT(F.venc_seguro, '%d-%m-%Y') AS venc_seguro, DATE_FORMAT(F.venc_vtv, '%d-%m-%Y') AS venc_vtv, DATE_FORMAT(F.venc_matafuego, '%d-%m-%Y') AS venc_matafuego, DATE_FORMAT(F.venc_cert_hidro, '%d-%m-%Y') AS venc_cert_hidro, DATE_FORMAT(F.venc_ruta, '%d-%m-%Y') AS venc_ruta, F.responsable, F.acc_kit, F.acc_cargador, F.acc_conos, F.acc_chalecos, FA.idchofer1, FA.idchofer2, FA.idproyecto", FALSE);

        $this->db->from('flota_main as F');
        $this->db->join('flota_asig as FA', 'FA.dominio = F.dominio','left');
        $this->db->where('F.id', $flotaId);
        $query = $this->db->get();

        return $query->result();
    }

    function getVehiculoNro($movilnro) //si existe el nro de vehículo
    {
        $this->db->select('movilnro');
        $this->db->from('flota_main');
        $this->db->where('movilnro =', $movilnro);

        $query = $this->db->count_all_results();

        return $query;
    }

    function addNewFlota($flotaInfo)
    {
        $this->db->trans_start();
        	$this->db->insert('flota_main', $flotaInfo);
        	$insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function addNewFlotaAsig($flota_asigInfo)
    {
        $this->db->trans_start();
        	$this->db->insert('flota_asig', $flota_asigInfo);
        	$insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }


    function editFlota($flotaInfo, $flotaId)
    {
        $this->db->where('id', $flotaId);
        $this->db->update('flota_main', $flotaInfo);

        return TRUE;
    }

    function editFlotaAsig($flota_asigInfo, $dominio)
    {
        $this->db->where('dominio', $dominio);
        $this->db->update('flota_asig', $flota_asigInfo);
        $filas = $this->db->affected_rows();
        if($filas == 0){
        	$this->db->insert('flota_asig', $flota_asigInfo);
        }

        return TRUE;
    }

    function deleteFlota($flotaId, $flotaInfo)
    {
        $this->db->where('id', $flotaId);
        $this->db->update('flota_main', $flotaInfo);

       	return $this->db->affected_rows();
        //return $flotaInfo;
    }
}
