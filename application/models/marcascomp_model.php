<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Marcascomp_model extends CI_Model
{
    
    function marcascompListingCount($searchText = '')
    {
        $this->db->select('CM.id');
        $this->db->from('componentes_marca as CM');

        if(!empty($searchText)) { 
            $this->db->like('CM.descrip', $searchText); 
        }

        $this->db->order_by("CM.descrip", "asc");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function marcascompListing($searchText = '', $page, $segment)
    {
        $this->db->select('CM.id, CM.descrip, CM.activo, CM.observaciones');
        $this->db->from('componentes_marca as CM');
        
        if(!empty($searchText)) { 
           $this->db->like('CM.descrip', $searchText); 
        }

        $this->db->order_by("CM.descrip", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewMarcacomp($marcacompInfo)
    {
        $this->db->trans_start();
        $this->db->insert('componentes_marca', $marcacompInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getMarcacompInfo($marcacompId)
    {
        $this->db->select('id, descrip, activo, observaciones');
        $this->db->from('componentes_marca');
        $this->db->where('id', $marcacompId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    
    function editMarcacomp($marcacompInfo, $marcacompId)
    {
        $this->db->where('id', $marcacompId);
        $this->db->update('componentes_marca', $marcacompInfo);
        
        return TRUE;
    }
    
    
    function deleteMarcacomp($marcacompId, $marcacompInfo)
    {
        $this->db->where('id', $marcacompId);
        $this->db->update('componentes_marca', $marcacompInfo);
        
       // return $this->db->affected_rows();
        return $marcacompInfo;
    }


    
}

  