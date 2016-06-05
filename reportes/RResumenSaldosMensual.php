<?php

// Extend the TCPDF class to create custom MultiRow
class RResumenSaldosMensual extends  ReportePDF {
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
	var $s5;
	var $s6;
	var $s7;
	var $s8;
	var $s9;
	var $s10;
	var $s11;
	var $s12;
	var $s13;
	
	
	var $t1;
	var $t2;
	var $t3;
	var $t4;
	var $t5;
	var $t6;
	var $t7;
	var $t8;
	var $t9;
	var $t10;
	var $t11;
	var $t12;
	var $t13;
	
	
	var $c1;
	var $c2;
	var $c3;
	var $c4;
	var $c5;
	var $c6;
	var $c7;
	var $c8;
	var $c9;
	var $c10;
	var $c11;
	var $c12;
	var $c13;	
	var $total;
	
	function datosHeader ( $detalle, $totales) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;
		$this->datos_titulo = $totales;
		$this->subtotal = 0;
		$this->SetMargins(10, 33, 5);
		
	}
	
	function Header() {
		
		//formato de fecha
		$newDate = date("d-m-Y", strtotime($this->objParam->getParametro('hasta')));
		
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,40,20);
		$this->ln(5);
		$this->SetFont('','BU',12);		
		$this->Cell(0,5,"RESUMEN DE SALDOS EN ADMINISTACION",0,1,'C');		
		$this->Ln(1);
		$this->Cell(0,5,"Expresado en Bolivianos",0,1,'C');		
		$this->Ln(1);
		$this->Cell(0,5,"Al ".$this->objParam->getParametro('fecha'),0,1,'C');		
		
		$this->Ln(3);
		$this->SetFont('','B',10);
		
		$this->setFontSubsetting(false);
		$this->SetFont('','B',9);
		
		
		
   }
   
   function generarReporte() {
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		 $this->SetFont('','B',7);
		$this->total = count($detalle);
		
		
		$sw = false;
		$concepto = '';
		//$this->generarCabecera();
		$this->Ln(4);
		$this->generarCuerpo($this->datos_detalle);
		$this->cerrarCasaOracion();
		$this->Ln();
		$this->cerrarCuadro();
		$this->Ln(4);
		$this->cerrarCuadroFinal();
		
		
	} 

    function generarCabecera(){
    	
		
		
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(10,43,15,15,15,15,15,15,15,15,15,19,15,19,19);
        $conf_par_tablealigns=array('C','C','C','C','C','C','C','C','C','C','C','C','C','C','C');
        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
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
                        's1' => 'Inicial',    //ingreso_inicial
                        's2' => 'Enero',        //ingreso_colectas
                        's3' => 'Febrero',           //ingreso_traspasos
                        's4' => 'Marzo',
                        's5' => 'Abril',   //egreso_inicial_por_rendir
                        's6' => 'Mayo',     //egreso_operacion
                        's7' => 'Junio',   //egresos_contra_rendicion
                        's8' => 'Julio',       //egresos_rendidos
                        's9' => 'Agosto',      //egreso_traspaso
                        's10' => 'Septiembre',
                        's11' => 'Octubre',
                        's12' => 'Noviembre',
                        's13' => 'Diciembre',
						
						);
                         
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
		$this->s5 = 0;
		$this->s6 = 0;
		$this->s7 = 0;
		$this->s8 = 0;
		$this->s9 = 0;
		$this->s10 = 0;
		$this->s11 = 0;
		$this->s12 = 0;
		$this->s13 = 0;
		
		$this->t1 = 0;
		$this->t2 = 0;
		$this->t3 = 0;
		$this->t4 = 0;
		$this->t5 = 0;
		$this->t6 = 0;
		$this->t7 = 0;
		$this->t8 = 0;
		$this->t9 = 0;
		$this->t10 = 0;
		$this->t11 = 0;
		$this->t12 = 0;
		$this->t13 = 0;
		
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
					$this->c5 = 0;
					$this->c6 = 0;
					$this->c7 = 0;
					$this->c8 = 0;
					$this->c9 = 0;
					$this->c10 = 0;
					$this->c11 = 0;
					$this->c12 = 0;
					$this->c13 = 0;
					$this->revisarfinPagina();
				}
				
				
			
			}
			
			if($sw == 1){
				if($ult_region != $val["nombre_region"]){
					$sw = 0;
					$count = 1;
					$this->Ln();
					$this->cerrarCuadro();
					$this->AddPage();
					//$this->Ln(4);
					$this->s1 = 0;
					$this->s2 = 0;
					$this->s3 = 0;
					$this->s4 = 0;
					$this->s5 = 0;
					$this->s6 = 0;
					$this->s7 = 0;
					$this->s8 = 0;
					$this->s9 = 0;
					$this->s10 = 0;
					$this->s11 = 0;
					$this->s12 = 0;
					$this->s13 = 0;
					$this->revisarfinPagina();
				}
				
				
			
			}
				
			
				
			if($sw == 0){
				$fill = 0;
				
				$this->imprimirTitulo($val["nombre_region"],$fill);
				$this->Ln(1);
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
			$this->total = $this->total -1;
			
			
			
			
			
		}
		
		
		
	}	
	
	function imprimirLinea($val,$count,$fill){	
		$conf_par_tablewidths=array(10,43,15,15,15,15,15,15,15,15,15,19,15,19,19);
        $conf_par_tablealigns=array('C','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R');
        $conf_par_tablenumbers=array(0,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
		$conf_tableborders=array('LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$val2 = $this->caclularMontos($val);
		
		
		$RowArray = array(
            			'nro'  => $count,
                        'casa' => "\t\t\t\t\t\t\t\t\t".$val['nombre_colecta'],
                        's1' => $val['saldo_inicial'],
                        's2' => $val['mes_1'],
                        's3' => $val['mes_2'],
                        's4' => $val['mes_3'],
						's5' => $val['mes_4'],
                        's6' => $val['mes_5'],
                        's7' => $val['mes_6'],
                        's8' => $val['mes_7'] ,
						's9' => $val['mes_8'],
                        's10' => $val['mes_9'],
                        's11' => $val['mes_10'],
                        's12' => $val['mes_11'],
                        's13' => $val['mes_12']
						
						);
						
						
                         
        $this-> MultiRow($RowArray,$fill,1);
			
	}
	
	function imprimirTitulo($titulo,$fill){
		
		$conf_par_tablewidths=array(10,43+15+15+15+15+15+15+15+15+15+19+15+19+19);
        $conf_par_tablealigns=array('C','C');
        $conf_par_tablenumbers=array(0,0);
		$conf_tableborders=array('LRTB','LRTB');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$val2 = $this->caclularMontos($val);
		
		
		$RowArray = array(
            			'nro'  => $count,
                        'casa' => strtoupper($titulo));
         $this->SetFont('','B',12);                 
         $this-> MultiRow($RowArray,$fill,1);
		 $this->SetFont('','',8);
		 
		 $this->generarCabecera();
		
	}
	
	function imprimirCasaOracion($titulo,$fill){
		$conf_par_tablewidths=array(10,43+15+15+15+15+15+15+15+15+15+19+15+19+19);
        $conf_par_tablealigns=array('C','L');
        $conf_par_tablenumbers=array(0,0);
		$conf_tableborders=array('LRTB','LRTB');
		
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
		
		
		
		
		$this->s1 = $this->s1 + $val['saldo_inicial'];
		$this->s2 = $this->s2 + $val['mes_1'];
		$this->s3 = $this->s3 + $val['mes_2'];
		$this->s4 = $this->s4 + $val['mes_3'];
		$this->s5 = $this->s5 + $val['mes_4'];
		$this->s6 = $this->s6 + $val['mes_5'] ;
		$this->s7 = $this->s7 + $val['mes_6'];
		$this->s8 = $this->s8 + $val['mes_7'];
		$this->s9 = $this->s9 + $val['mes_8'];
		$this->s10 = $this->s10 + $val['mes_9'];
		$this->s11 = $this->s11 + $val['mes_10'];
		$this->s12 = $this->s12 + $val['mes_11'];
		$this->s13 = $this->s13 + $val['mes_12'];
		
		
		$this->c1 = $this->c1 + $val['saldo_inicial'];
		$this->c2 = $this->c2 + $val['mes_1'];
		$this->c3 = $this->c3 + $val['mes_2'];
		$this->c4 = $this->c4 + $val['mes_3'];
		$this->c5 = $this->c5 + $val['mes_4'];
		$this->c6 = $this->c6 + $val['mes_5'] ;
		$this->c7 = $this->c7 + $val['mes_6'];
		$this->c8 = $this->c8 + $val['mes_7'];
		$this->c9 = $this->c9 + $val['mes_8'];
		$this->c10 = $this->c10 + $val['mes_9'];
		$this->c11 = $this->c11 + $val['mes_10'];
		$this->c12 = $this->c12 + $val['mes_11'];
		$this->c13 = $this->c13 + $val['mes_12'];
		
		
		$this->t1 = $this->t1 + $val['saldo_inicial'];
		$this->t2 = $this->t2 + $val['mes_1'];
		$this->t3 = $this->t3 + $val['mes_2'];
		$this->t4 = $this->t4 + $val['mes_3'];
		$this->t5 = $this->t5 + $val['mes_4'];
		$this->t6 = $this->t6 + $val['mes_5'];
		$this->t7 = $this->t7 + $val['mes_6'];
		$this->t8 = $this->t8 + $val['mes_7'];
		$this->t9 = $this->t9 + $val['mes_8'];
		$this->t10 = $this->t10 + $val['mes_9'];
		$this->t11 = $this->t10 + $val['mes_10'];
		$this->t12 = $this->t10 + $val['mes_11'];
		$this->t13 = $this->t10 + $val['mes_12'];
		 
		
		
		return $retorno;
		
		
		
	}

   function  cerrarCasaOracion(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	  
			
			$conf_par_tablewidths=array(10 + 43,15,15,15,15,15,15,15,15,15,19,15,19,19);
            $conf_par_tablealigns=array('R','R','R','R','R','R','R','R','R','R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2,2,2,2,2,2,2,2,2,2);	
	   	    $conf_par_tableborders=array('T','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB');
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
	                    's4' => $this->c4,
	                    's5' => $this->c5,
	                    's6' => $this->c6,
	                    's7' => $this->c7,
	                    's8' => $this->c8,
	                    's9' => $this->c9,
	                    's10' => $this->c10,
	                    's11' => $this->c11,
	                    's12' => $this->c12,
	                    's13' => $this->c13
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }


  function cerrarCuadro(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	  
			
			$conf_par_tablewidths=array(10 + 43,15,15,15,15,15,15,15,15,15,19,15,19,19);
            $conf_par_tablealigns=array('R','R','R','R','R','R','R','R','R','R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2,2,2,2,2,2,2,2,2,2);	
	   	    $conf_par_tableborders=array('T','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB');
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
	                    's4' => $this->s4,
	                    's5' => $this->s5,
	                    's6' => $this->s6,
	                    's7' => $this->s7,
	                    's8' => $this->s8,
	                    's9' => $this->s9,
	                    's10' => $this->s10,
	                    's11' => $this->s11,
	                    's12' => $this->s12,
	                    's13' => $this->s13
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
			
	
  }

  
   function cerrarCuadroFinal(){
  	
			$conf_par_tablewidths=array(10 + 43,15,15,15,15,15,15,15,15,15,19,15,19,19);
            $conf_par_tablealigns=array('R','R','R','R','R','R','R','R','R','R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2,2,2,2,2,2,2,2,2,2);
		
		
	   	     $conf_par_tableborders=array('T','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB');
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Total: ',
	                    't1' => $this->t1,
	                    't2' => $this->t2,
	                    't3' => $this->t3,
	                    't4' => $this->t4,
	                    't5' => $this->t5,
	                    't6' => $this->t6,
	                    't7' => $this->t7,
	                    't8' => $this->t8,
	                    't9' => $this->t9,
	                    't10' => $this->t10,
	                    't11' => $this->t11,
	                    't12' => $this->t12,
	                    't13' => $this->t13
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
			
	
  }

  function revisarfinPagina(){
		$dimensions = $this->getPageDimensions();
		$hasBorder = false; //flag for fringe case
		
		$startY = $this->GetY();
		$this->getNumLines($row['cell1data'], 80);
		
		if (($startY + 4 * 5) + $dimensions['bm'] > ($dimensions['hk'])) {
		    
			$this->AddPage();
		    $this->generarCabecera();
		    
		} 
		 
		
	}

}
?>

