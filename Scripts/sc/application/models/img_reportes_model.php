<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Img_reportes_model extends CI_Model
{
	function insertar($data)
	{
	    $this->db->insert('img_reportes', $data);
	    return TRUE;
	}
}