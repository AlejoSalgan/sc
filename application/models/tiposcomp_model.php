<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tiposcomp_model extends CI_Model
{
    
    function tiposcompListingCount($searchText = '')
    {
        $this->db->select('CT.id');
        $this->db->from('componentes_tipo as CT');

        if(!empty($searchText)) { 
            $this->db->like('CT.descrip', $searchText); 
        }

        $this->db->order_by("CT.descrip", "asc");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function tiposcompListing($searchText = '', $page, $segment)
    {
        $this->db->select('CT.id, CT.descrip, CT.activo, CT.seriado, CT.observaciones');
        $this->db->from('componentes_tipo as CT');
        
        if(!empty($searchText)) { 
           $this->db->like('CT.descrip', $searchText); 
        }

        $this->db->order_by("CT.descrip", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewTipocomp($tipocompInfo)
    {
        $this->db->trans_start();
        $this->db->insert('componentes_tipo', $tipocompInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getTipocompInfo($tipocompId)
    {
        $this->db->select('id, descrip, activo, seriado, observaciones');
        $this->db->from('componentes_tipo');
        $this->db->where('id', $tipocompId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    
    function editTipocomp($tipocompInfo, $tipocompId)
    {
        $this->db->where('id', $tipocompId);
        $this->db->update('componentes_tipo', $tipocompInfo);
        
        return TRUE;
    }
    
    
    function deletetipocomp($tipocompId, $tipocompInfo)
    {
        $this->db->where('id', $tipocompId);
        $this->db->update('componentes_tipo', $tipocompInfo);
        
       // return $this->db->affected_rows();
        return $tipocompInfo;
    }


    
}

  