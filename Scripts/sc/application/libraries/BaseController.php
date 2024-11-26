<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

/**
 * Class : BaseController
 * Base Class to control over all the classes
 * @author : Kishor Mali
 */
class BaseController extends CI_Controller {
	protected $role = '';
	protected $vendorId = '';
	protected $name = '';
	protected $roleText = '';
	protected $puesto = '';
	protected $puesto_descrip = '';
	protected $global = array ();

	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}



	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		$isLoggedIn = $this->session->userdata ( 'isLoggedIn' );

		if (! isset ( $isLoggedIn ) || $isLoggedIn != TRUE) {
			redirect ( 'login' );
		} else {
			$this->role = $this->session->userdata ( 'role' );
			$this->vendorId = $this->session->userdata ( 'userId' );
			$this->name = $this->session->userdata ( 'name' );
			$this->roleText = $this->session->userdata ( 'roleText' );
			$this->puesto = $this->session->userdata ( 'puesto' );
			$this->puesto_descrip = $this->session->userdata ( 'puesto_descrip' );
			$this->nombre = $this->session->userdata ( 'nombre' );
			$this->apellido = $this->session->userdata ( 'apellido' );


			$this->global ['name'] = $this->name;
			$this->global ['role'] = $this->role;
			$this->global ['role_text'] = $this->roleText;
			$this->global ['puesto'] = $this->puesto;
			$this->global ['puesto_descrip'] = $this->puesto_descrip;
			$this->global ['vendorId'] = $this->vendorId;
			$this->global ['nombre'] = $this->nombre;
			$this->global ['apellido'] = $this->apellido;


		}
	}

	public function menuPermisos(){ //Muestra y da acceso a los menus.
			$this->isLoggedIn();
			$this->load->model('menu_model');
			switch ($this->uri->segment(1)) {
				case 'mantenimiento':
				case 'reparaciones':
				case 'instalaciones':
				case 'ordenes':
				case 'ordenesb':
				case 'calibListing':
				case 'historial':
				case 'equipos':
				case 'equipamiento':
					$link = $this->uri->segment (1)."/".$this->uri->segment (2);
					break;

				case 'userListing':
					$link = $this->uri->segment (1)."/".$this->uri->segment (2)."/".$this->uri->segment (3);
					break;
				default:
					$link = $this->uri->segment (1);
					break;
			}
			if ($this->menu_model->getAcceso($this->role,$link) == 0) {
				show_404();
			} else {
				$this->menu ['categorias'] = $this->menu_model->getMenus(0,$this->role);
				$this->menu ['menus']      = $this->menu_model->getMenus(1,$this->role);
				$this->menu ['submenus']   = $this->menu_model->getMenus(2,$this->role);
			}
	}

	/**
	 * This function is used to check the access
	 */

	function isAdmin() {
		if ($this->role == ROLE_ADMIN || $this->role == ROLE_SUPERADMIN) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isSuper() {
		if ($this->role != ROLE_SUPERADMIN) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to check the access
	 */
	function isTicketter() {
		if ($this->role != ROLE_ADMIN || $this->role != ROLE_MANAGER) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Administracion.
	*/
	function isAdministrativo() {
		if ($this->role == ROLE_ADM || $this->role == ROLE_DIRADM || $this->role == ROLE_GERADM || $this->role == ROLE_SUPADM) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Bajada de Memoria.
	*/
	function isBajada() {
		if ($this->role == ROLE_BAJADA || $this->role == ROLE_DIRBAJADA || $this->role == ROLE_GERBAJADA || $this->role == ROLE_SUPBAJADA) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Calibracion.
	*/
	function isCalibracion() {
		if ($this->role == ROLE_CALIB || $this->role == ROLE_DIRCALIB || $this->role == ROLE_GERCALIB || $this->role == ROLE_SUPCALIB) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Deposito.
	*/
	function isDeposito() {
		if ($this->role == ROLE_DEPO || $this->role == ROLE_DIRDEPO || $this->role == ROLE_GERDEPO || $this->role == ROLE_SUPDEPO) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector Gestion Proyecto.
	*/
	function isGestion() {
		if ($this->role == ROLE_GESTIONPROY || $this->role == ROLE_DIRGESTIONPROY || $this->role == ROLE_GERGESTIONPROY || $this->role == ROLE_SUPGESTIONPROY || $this->role == ROLE_AUDGESTIONPROY) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector Ingreso de Datos.
	*/
	function isIngreso() {
		if ($this->role == ROLE_INGDATOS || $this->role == ROLE_SUPINGDATOS) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector Instalaciones.
	*/
	function isInstalacion() {
		if ($this->role == ROLE_INSTA || $this->role == ROLE_DIRINSTA || $this->role == ROLE_GERINSTA || $this->role == ROLE_SUPINSTA) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector Mantenimiento.
	*/
	function isMantenimiento() {
		if ($this->role == ROLE_MANTE || $this->role == ROLE_DIRMANTE || $this->role == ROLE_GERMANTE || $this->role == ROLE_SUPMANTE) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector Procesamiento de Datos.
	*/
	function isProcesamiento() {
		if ($this->role == ROLE_PROCEDATOS || $this->role == ROLE_GERPROCEDATOS || $this->role == ROLE_SUPPROCEDATOS) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector Reparaciones.
	*/
	function isReparacion() {
		if ($this->role == ROLE_REPA || $this->role == ROLE_DIRREPA || $this->role == ROLE_GERREPA || $this->role == ROLE_SUPREPA) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Servicios Generales.
	*/
	function isSSGG() {
		if ($this->role == ROLE_SSGG || $this->role == ROLE_DIRSSGG || $this->role == ROLE_GERSSGG || $this->role == ROLE_SUPSSGG) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Sistemas.
	*/
	function isSistemas() {
		if ($this->role == ROLE_SIST || $this->role == ROLE_DIRSIST || $this->role == ROLE_GERSIST || $this->role == ROLE_SUPSIST) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Esta funcion es usada para comprobar el acceso al Sector de Sistemas.
	*/
	function isCECASIT() {
		if ($this->role == ROLE_CECASIT || $this->role == ROLE_DIRCECASIT || $this->role == ROLE_GERCECASIT || $this->role == ROLE_SUPCECASIT) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function is used to load the set of views
	 */
	function loadThis() {
		$this->global ['pageTitle'] = 'Sistema Cecaitra : Acceso denegado';

		$this->load->view ( 'includes/header', $this->global );
		$this->load->view ( 'access' );
		$this->load->view ( 'includes/footer' );
	}

	function loadThis2() {
		$this->global ['pageTitle'] = 'Sistema Cecaitra : Acceso denegado';

		$this->load->view ( 'access' );
	}

	/**
	 * This function is used to logged out user from system
	 */
	function logout() {
		$this->session->sess_destroy ();

		redirect ( 'login' );
	}

	/**
	 * This function used provide the pagination resources
	 * @param unknown $link
	 * @param number $count
	 * @return string[]|unknown[]
	 */
	function paginationCompress($link, $count, $perPage = 10, $segmento = NULL) {
		$this->load->library ( 'pagination' );

		$config ['base_url'] = base_url () . $link;
		$config ['total_rows'] = $count;
		if ($segmento == NULL) {
			$config ['uri_segment'] = SEGMENT;
		} else {
			$config ['uri_segment'] = $segmento;
		}
		$config ['per_page'] = $perPage;
		$config ['num_links'] = 5;
		$config ['full_tag_open'] = '<nav><ul class="pagination">';
		$config ['full_tag_close'] = '</ul></nav>';
		$config ['first_tag_open'] = '<li class="arrow">';
		$config ['first_link'] = 'Primero';
		$config ['first_tag_close'] = '</li>';
		$config ['prev_link'] = 'Anterior';
		$config ['prev_tag_open'] = '<li class="arrow">';
		$config ['prev_tag_close'] = '</li>';
		$config ['next_link'] = 'Próximo';
		$config ['next_tag_open'] = '<li class="arrow">';
		$config ['next_tag_close'] = '</li>';
		$config ['cur_tag_open'] = '<li class="active"><a href="#">';
		$config ['cur_tag_close'] = '</a></li>';
		$config ['num_tag_open'] = '<li>';
		$config ['num_tag_close'] = '</li>';
		$config ['last_tag_open'] = '<li class="arrow">';
		$config ['last_link'] = 'Último';
		$config ['last_tag_close'] = '</li>';

		$this->pagination->initialize ( $config );
		$page = $config ['per_page'];

		if ($segmento == NULL) {
			$segment = $this->uri->segment ( SEGMENT );
		} else {
			$segment = $this->uri->segment ( $segmento );
		}

		return array (
				"page" => $page,
				"segment" => $segment
		);
	}
}
