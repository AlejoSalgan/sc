<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

    public function obtener_usuarios(){
        $this->db->select('userId, name, email, roleId');
        $this->db->from('tbl_users');
        $query = $this->db->get();

        return $query->result();
    }

    public function ver_detalles($id){
        $this->db->where('userId', $id);
        $query = $this->db->get('tbl_users');

        return $query->result();
    }

    public function crear_usuario($info_usuarios){
        $this->db->insert('tbl_users', $info_usuarios);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function editar_usuario($id){
        $this->db->where('userId', $id);
        $query = $this->db->get('tbl_users');

        return $query->result();
    }

    public function actualizar_datos(){

        // $this->db->where('id', $equipoId);
        // $this->db->update('equipos_main', $equipoInfo);
    }
}