/********************************************I-DAT-RAC-CCB-0-31/12/2012********************************************/
/*
*	Author: RAC
*	Date: 21/12/2012
*	Description: Build the menu definition and the composition
*/


/*

Para  definir la la metadata, menus, roles, etc

1) sincronize ls funciones y procedimientos del sistema
2)  verifique que la primera linea de los datos sea la insercion del sistema correspondiente
3)  exporte los datos a archivo SQL (desde la interface de sistema en sis_seguridad), 
    verifique que la codificacion  se mantenga en UTF8 para no distorcionar los caracteres especiales
4)  remplaze los sectores correspondientes en este archivo en su totalidad:  (el orden es importante)  
                             menu, 
                             funciones, 
                             procedimietnos
*/

INSERT INTO segu.tsubsistema ( "codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES ( E'CCB', E'ADMCCB', E'2013-01-04', E'CCB', 'activo', E'admin', NULL);

----------------------------------
--DEF DE INTERFACES
---------------------------------


----------------------------------
--COPY LINES TO data.sql FILE  
---------------------------------

select pxp.f_insert_tgui ('ADMCCB', '', 'ADM', 'si', 0, '', 1, '', '', 'CCB');
select pxp.f_insert_tgui ('Parametros', '', 'PAR', 'si', 1, '', 2, '', '', 'CCB');
select pxp.f_insert_tgui ('Regiones', 'Regiones de la CCB', 'REG', 'si', 1, 'sis_admin/vista/region/Region.php', 3, '', 'Region', 'CCB');
select pxp.f_insert_tgui ('Tipos de Ministerio', 'Tipos de Ministerio', 'TIPMIN', 'si', 2, 'sis_admin/vista/tipo_ministerio/TipoMinisterio.php', 3, '', 'TipoMinisterio', 'CCB');
select pxp.f_insert_tgui ('Tipos de Eventos', 'Eventos', 'EVEN', 'si', 3, 'sis_admin/vista/evento/Evento.php', 3, '', 'Evento', 'CCB');
select pxp.f_insert_tgui ('Casas de Oración', 'Casas de Oración', 'CAOR', 'si', 4, 'sis_admin/vista/casa_oracion/CasaOracion.php', 3, '', 'CasaOracion', 'CCB');
select pxp.f_insert_tgui ('Gestión', 'Gestión', 'GES', 'si', 1, 'sis_admin/vista/gestion/Gestion.php', 3, '', 'Gestion', 'CCB');
select pxp.f_insert_tgui ('Eventos por Región', 'Registro de Eventos por Region Administrativa', 'REGE', 'si', 2, 'sis_admin/vista/region_evento/RegionEvento.php', 2, '', 'RegionEvento', 'CCB');
select pxp.f_insert_tgui ('Tipos de Movimientos', 'Tipos de Moviemientos en salida e ingreso de colectas', 'TMOV', 'si', 5, 'sis_admin/vista/tipo_movimiento/TipoMovimiento.php', 3, '', 'TipoMovimiento', 'CCB');
select pxp.f_insert_tgui ('Movimientos Económicos', 'Registro de Movimientos Económicos', 'MOV', 'si', 3, 'sis_admin/vista/movimiento/Movimiento.php', 2, '', 'Movimiento', 'CCB');
select pxp.f_insert_tgui ('Reporte de Movimientos', 'Reporte', 'REPMOV', 'si', 4, 'sis_admin/vista/movimiento/MovimientoDinamico.php', 2, '', 'MovimientoDinamico', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_region_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_region_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_tipo_ministerio_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_tipo_ministerio_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_evento_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_evento_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_casa_oracion_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_estado_periodo_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_casa_oracion_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_tipo_movimiento_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_region_evento_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_obrero_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_region_evento_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_gestion_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_gestion_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_obrero_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_detalle_evento_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_detalle_evento_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_culto_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_culto_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_tipo_movimiento_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_estado_periodo_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_movimiento_det_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_movimiento_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_movimiento_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.f_movimiento_det_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tprocedimiento ('CCB_REGI_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_region_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGI_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_region_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGI_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_region_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGI_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_region_sel');
select pxp.f_insert_tprocedimiento ('CCB_REGI_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_region_sel');
select pxp.f_insert_tprocedimiento ('CCB_TIPMI_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_tipo_ministerio_ime');
select pxp.f_insert_tprocedimiento ('CCB_TIPMI_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_tipo_ministerio_ime');
select pxp.f_insert_tprocedimiento ('CCB_TIPMI_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_tipo_ministerio_ime');
select pxp.f_insert_tprocedimiento ('CCB_TIPMI_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_tipo_ministerio_sel');
select pxp.f_insert_tprocedimiento ('CCB_TIPMI_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_tipo_ministerio_sel');
select pxp.f_insert_tprocedimiento ('CCB_EVEN_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_EVEN_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_EVEN_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_EVEN_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_evento_sel');
select pxp.f_insert_tprocedimiento ('CCB_EVEN_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_evento_sel');
select pxp.f_insert_tprocedimiento ('CCB_CAOR_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_casa_oracion_ime');
select pxp.f_insert_tprocedimiento ('CCB_CAOR_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_casa_oracion_ime');
select pxp.f_insert_tprocedimiento ('CCB_CAOR_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_casa_oracion_ime');
select pxp.f_insert_tprocedimiento ('CCB_PER_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_estado_periodo_sel');
select pxp.f_insert_tprocedimiento ('CCB_PER_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_estado_periodo_sel');
select pxp.f_insert_tprocedimiento ('CCB_CAOR_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_casa_oracion_sel');
select pxp.f_insert_tprocedimiento ('CCB_CAOR_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_casa_oracion_sel');
select pxp.f_insert_tprocedimiento ('CCB_TMOV_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_tipo_movimiento_ime');
select pxp.f_insert_tprocedimiento ('CCB_TMOV_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_tipo_movimiento_ime');
select pxp.f_insert_tprocedimiento ('CCB_TMOV_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_tipo_movimiento_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGE_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_region_evento_sel');
select pxp.f_insert_tprocedimiento ('CCB_REGE_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_region_evento_sel');
select pxp.f_insert_tprocedimiento ('CCB_OBR_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_obrero_ime');
select pxp.f_insert_tprocedimiento ('CCB_OBR_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_obrero_ime');
select pxp.f_insert_tprocedimiento ('CCB_OBR_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_obrero_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGE_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_region_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGE_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_region_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_REGE_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_region_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_GES_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_gestion_sel');
select pxp.f_insert_tprocedimiento ('CCB_GES_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_gestion_sel');
select pxp.f_insert_tprocedimiento ('CCB_GES_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_gestion_ime');
select pxp.f_insert_tprocedimiento ('CCB_GES_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_gestion_ime');
select pxp.f_insert_tprocedimiento ('CCB_GES_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_gestion_ime');
select pxp.f_insert_tprocedimiento ('CCB_OBR_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_obrero_sel');
select pxp.f_insert_tprocedimiento ('CCB_OBR_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_obrero_sel');
select pxp.f_insert_tprocedimiento ('CCB_DEV_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_detalle_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_DEV_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_detalle_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_DEV_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_detalle_evento_ime');
select pxp.f_insert_tprocedimiento ('CCB_DEV_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_detalle_evento_sel');
select pxp.f_insert_tprocedimiento ('CCB_DEV_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_detalle_evento_sel');
select pxp.f_insert_tprocedimiento ('CCB_CUL_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_culto_ime');
select pxp.f_insert_tprocedimiento ('CCB_CUL_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_culto_ime');
select pxp.f_insert_tprocedimiento ('CCB_CUL_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_culto_ime');
select pxp.f_insert_tprocedimiento ('CCB_CUL_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_culto_sel');
select pxp.f_insert_tprocedimiento ('CCB_CUL_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_culto_sel');
select pxp.f_insert_tprocedimiento ('CCB_TMOV_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_tipo_movimiento_sel');
select pxp.f_insert_tprocedimiento ('CCB_TMOV_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_tipo_movimiento_sel');
select pxp.f_insert_tprocedimiento ('CCB_PER_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_estado_periodo_ime');
select pxp.f_insert_tprocedimiento ('CCB_PER_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_estado_periodo_ime');
select pxp.f_insert_tprocedimiento ('CCB_PER_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_estado_periodo_ime');
select pxp.f_insert_tprocedimiento ('CCB_GENGES_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_estado_periodo_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOVD_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_movimiento_det_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOVD_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_movimiento_det_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOVD_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_movimiento_det_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOVDIN_CONT', 'coonsulta dinamica delos movimientos economicos', 'si', '', '', 'ccb.f_movimiento_sel');
select pxp.f_insert_tprocedimiento ('CCB_MOV_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_movimiento_sel');
select pxp.f_insert_tprocedimiento ('CCB_MOV_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_movimiento_sel');
select pxp.f_insert_tprocedimiento ('CCB_MOV_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.f_movimiento_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOV_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.f_movimiento_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOV_INS', 'Insercion de registros', 'si', '', '', 'ccb.f_movimiento_ime');
select pxp.f_insert_tprocedimiento ('CCB_MOVD_CONT', 'Conteo de registros', 'si', '', '', 'ccb.f_movimiento_det_sel');
select pxp.f_insert_tprocedimiento ('CCB_MOVD_SEL', 'Consulta de datos', 'si', '', '', 'ccb.f_movimiento_det_sel');
----------------------------------
--COPY LINES TO dependencies.sql FILE 
---------------------------------

select pxp.f_insert_testructura_gui ('ADM', 'SISTEMA');
select pxp.f_insert_testructura_gui ('PAR', 'ADM');
select pxp.f_insert_testructura_gui ('REG', 'PAR');
select pxp.f_insert_testructura_gui ('TIPMIN', 'PAR');
select pxp.f_insert_testructura_gui ('EVEN', 'PAR');
select pxp.f_insert_testructura_gui ('CAOR', 'PAR');
select pxp.f_insert_testructura_gui ('GES', 'PAR');
select pxp.f_insert_testructura_gui ('REGE', 'ADM');
select pxp.f_insert_testructura_gui ('TMOV', 'PAR');
select pxp.f_insert_testructura_gui ('MOV', 'ADM');
select pxp.f_insert_testructura_gui ('REPMOV', 'ADM');



--------------------------------------
-- DATOS BASICOS
-----------------------------------------

/* Data for the 'ccb.ttipo_ministerio' table  (Records 1 - 7) */

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, 1, E'2013-01-05 03:41:38.562', E'2013-01-05 03:42:40.087', E'activo', 1, E'Presidente', E'administracion');

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, NULL, E'2013-01-05 03:42:57.887', NULL, E'activo', 2, E'Anciano', E'espiritual');

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, NULL, E'2013-01-05 03:43:21.653', NULL, E'activo', 3, E'Diacono', E'espiritual');

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, NULL, E'2013-01-05 03:43:28.881', NULL, E'activo', 4, E'Cooperador', E'espiritual');

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, NULL, E'2013-01-05 03:43:44.721', NULL, E'activo', 5, E'Cooperador de Jovenes', E'espiritual');

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, NULL, E'2013-01-05 03:44:20.220', NULL, E'activo', 6, E'Encargado Local', E'musical');

INSERT INTO ccb.ttipo_ministerio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_tipo_ministerio", "nombre", "tipo")
VALUES (1, NULL, E'2013-01-05 03:44:29.910', NULL, E'activo', 7, E'Encargado Regional', E'musical');


/********************************************F-DAT-RAC-CCB-0-31/12/2012********************************************/



/********************************************I-DAT-RAC-CCB-0-15/03/2015********************************************/

     
----------------------------------
--COPY LINES TO data.sql FILE  
---------------------------------

select pxp.f_insert_tgui ('Obreros', 'Obreros', 'REG.1', 'no', 0, 'sis_admin/vista/obrero/Obrero.php', 4, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Sensores', 'Sensores', 'REG.2', 'no', 0, 'sis_hidrologia/vista/sensor/Sensor.php', 4, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Personas', 'Personas', 'REG.1.1', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 5, '', 'persona', 'CCB');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'REG.1.1.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 6, '', 'subirFotoPersona', 'CCB');
select pxp.f_insert_tgui ('Cultos', 'Cultos', 'CAOR.1', 'no', 0, 'sis_admin/vista/culto/Culto.php', 4, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Periodos', 'Periodos', 'CAOR.2', 'no', 0, 'sis_admin/vista/estado_periodo/EstadoPeriodo.php', 4, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Detalle', 'Detalle', 'REGE.1', 'no', 0, 'sis_admin/vista/detalle_evento/DetalleEvento.php', 3, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Detalle', 'Detalle', 'MOV.1', 'no', 0, 'sis_admin/vista/movimiento_det/MovimientoDet.php', 3, '', 'MovimientoDet', 'CCB');
select pxp.f_insert_tgui ('Obreros', 'Obreros', 'OBR', 'si', 6, 'sis_admin/vista/obrero/Obrero.php', 2, '', 'Obrero', 'CCB');
select pxp.f_insert_tgui ('Roles', 'Roles', 'USUCCB.1', 'no', 0, 'sis_seguridad/vista/usuario_rol/UsuarioRol.php', 4, '', 'usuario_rol', 'CCB');
select pxp.f_insert_tgui ('Autorizaciones', 'Autorizaciones', 'USUCCB.2', 'no', 0, 'sis_admin/vista/usuario_permiso/UsuarioPermiso.php', 4, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Personas', 'Personas', 'USUCCB.3', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 4, '', 'persona', 'CCB');
select pxp.f_insert_tgui ('EP\', 'EP\', 'USUCCB.4', 'no', 0, 'sis_seguridad/vista/usuario_grupo_ep/UsuarioGrupoEp.php', 4, '', ', 
          width:400,
          cls:', 'CCB');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'USUCCB.3.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 5, '', 'subirFotoPersona', 'CCB');
select pxp.f_insert_tgui ('Detalle', 'Detalle', 'REVEN.1', 'no', 0, 'sis_admin/vista/detalle_evento/DetalleEvento.php', 4, '', '50%', 'CCB');
select pxp.f_insert_tgui ('Personas', 'Personas', 'OBR.1', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 3, '', 'persona', 'CCB');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'OBR.1.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 4, '', 'subirFotoPersona', 'CCB');
select pxp.f_insert_tgui ('Butizos/Santas Cenas', 'Butizos/Santas Cenas', 'BATSACE', 'si', 1, 'sis_admin/vista/region_evento/RegionEventoBSC.php', 3, '', 'RegionEventoBSC', 'CCB');
select pxp.f_insert_tfuncion ('ccb.ft_usuario_permiso_sel', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tfuncion ('ccb.ft_usuario_permiso_ime', 'Funcion para tabla     ', 'CCB');
select pxp.f_insert_tprocedimiento ('CCB_MOVDIN_SEL', 'lsitado dinamico por rubros', 'si', '', '', 'ccb.f_movimiento_sel');
select pxp.f_insert_tprocedimiento ('CCB_ABRCERAR_INS', 'abrir o cerrar el periodo', 'si', '', '', 'ccb.f_estado_periodo_ime');
select pxp.f_insert_tprocedimiento ('CCB_usper_SEL', 'Consulta de datos', 'si', '', '', 'ccb.ft_usuario_permiso_sel');
select pxp.f_insert_tprocedimiento ('CCB_usper_CONT', 'Conteo de registros', 'si', '', '', 'ccb.ft_usuario_permiso_sel');
select pxp.f_insert_tprocedimiento ('CCB_USPER_INS', 'Insercion de registros', 'si', '', '', 'ccb.ft_usuario_permiso_ime');
select pxp.f_insert_tprocedimiento ('CCB_usper_MOD', 'Modificacion de registros', 'si', '', '', 'ccb.ft_usuario_permiso_ime');
select pxp.f_insert_tprocedimiento ('CCB_usper_ELI', 'Eliminacion de registros', 'si', '', '', 'ccb.ft_usuario_permiso_ime');
select pxp.f_insert_trol ('Registro economico', 'CCB-Registro economico', 'CCB');
select pxp.f_insert_trol ('', 'Administrador CCB', 'CCB');
----------------------------------
--COPY LINES TO dependencies.sql FILE  
---------------------------------

select pxp.f_insert_testructura_gui ('REG.1', 'REG');
select pxp.f_insert_testructura_gui ('REG.2', 'REG');
select pxp.f_insert_testructura_gui ('REG.1.1', 'REG.1');
select pxp.f_insert_testructura_gui ('REG.1.1.1', 'REG.1.1');
select pxp.f_insert_testructura_gui ('CAOR.1', 'CAOR');
select pxp.f_insert_testructura_gui ('CAOR.2', 'CAOR');
select pxp.f_insert_testructura_gui ('REGE.1', 'REGE');
select pxp.f_insert_testructura_gui ('MOV.1', 'MOV');
select pxp.f_insert_testructura_gui ('USUCCB.1', 'USUCCB');
select pxp.f_insert_testructura_gui ('USUCCB.2', 'USUCCB');
select pxp.f_insert_testructura_gui ('USUCCB.3', 'USUCCB');
select pxp.f_insert_testructura_gui ('USUCCB.4', 'USUCCB');
select pxp.f_insert_testructura_gui ('USUCCB.3.1', 'USUCCB.3');
select pxp.f_insert_testructura_gui ('REVEN.1', 'REVEN');
select pxp.f_insert_testructura_gui ('OBR.1', 'OBR');
select pxp.f_insert_testructura_gui ('OBR.1.1', 'OBR.1');
select pxp.f_insert_testructura_gui ('BATSACE', 'CAREVE');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_INS', 'REG', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_MOD', 'REG', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_ELI', 'REG', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_SEL', 'REG', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_SEL', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_INS', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_MOD', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_ELI', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_SEL', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REG.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'REG.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'REG.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'REG.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'REG.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'REG.1.1.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_INS', 'TIPMIN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_MOD', 'TIPMIN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_ELI', 'TIPMIN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_SEL', 'TIPMIN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_EVEN_INS', 'EVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_EVEN_MOD', 'EVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_EVEN_ELI', 'EVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_EVEN_SEL', 'EVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_SEL', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_LUG_SEL', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_LUG_ARB_SEL', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_INS', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_MOD', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_ELI', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'CAOR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CUL_INS', 'CAOR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CUL_MOD', 'CAOR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CUL_ELI', 'CAOR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CUL_SEL', 'CAOR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_SEL', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_PER_INS', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_PER_MOD', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_PER_ELI', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_PER_SEL', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GENGES_INS', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_INS', 'GES', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_MOD', 'GES', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_ELI', 'GES', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_SEL', 'GES', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_SEL', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_SEL', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_EVEN_SEL', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_INS', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_MOD', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_ELI', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_SEL', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_SEL', 'REGE.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_INS', 'REGE.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_MOD', 'REGE.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_ELI', 'REGE.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_SEL', 'REGE.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TMOV_INS', 'TMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TMOV_MOD', 'TMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TMOV_ELI', 'TMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TMOV_SEL', 'TMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_SEL', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_PER_SEL', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOV_INS', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOV_MOD', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOV_ELI', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOV_SEL', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TMOV_SEL', 'MOV.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOVD_INS', 'MOV.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOVD_MOD', 'MOV.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOVD_ELI', 'MOV.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOVD_SEL', 'MOV.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TMOV_SEL', 'REPMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'REPMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_SEL', 'REPMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOVDIN_SEL', 'REPMOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_ABRCERAR_INS', 'CAOR.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'REGE', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_MOVDIN_SEL', 'MOV', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_CLASIF_SEL', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_ROL_SEL', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUARI_INS', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUARI_MOD', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUARI_ELI', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUARI_SEL', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_LISTUSU_SEG', 'USUCCB', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_ROL_SEL', 'USUCCB.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUROL_INS', 'USUCCB.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUROL_MOD', 'USUCCB.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUROL_ELI', 'USUCCB.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_USUROL_SEL', 'USUCCB.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_SEL', 'USUCCB.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'USUCCB.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_USPER_INS', 'USUCCB.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_usper_MOD', 'USUCCB.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_usper_ELI', 'USUCCB.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_usper_SEL', 'USUCCB.2', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'USUCCB.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'USUCCB.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'USUCCB.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'USUCCB.3', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'USUCCB.3.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('PM_GRU_SEL', 'USUCCB.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SG_UEP_INS', 'USUCCB.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SG_UEP_MOD', 'USUCCB.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SG_UEP_ELI', 'USUCCB.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('SG_UEP_SEL', 'USUCCB.4', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_GES_SEL', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_SEL', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_EVEN_SEL', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_INS', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_MOD', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_ELI', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGE_SEL', 'REVEN', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_SEL', 'REVEN.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_INS', 'REVEN.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_MOD', 'REVEN.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_ELI', 'REVEN.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_DEV_SEL', 'REVEN.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_TIPMI_SEL', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_REGI_SEL', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_CAOR_SEL', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_INS', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_MOD', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_ELI', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('CCB_OBR_SEL', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_SEL', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'OBR', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_INS', 'OBR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_MOD', 'OBR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSON_ELI', 'OBR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_PERSONMIN_SEL', 'OBR.1', 'no');
select pxp.f_insert_tprocedimiento_gui ('SEG_UPFOTOPER_MOD', 'OBR.1.1', 'no');
select pxp.f_insert_tgui_rol ('MOV', 'CCB-Registro economico');
select pxp.f_insert_tgui_rol ('ADM', 'CCB-Registro economico');
select pxp.f_insert_tgui_rol ('SISTEMA', 'CCB-Registro economico');
select pxp.f_insert_tgui_rol ('MOV.1', 'CCB-Registro economico');
select pxp.f_insert_tgui_rol ('REPMOV', 'CCB-Registro economico');
select pxp.f_insert_tgui_rol ('ADM', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('SISTEMA', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('PAR', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REG', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REG.2', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REG.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REG.1.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REG.1.1.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('TIPMIN', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('EVEN', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('CAOR', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('CAOR.2', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('CAOR.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('GES', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('TMOV', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('USUCCB', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('USUCCB.4', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('USUCCB.3', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('USUCCB.3.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('USUCCB.2', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('USUCCB.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('OBR', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('OBR.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('OBR.1.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('CAREVE', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REVEN', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REVEN.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REGE', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REGE.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('MOVECO', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('MOV', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('MOV.1', 'Administrador CCB');
select pxp.f_insert_tgui_rol ('REPMOV', 'Administrador CCB');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_CAOR_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_GES_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_PER_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOV_INS', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOV_MOD', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOV_ELI', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOV_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_TMOV_SEL', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOVD_INS', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOVD_MOD', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOVD_ELI', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOVD_SEL', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_TMOV_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_CAOR_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_GES_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('CCB-Registro economico', 'CCB_MOVDIN_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_INS', 'REG');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_MOD', 'REG');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_ELI', 'REG');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_SEL', 'REG');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_SEL', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_INS', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_MOD', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_ELI', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_SEL', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_SEL', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSONMIN_SEL', 'REG.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_INS', 'REG.1.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_MOD', 'REG.1.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_ELI', 'REG.1.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSONMIN_SEL', 'REG.1.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_UPFOTOPER_MOD', 'REG.1.1.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_INS', 'TIPMIN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_MOD', 'TIPMIN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_ELI', 'TIPMIN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_SEL', 'TIPMIN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_EVEN_INS', 'EVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_EVEN_MOD', 'EVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_EVEN_ELI', 'EVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_EVEN_SEL', 'EVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_SEL', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'PM_LUG_SEL', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'PM_LUG_ARB_SEL', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_INS', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_MOD', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_ELI', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'CAOR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_SEL', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_PER_INS', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_PER_MOD', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_PER_ELI', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_PER_SEL', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GENGES_INS', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_ABRCERAR_INS', 'CAOR.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CUL_INS', 'CAOR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CUL_MOD', 'CAOR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CUL_ELI', 'CAOR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CUL_SEL', 'CAOR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_INS', 'GES');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_MOD', 'GES');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_ELI', 'GES');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_SEL', 'GES');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TMOV_INS', 'TMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TMOV_MOD', 'TMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TMOV_ELI', 'TMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TMOV_SEL', 'TMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_SEL', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSONMIN_SEL', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_CLASIF_SEL', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_ROL_SEL', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUARI_INS', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUARI_MOD', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUARI_ELI', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUARI_SEL', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_LISTUSU_SEG', 'USUCCB');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'PM_GRU_SEL', 'USUCCB.4');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SG_UEP_INS', 'USUCCB.4');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SG_UEP_MOD', 'USUCCB.4');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SG_UEP_ELI', 'USUCCB.4');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SG_UEP_SEL', 'USUCCB.4');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_INS', 'USUCCB.3');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_MOD', 'USUCCB.3');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_ELI', 'USUCCB.3');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSONMIN_SEL', 'USUCCB.3');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_UPFOTOPER_MOD', 'USUCCB.3.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_SEL', 'USUCCB.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'USUCCB.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_USPER_INS', 'USUCCB.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_usper_MOD', 'USUCCB.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_usper_ELI', 'USUCCB.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_usper_SEL', 'USUCCB.2');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_ROL_SEL', 'USUCCB.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUROL_INS', 'USUCCB.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUROL_MOD', 'USUCCB.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUROL_ELI', 'USUCCB.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_USUROL_SEL', 'USUCCB.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_SEL', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_SEL', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_INS', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_MOD', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_ELI', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_OBR_SEL', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_SEL', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSONMIN_SEL', 'OBR');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_INS', 'OBR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_MOD', 'OBR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSON_ELI', 'OBR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_PERSONMIN_SEL', 'OBR.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'SEG_UPFOTOPER_MOD', 'OBR.1.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_SEL', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_SEL', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_EVEN_SEL', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_INS', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_MOD', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_ELI', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_SEL', 'REVEN');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_SEL', 'REVEN.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_INS', 'REVEN.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_MOD', 'REVEN.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_ELI', 'REVEN.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_SEL', 'REVEN.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_SEL', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGI_SEL', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_EVEN_SEL', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_INS', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_MOD', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_ELI', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_REGE_SEL', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'REGE');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TIPMI_SEL', 'REGE.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_INS', 'REGE.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_MOD', 'REGE.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_ELI', 'REGE.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_DEV_SEL', 'REGE.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_PER_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOV_INS', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOV_MOD', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOV_ELI', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOV_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOVDIN_SEL', 'MOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TMOV_SEL', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOVD_INS', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOVD_MOD', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOVD_ELI', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOVD_SEL', 'MOV.1');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_TMOV_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_CAOR_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_GES_SEL', 'REPMOV');
select pxp.f_insert_trol_procedimiento_gui ('Administrador CCB', 'CCB_MOVDIN_SEL', 'REPMOV');

/********************************************F-DAT-RAC-CCB-0-15/03/2015********************************************/

