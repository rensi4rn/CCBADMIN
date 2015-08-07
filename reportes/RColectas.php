<?php
// Extend the TCPDF class to create custom MultiRow
class RColectas extends  ReportePDF {
	var $datos_titulo;
	var $datos_detalle;
	var $ancho_hoja;
	var $gerencia;
	var $numeracion;
	var $ancho_sin_totales;
	var $cantidad_columnas_estaticas;
	
	function datosHeader ( $detalle, $totales) {
		$this->ancho_hoja = $this->getPageWidth()-PDF_MARGIN_LEFT-PDF_MARGIN_RIGHT-10;
		$this->datos_detalle = $detalle;
		$this->datos_titulo = $totales;
		$this->subtotal = 0;
		
		$this->subCon = 0;
		$this->subPie = 0;
		$this->subVia = 0;
		$this->subEsp = 0;
		$this->subMan = 0;
		$this->subTot = 0;
		
		$this->totCon = 0;
		$this->totPie = 0;
		$this->totVia = 0;
		$this->totEsp = 0;
		$this->totMan = 0;
		$this->totTot = 0;
		
		
		
		//$this->SetMargins(10, 22.5, 5);
		$this->SetMargins(10, 28, 5);
	}
	
	function Header() {
		//cabecera del reporte
		
		//$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.png', 10, 5, 30, 10);
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.jpg', 10,5,45,20);
		
		$this->ln(5);
		$this->SetFont('','BU',12);
		
		$this->Cell(0,5,"Colectas del Mes de ".$this->datos_titulo['mes']." de ".$this->datos_titulo['gestion'],0,1,'C');
		$this->Ln(1);
		$this->Cell(0,5,"Casa de Oración: ".$this->datos_detalle[0]['desc_casa_oracion'],0,1,'C');
		
		
		$this->Ln(10);
		$this->SetFont('','B',10);
		
	 }
   
   function generarReporte() {
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		
		$sw = false;
		$concepto = '';
		foreach ($this->datos_detalle as $val) {
			
			
			if ($concepto != $val['concepto']){
				
				if($sw){
				    $this->cerrarCuadro();
					$this->Ln(2);
				}
			   
			    $sw = true;	
			    
			    $this->sumarTotales();
			   
			   
			    $this->subCon = 0;
				$this->subPie = 0;
				$this->subVia = 0;
				$this->subEsp = 0;
				$this->subMan = 0;
				$this->subTot = 0;
				
			   $concepto = $val['concepto'];
			   $this->generarCabecera($val['desc_concepto'],  $val['desc_obrero']);
			}
			
			$this->generarCuerpo($val);
			
			$this->subCon = $this->subCon + $val['monto_construccion'];
			$this->subPie = $this->subPie + $val['monto_piedad'];
			$this->subVia = $this->subVia + $val['monto_viaje'];
			$this->subEsp = $this->subEsp + $val['monto_especial'];
			$this->subMan = $this->subMan + $val['monto_mantenimiento'];
			$this->subTot = $this->subTot + $val['monto_dia'];
			
		}
		
		$this->cerrarCuadro();
		$this->Ln(4);
		$this->Ln(4);
		
		$this->sumarTotales();
		//generar resumen del mes
		$this->generarCabecera('Total Colectas del Mes',  $val['desc_obrero']);
		$this->cerrarTotales();
		
		
	} 
    
    function sumarTotales(){
    	
		$this->totCon = $this->totCon + $this->subCon;
		$this->totPie = $this->totPie + $this->subPie;
		$this->totVia = $this->totVia + $this->subVia;
		$this->totEsp = $this->totEsp + $this->subEsp;
		$this->totMan = $this->totMan + $this->subMan;
		$this->totTot = $this->totTot + $this->subTot;
		
    } 

    function generarCabecera($titulo, $obrero){
    	
		
		//definir subtitulo
		$this->SetFont('','B',10);
		$this->tablewidths=array(200);
        $this->tablealigns=array('L');
        $this->tablenumbers=array(0);
        $this->tableborders=array();
        $this->tabletextcolor=array();
		$RowArray = array('tipo_concepto'=> $titulo);
		$this-> MultiRow($RowArray,false,1);
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(20,30,30,30,30,30,30);
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
                        'contruccion'  => 'Construccion',
                        'piedad'  => 'Piedad',
                        'Viaje'  => 'Viaje' , 
                        'Especial'  => 'Especial',
                        'Mantenimineto'  => 'Mantenimineto' ,                                 
                        'Total'    => 'Total');
                         
        $this-> MultiRow($RowArray,false,1);
    }
	
	function generarCuerpo($val){
		
		
		
		$conf_par_tablewidths=array(20,30,30,30,30,30,30);
		$conf_par_tablealigns=array('L','R','R','R','R','R','R');
		$conf_par_tablenumbers=array(0,2,2,2,2,2,2);
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
		$newDate = date("d-m-Y", strtotime($val['fecha']));
		
		$RowArray = array(
            			'fecha'  => $newDate,
                        'contruccion'  => $val['monto_construccion'],
                        'piedad'  => $val['monto_piedad'],
                        'Viaje'  => $val['monto_viaje'] , 
                        'Especial'  => $val['monto_especial'],
                        'Mantenimineto'  => $val['monto_mantenimiento'] ,                                 
                        'Total'    => $val['monto_dia']);
                         
        $this-> MultiRow($RowArray,false,1);
			
	}


  function cerrarCuadro(){
  	
	   if($inicio != 'si'){
	   	    //si noes inicio termina el cuardro anterior
	   	   $this->SetFont('','B',10);
	   	    $conf_tp_tablewidths=array(20,30,30,30,30,30,30);
		    $conf_tp_tablealigns=array('R','R','R','R','R','R','R');
		    $conf_tp_tablenumbers=array(0,2,2,2,2,2,2);
	   	    $conf_tp_tableborders=array(0,1,1,1,1,1,1);
			
			
			$this->tablewidths=$conf_tp_tablewidths;
	        $this->tablealigns=$conf_tp_tablealigns;
	        $this->tablenumbers=$conf_tp_tablenumbers;
	        $this->tableborders=$conf_tp_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Totales: ',
	                    'contruccion'  => $this->subCon,
                        'piedad'  => $this->subPie,
                        'viaje'  => $this->subVia , 
                        'especial'  => $this->subEsp,
                        'mantenimineto'  => $this->subMan,                                 
                        'total'    => $this->subTot);
	                
   
	                     
	        $this-> MultiRow($RowArray,false,1);
	   }
	   
	   
	
  }

   function cerrarTotales(){
  	
	   if($inicio != 'si'){
	   	    //si noes inicio termina el cuardro anterior
	   	   $this->SetFont('','B',10);
	   	    $conf_tp_tablewidths=array(20,30,30,30,30,30,30);
		    $conf_tp_tablealigns=array('R','R','R','R','R','R','R');
		    $conf_tp_tablenumbers=array(0,2,2,2,2,2,2);
	   	    $conf_tp_tableborders=array(0,1,1,1,1,1,1);
			
			
			$this->tablewidths=$conf_tp_tablewidths;
	        $this->tablealigns=$conf_tp_tablealigns;
	        $this->tablenumbers=$conf_tp_tablenumbers;
	        $this->tableborders=$conf_tp_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => '',
	                    'contruccion'  => $this->totCon,
                        'piedad'  => $this->totPie,
                        'viaje'  => $this->totVia , 
                        'especial'  => $this->totEsp,
                        'mantenimineto'  => $this->totMan,                                 
                        'total'    => $this->totTot);
	                
   
	                     
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
				   $tipo = $val['tipo_documento'];	
				}
		     }	
		} 
		
		return $tipo;
  }
}
?>