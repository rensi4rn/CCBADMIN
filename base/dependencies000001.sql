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
    ev.nombre
   FROM ccb.tregion_evento re
     JOIN ccb.tregion reg ON reg.id_region = re.id_region
     JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = re.id_casa_oracion
     JOIN ccb.tdetalle_evento deh ON deh.id_region_evento = re.id_region_evento
     JOIN ccb.ttipo_ministerio tm ON tm.id_tipo_ministerio = deh.id_tipo_ministerio AND tm.codigo::text = 'hermano'::text
     JOIN ccb.tdetalle_evento dee ON dee.id_region_evento = re.id_region_evento
     JOIN ccb.ttipo_ministerio tm2 ON tm2.id_tipo_ministerio = dee.id_tipo_ministerio AND tm2.codigo::text = 'hermana'::text
     JOIN ccb.tevento ev ON ev.id_evento = re.id_evento
     JOIN ccb.tgestion ges ON ges.id_gestion = re.id_gestion
  WHERE ev.codigo::text = 'bautizo'::text AND re.tipo_registro::text = 'detalle'::text;
/********************************************F-DEP-RAC-WF-0-11/03/2015*************************************/
