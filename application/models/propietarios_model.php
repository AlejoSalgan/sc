<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Propietarios_model extends CI_Model
{
    
    function propietariosListingCount($searchText = '')
    {
        $this->db->select('P.id');
        $this->db->from('equipos_propietarios as P');

        if(!empty($searchText)) { 
            $this->db->like('P.descrip', $searchText); 
        }

        $this->db->order_by("P.descrip", "asc");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function propietariosListing($searchText = '', $page, $segment)
    {
        $this->db->select('P.id, P.descrip, P.activo, P.observaciones');
        $this->db->from('equipos_propietarios as P');
        
        if(!empty($searchText)) { 
           $this->db->like('P.descrip', $searchText); 
        }

        $this->db->order_by("P.descrip", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewPropietario($propietarioInfo)
    {
        $this->db->trans_start();
        $this->db->insert('equipos_propietarios', $propietarioInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getPropietarioInfo($propietarioId)
    {
        $this->db->select('id, descrip, activo, observaciones');
        $this->db->from('equipos_propietarios');
        $this->db->where('id', $propietarioId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    
    function editPropietario($propietarioInfo, $propietarioId)
    {
        $this->db->where('id', $propietarioId);
        $this->db->update('equipos_propietarios', $propietarioInfo);
        
        return TRUE;
    }
    
    
    function deletePropietario($propietarioId, $propietarioInfo)
    {
        $this->db->where('id', $propietarioId);
        $this->db->update('equipos_propietarios', $propietarioInfo);
        
        return $propietarioInfo;
    }

    
    


    
}

  