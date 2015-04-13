

	
	<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0">
		<tr>
			<td width="47.5%" align="left">
				
				<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.3">
	  
				  <tr>
				  	<td align="center" width="70%"> <b>Obrero</b></td>
				  	<td align="center" width="30%"><b>Número</b></td>
				  </tr>
				  <?php for($k = $inicio; $k < $fin - $tam_pagina; $k++){   ?>
				      <tr>
					  	<td align="left" width="70%"> <?php echo $datos[$k]['desc_persona'].'<br>'.$datos[$k]['desc_tipo_ministerio'].'<font size=2> &nbsp;'.$datos[$k]['desc_region'].'</font>'; ?></td>
					  	<td align="right" width="30%"> <?php echo $datos[$k]['celular1'].'<br>'.$datos[$k]['telefono1']; ?></td>
					  </tr>
				  <?php } ?>
				</table>
				
				
			</td>
			<td width="5%" align="left"></td>
			<td width="47.5%" align="right">
				
				<table width="100%" style="width: 100%; text-align: center;" cellspacing="1" cellpadding="1" border="0.3">
	  
				  <tr>
				  	<td align="center" width="70%"><b>Obrero</b></td>
				  	<td align="center" width="30%"><b>Número</b></td>
				  </tr>
				  <?php for($k = $k; $k < $fin; $k++){   ?>
				      <tr>
					  	<td align="left" width="70%"> <?php echo $datos[$k]['desc_persona'].'<br>'.$datos[$k]['desc_tipo_ministerio'].'<font size=2> &nbsp;'.$datos[$k]['desc_region'].'</font>'; ?></td>
					  	<td align="right" width="30%"> <?php echo $datos[$k]['celular1'].'<br>'.$datos[$k]['telefono1']; ?></td>
					  </tr>
				  <?php } ?>
				</table>
				
				
			</td>
        </tr>
    </table> 
	
	
