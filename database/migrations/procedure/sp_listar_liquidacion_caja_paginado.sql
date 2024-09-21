CREATE OR REPLACE FUNCTION public.sp_listar_liquidacion_caja_paginado(p_fecha_inicio_desde character varying, p_fecha_inicio_hasta character varying, p_fecha_ini character varying, p_fecha_fin character varying, p_id_caja character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
--v_id numeric;
--v_numinf character varying;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;

Begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' t1.id,t1.id_caja,t3.name usuario,t1.saldo_inicial, 
        	(case when t1.estado=''0'' then total_recaudado else 
			(select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end))
			end)total_recaudado,
			(case when t1.estado=''0'' then saldo_total else 
			((select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end)) + t1.saldo_inicial)
			end)saldo_total,
			t1.estado,t2.denominacion caja,t2.tipo,t1.fecha_inicio,t1.fecha_fin
			,saldo_liquidado,observacion,t4.name usuario_contabilidad ';

	v_tabla='from caja_ingresos t1
			inner join tabla_maestras t2 on t1.id_caja=t2.id
			inner join users t3 on t1.id_usuario=t3.id
			--inner join users t4 on t1.id_usuario=t4.id
			left join users t4 on t1.id_usuario_contabilidad=t4.id ';
	
	v_where = ' Where 1=1 ';
	
	If p_fecha_inicio_desde<>'' Then
	 v_where:=v_where||'And t1.fecha_inicio >= '''||p_fecha_inicio_desde||' :00:00'' ';
	End If;
	If p_fecha_inicio_hasta<>'' Then
	 v_where:=v_where||'And t1.fecha_inicio <= '''||p_fecha_inicio_hasta||' :23:59'' ';
	End If;
	
	If p_fecha_ini<>'' Then
	 v_where:=v_where||'And t1.fecha_fin >= '''||p_fecha_ini||' :00:00'' ';
	End If;
	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And t1.fecha_fin <= '''||p_fecha_fin||' :23:59'' ';
	End If;
	
	If p_id_caja<>'0' Then
	 v_where:=v_where||' And t1.id_caja = '|| p_id_caja;
	End If;
	
	If p_estado<>'0' Then
	 	If p_estado='1' Then 
	 		p_estado:=1; 
			v_where:=v_where||' And t1.estado = '''|| p_estado||'''';
		End If;
	 	If p_estado='2' Then 
			p_estado:=0;
			v_where:=v_where||' And t1.estado = '''|| p_estado||'''';
		End If;
		If p_estado='3' Then 
			v_where:=v_where||' And t1.saldo_liquidado > 0';
		End If;
	End If;
	/*
	If p_afiliado<>'' Then
	 v_where:=v_where||'And t2.nombres||'' ''||t2.apellido_paterno||'' ''||t2.apellido_materno ilike ''%'||p_afiliado||'%'' ';
	End If;
	*/
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
