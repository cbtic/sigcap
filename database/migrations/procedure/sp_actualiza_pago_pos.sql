CREATE OR REPLACE FUNCTION public.sp_actualiza_pago_pos(p_tipo_doc character varying, p_numero_doc character varying, p_detalle character varying[], p_ref refcursor)
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
suma_total_deuda character varying;

_id_valorizacion character varying;

v_campos varchar;
v_scad varchar;

Begin

_id_valorizacion:= '';

	if array_length(p_detalle, 1)>0 then 
		for i in array_lower(p_detalle, 1) .. array_upper(p_detalle, 1) loop 
	
			codigo_producto := p_detalle[i][1];				
			descr_producto := p_detalle[i][2];
			num_documento := p_detalle[i][3];			
			desc_documento := p_detalle[i][4];
			fecha_vencimiento := p_detalle[i][5];
			fecha_emision := p_detalle[i][6]; 				 
			deuda := p_detalle[i][7];
			mora := p_detalle[i][8];
			gastos_adm := p_detalle[i][9];
			pago_minimo := p_detalle[i][10];
			importe_total := p_detalle[i][11];
			periodo:= p_detalle[i][12];
			anio := p_detalle[i][13];
			cuota := p_detalle[i][14]; 
			moneda_doc := p_detalle[i][15];
			id_forma_pago := p_detalle[i][16];
			destinatario := p_detalle[i][17];
			suma_total_deuda := p_detalle[i][18];
	
			_id_valorizacion:=_id_valorizacion || ',' || num_documento; 
			/*	
			update valorizaciones set pagado_post = '1'
			where id = num_documento::int;			
			*/
		end loop;
	end if;

		_id_valorizacion:= RIGHT(_id_valorizacion, LENGTH(_id_valorizacion) - 1);

		 v_campos:='select 
				c.codigo::int codigo_producto,				
				c.denominacion descr_producto,
				v.id num_documento,				
				(case when descripcion is null then c.denominacion else v.descripcion end) desc_documento,
				v.fecha fecha_vencimiento,
				v.fecha_proceso fecha_emision, 				 
				f.total deuda,
				0 mora,
				0 gastos_adm,
				0 pago_minimo,
				f.total importe_total,
				12 periodo,
				2024 anio,
				1 cuota, 
				v.id_moneda moneda_doc,
				id_forma_pago,
				f.destinatario,
				v.monto suma_total_deuda			 	           
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
				inner join comprobantes f  on  f.id = v.id_comprobante            
            where v.id in ('''||_id_valorizacion||''')             			
            order by v.fecha desc';  



	--v_scad:=v_campos; 
	--Raise Notice '%',v_campos;
	Open p_ref For Execute(v_campos);
	Return p_ref;
End
$function$
;