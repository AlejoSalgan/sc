<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class precintos_model extends CI_Model
{
    function getEquipoBySerie($serie) 
    {
        $this->db->select('*'); // (ubicacion_calle, ubicacion_altura, ubicacion_localidad, descrip, ubicacion_velper, multicarril');
        $this->db->where('serie',$serie);
        $query = $this->db->get('equipos_main as em');
        $result = $query->result();
        $exist = count($result);
        
        if ($exist == 0){
            return FALSE;
        }
        return $result;
    }
    
    function getpuntos_precintados()
    {
        $this->db->select('*');
        $this->db->from('puntos_precintado');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    
    function get_precintos()
    {
        $this->db->select('PR.*, EP.descripcion');
        $this->db->from('precintos as PR');
        $this->db->join('estado_precinto as EP', 'PR.estado = EP.id', 'right');
        $this->db->where( 'PR.estado = EP.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    function insertPunto($punto,$modelo){
        
        $data = array('descripcion' => $punto);
        $this->db->trans_start();
        $this->db->insert('puntos_precintado', $punto);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
    }
    
    function get_Estado($estado_desc) {
        
        $query = $this->db->get_where('estado_precinto', array(
            'descripcion' => $estado_desc));
        $row    = $query->row();
        $estado = $row->id;
        return $estado;
    }
    
    function cambiarEstado_precintoAnt($precinto, $id_estado)
    {
        if ($precinto != NULL) {
            $data  =  array (
                'estado'  => $id_estado
            );
            $this->db->where ('id', $precinto );
            $this->db->update ('precintos', $data);
        }
    }
    
    function cambiarEstado_precintoNUEVO($precinto, $id_estado)
    {
        if ($precinto != NULL) {
            $data  =  array (
                'estado'  => $id_estado
            );
            $this->db->where ('id', $precinto );
            $this->db->update ('precintos', $data);
        }
    }
    
    function insert_actaReparaciones( $id_equipo, $id_puntos_precintos,$info_acta)
    {
       $serie =  trim($info_acta[1][3]);
       $nro_interno = $serie."_".str_replace("-","", $info_acta[1][0]);
       $originalDate = $info_acta[1][0];
       $fecha = date("Y/m/d", strtotime($originalDate));
       
       foreach ($info_acta[3] as $value){
           $modif_instrum .= $value;
       } 
       
       $tabla_actas_precinto = array(
           //'id_acta' => 0,
           'codigo_interno' => $nro_interno,
           'fecha_acta' => $fecha ,
           'id_equipo' => $id_equipo,
           'codigo_aprobacion'=> "0",
           'informe_calibracion' => "0",
           'modificacion_instrumento' => $modif_instrum
       );
       
       $this->db->insert('actas_precinto', $tabla_actas_precinto);
       $id_result = $this->db->insert_id();
       $index = count($info_acta[2]);
       
       $ind = 0; 
       $y = 2;
       
       while ($ind != $index) {
           for ($x = 0; $x < 1; $x++) {
               $estado = $this->get_Estado($info_acta[$y][$ind][2]);
               $actas_precintos_estado = array(
                   'id_acta' => $id_result,
                   'id_puntos_precintado' => $id_puntos_precintos[$ind],
                   'id_precinto_anterior' => $info_acta[$y][$ind][1],
                   'id_precinto_nuevo' => $info_acta[$y][$ind][3],
                   'id_estados'=> $estado
               );
               settype($actas_precintos_estado, "array");
               $this->db->insert('actas_precintos_estado', $actas_precintos_estado);
               $this->cambiarEstado_precintoAnt($info_acta[$y][$ind][1], $estado);
               $this->cambiarEstado_precintoNUEVO($info_acta[$y][$ind][3], 4);
           }
           $ind++;
       }
       return $id_result;
    }
       
    function checkprecinto($numero_precinto)
    {
        if (!$numero_precinto == NULL){
            $query = $this->db->get_where('precintos', array( 'id' => $numero_precinto));
            $count = $query->num_rows(); //counting result from query
            $row   = $query->row();
            if ($count == 1) {
                Return TRUE;
            } else {
                return FALSE;
            }
        }
    }
    
    function precinto($numeros_precinto)
    {
        //$precintos_no_exist = array();
        $max                = count($numeros_precinto);
        
        for ($i = 0; $i < $max; $i++) {
            
            $precintoAnterior = $numeros_precinto[$i][1];
            $precintonuevo    = $numeros_precinto[$i][3];
            
            if (is_null($precintoAnterior)) {
                
                $result2 = $this->checkprecinto($precintonuevo);
               
                if (!$result2) {
                    $precintos_no_exist .= "El precinto Nº ".$precintonuevo." no esta cargado "."<br>";
                }
            } else {
                $result = $this->checkprecinto($precintoAnterior);
                if (!$result) {
                    $precintos_no_exist .= "El precinto Nº ".$precintoAnterior." no esta cargado "."<br>";
                    $result2 = $this->checkprecinto($precintonuevo);
                    if (!$result2) {
                        $precintos_no_exist .= "El precinto Nº ".$precintonuevo." no esta cargado "."<br>";
                    }
                } else {
                    $result2 = $this->checkprecinto($precintonuevo);
                    if (!$result2) {
                        $precintos_no_exist .= "El precinto Nº ".$precintonuevo." no esta cargado "."<br>";
                    }
                }
            }
        }
        $noExist = empty($precintos_no_exist);
//         echo "<pre>";
//         die(var_dump($numeros_precinto));
//         echo "</pre>";
        if (!$noExist) {
            $sql_result = array( 0, $precintos_no_exist);
            return $sql_result;
        } else {
            $sql_result = array(1);
            return $sql_result;
        }
    }
    
    function insert_precinto( $desde , $hasta)
    {
        $con = 0;
        settype($con, "integer");
        $hoy = date("Y-m-d");
        $query = null; //emptying in case
        
        if ($hasta == ""){
            $inicio = $desde;
            $max =  $desde + 1;
        } else {
            $max = $hasta + 1;
            $inicio = $desde;
        }
        
        while ($inicio < $max ) {
            $query = $this->db->get_where('precintos', array('id' => $inicio));
            $count = $query->num_rows(); //counting result from query
            if ($count == 0) {
                
                $data = array('id' => $inicio, 'estado' => 5, 'precinto_fecha' => $hoy);
                
                $this->db->insert('precintos', $data);
            } else {
                $result = array( FALSE, $inicio);
                return $result;
            }
            $inicio++;
        }
        $result[0] = TRUE;
        return $result;
        //$result = $max - $desde;
    }
    
    function get_PuntosPrecintos($puntos_precintado, $idmodelo)
    {
        $con = 0;
        $id_result = array();
        $cant_puntos = count($puntos_precintado);
        
        while ($con != $cant_puntos )
        {
            $query = null; //emptying in case
            $this->db->select('*');
            $this->db->from('puntos_precintado');
            $this->db->where( 'descripcion', $puntos_precintado[$con]);
            $query = $this->db->get();
            $count = $query->num_rows(); // resultado de la consulta hecha arriba. debe ser CERO para poder          insertar.
            
            // si la cantidad de filas es cero.. hace el insert en la tabla.
            if ($count === 0) {
                $data = array( 'descripcion' => $puntos_precintado[$con] ); // array del insert a realizar.
                $this->db->insert('puntos_precintado', $data);
                $id_result[$con] = $this->db->insert_id();
                $data2 = array( 'idpunto_precinto' => $id_result[$con] , 'idmodelo'=> $idmodelo ); // array del insert a realizar.
                $this->db->insert('configuracion_precintos', $data2);
           
            } else {
                $row = $query->row();
                $id_result[$con] = $row->id;
            }
            $con++;
        }
        return $id_result;
    }
    
    function configuracion_precintos( $idmodelo, $id_punto_precintado)
    {
        $i = 0;
        $cant_puntos = count($id_punto_precintado);
        
        foreach ( $id_punto_precintado as $punto )
        {
            $this->db->select('idpunto_precinto, idmodelo');
            $this->db->from('configuracion_precintos');
            $this->db->where('idpunto_precinto', $punto);
            $this->db->where('idmodelo', $idmodelo);
            $query = $this->db->get();
            $result = $query->result();
            $cant = count($result);
            
            if ($cant === 1){
                $i++;
            }
        }
        
        if ($i != $cant_puntos) {
            return FALSE;
        }
        return TRUE;
    }
    
    function precintoExist_acta($precinto)
    {
        //$result = array();
        $max = count($precinto);
        for ($X = 0; $X < $max; $X++) {
            
            $precintoNuevo    = $precinto[$X][3];
            $this->db->select('APE.*, AP.*' );
            $this->db->from('actas_precintos_estado as APE');
            $this->db->join( 'actas_precinto as AP', 'APE.id_acta = AP.id_acta','right');
            $this->db->where('APE.id_precinto_nuevo', $precintoNuevo);
            $query = $this->db->get();
            $row = $query->row();
            $this->db->select('PR.*, EP.descripcion');
            $this->db->from('precintos as PR');
            $this->db->join('estado_precinto as EP', 'PR.estado = EP.id', 'right');
            $this->db->where('PR.id', $precintoNuevo);
            $query = $this->db->get();
            $fila = $query->row();
            $estado = $fila->estado;
         
            if ($row) {
                $id_acta = "Precinto Nº ".$row->id_precinto_nuevo." se encuentra en el acta: ".$row->codigo_interno;
            }
            if ($id_acta) {
                $result .= $id_acta."<br>";
            }
        }
        if ($result) {
            return $result;
        } else {
            return FALSE;
        }
    }
    
    function precinto_estado_Nuevo($numeros_precinto)
    {
      $max = count($numeros_precinto);
      //$precinto_estado = array();
     
      for ($i = 0; $i < $max; $i++) {
          $precintoNuevo    = $numeros_precinto[$i][3];
          $this->db->select('PR.*, EP.descripcion');
          $this->db->from('precintos as PR');
          $this->db->join('estado_precinto as EP', 'PR.estado = EP.id', 'right');
          $this->db->where('PR.id', $precintoNuevo);
          $query = $this->db->get();
          $fila = $query->row();
          $estado = $fila->estado;
          
          if ($estado < 5)  {
              $precinto_estado .= "El precinto Nº ".$precintoNuevo." Se encuentra ".$fila->descripcion."<br>";  
          }
      }
      
      if ( empty($precinto_estado )) {
          return FALSE;//$precinto_estado;
      } else {
          return $precinto_estado;
      }
    }

    function get_info($idacta)
    {
        $this->db->select('AP.*, APE.*');
        $this->db->from('actas_precinto as AP');
        $this->db->join('actas_precintos_estado as APE', 'AP.id_acta = APE.id_acta', 'right');
        $this->db->where('AP.id_acta', $idacta);
        $query = $this->db->get();
        //$fila = $query->row();
        return $query->result();
    }

    function get_punto($id_punto)
    {
        $this->db->select('descripcion');
        $this->db->from('puntos_precintado');
        $this->db->where('id', $id_punto);
        $query = $this->db->get();
        $result = $query->Row();
        return $result->descripcion ;
    }
    
    function get_equipo($id_equipo)
    {
        $this->db->select('*');
        $this->db->from('equipos_main');
        $this->db->where('id', $id_equipo);
        $query = $this->db->get();
        $row = $query->row();
        return $row;
    }
    
    function get_estados($id_estado)
    {
        $this->db->select('*');
        $this->db->from('estado_precinto');
        $this->db->where('id', $id_estado);
        $query = $this->db->get();
        $estado_desc = $query->row();
        return $estado_desc->descripcion ;
    }
    
    function get_marca($id_marca)
    {
        $this->db->select('*');
        $this->db->from('equipos_marcas');
        $this->db->where('id', $id_marca);
        $query = $this->db->get();
        $marca_desc = $query->row();
        return $marca_desc->descrip ;
    }
    
    function get_modelo($id_modelo)
    {
        $this->db->select('*');
        $this->db->from('equipos_modelos');
        $this->db->where('id', $id_modelo);
        $query = $this->db->get();
        $modelo_desc = $query->row();
        return $modelo_desc->descrip ;
    }
    
    function get_localidad($id_localidad)
    {
        $this->db->select('id');
        $this->db->from('estados_precinto');
        $this->db->where('id', $id_localidad);
        $query = $this->db->get();
        $localidad_desc = $query->descripcion;
        return $localidad_desc ;
    }
    
    function get_municipio($id_equipo)
    {
        $this->db->select('EM.*, MUN.*');
        $this->db->from('equipos_main as EM');
        $this->db->join('municipios as MUN', 'EM.municipio = MUN.id', 'right');
        $this->db->where('EM.id', $id_equipo);
        $query = $this->db->get();
        $fila = $query->row();
        return $fila->descrip;
    }
    
    function update_archivoID($idarchivo, $idacta)
    {
        $data  =  array (
            'id_archivo'  => $idarchivo
        );
        $this->db->where ('id_acta', $idacta );
        $this->db->update ('actas_precinto', $data);
    }
    
    
    function updateEstadoPrecintos($id_acta)
    {
        $precintos = array();
        $this->db->select('*');
        $this->db->from('actas_precintos_estado');
        $this->db->where('id_acta', $id_acta);
        $query = $this->db->get();
        $result = $query->result();
        $max = count($result);
        
        for ($i = 0; $i < $max; $i++) {
            
            if (empty($result[$i]->id_precinto_anterior)){
                $precintos[] = $result[$i]->id_precinto_nuevo;
            } else {
                $precintos[] = $result[$i]->id_precinto_anterior;
                $precintos[] = $result[$i]->id_precinto_nuevo;
            }
        }
        $max2 = count($precintos);
        $result2 = array($max2, $precintos);
        
        return $result2;
    }
    
    function eliminar_acta($id_archivo)
    {
        echo "idarchivo: ".$id_archivo."<br>";
        $this->db->select('id_acta');
        $this->db->from('actas_precinto');
        $this->db->where('id_archivo', $id_archivo);
        $query = $this->db->get();
        $fila = $query->row();
        $id = $fila->id_acta;
        
        $data = array('estado' => 5);
        $result = $this->updateEstadoPrecintos($id);
        
        for ($i = 0; $i < $result[0]; $i++) {
            $this->db->where('id',  $result[1][$i]);
            $this->db->update('precintos', $data);
        }
        $this->db->delete('actas_precinto', array('id_archivo'=> $id_archivo));  // Produces: // DELETE FROM mytable  // WHERE id = $id
        $this->db->delete('actas_precintos_estado', array('id_acta'=> $id));
    }
    
    function eliminarPrecinto($NumPRecinto) {
        $this->db->delete('precintos', array('id' => $NumPRecinto)); 
    }
    
}
