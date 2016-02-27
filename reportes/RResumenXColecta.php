<?php

// Extend the TCPDF class to create custom MultiRow
class RResumenXColecta extends  ReportePDF {
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
	
	var $c1;
	var $c2;
	var $c3;
	var $c4;
	
	var $t1;
	var $t2;
	var $t3;
	var $t4;
	
	
	var $total;
	
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
		$this->Cell(0,5,"ESTADO CONSOLIDADO DE MOVIMIENTO ECONOMICO",0,1,'C');		
		$this->Ln(1);
		$this->Cell(0,5,"Expresado en Bolivianos",0,1,'C');		
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
		$this->cerrarCasaOracion();
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
                        'inicio' => 'Saldo Inicial',
                        'ingreso' => 'Ingresos',
                        'egreso' => 'Egresos',
                        'final' => 'Saldo Final');
                         
        $this-> MultiRow($RowArray,false,1);
    }
	
	function generarCuerpo($detalle){
		
		$count = 1;
		$sw = 0;
		$sw1 = 0;
		$ult_region = '';
		$ult_casa = '';
		$fill = 0;
		
		$this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
		
		$this->s1 = 0;
		$this->s2 = 0;
		$this->s3 = 0;
		$this->s4 = 0;
		
		$this->c1 = 0;
		$this->c2 = 0;
		$this->c3 = 0;
		$this->c4 = 0;
		
		$this->t1 = 0;
		$this->t2 = 0;
		$this->t3 = 0;
		$this->t4 = 0;
		
		foreach ($detalle as $val) {
				
				
			if($sw1 == 1){
				if($ult_casa != $val["nombre_casa_oracion"]){
					$sw1 = 0;
					$count = 1;
					$this->cerrarCasaOracion();
					$this->Ln(4);
					$this->c1 = 0;
					$this->c2 = 0;
					$this->c3 = 0;
					$this->c4 = 0;
					$this->revisarfinPagina();
				}
				
				
			
			}	
				
				
			if($sw == 1){
				if($ult_region != $val["nombre_region"]){
					$sw = 0;
					$count = 1;
					$this->cerrarCuadro();
					$this->Ln(4);
					$this->s1 = 0;
					$this->s2 = 0;
					$this->s3 = 0;
					$this->s4 = 0;
					
					$this->revisarfinPagina();
				}
				
				
			
			}	
				
			if($sw == 0){
				$fill = 0;
				$this->imprimirTitulo($val["nombre_region"],$fill);
				$fill = !$fill;
				$sw = 1;
				$ult_region = $val["nombre_region"];
			}
			
			if($sw1 == 0){
				$fill = 0;
				$this->imprimirCasaOracion($val["nombre_casa_oracion"],$fill);
				$fill = !$fill;
				$sw1 = 1;
				$ult_casa = $val["nombre_casa_oracion"];
			}	
			
			
			
			$this->imprimirLinea($val,$count,$fill);
			$fill = !$fill;
			$count = $count + 1;
			
			
			
			
		}
		
		
		
	}	
	
	function imprimirLinea($val,$count,$fill){	
		$conf_par_tablewidths=array(10,90,25,25,25,25);
        $conf_par_tablealigns=array('C','L','R','R','R','R');
        $conf_par_tablenumbers=array(0,0,2,2,2,2);
		$conf_tableborders=array('LR','LR','LR','LR','LR','LR');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$val2 = $this->caclularMontos($val);
		
		
		$RowArray = array(
            			'nro'  => $count,
                        'casa' => "\t\t\t\t\t\t".$val['nombre_colecta'],
                        'inicio' => $val2['ingreso_inicial'],
                        'ingreso' => $val2['ingreso'],
                        'egreso' => $val2['egreso'],
                        'final' => $val2['saldo_adm']);
                         
        $this-> MultiRow($RowArray,$fill,1);
			
	}
	
	function imprimirTitulo($titulo,$fill){
		$conf_par_tablewidths=array(10,90+25+25+25+25);
        $conf_par_tablealigns=array('C','L');
        $conf_par_tablenumbers=array(0,0,1,1,1,1);
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
	
	function imprimirCasaOracion($titulo,$fill){
		$conf_par_tablewidths=array(10,90+25+25+25+25);
        $conf_par_tablealigns=array('C','L');
        $conf_par_tablenumbers=array(0,0,1,1,1,1);
		$conf_tableborders=array('LRTB','LRTB','LRTB','LRTB','LRTB','LRTB');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		//$val2 = $this->caclularMontos($val);
		
		
		$RowArray = array(
            			'nro'  => $count,
                        'casa' => "\t\t\t\t\t".$titulo);
                         
        $this-> MultiRow($RowArray,$fill,1);
		
	}
	
	function caclularMontos($val){
		$retorno = Array();
		
		 
		
		$retorno['ingreso_total'] = $val['ingreso_traspasos'] + $val['ingreso_colectas'] + $val['ingreso_inicial'];
		$retorno['saldo_adm'] =  $retorno['ingreso_total'] + $val['devolucion'] - $val['egreso_traspaso'] - $val['egreso_operacion'] - $val['egresos_contra_rendicion']- $val['egreso_inicial_por_rendir'];
		$retorno['ingreso'] = $val['ingreso_colectas'] + $val['ingreso_traspasos'];
		$retorno['egreso'] = $val['egreso_operacion'] + $val['egresos_contra_rendicion'] - $val['devolucion'] + $val['egreso_traspaso'];
		$retorno['ingreso_inicial'] = $val['ingreso_inicial'] - $val['egreso_inicial_por_rendir'];
		
		
		$this->s1 = $this->s1 + $retorno['ingreso_inicial'];
		$this->s2 = $this->s2 + $retorno['ingreso'];
		$this->s3 = $this->s3 + $retorno['egreso'];
		$this->s4 = $this->s4 + $retorno['saldo_adm'];
		
		
		$this->c1 = $this->c1 + $retorno['ingreso_inicial'];
		$this->c2 = $this->c2 + $retorno['ingreso'];
		$this->c3 = $this->c3 + $retorno['egreso'];
		$this->c4 = $this->c4 + $retorno['saldo_adm'];
		
		
		$this->t1 = $this->t1 + $retorno['ingreso_inicial'];
		$this->t2 = $this->t2 + $retorno['ingreso'];
		$this->t3 = $this->t3 + $retorno['egreso'];
		$this->t4 = $this->t4 + $retorno['saldo_adm'];
		 
		
		
		return $retorno;
		
		
		
	}



  function cerrarCasaOracion(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	    $conf_par_tablewidths=array(10 + 90,25,25,25,25);
            $conf_par_tablealigns=array('R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2);
	   	    $conf_par_tableborders=array('T',LRTB,LRTB,LRTB,LRTB);
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Subtotal Casa Oración: ',
	                    's1' => $this->c1,
	                    's2' => $this->c2,
	                    's3' => $this->c3,
	                    's4' => $this->c4
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }

  function cerrarCuadro(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	    $conf_par_tablewidths=array(10 + 90,25,25,25,25);
            $conf_par_tablealigns=array('R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2);
	   	    $conf_par_tableborders=array('T',LRTB,LRTB,LRTB,LRTB);
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Subtotal Región: ',
	                    's1' => $this->s1,
	                    's2' => $this->s2,
	                    's3' => $this->s3,
	                    's4' => $this->s4
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }
  
  function cerrarCuadroFinal(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	    $conf_par_tablewidths=array(10 + 90,25,25,25,25);
            $conf_par_tablealigns=array('R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2);
	   	    $conf_par_tableborders=array('T',LRTB,LRTB,LRTB,LRTB);
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'TOTAL: ',
	                    't1' => $this->t1,
	                    't2' => $this->t2,
	                    't3' => $this->t3,
	                    't4' => $this->t4
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }
  
   function revisarfinPagina(){
		$dimensions = $this->getPageDimensions();
		$hasBorder = false; //flag for fringe case
		
		$startY = $this->GetY();
		$this->getNumLines($row['cell1data'], 80);
		
		if (($startY + 4 * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
		    
			$this->AddPage();
		    $this->generarCabecera();
		    
		} 
		 
		
	}

}
?>

