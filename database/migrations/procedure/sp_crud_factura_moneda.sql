-- DROP FUNCTION public.sp_crud_factura_moneda(varchar, int4, varchar, int4, int4, varchar, varchar, varchar, int4, int4, numeric, varchar, int4, int4);

CREATE OR REPLACE FUNCTION public.sp_crud_factura_moneda(serie character varying, numero integer, tipo character varying, ubicacion integer, persona integer, total character varying, descripcion character varying, cod_contable character varying, id_v integer, id_caja integer, descuento numeric, accion character varying, p_id_usuario integer, p_id_moneda integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	_numero integer;
	idp integer;

	_ruc character varying;
	_razon_social character varying;
	_direccion character varying;
	_correo character varying;

	_ruc2 character varying;
	_razon_social2 character varying;
	_direccion2 character varying;
	_correo2 character varying;

	_ruc_t character varying;
	_razon_social_t character varying;
	_direccion_t character varying;
	_correo_t character varying;


	_total numeric;
	_total_letras character varying;
	_decimal_letras character varying;
	_total_sm numeric;
	_nombres character varying;
	_id_valoriza integer;
	_id_valoriza_act integer;

	_cuenta_s integer;
	_cuenta_t integer;

	_total_smr numeric;
	_descuento numeric;
	_moneda character varying;
	_serie character varying;

	_pu numeric;
	_pu_con_igv numeric;
	_igv_total numeric;

	_subtotal numeric;

	_id_tipo_afectacion integer;

	persona2 integer;

	ubicacion2 integer;

begin
		
	_serie:=serie;

	_id_tipo_afectacion:=0;

	--select CAST(total AS numeric) into _total;
	_total := to_number(total,'9999999999.99');
	select CAST(descuento AS numeric) into _descuento;

	Case accion

		When 'f' then
		
			ubicacion2:=descripcion::integer;
			persona2:=cod_contable::integer;
		
			
			if p_id_moneda = 1 then
				_moneda:='SOLES';
			else
				_moneda:='DOLARES';
			end if;
		
			if ubicacion > 0 Then

				if trunc(_total) = 0 Then
					select substr(CAST(_total AS varchar),3) into _decimal_letras;
				else
					select substr(CAST(mod(_total,trunc(_total)) AS varchar),3) into _decimal_letras;
				End if;

				if tipo = 'FT' and  ubicacion > 0  Then
					select t2.ruc, t2.razon_social, (case when t2.direccion = 'Direccion' then '' else t2.direccion end) direccion, t2.email into  _ruc,_razon_social, _direccion, _correo
						from empresas t2						
						Where t2.id=ubicacion;
				end if;
			
				if tipo = 'FT' and  persona > 0  Then
					select numero_ruc, apellido_paterno || ' '|| apellido_materno || ' '|| nombres,  direccion, correo email into  _ruc, _razon_social, _direccion, _correo
						from personas
						Where id=persona;
				end if;

				if tipo = 'BV' and  persona > 0  Then
					select numero_documento, apellido_paterno || ' '|| apellido_materno || ' '|| nombres,  direccion, correo email into  _ruc, _razon_social, _direccion, _correo
						from personas
						Where id=persona;
				end if;
			
				if tipo = 'FT' and  ubicacion2 > 0  Then
					select t2.ruc, t2.razon_social, (case when t2.direccion = 'Direccion' then '' else t2.direccion end) direccion, t2.email into  _ruc2,_razon_social2, _direccion2, _correo2
						from empresas t2						
						Where t2.id=ubicacion2;
				end if;
			
				if tipo = 'BV' and  persona2 > 0  Then
					select numero_documento, apellido_paterno || ' '|| apellido_materno || ' '|| nombres,  direccion, correo email into  _ruc2, _razon_social2, _direccion2, _correo2
						from personas
						Where id=persona2;
				end if;
			
				if ubicacion2 > 0 or  persona2 > 0 then 
					_ruc_t := _ruc;
					_razon_social_t := _razon_social;
					_direccion_t := _direccion;
					_correo_t := _correo;

					_ruc := _ruc2;
					_razon_social := _razon_social2;
					_direccion := _direccion2;
					_correo := _correo2;

					_ruc2 := _ruc_t;
					_razon_social2 := _razon_social_t;
					_direccion2 := _direccion_t;
					_correo2 := _correo_t;			
				
				else
					_ruc2 := '';
					_razon_social2 := '';
					_direccion2 := '';
					_correo2 := '';
				
				end if;
			
			
			
			

				select upper(f_convnl(trunc(_total))) || ' CON '|| Case When _decimal_letras = '' Then '0' Else _decimal_letras End ||'/100 '||_moneda into _total_letras;
			

/*			
				if _descuento=0 then
					_pu := _total/1.18;
					_subtotal := _total/1.18;
					_igv_total := (_total/1.18)*0.18;
				else
					_pu := 0;
					_subtotal := CAST(total AS numeric);
					_igv_total := 0;
				end if;
	*/		
			
				_id_tipo_afectacion:= numero;
			
				if _id_tipo_afectacion = 30  then			
					_subtotal := CAST(total AS numeric);
					_igv_total := 0;
				else					
					_subtotal := _total/1.18;
					_igv_total := (_total/1.18)*0.18;				
				end if;

				Insert Into comprobantes (serie, numero, fecha, destinatario, direccion, cod_tributario, serie_guia,nro_guia, total_grav, total_inaf, total_exo, impuesto,
						total, letras, moneda, impuesto_factor, tipo_cambio, estado_pago, anulado, fecha_pago, fecha_recepcion, fecha_vencimiento,
						fecha_programado, observacion, id_moneda, tipo, id_forma_pago, afecta, cerrado, id_tipo_documento,serie_ncnd ,id_numero_ncnd ,tipo_ncnd,
						solictante,orden_compra,  total_anticipo, total_descuentos, desc_globales,monto_perce, monto_detrac, porc_detrac, totalconperce, tipo_guia,
						serie_refer, nro_refer, tipo_refer, codtipo_ncnd, motivo_ncnd, correo_des, tipo_operacion, base_perce, tipo_emision, ope_gratuitas,
						subtotal, codigo_bbss_detrac, cuenta_detrac, notas, cond_pago, id_caja, id_usuario_inserta, cod_tributario_2, destinatario_2, direccion_2, correo_des_2)
						
					Values (serie,(select coalesce(max(fi.numero),'0')+1 from comprobantes fi where fi.serie = _serie),now(),_razon_social,_direccion,_ruc,'', '',
						CAST(total AS numeric),0.00,0.00,
						_igv_total, --((CAST(total AS numeric)/1.18)*0.18),
						CAST(total AS numeric),_total_letras,_moneda,18,0.000,'P','N',now(),now(),
						now(),now(),'',p_id_moneda, tipo, 1, '', 'S',6,'',0,'','','',0.00, _descuento, 0.00, 0.00, 0.00, 0, CAST(total AS numeric), '', '', '', '', '', '', _correo, '01',CAST(total AS numeric), 'SINCRONO', 0, 
						_subtotal, --CAST(total AS numeric)/1.18, 
						'', '', '', '', id_caja, p_id_usuario, _ruc2, _razon_social2, _direccion2, _correo2);

				idp := (SELECT currval('comprobantes_id_seq'));

			Else
				idp:=0;
			End if;
		When 'd' then

			if numero > 0 then
				/*	
				if _descuento=0  then
					_pu := _total/1.18;
					_pu_con_igv := _total/1.18;
					_igv_total := (_total/1.18)*0.18;
				else
					_pu := 0;
					_pu_con_igv := 0;
					_igv_total := 0;
				end if;
			*/
				select id_tipo_afectacion into  _id_tipo_afectacion
				from conceptos 						
				Where id = persona;
			
				if _id_tipo_afectacion = 30  then
					_pu := _total;
					_igv_total := 0;
					_pu_con_igv := _pu + _igv_total;
					
				else
					_pu := _total/1.18;
					_igv_total := (_total/1.18)*0.18;
					_pu_con_igv := _total/1.18;
					
					_id_tipo_afectacion := 10;
				end if;
			
			
				Insert Into comprobante_detalles (serie, numero, tipo, item, cantidad, descripcion,
					pu,  pu_con_igv,  igv_total, descuento, importe,afect_igv, cod_contable, valor_gratu, unidad,id_usuario_inserta,id_comprobante, id_concepto)
					Values (_serie,numero,tipo,id_v,ubicacion,descripcion,
					_pu, _pu_con_igv,_igv_total, _descuento, (_total - _descuento)  ,_id_tipo_afectacion,cod_contable,0,'ZZ',p_id_usuario, id_caja, persona);
				
				--update valorizaciones Set id_comprobante  = id_caja, pagado = '1' where id = id_v;
								
				idp:=numero;

			Else
				idp:=0;
			End if;

	End Case;

	return idp;
/*
	EXCEPTION
	WHEN OTHERS THEN
        idp:=-1;

	return idp;
*/

/*
Select sp_crud_factura_moneda('B001',0, 'BV',3070,  924,'17.50','119','',0,0,0,'f',1,1);

Select sp_crud_factura('T001',0, 'TK', 3070,924,'17.50','119','',0,0,0,0,0,'f',2);
Select sp_crud_factura('T001',6281, 'TK', 1,0,'17.50','LBSP SERVICIO','7040205',8824,1,1,5,50,'d',2);
Select sp_crud_factura('T001',6281, 'TK', 1,0,'17.50','LBSP SERVICIO','7040205',8824,1,1,4,50,'d',2);
Select sp_crud_factura('T001',6281, 'TK', 1,0,'17.50','LBSP SERVICIO','7040205',8824,1,1,1,50,'d',2);

Select sp_crud_factura(T001,0, TK, 3070,2449,10,121,,0,0,0,0,0,f,2)
Select sp_crud_factura('T001',2870, 'TK', 1,0,'2','LBCA SERVICIO','7040204',8390,1,1,4,0,'d',2);

select * from valorizaciones order by 1 desc limit 10;

select * from valorizaciones where  val_codigo = 8824 order by 1 desc limit 100;

select * from val_atencion_smodulos where vsm_vnumero = 9607  limit 100;

select * from comprobante_detalles where numero = 6281
delete from comprobante_detalles where numero = 6281
"9315"

select * from comprobantes;
select * from comprobante_detalles;

select * from valorizaciones

delete from ind_atenciones;
delete from ind_atencion_modulos;
delete from ind_atencion_smodulos;
delete from valorizaciones;
delete from val_atencion_modulos;
delete from val_atencion_smodulos;

TRUNCATE TABLE ind_atenciones RESTART IDENTITY;
TRUNCATE TABLE ind_atencion_modulos RESTART IDENTITY;
TRUNCATE TABLE ind_atencion_smodulos RESTART IDENTITY;

TRUNCATE TABLE valorizaciones RESTART IDENTITY;
TRUNCATE TABLE val_atencion_modulos RESTART IDENTITY;
TRUNCATE TABLE val_atencion_smodulos RESTART IDENTITY;

delete from comprobantes;
delete from comprobante_detalles;

TRUNCATE TABLE comprobantes RESTART IDENTITY;

delete  from comprobantes;
TRUNCATE TABLE comprobante_detalles RESTART IDENTITY;

*/

end;
$function$
;
