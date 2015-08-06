<?php

// Extend the TCPDF class to create custom MultiRow
class RCbteRendicion extends  ReportePDF {
	var $datos_titulo;
	var $datos_detalle;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $cantidad_columnas_estaticas;
	
	function datosHeader ( $saldos, $rendiciones, $devoluciones, $titulo,$egresos) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		
		$this->datos_saldos = $saldos->getDatos();
		$this->datos_rendiciones = $rendiciones->getDatos();
		$this->datos_devoluciones = $devoluciones->getDatos();
		$this->datos_egresos = $egresos->getDatos();
		
		//var_dump($this->datos_saldos);exit;
		
		$this->datos_titulo = $titulo;
		
		$this->subtotal = 0;
		$this->subtotalret = 0;
		$this->SetMargins(10, 28, 5);
	}
	
	function Header() {
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.png', 10,5,45,20);
		$this->ln(5);
		$this->SetFont('','BU',12);
		
		$this->Cell(0,5,"Cbte de Rendición  del Mes de ".$this->datos_titulo['mes']." de ".$this->datos_titulo['gestion'],0,1,'C');
		$this->Ln(1);
		$this->Cell(0,5,"Casa de Oración: ".$this->datos_rendiciones[0]['desc_casa_oracion'],0,1,'C');
		$this->Ln(1);
		$this->Cell(0,5,"Obrero: ".$this->datos_saldos['v_desc_obrero'],0,1,'C');
		
		
		$this->Ln(2);
		$this->SetFont('','B',10);
		
		
		
		
		
   }
	
	function generarReporte() {
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		$this->ln(5);
		
		//generera saldo inicial
		$this->generarSaldoInicial();
		
		$this->ln(5);
		
		$this->generarReporteEgresos();
		$this->ln(5);
		
		//genera rendiciones
		$this->generarReporteRendiciones();
		$this->ln(5);
		
		
		$this->generarReporteDevoluciones();
		$this->ln(5);
		
		$this->generarSaldoActual();
		$this->ln(10);
		
		
		
		//$this->SetFont('','B',14);
		$this->writeHTML('<font size="12"><b><p>Total retenciones impositivas: '.number_format($this->subtotalret, 2).'</p></b></font>', true, false, true, false, '');	
		$this->ln(5);
		$this->colocarFirmas();
		
		
		
	} 
	
	
	/****************************************************
	*   (I)   REPORTE DE SALDO INICIAL POR RENDIR
	***************************************************/
	
	
	function generarSaldoInicial() {
		
		//definir subtitulo
		$this->SetFont('','B',10);
		$this->tablewidths=array(70,50);
		$this->tablealigns=array('L', 'C');
        $this->tablenumbers=array(0,1);
        $this->tableborders=array();
        $this->tabletextcolor=array();
		
		//var_dump($this->datos_saldos);
		//exit;
		$RowArray = array('tipo_concepto'=> '(I) Saldo por Rendir Anterior',
		                  'monto'=> $this->datos_saldos["v_total_saldo_adm"]);
		
		$this-> MultiRow($RowArray,false,1);
		
		
		$this->SetFont('','',9);
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(70,50);
        $conf_par_tablealigns=array('R','C');
        $conf_par_tablenumbers=array(0,1);
        $conf_tableborders=array();
        $conf_tabletextcolor=array();
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$RowArray = array('colecta'  => 'Construcción',
                        'monto'  => $this->datos_saldos["v_saldo_adm_construccion"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		
		$RowArray = array('colecta'  => 'Piedad',
                        'monto'  => $this->datos_saldos["v_saldo_adm_piedad"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		$RowArray = array('colecta'  => 'Viaje',
                        'monto'  => $this->datos_saldos["v_saldo_adm_viaje"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		$RowArray = array('colecta'  => 'Especial',
                        'monto'  => $this->datos_saldos["v_saldo_adm_especial"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		$RowArray = array('colecta'  => 'Mantenimineto',
                        'monto'  => $this->datos_saldos["v_saldo_adm_mantenimineto"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		
		
	} 
	
	
	
	/****************************************************
	*   (II)   REPORTE DE EGRESOS CONTRA RENDICION
	***************************************************/
	
	function generarReporteEgresos() {
		
		
		$sw = false;
		$concepto = '';
		$this->subtotal = 0;
		foreach ($this->datos_egresos as $val) {
			
			
			if ($concepto != $val['concepto']){
				
				if($sw){
				    $this->cerrarCuadro();
					$this->Ln(1);
				}
			   $sw = true;	
			   $this->subtotal = 0;
			   $concepto = $val['concepto'];
			   $this->generarCabecera('(II) Egresos por Rendir',  $val['desc_obrero']);
			}
			
			$this->generarCuerpo($val);
			$this->subtotal = $this->subtotal + $val['monto'];
			
		}
		
		$this->cerrarCuadro('Egresos por Rendir','(II)');
		
		
	} 
	
	
	
	/****************************************************
	*   (III)   REPORTE DE RENDICIONES
	***************************************************/
	
   
   function generarReporteRendiciones() {
		
		$sw = false;
		$concepto = '';
		$this->subtotal = 0;
		$this->subtotalret = 0;
		
		
		foreach ($this->datos_rendiciones as $val) {
			
			
			if ($concepto != $val['concepto']){
				
				if($sw){
				    $this->cerrarCuadro('retencion');
					$this->Ln(1);
				}
			   $sw = true;	
			   $this->subtotal = 0;
			   $concepto = $val['concepto'];
			   $this->generarCabecera('(III) Documentos en Rendición',  $val['desc_obrero'],'retencion');
			}
			
			$this->generarCuerpo($val,'retencion');
			$this->subtotal = $this->subtotal + $val['monto'];
			$this->subtotalret = $this->subtotalret + $val['retenciones'];
			
		}
		
		$this->cerrarCuadro('Documentos en Rendición','(III)','retencion');
		
		
	} 
   
    /****************************************************
	*   (IV)   DEVOLUCIONES
	***************************************************/
	
   function generarReporteDevoluciones() {
		
		
		$sw = false;
		$concepto = '';
		$this->subtotal = 0;
		foreach ($this->datos_devoluciones as $val) {
			
			
			if ($concepto != $val['concepto']){
				
				if($sw){
				    $this->cerrarCuadro();
					$this->Ln(1);
				}
			   $sw = true;	
			   $this->subtotal = 0;
			   $concepto = $val['concepto'];
			   $this->generarCabecera('(IV) Documentos en Devolución',  $val['desc_obrero']);
			}
			
			$this->generarCuerpo($val);
			$this->subtotal = $this->subtotal + $val['monto'];
			
		}
		
		$this->cerrarCuadro('Documentos en Devolución','(IV)');
		
		
	} 
   
   /****************************************************
	*   (V)   REPORTE DE SALDO ACTUALIZADO
	***************************************************/
	
	
	function generarSaldoActual() {
		
		//definir subtitulo
		$this->SetFont('','B',10);
		$this->tablewidths=array(70,50);
		$this->tablealigns=array('L', 'C');
        $this->tablenumbers=array(0,1);
        $this->tableborders=array();
        $this->tabletextcolor=array();
		
		//var_dump($this->datos_saldos);
		//exit;
		$RowArray = array('tipo_concepto'=> "(V) Saldo por Rendir a La Fecha \n   \t\t(V) = (I) + (II) - (III) - (IV)",
		                  'monto'=> $this->datos_saldos["v_total_saldo_act"]);
		
		$this-> MultiRow($RowArray,false,1);
		
		
		$this->SetFont('','',9);
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(70,50);
        $conf_par_tablealigns=array('R','C');
        $conf_par_tablenumbers=array(0,1);
        $conf_tableborders=array();
        $conf_tabletextcolor=array();
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$RowArray = array('colecta'  => 'Construcción',
                        'monto'  => $this->datos_saldos["v_saldo_act_construccion"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		
		$RowArray = array('colecta'  => 'Piedad',
                        'monto'  => $this->datos_saldos["v_saldo_act_piedad"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		$RowArray = array('colecta'  => 'Viaje',
                        'monto'  => $this->datos_saldos["v_saldo_act_viaje"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		$RowArray = array('colecta'  => 'Especial',
                        'monto'  => $this->datos_saldos["v_saldo_act_especial"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		$RowArray = array('colecta'  => 'Mantenimineto',
                        'monto'  => $this->datos_saldos["v_saldo_act_mantenimineto"]);
                         
        $this-> MultiRow($RowArray,false,1);
		
		
		
		
		
		
	} 
   
    /*******************************************
     *   FUNCIONES AUXILIARES
     *****************************************/

    function generarCabecera($titulo, $obrero,$retencion = ''){
    	
		
		//definir subtitulo
		$this->SetFont('','B',10);
		$this->tablewidths=array(20+ 25 + 80 +25 +15 +15 +20);
        $this->tablealigns=array('L');
        $this->tablenumbers=array(0);
        $this->tableborders=array();
        $this->tabletextcolor=array();
		$RowArray = array('tipo_concepto'=> $titulo);
		$this-> MultiRow($RowArray,false,1);
		
		if($retencion==''){
				//armca caecera de la tabla
				$conf_par_tablewidths=array(20,25,80,25,15,15 + 20);
		        $conf_par_tablealigns=array('C','C','C','C','C','C');
		        $conf_par_tablenumbers=array(0,0,0,0,0,0);
		        $conf_tableborders=array();
		        $conf_tabletextcolor=array();
				
				$this->tablewidths=$conf_par_tablewidths;
		        $this->tablealigns=$conf_par_tablealigns;
		        $this->tablenumbers=$conf_par_tablenumbers;
		        $this->tableborders=$conf_tableborders;
		        $this->tabletextcolor=$conf_tabletextcolor;
				
				$RowArray = array(
		            			'fecha'  => 'Fecha',
		                        'conlecta'  => 'Colecta' ,                        
		                        'obs'    => 'Obs',
		                        'monto' => 'Monto',
		                        'doc' => 'Doc',
		                        'num_doc' => 'Nº');
		                         
		        $this-> MultiRow($RowArray,false,1);	
		}
		else{
			//armca caecera de la tabla
				$conf_par_tablewidths=array(20,25,80,25,15,15,20);
		        $conf_par_tablealigns=array('C','C','C','C','C','C','C');
		        $conf_par_tablenumbers=array(0,0,0,0,0,0,0);
		        $conf_tableborders=array();
		        $conf_tabletextcolor=array();
				
				$this->tablewidths=$conf_par_tablewidths;
		        $this->tablealigns=$conf_par_tablealigns;
		        $this->tablenumbers=$conf_par_tablenumbers;
		        $this->tableborders=$conf_tableborders;
		        $this->tabletextcolor=$conf_tabletextcolor;
				
				$RowArray = array(
		            			'fecha'  => 'Fecha',
		                        'conlecta'  => 'Colecta' ,                        
		                        'obs'    => 'Obs',
		                        'monto' => 'Monto',
		                        'doc' => 'Doc',
		                        'num_doc' => 'Nº',
								'rev'=>'Ret');
		                         
		        $this-> MultiRow($RowArray,false,1);
			
		}
		
    }
	
	function generarCuerpo( $val, $retencion=''){
		
		
		if($retencion==''){
			$conf_par_tablewidths=array(20,25,80,25,15,15 + 20);
			$conf_par_tablealigns=array('L','L','L','R','L','R');
			$conf_par_tablenumbers=array(0,0,0,2,0,0);
		}
		else{
			$conf_par_tablewidths=array(20,25,80,25,15,15,20);
			$conf_par_tablealigns=array('L','L','L','R','L','R','R');
			$conf_par_tablenumbers=array(0,0,0,2,0,0,2);
		}
		
		$this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_tableborders;
	        $this->tabletextcolor=$conf_tabletextcolor;
		//configuracion de la tabla
		$this->SetFont('','',9);
        //define formato tipo de recibo
		$tipo = $this->getTipoDoc($val['tipo_documento']);	
		//formato de fecha
		
		$temp = '';
		
		$newDate = date("d-m-Y", strtotime($val['fecha']));
		
		if ($val['concepto'] == 'rendicion' or $val['concepto'] == 'contra_rendicion'){
			$temp = " \n Firmado por: ".$val['desc_obrero'];
		}
		
		if( isset($val['desc_ingas']) && $val['desc_ingas'] != ''){
			$obs = trim($val['obs'])."
		       (".trim($val['desc_ingas']).")\n".$temp;
		}
		else{
			$obs = trim($val['obs']).$temp;
		}
		
		if($retencion==''){
			$RowArray = array(
            			'fecha'  => $newDate,
                        'conlecta'  => $val['desc_tipo_movimiento'] ,                        
                        'obs'    => $obs,
                        'monto' => $val['monto'],
                        'doc' => $tipo,
                        'num_doc' => $val['num_documento']);
		}
		else{
			$RowArray = array(
            			'fecha'  => $newDate,
                        'conlecta'  => $val['desc_tipo_movimiento'] ,                        
                        'obs'    => $obs,
                        'monto' => $val['monto'],
                        'doc' => $tipo,
                        'num_doc' => $val['num_documento'],
						'rec' => $val['retenciones']);
		}
		
                         
        $this-> MultiRow($RowArray,false,1);
			
	}


  function cerrarCuadro($desc = '',$num = '', $retencion = ''){
  	
	   if($inicio != 'si'){
	   	    
			
			if($retencion==''){
				//si noes inicio termina el cuardro anterior
		   	    $conf_tp_tablewidths = array(20 +25 + 80,25);
		        $conf_tp_tablealigns = array('R','R');
		        $conf_tp_tablenumbers = array(0,2);
		        $conf_tp_tableborders = array(0,1);
			}
			else{
				//si noes inicio termina el cuardro anterior
		   	    $conf_tp_tablewidths = array(20 +25 + 80, 25, 15 + 15,20);
		        $conf_tp_tablealigns = array('R','R','R','R');
		        $conf_tp_tablenumbers = array(0,2,0,2);
		        $conf_tp_tableborders = array(0,1,0,1);
			}	
	   	    
			
			//coloca el total de egresos
			//coloca el total de la partida 
	        
	        $this->tablewidths=$conf_tp_tablewidths;
	        $this->tablealigns=$conf_tp_tablealigns;
	        $this->tablenumbers=$conf_tp_tablenumbers;
	        $this->tableborders=$conf_tp_tableborders;
	        
			if($retencion==''){
		        $RowArray = array( 
		                    'espacio'  =>  $num.' Total '.$desc.': ',
		                    'precio_total'  =>  $this->subtotal
		                  ); 
					      
			}
			else{
				$RowArray = array( 
	                    'espacio'  =>  $num.' Total '.$desc.': ',
	                    'precio_total'  =>  $this->subtotal,
	                    'espacio2' => 'Retenciones: ',
	                    'precio_ret'  =>  $this->subtotalret
	                  ); 
			}            
	        $this-> MultiRow($RowArray,false,1);
	   }
	   
	   
	
  }

  function getTipoDoc($tipo_documento){
        if($tipo_documento == 'recibo_sin_retencion'){
			$tipo = 'Recibo s/r';
		}
		else{
			if($tipo_documento == 'factura'){
			   $tipo = 'Factura';
		    }
			else{
			   if($tipo_documento == 'recibo_piedad'){
			        $tipo = 'Rec Piedad';
			    }
				else{
					if($tipo_documento == 'recibo'){
			            $tipo = 'Recibo';
				    }
					else{
					   $tipo = $tipo_documento;	
					}
				   
				}
		     }	
		} 
		
		return $tipo;
  }
  
  function colocarFirmas(){
  	
	$firmas = '<table width="100%" cellspacing="0" cellpadding="0" border="1">
					<tbody><tr class="firmas">
						<td align="center" width="33%" class="td_label"><span><b>Tesorero </b> </span></td>
						<td align="center" width="33%" class="td_label"><span><b>Obrero Resp. </b> </span></td>
						<td align="center" width="33%" class="td_label"><span><b>Fiscal</b> </span></td>
					</tr>
					<tr class="firmas">
						<td width="33%" class="td_label"><br><br><br></td>
						<td width="33%" class="td_label"><br><br><br></td>
						<td width="33%" class="td_label"><br><br><br></td>
					</tr>
					<tr class="firmas">
						<td width="33%" class="td_label"><span></span></td>
						<td width="33%" class="td_label" align="center"><span>'.$this->datos_saldos['v_desc_obrero'].'</span></td>
						<td width="33%" class="td_label"><span></span></td>
					</tr>
				</tbody></table>';
				
				
	$this->writeHTML($firmas, true, false, true, false, '');				
  }
}
?>

