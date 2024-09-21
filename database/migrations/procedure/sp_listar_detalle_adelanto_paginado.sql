CREATE OR REPLACE FUNCTION public.sp_listar_detalle_adelanto_paginado(p_adelanto_pagar character varying, p_fecha_pago character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' ad.id, ad.adelanto_pagar, ad.fecha_pago, ad.estado';

	v_tabla=' from adelanto_detalles ad ';
		
	
	v_where = ' Where 1=1  ';
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
	 v_where:=v_where||'And ad.estado = '''||p_estado||''' ';
	End If;
	

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ad.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ad.id desc ;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
