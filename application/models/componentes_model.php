<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Componentes_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function componentesListingCount($searchText = '')
    {
        $this->db->select('Comp.id');
        $this->db->from('componentes_main as Comp');
        $this->db->join('componentes_marca as CM', 'CM.id = Comp.idmarca','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = Comp.idtipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = Comp.idequipo','left');

        if(!empty($searchText)) { 
            $this->db->like('CM.descrip', $searchText); 
            $this->db->or_like('CT.descrip', $searchText); 
            $this->db->or_like('EM.serie', $searchText); 
            //$this->db->or_like('BaseTbl.ubicacion_calle', $searchText); 
        }
        //$this->db->where('Comp.activo', 1);

        //$this->db->group_by('Comp.idtipo, Comp.idmarca, Comp.serie');
        $this->db->group_by('Comp.idtipo, Comp.idmarca, Comp.serie, Comp.idequipo');

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    function componentesListing($searchText = '', $page, $segment)
    {
        $this->db->select('Comp.id, Comp.serie, Comp.descrip, Comp.evento_actual, Comp.modelo, CM.descrip AS descrip_marca, CT.descrip AS descrip_tipo, EM.serie AS serieEquipo, COUNT(*) AS cantidad, Comp.idtipo, Comp.idmarca, Comp.activo');
        $this->db->from('componentes_main as Comp');
        $this->db->join('componentes_marca as CM', 'CM.id = Comp.idmarca','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = Comp.idtipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = Comp.idequipo','left');

        if(!empty($searchText)) { 
            $this->db->like('CM.descrip', $searchText); 
            $this->db->or_like('CT.descrip', $searchText); 
            $this->db->or_like('EM.serie', $searchText); 
            $this->db->or_like('Comp.modelo', $searchText); 
            //$this->db->or_like('BaseTbl.ubicacion_calle', $searchText); 
        }

        //$this->db->group_by('idtipo, idmarca, serie, idequipo');
        $this->db->group_by('Comp.idtipo, Comp.idmarca, Comp.serie, Comp.idequipo');


        //$this->db->where('Comp.activo', 1);
        $this->db->order_by("CT.descrip asc, EM.serie asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 

     /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function compNoAsigListingCount($searchText = '')
    {
        $this->db->select('Comp.id, Comp.serie, Comp.descrip, Comp.evento_actual, CM.descrip AS descrip_marca, CT.descrip AS descrip_tipo');
        $this->db->from('componentes_main as Comp');
        $this->db->join('componentes_marca as CM', 'CM.id = Comp.idmarca','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = Comp.idtipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = Comp.idequipo','left');

        $where = "Comp.idequipo = 0 ";

        if(!empty($searchText)) { 
            $where .= "AND (CM.descrip LIKE '%$searchText%' OR CT.descrip LIKE '%$searchText%') ";
        }
        
        $this->db->where($where);

        $this->db->group_by('Comp.idtipo, Comp.idmarca, Comp.serie, Comp.idequipo');

        $query = $this->db->get();
        
        return count($query->result());
    }
    
    function compNoAsigListing($searchText = '', $page, $segment)
    {
        $this->db->select('Comp.id, Comp.serie, Comp.descrip, Comp.evento_actual, Comp.modelo, CM.descrip AS descrip_marca, CT.descrip AS descrip_tipo, EM.serie AS serieEquipo, COUNT(*) AS cantidad, Comp.idtipo, Comp.idmarca, Comp.activo');
        $this->db->from('componentes_main as Comp');
        $this->db->join('componentes_marca as CM', 'CM.id = Comp.idmarca','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = Comp.idtipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = Comp.idequipo','left');

        $where = "Comp.idequipo = 0 ";

        if(!empty($searchText)) { 
            $where .= "AND (CM.descrip LIKE '%$searchText%' OR CT.descrip LIKE '%$searchText%' OR Comp.modelo LIKE '%$searchText%') ";
        }

        $this->db->where($where);

        $this->db->group_by('idtipo, idmarca, serie');

        //$this->db->where('Comp.activo', 1);
        $this->db->order_by("CT.descrip asc, Comp.serie asc");

        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        return $query->result();
    } 
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getComponenteTipos()
    {
        $this->db->select('id, descrip');
        $this->db->from('componentes_tipo');
        //$this->db->where('roleId !=', 1);
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }

    function getComponenteMarcas()
    {
        $this->db->select('id, descrip');
        $this->db->from('componentes_marca');
        //$this->db->where('roleId !=', 1);
        $this->db->order_by('descrip', 'asc');
        $query = $this->db->get();
        
        return $query->result();
    }   
  
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewComponente($componenteInfo)
    {
        $this->db->trans_start();
        $this->db->insert('componentes_main', $componenteInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    /**
     * This function is used to add new Componentes si Serie 
     */
    function addNewComponente2($componenteInfo, $cantidad)
    {
        $this->db->trans_start();
        for( $i=0; $i < $cantidad; $i++ )
        {
            $this->db->insert('componentes_main', $componenteInfo);
        }
        $this->db->trans_complete();
        
        return TRUE;
    }

    function getComponenteInfo($componenteId)
    {
        $this->db->select('Comp.id, Comp.serie, Comp.modelo, Comp.descrip, Comp.evento_actual, CM.descrip AS descrip_marca, Comp.idtipo, Comp.idmarca, Comp.idequipo, Comp.activo, CT.descrip AS descrip_tipo, EM.serie AS serieEq');
        $this->db->from('componentes_main as Comp');
        $this->db->join('componentes_marca as CM', 'CM.id = Comp.idmarca','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = Comp.idtipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = Comp.idequipo','left');
        //$this->db->where('Comp.activo', 1);
        $this->db->where('Comp.id', $componenteId);
        $query = $this->db->get();
        
        return $query->result(); 
    }

    function getComponenteInfo2($tipoId, $marcaId)
    {
        $this->db->select('Comp.descrip, Comp.evento_actual, CM.descrip AS descrip_marca, Comp.idtipo, Comp.idmarca, Comp.activo, Comp.modelo, CT.descrip AS descrip_tipo, COUNT(*) AS cantidad');
        $this->db->from('componentes_main as Comp');
        $this->db->join('componentes_marca as CM', 'CM.id = Comp.idmarca','left');
        $this->db->join('componentes_tipo as CT', 'CT.id = Comp.idtipo','left');
        $this->db->join('equipos_main as EM', 'EM.id = Comp.idequipo','left');
        //$this->db->where('Comp.activo', 1);
        $this->db->where('Comp.idtipo', $tipoId);
        $this->db->where('Comp.idmarca', $marcaId);
        $this->db->where('Comp.idequipo', 0); //sin asignar equipo

        //$this->db->group_by('idtipo, idmarca, serie');

        $query = $this->db->get();
        
        return $query->result(); 
    }
    
    
    function editComponente($componenteInfo, $componenteId)
    {
        $this->db->where('id', $componenteId);
        $this->db->update('componentes_main', $componenteInfo);
        
        return TRUE;
    }


    function editComponente2($componenteInfo, $cantidad, $idmarcaOld, $idtipoOld)
    {
        
//var_dump($componenteInfo);
//die($cantidad);

        $this->db->where('idtipo', $idtipoOld);
        $this->db->where('idmarca', $idmarcaOld);
        $this->db->where('idequipo', 0); //sin asignar equipo
        $this->db->delete('componentes_main');

        $this->db->trans_start();
        for( $i=0; $i < $cantidad; $i++ )
        {
            $this->db->insert('componentes_main', $componenteInfo);
        }
        $this->db->trans_complete();
        
        return TRUE;
    }

	function deleteComponente($componenteId, $componenteInfo)
    {
        $this->db->where('id', $componenteId);
        $this->db->update('componentes_main', $componenteInfo);
        
        return $this->db->affected_rows();
        //return $componenteInfo;
    }

    function deleteComponenteSinSerie($idtipo, $idmarca, $componenteInfo)
    {
        $this->db->where('idtipo', $idtipo);
        $this->db->where('idmarca', $idmarca);
        $this->db->update('componentes_main', $componenteInfo);
        
        return $this->db->affected_rows();
        //return $componenteInfo;
    }

    function componentesSinSerieListing($idtipo, $idmarca) //los IDs de componentes SIN serie
    {
        $this->db->select('Comp.id');
        $this->db->from('componentes_main as Comp');
        $this->db->where('idtipo', $idtipo);
        $this->db->where('idmarca', $idmarca);

        $query = $this->db->get();
        
        return $query->result();
    }

    function deleteCompRelacion($componenteId, $componenteInfo)
    {
        $this->db->where('id', $componenteId);
        $this->db->update('componentes_main', $componenteInfo);
        
        return $this->db->affected_rows();
        //return $componenteInfo;
    }
    
    function getComponentesByTipo($id, $seriado = FALSE, $equipo = FALSE, $offset = FALSE)
    {
    	$this->db->select('cm.id as idcomponente, ct.id as idtipocomponente, idmarca, idequipo, serie, cm.descrip as compdescrip, ct.descrip as descrip, estado_comp, evento_actual, cm.activo, cm.creadopor, cm.fecha_alta, cm.eliminado, fecha_baja, seriado, observaciones');
    	$where = array(
    			'cm.idtipo' => $id,
    			'cm.activo' => '1'
    	);
    	if ($seriado !==FALSE) {
    		$where['ct.seriado'] = $seriado;
    	}
    	$this->db->where($where);
		if ($equipo) {
			// equipo es un array
			$this->db->where_in('idequipo',$equipo);
		}
    	$this->db->join('componentes_tipo ct', 'ct.id = cm.idtipo','left');
    	if ($offset !== FALSE) {
   			$this->db->limit(1, $offset);
    	}
    	$this->db->order_by("cm.id", "asc");
    	$query = $this->db->get('componentes_main cm');
    	return $query->result(); 
    }

    function getComponentesByTipoEquipoCount($id,$equipo)
    {
    	$this->db->select('count(*) as cant');
    	$where = array(
    			'idtipo' => $id,
    			'idequipo' => $equipo
    	);
    	$query = $this->db->get_where('componentes_main',$where);
    	$row = $query->row(); 
    	return $row->cant;
    }

    /* ------------- METODOS API ------------- */

    function get($queryParams = array()) {

        $fields = $queryParams["fields"] ?? "*";
        $where = $queryParams["where"];
        $wherein = $queryParams["wherein"];
        $joins = $queryParams["joins"]; 
        $fields = is_array($fields) ? join(",", $fields) : $fields;
        $this->db->select($fields);
        $this->db->from('componentes_main');
        if($joins) { 
            foreach ($joins as $join) {
                $join_explode = explode(",", $join);
                $this->db->join($join_explode[0], $join_explode[1], $join_explode[2]);
            }
        }
        if($where) {
            $this->db->where($where[0], $where[1]);
        }
        if($wherein) {
            $this->db->where_in($wherein[0], explode(',', $wherein[1]));
        }
        $query = $this->db->get();
        return $query->result();
    }
}