<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Mensajes_model extends CI_Model
{

    function addNewMensajeTransac($mensajebInfo, $ordenesbInfo, $ordenesbId)
    {
        $this->db->trans_begin();
        $this->db->trans_strict(FALSE);
            $this->db->insert('mensajes', $mensajebInfo);
            $insert_id = $this->db->insert_id();
            $this->db->where('id', $ordenesbId);
            $this->db->update('ordenesb_main', $ordenesbInfo);
        $this->db->trans_complete();

        //return $insert_id;

        if ($this->db->trans_status() === FALSE){
            //Hubo errores en la consulta, entonces se cancela la transacción.
            $this->db->trans_rollback();
            return FALSE;
        }else{
            //Todas las consultas se hicieron correctamente.
            $this->db->trans_commit();
            return TRUE;
        }

    }

	function addNewMensaje($mensajebInfo)
    {
        $this->db->trans_start();
        $this->db->insert('mensajes', $mensajebInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return $insert_id;
    }

    function getLastCoords()
    {
    	$sql = "SELECT u.name as nombre, u.imei as imei, m.coords as coordenadas, m.fecha_recepcion as fecha
				FROM mensajes m JOIN tbl_users u ON m.imei = u.imei
				JOIN (SELECT imei, MAX(fecha_recepcion) as MaxFecha FROM mensajes WHERE TRIM(coords) <> '' GROUP BY imei) as mm ON mm.imei = m.imei AND m.fecha_recepcion = mm.MaxFecha
				WHERE TRIM(m.coords) <> '' AND SUBSTRING(m.coords, 1, 1) = '-'";

    	$query = $this->db->query($sql);

    	return $query->result();
    }

    function deleteMensaje($ordenbId)
    {
        $this->db->where('ordenesb_ID', $ordenbId);
        $this->db->delete('mensajes');

        return TRUE;
    }

    function getRespuesta($imei,$tipo,$codigo)
    {
      $this->db->select('M.id, M.imei, M.tipo, M.codigo, M.datos');
      $this->db->from('mensajes as M');
      $this->db->where('M.imei', $imei);
      $this->db->where('M.tipo', $tipo);
      $this->db->where('M.codigo', $codigo);
      $query = $this->db->get();

      $row = $query->row();
      return $row;
    }


}
