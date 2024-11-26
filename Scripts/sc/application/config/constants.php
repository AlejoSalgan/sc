<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/**** USER DEFINED CONSTANTS **********/

//Rutas//
define('documentacion','/var/www/documentacion/');

//Extensiones//
define ("tipo_doc", array ('.pdf', '.doc', '.docx', '.xls', '.xlsx', '.xlsxm'));
define ("tipo_arch_equipo", array ('.dat'));

define ('tipos_mime', array ('pdf' => 'application/pdf', '.doc' => 'application/msword', '.docx' => 'application/pdf',
'.pdf' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
'.xls' => 'application/vnd.ms-excel',
'.xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
'.xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12'));

// Estadps //
define('REPA_ABIERTAS', array(3,4,5,6,9,10,11,14,15,16,17,18,19));

//CODEINSECT//
define('ROLE_SUPERADMIN', '99');
define('ROLE_ADMIN', '1');
define('ROLE_MANAGER', 	'2');
define('ROLE_EMPLOYEE', '3');

//Administracion//
define('ROLE_ADM',		 		'53');
define('ROLE_DIRADM', 	'50');
define('ROLE_GERADM', 	'51');
define('ROLE_SUPADM', 	'52');

//Bajada de memoria//
define('ROLE_BAJADA', 	'603');
define('ROLE_DIRBAJADA', 	'600');
define('ROLE_GERBAJADA', 	'601');
define('ROLE_SUPBAJADA', 	'602');

//Calibraciones//
define('ROLE_CALIB',		 	'703');
define('ROLE_DIRCALIB', 	'700');
define('ROLE_GERCALIB', 	'701');
define('ROLE_SUPCALIB', 	'702');

//Deposito//
define('ROLE_DEPO',			 	'753');
define('ROLE_DIRDEPO', 	'750');
define('ROLE_GERDEPO', 	'751');
define('ROLE_SUPDEPO', 	'752');

//Gestion de Proyectos//
define('ROLE_AUDGESTIONPROY', '104');
define('ROLE_GESTIONPROY', 	'103');
define('ROLE_DIRGESTIONPROY', '100');
define('ROLE_GERGESTIONPROY', '101');
define('ROLE_SUPGESTIONPROY', '102');

//Ingreso de datos//
define('ROLE_INGDATOS', 	'41');
define('ROLE_SUPINGDATOS', '40');

//Instalaciones
define('ROLE_INSTA', 	 	'503');
define('ROLE_DIRINSTA', 	 	'500');
define('ROLE_GERINSTA', 	 	'501');
define('ROLE_SUPINSTA', 	'502');

//Mantenimiento
define('ROLE_MANTE', 	 	'403');
define('ROLE_DIRMANTE', 	 	'400');
define('ROLE_GERMANTE', 	 	'401');
define('ROLE_SUPMANTE', 	'402');

//Presidencia
define('ROLE_PRESIDENT', 	 '900');

//Procesamiento de datos
define('ROLE_PROCEDATOS', 	 	'32');
define('ROLE_GERPROCEDATOS', 	'30');
define('ROLE_SUPPROCEDATOS', 	'31');

//Reparacion
define('ROLE_REPA', 	 	'203');
define('ROLE_DIRREPA', 	'200');
define('ROLE_GERREPA', 	'201');
define('ROLE_SUPREPA', 	'202');

//Servicios Generales
define('ROLE_SSGG', 	 	'303');
define('ROLE_DIRSSGG', 	 	'300');
define('ROLE_GERSSGG', 	 	'301');
define('ROLE_SUPSSGG', 	'302');

//Sistemas
define('ROLE_SIST', 	 	'13');
define('ROLE_DIRSIST', 	'10');
define('ROLE_GERSIST', 	'11');
define('ROLE_SUPSIST', 	'12');

//Sistemas
define('ROLE_CECASIT', 	 	'803');
define('ROLE_DIRCECASIT', 	'800');
define('ROLE_GERCECASIT', 	'801');
define('ROLE_SUPCECASIT', 	'802');

//Socios
define('ROLE_SOCIOS', 	 	'63');
define('ROLE_DIRSOCIOS', 	'60');
define('ROLE_GERSOCIOS', 	'61');
define('ROLE_SUPSOCIOS', 	'62');

//Comercial
define('ROLE_COMERCIAL', 	 	'73');
define('ROLE_DIRCOMERCIAL', 	'70');
define('ROLE_GERCOMERCIAL', 	'71');
define('ROLE_SUPCOMERCIAL', 	'72');

//Paginado
define('SEGMENT',2);
define('CANTPAGINA',15);

/* End of file constants.php */
/* Location: ./application/config/constants.php */
