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
	
	function datosHeader ( $detalle, $desde, $hasta) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;
		$this->desde = $desde;
		$this->hasta = $hasta;
		
		$this->SetMargins(5, 20, 10);
		
	}
	
	function Header() {
		
		$titulo = 'COONGREGACIÓN CRISTIANA EN BOLIVIA';
		$titulo2 = 'Del '.$this->desde.' al '.$this->hasta;	
			
		//cabecera del reporte
		$this->SetFont('','B',10);
		
		
		$this->Cell(0,3 ,$titulo,'',0,'L');
		$this->Cell(3,6 , $titulo,'',0,'R');
		$this->ln();
		$this->Cell(0,3 ,$titulo2,'',0,'L');
		$this->Cell(3,6 , $titulo2,'',0,'R');	
		$this->ln();
		
	}
	
	function Footer() {
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
	
	
	
	function setCabeceraDet($desc_evento){
		       $this->SetFont('','B',9);
		       $this->Cell(97,3.5,$desc_evento,'',0,'C');
			   $this->Cell(8,3.5,'','',0,'C');
			   $this->Cell(97,3.5,$desc_evento,'',0,'C');
			   $this->ln();
			   
			   $this->Cell(24,3.5,'Fecha','LTR',0,'C');
			   $this->Cell(40,3.5,'Localidad','LTR',0,'C');
			   $this->Cell(33,3.5,'Atiende','LTR',0,'C');
			   
			   $this->Cell(10,3.5,'','',0,'L');
			   
			   $this->Cell(24,3.5,'Fecha','LTR',0,'C');
			   $this->Cell(40,3.5,'Localidad','LTR',0,'C');
			   $this->Cell(33,3.5,'Atiende','LTR',0,'C');
			   $this->ln();
	}
	
	function setCuerpoDet($val){
		       $date = $this->getDia($val['num_dia']).' '.$val['fecha_programada'].'-'.$val['hora'];
		       $loc = $this->calText( '('.$val['obs_region'].') '.$val['desc_casa_oracion'],31);
			   $obre = $this->calText( $val['desc_obrero'],22);
			   
			   $this->SetFont('','',6);
			   $this->Cell(24,3.5,$date,'LTR',0,'L');
			   $this->SetFont('','',7);
			   $this->Cell(40,3.5,$loc,'LTR',0,'L');
			   $this->Cell(33,3.5,$obre,'LTR',0,'L');
			   
			   
			   $this->Cell(10,3.5,'','',0,'L');
			   
			   $this->SetFont('','',6);
			   $this->Cell(24,3.5,$date,'LTR',0,'L');
			   $this->SetFont('','',7);
			   $this->Cell(40,3.5,$loc,'LTR',0,'L');
			   $this->Cell(33,3.5,$obre,'LTR',0,'L');
			   $this->SetFont('','',8);
			   $this->ln();
	}
	
	function cerrarDet(){
		       $this->SetFont('','',8);
			   $this->Cell(24,3.5,'','T',0,'L');
			   $this->Cell(40,3.5,'','T',0,'L');
			   $this->Cell(33,3.5,'','T',0,'L');
			   
			   $this->Cell(10,3.5,'','',0,'L');
			   
			   $this->Cell(24,3.5,'','T',0,'L');
			   $this->Cell(40,3.5,'','T',0,'L');
			   $this->Cell(33,3.5,'','T',0,'L');
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
			   $this->setCabeceraDet($val['desc_evento']);
			}
			
			$this->setCuerpoDet($val);	
			
			$anterior = $val['desc_evento'];
			$sw_titulo = 0;
			
		}	
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