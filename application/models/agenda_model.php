<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Agenda_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}
	function getEventosTipos() 
	{
		$query = $this->db->get('agenda_tipo_evento');
		$result = $query->result();
		return $result;
	}

	function addEvento($data)
	{
		$this->db->trans_start();
		$this->db->insert('agenda_eventos',$data['evento']);

		$insert_id = $this->db->insert_id();

		$fecha = date('Y-m-d H:i:s');
		// Jerarquía del creador del evento
		$jerarquia_creador = $this->user_model->getJerarquiaByUser($data['evento']['creadopor']);
		$insert = array();

		foreach ($data['asistentes'] as $iduser) {
			$jerarquia_invitado =  $this->user_model->getJerarquiaByUser($iduser);
			if (($jerarquia_creador < $jerarquia_invitado) || ($data['evento']['creadopor'] == $iduser)) {
				$confirmo = 1;
			} else {
				$confirmo = 0;
			}
			$insert[] = array('evento' => $insert_id, 'invitado' => $iduser, 'confirmo' => $confirmo, 'fecha' => $fecha);
		}
		if ($insert) {
			$this->db->insert_batch('agenda_invitados',$insert);
		}

		$this->db->trans_complete();
	}

	function getInvitaciones($userId)
	{
		$where = array('ai.invitado' => $userId, 'ae.fecha_inicio >' => date('Y-m-d H:i:s'), 'ae.tipo' => 1);
		
		$this->db->select('ae.nombre, ae.ubicacion, u.name, ae.fecha_inicio, ae.fecha_fin, ae.descripcion, ai.evento, ai.confirmo, ai.razon');
		$this->db->from('agenda_invitados as ai');
		$this->db->join('agenda_eventos as ae', 'ae.id = ai.evento');
		$this->db->join('tbl_users as u', 'u.userId = ae.creadopor');
		$this->db->where($where);
		$this->db->order_by("ai.fecha", "desc");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	function editInvitacion($data,$where)
	{
		$this->db->where($where);
		$this->db->update('agenda_invitados', $data);
		
		return TRUE;
	}

	function usuarioOcupado($usuario,$fecha_inicio,$fecha_fin)
	{
		$sql = "SELECT count(*) as cant
				FROM agenda_eventos e
				JOIN agenda_invitados i ON e.id = i.evento
				JOIN tbl_users u ON u.userId = i.invitado
				WHERE u.userId = {$usuario}
				AND (i.confirmo = 0 OR i.confirmo = 1) 
				AND '{$fecha_inicio}' < e.fecha_fin
  				AND '{$fecha_fin}' > e.fecha_inicio";
		$query = $this->db->query($sql);
		$row = $query->row();
		return $row->cant;
	}

	function getUsuariosOcupados($asistentes,$fecha_inicio,$fecha_fin)
	{
		$ocupados = array();
		foreach ($asistentes as $asistente) {
			if ($this->usuarioOcupado($asistente,$fecha_inicio,$fecha_fin)) {
				// Si el usuario no puede en esa fecha
				$user = $this->user_model->getUserInfo($asistente);
				$ocupados[] = $user[0];
			}
		}
		return $ocupados;
	}

	function getEventos($usersId = FALSE, $confirmo = FALSE)
	{
		$sql = "SELECT ae.id, ae.nombre, ae.descripcion, ae.fecha_inicio, ae.fecha_fin, ae.tipo, ae.diacompleto
				FROM agenda_invitados as ai
				JOIN agenda_eventos as ae ON ae.id = ai.evento
				JOIN tbl_users as u ON u.userId = ae.creadopor";
				
		if ($usersId !== FALSE) {
			$sql .= " WHERE ai.invitado IN (";
			foreach ($usersId as $row) {
				$sql .= $row;
				if (end($usersId) != $row) {
					$sql .= ',';
				}
			}
			$sql .= ")";
		}
		if ($confirmo) {
			if ($usersId === FALSE) {
				$sql .= " WHERE";
			} else {
				$sql .= " AND";
			}
			$sql .= " ai.evento NOT IN (SELECT evento FROM agenda_invitados WHERE confirmo = 2) GROUP BY evento";
		}

		$query = $this->db->query($sql);

		return $query->result();
	}

	function getInvitadosEvento($id,$confirmo = FALSE)
	{
		$where = array('evento' => $id);
		if ($confirmo !== FALSE) {
			$where['confirmo'] = $confirmo;
		}
		
		$this->db->where($where);
		return $this->db->count_all_results('agenda_invitados');
	}

	function getFechasOcupadas()
	{
		if ($userId !== FALSE) {
			$where = array('ai.invitado' => $userId);
			$this->db->where($where);
		}
		
		$this->db->select('ae.id, ae.nombre, ae.descripcion, ae.fecha_inicio, ae.fecha_fin, ae.tipo, ae.diacompleto');
		$this->db->from('agenda_invitados as ai');
		$this->db->join('agenda_eventos as ae', 'ae.id = ai.evento');
		$this->db->join('tbl_users as u', 'u.userId = ae.creadopor');
		
		$query = $this->db->get();
		return $query->result();
	}
}