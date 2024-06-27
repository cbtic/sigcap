-- DROP FUNCTION public.sp_generar_asiento_planilla(varchar, varchar, varchar, varchar);

CREATE OR REPLACE FUNCTION public.sp_generar_asiento_planilla(p_asiento character varying, p_id_periodo character varying, p_anio character varying, p_mes character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	_numero integer;
	idp integer;
	
	_razon_social character varying;
	_total_smr numeric;
	_descuento numeric;

	_mes integer;
	_anio integer;
	_ruc character varying;

	_grupo integer;

	_id_periodo_comision integer;
	_id_periodo_comision_detalle integer;

	cursor_rh record;

begin
	
	

	_id_periodo_comision:=(select id_periodo_comision from periodo_comision_detalles where denominacion = p_anio||p_mes);
	_id_periodo_comision_detalle:=(select id from periodo_comision_detalles where denominacion = p_anio||p_mes);

	Case p_asiento
		When '1' then 
	
			select max(COALESCE(id_grupo, 0)) into _grupo 
			from asiento_planillas p 
			where p.id_periodo_comision = _id_periodo_comision and p.id_periodo_comision_detalle = _id_periodo_comision_detalle and p.estado = '1';
			if _grupo is null then _grupo:=0; end if;
			_grupo := _grupo + 1;
	
			For cursor_rh In	
			
				select pd.id, sub_total,  monto, adelanto, reintegro, total_bruto, ir_cuarta, total_honorario, descuento, 
					saldo, id_agremiado, 
					tipo_comprobante, numero_comprobante, fecha_comprobante, a.id_persona, 
					p.apellido_paterno ||' '|| p.apellido_materno || ' ' || p.nombres ||'-'|| p_mes ||'-'|| _grupo::varchar  glosa,			
					pd.fecha_comprobante,pd.fecha_vencimiento
				from planilla_delegados pl 
					inner join planilla_delegado_detalles pd on pd.id_planilla = pl.id  
					inner join agremiados a on a.id = pd.id_agremiado
					inner join personas p on p.id = a.id_persona
				where 1=1
					and pl.id_periodo_comision = _id_periodo_comision 
					and pl.mes = p_mes::integer 
					and pl.periodo = p_anio::integer 
					and pl.estado = '1'					
					and pd.id not in(
						select ap.id_planilla_delegado_detalle
						from asiento_planillas ap
						where ap.id_planilla_delegado_detalle is not null and ap.id_periodo_comision = _id_periodo_comision and ap.id_periodo_comision_detalle = _id_periodo_comision_detalle and ap.estado = '1'
					)
			
			loop
		 			
				insert into  asiento_planillas
					(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
					id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, centro_costo, presupuesto, fecha_documento,fecha_vencimiento,created_at,numero_comprobante, orden)				
					select 
					1, cursor_rh.id_persona, '63291', cursor_rh.total_bruto, 0,  cursor_rh.total_bruto/3.71, cursor_rh.glosa, 1, 1, 3.755, 1, 
					_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id, '2025601', '01P2501', cursor_rh.fecha_comprobante, cursor_rh.fecha_vencimiento, current_timestamp, cursor_rh.numero_comprobante,1;
			
				insert into  asiento_planillas
					(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
					id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, fecha_documento,fecha_vencimiento,created_at,numero_comprobante, orden)				
					select 
					1, cursor_rh.id_persona, '40172', 0, cursor_rh.ir_cuarta, cursor_rh.ir_cuarta/3.71, cursor_rh.glosa, 1, 1, 3.755, 1, 
					_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id, cursor_rh.fecha_comprobante, cursor_rh.fecha_vencimiento, current_timestamp, cursor_rh.numero_comprobante,2;
			
				insert into  asiento_planillas
					(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
					id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, fecha_documento,fecha_vencimiento,created_at,numero_comprobante, orden)				
					select 
					1, cursor_rh.id_persona, '4241', 0, cursor_rh.total_honorario, cursor_rh.total_honorario/3.71, cursor_rh.glosa, 1, 1, 3.755, 1, 
					_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id, cursor_rh.fecha_comprobante, cursor_rh.fecha_vencimiento, current_timestamp, cursor_rh.numero_comprobante,3;
				
				update planilla_delegado_detalles set id_grupo = _grupo where id = cursor_rh.id;
										
			End Loop;
	
		When '2' then 
	

			For cursor_rh In	
			
				select pd.id, sub_total,  monto, adelanto, reintegro, total_bruto, ir_cuarta, total_honorario, descuento, 
					saldo, id_agremiado, 
					tipo_comprobante, numero_comprobante, fecha_comprobante, a.id_persona, 
					p.apellido_paterno ||' '|| p.apellido_materno || ' ' || p.nombres ||'-'|| p_mes ||'-'|| pd.id_grupo::varchar  glosa,			
					pd.fecha_comprobante,pd.fecha_vencimiento, pd.id_grupo
				from planilla_delegados pl 
					inner join planilla_delegado_detalles pd on pd.id_planilla = pl.id  
					inner join agremiados a on a.id = pd.id_agremiado
					inner join personas p on p.id = a.id_persona
				where pl.id_periodo_comision = _id_periodo_comision 
					and pl.mes = p_mes::integer 
					and pl.periodo = p_anio::integer 
					and pl.estado = '1'
					and pd.cancelado = '1'
					and pd.id in(
						select ap.id_planilla_delegado_detalle
						from asiento_planillas ap
						where ap.id_planilla_delegado_detalle is not null and ap.id_periodo_comision = _id_periodo_comision and ap.id_periodo_comision_detalle = _id_periodo_comision_detalle and ap.estado = '1'
						and ap.id_tipo= 1
					)
					and pd.id not in(
						select ap.id_planilla_delegado_detalle
						from asiento_planillas ap
						where ap.id_planilla_delegado_detalle is not null and ap.id_periodo_comision = _id_periodo_comision and ap.id_periodo_comision_detalle = _id_periodo_comision_detalle and ap.estado = '1'
						and ap.id_tipo= 2
					)
			
			loop
		 								
				insert into  asiento_planillas
					(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
					id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, fecha_documento,fecha_vencimiento,created_at,numero_comprobante, orden)				
					select 
					2, cursor_rh.id_persona, '4241',cursor_rh.total_honorario, 0, cursor_rh.total_honorario/3.71, cursor_rh.glosa, 1, 1, 3.7, 1, 
					_id_periodo_comision, _id_periodo_comision_detalle, cursor_rh.id_grupo, cursor_rh.id, cursor_rh.fecha_comprobante, cursor_rh.fecha_vencimiento, current_timestamp, cursor_rh.numero_comprobante,1;	
				
				insert into  asiento_planillas
					(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
					id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, fecha_documento,fecha_vencimiento,created_at,numero_comprobante, orden)				
					select 
					2, cursor_rh.id_persona, '1692', 0, cursor_rh.descuento, cursor_rh.descuento/3.71, cursor_rh.glosa, 1, 1, 3.7, 1, 
					_id_periodo_comision, _id_periodo_comision_detalle, cursor_rh.id_grupo, cursor_rh.id, cursor_rh.fecha_comprobante, cursor_rh.fecha_vencimiento, current_timestamp, cursor_rh.numero_comprobante,2;
			
				insert into  asiento_planillas
					(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
					id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, codigo_financiero, medio_pago, fecha_documento,fecha_vencimiento,created_at,numero_comprobante, orden)				
					select 
					2, cursor_rh.id_persona, '104141', 0, cursor_rh.total_honorario-cursor_rh.descuento, (cursor_rh.total_honorario-cursor_rh.descuento)/3.71, cursor_rh.glosa, 1, 1, 3.7, 1, 
					_id_periodo_comision, _id_periodo_comision_detalle, cursor_rh.id_grupo, cursor_rh.id, '110', '001', cursor_rh.fecha_comprobante, cursor_rh.fecha_vencimiento, current_timestamp, cursor_rh.numero_comprobante,3;
		
			End Loop;
	End Case;

idp:=1;

return idp;

--update planilla_delegado_detalles set fecha_vencimiento = fecha_comprobante; 

--select * from planilla_delegado_detalles
--Select sp_generar_asiento_planilla('2','7', '2024', '03');

end;
$function$
;
