-- DROP FUNCTION public.sp_actualiza_pago_pos(varchar, varchar, _varchar, refcursor);

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

_serie character varying;
_tipo character varying;
_moneda character varying;
_correo character varying;
_direccion character varying;
_razon_social character varying;
_ruc character varying;
_decimal_letras character varying;
_total_letras character varying;
_cod_contable character varying;

_id_moneda integer;
_numero integer;
_descuento numeric;
_monto numeric;
_total numeric;
_subtotal numeric;
_igv numeric;
_pu numeric;
_pu_con_igv numeric;
_importe_total numeric;
_id_tipo_afectacion integer;

idp integer;
_id_caja integer;
_id_usuario integer;
_cantidad integer;

Begin

	_id_valorizacion:= '';
	_serie:= 'B041';
	_tipo:= 'BV';
	_descuento:= 0;
	_id_caja:= 0;
	_id_usuario:= 1;
	_total:= 0;
	_id_tipo_afectacion:= 10;
	_cantidad = 1;

	--------reemplazar
	desc_documento := '';
	id_forma_pago  := 1;

	if array_length(p_detalle, 1)>0 then 
		
		for i in array_lower(p_detalle, 1) .. array_upper(p_detalle, 1) loop 
	
			codigo_producto := p_detalle[i][1];				
			--descr_producto := p_detalle[i][2];
			num_documento := p_detalle[i][2];			
			--desc_documento := p_detalle[i][4];
			fecha_vencimiento := p_detalle[i][4];
			fecha_emision := p_detalle[i][5]; 				 
			deuda := p_detalle[i][6];
			mora := p_detalle[i][7];
			gastos_adm := p_detalle[i][8];
			--pago_minimo := p_detalle[i][10];
			importe_total := p_detalle[i][9];
			periodo:= p_detalle[i][10];
			anio := p_detalle[i][11];
			cuota := p_detalle[i][12]; 
			moneda_doc := p_detalle[i][13];
			--id_forma_pago := p_detalle[i][16];
			--destinatario := p_detalle[i][17];
			--suma_total_deuda := p_detalle[i][18];
	
			_id_valorizacion:=_id_valorizacion || ',' || num_documento;
			_importe_total := to_number(importe_total,'9999999999.99');
			_total:= _total + _importe_total;
	
			update valorizaciones set pagado_post = '1'
			where id = num_documento::int;						
		end loop;



		SELECT p.numero_documento, p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres, p.direccion, v.monto, m.abreviatura, v.id_moneda, p.correo, c.id_tipo_afectacion 
			   into _ruc, _razon_social, _direccion, _monto, _moneda, _id_moneda, _correo, _id_tipo_afectacion
		FROM valorizaciones v
		inner join personas p on p.id = v.id_persona
		left join tabla_maestras m on m.codigo::int = v.id_moneda and m.tipo='1'
		left join conceptos c on c.id = v.id_concepto
		where v.id=num_documento::int ;
		Raise Notice '%',num_documento;
		
		if _id_tipo_afectacion = 30  then			
			_subtotal := CAST(_total AS numeric);
			_igv := 0;
		else					
			_subtotal := round(_total/1.18,2);
			_igv := round((_total/1.18)*0.18,2);				
		end if;


		if trunc(_total) = 0 Then
			select substr(CAST(_total AS varchar),3) into _decimal_letras;
		else
			select substr(CAST(mod(_total,trunc(_total)) AS varchar),3) into _decimal_letras;
		End if;
		
		select upper(f_convnl(trunc(_total))) || ' CON '|| Case When _decimal_letras = '' Then '0' Else _decimal_letras End ||'/100 '||_moneda into _total_letras;

		select coalesce(max(fi.numero),'0')+1 into _numero from comprobantes fi where fi.serie = _serie;

		if (select count(id) from comprobantes f where f.serie = _serie And f.numero=_numero)=0 then
	
			if (select count(id) from comprobantes f where f.serie = _serie  and f.fecha BETWEEN NOW() - INTERVAL '3 SECONDS' AND NOW())=0 then
				
				Raise Notice '%Ingresa',_serie;

				Insert Into comprobantes (serie, numero, fecha, destinatario, direccion, cod_tributario, serie_guia,nro_guia, total_grav, total_inaf, total_exo, impuesto,
				 total, letras, moneda, impuesto_factor, tipo_cambio, estado_pago, anulado, fecha_pago, fecha_recepcion, fecha_vencimiento,
				 fecha_programado, observacion, id_moneda, tipo, id_forma_pago, afecta, cerrado, id_tipo_documento,serie_ncnd ,id_numero_ncnd ,tipo_ncnd,
				 solictante,orden_compra,  total_anticipo, total_descuentos, desc_globales,monto_perce, monto_detrac, porc_detrac, totalconperce, tipo_guia,
				 serie_refer, nro_refer, tipo_refer, codtipo_ncnd, motivo_ncnd, correo_des, tipo_operacion, base_perce, tipo_emision, ope_gratuitas,
				 subtotal, codigo_bbss_detrac, cuenta_detrac, notas, cond_pago, id_caja, id_usuario_inserta)					
				Values (_serie, _numero, now(), _razon_social, _direccion, _ruc,'', '',CAST(_total AS numeric),0.00,0.00,_igv, 
				 CAST(_total AS numeric),_total_letras,_moneda,18,0.000,'P','N',now(),now(),
				 now(),now(),'',_id_moneda, _tipo, 1, '', 'S',6,'',0,'','','',0.00, _descuento, 0.00, 0.00, 0.00, 0, CAST(_total AS numeric), '', '', '', '', '', '', _correo, '01',CAST(_total AS numeric), 'SINCRONO', 0, 
				 _subtotal, 
				 '', '', '', '', _id_caja, _id_usuario) RETURNING id into idp;

			update valorizaciones set id_comprobante = idp, pagado='1' where id = num_documento::int;


			else 				
				select id into idp from comprobantes f where f.serie = _serie and f.fecha BETWEEN NOW() - INTERVAL '5 MINUTE' AND NOW() order by id desc limit 1;			
			End if;
		else 			
			select id into idp from comprobantes f where f.serie = _serie And f.numero=_numero order by id desc limit 1;		
		End if;


			_total:= 0;
			_importe_total := 0;
 
			if array_length(p_detalle, 1)>0 then 
				for i in array_lower(p_detalle, 1) .. array_upper(p_detalle, 1) loop 
						
					codigo_producto := p_detalle[i][1];				
					--descr_producto := p_detalle[i][2];
					num_documento := p_detalle[i][2];			
					--desc_documento := p_detalle[i][4];
					fecha_vencimiento := p_detalle[i][4];
					fecha_emision := p_detalle[i][5]; 				 
					deuda := p_detalle[i][6];
					mora := p_detalle[i][7];
					gastos_adm := p_detalle[i][8];
					--pago_minimo := p_detalle[i][10];
					importe_total := p_detalle[i][9];
					periodo:= p_detalle[i][10];
					anio := p_detalle[i][11];
					cuota := p_detalle[i][12]; 
					moneda_doc := p_detalle[i][13];
					--id_forma_pago := p_detalle[i][16];
					--destinatario := p_detalle[i][17];
					--suma_total_deuda := p_detalle[i][18];

					_importe_total := to_number(importe_total,'9999999999.99');
					_total:= _total + _importe_total;
					
					if _cod_contable='0' then _cod_contable=''; end if;

					if _id_tipo_afectacion = 30  then
						_pu := _total;
						_igv := 0;
						_pu_con_igv := _pu + _igv;
						
					else
						_pu := round(_total/1.18,2);
						_igv := round((_total/1.18)*0.18,2);
						_pu_con_igv := round(_total/1.18);
						
						_id_tipo_afectacion := 10;
					end if;

				


				Insert Into comprobante_detalles (serie, numero, tipo, item, cantidad, descripcion,
					pu,  pu_con_igv,  igv_total, descuento, importe,afect_igv, cod_contable, valor_gratu, unidad,id_usuario_inserta,id_comprobante)
					Values (_serie, _numero, _tipo, 1,_cantidad,desc_documento,
					_pu, _pu_con_igv,_igv, _descuento, (_cantidad *_total - _descuento)  ,_id_tipo_afectacion,_cod_contable,0,'ZZ',1, 1);

									
				end loop;
			end if;






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
				05 periodo,
				2025 anio,
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
