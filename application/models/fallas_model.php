<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Fallas_model extends CI_Model
{
    function getFallas()
    {
        $this->db->order_by('descrip');
        $query = $this->db->get('fallas_main');

        return $query->result();
    }

    function getFallasSector($sector, $id_falla = NULL)
    {
        // Las fallas por sector.
        $this->db->select('id, descrip');
        $this->db->from('fallas_main');
        $this->db->where('sector',$sector);
        $this->db->get();
        $query1 = $this->db->last_query();

        $sql = $query1;

        //Agrego una falla por ID.
        if (!is_null($id_falla)) {
          $this->db->select('id, descrip');
          $this->db->from('fallas_main');
          $this->db->where('id',$id_falla);
          $this->db->get();
          $query2 =  $this->db->last_query();

          $sql .= " UNION ".$query2;
        }

        $query = $this->db->query($sql);
        return $query->result();
    }
}
