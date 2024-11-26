<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Estados_model extends CI_Model
{
    function getEstados($tipo = NULL, $estado = NULL)
    {
        $this->db->select('id, descrip');
        $this->db->from('estados');
        if (!is_null($estado)) {
          $this->db->where('activo', $estado);
        }

        if (!is_null($tipo)) {
            if (is_array($tipo)) {
                $this->db->where_in('tipo', $tipo);
            } else {
                $this->db->where('tipo =', $tipo);
            }
        }

        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();

        return $query->result();
    }
}
