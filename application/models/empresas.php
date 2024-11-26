<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Empresas extends CI_Model
{
    public function get($queryParams = array()) {
        $queryParams = $this->input->get();
        $fields = $queryParams["fields"] ?? "*";
        $where = $queryParams["where"];
        $wherein = $queryParams["wherein"];
        $joins = $queryParams["joins"]; 
        $fields = is_array($fields) ? join(",", $fields) : $fields;
        $this->db->select($fields);
        $this->db->from('empresas');
        if($joins) {
            foreach ($joins as $join) {
                $join_explode = explode(",", $join);
                $this->db->join($join_explode[0], $join_explode[1], $join_explode[2]);
            }
        }
        if($where) {
            $this->db->where($where[0], $where[1]);
        }
        if($wherein) {
            $this->db->where_in($wherein[0], explode(',', $wherein[1]));
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getAll() {
        $this->db->select('*');
        $this->db->from('empresas');
        $query = $this->db->get();
        return $query->result();
    }
}