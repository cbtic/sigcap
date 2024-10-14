
CREATE OR REPLACE FUNCTION public.sp_actualiza_pago_pos(p_tipo_doc character varying, p_numero_doc character varying, p_cod_producto character varying, p_opcion character varying, p_detalle character varying[], p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare

codigo_producto character varying;				
descr_producto character varying;
num_documento character varying;				
desc_documento character varying;
fecha_vencimiento character varying;
fecha_emision character varying; 				 
deuda character varying;
mora character varying;
gastos_adm character varying;
pago_minimo character varying;
importe_total character varying;
periodo character varying;
anio character varying;
cuota character varying; 
moneda_doc character varying;
id_forma_pago character varying;
destinatario character varying;

v_campos varchar;
v_scad varchar;
_id_valorizacion character varying;
v_where varchar;

/*
0 pendiente 
1 pagado -
2 anulación de pago
3 extorno de pago
4 extorno de anulación -
*/

Begin
	_id_valorizacion:= '';

	v_where = ' ';
	If p_cod_producto <> '' Then
 		v_where:=v_where||' And c.codigo = '''||p_cod_producto||''' '; 
	End If;	


	if array_length(p_detalle, 1)>0 then 
		for i in array_lower(p_detalle, 1) .. array_upper(p_detalle, 1) loop 

			codigo_producto := p_detalle[i][1];
			num_documento := p_detalle[i][2];
			fecha_vencimiento := p_detalle[i][3];
			fecha_emision := p_detalle[i][4];
			deuda := p_detalle[i][5];
			mora := p_detalle[i][6];
			gastos_adm := p_detalle[i][7];
			importe_total := p_detalle[i][8];
			periodo := p_detalle[i][9];
			anio := p_detalle[i][10];
			cuota := p_detalle[i][11];
			moneda_doc := p_detalle[i][12];

			_id_valorizacion:=_id_valorizacion || ',' || num_documento;
										
			update valorizaciones set pagado_post = p_opcion
			where id = num_documento::int;
						
		end loop;
	end if;

	_id_valorizacion = SUBSTRING (_id_valorizacion, 2, LENGTH(_id_valorizacion));

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
             where v.id in ('''||_id_valorizacion||''') 
				'||v_where||' 

			';
			


	Open p_ref For Execute(v_campos);
	Return p_ref;
End
$function$
;

