
CREATE OR REPLACE FUNCTION public.sp_listar_afiliado_seguro_paginado(p_cap character varying, p_nombre character varying, p_seguro character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	 --select * from seguro_afiliados sa inner join agremiados a on sa.id_agremiado =a.id inner join seguros s on sp.id_seguro =s.id inner join seguros_planes sp on s.id =sp.id_seguro and sa.id_plan =sp.id  ;  
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' sa.id,a.numero_cap, apellido_paterno||'' ''|| apellido_materno || '', '' || nombres    desc_cliente,s.nombre,sa.estado, sp.nombre plan,sp.monto monto   ';

	v_tabla=' from seguro_afiliados sa inner join agremiados a on sa.id_agremiado =a.id  inner join seguros_planes sp on sa.id_plan =sp.id and sa.id_plan =sp.id  inner join seguros s on sp.id_seguro =s.id inner join personas p on p.id=a.id_persona';
	
	
	v_where = ' Where 1=1  ';
	
	If p_nombre<>'' Then
	 v_where:=v_where||'And a.desc_cliente ilike ''%'||p_nombre||'%'' ';
	End If;
	
	If p_seguro<>'' Then
	 v_where:=v_where||'And s.nombre ilike ''%'||p_seguro||'%'' ';
	End If;
	
	
	If p_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap = '''||p_cap||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And sa.estado = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.desc_cliente  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.desc_cliente ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
