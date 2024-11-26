<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Equiposconfig_model extends CI_Model
{
	function getEquiposConfigByModel($modelo) 
	{
		$this->db->select('em.descrip AS em_descrip, em.descrip_alt AS em_descrip_alt, sigla AS em_sigla, ct.descrip AS ct_descrip, ec.cantidad, ct.seriado, ec.id_eq_modelo, ec.id_comp_tipo');
		$this->db->from('equipos_config ec');
		$this->db->join('equipos_modelos em', 'em.id = ec.id_eq_modelo');
		$this->db->join('componentes_tipo ct', 'ct.id = ec.id_comp_tipo');
		$this->db->where('id_eq_modelo', $modelo);
		$this->db->order_by("id_comp_tipo", "asc");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}