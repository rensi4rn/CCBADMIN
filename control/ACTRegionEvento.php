<?php
/**
*@package pXP
*@file gen-ACTRegionEvento.php
*@author  (admin)
*@date 13-01-2013 14:31:26
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/
require_once(dirname(__FILE__).'/../../pxp/pxpReport/DataSource.php');
require_once(dirname(__FILE__).'/../../lib/lib_reporte/PlantillasHTML.php');
require_once(dirname(__FILE__).'/../../lib/lib_reporte/smarty/ksmarty.php');
require_once dirname(__FILE__).'/../../pxp/lib/lib_reporte/ReportePDFFormulario.php';
require_once(dirname(__FILE__).'/../reportes/RAgenda.php');
require_once(dirname(__FILE__).'/../reportes/RAgendaAnual.php');
require_once(dirname(__FILE__).'/../reportes/RResumenEve.php');
require_once(dirname(__FILE__).'/../reportes/RResumenEveCon.php');


class ACTRegionEvento extends ACTbase{    
			
	function listarRegionEvento(){
		$this->objParam->defecto('ordenacion','id_region_evento');
		

		if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("rege.id_region = ".$this->objParam->getParametro('id_region'));	
		}

        if($this->objParam->getParametro('id_gestion')!=''){
			    	$this->objParam->addFiltro("rege.id_gestion = ".$this->objParam->getParametro('id_gestion'));	
		}
		
		if($this->objParam->getParametro('id_obrero')!=''){
			    	$this->objParam->addFiltro("rege.id_obrero = ".$this->objParam->getParametro('id_obrero'));	
		}
		
		if($this->objParam->getParametro('id_evento')!=''){
			    	$this->objParam->addFiltro("rege.id_evento = ".$this->objParam->getParametro('id_evento'));	
		}
		
		if($this->objParam->getParametro('tipo_registro')!=''){
			    	$this->objParam->addFiltro("rege.tipo_registro =''".$this->objParam->getParametro('tipo_registro')."''");	
		}

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRegionEvento','listarRegionEvento');
		} else{
			$this->objFunc=$this->create('MODRegionEvento');
			
			$this->res=$this->objFunc->listarRegionEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

   function listarBautizoSantaCena(){
		$this->objParam->defecto('ordenacion','fecha_programada');
		$this->objParam->defecto('dir_ordenacion','DESC');

		if($this->objParam->getParametro('id_region')!=''){
			    	$this->objParam->addFiltro("eveid_region = ".$this->objParam->getParametro('id_region'));	
		}

        if($this->objParam->getParametro('id_gestion')!=''){
			    	$this->objParam->addFiltro("eve.id_gestion = ".$this->objParam->getParametro('id_gestion'));	
		}
		
		if($this->objParam->getParametro('codigo')!=''){
			    	$this->objParam->addFiltro("eve.codigo = ''".$this->objParam->getParametro('codigo'))."''";	
		}
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRegionEvento','listarBautizoSantaCena');
		} else{
			$this->objFunc=$this->create('MODRegionEvento');
			
			$this->res=$this->objFunc->listarBautizoSantaCena($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRegionEvento(){
		$this->objFunc=$this->create('MODRegionEvento');	
		if($this->objParam->insertar('id_region_evento')){
			$this->res=$this->objFunc->insertarRegionEvento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRegionEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function insertarBautizoSantaCena(){
		$this->objFunc=$this->create('MODRegionEvento');	
		if($this->objParam->insertar('id_region_evento')){
			$this->res=$this->objFunc->insertarBautizoSantaCena($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarBautizoSantaCena($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRegionEvento(){
			$this->objFunc=$this->create('MODRegionEvento');	
		$this->res=$this->objFunc->eliminarRegionEvento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function eliminarBautizoSantaCena(){
			$this->objFunc=$this->create('MODRegionEvento');	
		$this->res=$this->objFunc->eliminarBautizoSantaCena($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function generarResumen(){
		$this->objFunc=$this->create('MODRegionEvento');	
		$this->res=$this->objFunc->generarResumen($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarCalendario(){
		$this->objParam->defecto('ordenacion','id_region_evento');
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRegionEvento','listarCalendario');
		} else{
			$this->objFunc=$this->create('MODRegionEvento');
			
			$this->res=$this->objFunc->listarCalendario($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	
	function recuperarDatosReporteAgenda(){
    	
		$this->objFunc = $this->create('MODRegionEvento');
		$cbteHeader = $this->objFunc->listarReporteAgenda($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
   
   function reporteAgenda(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Agenda') . '.pdf'; 
		$dataSource = $this->recuperarDatosReporteAgenda();	
		
		//parametros basicos
		if($this->objParam->getParametro('tipo_imp') == 'unica'){
			$tamano = array(108,279);//LETTER
		}
		else{
			$tamano = 'LETTER';//LETTER
		}
		
		$orientacion = 'P';
		$titulo = 'Agenda';
		
		//$this->objParam->addParametro('tipo_imp','unica');  //unica, doble
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		
		
		
		//Instancia la clase de pdf
		
		$reporte = new RAgenda($this->objParam);
		$reporte->datosHeader($dataSource, $this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'), $this->objParam->getParametro('comunicado'));
			
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

    function recuperarDatosCasaOracion(){
    	
		$this->objFunc = $this->create('MODCasaOracion');
		$cbteHeader = $this->objFunc->listarCasaOracionAgenda($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }

   function recuperarDatosAgendaAnual(){
    	
		$this->objFunc = $this->create('MODRegionEvento');
		$cbteHeader = $this->objFunc->listarReporteAgendaAnual($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
   
    function recuperarDatosAgendaTelefonica(){
    	
		$this->objFunc = $this->create('MODObrero');
		$cbteHeader = $this->objFunc->listarObreroAgenda($this->objParam);
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader->getDatos();
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }



   function reporteAgendaAnual(){
			
			$nombreArchivo = uniqid(md5(session_id()).'AgendaAnual') . '.pdf'; 
			$dataSource = $this->recuperarDatosCasaOracion();	
			
			//parametros basicos
			$tamano = 'A4';
			$orientacion = 'P';
			$titulo = 'Agenda';
			
			$this->objParam->addParametro('orientacion',$orientacion);
			$this->objParam->addParametro('tamano',$tamano);		
			$this->objParam->addParametro('titulo_archivo',$titulo);        
			$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
			//Instancia la clase de pdf
			
			$reporte = new RAgendaAnual($this->objParam);
			$reporte->datosHeader($dataSource, $this->objParam->getParametro('desde'),$this->objParam->getParametro('hasta'));
		
			$reporte->generarCasasOracion();
			
			$dataSource = $this->recuperarDatosAgendaAnual();
			$reporte->setDatosAgenda($dataSource);
			$reporte->generarAgendaAnual();
			
			$dataSource = $this->recuperarDatosAgendaTelefonica();
			$reporte->setDatosAgendaTelefonica($dataSource);
			$reporte->generarAgendaTelefonica();
			
			
			$reporte->AddPage();
			$reporte->generarCuadroManual('BAUTIZOS',35);
			$reporte->AddPage();
			$reporte->generarCuadroManual('SANTAS CENAS',35);
			$reporte->AddPage();
			$reporte->generarCuadroManualVacio('NOTAS',35);
				
			
			
			$reporte->output($reporte->url_archivo,'F');
			
			$this->mensajeExito=new Mensaje();
			$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
			$this->mensajeExito->setArchivoGenerado($nombreArchivo);
			$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

    function recuperarDatosResumen($tipo_imp){
    	
		$this->objFunc = $this->create('MODRegionEvento');
		
		if($tipo_imp == 'detallado'){
			$cbteHeader = $this->objFunc->listarResumenBautizoSantaCena($this->objParam);
		}
		else{
			$cbteHeader = $this->objFunc->listarResumenBautizoSantaCenaConsolidado($this->objParam);
		}
		
		if($cbteHeader->getTipo() == 'EXITO'){
				
			return $cbteHeader;
		}
        else{
		    $cbteHeader->imprimirRespuesta($cbteHeader->generarJson());
			exit;
		}              
		
    }
	
	 
	
	
	
	function reporteResumen(){
			
		$nombreArchivo = uniqid(md5(session_id()).'Egresos') . '.pdf'; 
		
		$dataSource = $this->recuperarDatosResumen($this->objParam->getParametro('tipo_imp'));	
		
		
		//parametros basicos
		$tamano = 'LETTER';
		$orientacion = 'P';		
		$titulo = 'Consolidado';
		
		
		$this->objParam->addParametro('orientacion',$orientacion);
		$this->objParam->addParametro('tamano',$tamano);		
		$this->objParam->addParametro('titulo_archivo',$titulo);	
        
		$this->objParam->addParametro('nombre_archivo',$nombreArchivo);
		//Instancia la clase de pdf
		if($this->objParam->getParametro('tipo_imp') == 'detallado'){
			$reporte = new RResumenEve($this->objParam);   
		}
		else{
			$reporte = new RResumenEveCon($this->objParam);   
		}
		
        $reporte->datosHeader($dataSource->getDatos(),  $dataSource->extraData);
		//$this->objReporteFormato->renderDatos($this->res2->datos);
		
		$reporte->generarReporte();
		$reporte->output($reporte->url_archivo,'F');
		
		$this->mensajeExito=new Mensaje();
		$this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado','Se generó con éxito el reporte: '.$nombreArchivo,'control');
		$this->mensajeExito->setArchivoGenerado($nombreArchivo);
		$this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
		
	}

	
	
	
	
		
}
?>