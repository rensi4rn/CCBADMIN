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



