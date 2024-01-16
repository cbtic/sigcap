CREATE OR REPLACE FUNCTION public.sp_listar_certificado2_paginado(p_cap character varying, p_agremiado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' c.id , a.numero_cap ,p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres agremiado ,tm.denominacion Tipo_certificado,c.codigo,c.estado ';

	v_tabla=' from certificados c 
	inner join agremiados a on c.id_agremiado =a.id 
	inner join personas p on a.id_persona =p.id
	inner join tabla_maestras tm on c.id_tipo =tm.codigo::int and tm.tipo =''100''';
	
	v_where = ' Where 1=1  ';

	If p_agremiado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_agremiado||'%'' ';
	End If;
	
	
	If p_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap = '''||p_cap||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And c.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
