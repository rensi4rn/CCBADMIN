/********************************************I-DEP-RAC-WF-0-08/03/2015*************************************/

--------------- SQL ---------------

ALTER TABLE ccb.tobrero
  ADD CONSTRAINT tobrero__id_region_fk FOREIGN KEY (id_region)
    REFERENCES ccb.tregion(id_region)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
    
--------------- SQL ---------------

ALTER TABLE ccb.tobrero
  ADD CONSTRAINT tobrero__id_casa_oracion_fk FOREIGN KEY (id_casa_oracion)
    REFERENCES ccb.tcasa_oracion(id_casa_oracion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;


--------------- SQL ---------------

ALTER TABLE ccb.tobrero
  ADD CONSTRAINT tobrero__id_persona_fk FOREIGN KEY (id_persona)
    REFERENCES segu.tpersona(id_persona)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;


--------------- SQL ---------------

ALTER TABLE ccb.tdetalle_evento
  ADD CONSTRAINT tdetalle_evento__id_region_evento_fk FOREIGN KEY (id_region_evento)
    REFERENCES ccb.tregion_evento(id_region_evento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.tdetalle_evento
  ADD CONSTRAINT tdetalle_evento_id_tipo_ministerio_fk FOREIGN KEY (id_tipo_ministerio)
    REFERENCES ccb.ttipo_ministerio(id_tipo_ministerio)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;    

--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD CONSTRAINT tmovimiento_id_casa_oracion_fk FOREIGN KEY (id_casa_oracion)
    REFERENCES ccb.tcasa_oracion(id_casa_oracion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD CONSTRAINT tmovimiento__id_estado_periodo_fk FOREIGN KEY (id_estado_periodo)
    REFERENCES ccb.testado_periodo(id_estado_periodo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento_det
  ADD CONSTRAINT tmovimiento_det__id_movimiento_fk FOREIGN KEY (id_movimiento)
    REFERENCES ccb.tmovimiento(id_movimiento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento_det
  ADD CONSTRAINT tmovimiento_det_fk FOREIGN KEY (id_tipo_movimiento)
    REFERENCES ccb.ttipo_movimiento(id_tipo_movimiento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    

--------------- SQL ---------------

ALTER TABLE ccb.tusuario_permiso
  ADD CONSTRAINT tusuario_permiso__id_region_fk FOREIGN KEY (id_region)
    REFERENCES ccb.tregion(id_region)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;



--------------- SQL ---------------

ALTER TABLE ccb.tusuario_permiso
  ADD CONSTRAINT tusuario_permiso__id_casa_oracion_ FOREIGN KEY (id_casa_oracion)
    REFERENCES ccb.tcasa_oracion(id_casa_oracion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.tobrero
  ADD CONSTRAINT tobrero__id_tipo_ministerio_fk FOREIGN KEY (id_tipo_ministerio)
    REFERENCES ccb.ttipo_ministerio(id_tipo_ministerio)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;    


--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD CONSTRAINT tregion_evento__id_gestion_fk FOREIGN KEY (id_gestion)
    REFERENCES ccb.tgestion(id_gestion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    


--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD CONSTRAINT tregion_evento__id_casa_oracion_fk FOREIGN KEY (id_casa_oracion)
    REFERENCES ccb.tcasa_oracion(id_casa_oracion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD CONSTRAINT tregion_evento__id_region_fk FOREIGN KEY (id_region)
    REFERENCES ccb.tregion(id_region)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;    


--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD CONSTRAINT tregion_evento__id_evento_fk FOREIGN KEY (id_evento)
    REFERENCES ccb.tevento(id_evento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.testado_periodo
  ADD CONSTRAINT testado_periodo__id_gestion_fk FOREIGN KEY (id_gestion)
    REFERENCES ccb.tgestion(id_gestion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
--------------- SQL ---------------

ALTER TABLE ccb.testado_periodo
  ADD CONSTRAINT testado_periodo__casa_oracion_fk FOREIGN KEY (id_casa_oracion)
    REFERENCES ccb.tcasa_oracion(id_casa_oracion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;

--------------- SQL ---------------

ALTER TABLE ccb.tculto
  ADD CONSTRAINT tculto__id_casa_oracion_fk FOREIGN KEY (id_casa_oracion)
    REFERENCES ccb.tcasa_oracion(id_casa_oracion)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;




 
/********************************************F-DEP-RAC-WF-0-08/03/2015*************************************/



/********************************************I-DEP-RAC-WF-0-11/03/2015*************************************/


CREATE OR REPLACE VIEW ccb.vevento_bautizo_santa_cena(
    fecha_programada,
    estado,
    id_region_evento,
    id_casa_oracion,
    id_region,
    nombre_region,
    nombre_co,
    cantidad_hermano,
    cantidad_hermana,
    id_gestion,
    gestion,
    id_detalle_evento_hermano,
    id_detalle_evento_hermana,
    id_evento,
    codigo,
    nombre)
AS
  SELECT re.fecha_programada,
         re.estado,
         re.id_region_evento,
         re.id_casa_oracion,
         reg.id_region,
         reg.nombre AS nombre_region,
         co.nombre AS nombre_co,
         deh.cantidad AS cantidad_hermano,
         dee.cantidad AS cantidad_hermana,
         ges.id_gestion,
         ges.gestion,
         deh.id_detalle_evento AS id_detalle_evento_hermano,
         dee.id_detalle_evento AS id_detalle_evento_hermana,
         ev.id_evento,
         ev.codigo,
         ev.nombre
  FROM ccb.tregion_evento re
       JOIN ccb.tregion reg ON reg.id_region = re.id_region
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = re.id_casa_oracion
       JOIN ccb.tdetalle_evento deh ON deh.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm ON tm.id_tipo_ministerio =
         deh.id_tipo_ministerio AND tm.codigo::text = 'hermano'::text
       JOIN ccb.tdetalle_evento dee ON dee.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm2 ON tm2.id_tipo_ministerio =
         dee.id_tipo_ministerio AND tm2.codigo::text = 'hermana'::text
       JOIN ccb.tevento ev ON ev.id_evento = re.id_evento
       JOIN ccb.tgestion ges ON ges.id_gestion = re.id_gestion
  WHERE ev.codigo::text = 'bautizo'::text AND
        re.tipo_registro::text = 'detalle'::text;
/********************************************F-DEP-RAC-WF-0-11/03/2015*************************************/




/********************************************I-DEP-RAC-WF-0-17/03/2015*************************************/


CREATE OR REPLACE VIEW ccb.vevento_bautizo_santa_cena(
    fecha_programada,
    estado,
    id_region_evento,
    id_casa_oracion,
    id_region,
    nombre_region,
    nombre_co,
    cantidad_hermano,
    cantidad_hermana,
    id_gestion,
    gestion,
    id_detalle_evento_hermano,
    id_detalle_evento_hermana,
    id_evento,
    codigo,
    nombre)
AS
  SELECT re.fecha_programada,
         re.estado,
         re.id_region_evento,
         re.id_casa_oracion,
         reg.id_region,
         reg.nombre AS nombre_region,
         co.nombre AS nombre_co,
         deh.cantidad AS cantidad_hermano,
         dee.cantidad AS cantidad_hermana,
         ges.id_gestion,
         ges.gestion,
         deh.id_detalle_evento AS id_detalle_evento_hermano,
         dee.id_detalle_evento AS id_detalle_evento_hermana,
         ev.id_evento,
         ev.codigo,
         ev.nombre
  FROM ccb.tregion_evento re
       JOIN ccb.tregion reg ON reg.id_region = re.id_region
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = re.id_casa_oracion
       JOIN ccb.tdetalle_evento deh ON deh.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm ON tm.id_tipo_ministerio =
         deh.id_tipo_ministerio AND tm.codigo::text = 'hermano'::text
       JOIN ccb.tdetalle_evento dee ON dee.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm2 ON tm2.id_tipo_ministerio =
         dee.id_tipo_ministerio AND tm2.codigo::text = 'hermana'::text
       JOIN ccb.tevento ev ON ev.id_evento = re.id_evento
       JOIN ccb.tgestion ges ON ges.id_gestion = re.id_gestion
  WHERE (ev.codigo::text = ANY (ARRAY [ 'bautizo'::text, 'santacena'::text ]))
  AND
        re.tipo_registro::text = 'detalle'::text;
        
/********************************************F-DEP-RAC-WF-0-17/03/2015*************************************/



/********************************************I-DEP-RAC-WF-0-18/03/2015*************************************/


--------------- SQL ---------------

 -- object recreation
DROP VIEW ccb.vevento_bautizo_santa_cena;


CREATE VIEW ccb.vevento_bautizo_santa_cena
AS
  SELECT re.fecha_programada,
         re.estado,
         re.id_region_evento,
         re.id_casa_oracion,
         reg.id_region,
         reg.nombre AS nombre_region,
         co.nombre AS nombre_co,
         deh.cantidad AS cantidad_hermano,
         dee.cantidad AS cantidad_hermana,
         ges.id_gestion,
         ges.gestion,
         deh.id_detalle_evento AS id_detalle_evento_hermano,
         dee.id_detalle_evento AS id_detalle_evento_hermana,
         ev.id_evento,
         ev.codigo,
         ev.nombre,
         re.id_usuario_mod,
         us.cuenta
  FROM ccb.tregion_evento re
       JOIN segu.tusuario us ON us.id_usuario = re.id_usuario_mod
       JOIN ccb.tregion reg ON reg.id_region = re.id_region
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = re.id_casa_oracion
       JOIN ccb.tdetalle_evento deh ON deh.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm ON tm.id_tipo_ministerio =
         deh.id_tipo_ministerio AND tm.codigo::text = 'hermano'::text
       JOIN ccb.tdetalle_evento dee ON dee.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm2 ON tm2.id_tipo_ministerio =
         dee.id_tipo_ministerio AND tm2.codigo::text = 'hermana'::text
       JOIN ccb.tevento ev ON ev.id_evento = re.id_evento
       JOIN ccb.tgestion ges ON ges.id_gestion = re.id_gestion
  WHERE (ev.codigo::text = ANY (ARRAY [ 'bautizo'::text, 'santacena'::text ]))
  AND
        re.tipo_registro::text = 'detalle'::text;
        
/********************************************F-DEP-RAC-WF-0-18/03/2015*************************************/



/********************************************I-DEP-RAC-WF-0-03/04/2015*************************************/

--------------- SQL ---------------

CREATE VIEW ccb.vobrero
AS 
select 
per.nombre_completo1,
per.id_persona,
o.id_obrero

from ccb.tobrero o
inner join segu.vpersona per on per.id_persona = o.id_persona ;


--------------- SQL ---------------

CREATE VIEW ccb.vmovimiento_ingreso (
    id_movimiento,
    estado_reg,
    tipo,
    id_casa_oracion,
    concepto,
    obs,
    fecha,
    id_estado_periodo,
    fecha_reg,
    id_usuario_reg,
    fecha_mod,
    id_usuario_mod,
    usr_reg,
    usr_mod,
    id_tipo_movimiento_mantenimiento,
    id_movimiento_det_mantenimiento,
    monto_mantenimiento,
    id_tipo_movimiento_especial,
    id_movimiento_det_especial,
    monto_especial,
    id_tipo_movimiento_piedad,
    id_movimiento_det_piedad,
    monto_piedad,
    id_tipo_movimiento_construccion,
    id_movimiento_det_construccion,
    monto_construccion,
    id_tipo_movimiento_viaje,
    id_movimiento_det_viaje,
    monto_viaje,
    monto_dia,
    id_obrero,
    desc_obrero,
    estado)
AS
SELECT mov.id_movimiento,
    mov.estado_reg,
    mov.tipo,
    mov.id_casa_oracion,
    mov.concepto,
    mov.obs,
    mov.fecha,
    mov.id_estado_periodo,
    mov.fecha_reg,
    mov.id_usuario_reg,
    mov.fecha_mod,
    mov.id_usuario_mod,
    usu1.cuenta AS usr_reg,
    usu2.cuenta AS usr_mod,
    tm1.id_tipo_movimiento AS id_tipo_movimiento_mantenimiento,
    md1.id_movimiento_det AS id_movimiento_det_mantenimiento,
    md1.monto AS monto_mantenimiento,
    tm2.id_tipo_movimiento AS id_tipo_movimiento_especial,
    md2.id_movimiento_det AS id_movimiento_det_especial,
    md2.monto AS monto_especial,
    tm3.id_tipo_movimiento AS id_tipo_movimiento_piedad,
    md3.id_movimiento_det AS id_movimiento_det_piedad,
    md3.monto AS monto_piedad,
    tm4.id_tipo_movimiento AS id_tipo_movimiento_construccion,
    md4.id_movimiento_det AS id_movimiento_det_construccion,
    md4.monto AS monto_construccion,
    tm5.id_tipo_movimiento AS id_tipo_movimiento_viaje,
    md5.id_movimiento_det AS id_movimiento_det_viaje,
    md5.monto AS monto_viaje,
    md1.monto + md2.monto + md3.monto + md4.monto + md5.monto AS monto_dia,
    mov.id_obrero,
    o.nombre_completo1 AS desc_obrero,
    mov.estado
FROM ccb.tmovimiento mov
     JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
     JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
     JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
     JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento =
         md1.id_tipo_movimiento AND tm1.codigo::text = 'mantenimiento'::text
     JOIN ccb.tmovimiento_det md2 ON md2.id_movimiento = mov.id_movimiento
     JOIN ccb.ttipo_movimiento tm2 ON tm2.id_tipo_movimiento =
         md2.id_tipo_movimiento AND tm2.codigo::text = 'especial'::text
     JOIN ccb.tmovimiento_det md3 ON md3.id_movimiento = mov.id_movimiento
     JOIN ccb.ttipo_movimiento tm3 ON tm3.id_tipo_movimiento =
         md3.id_tipo_movimiento AND tm3.codigo::text = 'piedad'::text
     JOIN ccb.tmovimiento_det md4 ON md4.id_movimiento = mov.id_movimiento
     JOIN ccb.ttipo_movimiento tm4 ON tm4.id_tipo_movimiento =
         md4.id_tipo_movimiento AND tm4.codigo::text = 'construccion'::text
     JOIN ccb.tmovimiento_det md5 ON md5.id_movimiento = mov.id_movimiento
     JOIN ccb.ttipo_movimiento tm5 ON tm5.id_tipo_movimiento =
         md5.id_tipo_movimiento AND tm5.codigo::text = 'viaje'::text
     LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
WHERE mov.tipo::text = 'ingreso'::text;
 

--------------- SQL ---------------

--------------- SQL ---------------


CREATE VIEW ccb.vmovimiento_egreso
  as SELECT mov.id_movimiento,
    mov.estado_reg,
    mov.tipo,
    mov.id_casa_oracion,
    mov.concepto,
    mov.obs,
    mov.fecha,
    mov.id_estado_periodo,
    mov.fecha_reg,
    mov.id_usuario_reg,
    mov.fecha_mod,
    mov.id_usuario_mod,
    usu1.cuenta AS usr_reg,
    usu2.cuenta AS usr_mod,
    tm1.id_tipo_movimiento AS id_tipo_movimiento,
    md1.id_movimiento_det AS id_movimiento_det,
    md1.monto AS monto,
    mov.id_obrero,
    o.nombre_completo1 AS desc_obrero,
    mov.estado,
    mov.tipo_documento,
    mov.num_documento,
    tm1.nombre as desc_tipo_movimiento
FROM ccb.tmovimiento mov
     JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
     JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
     JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
     JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento =
         md1.id_tipo_movimiento AND tm1.codigo::text = 'mantenimiento'::text
     LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
WHERE mov.tipo::text = 'egreso'::text;
                       
/********************************************F-DEP-RAC-WF-0-03/04/2015*************************************/


/********************************************I-DEP-RAC-WF-0-08/04/2015*************************************/


CREATE OR REPLACE VIEW ccb.vmovimiento_ingreso(
    id_movimiento,
    estado_reg,
    tipo,
    id_casa_oracion,
    concepto,
    obs,
    fecha,
    id_estado_periodo,
    fecha_reg,
    id_usuario_reg,
    fecha_mod,
    id_usuario_mod,
    usr_reg,
    usr_mod,
    id_tipo_movimiento_mantenimiento,
    id_movimiento_det_mantenimiento,
    monto_mantenimiento,
    id_tipo_movimiento_especial,
    id_movimiento_det_especial,
    monto_especial,
    id_tipo_movimiento_piedad,
    id_movimiento_det_piedad,
    monto_piedad,
    id_tipo_movimiento_construccion,
    id_movimiento_det_construccion,
    monto_construccion,
    id_tipo_movimiento_viaje,
    id_movimiento_det_viaje,
    monto_viaje,
    monto_dia,
    id_obrero,
    desc_obrero,
    estado,
    desc_casa_oracion,
    mes,
    estado_periodo,
    id_gestion,
    gestion)
AS
  SELECT mov.id_movimiento,
         mov.estado_reg,
         mov.tipo,
         mov.id_casa_oracion,
         mov.concepto,
         mov.obs,
         mov.fecha,
         mov.id_estado_periodo,
         mov.fecha_reg,
         mov.id_usuario_reg,
         mov.fecha_mod,
         mov.id_usuario_mod,
         usu1.cuenta AS usr_reg,
         usu2.cuenta AS usr_mod,
         tm1.id_tipo_movimiento AS id_tipo_movimiento_mantenimiento,
         md1.id_movimiento_det AS id_movimiento_det_mantenimiento,
         md1.monto AS monto_mantenimiento,
         tm2.id_tipo_movimiento AS id_tipo_movimiento_especial,
         md2.id_movimiento_det AS id_movimiento_det_especial,
         md2.monto AS monto_especial,
         tm3.id_tipo_movimiento AS id_tipo_movimiento_piedad,
         md3.id_movimiento_det AS id_movimiento_det_piedad,
         md3.monto AS monto_piedad,
         tm4.id_tipo_movimiento AS id_tipo_movimiento_construccion,
         md4.id_movimiento_det AS id_movimiento_det_construccion,
         md4.monto AS monto_construccion,
         tm5.id_tipo_movimiento AS id_tipo_movimiento_viaje,
         md5.id_movimiento_det AS id_movimiento_det_viaje,
         md5.monto AS monto_viaje,
         md1.monto + md2.monto + md3.monto + md4.monto + md5.monto AS monto_dia,
         mov.id_obrero,
         o.nombre_completo1 AS desc_obrero,
         mov.estado,
         co.nombre AS desc_casa_oracion,
         ep.mes,
         ep.estado_periodo,
         ges.id_gestion,
         ges.gestion
  FROM ccb.tmovimiento mov
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = mov.id_casa_oracion
       JOIN ccb.testado_periodo ep ON ep.id_estado_periodo =
         mov.id_estado_periodo
       JOIN ccb.tgestion ges ON ges.id_gestion = ep.id_gestion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
       JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
       JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento =
         md1.id_tipo_movimiento AND tm1.codigo::text = 'mantenimiento'::text
       JOIN ccb.tmovimiento_det md2 ON md2.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm2 ON tm2.id_tipo_movimiento =
         md2.id_tipo_movimiento AND tm2.codigo::text = 'especial'::text
       JOIN ccb.tmovimiento_det md3 ON md3.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm3 ON tm3.id_tipo_movimiento =
         md3.id_tipo_movimiento AND tm3.codigo::text = 'piedad'::text
       JOIN ccb.tmovimiento_det md4 ON md4.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm4 ON tm4.id_tipo_movimiento =
         md4.id_tipo_movimiento AND tm4.codigo::text = 'construccion'::text
       JOIN ccb.tmovimiento_det md5 ON md5.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm5 ON tm5.id_tipo_movimiento =
         md5.id_tipo_movimiento AND tm5.codigo::text = 'viaje'::text
       LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
  WHERE mov.tipo::text = 'ingreso'::text;
 
 
 CREATE OR REPLACE VIEW ccb.vmovimiento_egreso(
    id_movimiento,
    estado_reg,
    tipo,
    id_casa_oracion,
    concepto,
    obs,
    fecha,
    id_estado_periodo,
    fecha_reg,
    id_usuario_reg,
    fecha_mod,
    id_usuario_mod,
    usr_reg,
    usr_mod,
    id_tipo_movimiento,
    id_movimiento_det,
    monto,
    id_obrero,
    desc_obrero,
    estado,
    tipo_documento,
    num_documento,
    desc_tipo_movimiento,
    desc_casa_oracion,
    mes,
    estado_periodo,
    id_gestion,
    gestion)
AS
  SELECT mov.id_movimiento,
         mov.estado_reg,
         mov.tipo,
         mov.id_casa_oracion,
         mov.concepto,
         mov.obs,
         mov.fecha,
         mov.id_estado_periodo,
         mov.fecha_reg,
         mov.id_usuario_reg,
         mov.fecha_mod,
         mov.id_usuario_mod,
         usu1.cuenta AS usr_reg,
         usu2.cuenta AS usr_mod,
         tm1.id_tipo_movimiento,
         md1.id_movimiento_det,
         md1.monto,
         mov.id_obrero,
         o.nombre_completo1 AS desc_obrero,
         mov.estado,
         mov.tipo_documento,
         mov.num_documento,
         tm1.nombre AS desc_tipo_movimiento,
         co.nombre AS desc_casa_oracion,
         ep.mes,
         ep.estado_periodo,
         ges.id_gestion,
         ges.gestion
  FROM ccb.tmovimiento mov
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = mov.id_casa_oracion
       JOIN ccb.testado_periodo ep ON ep.id_estado_periodo =
         mov.id_estado_periodo
       JOIN ccb.tgestion ges ON ges.id_gestion = ep.id_gestion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
       JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
       JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento =
         md1.id_tipo_movimiento AND tm1.codigo::text = 'mantenimiento'::text
       LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
  WHERE mov.tipo::text = 'egreso'::text;
  
/********************************************F-DEP-RAC-WF-0-08/04/2015*************************************/



/********************************************I-DEP-RAC-WF-0-18/04/2015*************************************/

--------------- SQL ---------------

CREATE OR REPLACE VIEW ccb.vmovimiento_egreso(
    id_movimiento,
    estado_reg,
    tipo,
    id_casa_oracion,
    concepto,
    obs,
    fecha,
    id_estado_periodo,
    fecha_reg,
    id_usuario_reg,
    fecha_mod,
    id_usuario_mod,
    usr_reg,
    usr_mod,
    id_tipo_movimiento,
    id_movimiento_det,
    monto,
    id_obrero,
    desc_obrero,
    estado,
    tipo_documento,
    num_documento,
    desc_tipo_movimiento,
    desc_casa_oracion,
    mes,
    estado_periodo,
    id_gestion,
    gestion)
AS
  SELECT mov.id_movimiento,
         mov.estado_reg,
         mov.tipo,
         mov.id_casa_oracion,
         mov.concepto,
         mov.obs,
         mov.fecha,
         mov.id_estado_periodo,
         mov.fecha_reg,
         mov.id_usuario_reg,
         mov.fecha_mod,
         mov.id_usuario_mod,
         usu1.cuenta AS usr_reg,
         usu2.cuenta AS usr_mod,
         tm1.id_tipo_movimiento,
         md1.id_movimiento_det,
         md1.monto,
         mov.id_obrero,
         o.nombre_completo1 AS desc_obrero,
         mov.estado,
         mov.tipo_documento,
         mov.num_documento,
         tm1.nombre AS desc_tipo_movimiento,
         co.nombre AS desc_casa_oracion,
         ep.mes,
         ep.estado_periodo,
         ges.id_gestion,
         ges.gestion
  FROM ccb.tmovimiento mov
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = mov.id_casa_oracion
       JOIN ccb.testado_periodo ep ON ep.id_estado_periodo =
         mov.id_estado_periodo
       JOIN ccb.tgestion ges ON ges.id_gestion = ep.id_gestion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
       JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
       JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento = md1.id_tipo_movimiento 
       LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
  WHERE mov.tipo::text = 'egreso'::text;


/********************************************F-DEP-RAC-WF-0-18/04/2015*************************************/



/********************************************I-DEP-RAC-WF-0-21/04/2015*************************************/

CREATE OR REPLACE VIEW ccb.vevento_bautizo_santa_cena(
    fecha_programada,
    estado,
    id_region_evento,
    id_casa_oracion,
    id_region,
    nombre_region,
    nombre_co,
    cantidad_hermano,
    cantidad_hermana,
    id_gestion,
    gestion,
    id_detalle_evento_hermano,
    id_detalle_evento_hermana,
    id_evento,
    codigo,
    nombre,
    id_usuario_mod,
    cuenta,
    hora)
AS
  SELECT re.fecha_programada,
         re.estado,
         re.id_region_evento,
         re.id_casa_oracion,
         reg.id_region,
         reg.nombre AS nombre_region,
         co.nombre AS nombre_co,
         deh.cantidad AS cantidad_hermano,
         dee.cantidad AS cantidad_hermana,
         ges.id_gestion,
         ges.gestion,
         deh.id_detalle_evento AS id_detalle_evento_hermano,
         dee.id_detalle_evento AS id_detalle_evento_hermana,
         ev.id_evento,
         ev.codigo,
         ev.nombre,
         re.id_usuario_mod,
         us.cuenta,
         re.hora
  FROM ccb.tregion_evento re
       JOIN segu.tusuario us ON us.id_usuario = re.id_usuario_mod
       JOIN ccb.tregion reg ON reg.id_region = re.id_region
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = re.id_casa_oracion
       JOIN ccb.tdetalle_evento deh ON deh.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm ON tm.id_tipo_ministerio =
         deh.id_tipo_ministerio AND tm.codigo::text = 'hermano'::text
       JOIN ccb.tdetalle_evento dee ON dee.id_region_evento =
         re.id_region_evento
       JOIN ccb.ttipo_ministerio tm2 ON tm2.id_tipo_ministerio =
         dee.id_tipo_ministerio AND tm2.codigo::text = 'hermana'::text
       JOIN ccb.tevento ev ON ev.id_evento = re.id_evento
       JOIN ccb.tgestion ges ON ges.id_gestion = re.id_gestion
  WHERE (ev.codigo::text = ANY (ARRAY [ 'bautizo'::text, 'santacena'::text ]))
  AND
        re.tipo_registro::text = 'detalle'::text;
        
/********************************************F-DEP-RAC-WF-0-21/04/2015*************************************/



/********************************************I-DEP-RAC-WF-0-01/05/2015*************************************/

CREATE OR REPLACE VIEW ccb.vmovimiento_ingreso_x_colecta(
    id_movimiento,
    estado_reg,
    tipo,
    id_casa_oracion,
    concepto,
    obs,
    fecha,
    id_estado_periodo,
    fecha_reg,
    id_usuario_reg,
    fecha_mod,
    id_usuario_mod,
    usr_reg,
    usr_mod,
    id_tipo_movimiento,
    id_movimiento_det,
    monto,
    id_obrero,
    desc_obrero,
    estado,
    tipo_documento,
    num_documento,
    desc_tipo_movimiento,
    desc_casa_oracion,
    mes,
    estado_periodo,
    id_gestion,
    gestion,
    id_region,
    id_lugar)
AS
  SELECT mov.id_movimiento,
         mov.estado_reg,
         mov.tipo,
         mov.id_casa_oracion,
         mov.concepto,
         mov.obs,
         mov.fecha,
         mov.id_estado_periodo,
         mov.fecha_reg,
         mov.id_usuario_reg,
         mov.fecha_mod,
         mov.id_usuario_mod,
         usu1.cuenta AS usr_reg,
         usu2.cuenta AS usr_mod,
         tm1.id_tipo_movimiento,
         md1.id_movimiento_det,
         md1.monto,
         mov.id_obrero,
         o.nombre_completo1 AS desc_obrero,
         mov.estado,
         mov.tipo_documento,
         mov.num_documento,
         tm1.nombre AS desc_tipo_movimiento,
         co.nombre AS desc_casa_oracion,
         ep.mes,
         ep.estado_periodo,
         ges.id_gestion,
         ges.gestion,
         co.id_region,
         co.id_lugar
  FROM ccb.tmovimiento mov
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = mov.id_casa_oracion
       JOIN ccb.testado_periodo ep ON ep.id_estado_periodo =
         mov.id_estado_periodo
       JOIN ccb.tgestion ges ON ges.id_gestion = ep.id_gestion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
       JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
       JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento =
         md1.id_tipo_movimiento
       LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
  WHERE mov.tipo::text = 'ingreso'::text;
  
 
 
 CREATE OR REPLACE VIEW ccb.vmovimiento_egreso(
    id_movimiento,
    estado_reg,
    tipo,
    id_casa_oracion,
    concepto,
    obs,
    fecha,
    id_estado_periodo,
    fecha_reg,
    id_usuario_reg,
    fecha_mod,
    id_usuario_mod,
    usr_reg,
    usr_mod,
    id_tipo_movimiento,
    id_movimiento_det,
    monto,
    id_obrero,
    desc_obrero,
    estado,
    tipo_documento,
    num_documento,
    desc_tipo_movimiento,
    desc_casa_oracion,
    mes,
    estado_periodo,
    id_gestion,
    gestion,
    id_region,
    id_lugar)
AS
  SELECT mov.id_movimiento,
         mov.estado_reg,
         mov.tipo,
         mov.id_casa_oracion,
         mov.concepto,
         mov.obs,
         mov.fecha,
         mov.id_estado_periodo,
         mov.fecha_reg,
         mov.id_usuario_reg,
         mov.fecha_mod,
         mov.id_usuario_mod,
         usu1.cuenta AS usr_reg,
         usu2.cuenta AS usr_mod,
         tm1.id_tipo_movimiento,
         md1.id_movimiento_det,
         md1.monto,
         mov.id_obrero,
         o.nombre_completo1 AS desc_obrero,
         mov.estado,
         mov.tipo_documento,
         mov.num_documento,
         tm1.nombre AS desc_tipo_movimiento,
         co.nombre AS desc_casa_oracion,
         ep.mes,
         ep.estado_periodo,
         ges.id_gestion,
         ges.gestion,
         co.id_region,
         co.id_lugar
  FROM ccb.tmovimiento mov
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = mov.id_casa_oracion
       JOIN ccb.testado_periodo ep ON ep.id_estado_periodo =
         mov.id_estado_periodo
       JOIN ccb.tgestion ges ON ges.id_gestion = ep.id_gestion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = mov.id_usuario_reg
       JOIN segu.tusuario usu2 ON usu2.id_usuario = mov.id_usuario_mod
       JOIN ccb.tmovimiento_det md1 ON md1.id_movimiento = mov.id_movimiento
       JOIN ccb.ttipo_movimiento tm1 ON tm1.id_tipo_movimiento =
         md1.id_tipo_movimiento
       LEFT JOIN ccb.vobrero o ON o.id_obrero = mov.id_obrero
  WHERE mov.tipo::text = 'egreso'::text;
  
   
/********************************************F-DEP-RAC-WF-0-01/05/2015*************************************/
