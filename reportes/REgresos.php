<?php

// Extend the TCPDF class to create custom MultiRow
class REgresos extends  ReportePDF {
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
		$this->SetMargins(5, 22.5, 5);
	}
	
	function Header() {
		//cabecera del reporte
		$this->Image(dirname(__FILE__).'/../../lib'.$_SESSION['_DIR_LOGO'], $this->ancho_hoja, 5, 30, 10);
		$this->ln(5);
		$this->SetFont('','BU',12);
		
		$this->Cell(0,5,"Egresos del Mes de ".$this->datos_titulo['mes']." de ".$this->datos_titulo['gestion'],0,1,'C');
		$this->Ln(1);
		$this->Cell(0,5,"Casa de Oración: ".$this->datos_detalle[0]['desc_casa_oracion'],0,1,'C');
		
		
		$this->Ln(2);
		$this->SetFont('','B',10);
		
		
		
		
   }
	function generarReporte() {
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		
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
		
		
		
		$conf_par_tablealigns=array('L','L','L','R','L','R','R');
		 $conf_par_tablenumbers=array(0,0,0,2,0,0,0);
		$this->tablewidths=$conf_par_tablewidths;
        $this->tablealigns=$conf_par_tablealigns;
        $this->tablenumbers=$conf_par_tablenumbers;
        $this->tableborders=$conf_tableborders;
        $this->tabletextcolor=$conf_tabletextcolor;
		//configuracion de la tabla
		$this->SetFont('','',9);
        
		        
        foreach ($this->datos_detalle as $val) {
        	
			//define formato tipo de recibo
			if($val['tipo_documento'] == 'recibo_sin_retencion'){
				$tipo = 'Recibo s/r';
			}
			else{
				if($val['tipo_documento'] == 'factura'){
				   $tipo = 'Factura';
			    }
				else{
				   if($val['tipo_documento'] == 'recibo_piedad'){
				        $tipo = 'Rec Piedad';
				    }
					else{
					   $tipo = $val['tipo_documento'];	
					}
			     }	
			}  
			//formato de fecha
			$newDate = date("d-m-Y", strtotime($val['fecha']));
			
		    $obs = trim($val['obs']).'
		    ('. $val['desc_ingas'].')';
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
                    'precio_total' => $this->datos_titulo['total_monto']
                  );     
                     
        $this-> MultiRow($RowArray,false,1);	
	} 
}
?>

