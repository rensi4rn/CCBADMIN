<?php  
  $datos = $dataSource->getParameter('datos');
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
    tr.firmas  td {
    	border-top:1pt solid black;
    	border-left:1pt solid black;
    	border-right:1pt solid black;
    	border-bottom:1pt solid black;
    	
    }
    tr.titulo  td {
    	border-top:none;
    	border-left:none;
    	border-right:none;
    	border-bottom:none;
    	
    }
	tr  td {border-bottom:1pt solid black;}
	
	
</style>
</head>
<body>
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="0" cellpadding="0" border="0">
	<tr class="titulo"> 
		<td align="left">
			<img  style="width: 150px;" src="./../../../lib/imagenes/logos/logo.png" alt="Logo">
		</td>
		<td>
		   <b><font size="14">Comprobante de Ofrendeas, Egresos y Transferencias en Administración<br>
		   <?php  echo $datos['v_mes'].' de '.$datos['v_gestion'].',  '.$datos['v_casa_oracion'].' ('.$datos['v_codigo'].') - '.$datos['v_region']?> </font></b>
	     </td>
	     
	</tr>
		
	</table>
	<br>
	<br>
    <table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr class="border_bottom">
	  	<td  colspan="2" align="left"   width="60%" style="{border-bottom:1pt solid black;}"> <font size="11"><b>I)  SALDOS PREVIOS</b></font></td>
	  	<td align="left" width="40%"> <font size="11"><b><?php echo number_format($datos['v_total_saldo_adm'], 2) ?></b></font></td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="30%" style="{border-bottom:1pt solid black;}"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_adm_construccion'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_adm_piedad'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_adm_viaje'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_adm_especial'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_adm_mantenimiento'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  
	</table>
	<br> 
	<table>
	<tr>
		 <td colspan="2"><font size="11"><b>II) COLECTAS Y DEVOLUCIONES</b></font></td>	
	</tr>
	<tr><td>
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr>
	  	<td  colspan="2" align="left"  width="70%"> <font size="11"><b> a)  COLECTAS DEL MES </b></font></td>
	  	<td align="right" width="30%"> <font size="11"><b><?php echo number_format($datos['v_total_colecta'], 2) ?></b></font></td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_colecta_construccion'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_colecta_piedad'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	 
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_colecta_viaje'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	   <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_colecta_especial'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_colecta_mantenimiento'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	</table>
	</td><td>
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr>
	  	<td  colspan="2" align="left"  width="70%"> <font size="11"><b>b)  DEVOLUCIONES DEL MES </b></font></td>
	  	<td align="right" width="30%"> <font size="11"><b><?php echo number_format($datos['v_total_ing_devolucion'], 2) ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></font></td>
	  </tr>
	  
	  <tr>   
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_devolucion_construccion'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_devolucion_piedad'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_devolucion_viaje'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_devolucion_especial'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_devolucion_mantenimiento'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr> 
	</table>
	</td></tr>
	</table>
	<table>
	<tr>
		 <td colspan="2"><font size="11"><b>III) TRASPASOS</b></font></td>	
	</tr>
	<tr><td>
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr>
	  	<td  colspan="2" align="left"  width="70%"> <font size="11"><b>a)  INGRESOS </b></font></td>
	  	<td align="right" width="30%"> <font size="11"><b><?php echo number_format($datos['v_total_ing_traspasos'], 2) ?></b></font></td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_traspasos_construccion'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_traspasos_piedad'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	 
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_traspasos_viaje'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	   <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_traspasos_especial'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_ing_traspasos_mantenimiento'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	</table>
	</td><td>
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr>
	  	<td  colspan="2" align="left"  width="70%"> <font size="11"><b>b)  EGRESOS </b></font></td>
	  	<td align="right" width="30%"> <font size="11"><b><?php echo number_format($datos['v_egre_traspasos_construccion'], 2) ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></font></td>
	  </tr>
	  
	  <tr>   
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_egre_traspasos_construccion'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_egre_traspasos_piedad'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_egre_traspasos_viaje'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_egre_traspasos_especial'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="40%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_egre_traspasos_mantenimiento'], 2) ?></td>
	  	<td align="left" width="30%">&nbsp;</td>
	  </tr>
	</table>
	</td></tr>
	</table>
	<br> 
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr>
	  	<td  colspan="2" align="left"   width="60%"> <font size="11"><b>IV) EGRESOS DE LA ADMINISTRACION</b></font></td>
	  	<td align="left" width="40%"> <font size="11"><b><?php echo number_format($datos['v_total_egresos_adm_tmp'], 2) ?></b></font></td>
	  </tr>
	 
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_total_egresos_adm_construccion_tmp'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	   <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_total_egresos_adm_piedad_tmp'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_total_egresos_adm_viaje_tmp'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_total_egresos_adm_especial_tmp'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	 
	  
	   <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_total_egresos_adm_mantenimiento_tmp'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  
	</table>
	<br> 
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.5">
	  <tr>
	  	<td  colspan="2" align="left"   width="60%"> <font size="11"><b>V)  SALDO ACTUAL (En administración)<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (v) = (i) + (ii.a) + (ii.b) + (iii.a) - (iii.b) - (iv)</b></font></td>
	  	<td align="left" width="40%"> <font size="11"><b><?php echo number_format($datos['v_total_saldo_mes'], 2) ?></b></font></td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Construcción</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_mes_construccion'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Piedad</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_mes_piedad'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	 
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Viaje</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_mes_viaje'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	   <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Especial</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_mes_especial'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	<td align="left" width="30%"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Mantenimiento</b></td>
	  	<td align="right" width="30%"> <?php echo number_format($datos['v_saldo_mes_mantenimiento'], 2) ?></td>
	  	<td align="left" width="40%">&nbsp;</td>
	  </tr>
	</table>
<br> <br>
 
 
<table width="100%" cellspacing="0" cellpadding="0" border="1">
	<tbody><tr class="firmas">
		<td align="center" width="33%" class="td_label"><span><b>Resp Tesorero Casa Oración</b> </span></td>
		<td align="center" width="33%" class="td_label"><span><b>Tesorero (Resp. Regional)</b> </span></td>
		<td align="center" width="33%" class="td_label"><span><b>Fiscal</b> </span></td>
	</tr>
	<tr class="firmas">
		<td width="33%" class="td_label"><br><br><br></td>
		<td width="33%" class="td_label"><br><br><br></td>
		<td width="33%" class="td_label"><br><br><br></td>
	</tr>
	<tr class="firmas">
		<td width="33%" class="td_label"><span></span></td>
		<td width="33%" class="td_label"><span></span></td>
		<td width="33%" class="td_label"><span></span></td>
	</tr>
</tbody></table>
      
<br><br>
<font size="8">
     <b>NOTAS:</b><br>   
     -  El saldo administrativo debe ser igual al arqueo de caja (Si falta dinero es responsabilidad del <b>Tesorero de la Casa Oración</b> reponer el faltante)
<br>     
     - (1) La primera hoja se entrega firmada al <b>Tesorero (Resp. Regional)</b> con todos los respaldo originales  (facturas, recibos)
     antes del día 10 de cada mes subsiguiente, 
     (2) la segunda hoja se queda como respaldo en la casa de oración origen</b> 
</font></body></html>