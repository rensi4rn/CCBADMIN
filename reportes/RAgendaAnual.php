<?php
// Extend the TCPDF class to create custom MultiRow
class RAgendaAnual extends  ReportePDF {
	var $datos_titulo;
	var $datos_detalle;
	var $datos_agenda;
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
	
	function setDatosAgenda($detalle) {
		$this->datos_agenda = $detalle;
	}
	
	function setDatosAgendaTelefonica($detalle) {
		$this->datos_agenda_telefonica = $detalle;
	}
	
	function Header() {
		
		$titulo = 'COONGREGACIÓN CRISTIANA EN BOLIVIA';
		$titulo2 = 'Del '.$this->desde.' al '.$this->hasta;	
			
		//cabecera del reporte
		$this->SetFont('','B',10);
		
		
		$this->Cell(0,3 ,$titulo,'',0,'C');
		
		$this->ln();
		$this->Cell(0,3 ,$titulo2,'',0,'C');
		
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
		$ancho = ($ancho) -2;
		
		$this->Ln(2);
		$cur_y = $this->GetY();
		//$this->Cell($ancho, 0, 'Generado por XPHS', 'T', 0, 'L');
		
		//$this->Cell($ancho, 0, 'Usuario: '.$_SESSION['_LOGIN'], '', 0, 'L');
		$fecha_rep = date("d-m-Y H:i:s");
		$this->Cell(($ancho), 0, "Fecha Imp : ".$fecha_rep, '', 0, 'L');
		$pagenumtxt = 'Página'.' '.$this->getAliasNumPage().' de '.$this->getAliasNbPages();
		
		$this->Cell($ancho, 0, $pagenumtxt, '', 0, 'C');
		$this->Cell($ancho, 0, $_SESSION['_REP_NOMBRE_SISTEMA'], '', 0, 'R');
		
		
		
		
		//$this->Ln();
		//$fecha_rep = date("d-m-Y H:i:s");
		//$this->Cell(($ancho*3), 0, "Fecha Imp : ".$fecha_rep, '', 0, 'L');
		
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
	
	
	
	function setCabeceraCasaOracionDet($region){
		       $this->SetFont('','B',14);
			   $this->ln();
		       $this->Cell(200,3.5,$region,'',0,'C');
			   $this->ln();
			   $this->Cell(60,3.5,'Casa Oracion ','LTR',0,'C');
			   $this->Cell(20,3.5,'Dom','LTR',0,'C');
			   $this->Cell(20,3.5,'Lun','LTR',0,'C');
			   $this->Cell(20,3.5,'Mar','LTR',0,'C');
			   $this->Cell(20,3.5,'Mie','LTR',0,'C');
			   $this->Cell(20,3.5,'Jue','LTR',0,'C');
			   $this->Cell(20,3.5,'Vie','LTR',0,'C');
			   $this->Cell(20,3.5,'Sab','LTR',0,'C');
			   $this->ln();
	}
	
	function definirHorario($horario){
		
		 
	}
	
	function setCuerpoCasaOracionDet($val){
		
		        $conf_par_tablewidths=array(60,20,20,20,20,20,20,20);
		        $conf_par_tablealigns=array('L','C','C','C','C','C','C','C');
		        $conf_par_tablenumbers=array(0,0,0,0,0,0,0,0);
		        $conf_tableborders=array('LTR','LTR','LTR','LTR','LTR','LTR','LTR','LTR');
		        $conf_tabletextcolor=array();
				$this->tablewidths=$conf_par_tablewidths;
	            $this->tablealigns=$conf_par_tablealigns;
	            $this->tablenumbers=$conf_par_tablenumbers;
	            $this->tableborders=$conf_tableborders;
	            $this->tabletextcolor=$conf_tabletextcolor;
		       
			   
			     $this->SetFont('','',14);
			     $temphorario = explode(",", $val['horarios']);
				 $dias = array(
					    'Domingo'  => '',
					    'Lunes' => '',
					    'Martes' => '',
					    'Miercoles' => '',
					    'Jueves' => '',
					    'Viernes' => '',
					    'Sabado' => '',
					  );
				 
				 for($i= 0; $i < count($temphorario); $i++){
				 	
					 $aux = explode("-", $temphorario[$i] );
				     if($dias[$aux[0]] == ''){
				     	$dias[$aux[0]] = $aux[1]." ".$aux[2][0]."";
				     }
					 else{
					 	$dias[$aux[0]] = $dias[$aux[0]]."\n".$aux[1]." ".$aux[2][0]."";
					 }
				 }
				 
				 
			   
			    $RowArray = array('casa_oracion'  =>  $val['casa_oracion'],
								   'Domingo'  =>  $dias['Domingo'],
								   'Lunes'  =>  $dias['Lunes'],
								   'Martes'  =>  $dias['Martes'],
								   'Miercoles'  =>  $dias['Miercoles'],
								   'Jueves'  =>  $dias['Jueves'],
								   'Viernes'  =>  $dias['Viernes'],
								   'Sabado'  =>  $dias['Sabado']);
								    
			   	 $this-> MultiRow($RowArray,false,0);
				
			   
	}
	
	function cerrarDet(){
		       $this->SetFont('','',8);
			   $this->Cell(200,3.5,'','T',0,'L');
			   $this->ln();
	}

   function generarCasasOracion() {
		
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
	       		
			
			if ($sw_titulo == 1 || $anterior != $val['region']){
			   	
				if ($sw_titulo != 1){
					//cerramos la anterior linea
					$this->cerrarDet();
				}
			   $this->setCabeceraCasaOracionDet($val['region']);
			}
			
			$this->setCuerpoCasaOracionDet($val);	
			
			$anterior = $val['region'];
			$sw_titulo = 0;
			
		}	
		$this->cerrarDet();		
		$this->ln();
	}


    function setCabeceraAgendaDet($mes){
		       $this->SetFont('','B',17);
			   $this->ln();
		       $this->Cell(200,3.5,$this->traducirMes($mes),'',0,'C');
			    $this->SetFont('','B',14);
			   $this->ln();
			   $this->Cell(20,3.5,'#','LTR',0,'C');
			   $this->Cell(20,3.5,'DIA','LTR',0,'C');
			   $this->Cell(20,3.5,'HORA','LTR',0,'C');
			   $this->Cell(140,3.5,'SERVICIO','LTR',0,'C');
			   
			   $this->ln();
	}
	
	
	
	function setCuerpoAgendaDet($val){
		
		        $conf_par_tablewidths=array(20,20,20,140);
		        $conf_par_tablealigns=array('C','C','C','L');
		        $conf_par_tablenumbers=array(0,0,0,0);
		        $conf_tableborders=array('LTR','LTR','LTR','LTR');
		        $conf_tabletextcolor=array();
				$this->tablewidths=$conf_par_tablewidths;
	            $this->tablealigns=$conf_par_tablealigns;
	            $this->tablenumbers=$conf_par_tablenumbers;
	            $this->tableborders=$conf_tableborders;
	            $this->tabletextcolor=$conf_tabletextcolor;
		        
				$evento = $val['desc_evento'];
			    if ($val['desc_evento'] != ''){
			    	$evento = $val['desc_evento'].' en  '.$val['desc_casa_oracion'].'  ('.$val['desc_region'].')';
			    }
			   
			    $RowArray = array('num_dia'  =>  $val['num_dia'],
								   'dia'  =>   $this->getDia2($val['dia_sem']),
								   'hora'  =>  $val['hora'],
								   'servicio'  =>  $evento);
								    
			   	 $this-> MultiRow($RowArray,false,0);
				
			   
	}
	
	
	
	
	function generarAgendaAnual() {
		
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		//configuracion de la tabla
		$this->SetFont('','',9);
		$sw_titulo = 1;
		$anterior = '';
		
        foreach ($this->datos_agenda as $val) {
	       		
			
			if ($sw_titulo == 1 || $anterior != $val['mes']){
			   	
				if ($sw_titulo != 1){
					//cerramos la anterior linea
					$this->cerrarDet();
					$this->AddPage();
				}
			   $this->setCabeceraAgendaDet(trim($val['mes']));
			}
			
			$this->setCuerpoAgendaDet($val);	
			
			$anterior = $val['mes'];
			$sw_titulo = 0;
			
		}	
		$this->cerrarDet();		
		$this->ln();
	}

  function setCabeceraAgendaTelefonicaDet($cargo){
		       $this->SetFont('','B',17);
			   $this->ln();
		       $this->Cell(200,3.5,$cargo,'',0,'C');
			    $this->SetFont('','B',14);
			   $this->ln();
			   $this->Cell(80,3.5,'NOMBRE','LTR',0,'C');
			   $this->Cell(60,3.5,'COMUN','LTR',0,'C');
			   $this->Cell(60,3.5,'TELEFONOS','LTR',0,'C');
			   $this->ln();
	}
	
	
	
	function setCuerpoAgendaTelefonicaDet($val){
		
		        $conf_par_tablewidths=array(80,60,60);
		        $conf_par_tablealigns=array('L','L','L');
		        $conf_par_tablenumbers=array(0,0,0);
		        $conf_tableborders=array('LTR','LTR','LTR');
		        $conf_tabletextcolor=array();
				$this->tablewidths=$conf_par_tablewidths;
	            $this->tablealigns=$conf_par_tablealigns;
	            $this->tablenumbers=$conf_par_tablenumbers;
	            $this->tableborders=$conf_tableborders;
	            $this->tabletextcolor=$conf_tabletextcolor;
		        
				$evento = $val['desc_evento'];
			    if ($val['casa_oracion'] != ''){
			    	$comun = $val['casa_oracion'].' en  '.$val['region'];
			    }
				
				$tel = '';
				$tel = $val['telefono1'];
			    
			    if($val['celular1'] != ''){
			    	$tel = $tel.' Cel: '.$val['celular1'];
			    }
			   
			    $RowArray = array('nombre'  =>  $val['nombre_completo1'],
								   'comun'  =>   $comun,
								   'telefono'  =>  $tel);
								    
			   	 $this-> MultiRow($RowArray,false,0);
				
			   
	}



    function generarAgendaTelefonica() {
		
		$this->setFontSubsetting(false);
		$this->AddPage();
		
		//configuracion de la tabla
		$this->SetFont('','',9);
		$sw_titulo = 1;
		$anterior = '';
		
        foreach ($this->datos_agenda_telefonica as $val) {
	       		
			
			if ($sw_titulo == 1 || $anterior != $val['ministerio']){
			   	
				if ($sw_titulo != 1){
					//cerramos la anterior linea
					$this->cerrarDet();
					
				}
			   $this->setCabeceraAgendaTelefonicaDet(trim($val['ministerio']));
			}
			
			$this->setCuerpoAgendaTElefonicaDet($val);	
			
			$anterior = $val['ministerio'];
			$sw_titulo = 0;
			
		}	
		$this->cerrarDet();		
		$this->ln();
	}

   function setCabeceraCuadroManual($evento){
		       $this->SetFont('','B',17);
			   $this->ln();
		       $this->Cell(200,3.5,$evento,'',0,'C');
			    $this->SetFont('','B',14);
			   $this->ln();
			   $this->Cell(30,3.5,'FECHA','LTR',0,'C');
			   $this->Cell(25,3.5,'HORA','LTR',0,'C');
			   $this->Cell(70,3.5,'LOCALIDAD','LTR',0,'C');
			   $this->Cell(25,3.5,'HMNOS','LTR',0,'C');
			   $this->Cell(25,3.5,'HMNAS','LTR',0,'C');
			   $this->Cell(25,3.5,'TOTAL','LTR',0,'C');
			   $this->ln();
			   
	}

   function generarCuadroManual($evento,$total){
  	    $this->setFontSubsetting(false);
		
		
		//configuracion de la tabla
		$this->SetFont('','',9);
		$sw_titulo = 1;
		$anterior = '';
		
		
		$this->setCabeceraCuadroManual($evento);
		for ($i = 0; $i< $total; $i ++) {
			  $this->Cell(30,3.5,'','LTR',0,'C');
			   $this->Cell(25,3.5,'','LTR',0,'C');
			   $this->Cell(70,3.5,'','LTR',0,'C');
			   $this->Cell(25,3.5,'','LTR',0,'C');
			   $this->Cell(25,3.5,'','LTR',0,'C');
			   $this->Cell(25,3.5,'','LTR',0,'C');
			   $this->ln();	
		}
		$this->cerrarDet();	
		$this->ln();
   }
   
    function generarCuadroManualVacio($evento,$total){
  	    $this->setFontSubsetting(false);
		
		
		//configuracion de la tabla
		$this->SetFont('','',9);
		$sw_titulo = 1;
		$anterior = '';
		
		
	   $this->SetFont('','B',17);
	   $this->ln();
       $this->Cell(200,3.5,$evento,'',0,'C');
	   $this->SetFont('','B',14);
	   $this->ln();
			   
		for ($i = 0; $i< $total; $i ++) {
			  $this->Cell(200,3.5,'','LTR',0,'C');
			  $this->ln();	
		}
		$this->cerrarDet();	
		$this->ln();
   }

	function traducirMes($mes){
		
		if($mes == 'JANUARY'){
			return 'ENERO';
		}
        if($mes == 'FEBRUARY'){
			return 'FEBRERO';
		}
		if($mes == 'MARCH'){
			return 'MARZO';
		}
        if($mes == 'APRIL'){
			return 'ABRIL';
		}
		if($mes == 'MAY'){
			return 'MAYO';
		}
        if($mes == 'JUNE'){
			return 'JUNIO';
		}
		if($mes == 'JULY'){
			return 'JULIO';
		}
        if($mes == 'AUGUST'){
			return 'AGOSTO';
		}
		if($mes == 'SEPTEMBER'){
			return 'SEPTIEMBRE';
		}
        if($mes == 'OCTOBER'){
			return 'OCTUBRE';
		}
		if($mes == 'NOVEMBER'){
			return 'NOVIEMBRE';
		}
        if($mes == 'DECEMBER'){
			return 'DICIEMBRE';
		}
		
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
	function getDia2($num){
		switch ($num) {
		    case 2:
		        return "Lu";
		        break;
		    case 3:
		          return "Ma";
		        break;
		    case 4:
		          return "Mi";
		        break;
			case 5:
		          return "Ju";
		        break;
			case 6:
		          return "Vi";
		        break;
			case 7:
		          return "Sa";
		        break;
			case 1:
		          return "Do";
		        break;
		}
	}
	
	
}
?>