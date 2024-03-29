
CREATE OR REPLACE FUNCTION public.sp_listar_reintegro_paginado(p_denominacion character varying, p_periodo character varying,p_mes character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos='  dr.id,r.denominacion regional,pc.descripcion periodo,id_mes,importe,p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado,
			a.numero_cap,dr.estado,c.denominacion comision ';

	v_tabla=' from delegado_reintegros dr
inner join periodo_comisiones pc on dr.id_periodo=pc.id 
inner join comision_delegados cd on dr.id_delegado=cd.id 
inner join agremiados a on cd.id_agremiado=a.id
inner join personas p on a.id_persona=p.id 
inner join regiones r on dr.id_regional = r.id
inner join comisiones c on dr.id_comision = c.id
';
	
	
	v_where = ' Where 1=1  ';
	
	/*
	If p_denominacion<>'' Then
	 v_where:=v_where||'And m.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And m.estado = '''||p_estado||''' ';
	End If;
	*/
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By dr.id LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By dr.id ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

