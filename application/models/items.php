<?php

class Items extends CI_Model {

    function get_live_items($search_data) {

        $this->db->select("id,serie");
        $this->db->from('equipos_main');
        $this->db->like('serie', $search_data, 'after');
        $this->db->limit(10);
        $this->db->order_by("serie", 'asc');
        $query = $this->db->get();

        return $query->result();

    }

}
