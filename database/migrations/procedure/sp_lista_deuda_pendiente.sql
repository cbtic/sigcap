-- DROP FUNCTION public.sp_lista_deuda_pendiente(varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_lista_deuda_pendiente(p_tipo_doc character varying, p_numero_doc character varying, p_cod_producto character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
_id_persona bigint;
_id_empresa bigint;
v_campos varchar;
v_scad varchar;
v_where varchar;

Begin


--- LIQUIDACION  $tipo_documento=="87"
	if p_tipo_doc = '87' then 
		select COALESCE(pr.id_persona,0), COALESCE(pr.id_empresa,0)
			into _id_persona, _id_empresa 
		from liquidaciones l 
			inner join propietarios pr on pr.id_solicitud = l.id_solicitud
			left join personas p on p.id = pr.id_persona 
			left join empresas e  on e.id = pr.id_empresa 
		where 1=1 and
			trim(l.credipago) = p_numero_doc 
		limit 1;
	--end if;	
		    
    
		
---- RUC  $tipo_documento=="79"
	elseif p_tipo_doc = '2' then
		select COALESCE(t1.id,0)
			into _id_empresa
        from empresas t1                    
        Where trim(t1.ruc )= p_numero_doc
       	limit 1;
	--end if;

---- CAP
    elseif p_tipo_doc = '0' then                
        select COALESCE(t2.id_persona,0)
			into _id_persona
		from personas t1 
			inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
		Where trim(t2.numero_cap) = p_numero_doc
			and t1.estado='1' 
		limit 1;
	--end if;

----- OTROS
	else
		select COALESCE(t2.id_persona,0)
			into _id_persona 			
		from personas t1 
			left join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
		Where t1.id_tipo_documento = 1 
				and trim(t1.numero_documento) = p_numero_doc 
				and t1.estado='1' 
		limit 1;
	end if;
/*
output (maximo 5) lista
CodigoProducto	:012
DescrProducto	:CUOTA GREMIAL
NumDocumento 	:FD221919437    
DescDocumento	:FACTURA DICIEMBRE   
FechaVencimiento:31/12/2024	
FechaEmision	:12/09/2024
Deuda		:30
Mora		:0
GastosAdm	:0
PagoMinimo	:0
ImporteTotal	:30
Periodo		:12
Año		:2024
Cuota		:1
MonedaDoc	:1(1: Soles,2: Dólares)
*/		

	v_where = ' ';
	If p_cod_producto <> '' Then
 		v_where:=v_where||' And c.codigo = '''||p_cod_producto||''' '; 
	End If;	


--- VALORIZACION RUC
	if p_tipo_doc = '2' then		

			v_campos:='select 
				c.codigo::int codigo_producto,				
				c.denominacion descr_producto,
				v.id num_documento,				
				(case when descripcion is null then c.denominacion else v.descripcion end) desc_documento,
				v.fecha fecha_vencimiento,
				v.fecha_proceso fecha_emision, 				 
				v.monto deuda,
				0 mora,
				0 gastos_adm,
				0 pago_minimo,
				v.monto importe_total,
				DATE_PART(''month'', v.fecha_proceso) periodo,
				DATE_PART(''year'', v.fecha_proceso) anio,
				1 cuota, 
				v.id_moneda moneda_doc	,
				1 id_forma_pago,
				e.razon_social destinatario,
				v.monto suma_total_deuda
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                --left join personas p on p.id = v.id_persona 
                left join empresas e on e.id = v.id_empresa 				                           
                where 1=1
                and v.id_empresa = '''||_id_empresa||'''           
                and v.estado = ''1''            
                and v.pagado_post = ''0''
                and v.exonerado = ''0''               
                and (case when v.id_comprobante is null 
					then ''P'' 
				else 
					(select co.estado_pago from comprobantes co where co.id=v.id_comprobante limit 1)
				end) = ''P''                
            order by v.fecha desc			 
			limit '''||p_limit||''' '; 

--- VALORIZACION RUC , LIQUIDACION            
	elseif p_tipo_doc = '87' and _id_empresa <> 0 then

			v_campos:='select 
				c.codigo::int codigo_producto,				
				c.denominacion descr_producto,
				v.id num_documento,				
				(case when descripcion is null then c.denominacion else v.descripcion end) desc_documento,
				v.fecha fecha_vencimiento,
				v.fecha_proceso fecha_emision, 				 
				v.monto deuda,
				0 mora,
				0 gastos_adm,
				0 pago_minimo,
				v.monto importe_total,
				DATE_PART(''month'', v.fecha_proceso) periodo,
				DATE_PART(''year'', v.fecha_proceso) anio,
				1 cuota, 
				v.id_moneda moneda_doc	,
				1 id_forma_pago,
				e.razon_social destinatario,
				v.monto suma_total_deuda
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                left join liquidaciones l  on l.id = v.pk_registro and v.id_modulo = 7
                left join empresas e on e.id = v.id_empresa 				                           
                where 1=1
                and v.id_empresa = '''||_id_empresa||'''           
                and v.estado = ''1''            
                and v.pagado_post = ''0''
                and v.exonerado = ''0''
				and l.estado = ''1''
                and l.credipago = '''||p_numero_doc||'''               
                and (case when v.id_comprobante is null 
					then ''P'' 
				else 
					(select co.estado_pago from comprobantes co where co.id=v.id_comprobante limit 1)
				end) = ''P''                
            order by v.fecha desc			 
			limit '''||p_limit||''' '; 

            
--- VALORIZACION DNI , LIQUIDACION 
	elseif p_tipo_doc = '87' and _id_persona <> 0 then  
			v_campos:='select 
				c.codigo codigo_producto,				
				c.denominacion descr_producto,
				v.id num_documento,				
				(case when descripcion is null then c.denominacion else v.descripcion end) desc_documento,
				v.fecha fecha_vencimiento,
				v.fecha_proceso fecha_emision, 				 
				v.monto deuda,
				0 mora,
				0 gastos_adm,
				0 pago_minimo,
				v.monto importe_total,
				DATE_PART(''month'', v.fecha_proceso) periodo,
				DATE_PART(''year'', v.fecha_proceso) anio,
				1 cuota, 
				v.id_moneda moneda_doc	,
				1 id_forma_pago,
				v.id_persona, 
				p.apellido_paterno ||'' ''||p.apellido_materno||'' ''||p.nombres destinatario,
				v.monto suma_total_deuda
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                left join personas p on p.id = v.id_persona
				left join liquidaciones l  on l.id = v.pk_registro and v.id_modulo = 7                  				                           
                where 1=1            
                and  v.id_persona = = '''||_id_persona||'''
                and v.estado = ''1''            
                and v.pagado_post = ''0''
                and v.exonerado = ''0''  
				and l.estado = ''1''
                and l.credipago = '''||p_numero_doc||'''               
                and (case when v.id_comprobante is null 
					then ''P'' 
				else 
					(select co.estado_pago from comprobantes co where co.id=v.id_comprobante limit 1)
				end) = ''P''                
            order by v.fecha desc			 
			limit '''||p_limit||''' '; 

--- VALORIZACION DNI
	else 

		 v_campos:='select 
				c.codigo codigo_producto,				
				c.denominacion descr_producto,
				v.id num_documento,				
				(case when descripcion is null then c.denominacion else v.descripcion end) desc_documento,
				v.fecha fecha_vencimiento,
				v.fecha_proceso fecha_emision, 				 
				v.monto deuda,
				0 mora,
				0 gastos_adm,
				0 pago_minimo,
				v.monto importe_total,
				DATE_PART(''month'', v.fecha_proceso) periodo,
				DATE_PART(''year'', v.fecha_proceso) anio,
				1 cuota, 
				v.id_moneda moneda_doc	,
				1 id_forma_pago,
				v.id_persona, 
				p.apellido_paterno ||'' ''||p.apellido_materno||'' ''||p.nombres destinatario				           
			from valorizaciones v
				inner join conceptos c  on c.id = v.id_concepto
				inner join personas p on p.id = v.id_persona 
				left join comprobantes co on v.id_comprobante=co.id and co.estado_pago=''C'' 				                           
            where 1=1
				and co.id is null            
                and  v.id_persona =  '''||_id_persona||'''
                and v.estado = ''1''                         
                and v.exonerado =  ''0''
				and v.pagado_post in (''0'',''2'',''3'')
				'||v_where||'
            order by v.fecha desc
			limit '''||p_limit||''' ';  



	end if;
		
	--v_scad:=v_campos; 
	--Raise Notice '%',v_campos;
	Open p_ref For Execute(v_campos);
	Return p_ref;
End
$function$
;
