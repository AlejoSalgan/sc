<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {

    public function page_not_found() {
        $redirect_dashoboard = base_url("landing");
        echo "<h1>Módulo no disponible</h1>";
        echo "<a href='$redirect_dashoboard'>Inicio</a>";
    }
}