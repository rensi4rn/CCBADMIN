<?php
/**
*@package pXP
*@file gen-ACTEvento.php
*@author  (admin)
*@date 05-01-2013 08:03:46
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTEvento extends ACTbase{    
			
	function listarEvento(){
		$this->objParam->defecto('ordenacion','id_evento');
        $this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('filtro_evento')=='bsc'){
			   $this->objParam->addFiltro("even.codigo in  (''bautizo'',''santacena'')");	
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODEvento','listarEvento');
		} else{
		//	$this->objFunc=new FuncionesAdmin();
			$this->objFunc=$this->create('MODEvento');
			
			$this->res=$this->objFunc->listarEvento($this->objParam);
		}
		
		if($this->objParam->getParametro('_adicionar')!=''){
		    
			$respuesta = $this->res->getDatos();
			
										
		    array_unshift ( $respuesta, array(  'id_evento'=>'0',
		                                'estado_reg'=>'Todos',
									    'nombre'=>'Todos',
										'id_usuario_reg'=>'Todos',
										'gestion'=>'Todos',
										'codigo'=>'Todos') );
		    //var_dump($respuesta);
			$this->res->setDatos($respuesta);
		}


		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarEvento(){
		$this->objFunc=$this->create('MODEvento');	
		if($this->objParam->insertar('id_evento')){
			$this->res=$this->objFunc->insertarEvento($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarEvento($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarEvento(){
		$this->objFunc=$this->create('MODEvento');	
		$this->res=$this->objFunc->eliminarEvento($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>