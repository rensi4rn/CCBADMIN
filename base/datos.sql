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


INSERT INTO segu.tsubsistema ("id_subsistema", "codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES (5, E'CCB', E'ADMCCB', E'2013-01-04', E'CCB', NULL, E'admin', NULL);


----------------------------------
--DEF DE INTERFACES
---------------------------------


select pxp.f_insert_tgui ('ADMCCB', '', 'ADM', 'si', , '', 1, '', '', 'CCB');
select pxp.f_insert_tgui ('Parametros', '', 'PAR', 'si', 1, '', 2, '', '', 'CCB');
select pxp.f_insert_tgui ('Regiones', 'Regiones de la CCB', 'REG', 'si', 1, 'sis_admin/vista/region/Region.php', 3, '', 'Region', 'CCB');
select pxp.f_insert_tgui ('Tipos de Ministerio', 'Tipos de Ministerio', 'TIPMIN', 'si', 2, 'sis_admin/vista/tipo_ministerio/TipoMinisterio.php', 3, '', 'TipoMinisterio', 'CCB');
select pxp.f_insert_tgui ('Tipos de Eventos', 'Eventos', 'EVEN', 'si', 3, 'sis_admin/vista/evento/Evento.php', 3, '', 'Evento', 'CCB');
select pxp.f_insert_testructura_gui ('ADM', 'SISTEMA');
select pxp.f_insert_testructura_gui ('PAR', 'ADM');
select pxp.f_insert_testructura_gui ('REG', 'PAR');
select pxp.f_insert_testructura_gui ('TIPMIN', 'PAR');
select pxp.f_insert_testructura_gui ('EVEN', 'PAR');



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

