<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Equipamiento_model extends CI_Model
{
    function add()
    {
//         $this->db->trans_start();
//         $this->db->insert('agenda_eventos',$data['evento']);
        
//         $insert_id = $this->db->insert_id();
        
//         $fecha = date('Y-m-d H:i:s');
//         // Jerarquía del creador del evento
//         $jerarquia_creador = $this->user_model->getJerarquiaByUser($data['evento']['creadopor']);
//         $insert = array();
        
//         foreach ($data['asistentes'] as $iduser) {
//             $jerarquia_invitado =  $this->user_model->getJerarquiaByUser($iduser);
//             if (($jerarquia_creador < $jerarquia_invitado) || ($data['evento']['creadopor'] == $iduser)) {
//                 $confirmo = 1;
//             } else {
//                 $confirmo = 0;
//             }
//             $insert[] = array('evento' => $insert_id, 'invitado' => $iduser, 'confirmo' => $confirmo, 'fecha' => $fecha);
//         }
//         if ($insert) {
//             $this->db->insert_batch('agenda_invitados',$insert);
//         }
        
//         $this->db->trans_complete();
    }
    
    function getEquipamientoTipos()
    {
        $this->db->select('id, descripcion');
        $this->db->from('equipamiento_tipos');
        $this->db->order_by('descripcion', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }
}