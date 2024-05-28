CREATE OR REPLACE FUNCTION public.sp_listar_concurso_resultado_agremiado_paginado(p_periodo character varying,p_id_tipo_concurso character varying,p_id_sub_tipo_concurso character varying,p_id_puesto character varying,p_id_concurso character varying, p_numero_documento character varying, p_id_agremiado character varying, p_agremiado character varying, p_numero_cap character varying, p_id_regional character varying, p_id_situacion character varying, p_id_estado character varying, p_campo character varying, p_orden character varying, p_flag_concurso character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' t1.id,pc.descripcion periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso,to_char(t1.created_at,''dd-mm-yyyy'')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t10.tipo,t10.serie,t10.numero,t1.puntaje,t1.resultado,t11.denominacion puesto, 
case when now() > t5.fecha_inscripcion_fin then 1 else 0 end valida,fecha_acreditacion_inicio,fecha_acreditacion_fin 
';

	v_tabla=' from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
inner join periodo_comisiones pc on t5.id_periodo=pc.id 
inner join tabla_maestras tm on t5.id_tipo_concurso::int=tm.codigo::int and tm.tipo=''101''
left join tabla_maestras tms on t5.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo=''93''
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo =''14'' 
inner join regiones t8 on t2.id_regional = t8.id
left join valorizaciones t9 on t1.id=t9.pk_registro and t9.id_modulo=''1''
left join comprobantes t10 on t9.id_comprobante=t10.id 
left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo =''94'' ';
	
	
	v_where = ' Where 1=1  
And t1.estado=''1'' ';
	
	If p_numero_documento<>'' Then
	 v_where:=v_where||'And t3.numero_documento = '''||p_numero_documento||''' ';
	End If;
	
	If p_agremiado<>'' Then
	 v_where:=v_where||'And t3.nombres||'' ''||t3.apellido_paterno||'' ''||t3.apellido_materno ilike ''%'||p_agremiado||'%'' ';
	End If;
	
	If p_id_agremiado<>'' Then
	 v_where:=v_where||'And t1.id_agremiado = '''||p_id_agremiado||''' ';
	End If;

	If p_numero_cap<>'' Then
	 v_where:=v_where||'And t2.numero_cap = '''||p_numero_cap||''' ';
	End If;
	/*
	If p_id_concurso<>'' Then
	 v_where:=v_where||'And t4.id_concurso = '''||p_id_concurso||''' ';
	End If;
	*/
	
	If p_id_puesto<>'' and p_id_puesto<>'0' Then
	 v_where:=v_where||'And t1.puesto_postula = '''||p_id_puesto||''' ';
	End If;
	
	If p_id_tipo_concurso<>'' and p_id_tipo_concurso<>'0' Then
	 v_where:=v_where||'And t5.id_tipo_concurso = '''||p_id_tipo_concurso||''' ';
	End If;

	If p_id_sub_tipo_concurso<>'' and p_id_sub_tipo_concurso<>'0' Then
	 v_where:=v_where||'And t5.id_sub_tipo_concurso = '''||p_id_sub_tipo_concurso||''' ';
	End If;
	
	If p_periodo<>'' Then
	 v_where:=v_where||'And t5.id_periodo = '''||p_periodo||''' ';
	End If;

	If p_id_regional<>'' Then
	 v_where:=v_where||'And t2.id_regional = '''||p_id_regional||''' ';
	End If;

	If p_id_situacion<>'' Then
	 v_where:=v_where||'And t2.id_situacion = '''||p_id_situacion||''' ';
	End If;

	If p_id_estado<>'' Then
	 v_where:=v_where||'And t1.resultado = '''||p_id_estado||''' ';
	End If;
	
	if p_flag_concurso<>'' Then
	 v_where:=v_where||'And (case when now() > t5.fecha_inscripcion_fin then 2 else 1 end) = '''||p_flag_concurso||''' ';
	End If;

	/*
	If p_campo='' Then
		p_campo='t1.id';
	End If;

	If p_orden='' Then
		p_orden='desc';
	End If;
	*/
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By '||p_campo||' '||p_orden||' LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By '||p_campo||' '||p_orden||' ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
