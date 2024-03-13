-- DROP FUNCTION public.sp_listar_asignacion_cuenta_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_asignacion_cuenta_paginado(p_cuenta character varying, p_denominacion character varying, p_tipo character varying, p_centro_costo character varying, p_partida_presupuestal character varying, p_cod_financiero character varying, p_medio_pago character varying, p_origen character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' ac.id, pc.cuenta cuenta, ac.denominacion, tc.denominacion tipo_cuenta, 
		cc.codigo centro_costo, pp.codigo partida_presupuestal, ac.id_codigo_financiero codigo_financiero, 
		mp.codigo medio_pago, ac.id_origen origen, ac.estado ';

	v_tabla=' from asignacion_cuentas ac 
		left join plan_contables pc on pc.id = ac.id_plan_contable 
		left join tabla_maestras tc on tc.tipo = ''119'' and tc.codigo::int = ac.id_tipo_cuenta::int 
		left join centro_costos cc on cc.id = ac.id_centro_costo 
		left join partida_presupuestales pp on pp.id = ac.id_partida_presupuestal 
		left join tabla_maestras mp on mp.tipo = ''108'' and mp.codigo::int = ac.id_medio_pago::int ';
	
	v_where = ' Where 1=1  ';
	
	If p_cuenta<>'' Then
	 v_where:=v_where||'And pc.cuenta ilike '''||p_cuenta||'%'' ';
	End If;
	
	If p_denominacion<>'' Then
	 v_where:=v_where||'And ac.denominacion ilike '''||p_denominacion||'%'' ';
	End If;

	If p_tipo<>'' Then
	 v_where:=v_where||'And tc.denominacion ilike '''||p_tipo||'%'' ';
	End If;

	If p_centro_costo<>'' Then
	 v_where:=v_where||'And cc.codigo ilike '''||p_centro_costo||'%'' ';
	End If;

	If p_partida_presupuestal<>'' Then
	 v_where:=v_where||'And pp.codigo ilike '''||p_partida_presupuestal||'%'' ';
	End If;

	If p_cod_financiero<>'' Then
	 v_where:=v_where||'And ac.id_codigo_financiero ilike '''||p_cod_financiero||'%'' ';
	End If;

	If p_medio_pago<>'' Then
	 v_where:=v_where||'And mp.codigo ilike '''||p_medio_pago||'%'' ';
	End If;

	If p_origen<>'' Then
	 v_where:=v_where||'And ac.id_origen ilike '''||p_origen||'%'' ';
	End If;


	If p_estado<>'' Then
	 v_where:=v_where||'And ac.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ac.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ac.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
