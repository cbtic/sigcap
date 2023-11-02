CREATE OR REPLACE FUNCTION public.sp_listar_concurso_agremiado_paginado(p_id_tipo_concurso character varying, p_periodo character varying, p_numero_documento character varying, p_agremiado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' t1.id,t5.periodo,t6.denominacion tipo_concurso,to_char(t1.created_at,''dd-mm-yyyy'')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t10.tipo,t10.serie,t10.numero ';

	v_tabla=' from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo=''93''
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo =''14'' 
inner join regiones t8 on t2.id_regional = t8.id
inner join valorizaciones t9 on t1.id=t9.pk_registro and t9.id_modulo=''1''
inner join comprobantes t10 on t9.id_comprobante=t10.id ';
	
	
	v_where = ' Where 1=1  ';
	/*
	If p_id_concurso<>'' Then
	 v_where:=v_where||'And c.id_concurso = '''||p_id_concurso||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And c.estado = '''||p_estado||''' ';
	End If;
	*/

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By t1.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

