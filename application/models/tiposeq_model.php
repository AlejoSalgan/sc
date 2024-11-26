<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tiposeq_model extends CI_Model
{
    
    function tiposeqListingCount($searchText = '')
    {
        $this->db->select('ET.id');
        $this->db->from('equipos_tipos as ET');

        if(!empty($searchText)) { 
            $this->db->like('ET.descrip', $searchText); 
        }

        $this->db->order_by("ET.descrip", "asc");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function tiposeqListing($searchText = '', $page, $segment)
    {
        $this->db->select('ET.id, ET.descrip, ET.activo, ET.observaciones');
        $this->db->from('equipos_tipos as ET');
        
        if(!empty($searchText)) { 
           $this->db->like('ET.descrip', $searchText); 
        }

        $this->db->order_by("ET.descrip", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewTipoeq($tipoeqInfo)
    {
        $this->db->trans_start();
        $this->db->insert('equipos_tipos', $tipoeqInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    

    function getTipoeqInfo($tipoeqId)
    {
        $this->db->select('id, descrip, activo, observaciones');
        $this->db->from('equipos_tipos');
        $this->db->where('id', $tipoeqId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    
    function editTipoeq($tipoeqInfo, $tipoeqId)
    {
        $this->db->where('id', $tipoeqId);
        $this->db->update('equipos_tipos', $tipoeqInfo);
        
        return TRUE;
    }
    
    
    function deleteTipoeq($tipoeqId, $tipoeqInfo)
    {
        $this->db->where('id', $tipoeqId);
        $this->db->update('equipos_tipos', $tipoeqInfo);
        
       // return $this->db->affected_rows();
        return $tipoeqInfo;
    }


    
}

  