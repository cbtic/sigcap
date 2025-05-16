-- DROP FUNCTION public.sp_listar_deuda_detallado_caja_paginado(varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_deuda_detallado_caja_paginado(p_fecha_fin character varying, p_fecha_consulta character varying, p_concepto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' v.id, a.numero_cap, p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres apellidos_nombre, v.monto, c.denominacion concepto, v.descripcion , EXTRACT(YEAR FROM v.fecha) periodo, to_char(v.fecha,''dd-mm-yyyy'') fecha_vencimiento ';

	v_tabla=' from valorizaciones v 
    inner join conceptos c on v.id_concepto = c.id 
    inner join agremiados a on v.id_agremido = a.id 
    inner join personas p on a.id_persona = p.id 
	LEFT JOIN comprobantes co ON v.id_comprobante = co.id';
	
	v_where = ' Where 1=1 
	and v.id_modulo in (''2'',''3'',''4'',''6'') 
	and a.id_regional =''5''
	and a.id_situacion not in(''83'',''266'',''267'')
	and a.id_ubicacion =''334''
	and v.exonerado = ''0'' ';
	
	If p_fecha_fin<>'' Then
	 v_where:=v_where||' and v.fecha <= '''||p_fecha_fin||''' ';
	End If;

	If p_fecha_consulta<>'' Then
	 v_where:=v_where||' AND ( v.pagado = ''0'' OR (v.pagado = ''1'' AND co.fecha_pago > (TO_DATE(''' || p_fecha_consulta || ''', ''DD-MM-YYYY'')) + INTERVAL ''1 day''))';
	End If;

	If p_concepto<>'' Then
	 v_where:=v_where||' And v.id_concepto = '''||p_concepto||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||' And v.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By apellidos_nombre, concepto asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By apellidos_nombre, concepto asc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
