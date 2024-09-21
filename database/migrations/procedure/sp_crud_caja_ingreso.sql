CREATE OR REPLACE FUNCTION public.sp_crud_caja_ingreso(accion character varying, p_id_usuario integer, p_id_caja_ingreso integer, p_id_caja integer, p_saldo_inicial character varying, p_total_recaudado character varying, p_saldo_total character varying, p_estado character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	--id_caja_ingreso integer;
	cantidad_caja integer;
begin

	Case accion
		When 'i' then
			select count(id) into cantidad_caja from caja_ingresos where id_caja=p_id_caja And estado = '1';
		
			if cantidad_caja=0 Then
				Insert Into caja_ingresos (id_usuario, id_caja, saldo_inicial, total_recaudado,saldo_total,fecha_inicio,estado,created_at, id_regional, id_usuario_contabilidad,id_usuario_inserta)
				Values (p_id_usuario,p_id_caja,to_number( p_saldo_inicial,'9999999999.99'),to_number( p_total_recaudado,'9999999999.99'),to_number( p_saldo_total,'9999999999.99'),now(),p_estado,now(),5,p_id_usuario,p_id_usuario);
				p_id_caja_ingreso := (SELECT currval('caja_ingresos_id_seq'));
			End if;
		When 'u' then
			update caja_ingresos t1 set 
			estado=0,
			--total_recaudado=(select coalesce(Sum(fac_total),0) from facturas where fac_caja_id=p_id_caja),
			total_recaudado=(select coalesce(Sum(total),0) from comprobantes c where c.anulado='N' And c.id_caja=t1.id_caja And c.fecha >= t1.fecha_inicio And c.fecha <= (case when t1.fecha_fin is null then now() else t1.fecha_fin end)),
			
			--saldo_total=((select coalesce(Sum(fac_total),0) from facturas where fac_caja_id=p_id_caja)+saldo_inicial),
			saldo_total =  ((select coalesce(Sum(total),0) from comprobantes c where c.anulado='N' And c.id_caja=t1.id_caja And c.fecha >= t1.fecha_inicio And c.fecha <= (case when t1.fecha_fin is null then now() else t1.fecha_fin end))+t1.saldo_inicial),
			fecha_fin=now(),
			updated_at=now() 
			where id=p_id_caja_ingreso;
		When 'ul' then
			update caja_ingresos set 
			id_usuario_contabilidad=p_id_usuario,
			saldo_liquidado=to_number( p_saldo_total,'9999999999.99'),
			observacion=p_estado
			where id=p_id_caja_ingreso;
			
		End Case;
				
	return p_id_caja_ingreso;
	/*EXCEPTION
	WHEN OTHERS THEN
        id_caja_ingreso:=-1;
	return id_caja_ingreso;
	*/
end;
$function$
;
