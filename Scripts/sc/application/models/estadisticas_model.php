<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas_model extends CI_Model
{
  // LISTADOS //

    function listadoArchivos($searchText = '',$criterio,$page = NULL, $segment = NULL,$role,$userId,$opciones)
    {
        $this->db->select('EA.id, EA.nombre_archivo, EA.protocolo, EA.id_orden, EA.copiado, EA.procesado, EA.desencriptado, EA.decripto');
        $this->db->from('estadisticas_archivos as EA');
        
        if(!empty($searchText)) {
          if($criterio != '0') {
            $likeCriteria = "(".$criterio. " LIKE '%".$searchText."%')";
          }else{
            $likeCriteria .= "(";
            foreach($opciones as $key => $opcion){
              if($key != '0'){
                $likeCriteria .= $key. " LIKE '%".$searchText."%'";
              }
              if(end(array_keys($opciones)) != $key){
                $likeCriteria .= " OR ";
              }
            }
            $likeCriteria .= ")";
          }
          $this->db->where($likeCriteria);
        }
        
        if (empty($searchText)) {
          $this->db->where('EA.copiado !=', 1);
          $this->db->or_where('EA.desencriptado !=', 1);
          $this->db->or_where('EA.procesado !=', 1);

          $this->db->order_by('EA.desencriptado','ASC');
          $this->db->order_by('EA.copiado','DESC');
          $this->db->order_by('EA.protocolo','ASC');
          $this->db->order_by('EA.nombre_archivo','ASC');
        }else {
          $this->db->order_by('EA.protocolo','ASC');
          $this->db->order_by('EA.nombre_archivo','ASC');
          $this->db->order_by('EA.copiado','DESC');
        }

        if ($page != NULL) {
          $this->db->limit($page, $segment);
        }

        $query = $this->db->get();

        if ($page != NULL) {
          return $query->result();
        }
        return count($query->result());
    }



    //////////////// MODIFICAR /////////////

    function editarArchivo($archivoInfo,$id_archivo) 
    {
        $this->db->where('id', $id_archivo);
        $this->db->update('estadisticas_archivos', $archivoInfo);

        return TRUE;
    }


}

?>
