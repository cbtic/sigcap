CREATE OR REPLACE FUNCTION public.sp_listar_coordinador_zonal_paginado(p_periodo character varying, p_numero_cap character varying, p_agremiado character varying, p_municipalidad character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' * ';

	v_tabla='from (select cz.id, a.numero_cap, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, zo.denominacion zonal,ec.denominacion estado_coordinador, cz.estado, 
	(select string_agg(m.denominacion,'' - '') from coordinador_zonal_detalles czd
	left join municipalidades m on czd.id_municipalidad = m.id
	where czd.id_tipo_coordinador = cz.id_zonal';

	If p_periodo<>'' Then
	 v_tabla:=v_tabla||' and czd.periodo = '''||p_periodo||''' ';
	End If;
	
	v_tabla:=v_tabla||') municipalidad
	from coordinador_zonales cz 
	inner join agremiados a on cz.id_agremiado = a.id 
	inner join personas p on a.id_persona = p.id 
	left join tabla_maestras zo on cz.id_zonal::int = zo.codigo::int And zo.tipo =''117'' 
	left join tabla_maestras ec on cz.estado_coordinador::int = ec.codigo::int And ec.tipo =''119''';

	If p_periodo<>'' Then
	 v_tabla:=v_tabla||' where cz.id_periodo = '''||p_periodo||''' ';
	End If;

	v_tabla:=v_tabla||') M';

	v_where = ' Where 1=1  ';
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And M.numero_cap = '''||p_numero_cap||''' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And M.agremiado ilike ''%'||p_agremiado||'%'' ';
	End If;

	/*if p_periodo<>'' Then
	 v_where:=v_where||'And cz.id_periodo = '''||p_periodo||''' ';
	End If;*/

	If p_municipalidad<>'' Then
	 v_where:=v_where||'And M.municipalidad ilike ''%'||p_municipalidad||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And M.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By M.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By M.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
