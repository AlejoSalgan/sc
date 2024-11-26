<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Adjuntar_model extends CI_Model
{
// VALIDACIONES //
    function tipoDocumento ($ext){
      if (in_array($ext, tipo_doc)){
        return TRUE;
      }else{
        $mensaje = 'Formato de archivo no aceptado o no se adjunto archivo.';
        return $mensaje;
      }
    }

    function moverArchivo ($nombre_temp, $destino, $archivoInfo, $id_orden){
      if (move_uploaded_file($nombre_temp,$destino)){
        $this->adjuntar_model->agregarArchivo($archivoInfo);
        $flash = array("success", "Archivo guardado correctamente para la orden de trabajo Nº $id_orden");
      }else{
        $flash = array("error", "Error al guardar archivo para la orden de trabajo Nº $id_orden");
      }
        return $flash;
    }



    function eliminarArchivo ($destino, $archivoInfo, $id){
      if (unlink($destino)){
        $this->adjuntar_model->updateArchivo($archivoInfo, $id);
        $flash = array('success', 'Archivo adjunto borrado.');
      }else{
        $flash = array('error', 'Error al borrar el archivo adjuntado.');
      }
        return $flash;
    }

// LISTADOS //

    function getArchivos($idorden, $count = NULL, $estado = 0)
    {
        $this->db->select('OA.id, OA.orden, OA.nombre_archivo, OA.tipo_documentacion, OA.observacion, OA.archivo, OA.tipo, OA.creado_por, OA.fecha_ts, U.name' );
        $this->db->from('ordenes_archivos as OA');
        $this->db->join('tbl_users as U', 'OA.creado_por = U.userId','left');
        $this->db->where('OA.orden', $idorden);
        $this->db->where('OA.activo', 1);
        $this->db->where('OA.estado', $estado);

        $query = $this->db->get();
        if ($count == NULL) {
          return $query->result();
        } else {
          return count($query->result());
        }
    }



// AGREGAR //


    function agregarArchivo($archivoInfo) //Agrego un nuevo archivo a la orden de trabajo.
    {
        $this->db->trans_start();
        $this->db->insert('ordenes_archivos', $archivoInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

// MODIFICAR //

    function updateArchivo($archivoInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('ordenes_archivos', $archivoInfo);

        return TRUE;
    }

    function updateArchivos($archivoInfo, $id_orden)
    {
        $this->db->where('orden', $id_orden);
        $this->db->where('activo', 1);
        $this->db->where('estado', 0);
        $this->db->update('ordenes_archivos', $archivoInfo);

        return TRUE;
    }


// OBTENER INFORMACION //

    function getArchivo($id)
    {
      $this->db->select('OA.id, OA.archivo, OA.tipo_documentacion');
      $this->db->from('ordenes_archivos as OA');
      $this->db->where('OA.id', $id);

      $query = $this->db->get();
      $row = $query->row();
      return $row;

    }





///////////////////////////////////////////////////////////////////////////////

    function getArchivosEquipos($id_equipo, $count = NULL, $estado = 0)
    {
        $this->db->select('EA.id, EA.nombre_archivo, EA.tipo_documentacion, EA.observacion, EA.archivo, EA.tipo, EA.creado_por, EA.fecha_ts, U.name' );
        $this->db->from('equipos_archivos as EA');
        $this->db->join('tbl_users as U', 'EA.creado_por = U.userId','left');
        $this->db->where('EA.id_equipo', $id_equipo);
        $this->db->where('EA.activo', 1);
        $this->db->where('EA.estado', $estado);

        $query = $this->db->get();
        if ($count == NULL) {
          return $query->result();
        } else {
          return count($query->result());
        }
    }

    //Este es el DEFINITIVO.
    function mover_Archivo($nombre_temp, $destino, $archivoInfo, $tabla){
      if (move_uploaded_file($nombre_temp,$destino)){
        $this->adjuntar_model->agregar_Archivo($archivoInfo, $tabla);
        $flash = array("success", "Archivo guardado correctamente");
      }else{
        $flash = array("error", "Error al guardar el archivo");
      }
        return $flash;
    }

    //Este es el DEFINITIVO.
    function agregar_Archivo($archivoInfo, $tabla)
    {
        $this->db->trans_start();
        $this->db->insert($tabla, $archivoInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function update_Archivo($archivoInfo, $id, $tabla)
    {
        $this->db->where('id', $id);
        $this->db->update($tabla, $archivoInfo);

        return TRUE;
    }

    function update_Archivo2($archivoInfo, $id_equipo)
    {
        $this->db->where('id_equipo', $id_equipo);
        $this->db->update('equipos_archivos', $archivoInfo);

        return TRUE;
    }

    function update_Archivo3($archivoInfo, $id_orden, $tipo_orden)
    {
        /*
        //A futuro usar este array para updatear la tabla de los archivos
        $array = array('name' => $name, 'title' => $title, 'status' => $status);
        $this->db->where($array);
        // Produces: WHERE name = 'Joe' AND title = 'boss' AND status = 'active'
        */

        $this->db->where('orden', $id_orden);
        $this->db->where('tipo_orden', $tipo_orden);
        $this->db->where('activo', 1);
        $this->db->update('instalaciones_archivos', $archivoInfo);

        return TRUE;
    }

    function eliminar_Archivo ($destino, $archivoInfo, $id, $tabla){
      if (unlink($destino)){
        $this->adjuntar_model->update_Archivo($archivoInfo, $id, $tabla);
        $flash = array('success', 'Archivo adjunto borrado.');
      }else{
        $flash = array('error', 'Error al borrar el archivo adjuntado.');
      }
        return $flash;
    }

    function get_Archivo($id, $tabla)
    {
      $this->db->select('id, archivo, tipo_documentacion');
      $this->db->from($tabla);
      $this->db->where('id', $id);

      $query = $this->db->get();
      $row = $query->row();
      return $row;
    }







}

?>
