<?php

// Extend the TCPDF class to create custom MultiRow
class RIngresos extends  ReportePDF {
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
		$this->SetMargins(10, 28, 5);
	}
	
	function Header() {
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib/imagenes/logos/logo.png', 10,5,40,20);
		$this->ln(5);
		$this->SetFont('','BU',12);
		
		$this->Cell(0,5,"Traspasos y Devoluciones del Mes de ".$this->datos_titulo['mes']." de ".$this->datos_titulo['gestion'],0,1,'C');
		$this->Ln(1);
		$this->Cell(0,5,"Casa de Oración: ".$this->datos_detalle[0]['desc_casa_oracion'],0,1,'C');
		
		
		$this->Ln(2);
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
					$this->Ln(1);
				}
			   $sw = true;	
			   $this->subtotal = 0;
			   $concepto = $val['concepto'];
			   $this->generarCabecera($val['desc_concepto'],  $val['desc_obrero']);
			}
			
			$this->generarCuerpo($val);
			$this->subtotal = $this->subtotal + $val['monto'];
			
		}
		
		$this->cerrarCuadro();
		
		
	} 

    function generarCabecera($titulo, $obrero){
    	
		
		//definir subtitulo
		$this->SetFont('','B',10);
		$this->tablewidths=array(20+ 25 + 90 +25 +15 +15 +10);
        $this->tablealigns=array('L');
        $this->tablenumbers=array(0);
        $this->tableborders=array();
        $this->tabletextcolor=array();
		$RowArray = array('tipo_concepto'=> $titulo);
		$this-> MultiRow($RowArray,false,1);
		
		//armca caecera de la tabla
		$conf_par_tablewidths=array(20,25,90,25,15,15,10);
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
                        'num_doc' => 'Núm Doc',
						'rev'=>'Rev');
                         
        $this-> MultiRow($RowArray,false,1);
    }
	
	function generarCuerpo($val){
		
		
		
		$conf_par_tablewidths=array(20,25,90,25,15,15,10);
		$conf_par_tablealigns=array('L','L','L','R','L','R','R');
		$conf_par_tablenumbers=array(0,0,0,2,0,0,0);
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
		
		if( isset($val['desc_obrero']) && $val['desc_obrero'] != ''){
			$obs = trim($val['obs']).'
		       (Firmado por: '.trim($val['desc_obrero']).')';
		}
		else{
			$obs = trim($val['obs']);
		}
		
		
		$RowArray = array(
            			'fecha'  => $newDate,
                        'conlecta'  => $val['desc_tipo_movimiento'] ,                        
                        'obs'    => $obs,
                        'monto' => $val['monto'],
                        'doc' => $tipo,
                        'num_doc' => $val['num_documento'],
						'rec' => '');
                         
        $this-> MultiRow($RowArray,false,1);
			
	}


  function cerrarCuadro(){
  	
	   if($inicio != 'si'){
	   	    //si noes inicio termina el cuardro anterior
	   	    $conf_tp_tablewidths=array(20 +25 + 90,25);
	        $conf_tp_tablealigns=array('R','R');
	        $conf_tp_tablenumbers=array(0,2);
	        $conf_tp_tableborders=array(0,1);
			//coloca el total de egresos
			//coloca el total de la partida 
	        $this->tablewidths=$conf_tp_tablewidths;
	        $this->tablealigns=$conf_tp_tablealigns;
	        $this->tablenumbers=$conf_tp_tablenumbers;
	        $this->tableborders=$conf_tp_tableborders;
	        
	        $RowArray = array( 
	                    'espacio' => 'Total: ',
	                    'precio_total' => $this->subtotal
	                  );     
	                     
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
				   $tipo = $tipo_documento;	
				}
		     }	
		} 
		
		return $tipo;
  }
}
?>

