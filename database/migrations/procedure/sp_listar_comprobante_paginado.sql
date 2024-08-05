-- DROP FUNCTION public.sp_listar_comprobante_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_comprobante_paginado(p_fecha_ini character varying, p_fecha_fin character varying, p_tipo character varying, p_serie character varying, p_numero character varying, p_razon_social character varying, p_estado_pago character varying, p_anulado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	--select * from comprobantes limit 10
	--select * from personas limit 10
	--select * from afiliaciones limit 10
	
 /*select f.id, f.serie, f.numero, f.tipo, f.fecha, f.cod_tributario, f.destinatario, 
        f.subtotal, f.impuesto, f.total, f.estado_pago, f.anulado, f.estado_sunat sunat, f.ruta_comprobante pdf
	FROM public.comprobantes f
		  Inner Join users u On u.id = f.id_usuario_inserta 
         
   */       
		  


	v_campos=' f.id, f.serie, f.numero, f.tipo, f.fecha, f.cod_tributario, f.destinatario, 
        f.subtotal, f.impuesto, f.total, f.estado_pago, f.anulado, f.estado_sunat sunat, f.ruta_comprobante pdf, u.name usuario, tm.denominacion caja,
        f.id_forma_pago, fp.denominacion forma_pago, case when f.id_forma_pago = 2  then f.total - (select sum(t.monto) monto from comprobante_cuota_pagos t where t.estado = ''1'' and t.id_comprobante = f.id) 
		else 0 end restante_credito 
';
        
	v_tabla='FROM comprobantes f 
				left join users u on u.id = f.id_usuario_inserta 
				left join tabla_maestras tm on tm.tipo = ''91'' and tm.codigo::int = f.id_caja
				left join tabla_maestras fp on fp.tipo = ''104'' and fp.codigo::int = f.id_forma_pago 

';

	v_where = ' Where 1 = 1 ';

	If p_fecha_ini<>'' Then
	 v_where:=v_where||'And f.fecha >= '''||p_fecha_ini||' :00:00'' ';
	End If;


	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And f.fecha <= '''||p_fecha_fin||' :23:59'' ';
	End If;

	If p_tipo<>'' Then
	 v_where:=v_where||' And f.tipo = '''||p_tipo||''' '; 
	End If;

	If p_serie<>'' Then
	 v_where:=v_where||' And f.serie ilike '''||p_serie||'%'' '; 
	End If;
	
	If p_numero<>'' Then
	 v_where:=v_where||' And f.numero = '''||p_numero||''' '; 
	End If;

	If p_razon_social<>'' Then
	 v_where:=v_where||' And f.destinatario ilike ''%'||p_razon_social||'%'' '; 
	End If;	

	If p_estado_pago<>'' then
	 v_where:=v_where||' And f.estado_pago = '''||p_estado_pago||''' '; 
	End If;

	If p_anulado<>'' then
	 v_where:=v_where||' And f.anulado = '''||p_anulado||''' '; 
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By f.fecha Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By f.fecha Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
