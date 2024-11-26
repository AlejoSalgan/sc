<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Eventos extends BaseController
{
    public function __construct() //This is default constructor of the class.
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->menuPermisos();
        $this->load->model('equipos_model');
        $this->load->model('eventos_model');
        $this->load->model('historial_model');
        $this->load->model('municipios_model');
        $this->load->model('ordenes_model');
        $this->load->model('mail_model');
        $this->load->library('fechas'); //utils Fechas
    }

    public function index() //This function used to load the first screen of the user
    {
        /*$this->global['pageTitle'] = 'CECAITRA: Stock';

        $this->load->view('includes/header', $this->global);
        $this->load->view('includes/menu', $this->menu);
        $this->load->view('eventos');
        $this->load->view('includes/footer');*/
    }

    //Agrega un nuevo evento a un equipo (Actualiza el estado y evento de un equipo).
    function editEvento()
    {
        $equipoid = $this->input->post('equipoid');
        $serie    = $this->input->post('serie');
        $estado   = $this->input->post('estado'); // Lugar.
        $evento   = $this->input->post('evento');
        $observ   = $this->input->post('observ');

        if($estado == 1 && $this->ordenes_model->ordenes_abiertas($serie,REPA_ABIERTAS,'R')){
            $this->session->set_flashdata('error', 'No puede cambiar el equipo al lugar DEPOSITO. Tiene una orden de Reparacion Abierta. Solicite al sector REPARACIONES que ejecute la accion Enviar Equipo.');
            redirect('equiposListing');
        }

        $infoAnt    = $this->equipos_model->getEquipoInfo($equipoid);
        $op_equipo = ($this->equipos_model->getOperativo($equipoid) == '1') ? 'SI' : 'NO';
        $equipoInfo = array('evento_actual'=>$evento,'estado'=>$estado);

        if ($estado <> 2) {
  				$operativo = '0';
  				array_push($equipoInfo['operativo']  = $operativo);
  			} else {
  				$operativo = '1';
  				array_push($equipoInfo['operativo']  = $operativo);
  			}
  			$operativo = ($operativo == '1') ? "SI" : "NO";

        $result     = $this->equipos_model->editEquipo($equipoInfo, $equipoid);

        if($result == true){ //Historial
            $idequipo       = $equipoid;
            $idcomponente   = 0;
            $idevento       = $evento; //Modificación, no hay evento
            $idestado       = $estado; //$estado;
            $origen         = "EVENTOS";
            $tipo_historial = "NUEVO EVENTO";
            $reubicacion    = 0; //$municipio;

            foreach($infoAnt as $infoInd){
                $old_estado = $infoInd->estado;
                $old_evento = $infoInd->evento_actual;
                $nombreGestor = $infoInd->nombreGestor;
                $emailGestor  = $infoInd->emailGestor;
            }

            if ($old_estado != $estado) {
                $estado_ant     = $this->equipos_model->getEstado($old_estado);
                $estado_descrip = $this->equipos_model->getEstado($estado);
                $infoH .= "El estado anterior era: <strong>".$estado_ant."</strong>, se cambio por <strong>".$estado_descrip."</strong>. <br>";
            }

            if ($old_evento != $evento) {
                $evento_ant     = $this->equipos_model->getEvento($old_evento);
                $evento_descrip = $this->equipos_model->getEvento($evento);
                $infoH .= "El evento anterior era: <strong>".$evento_ant."</strong>, se cambio por <strong>".$evento_descrip."</strong>. <br>";
            }

            $infoH .= 'La condicion de Bajada era <strong>'.$op_equipo.' </strong>, se cambió por <strong>'.$operativo.'</strong>.';

            $observaciones = $observ;

            if (($infoH != NULL) OR ($observaciones != NULL)) {
                if ($infoH == NULL) {
                    $infoH = "Sin detalles.";
                }

                $historialNew = array('idequipo'=>$idequipo, 'idcomponente'=>$idcomponente,'idevento'=>$idevento,'idestado'=>$idestado,'reubicacion'=>$reubicacion,'origen'=>$origen, 'tipo'=>$tipo_historial, 'detalle'=>$infoH, 'observaciones'=>$observaciones, 'creadopor'=>$this->vendorId, 'fecha'=>date('Y-m-d H:i:s'));
                $this->load->model('historial_model');
                $result2 = $this->historial_model->addHistorial($historialNew);
            }
            //FIN HISTORIAL

            if($estado == '3'){
                $this->mail_model->enviarMail(7, $serie, $reparacionNro = NULL,
                $detalle = NULL, $fecha = NULL, $reasignadoA = NULL, $proyecto = NULL, $emailGestor, $nombreGestor);
            }
            $this->session->set_flashdata('success', 'Evento actualizado correctamente');
        } else {
            $this->session->set_flashdata('error', 'Error al actualizar evento');
        }
        redirect('equiposListing');
    }

}
?>
