<?php

// Extend the TCPDF class to create custom MultiRow
class RResumenDet extends  ReportePDF {
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
		$this->Cell(0,5,"ESTADO DETALLADO DE MOVIMIENTO ECONOMICO",0,1,'C');		
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
		
		  $this->SetFont('','B',9);
		
		
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
		$conf_par_tablewidths=array(10,50,20 + 20 + 20 + 20,  20 + 20 + 20 +20, 20 + 20);
        $conf_par_tablealigns=array('C','C','C','C','C');
        $conf_par_tablenumbers=array(0,0,0,0,0);
        $conf_tableborders=array(0,0,1,1,1);
        $conf_tabletextcolor=array();
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$RowArray = array(
            			'nro'  => '',
                        'casa' => '',
                        'inicial' => 'INGRESOS',    //ingreso_inicial
                        'colectas' => 'EGRESOS',        //ingreso_colectas
                        'intras' => 'SALDOS');
                         
        $this-> MultiRow($RowArray,false,1);
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(10,50,20,20,20,20,20,20,20,20,20,20);
        $conf_par_tablealigns=array('C','C','C','C','C','C','C','C','C','C','C','C');
        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0,0,0,0,0);
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
                        's2' => 'Colectas',        //ingreso_colectas
                        's3' => 'Traspaso',           //ingreso_traspasos
                        's4' => 'Devol.',
                        's5' => 'Opera.',   //egreso_inicial_por_rendir
                        's6' => 'Por Rendir',     //egreso_operacion
                        's7' => 'Rendido',   //egresos_contra_rendicion
                        's8' => 'Traspaso',       //egresos_rendidos
                        's9' => 'Admin',      //egreso_traspaso
                        's10' => 'Total');
                         
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
		$this->s4 = 0;
		$this->s5 = 0;
		$this->s6 = 0;
		$this->s7 = 0;
		$this->s8 = 0;
		$this->s9 = 0;
		$this->s10 = 0;
		
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
					$this->s4 = 0;
					$this->s5 = 0;
					$this->s6 = 0;
					$this->s7 = 0;
					$this->s8 = 0;
					$this->s9 = 0;
					$this->s10 = 0;
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
		$conf_par_tablewidths=array(10,50,20,20,20,20,20,20,20,20,20,20);
        $conf_par_tablealigns=array('C','L','R','R','R','R','R','R','R','R','R','R');
        $conf_par_tablenumbers=array(0,0,2,2,2,2,2,2,2,2,2,2);
		$conf_tableborders=array('LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR','LR');
		
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		
		$val2 = $this->caclularMontos($val);
		
		
		$RowArray = array(
            			'nro'  => $count,
                        'casa' => "\t\t\t\t\t\t".$val['nombre_casa_oracion'],
                        's1' => $val['ingreso_inicial'],
                        's2' => $val2['ingreso_colectas'],
                        's3' => $val2['ingreso_traspasos'],
                        's4' => $val2['devolucion'],
						's5' => $val['egreso_operacion'],
                        's6' => $val2['egresos_contra_rendicion'],
                        's7' => $val2['egresos_rendidos'],
                        's8' => $val2['egreso_traspaso'] ,
						's9' => $val2['saldo_adm'],
                        's10' => $val2['saldo_total']);
						
						
                         
        $this-> MultiRow($RowArray,$fill,1);
			
	}
	
	function imprimirTitulo($titulo,$fill){
		$conf_par_tablewidths=array(10,50 +20 + 20 + 20 + 20 +  20 + 20 + 20 +20 + 20 + 20);
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
		
		 
		$retorno['ingreso_total'] = $val['ingreso_traspasos'] + $val['ingreso_colectas'] + $val['ingreso_inicial'];
		$retorno['saldo_adm'] =  $retorno['ingreso_total'] + $val['devolucion'] - $val['egreso_traspaso'] - $val['egreso_operacion'] - $val['egresos_contra_rendicion']- $val['egreso_inicial_por_rendir'];
		$retorno['saldo_total'] = $retorno['ingreso_total'] - $val['egreso_operacion'] - $val['egresos_rendidos'] - $val['egreso_traspaso']; 
		
		
		$retorno['ingreso_total'] = $val['ingreso_inicial'];
		$retorno['ingreso_colectas'] = $val['ingreso_colectas'];
		$retorno['ingreso_traspasos'] = $val['ingreso_traspasos'];
		$retorno['devolucion'] = $val['devolucion'];
		$retorno['egreso_operacion'] = $val['egreso_operacion'];
		$retorno['egresos_contra_rendicion'] = $val['egresos_contra_rendicion'] + $val['egreso_inicial_por_rendir'];
		$retorno['egresos_rendidos'] = $val['egresos_rendidos'];
		$retorno['egreso_traspaso'] = $val['egreso_traspaso'];
		
		
		$this->s1 = $this->s1 + $val['ingreso_inicial'];
		$this->s2 = $this->s2 + $val['ingreso_colectas'];
		$this->s3 = $this->s3 + $val['ingreso_traspasos'];
		$this->s4 = $this->s4 + $val['devolucion'];
		$this->s5 = $this->s5 + $val['egreso_operacion'];
		$this->s6 = $this->s6 + $val['egresos_contra_rendicion'] + $val['egreso_inicial_por_rendir'];
		$this->s7 = $this->s7 + $val['egresos_rendidos'];
		$this->s8 = $this->s8 + $val['egreso_traspaso'];
		$this->s9 = $this->s9 + $retorno['saldo_adm'];
		$this->s10 = $this->s10 + $retorno['saldo_total'];
		
		
		$this->t1 = $this->t1 + $val['ingreso_inicial'];
		$this->t2 = $this->t2 + $val['ingreso_colectas'];
		$this->t3 = $this->t3 + $val['ingreso_traspasos'];
		$this->t4 = $this->t4 + $val['devolucion'];
		$this->t5 = $this->t5 + $val['egreso_operacion'];
		$this->t6 = $this->t6 + $val['egresos_contra_rendicion'] + $val['egreso_inicial_por_rendir'];
		$this->t7 = $this->t7 + $val['egresos_rendidos'];
		$this->t8 = $this->t8 + $val['egreso_traspaso'];
		$this->t9 = $this->t9 + $retorno['saldo_adm'];
		$this->t10 = $this->t10 + $retorno['saldo_total'];
		 
		
		
		return $retorno;
		
		
		
	}


  function cerrarCuadro(){
  	
	   
	   	    //si noes inicio termina el cuardro anterior
	   	  
			
			$conf_par_tablewidths=array(10 + 50,20,20,20,20,20,20,20,20,20,20);
            $conf_par_tablealigns=array('R','R','R','R','R','R','R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2,2,2,2,2,2,2);	
	   	    $conf_par_tableborders=array('T','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB','LRTB');
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_par_tablewidths;
	        $this->tablealigns=$conf_par_tablealigns;
	        $this->tablenumbers=$conf_par_tablenumbers;
	        $this->tableborders=$conf_par_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Subtotal: ',
	                    's1' => $this->s1,
	                    's2' => $this->s2,
	                    's3' => $this->s3,
	                    's4' => $this->s4,
	                    's5' => $this->s5,
	                    's6' => $this->s6,
	                    's7' => $this->s7,
	                    's8' => $this->s8,
	                    's9' => $this->s9,
	                    's10' => $this->s10
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }
  
   function cerrarCuadroFinal(){
  	
	   
	   	    $conf_par_tablewidths=array(10 + 50,20,20,20,20,20,20,20,20,20,20);
            $conf_par_tablealigns=array('R','R','R','R','R','R','R','R','R','R','R');
            $conf_par_tablenumbers=array(0,2,2,2,2,2,2,2,2,2,2);
		
		
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
	                    't10' => $this->t10
	                  );     
	                     
	        $this-> MultiRow($RowArray,false,1);
	
  }

}
?>

