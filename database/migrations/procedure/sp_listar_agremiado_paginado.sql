CREATE OR REPLACE FUNCTION public.sp_listar_agremiado_paginado(p_region character varying, p_numero_cap character varying, p_numero_documento character varying, p_agremiado character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_id_situacion character varying, p_id_categoria character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' a.id,to_char(a.fecha_colegiado,''dd-mm-yyyy'')fecha_colegiado,tm.denominacion tipo_documento,
p.numero_documento,a.numero_cap,r.denominacion region,
p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, 
to_char(p.fecha_nacimiento,''dd-mm-yyyy'')fecha_nacimiento,tms.denominacion situacion,tmc.denominacion categoria ';

	v_tabla='from agremiados a 
inner join personas p on a.id_persona=p.id
inner join tabla_maestras tm on p.id_tipo_documento::int=tm.codigo::int and tm.tipo=''16''
inner join regiones r on a.id_regional=r.id 
inner join tabla_maestras tms on a.id_situacion::int=tms.codigo::int and tms.tipo=''14'' 
left join tabla_maestras tmc on a.id_categoria::int=tmc.codigo::int and tmc.tipo=''18'' ';
	
	v_where = ' Where 1=1  ';

	If p_region<>'' Then
	 v_where:=v_where||'And a.id_regional = '''||p_region||''' ';
	End If;
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap = '''||p_numero_cap||''' ';
	End If;
	
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento = '''||p_numero_documento||''' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_agremiado||'%'' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And a.fecha_colegiado >= '''||p_fecha_inicio||' :00:00'' ';
	End If;
	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And a.fecha_colegiado <= '''||p_fecha_fin||' :23:59'' ';
	End If;
	
	If p_id_situacion<>'' Then
	 v_where:=v_where||'And a.id_situacion = '''||p_id_situacion||''' ';
	End If;

	If p_id_categoria<>'' Then
	 v_where:=v_where||'And a.id_categoria = '''||p_id_categoria||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
