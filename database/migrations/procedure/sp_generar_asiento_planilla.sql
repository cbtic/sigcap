CREATE OR REPLACE FUNCTION sp_generar_asiento_planilla(p_id_periodo character varying, p_anio character varying, p_mes character varying)
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

	_grupo character varying;

	_id_periodo_comision integer;
	_id_periodo_comision_detalle integer;

	cursor_rh record;

begin
	
	_grupo := '1';

	_id_periodo_comision:=(select id_periodo_comision from periodo_comision_detalles where denominacion = p_anio||p_mes);
	_id_periodo_comision_detalle:=(select id from periodo_comision_detalles where denominacion = p_anio||p_mes);

	
	For cursor_rh In	
	
		select pd.id, sub_total,  monto, adelanto, reintegro, total_bruto, ir_cuarta, total_honorario, descuento, 
		saldo, id_agremiado, 
		tipo_comprobante, numero_comprobante, fecha_comprobante, a.id_persona, 
		p.apellido_paterno ||' '|| p.apellido_materno || ' ' || p.nombres ||'-'|| p_mes ||'-'|| _grupo  glosa
		from planilla_delegado_detalles pd
		inner join agremiados a on a.id = pd.id_agremiado
		inner join personas p on p.id = a.id_persona 		
		loop
 			
			insert into  asiento_planillas
				(id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, centro_costo, presupuesto)				
				select 
				cursor_rh.id_persona, '63291', cursor_rh.total_bruto, 0,  cursor_rh.total_bruto/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, 1, cursor_rh.id,'2025601','01P2501';
	
			insert into  asiento_planillas
				(id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle)				
				select 
				cursor_rh.id_persona, '40172', 0, cursor_rh.ir_cuarta, cursor_rh.ir_cuarta/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, 1, cursor_rh.id;

			insert into  asiento_planillas
				(id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle)				
				select 
				cursor_rh.id_persona, '4241', 0, cursor_rh.total_honorario, cursor_rh.total_honorario/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, 1, cursor_rh.id;			
			
		End Loop;

idp:=1;

return idp;

--Select sp_generar_asiento_planilla('7', '2024', '03');

end;
$function$
;


