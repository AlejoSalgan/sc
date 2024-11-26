<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Modeloseq_model extends CI_Model
{
    
    function modeloseqListingCount($searchText = '',$criterio)
    {
        $this->db->select('EM.id');
        $this->db->from('equipos_modelos as EM');

        if(!empty($searchText)) { 
            switch ($criterio) {
                case 1:
                    $likeCriteria = "(EM.descrip  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(EM.sigla  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(EM.asociado  LIKE '%".$searchText."%')";
                    break;
                
                default:
                    $likeCriteria = "(EM.descrip  LIKE '%".$searchText."%'
                            OR  EM.sigla  LIKE '%".$searchText."%'
                            OR  EM.asociado  LIKE '%".$searchText."%')";
                    break;
            }
            
            $this->db->where($likeCriteria);
        }

        $this->db->order_by("EM.descrip", "asc");

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    
    function modeloseqListing($searchText = '', $page, $segment,$criterio)
    {
        $this->db->select('EM.id, EM.descrip, EM.activo, EM.sigla, EM.observaciones, EM.asociado, EM.sistemas_aprob, P.descrip as asoc');
        $this->db->from('equipos_modelos as EM');
        $this->db->join('equipos_propietarios as P', 'P.descrip = EM.asociado','left');
        
        if(!empty($searchText)) { 
           switch ($criterio) {
                case 1:
                    $likeCriteria = "(EM.descrip  LIKE '%".$searchText."%')";
                    break;

                case 2:
                    $likeCriteria = "(EM.sigla  LIKE '%".$searchText."%')";
                    break;

                case 3:
                    $likeCriteria = "(EM.asociado  LIKE '%".$searchText."%')";
                    break;
                
                default:
                    $likeCriteria = "(EM.asociado  LIKE '%".$searchText."%'
                            OR  EM.sigla  LIKE '%".$searchText."%'
                            OR  EM.asociado  LIKE '%".$searchText."%')";
                    break;
            }
            
            $this->db->where($likeCriteria);
        }

        $this->db->order_by("EM.descrip", "asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    

    
    function addNewModeloeq($modeloeqInfo)
    {
        $this->db->trans_start();
        $this->db->insert('equipos_modelos', $modeloeqInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    function validarModelo($serie){
        $this->db->select('id','sigla');
        $this->db->from('equipos_modelos');
        $this->db->where('sigla', $serie);
        $query = $this->db->get();
        
        return $query->result();
    }
    

    function getModeloeqInfo($modeloeqId)
    {
        $this->db->select('id, descrip, activo, descrip_alt, sigla, asociado, observaciones');
        $this->db->from('equipos_modelos');
        $this->db->where('id', $modeloeqId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    
    function editModeloeq($modeloeqInfo, $modeloeqId)
    {
        $this->db->where('id', $modeloeqId);
        $this->db->update('equipos_modelos', $modeloeqInfo);
        
        return TRUE;
    }
    
    
    function deleteModeloeq($modeloeqId, $modeloeqInfo)
    {
        $this->db->where('id', $modeloeqId);
        $this->db->update('equipos_modelos', $modeloeqInfo);
        
        return $modeloeqInfo;
    }
    
/*    function aprobarEq($modeloeqId,$modeloeqInfo)
    {
        $this->db->where('sigla', $modeloeqId);
        $this->db->update('equipos_modelos', $modeloeqInfo);
        
        return $modeloeqInfo;
    }*/
    
    function aprobarEquipo($equipoInfo, $equipoId)
    {
        $this->db->where('id', $equipoId);
        $this->db->update('equipos_modelos', $equipoInfo);
        
        return true;
    }

}

  