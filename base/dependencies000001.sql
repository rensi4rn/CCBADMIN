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
