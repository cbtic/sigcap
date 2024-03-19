CREATE OR REPLACE FUNCTION public.sp_listar_beneficiario_paginado(p_ruc character varying, p_dni character varying, p_agremiado character varying, p_razon_social character varying, p_periodo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' ceb.id,  e.ruc, e.razon_social, p.numero_documento, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, tm.denominacion sexo, p.fecha_nacimiento, ceb.periodo, c.denominacion concepto, tm2.denominacion estado_beneficiario, ceb.estado ';

	v_tabla='from concepto_empresa_beneficiarios ceb 
	inner join personas p on ceb.id_persona = p.id 
	inner join empresas e on ceb.id_empresa = e.id 
	inner join conceptos c on ceb.id_concepto = c.id 
	left join tabla_maestras tm on p.id_sexo ::int =tm.codigo:: int and tm.tipo = ''2''
	left join tabla_maestras tm2 on ceb.estado_beneficiario ::int =tm2.codigo:: int and tm2.tipo = ''120''';
	
	v_where = ' Where 1=1  ';
	

	/*if p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta ilike ''%'||p_cuenta||'%'' ';
	End If;

	If p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta = '''||p_cuenta||''' ';
	End If;*/

	If p_dni<>'' Then
	 v_where:=v_where||'And p.numero_documento = '''||p_dni||''' ';
	End If;

	if p_agremiado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_agremiado||'%'' ';
	End If;

	If p_razon_social<>'' Then
	 v_where:=v_where||'And e.razon_social ilike ''%'||p_razon_social||'%'' ';
	End If;

	If p_ruc<>'' Then
	 v_where:=v_where||'And e.ruc ilike ''%'||p_ruc||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ceb.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ceb.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ceb.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
