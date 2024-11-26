<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Marcaseq_model extends CI_Model
{
    
    function marcaseqListingCount($searchText = '')
    {
        $this->db->select('EM.id, EM.descrip, EM.activo');
        $this->db->from('equipos_marcas as EM');

        if(!empty($searchText)) { 
            $this->db->like('EM.descrip', $searchText); 
        }

        $this->db->order_by("EM.descrip", "asc");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function marcaseqListing($searchText = '', $page, $segment)
    {
        $this->db->select('EM.id, EM.descrip, EM.activo, EM.observaciones');
        $this->db->from('equipos_marcas as EM');
        
        if(!empty($searchText)) { 
           $this->db->like('EM.descrip', $searchText); 
        }

        $this->db->order_by("EM.descrip", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewMarcaeq($marcaeqInfo)
    {
        $this->db->trans_start();
        $this->db->insert('equipos_marcas', $marcaeqInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getMarcaeqInfo($marcaeqId)
    {
        $this->db->select('id, descrip, activo, observaciones');
        $this->db->from('equipos_marcas');
        $this->db->where('id', $marcaeqId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    
    function editMarcaeq($marcaeqInfo, $marcaeqId)
    {
        $this->db->where('id', $marcaeqId);
        $this->db->update('equipos_marcas', $marcaeqInfo);
        
        return TRUE;
    }
    
    
    function deleteMarcaeq($marcaeqId, $marcaeqInfo)
    {
        $this->db->where('id', $marcaeqId);
        $this->db->update('equipos_marcas', $marcaeqInfo);
        
       // return $this->db->affected_rows();
        return $marcaeqInfo;
    }


    
}

  