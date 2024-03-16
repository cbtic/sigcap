
CREATE OR REPLACE FUNCTION public.sp_listar_empresa_beneficiario_paginado(p_id_empresa character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' p.numero_documento, p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres nombres, p.direccion,p.numero_celular, p.correo ';

	v_tabla=' from curso_empresa_beneficiarios ceb 
        inner join personas p on ceb.id_persona = p.id 
        inner join empresas e on ceb.id_empresa = e.id ';
	
	
	v_where = ' Where 1=1  ';
	
	If p_id_empresa<>'' Then
	 v_where:=v_where||'And e.id = '''||p_id_empresa||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ceb.id desc  LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ceb.id desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;

