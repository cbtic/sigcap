CREATE OR REPLACE FUNCTION public.sp_listar_asignacion_cuenta_paginado(p_tipo_planilla character varying, p_cuenta character varying, p_denominacion character varying, p_tipo character varying, p_centro_costo character varying, p_partida_presupuestal character varying, p_cod_financiero character varying, p_medio_pago character varying, p_origen character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	cc.codigo centro_costo, pp.codigo partida_presupuestal, cf.codigo || ''-'' ||cf.denominacion codigo_financiero, 
	mp.codigo || ''-'' || mp.denominacion medio_pago, tm.codigo||''-''||tm.denominacion origen, tm2.denominacion tipo_planilla, ac.estado  ';

	v_tabla=' from asignacion_cuentas ac 
	left join plan_contables pc on pc.id = ac.id_plan_contable 
	left join tabla_maestras tc on tc.tipo = ''122'' and tc.codigo::int = ac.id_tipo_cuenta::int 
	left join centro_costos cc on cc.id = ac.id_centro_costo 
	left join partida_presupuestales pp on pp.id = ac.id_partida_presupuestal 
	left join tabla_maestras mp on mp.tipo = ''108'' and mp.codigo::int = ac.id_medio_pago::int
	left join codigo_financieros cf on ac.id_codigo_financiero = cf.id
	left join tabla_maestras tm on tm.tipo = ''128'' and tm.codigo::int = ac.id_origen ::int
	left join tabla_maestras tm2 on tm2.tipo = ''129'' and tm2.codigo::int = ac.id_tipo_planilla ::int';
	
	v_where = ' Where 1=1  ';
	
	If p_tipo_planilla<>'' Then
	 v_where:=v_where||'And ac.id_tipo_planilla ='''||p_tipo_planilla||''' ';
	End If;

	If p_cuenta<>'' Then
	 v_where:=v_where||'And pc.id ='''||p_cuenta||''' ';
	End If;
	
	If p_denominacion<>'' Then
	 v_where:=v_where||'And ac.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	If p_tipo<>'' Then
	 v_where:=v_where||'And ac.id_tipo_cuenta = '''||p_tipo||''' ';
	End If;

	If p_centro_costo<>'' Then
	 v_where:=v_where||'And ac.id_centro_costo = '''||p_centro_costo||''' ';
	End If;

	If p_partida_presupuestal<>'' Then
	 v_where:=v_where||'And ac.id_partida_presupuestal = '''||p_partida_presupuestal||''' ';
	End If;

	If p_cod_financiero<>'' Then
	 v_where:=v_where||'And ac.id_codigo_financiero = '''||p_cod_financiero||''' ';
	End If;

	If p_medio_pago<>'' Then
	 v_where:=v_where||'And ac.id_medio_pago = '''||p_medio_pago||''' ';
	End If;

	If p_origen<>'' Then
	 v_where:=v_where||'And ac.id_origen = '''||p_origen||''' ';
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
