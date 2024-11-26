<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ordenes_model extends CI_Model
{
	function getCountOrdenes($estado = NULL, $tipo = NULL, $orden = NULL, $search = '',$userId, $role, $page = NULL)
	{
		$this->db->select('*');
		$this->db->from('reparacion_main as rm');
		$this->db->join('reparacion_estados as re', 'rm.id = re.orden','inner');
		$this->db->join('fallas_main as fm', 'fm.id = rm.falla','left');
		$this->db->join('fallas_motivos as mo', 'mo.id = fm.motivo','left');
		$this->db->join('municipios as mu', 'mu.id = rm.idproyecto','left');
		$this->db->join('tbl_users as u', 'u.userId = re.usuario','left');
		$this->db->join('tbl_roles as r', 'r.roleId = u.roleId','left');
		$this->db->join('tbl_puestos as p', 'p.id = u.puesto','left');
		$this->db->join('equipos_main as em', 'em.serie = rm.serie','left');
		$this->db->join('equipos_marcas as ema', 'ema.id = em.marca','left');
		$this->db->join('equipos_modelos as emo', 'emo.id = em.idmodelo','left');
		$this->db->join('ordenes_tipo_estados as ote', 'ote.id = rm.ultimo_estado','left');
		$this->db->join('tbl_users as ue', 'ue.userId = mu.gestor','left');
		$this->db->join('reparacion_categorias as rc', 'rc.id = rm.ultimo_categoria','left');
		$this->db->join('estados as es', 'em.estado = es.id','left');
		$this->db->join('diagnosticos_main as dm', 'dm.id = rm.diagnostico','left');
		$this->db->join('ordenes_visitas as ov', 'ov.id_orden = rm.id AND ov.id = (SELECT MAX(id) FROM ordenes_visitas )','left');

		if (in_array($role,array(101,102,103,104,105))) {
			$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = mu.id','left');
		}

		if(!empty($search)) {
			$busqueda = "(
							fm.descrip LIKE '%".$search."%'
							OR rm.serie LIKE '%".$search."%'
							OR mu.descrip LIKE '%".$search."%'
							OR mo.descrip LIKE '%".$search."%'
							OR rc.descrip LIKE '%".$search."%'
						)";
			$this->db->where($busqueda);
		}

		if (!is_null($estado)) {
			if (is_array($estado)) {
				$this->db->where_in('rm.ultimo_estado', $estado);
				$this->db->where_in('re.tipo', $estado);
			} else {
				$this->db->where('rm.ultimo_estado', $estado);
				$this->db->where('re.tipo', $estado);
			}
		}
		if (!is_null($tipo)) {
			switch ($tipo) {
				case 'R':
					$categoria = 1;
					break;
				case 'M':
					$categoria = 2;
					break;
				case 'I':
					$categoria = 3;
					break;
			}
			$this->db->where("(rm.tipo = '{$tipo}' OR rm.ultimo_categoria = {$categoria})");
		}
		$this->db->where('em.eliminado', 0);

		if (in_array($role,array(101,102,103,104,105))) {
			$this->db->where('MA.usuario',$userId);
		}

		$this->db->group_by('re.orden');
		if (is_null($orden)) {
			$this->db->order_by('re.fecha','DESC');
		} else {
			$this->db->order_by('re.fecha',$orden);
		}

		$this->db->order_by('re.fecha','DESC');

		if ($page != NULL) {
			$this->db->limit($page, $segment);
		}

		$query = $this->db->get();

		return $query->num_rows();
	}


	function getOrdenes($estado = NULL, $tipo = NULL, $orden = NULL, $search = '',$userId, $role, $page = NULL, $segment = NULL)
	{
		$this->db->select("rm.id as rm_id, rm.tipo as rm_tipo, rm.ultimo_estado as rm_ultimo_estado, rm.falla as rm_falla, rm.idproyecto as rm_idproyecto, rm.fecha_visita as rm_fecha_visita, rm.supervisor as rm_supervisor, rm.idflota as rm_idflota, rm.conductor as rm_conductor, rm.tecnico as rm_tecnico, rm.serie as rm_serie, rm.enviado as rm_enviado, rm.enviado_fecha as rm_enviado_fecha, rm.ack as rm_ack, rm.nro_msj as rm_nro_msj, rm.recibido as rm_recibido, rm.recibido_fecha as rm_recibido_fecha, rm.fecha_baja as rm_fecha_baja, rm.ord_procesado as rm_ord_procesado, rm.procesado_fecha as rm_procesado_fecha, rm.ultimo_categoria as rm_ultimo_categoria, re.id as re_id, re.usuario as re_usuario, re.fecha as re_fecha, re.tipo as re_tipo, re.observ as re_observ, fm.id as fm_id, fm.descrip as fm_descrip, fm.motivo as fm_motivo, mo.id as mo_id, mo.descrip as mo_descrip, mu.id as mu_id, mu.descrip as mu_descrip, u.userId as u_id, u.email as u_email, u.name as u_name, u.nombre as u_nombre, u.apellido as u_apellido, u.mobile as u_mobile, u.modelomov as u_modelomov, u.imei as u_imei, u.roleId as u_roleId, u.puesto as u_puesto, u.asociado as u_asociado, u.tipo as u_tipo, u.isDeleted as u_isDeleted, u.createdBy as u_createdBy, u.createdDtm as u_createdDtm, u.updatedBy as u_updatedBy, u.updatedDtm as u_updatedDtm, r.roleId as r_roleId, r.role as r_role, p.id as p_id, p.descrip as p_descrip, p.jerarquia as p_jerarquia, em.id as em_id, em.serie as em_serie, em.municipio as em_municipio, em.ubicacion_calle as em_ubicacion_calle, em.ubicacion_altura as em_ubicacion_altura, em.ubicacion_mano as em_ubicacion_mano, em.ubicacion_sentido as em_ubicacion_sentido, em.ubicacion_localidad as em_ubicacion_localidad, em.ubicacion_cp as em_ubicacion_cp, em.geo_lat as em_geo_lat, em.geo_lon as em_geo_lon, em.tipo as em_tipo, em.tipo_equipo as em_tipo_equipo, em.multicarril as em_multicarril, em.marca as em_marca, em.idmodelo as em_idmodelo, em.modelo as em_modelo, em.serie_int as em_serie_int, em.vehiculoasig as em_vehiculoasig, em.decriptador as em_decriptador, em.mapa_x as em_mapa_x, em.mapa_y as em_mapa_y, em.estado_mapa as em_estado_mapa, em.falta as em_falta, em.ts as em_ts, em.ubicacion_velper as em_ubicacion_velper, em.observ as em_observ, em.series_asociados as em_series_asociados, em.doc_certif as em_doc_certif, em.doc_fechacal as em_doc_fechacal, em.doc_fechavto as em_doc_fechavto, em.doc_tipocal as em_doc_tipocal, em.doc_aprob as em_doc_aprob, em.doc_normasic as em_doc_normasic, em.doc_distancia as em_doc_distancia, em.remito as em_remito, em.pedido as em_pedido, em.ordencompra as em_ordencompra, em.exportable as em_exportable, em.idmunicipio as em_idmunicipio, em.localidad as em_localidad, em.jur_const as em_jur_const, em.jur_aplic as em_jur_aplic, em.aut_const as em_aut_const, em.ejido_urbano as em_ejido_urbano, em.cp as em_cp, em.tipo_medio as em_tipo_medio, em.ftp_host as em_ftp_host, em.ftp_user as em_ftp_user, em.ftp_pass as em_ftp_pass, em.alerta_bajadas as em_alerta_bajadas, em.bajada_automatica as em_bajada_automatica, em.region as em_region, em.baja as em_baja, em.fecha_baja as em_fecha_baja, em.creadopor as em_creadopor, em.fecha_alta as em_fecha_alta, em.estado as em_estado, em.evento_actual as em_evento_actual, em.instalado as em_instalado, em.requiere_calib as em_requiere_calib, em.calibrado as em_calibrado, em.fecha_ultmod as em_fecha_ultmod, em.activo as em_activo, em.eliminado as em_eliminado, em.idpropietario as em_idpropietario, em.nro_ot as em_nro_ot, em.prueba as em_prueba, ote.id as ote_id, ote.descrip as ote_descrip, ema.id as ema_id, ema.descrip as ema_descrip, ema.creadopor as ema_creadopor, ema.fecha_alta as ema_fecha_alta, ema.fecha_baja as ema_fecha_baja, ema.activo as ema_activo, ema.eliminado as ema_eliminado, ema.observaciones as ema_observaciones, emo.id as emo_id, emo.descrip as emo_descrip, emo.descrip_alt as emo_descrip_alt, emo.sigla as emo_sigla, emo.asociado as emo_asociado, emo.creadopor as emo_creadopor, emo.fecha_alta as emo_fecha_alta, emo.fecha_baja as emo_fecha_baja, emo.activo as emo_activo, emo.eliminado as emo_eliminado, emo.observaciones as emo_observaciones, ue.userId as ue_userId, ue.email as ue_email, ue.name as ue_name, ue.nombre as ue_nombre, ue.apellido as ue_apellido, rc.id as rc_id, rc.descrip as rc_descrip, rc.color as rc_color, es.id as es_id, es.descrip as es_descrip, rm.diagnostico as rm_diagnostico, dm.id as dm_id, dm.descrip as dm_descrip, ov.fecha_visita as ov_fecha_visita, ov.conductor as ov_conductor, ov.tecnico as ov_tecnico, ov.idflota as ov_idflota, EP.id as ep_id, EP.descrip as ep_descrip, reest.observ as obs_primeraFalla,  (SELECT UG.name
		FROM municipios_asignaciones as MA2
		LEFT JOIN tbl_users as UG ON UG.userId = MA2.usuario
		WHERE mu.id = MA2.id_proyecto
		AND MA2.prioridad = 1
		) AS 'gestor_name'");
		$this->db->from('reparacion_main as rm');
		$this->db->join('reparacion_estados as re', 'rm.id = re.orden','inner');
		$this->db->join('fallas_main as fm', 'fm.id = rm.falla','left');
		$this->db->join('fallas_motivos as mo', 'mo.id = fm.motivo','left');
		$this->db->join('municipios as mu', 'mu.id = rm.idproyecto','left');
		$this->db->join('tbl_users as u', 'u.userId = re.usuario','left');
		$this->db->join('tbl_roles as r', 'r.roleId = u.roleId','left');
		$this->db->join('tbl_puestos as p', 'p.id = u.puesto','left');
		$this->db->join('equipos_main as em', 'em.serie = rm.serie','left');
		$this->db->join('equipos_marcas as ema', 'ema.id = em.marca','left');
		$this->db->join('equipos_modelos as emo', 'emo.id = em.idmodelo','left');
		$this->db->join('equipos_propietarios as EP', 'EP.descrip = emo.asociado','left');
		$this->db->join('ordenes_tipo_estados as ote', 'ote.id = rm.ultimo_estado','left');
		$this->db->join('tbl_users as ue', 'ue.userId = mu.gestor','left');
		$this->db->join('reparacion_categorias as rc', 'rc.id = rm.ultimo_categoria','left');
		$this->db->join('estados as es', 'em.estado = es.id','left');
		$this->db->join('diagnosticos_main as dm', 'dm.id = rm.diagnostico','left');
		$this->db->join('ordenes_visitas as ov', 'ov.id_orden = rm.id AND ov.id = (SELECT MAX(id) FROM ordenes_visitas )','left');
		$this->db->join('reparacion_estados as reest', 'rm.id = reest.orden','left');

		if (in_array($role,array(101,102,103,104,105))) {
			$this->db->join('municipios_asignaciones as MA', 'MA.id_proyecto = mu.id','left');
		}

		if(!empty($search)) {
			$busqueda = "(
							fm.descrip LIKE '%".$search."%'
							OR rm.serie LIKE '%".$search."%'
							OR mu.descrip LIKE '%".$search."%'
							OR mo.descrip LIKE '%".$search."%'
							OR rc.descrip LIKE '%".$search."%'
						)";
			$this->db->where($busqueda);
		}

		if (!is_null($estado)) {
			if (is_array($estado)) {
				$this->db->where_in('rm.ultimo_estado', $estado);
				$this->db->where_in('re.tipo', $estado);
			} else {
				$this->db->where('rm.ultimo_estado', $estado);
				$this->db->where('re.tipo', $estado);
			}
		}
		if (!is_null($tipo)) {
			switch ($tipo) {
				case 'R':
					$categoria = 1;
					break;
				case 'M':
					$categoria = 2;
					break;
				case 'I':
					$categoria = 3;
					break;
			}
			$this->db->where("(rm.tipo = '{$tipo}' OR rm.ultimo_categoria = {$categoria})");
		}
		$this->db->where('em.eliminado', 0);

		if (in_array($role,array(101,102,103,104,105))) {
			$this->db->where('MA.usuario',$userId);
		}

		$this->db->group_by('re.orden');
		if (is_null($orden)) {
			$this->db->order_by('re_fecha','DESC');
		} else {
			$this->db->order_by('re_fecha',$orden);
		}

		if ($page != NULL) {
			$this->db->limit($page, $segment);
		}

		$query = $this->db->get();
		return $query->result();
	}


	function getOrden($id = NULL, $estado_orden = NULL, $estado_estado = NULL)
	{
		if (!is_null($id)) {
			$this->db->select('rm.ord_lat as lat, rm.ord_long as ordlong, rm.id as rm_id, rm.tipo as rm_tipo, rm.ultimo_estado as rm_ultimo_estado, rm.falla as rm_falla, rm.idproyecto as rm_idproyecto, rm.fecha_visita as rm_fecha_visita, rm.supervisor as rm_supervisor, rm.idflota as rm_idflota, rm.conductor as rm_conductor, rm.tecnico as rm_tecnico, rm.serie as rm_serie, rm.enviado as rm_enviado, rm.enviado_fecha as rm_enviado_fecha, rm.ack as rm_ack, rm.nro_msj as rm_nro_msj, rm.recibido as rm_recibido, rm.recibido_fecha as rm_recibido_fecha, rm.fecha_baja as rm_fecha_baja, rm.ord_procesado as rm_ord_procesado, rm.procesado_fecha as rm_procesado_fecha, rm.ultimo_categoria as rm_ultimo_categoria, rm.equipo_operativo as rm_equipo_operativo, re.id as re_id, re.usuario as re_usuario, re.fecha as re_fecha, re.tipo as re_tipo, re.observ as re_observ, fm.id as fm_id, fm.descrip as fm_descrip, fm.motivo as fm_motivo, mo.id as mo_id, mo.descrip as mo_descrip, mu.id as mu_id, mu.descrip as mu_descrip, u.userId as u_id, u.email as u_email, u.name as u_name, u.nombre as u_nombre, u.apellido as u_apellido, u.mobile as u_mobile, u.modelomov as u_modelomov, u.imei as u_imei, u.roleId as u_roleId, u.puesto as u_puesto, u.asociado as u_asociado, u.tipo as u_tipo, u.isDeleted as u_isDeleted, u.createdBy as u_createdBy, u.createdDtm as u_createdDtm, u.updatedBy as u_updatedBy, u.updatedDtm as u_updatedDtm, r.roleId as r_roleId, r.role as r_role, p.id as p_id, p.descrip as p_descrip, p.jerarquia as p_jerarquia, em.id as em_id, em.serie as em_serie, em.municipio as em_municipio, em.ubicacion_calle as em_ubicacion_calle, em.ubicacion_altura as em_ubicacion_altura, em.ubicacion_mano as em_ubicacion_mano, em.ubicacion_sentido as em_ubicacion_sentido, em.ubicacion_localidad as em_ubicacion_localidad, em.ubicacion_cp as em_ubicacion_cp, em.geo_lat as em_geo_lat, em.geo_lon as em_geo_lon, em.tipo as em_tipo, em.tipo_equipo as em_tipo_equipo, em.multicarril as em_multicarril, em.marca as em_marca, em.idmodelo as em_idmodelo, em.modelo as em_modelo, em.serie_int as em_serie_int, em.vehiculoasig as em_vehiculoasig, em.decriptador as em_decriptador, em.mapa_x as em_mapa_x, em.mapa_y as em_mapa_y, em.estado_mapa as em_estado_mapa, em.falta as em_falta, em.ts as em_ts, em.ubicacion_velper as em_ubicacion_velper, em.observ as em_observ, em.series_asociados as em_series_asociados, em.doc_certif as em_doc_certif, em.doc_fechacal as em_doc_fechacal, em.doc_fechavto as em_doc_fechavto, em.doc_tipocal as em_doc_tipocal, em.doc_aprob as em_doc_aprob, em.doc_normasic as em_doc_normasic, em.doc_distancia as em_doc_distancia, em.remito as em_remito, em.pedido as em_pedido, em.ordencompra as em_ordencompra, em.exportable as em_exportable, em.idmunicipio as em_idmunicipio, em.localidad as em_localidad, em.jur_const as em_jur_const, em.jur_aplic as em_jur_aplic, em.aut_const as em_aut_const, em.ejido_urbano as em_ejido_urbano, em.cp as em_cp, em.tipo_medio as em_tipo_medio, em.ftp_host as em_ftp_host, em.ftp_user as em_ftp_user, em.ftp_pass as em_ftp_pass, em.alerta_bajadas as em_alerta_bajadas, em.bajada_automatica as em_bajada_automatica, em.region as em_region, em.baja as em_baja, em.fecha_baja as em_fecha_baja, em.creadopor as em_creadopor, em.fecha_alta as em_fecha_alta, em.estado as em_estado, em.evento_actual as em_evento_actual, em.instalado as em_instalado, em.requiere_calib as em_requiere_calib, em.calibrado as em_calibrado, em.fecha_ultmod as em_fecha_ultmod, em.activo as em_activo, em.eliminado as em_eliminado, em.idpropietario as em_idpropietario, em.nro_ot as em_nro_ot, em.prueba as em_prueba, ote.id as ote_id, ote.descrip as ote_descrip, ema.id as ema_id, ema.descrip as ema_descrip, ema.creadopor as ema_creadopor, ema.fecha_alta as ema_fecha_alta, ema.fecha_baja as ema_fecha_baja, ema.activo as ema_activo, ema.eliminado as ema_eliminado, ema.observaciones as ema_observaciones, emo.id as emo_id, emo.descrip as emo_descrip, emo.descrip_alt as emo_descrip_alt, emo.sigla as emo_sigla, emo.asociado as emo_asociado, emo.creadopor as emo_creadopor, emo.fecha_alta as emo_fecha_alta, emo.fecha_baja as emo_fecha_baja, emo.activo as emo_activo, emo.eliminado as emo_eliminado, emo.observaciones as emo_observaciones, ue.userId as ue_userId, ue.email as ue_email, ue.name as ue_name, ue.nombre as ue_nombre, ue.apellido as ue_apellido, fl.id as fl_id, fl.dominio as fl_dominio, fl.movilnro as fl_movilnro, fl.marca as fl_marca, fl.modelo as fl_modelo, fl.motor as fl_motor, fl.chasis as fl_chasis, fl.anio as fl_anio, fl.propietario as fl_propietario, fl.segmento as fl_segmento, fl.nro_poliza as fl_nro_poliza, fl.tipo_poliza as fl_tipo_poliza, fl.fecha_autoparte as fl_fecha_autoparte, fl.venc_cedulaverde as fl_venc_cedulaverde, fl.venc_seguro as fl_venc_seguro, fl.venc_vtv as fl_venc_vtv, fl.venc_matafuego as fl_venc_matafuego, fl.venc_cert_hidro as fl_venc_cert_hidro, fl.venc_ruta as fl_venc_ruta, fl.responsable as fl_responsable, fl.acc_kit as fl_acc_kit, fl.acc_cargador as fl_acc_cargador, fl.acc_conos as fl_acc_conos, fl.acc_chalecos as fl_acc_chalecos, fl.destino as fl_destino, fl.celu_nro as fl_celu_nro, fl.celu_imei as fl_celu_imei, fl.activo as fl_activo, fl.creadopor as fl_creadopor, fl.fecha_alta as fl_fecha_alta, fl.fecha_baja as fl_fecha_baja, co.userId as co_id, co.email as co_email, co.name as co_name, co.nombre as co_nombre, co.apellido as co_apellido, co.mobile as co_mobile, co.modelomov as co_modelomov, co.imei as co_imei, co.roleId as co_roleId, co.puesto as co_puesto, co.asociado as co_asociado, co.tipo as co_tipo, co.isDeleted as co_isDeleted, co.createdBy as co_createdBy, co.createdDtm as co_createdDtm, co.updatedBy as co_updatedBy, co.updatedDtm as co_updatedDtm, te.userId as te_id, te.email as te_email, te.name as te_name, te.nombre as te_nombre, te.apellido as te_apellido, te.mobile as te_mobile, te.modelomov as te_modelomov, te.imei as te_imei, te.roleId as te_roleId, te.puesto as te_puesto, te.asociado as te_asociado, te.tipo as te_tipo, te.isDeleted as te_isDeleted, te.createdBy as te_createdBy, te.createdDtm as te_createdDtm, te.updatedBy as te_updatedBy, te.updatedDtm as te_updatedDtm, rc.id as rc_id, rc.descrip as rc_descrip, rc.color as rc_color, , ov.fecha_visita as ov_fecha_visita, ov.conductor as ov_conductor, ov.tecnico as ov_tecnico, ov.idflota as ov_idflota');
			$this->db->from('reparacion_main as rm');
			$this->db->join('reparacion_estados as re', 'rm.id = re.orden','left');
			$this->db->join('fallas_main as fm', 'fm.id = rm.falla','left');
			$this->db->join('fallas_motivos as mo', 'mo.id = fm.motivo','left');
			$this->db->join('municipios as mu', 'mu.id = rm.idproyecto','left');
			$this->db->join('tbl_users as u', 'u.userId = re.usuario','left');
			$this->db->join('tbl_roles as r', 'r.roleId = u.roleId','left');
			$this->db->join('tbl_puestos as p', 'p.id = u.puesto','left');
			$this->db->join('equipos_main as em', 'em.serie = rm.serie','left');
			$this->db->join('equipos_marcas as ema', 'ema.id = em.marca','left');
			$this->db->join('equipos_modelos as emo', 'emo.id = em.idmodelo','left');
			$this->db->join('ordenes_tipo_estados as ote', 'ote.id = rm.ultimo_estado','left');
			$this->db->join('tbl_users as ue', 'ue.userId = mu.gestor','left');
			$this->db->join('tbl_users as co', 'co.userId = rm.conductor','left');
			$this->db->join('tbl_users as te', 'te.userId = rm.tecnico','left');
			$this->db->join('flota_main as fl', 'fl.id = rm.idflota','left');
			$this->db->join('reparacion_categorias as rc', 'rc.id = rm.ultimo_categoria','left');

			$this->db->join('ordenes_visitas as ov', 'ov.id_orden = rm.id AND ov.id = (SELECT MAX(id) FROM ordenes_visitas )','left');

			$this->db->where('rm.id', $id);
			if (!is_null($estado_estado)) {
					$this->db->where('rm.ultimo_estado', $estado_orden);
					$this->db->where('re.tipo', $estado_estado);
			} elseif (!is_null($estado_orden)) {
				$this->db->where('rm.ultimo_estado', $estado_orden);
				$this->db->where('re.tipo', $estado_orden);
			}
			$this->db->group_by('re.orden');
			$this->db->order_by('re.tipo','desc');
			$query = $this->db->get();

			return $query->row();

		}
		return FALSE;
	}

	function getEstados($id = NULL, $tipo = NULL)
	{
		if (!is_null($id)) {
			$this->db->select('re.id as re_id, re.usuario as re_usuario, re.fecha as re_fecha, re.tipo as re_tipo, re.observ as re_observ, re.asignado_categoria as re_asignado_categoria, ote.id as ote_id, ote.descrip as ote_descrip, u.userId as u_id, u.email as u_email, u.name as u_name, u.nombre as u_nombre, u.apellido as u_apellido, u.mobile as u_mobile, u.modelomov as u_modelomov, u.imei as u_imei, u.roleId as u_roleId, u.puesto as u_puesto, u.asociado as u_asociado, u.tipo as u_tipo, u.isDeleted as u_isDeleted, u.createdBy as u_createdBy, u.createdDtm as u_createdDtm, u.updatedBy as u_updatedBy, u.updatedDtm as u_updatedDtm, r.roleId as r_roleId, r.role as r_role, p.id as p_id, p.descrip as p_descrip, p.jerarquia as p_jerarquia, rc.id as rc_id, rc.descrip as rc_descrip, rc.color as rc_color');
			$this->db->from('reparacion_estados as re');
			$this->db->join('ordenes_tipo_estados as ote', 'ote.id = re.tipo','left');
			$this->db->join('tbl_users as u', 'u.userId = re.usuario','left');
			$this->db->join('tbl_roles as r', 'r.roleId = u.roleId','left');
			$this->db->join('tbl_puestos as p', 'p.id = u.puesto','left');
			$this->db->join('reparacion_categorias as rc', 'rc.id = re.asignado_categoria','left');
			$this->db->where('re.orden', $id);
			$this->db->order_by('re.fecha', 'asc');

			if ($tipo != 1) {
				$query = $this->db->get();
				return $query->result();
			} else {
				$this->db->limit($tipo);
				$query = $this->db->get();
				$row = $query->row('re_asignado_categoria');
				return $row;
			}

		}
		return FALSE;
	}

	function getAsignados($id = NULL)
	{
			$this->db->select('re.id, re.orden, re.asignado_categoria,rm.tipo');
			$this->db->from('reparacion_estados as re');
			$this->db->join('reparacion_main as rm', 'rm.id = re.orden','left');
			$this->db->where('re.orden', $id);
			$this->db->where('re.asignado_categoria', 3);

			$query = $this->db->get();
			return $query->result();
	}

	function getTipoOrden($id = NULL)
	{
			$this->db->select('rm.tipo');
			$this->db->from('reparacion_main as rm');
			$this->db->where('rm.id', $id);

			$query = $this->db->get();
			return $query->row();
	}

	function ordenes_fechas($id_orden = NULL)
	{
			$this->db->select('OV.id, OV.id_orden, OV.tipo, OV.fecha_visita, OV.conductor, OV.tecnico, OV.idflota, OV.observacion, co.name as uv_conductor, te.name as uv_tecnico, fl.dominio as uv_dominio, fl.marca as uv_marca, fl.modelo as uv_modelo, te.roleId as roleTecnico, co.roleId as roleConductor');
			$this->db->from('ordenes_visitas as OV');
			$this->db->join('tbl_users as co', 'co.userId = OV.conductor','left');
			$this->db->join('tbl_users as te', 'te.userId = OV.tecnico','left');
			$this->db->join('flota_main as fl', 'fl.id = OV.idflota','left');
			if ($id_orden != NULL) {
				$this->db->order_by('OV.id', 'desc');
				$this->db->limit(1);
				$this->db->where('OV.id_orden', $id_orden);
				$query = $this->db->get();
				return $query->row();
			} else {
				$this->db->order_by('OV.ts', 'desc');
				$this->db->group_by('OV.id_orden', 'desc');
				$query = $this->db->get();
				return $query->result();
			}

			//SELECT MAX(ov.id), ov.id_orden FROM ordenes_visitas AS ov GROUP BY ov.id_orden

	}


	function getImagenes($serie = NULL, $fecha = NULL)
	{
		if ((!is_null($fecha)) || (!is_null($fecha))) {
			$this->db->where('equipo', $serie);
			$this->db->where('fecha_archivo', $fecha);

			$query = $this->db->get('img_reportes');

			return $query->result();
		}
		return FALSE;
	}

	function insertarEstado($data)
	{
		$this->db->insert('reparacion_estados', $data);
		return TRUE;
	}

	function updateOrden($id,$data)
	{
		if ($id && $data) {
			$this->db->where('id', $id);
			$this->db->update('reparacion_main', $data);
			return TRUE;
		}
		return FALSE;
	}

	function altaSolicitud($id,$data,$sector,$categoria,$operativo)
	{
		$this->db->trans_begin();

		$update = array (
				'ultimo_estado' => 2,
				'tipo' => $sector,
        'ultimo_categoria' => $categoria,
        'equipo_operativo' => $operativo?1:0
		);
		$this->updateOrden($id,$update);
		$this->insertarEstado($data);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function altaOrden($id,$data_estado)
	{
		$this->db->trans_begin();

		$data_orden = array(
				'ultimo_estado' => 3
		);

		$this->updateOrden($id,$data_orden);
		$this->insertarEstado($data_estado);

		// Obtengo la orden, porque necesito los datos más abajo.
		$orden1 = $this->getOrden($id,3,2);//para saber el mail del gestor solicitante
		$mail_a_enviar = $orden1->ue_email;
		$nom_mail = $orden1->ue_name;

		if (!$orden1) {
			$orden1 = $this->getOrden($id,3,3);//para saber el mail de reparaciones en caso que gestor sea NULL
			$mail_a_enviar = $orden1->u_email;
			$nom_mail = $orden1->u_name;
		}

		$orden = $this->getOrden($id);
		switch ($orden->rm_tipo) {
			case 'R':
				$this->load->model('historial_model');
				$this->load->model('equipos_model');
				$edit_equipo = array(
					'evento_actual' => 20,
				    'operativo' => $orden->rm_equipo_operativo
				);
				$this->equipos_model->editEquipo($edit_equipo,$orden->em_id);

				$registro = array(
					'idequipo' => $orden->em_id,
					'idevento' => 20,
					'tipo' => 'ALTA',
					'creadopor' => $this->session->userdata('userId'),
					'fecha' => date('Y-m-d H:i:s'),
					'detalle' => 'El evento anterior era: <strong>'.$this->equipos_model->getEvento($orden->em_evento_actual).'</strong>, se cambió por <strong>'.$this->equipos_model->getEvento(20).'</strong>. Orden <a href="'.base_url("ver-orden/{$id}?ref=reparaciones/ordenes").'">'.$id.'</a> CREADA',
					'origen' => 'REPARACIÓN'
				);

				$this->historial_model->addHistorial($registro);
				break;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			if($orden->rm_tipo === 'R') {
				$this->load->model('mail_model');
				$this->mail_model->enviarMail(3, $orden->rm_serie, $orden->rm_id, $data_estado['observ'], date('d/m/Y',strtotime($orden->re_fecha)),NULL,NULL,$mail_a_enviar,$nom_mail);
			}
			return TRUE;
		}
	}

	function rechazarSolicitud($id,$data,$orden=NULL)
	{
		$this->db->trans_begin();

		$update = array (
				'ultimo_estado' => 8
		);


		$this->updateOrden($id,$update);
		$this->insertarEstado($data);

        // Obtengo la orden, porque necesito los datos más abajo.
        $orden = $this->getOrden($id,8,2);//para saber el mail del gestor solicitante
		$mail_a_enviar = $orden->ue_email;
		$nom_mail = $orden->ue_name;

		//die(var_dump($orden->rm_ultimo_categoria));
		switch ($orden->rm_ultimo_categoria) {
			case 1:
				$tipo = "REPARACIÓN";
				break;
			case 2:
			$tipo = "MANTENIMIENTO";
				break;
		}

		$this->load->model('historial_model');
		$registro = array(
					'idequipo' => $orden->em_id,
					'idevento' => 0,
					'tipo' => 'RECHAZADA',
					'creadopor' => $this->session->userdata('userId'),
					'fecha' => date('Y-m-d H:i:s'),
					'detalle' => ' Orden <a href="'.base_url("ver-orden/{$id}?ref=reparaciones/ordenes").'">'.$id.'</a> RECHAZADA',
					'Observaciones' => $data['observ'],
					'origen' => $tipo
				);
		$this->historial_model->addHistorial($registro);


        if (!$orden) {
            $orden = $this->getOrden($id,8,3);//para saber el mail de reparaciones
			$mail_a_enviar = $orden->u_email;
			$nom_mail = $orden->u_name;
        }

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			if($data['asignado_categoria'] == 1){ //CORROBORA SI ES DE REPARACIONES
			$this->load->model('mail_model');
			$this->mail_model->enviarMail(4, $orden->rm_serie, $orden->rm_id, $data['observ'], date('d/m/Y',strtotime($orden->re_fecha)),NULL,NULL,$mail_a_enviar,$nom_mail);
			}
			$this->db->trans_commit();
		}
		return TRUE;

	}

	function visitaProgramada($idorden,$data_estado,$origen = NULL)
	{
		$this->db->trans_begin();

		$orden_original = $this->getOrden($idorden,3);

		$update = array (
				'ultimo_estado' => 11,
		);

		$this->updateOrden($idorden,$update);

		$this->insertarEstado($data_estado);

		$orden = $this->getOrden($idorden);

		/*$tecnico = $this->user_model->getUserInfo($orden->rm_tecnico);

		$data_estado['observ'] = str_replace(',','',$orden_original->fm_descrip).': '.$orden_original->re_observ.'. '.str_replace(',','',$data_estado['observ']);
		$data_mensaje = array(
				'imei' => $tecnico[0]->imei,
				'codigo' => $orden->rm_nro_msj,
				'equipo' => $orden->rm_serie,
				'datos' => implode(',', array($orden->rm_id,$orden->rm_fecha_visita,str_replace(',','',$data_estado['observ']))),
				'fecha_recepcion' => date('Y-m-d H:i:s'),
				'origen' => 1
		);*/

		//$tecnico = $this->user_model->getUserInfo($orden->ov_tecnico);

		$info_OV = 	$this->ordenes_fechas($idorden); //Informacion de las Ordenes de visitas.

		$tecnico = $this->user_model->getUserInfo($info_OV->tecnico);

		$data_estado['observ'] = str_replace(',','',$orden_original->fm_descrip).': '.$orden_original->re_observ.'. '.str_replace(',','',$data_estado['observ']);
		$data_mensaje = array(
				'imei' => $tecnico[0]->imei,
				'codigo' => $orden->rm_nro_msj,
				'equipo' => $orden->rm_serie,
				'datos' =>
				implode(',', array($orden->rm_id,$orden->ov_fecha_visita,str_replace(',','',$data_estado['observ']),$origen
									)
								),
				'fecha_recepcion' => date('Y-m-d H:i:s'),
				'origen' => 1
		);

		switch ($orden->rm_tipo) {
			case 'R':
				$data_mensaje['tipo'] = '2007';
				break;
			case 'M':
				$data_mensaje['tipo'] = '2008';
				break;
			case 'I':
				$data_mensaje['tipo'] = '2009';
				break;
		}

		$this->load->model('mensajes_model');
		$this->mensajes_model->addNewMensaje($data_mensaje);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function finalizarOrden($id,$data_estado,$ultimo_estado,$estado,$diagnostico)
	{
		$this->load->model('eventos_model');
		$this->db->trans_begin();

		$update = array (
				'ultimo_estado' => 7,
				'diagnostico' => $diagnostico,
				'fecha_finalizada' => date('Y-m-d H:i:s')
		);
		// Actualizo el último estado de la orden a finalizada
		$this->updateOrden($id,$update);
		// Agrego estado nuevo de la orden de finalizada
		$this->insertarEstado($data_estado);

		$orden = $this->getOrden($id); //Obtengo la orden

		switch ($orden->rm_tipo) {
			//REPARACIONES
			case 'R':
				$this->load->model('historial_model');
				$this->load->model('equipos_model');

				$edit_equipo = array(
					'evento_actual' => 130,
					'operativo' => 1
				);
				$this->equipos_model->editEquipo($edit_equipo,$orden->em_id);

				$registro = array(
					'idequipo' => $orden->em_id,
					'idevento' => 60,
					'tipo' => 'CERRADA',
					'creadopor' => $this->session->userdata('userId'),
					'fecha' => date('Y-m-d H:i:s'),
					'detalle' => 'El evento anterior era: <strong>'.$this->equipos_model->getEvento($orden->em_evento_actual).'</strong>, se cambió por <strong>'.$this->equipos_model->getEvento(130).'</strong>. Orden <a href="'.base_url("ver-orden/{$id}?ref=reparaciones/ordenes").'">'.$id.'</a> FINALIZADA',
					'origen' => 'REPARACIÓN'
				);
				if ($estado != $orden->em_estado) {
					$registro['detalle'] .= '<br>El lugar anterior era: <strong>'.$this->equipos_model->getEstado($orden->em_estado).'</strong>, se cambió por <strong>'.$this->equipos_model->getEstado($estado).'</strong>.';
					$edit_equipo = array(
						'estado' => $estado
					);
					$this->equipos_model->editEquipo($edit_equipo,$orden->em_id);
				}
				$this->historial_model->addHistorial($registro);
				break;
		}

		// Borrar la orden en el celular / APP
		$info_OV = 	$this->ordenes_fechas($id); //Informacion de las Ordenes de visitas.
		$tecnico = $this->user_model->getUserInfo($info_OV->tecnico);

		$imei        = $tecnico[0]->imei;
		$tipo_msj    = "3010";
		$nro_msj     = date('Ymd His');
		$equipoSerie = "Borrar Registro";
		$datos       = $orden->rm_nro_msj;
		$fecha_alta  = date('Y-m-d H:i:s');
		$origen      = 1;

		$mensajesInfo = array('imei'=>$imei,'tipo'=>$tipo_msj,'codigo'=>$nro_msj,'equipo'=>$equipoSerie,'datos'=>$datos,'fecha_recepcion'=>$fecha_alta, 'origen'=>$origen, 'ordenesb_ID'=>$ordenesbId);
		$this->load->model('mensajes_model');
		$this->mensajes_model->addNewMensaje($mensajesInfo);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function desestimarReporte($id,$data_estado)
	{
		$this->db->trans_begin();

		$update = array (
			'ultimo_estado' => 12,
		);
		$this->updateOrden($id,$update);

		$this->insertarEstado($data_estado);
		$orden = $this->getOrden($id);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			$this->load->model('historial_model');

			$registro = array(
						'idequipo' => $orden->em_id,
						'idevento' => 0,
						'tipo' => 'RECHAZADA',
						'creadopor' => $this->session->userdata('userId'),
						'fecha' => date('Y-m-d H:i:s'),
						'detalle' => 'Orden <a href="'.base_url("ver-desestimado/{$id}?ref=reparaciones/ordenes").'">'.$id.'</a> RECHAZADA',
							'observaciones' => $data_estado['observ'],
						'origen' => 'DESESTIMADOS'
					);

			$this->historial_model->addHistorial($registro);
			return TRUE;
		}
	}

	function getDesestimada($id = NULL, $searchText = '')
	{
		if (!is_null($id)) {
			$this->db->select('rm.id as rm_id, rm.tipo as rm_tipo, rm.ultimo_estado as rm_ultimo_estado, rm.falla as rm_falla, rm.idproyecto as rm_idproyecto, rm.fecha_visita as rm_fecha_visita, rm.supervisor as rm_supervisor, rm.idflota as rm_idflota, rm.conductor as rm_conductor, rm.tecnico as rm_tecnico, rm.serie as rm_serie, rm.enviado as rm_enviado, rm.enviado_fecha as rm_enviado_fecha, rm.ack as rm_ack, rm.nro_msj as rm_nro_msj, rm.recibido as rm_recibido, rm.recibido_fecha as rm_recibido_fecha, rm.fecha_baja as rm_fecha_baja, rm.ord_procesado as rm_ord_procesado, rm.procesado_fecha as rm_procesado_fecha, re.id as re_id, re.usuario as re_usuario, re.fecha as re_fecha, re.tipo as re_tipo, re.observ as re_observ, fm.id as fm_id, fm.descrip as fm_descrip, fm.motivo as fm_motivo, mo.id as mo_id, mo.descrip as mo_descrip, mu.id as mu_id, mu.descrip as mu_descrip, u.userId as u_id, u.email as u_email, u.name as u_name, u.nombre as u_nombre, u.apellido as u_apellido, u.mobile as u_mobile, u.modelomov as u_modelomov, u.imei as u_imei, u.roleId as u_roleId, u.puesto as u_puesto, u.asociado as u_asociado, u.tipo as u_tipo, u.isDeleted as u_isDeleted, u.createdBy as u_createdBy, u.createdDtm as u_createdDtm, u.updatedBy as u_updatedBy, u.updatedDtm as u_updatedDtm, r.roleId as r_roleId, r.role as r_role, p.id as p_id, p.descrip as p_descrip, p.jerarquia as p_jerarquia, em.id as em_id, em.serie as em_serie, em.municipio as em_municipio, em.ubicacion_calle as em_ubicacion_calle, em.ubicacion_altura as em_ubicacion_altura, em.ubicacion_mano as em_ubicacion_mano, em.ubicacion_sentido as em_ubicacion_sentido, em.ubicacion_localidad as em_ubicacion_localidad, em.ubicacion_cp as em_ubicacion_cp, em.geo_lat as em_geo_lat, em.geo_lon as em_geo_lon, em.tipo as em_tipo, em.tipo_equipo as em_tipo_equipo, em.multicarril as em_multicarril, em.marca as em_marca, em.idmodelo as em_idmodelo, em.modelo as em_modelo, em.serie_int as em_serie_int, em.vehiculoasig as em_vehiculoasig, em.decriptador as em_decriptador, em.mapa_x as em_mapa_x, em.mapa_y as em_mapa_y, em.estado_mapa as em_estado_mapa, em.falta as em_falta, em.ts as em_ts, em.ubicacion_velper as em_ubicacion_velper, em.observ as em_observ, em.series_asociados as em_series_asociados, em.doc_certif as em_doc_certif, em.doc_fechacal as em_doc_fechacal, em.doc_fechavto as em_doc_fechavto, em.doc_tipocal as em_doc_tipocal, em.doc_aprob as em_doc_aprob, em.doc_normasic as em_doc_normasic, em.doc_distancia as em_doc_distancia, em.remito as em_remito, em.pedido as em_pedido, em.ordencompra as em_ordencompra, em.exportable as em_exportable, em.idmunicipio as em_idmunicipio, em.localidad as em_localidad, em.jur_const as em_jur_const, em.jur_aplic as em_jur_aplic, em.aut_const as em_aut_const, em.ejido_urbano as em_ejido_urbano, em.cp as em_cp, em.tipo_medio as em_tipo_medio, em.ftp_host as em_ftp_host, em.ftp_user as em_ftp_user, em.ftp_pass as em_ftp_pass, em.alerta_bajadas as em_alerta_bajadas, em.bajada_automatica as em_bajada_automatica, em.region as em_region, em.baja as em_baja, em.fecha_baja as em_fecha_baja, em.creadopor as em_creadopor, em.fecha_alta as em_fecha_alta, em.estado as em_estado, em.evento_actual as em_evento_actual, em.instalado as em_instalado, em.requiere_calib as em_requiere_calib, em.calibrado as em_calibrado, em.fecha_ultmod as em_fecha_ultmod, em.activo as em_activo, em.eliminado as em_eliminado, em.idpropietario as em_idpropietario, em.nro_ot as em_nro_ot, em.prueba as em_prueba, ote.id as ote_id, ote.descrip as ote_descrip, ema.id as ema_id, ema.descrip as ema_descrip, ema.creadopor as ema_creadopor, ema.fecha_alta as ema_fecha_alta, ema.fecha_baja as ema_fecha_baja, ema.activo as ema_activo, ema.eliminado as ema_eliminado, ema.observaciones as ema_observaciones, emo.id as emo_id, emo.descrip as emo_descrip, emo.descrip_alt as emo_descrip_alt, emo.sigla as emo_sigla, emo.asociado as emo_asociado, emo.creadopor as emo_creadopor, emo.fecha_alta as emo_fecha_alta, emo.fecha_baja as emo_fecha_baja, emo.activo as emo_activo, emo.eliminado as emo_eliminado, emo.observaciones as emo_observaciones, ue.userId as ue_userId, ue.email as ue_email, ue.name as ue_name, ue.nombre as ue_nombre, ue.apellido as ue_apellido, fl.id as fl_id, fl.dominio as fl_dominio, fl.movilnro as fl_movilnro, fl.marca as fl_marca, fl.modelo as fl_modelo, fl.motor as fl_motor, fl.chasis as fl_chasis, fl.anio as fl_anio, fl.propietario as fl_propietario, fl.segmento as fl_segmento, fl.nro_poliza as fl_nro_poliza, fl.tipo_poliza as fl_tipo_poliza, fl.fecha_autoparte as fl_fecha_autoparte, fl.venc_cedulaverde as fl_venc_cedulaverde, fl.venc_seguro as fl_venc_seguro, fl.venc_vtv as fl_venc_vtv, fl.venc_matafuego as fl_venc_matafuego, fl.venc_cert_hidro as fl_venc_cert_hidro, fl.venc_ruta as fl_venc_ruta, fl.responsable as fl_responsable, fl.acc_kit as fl_acc_kit, fl.acc_cargador as fl_acc_cargador, fl.acc_conos as fl_acc_conos, fl.acc_chalecos as fl_acc_chalecos, fl.destino as fl_destino, fl.celu_nro as fl_celu_nro, fl.celu_imei as fl_celu_imei, fl.activo as fl_activo, fl.creadopor as fl_creadopor, fl.fecha_alta as fl_fecha_alta, fl.fecha_baja as fl_fecha_baja, co.userId as co_id, co.email as co_email, co.name as co_name, co.nombre as co_nombre, co.apellido as co_apellido, co.mobile as co_mobile, co.modelomov as co_modelomov, co.imei as co_imei, co.roleId as co_roleId, co.puesto as co_puesto, co.asociado as co_asociado, co.tipo as co_tipo, co.isDeleted as co_isDeleted, co.createdBy as co_createdBy, co.createdDtm as co_createdDtm, co.updatedBy as co_updatedBy, co.updatedDtm as co_updatedDtm, te.userId as te_id, te.email as te_email, te.name as te_name, te.nombre as te_nombre, te.apellido as te_apellido, te.mobile as te_mobile, te.modelomov as te_modelomov, te.imei as te_imei, te.roleId as te_roleId, te.puesto as te_puesto, te.asociado as te_asociado, te.tipo as te_tipo, te.isDeleted as te_isDeleted, te.createdBy as te_createdBy, te.createdDtm as te_createdDtm, te.updatedBy as te_updatedBy, te.updatedDtm as te_updatedDtm');
			$this->db->from('reparacion_main as rm');
			$this->db->join('reparacion_estados as re', 'rm.id = re.orden','left');
			$this->db->join('fallas_main as fm', 'fm.id = rm.falla','left');
			$this->db->join('fallas_motivos as mo', 'mo.id = fm.motivo','left');
			$this->db->join('municipios as mu', 'mu.id = rm.idproyecto','left');
			$this->db->join('tbl_users as u', 'u.userId = re.usuario','left');
			$this->db->join('tbl_roles as r', 'r.roleId = u.roleId','left');
			$this->db->join('tbl_puestos as p', 'p.id = u.puesto','left');
			$this->db->join('equipos_main as em', 'em.serie = rm.serie','left');
			$this->db->join('equipos_marcas as ema', 'ema.id = em.marca','left');
			$this->db->join('equipos_modelos as emo', 'emo.id = em.idmodelo','left');
			$this->db->join('ordenes_tipo_estados as ote', 'ote.id = rm.ultimo_estado','left');
			$this->db->join('tbl_users as ue', 'ue.userId = mu.gestor','left');
			$this->db->join('tbl_users as co', 'co.userId = rm.conductor','left');
			$this->db->join('tbl_users as te', 'te.userId = rm.tecnico','left');
			$this->db->join('flota_main as fl', 'fl.id = rm.idflota','left');
			$this->db->where('rm.id', $id);
			$this->db->where('re.tipo', 1);

			$this->db->group_by('re.orden');
			$this->db->order_by('re.tipo','desc');
			$query = $this->db->get();

			return $query->row();

			if(!empty($searchText)) {
				$this->db->like('rm_serie', $searchText);
			}
		}
		return FALSE;
	}

	function altaNuevaSolicitud($data_orden,$data_estado)
	{
		$this->db->trans_begin();

		$this->db->insert('reparacion_main', $data_orden);

		$insert_id = $this->db->insert_id();

		$data_estado['orden'] = $insert_id;

		$this->insertarEstado($data_estado);

		$orden = $this->getOrden($insert_id);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();

			return $insert_id;
		}
	}

	function altaNuevaOrden($data_orden,$data_estado)
	{
		$this->db->trans_begin();

		$this->db->insert('reparacion_main', $data_orden);

		$insert_id = $this->db->insert_id();

		$data_estado['orden'] = $insert_id;

		$this->insertarEstado($data_estado);

		$orden = $this->getOrden($insert_id);


		switch ($orden->rm_tipo) {
			case 'R':
				$this->load->model('historial_model');
				$this->load->model('equipos_model');

				$edit_equipo = array(
					'evento_actual' => 20,
				    'operativo' => $orden->rm_equipo_operativo
				);
				$this->equipos_model->editEquipo($edit_equipo,$orden->em_id);

				$registro = array(
					'idequipo' => $orden->em_id,
					'idevento' => 20,
					'tipo' => 'ALTA',
					'creadopor' => $this->session->userdata('userId'),
					'fecha' => date('Y-m-d H:i:s'),
					'detalle' => 'El evento anterior era: <strong>'.$this->equipos_model->getEvento($orden->em_evento_actual).'</strong>, se cambió por <strong>'.$this->equipos_model->getEvento(20).'</strong>. Orden <a href="'.base_url("ver-orden/{$insert_id}?ref=reparaciones/ordenes").'">'.$insert_id.'</a> CREADA',
					'origen' => 'REPARACIÓN'
						);

				$this->historial_model->addHistorial($registro);
				break;

				case 'M':
					$this->load->model('historial_model');

					$registro = array(
						'idequipo' => $orden->em_id,
						'idevento' => 0,
						'tipo' => 'ALTA',
						'creadopor' => $this->session->userdata('userId'),
						'fecha' => date('Y-m-d H:i:s'),
						'detalle' => ' Orden <a href="'.base_url("ver-orden/{$insert_id}?ref=mantenimiento/ordenes").'">'.$insert_id.'</a> CREADA',
						'observaciones' => $data_estado['observ'],
						'origen' => 'MANTENIMIENTO'
							);

					$this->historial_model->addHistorial($registro);
					break;
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return $insert_id;
		}
	}

	function getOrdenesAbiertas($sector = FALSE)
	{
		$estados = array(1,7,8,12);

		$this->db->select('serie');
		// Si viene sin $sector, es porque es para los reportes de novedades
		if ($sector !== FALSE) {
			// Si viene con $sector, es porque es para la vista de solicitudes, y debo excluirlas
			$estados[] = 2;
			$this->db->where('tipo',$sector);
		}
		// Excluyo de la condición a los estados que representan reportes, reportes desestimados, solicitudes rechazadas y órdenes finalizadas.
		$this->db->where_not_in('ultimo_estado', $estados);
		$this->db->group_by("serie");

		$query = $this->db->get('reparacion_main');

		return array_column($query->result_array(),'serie');
	}

	function getIdsOrdenesAbiertas($serie, $sector = NULL)
	{
		$estados = array(1,7,8,12);

		$this->db->select('id, tipo, ultimo_estado');
		$this->db->where_not_in('ultimo_estado', $estados);
		$this->db->where('serie', $serie);
		if (!is_null($sector)) {
			$this->db->where('tipo', $sector);
		}

		$query = $this->db->get('reparacion_main');

		return $query->result();
	}

	function getEstado($id,$estado)
	{
		$where = array(
			'orden' => $id,
			'tipo' => $estado
		);


		$query = $this->db->get_where('reparacion_estados',$where);

		return $query->result();
	}

	function getCategorias()
	{
		$query = $this->db->get_where('reparacion_categorias', array('activo' => 1));

		return $query->result();
	}

	function reasignarOrden($id,$data_estado,$estado_equipo,$ultimoEstado = NULL)
	{
		$this->load->model('historial_model');
		$this->load->model('equipos_model');

		$this->db->trans_begin();
		if ($ultimoEstado == NULL) {
			$update = array ('ultimo_categoria' => $data_estado['asignado_categoria'], 'ultimo_estado' => 3);
		} else {
			$update = array ('ultimo_categoria' => $data_estado['asignado_categoria'], 'ultimo_estado' => $ultimoEstado);
		}

		// Actualizo la última categoría de la orden reasignada
		$this->updateOrden($id,$update);
		// Agrego estado nuevo de la orden de reasignar
		$this->insertarEstado($data_estado);

		/*
		// Obtengo la orden, porque necesito los datos más abajo.
		$orden1 = $this->getOrden($id,3,2);//para saber el mail del gestor solicitante
		$mail_a_enviar = $orden1->ue_email;
		$nom_mail = $orden1->ue_name;

		if (!$orden1) {
			$orden1 = $this->getOrden($id,3,3);//para saber el mail de reparaciones
			$mail_a_enviar = $orden1->u_email;
			$nom_mail = $orden1->u_name;
		}
		*/

		$orden = $this->getOrden($id);
		// Obtengo la orden, porque necesito los datos más abajo.

		if ($orden->em_estado != $estado_equipo) {
			$update_equipo = array('estado' => $estado_equipo);

			if ($estado_equipo <> 2) {
				$operativo = '0';
				array_push($update_equipo['operativo']  = $operativo);
			} else {
				$operativo = '1';
				array_push($update_equipo['operativo']  = $operativo);
			}
			$operativo = ($operativo == '1') ? "SI" : "NO";
			$op_equipo = ($this->equipos_model->getOperativo($orden->em_id) == '1') ? 'SI' : 'NO';
			$datalle = 'La condicion de Bajada era <strong>'.$op_equipo.' </strong>, se cambió por <strong>'.$operativo.'</strong>.';

			$this->equipos_model->editEquipo($update_equipo,$orden->em_id);

			$registroOperativo = array(
				'idequipo' => $orden->em_id,
				'idestado' => 0,
				'origen' => 'EQUIPOS',
				'tipo' => 'MODIFICACIÓN',
				'creadopor' => $this->session->userdata('userId'),
				'fecha' => date('Y-m-d H:i:s'),
				'detalle' => $datalle
			);

			$this->historial_model->addHistorial($registroOperativo);

			$registro = array(
				'idequipo' => $orden->em_id,
				'idestado' => $estado_equipo,
				'tipo' => 'MODIFICACIÓN',
				'creadopor' => $this->session->userdata('userId'),
				'fecha' => date('Y-m-d H:i:s'),
				'detalle' => 'El lugar anterior era: <strong>'.$this->equipos_model->getEstado($orden->em_estado).'</strong>, se cambió por <strong>'.$this->equipos_model->getEstado($estado_equipo).'</strong>.'
			);
			switch ($orden->rm_tipo) {
				case 'R':
					$registro['origen'] = 'REPARACIÓN';
					break;
				case 'M':
					$registro['origen'] = 'MANTENIMIENTO';
					break;
				case 'I':
					$registro['origen'] = 'INSTALACIONES';
					break;
			}

			$this->historial_model->addHistorial($registro);
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	function tiempoTotal($idorden)
	{
		$this->db->select("TIMESTAMPDIFF(DAY,MIN(fecha),NOW()) as dias");
		$where = array("orden" => $idorden);
		$query = $this->db->get_where('reparacion_estados',$where);

		$row = $query->row();
		return $row->dias;
	}

	function tiempoCatTotal($idorden,$idcategoria)
	{
		$consulta = "SELECT IFNULL(SUM(TIMESTAMPDIFF(DAY, fecha , IFNULL((SELECT MIN(fecha) FROM reparacion_estados WHERE fecha > re.fecha AND orden = {$idorden}),NOW()))),'0') as dias FROM reparacion_estados as re WHERE orden = {$idorden} AND asignado_categoria = {$idcategoria}";

		$query = $this->db->query($consulta);

		$row = $query->row();
		return $row->dias;
	}

	function tiempoEveTotal($idorden)
	{
		$this->db->select("TIMESTAMPDIFF(DAY,MAX(fecha),NOW()) as dias");
		$where = array("orden" => $idorden);
		$query = $this->db->get_where('reparacion_estados',$where);

		$row = $query->row();
		return $row->dias;
	}

	function getUltimoEvento($idorden)
	{
		$where = array("orden" => $idorden);
		$this->db->order_by('fecha','DESC');
		$query = $this->db->get_where('reparacion_estados',$where, 1);

		$row = $query->row();
		return $row;
	}

	function getPrimerEvento($idorden)
	{
		$where = array("orden" => $idorden);
		$this->db->order_by('fecha','ASC');
		$query = $this->db->get_where('reparacion_estados',$where, 1);

		$row = $query->row();

		return $row;
	}

	function tiempoFinalizada($idorden)
	{
		$primero   = $this->getPrimerEvento($idorden);
		$ultimo    = $this->getUltimoEvento($idorden);
		$primero   = new DateTime($primero->fecha);
		$ultimo    = new DateTime($ultimo->fecha);
		$intervalo = $primero->diff($ultimo);
		return $intervalo->format('%a');
	}

	function getCategoriasOrden($idorden)
	{
		$this->db->join('reparacion_categorias as rc', 'rc.id = re.asignado_categoria','left');
		$this->db->group_by("asignado_categoria");
		$query = $this->db->get_where('reparacion_estados as re',array('orden' => $idorden));

		$result = $query->result();

		$out = array(
			'datasets' => array(array(
				'data' => array(),
				'backgroundColor' => array()
			)),
			'labels' => array()
		);

		foreach ($result as $row) {
			$out['datasets'][0]['data'][] = $this->tiempoCatTotal($idorden,$row->asignado_categoria);
			$out['datasets'][0]['backgroundColor'][] = "#{$row->color}";
			$out['labels'][] = $row->descrip;
		}

		return $out;
	}

//OBTENER PROMEDIO//
    function porcentaje($cantidad,$total,$decimales)
    {
        return number_format(($cantidad/$total)*100,$decimales);
    }

    function cantidad($porcentaje,$total,$decimales)
    {
        return number_format(($porcentaje*$total)/100,$decimales);
    }

// Ordenes de visitas agregarVisitas
		function addVisita($visitaInfo)
		{
				$this->db->trans_start();
				$this->db->insert('ordenes_visitas', $visitaInfo);

				$insert_id = $this->db->insert_id();
				$this->db->trans_complete();
				return $insert_id;
		}

		function updateVisita($id_visita, $visitaInfo)
    {
        $this->db->where('id', $id_visita);
        $this->db->update('ordenes_visitas', $visitaInfo);

        return TRUE;
    }

		function getVisitas($idorden)
		{
				$this->db->select("OV.fecha_visita, OV.observacion, F.dominio, UC.name as nameConductor, UT.name as nameTecnico", FALSE);
				$this->db->join('flota_main as F', 'F.id = OV.idflota','left');
				$this->db->join('tbl_users as UC', 'UC.userId = OV.conductor','left');
				$this->db->join('tbl_users as UT', 'UT.userId = OV.tecnico','left');
				$this->db->from("ordenes_visitas AS OV");
				$this->db->where("id_orden", $idorden);

				$query = $this->db->get();
				return $query->result();
		}


		function getCortes($idorden)
		{
				$this->db->select("OF.fecha_desde, OF.fecha_hasta, OF.observacion, U.name as nameCreador", FALSE);
				$this->db->join('tbl_users as U', 'U.userId = OF.creado_por','left');
				$this->db->from("ordenes_fechaCortes AS OF");
				$this->db->where("id_orden", $idorden);

				$query = $this->db->get();
				return $query->result();
		}


		function getCountCortes($idorden)
		{
				$this->db->select("OF.id", FALSE);
				$this->db->from("ordenes_fechaCortes AS OF");
				$this->db->where("id_orden", $idorden);

				$query = $this->db->get();
				return $query->num_rows();
		}


		function addCorte($fechaInfo)
		{
				$this->db->trans_start();
				$this->db->insert('ordenes_fechaCortes', $fechaInfo);

				$insert_id = $this->db->insert_id();
				$this->db->trans_complete();
				return $insert_id;
		}

		function agregarArchivo($archivoInfo) //Agrego un nuevo archivo a la orden de trabajo.
    {
        $this->db->trans_start();
        $this->db->insert('ordenes_archivos', $archivoInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

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

		function updateArchivos($archivoInfo, $id_orden)
    {

        $this->db->where('orden', $id_orden);
				$this->db->where('activo', 1);
				$this->db->where('estado', 0);
        $this->db->update('ordenes_archivos', $archivoInfo);

        return TRUE;
    }

		function getArchivo($id)
    {
      $this->db->select('OA.id, OA.archivo, OA.tipo_documentacion');
      $this->db->from('ordenes_archivos as OA');
      $this->db->where('OA.id', $id);

      $query = $this->db->get();
      $row = $query->row();
      return $row;

    }

		function updateArchivo($archivoInfo, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('ordenes_archivos', $archivoInfo);

        return TRUE;
    }

		function ordenes_abiertas($serie,$estados,$tipo)
		{
				$this->db->select('RM.id,RM.ultimo_estado');
				$this->db->from('reparacion_main as RM');
				$this->db->where('serie',$serie);
				$this->db->where('tipo',$tipo);
				if (is_array($estados)) {
					$this->db->where_in('RM.ultimo_estado',$estados);
				} else {
					$this->db->where('RM.ultimo_estado',$estados);
				}

				$query = $this->db->get();
				return $query->result();
		}

		function primerEvento($id_orden)
		{
			$this->db->select('RE.asignado_categoria');
			$this->db->from('reparacion_estados as RE');
			$this->db->where('RE.orden',$id_orden);

			$query = $this->db->get();
			$row = $query->row();
			return $row;
		}

		function estadoEquipo($idequipo,$estado)
		{
		    $this->db->select('de.id');
		    $this->db->from('deposito as de');
		    $this->db->where('de.id_equipo', $idequipo);
		    $this->db->where('de.estado', $estado);

		    $query = $this->db->get();
		    $row = $query->row();
		    return $row;
		}
}
