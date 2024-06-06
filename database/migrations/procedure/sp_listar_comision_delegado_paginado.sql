
CREATE OR REPLACE FUNCTION public.sp_listar_comision_delegado_paginado(p_id_periodo_comisiones character varying, p_id_tipo_agrupacion character varying, p_tipo_comision character varying, p_comision character varying,p_numero_cap character varying, p_delegado character varying, p_coordinador character varying, p_id_situacion character varying, p_puesto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' cd.id,c.id id_comision,c.denominacion,c.comision,tm.denominacion tipo_agrupacion,tm2.denominacion situacion,tm3.denominacion puesto,
p.numero_documento,p.nombres,p.apellido_paterno,p.apellido_materno,a.numero_cap,cd.coordinador,tm4.denominacion tipo_comision ';

	v_tabla=' from comisiones c
left join comision_delegados cd on c.id=cd.id_comision 
inner join municipalidad_integradas mi on c.id_municipalidad_integrada = mi.id
inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo=''99''
left join agremiados a on cd.id_agremiado=a.id
left join personas p on a.id_persona=p.id
left join tabla_maestras tm2 on a.id_situacion = tm2.codigo::int And tm2.tipo =''14''
left join tabla_maestras tm3 on cd.id_puesto::int = tm3.codigo::int And tm3.tipo =''94''
left join tabla_maestras tm4 on c.id_tipo_comision::varchar = tm4.codigo::varchar And tm4.tipo =''102'' ';
	
	v_where = ' Where 1=1 and cd.estado=''1'' ';
	
	If p_id_periodo_comisiones<>'0' Then
	 v_where:=v_where||'And mi.id_periodo_comision = '''||p_id_periodo_comisiones||''' ';
	End If;

	If p_comision<>'0' Then
	 v_where:=v_where||'And c.id = '''||p_comision||''' ';
	End If;

	If p_id_tipo_agrupacion<>'0' Then
	 v_where:=v_where||'And mi.id_tipo_agrupacion = '''||p_id_tipo_agrupacion||''' ';
	End If;
	
	If p_tipo_comision<>'0' Then
	 v_where:=v_where||'And c.id_tipo_comision::varchar = '''||p_tipo_comision||''' ';
	End If;
	
	If p_numero_cap<>'' Then
	 v_where:=v_where||'And a.numero_cap = '''||p_numero_cap||''' ';
	End If;
	
	If p_delegado<>'' Then
	 v_where:=v_where||'And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_delegado||'%'' ';
	End If;

	If p_id_situacion<>'' Then
	 v_where:=v_where||'And a.id_situacion = '''||p_id_situacion||''' ';
	End If;
	
	If p_puesto<>'' Then
	 v_where:=v_where||'And cd.id_puesto::int = '''||p_puesto||''' ';
	End If;
	
	If p_coordinador<>'' Then
	 v_where:=v_where||'And cd.coordinador = '''||p_coordinador||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.denominacion asc, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.denominacion asc, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres asc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

