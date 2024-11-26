<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Gestores_model extends CI_Model
{
   
    function getGestores()
    {
        $sql = "SELECT userId, name 
                FROM tbl_users 
                WHERE roleId IN (100,101,102,103)
                ORDER by name ASC "; 
        $query = $this->db->query($sql);
        return $query->result();
    }

}