-- DROP FUNCTION public.sp_listar_comprobante_cuota_pago_paginado(varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_comprobante_cuota_pago_paginado(p_id character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

begin
	 
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
/*	
select  c.id, c.id_comprobante, c.item, c.fecha, c.id_medio, c.nro_operacion, c.descripcion, c.monto, c.fecha_vencimiento fecha, c.estado, cp.denominacion
                from comprobante_cuota_pagos c
                inner join tabla_maestras cp on cp.tipo = '19' and cp.codigo::int = c.id_medio 
                where c.id_comprobante='360'
                order by c.id 
*/
	v_campos=' c.id, c.id_comprobante, c.item, c.fecha, c.id_medio, c.nro_operacion, c.descripcion, c.monto, c.fecha_vencimiento fecha, c.estado, cp.denominacion ';

	v_tabla=' from comprobante_cuota_pagos c
                inner join tabla_maestras cp on cp.tipo = ''19'' and cp.codigo::int = c.id_medio ';
	
	
	v_where = ' Where 1=1  ';
	
	If p_id<>'' Then
	 v_where:=v_where||'And c.id_comprobante = '''||p_id||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And c.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
