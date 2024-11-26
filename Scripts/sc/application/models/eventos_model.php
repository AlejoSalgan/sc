<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Eventos_model extends CI_Model
{

    function addEvento($eventoInfo)
    {
        $this->db->where('id', $equipoId);
        $this->db->update('equipos_main', $eventoInfo);
        
        return TRUE;
    }

    function setEventoEq($idequipo, $activo, $evento_actual, $instalado, $origen, $detalle) {
        
        //EQUIPO
        $dataEq = array(
            'activo' => $activo,
            'evento_actual' => $evento_actual,
            'instalado' => $instalado, 
            //'fecha_ultmod'=>date('Y-m-d H:i:sa'),  campo ts timestamp
       		'creadopor'=>$this->session->userdata('userId')

        );
        $this->db->where('id', $idequipo);
        $this->db->update('equipos_main', $dataEq);

        //HISTORIAL
        $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>0,'idevento'=>$evento_actual,'origen'=>$origen,'detalle'=>$detalle,'creadopor'=>$this->session->userdata('userId'), 'fecha'=>date('Y-m-d H:i:sa'));
        $this->load->model('historial_model');
        $result = $this->historial_model->addHistorial($historialNew);



        return TRUE;
        
    }

    function getEventos($tipo)
    {
        $this->db->select('id, descrip');
        $this->db->from('eventos');
        $this->db->where('tipo =', 'A');
        $this->db->or_where('tipo =', $tipo);
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }
    

   
    
}

  