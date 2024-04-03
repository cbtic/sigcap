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

	_grupo integer;

	_id_periodo_comision integer;
	_id_periodo_comision_detalle integer;

	cursor_rh record;

begin
	
	

	_id_periodo_comision:=(select id_periodo_comision from periodo_comision_detalles where denominacion = p_anio||p_mes);
	_id_periodo_comision_detalle:=(select id from periodo_comision_detalles where denominacion = p_anio||p_mes);

	select max(id_grupo) into _grupo from asiento_planillas p 
	where p.id_periodo_comision = _id_periodo_comision and p.id_periodo_comision_detalle = _id_periodo_comision_detalle and p.estado = '1';

	_grupo := _grupo + 1;


	
	For cursor_rh In	
	
		select pd.id, sub_total,  monto, adelanto, reintegro, total_bruto, ir_cuarta, total_honorario, descuento, 
		saldo, id_agremiado, 
		tipo_comprobante, numero_comprobante, fecha_comprobante, a.id_persona, 
		p.apellido_paterno ||' '|| p.apellido_materno || ' ' || p.nombres ||'-'|| p_mes ||'-'|| _grupo::varchar  glosa
		from planilla_delegados pl 
		inner join planilla_delegado_detalles pd on pd.id_planilla = pl.id  
		inner join agremiados a on a.id = pd.id_agremiado
		inner join personas p on p.id = a.id_persona
		
		loop
 			
			insert into  asiento_planillas
				(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, centro_costo, presupuesto)				
				select 
				1, cursor_rh.id_persona, '63291', cursor_rh.total_bruto, 0,  cursor_rh.total_bruto/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id, '2025601', '01P2501';
	
			insert into  asiento_planillas
				(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle)				
				select 
				1, cursor_rh.id_persona, '40172', 0, cursor_rh.ir_cuarta, cursor_rh.ir_cuarta/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id;

			insert into  asiento_planillas
				(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle)				
				select 
				1, cursor_rh.id_persona, '4241', 0, cursor_rh.total_honorario, cursor_rh.total_honorario/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id;			

			
			
			insert into  asiento_planillas
				(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle)				
				select 
				2, cursor_rh.id_persona, '4241',cursor_rh.total_honorario, 0, cursor_rh.total_honorario/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id;	
			
			insert into  asiento_planillas
				(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle)				
				select 
				2, cursor_rh.id_persona, '1692', 0, cursor_rh.descuento, cursor_rh.descuento/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id;
	
			insert into  asiento_planillas
				(id_tipo, id_persona, cuenta, debe, haber, equivalente, glosa, id_tipo_documento, id_moneda, tipo_cambio, id_usuario_inserta,  
				id_periodo_comision, id_periodo_comision_detalle, id_grupo, id_planilla_delegado_detalle, codigo_financiero, medio_pago)				
				select 
				2, cursor_rh.id_persona, '104141', cursor_rh.total_honorario-cursor_rh.descuento, 0, (cursor_rh.total_honorario-cursor_rh.descuento)/3.71, cursor_rh.glosa, 1, 1, 3.73, 1, 
				_id_periodo_comision, _id_periodo_comision_detalle, _grupo, cursor_rh.id, '110', '001';


		End Loop;

idp:=1;

return idp;

--Select sp_generar_asiento_planilla('7', '2024', '03');

end;
$function$
;


