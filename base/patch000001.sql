/***********************************I-SCP-RAC-CCB-1-01/01/2013****************************************/
/*
CREATE TABLE ccb.tregion(
    id_region SERIAL NOT NULL,
    nombre varchar(200),
    obs varchar(500),
    PRIMARY KEY (id_region)) INHERITS (pxp.tbase);
    

ALTER TABLE ccb.tregion
  ALTER COLUMN nombre SET NOT NULL;
  
 
CREATE TABLE ccb.ttipo_ministerio(
    id_tipo_ministerio SERIAL NOT NULL,
    nombre varchar(255),
    tipo varchar(30),
    PRIMARY KEY (id_tipo_ministerio)) INHERITS (pxp.tbase);
    
    

CREATE TABLE ccb.tevento(
    id_evento SERIAL NOT NULL,
    nombre varchar(255),
    descripcion text,
    PRIMARY KEY (id_evento)) INHERITS (pxp.tbase);
    
    
    
CREATE TABLE ccb.tcasa_oracion(
    id_casa_oracion SERIAL NOT NULL,
    id_region int4 NOT NULL,
    id_lugar int4,
    codigo varchar(255),
    nombre varchar(255),
    direccion text,
    fecha_apertura date,
    fecha_cierre date,
    PRIMARY KEY (id_casa_oracion))  INHERITS (pxp.tbase); 
    
    
   
CREATE TABLE ccb.tobrero(
    id_obrero SERIAL NOT NULL,
    id_persona int4,
    id_region int4 NOT NULL,
    id_tipo_ministerio int4 NOT NULL,
    fecha_ini date,
    fecha_fin date,
    obs text,
    PRIMARY KEY (id_obrero)) INHERITS (pxp.tbase);
    
CREATE TABLE ccb.tgestion(
    id_gestion SERIAL NOT NULL,
    gestion varchar(255),
    PRIMARY KEY (id_gestion))
  INHERITS( pxp.tbase) 
  
  
CREATE TABLE ccb.tregion_evento(
    id_region_evento SERIAL NOT NULL,
    id_gestion int4 NOT NULL,
    id_evento int4 NOT NULL,
    fecha_programada date,
    estado varchar(20),
    id_region int4 NOT NULL,
    PRIMARY KEY (id_region_evento)) INHERITS( pxp.tbase);
        
   
CREATE TABLE ccb.tdetalle_evento(
    id_detalle_evento SERIAL NOT NULL,
    id_region_evento int4 NOT NULL,
    id_tipo_ministerio int4 NOT NULL,
    catidad int4,
    obs varchar(255),
    PRIMARY KEY (id_detalle_evento))
    INHERITS( pxp.tbase);
    
CREATE TABLE ccb.tculto(
    id_culto SERIAL NOT NULL,
    id_casa_oracion int4 NOT NULL,
    tipo_culto varchar(255),
    dia varchar(30),
    hora time(6),
    PRIMARY KEY (id_culto))
     INHERITS( pxp.tbase);
     
CREATE TABLE ccb.testado_periodo(
    id_estado_periodo SERIAL NOT NULL,
    id_casa_oracion int4 NOT NULL,
    id_gestion int4 NOT NULL,
    num_mes int4,
    mes varchar(20),
    fecha_ini date,
    fecha_fin date,
    estado_periodo varchar(255),
    PRIMARY KEY (id_estado_periodo))
     INHERITS( pxp.tbase);       

  
CREATE TABLE ccb.ttipo_movimiento(
    id_tipo_movimiento SERIAL NOT NULL,
    codigo varchar(20),
    nombre varchar(255),
    tipo varchar(15),
    PRIMARY KEY (id_tipo_movimiento))
    INHERITS( pxp.tbase);	
    
CREATE TABLE ccb.tmovimiento(
    id_movimiento SERIAL NOT NULL,
    id_casa_oracion int4 NOT NULL,
    id_estado_periodo int4 NOT NULL,
    tipo varchar(30),
    fecha date,
    concepto varchar(50),
    obs text,
    PRIMARY KEY (id_movimiento))
    INHERITS( pxp.tbase); 
    
CREATE TABLE ccb.tmovimiento_det(
    id_movimiento_det SERIAL NOT NULL,
    id_tipo_movimiento int4 NOT NULL,
    id_movimiento int4 NOT NULL,
    monto numeric(19, 2),
    PRIMARY KEY (id_movimiento_det))
    INHERITS( pxp.tbase);*/
     
 CREATE TABLE ccb.tcasa_oracion (
  id_casa_oracion SERIAL, 
  id_region INTEGER NOT NULL, 
  id_lugar INTEGER, 
  codigo VARCHAR(255), 
  nombre VARCHAR(255), 
  direccion TEXT, 
  fecha_apertura DATE, 
  fecha_cierre DATE, 
  CONSTRAINT tcasa_oracion_pkey PRIMARY KEY(id_casa_oracion)
) INHERITS (pxp.tbase)
WITHOUT OIDS;



CREATE TABLE ccb.tculto (
  id_culto SERIAL, 
  id_casa_oracion INTEGER NOT NULL, 
  tipo_culto VARCHAR(255), 
  dia VARCHAR(30), 
  hora TIME(6) WITHOUT TIME ZONE, 
  CONSTRAINT tculto_pkey PRIMARY KEY(id_culto)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tdetalle_evento (
  id_detalle_evento SERIAL, 
  id_region_evento INTEGER NOT NULL, 
  id_tipo_ministerio INTEGER NOT NULL, 
  catidad INTEGER, 
  obs VARCHAR(255), 
  CONSTRAINT tdetalle_evento_pkey PRIMARY KEY(id_detalle_evento)
) INHERITS (pxp.tbase)
WITHOUT OIDS;



CREATE TABLE ccb.testado_periodo (
  id_estado_periodo SERIAL, 
  id_casa_oracion INTEGER NOT NULL, 
  id_gestion INTEGER NOT NULL, 
  num_mes INTEGER, 
  mes VARCHAR(20), 
  fecha_fin DATE, 
  estado_periodo VARCHAR(255), 
  fecha_ini DATE, 
  CONSTRAINT testado_periodo_pkey PRIMARY KEY(id_estado_periodo)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tevento (
  id_evento SERIAL, 
  nombre VARCHAR(255), 
  descripcion TEXT, 
  CONSTRAINT tevento_pkey PRIMARY KEY(id_evento)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tgestion (
  id_gestion SERIAL, 
  gestion VARCHAR(255), 
  CONSTRAINT tgestion_pkey PRIMARY KEY(id_gestion)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tmovimiento (
  id_movimiento SERIAL, 
  id_casa_oracion INTEGER NOT NULL, 
  id_estado_periodo INTEGER NOT NULL, 
  tipo VARCHAR(30), 
  fecha DATE, 
  concepto VARCHAR(50), 
  obs TEXT, 
  CONSTRAINT tmovimiento_pkey PRIMARY KEY(id_movimiento)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tmovimiento_det (
  id_movimiento_det SERIAL, 
  id_tipo_movimiento INTEGER NOT NULL, 
  id_movimiento INTEGER NOT NULL, 
  monto NUMERIC(19,2), 
  CONSTRAINT tmovimiento_det_pkey PRIMARY KEY(id_movimiento_det)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tobrero (
  id_obrero SERIAL, 
  id_persona INTEGER, 
  id_region INTEGER NOT NULL, 
  id_tipo_ministerio INTEGER NOT NULL, 
  fecha_ini DATE, 
  fecha_fin DATE, 
  obs TEXT, 
  CONSTRAINT tobrero_pkey PRIMARY KEY(id_obrero)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.tregion (
  id_region SERIAL, 
  nombre VARCHAR(200) NOT NULL, 
  obs VARCHAR(500), 
  CONSTRAINT tregion_pkey PRIMARY KEY(id_region)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

 
 CREATE TABLE ccb.tregion_evento (
  id_region_evento SERIAL, 
  id_gestion INTEGER NOT NULL, 
  id_evento INTEGER NOT NULL, 
  fecha_programada DATE, 
  estado VARCHAR(20), 
  id_region INTEGER NOT NULL, 
  CONSTRAINT tregion_evento_pkey PRIMARY KEY(id_region_evento)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.ttipo_ministerio (
  id_tipo_ministerio SERIAL, 
  nombre VARCHAR(255), 
  tipo VARCHAR(30), 
  CONSTRAINT ttipo_ministerio_pkey PRIMARY KEY(id_tipo_ministerio)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


CREATE TABLE ccb.ttipo_movimiento (
  id_tipo_movimiento SERIAL, 
  codigo VARCHAR(20), 
  nombre VARCHAR(255), 
  tipo VARCHAR(15), 
  CONSTRAINT ttipo_movimiento_pkey PRIMARY KEY(id_tipo_movimiento)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

/***********************************F-SCP-RAC-CCB-1-01/01/2013****************************************/




/***********************************I-SCP-RAC-CCB-1-03/03/2015****************************************/


--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD COLUMN id_casa_oracion INTEGER;

--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD COLUMN tipo_registro VARCHAR(20) DEFAULT 'detalle' NOT NULL;

COMMENT ON COLUMN ccb.tregion_evento.tipo_registro
IS 'topma los valores detalle o resumen,
se realiza un resumen por gestion';

--------------- SQL ---------------

CREATE TABLE ccb.tusuario_permiso (
  id_usuario_permiso SERIAL,
  id_usuario_asignado INTEGER NOT NULL,
  id_casa_oracion INTEGER NOT NULL,
  CONSTRAINT tusuario_permiso_pkey PRIMARY KEY(id_usuario_permiso)
) INHERITS (pxp.tbase)
WITHOUT OIDS;


/***********************************F-SCP-RAC-CCB-1-03/03/2015****************************************/



/***********************************I-SCP-RAC-CCB-1-06/03/2015****************************************/
--------------- SQL ---------------

ALTER TABLE ccb.tusuario_permiso
  ADD COLUMN id_region INTEGER;

COMMENT ON COLUMN ccb.tusuario_permiso.id_region
IS 'el suario puede tener permisos sobre tod auna region';


/***********************************F-SCP-RAC-CCB-1-06/03/2015****************************************/


/***********************************I-SCP-RAC-CCB-2-06/03/2015****************************************/

--------------- SQL ---------------

ALTER TABLE ccb.tusuario_permiso
  ALTER COLUMN id_casa_oracion DROP NOT NULL;
  
--------------- SQL ---------------

ALTER TABLE ccb.tevento
  ADD COLUMN codigo VARCHAR(20);

--------------- SQL ---------------

ALTER TABLE ccb.ttipo_ministerio
  ADD COLUMN codigo VARCHAR(20);
  
--------------- SQL ---------------

ALTER TABLE ccb.tobrero
  ADD COLUMN id_casa_oracion INTEGER;
  
  
/***********************************F-SCP-RAC-CCB-2-06/03/2015****************************************/



/***********************************I-SCP-RAC-CCB-2-08/03/2015****************************************/


--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ALTER COLUMN fecha_programada DROP NOT NULL;
  
/***********************************F-SCP-RAC-CCB-2-08/03/2015****************************************/


/***********************************I-SCP-RAC-CCB-2-11/03/2015****************************************/
-------------- SQL ---------------

ALTER TABLE ccb.tdetalle_evento
  RENAME COLUMN catidad TO cantidad;
 
/***********************************F-SCP-RAC-CCB-2-11/03/2015****************************************/



/***********************************I-SCP-RAC-CCB-2-03/04/2015****************************************/

--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD COLUMN id_obrero INTEGER;

COMMENT ON COLUMN ccb.tmovimiento.id_obrero
IS 'persona resposble que lelva la colecta';


--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD COLUMN estado VARCHAR(15) DEFAULT 'entregado' NOT NULL;

COMMENT ON COLUMN ccb.tmovimiento.estado
IS 'entregado, pendiente';

--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD COLUMN tipo_documento VARCHAR(20);

COMMENT ON COLUMN ccb.tmovimiento.tipo_documento
IS 'factura o recibo';

--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD COLUMN num_documento VARCHAR(30);

COMMENT ON COLUMN ccb.tmovimiento.num_documento
IS 'para egreso identifica el numero de factura o recibo';

/***********************************F-SCP-RAC-CCB-2-03/04/2015****************************************/





/***********************************I-SCP-RAC-CCB-2-20/04/2015****************************************/

--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD COLUMN hora TIME(6) WITHOUT TIME ZONE;

/***********************************F-SCP-RAC-CCB-2-20/04/2015****************************************/

 
/***********************************I-SCP-RAC-CCB-2-16/05/2015****************************************/

 
 --------------- SQL ---------------

ALTER TABLE ccb.tmovimiento
  ADD COLUMN id_ot INTEGER;
  

--------------- SQL ---------------

ALTER TABLE ccb.tmovimiento_det
  ADD COLUMN id_concepto_ingas INTEGER;
  
/***********************************F-SCP-RAC-CCB-2-16/05/2015****************************************/

/***********************************I-SCP-RAC-CCB-2-20/05/2015****************************************/

ALTER TABLE ccb.tmovimiento
  ADD COLUMN id_tipo_movimiento_ot INTEGER;

/***********************************F-SCP-RAC-CCB-2-20/05/2015****************************************/




/***********************************I-SCP-RAC-CCB-2-11/06/2015****************************************/

--------------- SQL ---------------

ALTER TABLE ccb.tcasa_oracion
  ADD COLUMN longitud VARCHAR;
  
--------------- SQL ---------------

ALTER TABLE ccb.tcasa_oracion
  ADD COLUMN latitud VARCHAR;
  
--------------- SQL ---------------

ALTER TABLE ccb.tcasa_oracion
  ADD COLUMN zoom VARCHAR;


/***********************************F-SCP-RAC-CCB-2-11/06/2015****************************************/




/***********************************I-SCP-RAC-CCB-2-23/06/2015****************************************/

--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD COLUMN id_obrero INTEGER;

COMMENT ON COLUMN ccb.tregion_evento.id_obrero
IS 'identifica las los obereos responsalbes por atender';


--------------- SQL ---------------

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
         re.hora,
         re.id_obrero,
         ob.nombre_completo1 as desc_obrero
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
       LEFT JOIN ccb.vobrero ob ON ob.id_obrero = re.id_obrero
  WHERE (ev.codigo::text = ANY (ARRAY [ 'bautizo'::text, 'santacena'::text ]))
  AND
        re.tipo_registro::text = 'detalle'::text;


--------------- SQL ---------------

CREATE OR REPLACE VIEW ccb.vcalendario(
    event,
    title,
    start,
    "end",
    desc_evento,
    desc_region,
    desc_casa_oracion,
    tipo_registro,
    desc_lugar,
    hora,
    id_lugar,
    fecha_programada,
    css,
    id_region_evento)
AS
  SELECT (rege.id_region_evento::character varying::text || ' - '::text) ||
    COALESCE(rege.hora::character varying, '19:00:00'::character varying)::text
    AS event,
         ((((eve.nombre::text || ' - '::text) || co.nombre::text) || ' ('::text)
           || lug.nombre::text) || ')'::text AS title,
         ((rege.fecha_programada::character varying::text || ' '::text) ||
           COALESCE(rege.hora, '19:00:00'::time without time zone))::timestamp
           without time zone AS start,
         (((rege.fecha_programada::character varying::text || ' '::text) ||
           COALESCE(rege.hora, '19:00:00'::time without time zone))::timestamp
           without time zone) + '02:00:00'::interval hour AS "end",
         eve.nombre AS desc_evento,
         reg.nombre AS desc_region,
         co.nombre AS desc_casa_oracion,
         rege.tipo_registro,
         lug.nombre AS desc_lugar,
         COALESCE(rege.hora, '19:00:00'::time without time zone) AS hora,
         lug.id_lugar,
         rege.fecha_programada,
         CASE
           WHEN eve.codigo::text = 'bautico'::text THEN 'green'::text
           WHEN eve.codigo::text = 'santacena'::text THEN 'blue'::text
           WHEN eve.codigo::text = 'reuniondejuventud'::text THEN 'purple'::text
           WHEN eve.codigo::text = 'reunmiloc'::text THEN 'orange'::text
           WHEN eve.codigo::text = 'ensayoreg'::text THEN 'brown'::text
           WHEN eve.codigo::text = 'reunmireg'::text THEN 'red'::text
           ELSE 'grey'::text
         END AS css,
         rege.id_region_evento,
         rege.id_obrero,
         ob.nombre_completo1 as desc_obrero
  FROM ccb.tregion_evento rege
       JOIN ccb.tgestion ges ON ges.id_gestion = rege.id_gestion
       JOIN ccb.tregion reg ON reg.id_region = rege.id_region
       JOIN ccb.tevento eve ON eve.id_evento = rege.id_evento
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = rege.id_casa_oracion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = rege.id_usuario_reg
       JOIN param.tlugar lug ON lug.id_lugar = co.id_lugar
       LEFT JOIN ccb.vobrero ob ON ob.id_obrero = rege.id_obrero
  WHERE rege.tipo_registro::text = 'detalle'::text;
/***********************************F-SCP-RAC-CCB-2-23/06/2015****************************************/



/***********************************I-SCP-RAC-CCB-2-27/06/2015****************************************/


--------------- SQL ---------------

CREATE OR REPLACE VIEW ccb.vcalendario(
    event,
    title,
    start,
    "end",
    desc_evento,
    desc_region,
    desc_casa_oracion,
    tipo_registro,
    desc_lugar,
    hora,
    id_lugar,
    fecha_programada,
    css,
    id_region_evento,
    id_obrero,
    desc_obrero)
AS
  SELECT (rege.id_region_evento::character varying::text || ' - '::text) ||
    COALESCE(rege.hora::character varying, '19:00:00'::character varying)::text
    AS event,
         ((((eve.nombre::text || ' - '::text) || co.nombre::text) || ' ('::text)
           || lug.nombre::text) || ')'::text AS title,
         ((rege.fecha_programada::character varying::text || ' '::text) ||
           COALESCE(rege.hora, '19:00:00'::time without time zone))::timestamp
           without time zone AS start,
         (((rege.fecha_programada::character varying::text || ' '::text) ||
           COALESCE(rege.hora, '19:00:00'::time without time zone))::timestamp
           without time zone) + '02:00:00'::interval hour AS "end",
         eve.nombre AS desc_evento,
         reg.nombre AS desc_region,
         co.nombre AS desc_casa_oracion,
         rege.tipo_registro,
         lug.nombre AS desc_lugar,
         COALESCE(rege.hora, '19:00:00'::time without time zone) AS hora,
         lug.id_lugar,
         rege.fecha_programada,
         CASE
           WHEN eve.codigo::text = 'bautico'::text THEN 'green'::text
           WHEN eve.codigo::text = 'santacena'::text THEN 'blue'::text
           WHEN eve.codigo::text = 'reuniondejuventud'::text THEN 'purple'::text
           WHEN eve.codigo::text = 'reunmiloc'::text THEN 'orange'::text
           WHEN eve.codigo::text = 'ensayoreg'::text THEN 'brown'::text
           WHEN eve.codigo::text = 'reunmireg'::text THEN 'red'::text
           ELSE 'grey'::text
         END AS css,
         rege.id_region_evento,
         rege.id_obrero,
         ob.nombre_completo1 AS desc_obrero,
         eve.id_evento
  FROM ccb.tregion_evento rege
       JOIN ccb.tgestion ges ON ges.id_gestion = rege.id_gestion
       JOIN ccb.tregion reg ON reg.id_region = rege.id_region
       JOIN ccb.tevento eve ON eve.id_evento = rege.id_evento
       JOIN ccb.tcasa_oracion co ON co.id_casa_oracion = rege.id_casa_oracion
       JOIN segu.tusuario usu1 ON usu1.id_usuario = rege.id_usuario_reg
       JOIN param.tlugar lug ON lug.id_lugar = co.id_lugar
       LEFT JOIN ccb.vobrero ob ON ob.id_obrero = rege.id_obrero
  WHERE rege.tipo_registro::text = 'detalle'::text;

/***********************************F-SCP-RAC-CCB-2-27/06/2015****************************************/

/***********************************I-SCP-RAC-CCB-2-25/07/2015****************************************/



--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD COLUMN obs VARCHAR;

--------------- SQL ---------------

ALTER TABLE ccb.tregion_evento
  ADD COLUMN obs2 VARCHAR;

COMMENT ON COLUMN ccb.tregion_evento.obs2
IS 'observaciones que no van en el reporte';



--------------- SQL ---------------

ALTER TABLE ccb.tevento
  ADD COLUMN prioridad NUMERIC DEFAULT 1 NOT NULL;

COMMENT ON COLUMN ccb.tevento.prioridad
IS 'prioridad para aparecer en rerpotes';


/***********************************F-SCP-RAC-CCB-2-25/07/2015****************************************/


/***********************************I-SCP-RAC-CCB-2-16/08/2015****************************************/

--------------- SQL ---------------

ALTER TABLE ccb.ttipo_ministerio
  ADD COLUMN prioridad NUMERIC DEFAULT 1 NOT NULL;

COMMENT ON COLUMN ccb.ttipo_ministerio.prioridad
IS 'la prioridad menor es las mas importante';

/***********************************F-SCP-RAC-CCB-2-16/08/2015****************************************/



/***********************************I-SCP-RAC-CCB-2-04/10/2015****************************************/

--------------- SQL ---------------

CREATE TABLE ccb.ttipo_concepto (
  id_tipo_concepto SERIAL NOT NULL,
  codigo VARCHAR(40) NOT NULL UNIQUE,
  descripcion VARCHAR,
  prioridad INTEGER NOT NULL,
  PRIMARY KEY(id_tipo_concepto)
) INHERITS (pxp.tbase)
;

ALTER TABLE ccb.ttipo_concepto
  ALTER COLUMN descripcion SET STATISTICS 0;
  

/***********************************F-SCP-RAC-CCB-2-04/10/2015****************************************/

