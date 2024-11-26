<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Insta_model extends CI_Model
{
    
    function instaListingCount($searchText = '')
    {
        $this->db->select('INS.id');
        $this->db->from('instalacion_main as INS');
        $this->db->join('municipios as Mun', 'Mun.id = INS.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = INS.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = INS.idequipo','left');
        $this->db->join('tbl_users as U', 'U.userId = INS.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = INS.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = INS.tecnico','left');

        if(!empty($searchText)) { 
            $this->db->like('INS.id', $searchText); 
        }

        $this->db->order_by("INS.fecha_visita", "DESC");
        $this->db->order_by("F.dominio", "ASC");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function instaListing($searchText = '', $page, $segment)
    {
        $this->db->select('INS.id, INS.activo, INS.fecha_visita, INS.enviado, INS.ord_procesado ,EM.serie AS equipoSerie, INS.recibido, Mun.descrip AS descripProyecto, UT.name AS nameTecnico, F.dominio');
        $this->db->from('instalacion_main as INS');
        $this->db->join('municipios as Mun', 'Mun.id = INS.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = INS.iddominio','left');
        $this->db->join('equipos_main as EM', 'EM.id = INS.idequipo','left');
        $this->db->join('tbl_users as U', 'U.userId = INS.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = INS.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = INS.tecnico','left');
        
        if(!empty($searchText)) { 
           $this->db->like('INS.id', $searchText); 
        }

        $this->db->order_by("INS.fecha_visita", "DESC");
        $this->db->order_by("F.dominio", "ASC");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewInsta($instaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('instalacion_main', $instaInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getInstaInfo($instaId)
    {
        $this->db->select("INS.id, INS.activo, INS.diagnostico_previo, INS.idproyecto, INS.idsupervisor, INS.iddominio, INS.conductor, INS.tecnico, INS.idequipo, DATE_FORMAT(INS.fecha_visita, '%d-%m-%Y') AS fecha_visita, DATE_FORMAT(INS.fecha_alta, '%d-%m-%Y') AS fecha_alta, EM.serie AS equipoSerie, Mun.descrip AS descripProyecto, U.name AS nameSupervisor, UC.name AS nameConductor, UT.name AS nameTecnico, F.dominio", FALSE);
        $this->db->join('equipos_main as EM', 'EM.id = INS.idequipo','left');
        $this->db->join('municipios as Mun', 'Mun.id = INS.idproyecto','left');
        $this->db->join('flota_main as F', 'F.id = INS.iddominio','left');
        $this->db->join('tbl_users as U', 'U.userId = INS.idsupervisor','left');
        $this->db->join('tbl_users as UC', 'UC.userId = INS.conductor','left');
        $this->db->join('tbl_users as UT', 'UT.userId = INS.tecnico','left');
        $this->db->from("instalacion_main AS INS");
        $this->db->where("INS.id", $instaId);
        $query = $this->db->get();
        
        return $query->result(); 
    }


    function getInstaEnvio($instaId)
    {
        $this->db->select('INS.id, INS.imei, INS.fecha_alta, INS.fecha_visita, INS.diagnostico_previo, EM.serie AS equipoSerie');
        $this->db->from('instalacion_main AS INS');
        $this->db->join('equipos_main as EM', 'EM.id = INS.idequipo','left');
        $this->db->where('INS.id', $instaId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    function getSinEnviar()
    {
        $this->db->select('INS.id');
        $this->db->from('instalacion_main AS INS');
        $where = "enviado IS NULL OR enviado = 0";
        $this->db->where($where);
        $query = $this->db->get();
        
        return $query->result();
    }

    
    function editInsta($instaInfo, $instaId)
    {
        $this->db->where('id', $instaId);
        $this->db->update('instalacion_main', $instaInfo);
        
        return TRUE;
    }
    
    
    function deleteInsta($instaId, $instaInfo)
    {
        $this->db->where('id', $instaId);
        $this->db->update('instalacion_main', $instaInfo);
        
       // return $this->db->affected_rows();
        return $instaInfo;
    }

    function getProxOrden()
    {
        $this->db->select_max('id');
        $result = $this->db->get('instalacion_main')->row();
        $data = $result->id + 1;

        return $data;
    }


    
}

  