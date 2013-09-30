/***********************************I-SCP-RAC-CCB-1-01/01/2013****************************************/

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
    INHERITS( pxp.tbase);
     

/***********************************F-SCP-RAC-CCB-1-01/01/2013****************************************/
