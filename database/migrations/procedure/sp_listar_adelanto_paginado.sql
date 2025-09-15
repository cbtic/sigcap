CREATE OR REPLACE FUNCTION public.sp_listar_adelanto_paginado(p_numero_cap character varying, p_agremiado character varying, p_total_adelanto character varying, p_numero_cuotas character varying, p_fecha character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' a.id, ag.numero_cap, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado, a.total_adelanto, a.nro_total_cuotas, 
	a.fecha, a.estado,tm.denominacion tiene_recibo';

	v_tabla=' from adelantos a 
	inner join agremiados ag on a.id_agremiado = ag.id
	inner join personas p on ag.id_persona = p.id 
	left join tabla_maestras tm on a.id_tiene_recibo::int=tm.codigo::int and tm.tipo=''121''
	';
		
	
	v_where = ' Where 1=1  ';
	

	If p_numero_cap<>'' Then
	 v_where:=v_where||'And ag.numero_cap = '''||p_numero_cap||''' ';
	End If;

	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.nombres||'' ''||p.apellido_paterno||'' ''||p.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;

/*
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And t3.numero_documento = '''||p_numero_documento||''' ';
	End If;
	
	If p_agremiado<>'' Then
	 v_where:=v_where||'And t3.nombres||'' ''||t3.apellido_paterno||'' ''||t3.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And t2.numero_cap = '''||p_numero_cap||''' ';
	End If;

	If p_id_concurso<>'' Then
	 v_where:=v_where||'And t4.id_concurso = '''||p_id_concurso||''' ';
	End If;

	If p_id_regional<>'' Then
	 v_where:=v_where||'And t2.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_situacion<>'' Then
	 v_where:=v_where||'And t2.id_situacion = '''||p_id_situacion||''' ';
	End If;
*/
	If p_estado<>'' Then
	 v_where:=v_where||'And a.estado = '''||p_estado||''' ';
	End If;
	

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
