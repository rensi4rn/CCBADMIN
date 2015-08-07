<?php
// Extend the TCPDF class to create custom MultiRow
class RAgenda extends  ReportePDF {
	var $datos_titulo;
	var $datos_detalle;
	var $desde;
	var $hasta;
	var $nivel;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $cantidad_columnas_estaticas;
	var $codigos;
	var $total_activo;
	var $total_pasigo;
	var $total_patrimonio;
	var $comunicado;
	var $tipo_imp;
	
	function datosHeader ( $detalle, $desde, $hasta, $comunicado) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;
		$this->desde = $desde;
		$this->hasta = $hasta;
		$this->comunicado = $comunicado;
		
		$this->tipo_imp =  $this->objParam->getParametro('tipo_imp');
		$this->SetMargins(5, 22, 10);
		
		
		
	}
	
	function Header() {
		
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 60,5,32.4,14.4);
		
		if($this->tipo_imp == 'doble'){
		   $this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 115,5,32.4,14.4);
		}
		
		$titulo = 'Agenda CCB';
		$titulo2 = 'Del '.$this->desde.' al '.$this->hasta;	
			
		//cabecera del reporte
		$this->SetFont('','B',10);
		
		
		$this->Cell(0,3 ,$titulo,'',0,'L');
		if($this->tipo_imp == 'doble'){
			$this->Cell(3,6 , $titulo,'',0,'R');
		}
		
		
		$this->ln();
		
		$this->Cell(0,3 ,$titulo2,'',0,'L');
		if($this->tipo_imp == 'doble'){
			$this->Cell(3,6 , $titulo2,'',0,'R');	
		}
		
		$this->ln();
		
	}
	
	function Footer() {
		
		if($this->tipo_imp == 'doble'){
		    $this->setY(-15);
			$ormargins = $this->getOriginalMargins();
			$this->SetTextColor(0, 0, 0);
			//set style for cell border
			$line_width = 0.85 / $this->getScaleFactor();
			$this->SetLineStyle(array('width' => $line_width, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
			$ancho = round(($this->getPageWidth() - $ormargins['left'] - $ormargins['right']) / 3);
			$ancho = ($ancho/2) -2;
			
			$this->Ln(2);
			$cur_y = $this->GetY();
			//$this->Cell($ancho, 0, 'Generado por XPHS', 'T', 0, 'L');
			$this->Cell($ancho, 0, 'Usuario: '.$_SESSION['_LOGIN'], '', 0, 'L');
			$pagenumtxt = 'Página'.' '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
			$this->Cell($ancho, 0, $pagenumtxt, '', 0, 'C');
			$this->Cell($ancho, 0, $_SESSION['_REP_NOMBRE_SISTEMA'], '', 0, 'R');
			
			$this->Cell(15, 0, '', '', 0, 'R');
			
			
			$this->Cell($ancho, 0, 'Usuario: '.$_SESSION['_LOGIN'], '', 0, 'L');
			$pagenumtxt = 'Página'.' '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
			$this->Cell($ancho, 0, $pagenumtxt, '', 0, 'C');
			$this->Cell($ancho, 0, $_SESSION['_REP_NOMBRE_SISTEMA'], '', 0, 'R');
			
			
			$this->Ln();
			$fecha_rep = date("d-m-Y H:i:s");
			$this->Cell(($ancho*3), 0, "Fecha : ".$fecha_rep, '', 0, 'L');
			
			$this->Cell(15, 0, '', '', 0, 'R');
			$this->Cell($ancho, 0, "Fecha : ".$fecha_rep, '', 0, 'L');
			
			$this->Ln($line_width);	
			
			$this->Ln();
			$barcode = $this->getBarcode();
			$style = array(
						'position' => $this->rtl?'R':'L',
						'align' => $this->rtl?'R':'L',
						'stretch' => false,
						'fitwidth' => true,
						'cellfitalign' => '',
						'border' => false,
						'padding' => 0,
						'fgcolor' => array(0,0,0),
						'bgcolor' => false,
						'text' => false,
						'position' => 'R'
					);
		}
		else{
			parent::Footer();
			
		}
	}
	
	
	
	function setCabeceraDet($desc_evento){
		       $this->SetFont('','B',9);
		       $this->Cell(97,3.5,$desc_evento,'',0,'C');
			   
			   if($this->tipo_imp == 'doble'){
			   		$this->Cell(8,3.5,'','',0,'C');
			   		$this->Cell(97,3.5,$desc_evento,'',0,'C');
			   }
			   
			   $this->ln();
			   
			   $this->Cell(24,3.5,'Fecha','LTR',0,'C');
			   $this->Cell(40,3.5,'Localidad','LTR',0,'C');
			   $this->Cell(33,3.5,'Atiende','LTR',0,'C');
			   
			   
			   if($this->tipo_imp == 'doble'){
				   $this->Cell(10,3.5,'','',0,'L');
				   
				   $this->Cell(24,3.5,'Fecha','LTR',0,'C');
				   $this->Cell(40,3.5,'Localidad','LTR',0,'C');
				   $this->Cell(33,3.5,'Atiende','LTR',0,'C');
			   }
			   $this->ln();
	}
	
	function setCuerpoDet($val){
		       	
		       $date = $this->getDia($val['num_dia']).' '.$val['fecha_programada'].'-'.$val['hora'];
		       //$loc = $this->calText( '('.$val['obs_region'].') '.$val['desc_lugar'].', '.$val['desc_casa_oracion'],31);
			   
			   if(strtoupper(trim($val['desc_lugar'])) == strtoupper(trim($val['desc_casa_oracion']))){
			   	 $loc ='('.$val['obs_region'].') '.$val['desc_casa_oracion'];
			   }
			   else{			   	
		          $loc ='('.$val['obs_region'].') '.$val['desc_lugar'].', '.$val['desc_casa_oracion'];
			   }
			   
			   $obre = $this->calText( $val['desc_obrero'],22);
			   
			   
			   
			   $this->SetFont('','',6);
			   
			 
			    if($this->tipo_imp == 'doble'){
			        $conf_par_tablewidths=array(24,40,33,10,24,40,33);
					$conf_par_tablealigns=array('L','L','L','L','L','L','L');
		            $conf_par_tablenumbers=array(0,0,0,0,0,0,0);
		            $conf_tableborders=array('LTR','LTR','LTR','L','LTR','LTR','LTR');
		            $conf_tabletextcolor=array();
				}
				else{
					$conf_par_tablewidths=array(24,40,33);
					$conf_par_tablealigns=array('L','L','L');
		            $conf_par_tablenumbers=array(0,0,0);
		            $conf_tableborders=array('LTR','LTR','LTR');
		            $conf_tabletextcolor=array();
				}	
		       
			   	
				$this->tablewidths=$conf_par_tablewidths;
	            $this->tablealigns=$conf_par_tablealigns;
	            $this->tablenumbers=$conf_par_tablenumbers;
	            $this->tableborders=$conf_tableborders;
	            $this->tabletextcolor=$conf_tabletextcolor;
				
			   	 $RowArray = array('fecha'  =>  $date,
			   	                   'desc'  =>  $loc,
			   	                   'atn'  =>  $obre,
								   'esp'  =>  '',
								   'fecha2'  =>  $date,
			   	                   'desc2'  =>  $loc,
			   	                   
			   	                   'atn2'  =>  $obre); 
			   	 $this-> MultiRow($RowArray,false,0);
				 
				
			   
			   
			   if($val['obs'] != ''){
			   	
					if($this->tipo_imp == 'doble'){
					    $conf_par_tablewidths=array(97,10,97);
					    $conf_par_tablealigns=array('L','L','L');
				        $conf_par_tablenumbers=array(0,0,0,0);
				        $conf_tableborders=array('LTR','L','LTR');
				        $conf_tabletextcolor=array();
				    }
					else{
					    $conf_par_tablewidths=array(97);
						$conf_par_tablealigns=array('L');
				        $conf_par_tablenumbers=array(0);
				        $conf_tableborders=array('LTR');
				        $conf_tabletextcolor=array();
					}
		       
			   	
					$this->tablewidths=$conf_par_tablewidths;
		            $this->tablealigns=$conf_par_tablealigns;
		            $this->tablenumbers=$conf_par_tablenumbers;
		            $this->tableborders=$conf_tableborders;
		            $this->tabletextcolor=$conf_tabletextcolor;
					
				   	 $RowArray = array('obs'  =>  'OBS: '.$val['obs'],
									   'esp'  =>  '',
									   'obs2'  =>  'OBS: '.$val['obs']); 
			   	  $this-> MultiRow($RowArray,false,0);
			   }
	}
	
	function cerrarDet(){
		
		       $this->SetFont('','',8);
			   $this->Cell(24,3.5,'','T',0,'L');
			   $this->Cell(40,3.5,'','T',0,'L');
			   $this->Cell(33,3.5,'','T',0,'L');
			   if($this->tipo_imp == 'doble'){
				   $this->Cell(10,3.5,'','',0,'L');				   
				   $this->Cell(24,3.5,'','T',0,'L');
				   $this->Cell(40,3.5,'','T',0,'L');
				   $this->Cell(33,3.5,'','T',0,'L');
			   }
			   $this->ln();
	}
	
	
	
	function generarReporte() {
		
		$this->total_activo = 0;
	    $this->total_pasigo = 0;
	    $this->total_patrimonio = 0;		
		
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		//configuracion de la tabla
		$this->SetFont('','',9);
		$sw_titulo = 1;
		$anterior = '';
		
        foreach ($this->datos_detalle as $val) {
	       		
			
			if ($sw_titulo == 1 || $anterior != $val['desc_evento']){
			   	
				if ($sw_titulo != 1){
					//cerramos la anterior linea
					$this->cerrarDet();
				}
			   $this->revisarfinPagina();
			   $this->setCabeceraDet($val['desc_evento']);
			}
			
			$this->setCuerpoDet($val);	
			
			$anterior = $val['desc_evento'];
			$sw_titulo = 0;
			
		}	
		$this->cerrarDet();		
		$this->ln();
		
		if( isset($this->comunicado) &&  $this->comunicado != ''){
			$this->imprimirComunicado();			
		}
	}
	
	function revisarfinPagina(){
		$dimensions = $this->getPageDimensions();
		$hasBorder = false; //flag for fringe case
		
		$startY = $this->GetY();
		$this->getNumLines($row['cell1data'], 80);
		
		if (($startY + 4 * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
		    	
			$k = 	($startY + 4 * 6) + $dimensions['bm'] - ($dimensions['hk']);
			for($i=0;$i<=k;$i++){
				$this->ln();
				$this->ln();
				$this->ln();
				$this->ln();
				$this->ln();
				$this->ln();
			}
		    
		} 
		 
		
	}
	
	
	function imprimirComunicado(){
		
		
		       
			   $this->SetFont('','B',9);
		       $this->Cell(97,3.5,'Comunicados','',0,'C');
			   $this->Cell(8,3.5,'','',0,'C');
			   $this->Cell(97,3.5,'Comunicados','',0,'C');
			   $this->ln();
			   
			   	$this->SetFont('','',9);
				$conf_par_tablewidths=array(97,10,97);
		        $conf_par_tablealigns=array('L','L','L');
		        $conf_par_tablenumbers=array(0,0,0,0);
		        $conf_tableborders=array('LTR','L','LTR');
		        $conf_tabletextcolor=array();
			   	
				$this->tablewidths=$conf_par_tablewidths;
	            $this->tablealigns=$conf_par_tablealigns;
	            $this->tablenumbers=$conf_par_tablenumbers;
	            $this->tableborders=$conf_tableborders;
	            $this->tabletextcolor=$conf_tabletextcolor;
				
			   	 $RowArray = array('obs'  =>  $this->comunicado,
								   'esp'  =>  '',
								   'obs2'  => $this->comunicado); 
			   	 $this-> MultiRow($RowArray,false,0);
				 $this->cerrarDet();		
		         $this->ln();
			   
		
	}
	
	function calText($text, $tam){
		
		if (strlen ($text) > $tam ){
			return substr ( $text ,0, $tam);
		}
		else{
			return $text;
		}
	}
	function getDia($num){
		switch ($num) {
		    case 1:
		        return "Lu";
		        break;
		    case 2:
		          return "Ma";
		        break;
		    case 3:
		          return "Mi";
		        break;
			case 4:
		          return "Ju";
		        break;
			case 5:
		          return "Vi";
		        break;
			case 6:
		          return "Sa";
		        break;
			case 0:
		          return "Do";
		        break;
		}
	}
	
	
}
?>