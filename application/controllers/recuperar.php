<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Recuperar extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('recuperar_model');
        $this->load->model('login_model');
    }

    public function index()
    {
        $this->recuperarPass();
    }

    function recuperarPass()
    {
        $this->load->view('recuperar');
    }

    function resetPass()
    {
        $this->load->view('resetpass');
    }
}

?>
