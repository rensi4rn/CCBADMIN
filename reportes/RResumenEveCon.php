<?php

// Extend the TCPDF class to create custom MultiRow
class RResumenEveCon extends  ReportePDF {
	var $datos_titulo;
	var $datos_detalle;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $cantidad_columnas_estaticas;
	var $s1;
	var $s2;
	var $s3;
	var $s4;
	var $t1;
	var $t2;
	var $t3;
	var $t4;
	
	function datosHeader ( $detalle, $totales) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;
		$this->datos_titulo = $totales;
		$this->subtotal = 0;
		$this->SetMargins(10, 30, 5);
	}
	
	function Header() {
		
		//formato de fecha
		$newDate = date("d-m-Y", strtotime($this->objParam->getParametro('hasta')));
		
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,40,20);
		$this->ln(5);
		$this->SetFont('','BU',12);		
		$this->Cell(0,5,"INFORME ESPIRITUAL",0,1,'C');		
		$this->Ln(1);
		
		if($this->objParam->getParametro('hasta') == 'bautizo'){
			$this->Cell(0,5,"BAUTISMOS",0,1,'C');	
		}
		else {
			$this->Cell(0,5,"Santas Cenas",0,1,'C');	
		}
		$this->Ln(1);
		
		$this->Cell(0,5,"Al ".$this->objParam->getParametro('hasta'),0,1,'C');		
		
		$this->Ln(3);
		$this->SetFont('','B',10);
		
		
		
   }
   
   function generarReporte() {
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		
		$sw = false;
		$concepto = '';
		$this->generarCabecera();
		$this->Ln(4);
		$this->generarCuerpo($this->datos_detalle);
		
		$this->cerrarCuadro();
		$this->Ln(4);
		$this->cerrarCuadroFinal();
		
		
	} 

    function generarCabecera(){
    	
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(10,90,25,25,25,25);
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
            			'nro'  => 'Nro',
                        'casa' => 'Región/Casa Oración',
                        's2' => 'Hermanos',
                        's3' => 'Hermanas',
                        's4' => 'Total');
                         
        $this-> MultiRow($RowArray,false,1);
    }
	
	function generarCuerpo($detalle){
		
		$count = 1;
		$sw = 0;
		$ult_region = '';
		$fill = 0;
		
		$this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
		
		$this->s1 = 0;
		$this->s2 = 0;
		$this->s3 = 0;
		
		$this->t1 = 0;
		$this->t2 = 0;
		$this->t3 = 0;
		
		
		foreach ($detalle as $val) {
				
			if($sw == 1){
				if($ult_region != $val["nombre_region"]){
					$sw = 0;
					$count = 1;
					$this->cerrarCuadro();
					$this->Ln(4);
					$this->s1 = 0;
					$this->s2 = 0;
					$this->s3 = 0;
					
				}
				
				
			
			}	
				
			if($sw == 0){
				$fill = 0;
				$this->imprimirTitulo($val["nombre_region"],$fill);
				$fill = !$fill;
				$sw = 1;
				$ult_region = $val["nombre_region"];
			}	
			
			
			
			$this->imprimirLinea($val,$count,$fill);
			$fill = !$fill;
			$count = $count + 1;
			
			
			
			
		}
		
		
		
	}	
	
	function imprimirLinea($val,$count,$fill){	
		$conf_par_tablewidths=array(10,90+25,25,25,25);
        $conf_par_tablealigns=array('C','L','R','R','R','R');
        $conf_par_tablenumbers=array(0,0,0,0,0,0);
		$conf_tableborders=array('LR','LR','LR','LR','LR','LR');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$val2 = $this->caclularMontos($val);
		
		
		$casa = "\t\t\t\t\t\t".$val['nombre_co'];
		$total = $val['cantidad_hermano'] + $val['cantidad_hermana'];
		$RowArray = array('nro'  => $count,
                          'casa' => $casa,
                          's2' => (int)$val['cantidad_hermano'],
                          's3' => (int)$val['cantidad_hermana'],
                          's4' => (int)$total);
                         
        $this-> MultiRow($RowArray,$fill,1);
			
	}
	
	function imprimirTitulo($titulo,$fill){
		$conf_par_tablewidths=array(10,90+25+25+25+25);
        $conf_par_tablealigns=array('C','L');
        $conf_par_tablenumbers=array(0,0);
		$conf_tableborders=array('LRTB','LRTB','LRTB','LRTB','LRTB','LRTB');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$val2 = $this->caclularMontos($val);
		
		
		$RowArray = array(
            			'nro'  => $count,
                        'casa' => $titulo);
                         
        $this-> MultiRow($RowArray,$fill,1);
		
	}
	
	function caclularMontos($val){
		$retorno = Array();
		
		$this->s1 = $this->s1 + $val['cantidad_hermano'];
		$this->s2 = $this->s2 + $val['cantidad_hermana'];
		$this->s3 = $this->s3 + $val['cantidad_hermano'] + $val['cantidad_hermana'];
		$this->t1 = $this->t1 + $val['cantidad_hermano'];
		$this->t2 = $this->t2 + $val['cantidad_hermana'];
		$this->t3 = $this->t3 + $val['cantidad_hermano'] + $val['cantidad_hermana'];
		
		return $retorno;
	}


  function cerrarCuadro(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	    $conf_par_tablewidths=array(10 + 90 + 25,25,25,25,25);
            $conf_par_tablealigns=array('R','R','R','R','R');
            $conf_par_tablenumbers=array(0,0,0,0,0);
	   	    $conf_par_tableborders=array('T',LRTB,LRTB,LRTB,LRTB);
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Subtotal: ',
	                    's1' => intval($this->s1),
	                    's2' => intval($this->s2),
	                    's3' => intval($this->s3)
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }
  
   function cerrarCuadroFinal(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	    $conf_par_tablewidths=array(10 + 90 + 25,25,25,25);
            $conf_par_tablealigns=array('R','R','R','R','R');
            $conf_par_tablenumbers=array(0,0,0,0,0);
	   	    $conf_par_tableborders=array('T',LRTB,LRTB,LRTB,LRTB);
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'TOTAL: ',
	                    't1' => intval($this->t1),
	                    't2' => intval($this->t2),
	                    't3' => intval($this->t3)
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }

}
?>

