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
