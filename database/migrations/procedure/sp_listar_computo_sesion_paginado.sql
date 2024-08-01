
CREATE OR REPLACE FUNCTION public.sp_listar_computo_sesion_paginado(p_id_periodo_comisiones character varying, p_id_comision character varying, p_id_puesto character varying, p_anio character varying, p_mes character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

v_sesion_delegado varchar;
v_sesion_coordinador_zonal varchar;
v_sesion_suplente varchar;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' * ';

	v_tabla=' from (
select mi.denominacion municipalidad,t4.comision comision,
p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres delegado,a.numero_cap,coalesce(tmp.denominacion,''ASESOR / ESPECIALISTA'') puesto,cd.id_puesto::int id_puesto, 
t5.descripcion periodo,
(case when t0.coordinador=''1'' then ''COORDINADOR'' else '''' end) coordinador,
/*sum(case when tmts.denominacion=''ORDINARIA'' then 1 else 0 end) computada,*/
sum(1) computada,
sum(case when /*tmts.denominacion=''ORDINARIA'' and*/ t4.denominacion in(select denominacion from tabla_maestras tm where tipo=''117'' and estado=''1'') then 1 else 0 end) sesion_coordinado_zonal,
sum(case when /*tmts.denominacion=''ORDINARIA'' and*/ coalesce(tmp.denominacion,''0'')!=''SUPLENTE'' and t4.denominacion not in(select denominacion from tabla_maestras tm where tipo=''117'' and estado=''1'') then 1 else 0 end) sesion_delegado,
/*sum(case when tmts.denominacion=''EXTRAORDINARIA'' then 1 else 0 end) adicional,*/
0 adicional,
sum(case when coalesce(tmp.denominacion,''0'')=''SUPLENTE'' then 1 else 0 end) sesion_suplente,
count(*) total
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join tabla_maestras t2 on t1.id_tipo_sesion::int = t2.codigo::int And t2.tipo =''71''
inner join tabla_maestras t3 on t1.id_estado_sesion::int = t3.codigo::int And t3.tipo =''56''
left join tabla_maestras t7 on t1.id_estado_aprobacion::int = t7.codigo::int And t7.tipo =''109'' 
inner join comisiones t4 on t1.id_comision=t4.id
inner join periodo_comisiones t5 on t1.id_periodo_comisione=t5.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
/*inner join comision_delegados cd on t0.id_delegado=cd.id  
inner join agremiados a on cd.id_agremiado=a.id*/
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id 
inner join personas p on a.id_persona=p.id 
inner join tabla_maestras tmts on t1.id_tipo_sesion::int = tmts.codigo::int And tmts.tipo =''71''
left join tabla_maestras tmp  on cd.id_puesto::int = tmp.codigo::int And tmp.tipo =''94''
where t0.id_aprobar_pago=2 ';
	
	If p_id_periodo_comisiones<>'' Then
	 v_tabla:=v_tabla||'And t1.id_periodo_comisione = '''||p_id_periodo_comisiones||''' ';
	End If;
	
	If p_id_comision<>'' and p_id_comision<>'0' Then
	 v_tabla:=v_tabla||' And t1.id_comision = '''||p_id_comision||''' ';
	End If;

	If p_id_puesto<>'' and p_id_puesto<>'0' Then
	 v_tabla:=v_tabla||' And cd.id_puesto = '''||p_id_puesto||''' ';
	End If;

	If p_anio<>'' Then
	 v_tabla:=v_tabla||'And to_char(t1.fecha_ejecucion,''yyyy'') = '''||p_anio||''' ';
	End If;

	If p_mes<>'' Then
	 v_tabla:=v_tabla||'And to_char(t1.fecha_ejecucion,''mm'') = '''||p_mes||''' ';
	End If;

	v_tabla:=v_tabla||'group by t0.coordinador,mi.denominacion,t4.comision,p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres,a.numero_cap,tmp.denominacion,cd.id_puesto::int, t5.descripcion
)R ';
	
	v_where = ' Where 1=1  ';
	

	/*
	If p_id_regional<>'' Then
	 v_where:=v_where||'And t1.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_periodo_comisiones<>'' Then
	 v_where:=v_where||'And t1.id_periodo_comisione = '''||p_id_periodo_comisiones||''' ';
	End If;

	If p_id_comision<>'' Then
	 v_where:=v_where||'And t1.id_comision = '''||p_id_comision||''' ';
	End If;
	
	If p_id_tipo_sesion<>'' Then
	 v_where:=v_where||'And t1.id_tipo_sesion::int = '''||p_id_tipo_sesion||''' ';
	End If;
	
	If p_id_estado_sesion<>'' Then
	 v_where:=v_where||'And t1.id_estado_sesion::int = '''||p_id_estado_sesion||''' ';
	End If;

	If p_id_estado_aprobacion<>'' Then
	 v_where:=v_where||'And t1.id_estado_aprobacion::int = '''||p_id_estado_aprobacion||''' ';
	End If;

	If p_fecha_programado_desde<>'' Then
	 v_where:=v_where||'And t1.fecha_programado >= '''||p_fecha_programado_desde||' :00:00'' ';
	End If;
	If p_fecha_programado_hasta<>'' Then
	 v_where:=v_where||'And t1.fecha_programado <= '''||p_fecha_programado_hasta||' :23:59'' ';
	End If;
	*/

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;

	EXECUTE ('SELECT coalesce(sum(sesion_coordinado_zonal),0) From (SELECT '||v_campos||v_tabla||v_where||')R') INTO v_sesion_coordinador_zonal;
	EXECUTE ('SELECT coalesce(sum(sesion_delegado),0) From (SELECT '||v_campos||v_tabla||v_where||')R') INTO v_sesion_delegado;
	EXECUTE ('SELECT coalesce(sum(sesion_suplente),0) From (SELECT '||v_campos||v_tabla||v_where||')R') INTO v_sesion_suplente;

	v_col_count:=' ,'||v_count||' as TotalRows ';
	v_col_count:=v_col_count||' ,'||v_sesion_coordinador_zonal||' as total_sesion_coordinador_zonal ';
	v_col_count:=v_col_count||' ,'||v_sesion_delegado||' as total_sesion_delegado ';
	v_col_count:=v_col_count||' ,'||v_sesion_suplente||' as total_sesion_suplente ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By municipalidad asc,comision asc,id_puesto asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By municipalidad asc,comision asc,id_puesto asc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;


