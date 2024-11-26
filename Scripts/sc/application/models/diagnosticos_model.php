<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Diagnosticos_model extends CI_Model
{
    function getDiagnosticos()
    {
        $this->db->select('id, descrip');
        $this->db->order_by('id', 'asc');

        $query = $this->db->get('diagnosticos_main');
        
        return $query->result();
    }
}

  