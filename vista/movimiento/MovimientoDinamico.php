<?php
/**
*@package pXP
*@file gen-TipoSensor.php
*@author  (mflores)
*@date 15-03-2012 10:27:35
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.MovimientoDinamico=Ext.extend(Phx.gridInterfaz,{
     constructor:function(config){
		this.configMaestro=config;
		this.config=config;
    	//llama al constructor de la clase padre
    	Phx.CP.loadingShow();
	    this.storeAtributos= new Ext.data.JsonStore({
          			url:'../../sis_admin/control/TipoMovimiento/listarTipoMovimiento',
				    id: 'id_tipo_movimiento',
   					root: 'datos',
   				    totalProperty: 'total',
   					fields: [  {name:'id_tipo_movimiento', type: 'numeric'},
								{name:'codigo', type: 'varchar'},
								{name:'nombre', type: 'varchar'}],
						sortInfo:{
							field: 'id_tipo_movimiento',
							direction: 'ASC'
						}});
			//evento de error
			this.storeAtributos.on('loadexception',this.conexionFailure);				
			
			this.storeAtributos.load({params:{
				                              "sort":"id_tipo_movimiento",
				                              "dir":"ASC",
				                               start:0, 
				                               limit:500},callback:this.successConstructor,scope:this})			
	},		
	
	successConstructor:function(rec,con,res){
		console.log('RETORNO',rec)
		
		this.recColumnas = rec;
		this.Atributos=[];
		this.fields=[];
		this.id_store='id_movimieno_din'
		
		this.sortInfo={
			field: 'fecha',
			direction: 'ASC'
		};
		this.fields.push(this.id_store);
		this.fields.push('id_movimiento');
		this.fields.push('desc_casa_oracion');
		this.fields.push('desc_gestion');
		this.fields.push('desc_estado_periodo');
		this.fields.push('concepto');
		this.fields.push('tipo');
		this.fields.push({name:'fecha', type: 'date', dateFormat:'Y-m-d'});
	
		
		if(res)
		{
			this.Atributos[0]={
			//configuracion del componente
								config:{
										labelSeparator:'',
										inputType:'hidden',
										name: this.id_store
								},
								type:'Field',
								form:true 
						};
						
			var recText = this.id_store +'#integer';  
						
			this.Atributos[1]={
            //configuracion del componente
                                config:{
                                        labelSeparator:'',
                                        inputType:'hidden',
                                        name: 'id_movimiento'
                                },
                                type:'Field',
                                form:true 
                        };
                        
              recText = recText+'@id_movimiento#integer'; 
                        
              this.Atributos[2]={
            //configuracion del componente
                                config:{
                                        
                                        name: 'desc_casa_oracion',
                                        inputType:'hidden',
                                        fieldLabel: 'Casa de Oracion',
                                        allowBlank: false,
                                        gwidth: 200,
                                        },
                                type:'TextField',
                                filters:{pfiltro:'desc_casa_oracion',type:'string'},
                                grid:false,
                                form:false 
                        }; 
              
              recText = recText+'@desc_casa_oracion#varchar';         
                        
              this.Atributos[3]={
            //configuracion del componente
                                config:{
                                        
                                        name: 'desc_gestion',
                                        inputType:'hidden',
                                        fieldLabel: 'Gestion',
                                        allowBlank: false,
                                        gwidth: 200,
                                        },
                                type:'TextField',
                                filters:{pfiltro:'desc_gestion',type:'numeric'},
                                grid:false,
                                form:false 
                        };                      
                       
              recText = recText+'@desc_gestion#integer';      
                        
             this.Atributos[4]={
            //configuracion del componente
                                config:{
                                        
                                        name: 'desc_estado_periodo',
                                        inputType:'hidden',
                                        fieldLabel: 'Periodo',
                                        allowBlank: false,
                                        gwidth: 80,
                                        },
                                type:'TextField',
                                filters:{pfiltro:'desc_estado_periodo',type:'string'},
                                grid:true,
                                bottom_filter: true,
                                form:false 
                        };                      
               recText = recText+'@desc_estado_periodo#varchar'; 
              
                               
			this.Atributos[5]={
            //configuracion del componente
                                config:{
                                        
                                        name: 'concepto',
                                        fieldLabel: 'Concepto',
                                        allowBlank: false,
                                        gwidth: 200,
                                        renderer:function (value, p, record){
                                                var dato='';
                                                dato = (dato==''&&value=='colecta_adultos')?'Colecta de Adultos':dato;
                                                dato = (dato==''&&value=='colecta_jovenes')?'Colecta de Jovenes':dato;
                                                dato = (dato==''&&value=='colecta_especial')?'Colecta Especial':dato;
                                                dato = (dato==''&&value=='colecta_especial')?'Colecta Especial':dato;
                                                dato = (dato==''&&value=='saldo_inicial')?'Saldo Inicial':dato;
                                                dato = (dato==''&&value=='ingreso_trapaso')?'Ingreso por Trapaso':dato;
                                                dato = (dato==''&&value=='operacion')?'Operacion':dato;
                                                dato = (dato==''&&value=='rendicion')?'Rendición':dato;
                                                dato = (dato==''&&value=='egreso_traspaso')?'Egreso por Traspaso':dato;
                                                
                                                if(record.data.concepto=='Total'){
                                                     return String.format('<b><font color="green">{0}</font><b>', value);
                                                }
                                                else{
                                                    return String.format('{0}', dato);
                                                }
                                            
                                            }
                                        },
                                type:'TextField',
                                filters:{pfiltro:'concepto',type:'string'},
                                grid:true,
                                bottom_filter: true,
                                form:false 
                        };
                        
                 recText = recText+'@concepto#varchar';  
                        
              this.Atributos[6]={
            //configuracion del componente
                                config:{
                                        
                                        name: 'tipo',
                                        fieldLabel: 'Periodo',
                                        allowBlank: false,
                                        gwidth: 200,
                                        },
                                type:'TextField',
                                filters:{pfiltro:'tipo',type:'string'},
                                grid:false,
                                form:false 
                        };  
                                  
			 recText = recText+'@tipo#varchar';
			   
			this.Atributos[7]={
			//configuracion del componente
								config:{
										
										name: 'fecha',
										fieldLabel: 'Fecha',
										allowBlank: false,
										anchor: '100%',
										format: 'd/m/Y',
										renderer:function (value,p,record){
										    if(record.data.concepto=='Total'){
                                                     return String.format('<b><font color="green">{0}</font></b>', value?value.dateFormat('d/m/Y'):'');
                                                }
                                                else{
                                                    return value?value.dateFormat('d/m/Y'):''
                                                }
										    
										    
										    }
								},
								type:'DateField',
								filters:{pfiltro:'fecha',type:'date'},
								grid:true,
								form:true 
						};
						
			 recText = recText+'@fecha#date';
			
									
				
			for (var i=0;i<rec.length;i++){
			    
			   
				var configDef={};
				
			   var codigo_col = 'col_'+  Ext.util.Format.lowercase(rec[i].data.codigo);
				
				this.fields.push(codigo_col);
				this.fields.push(codigo_col+'_key');
				
			    recText=recText+'@'+codigo_col+'#numeric'+'@'+codigo_col+'_key#integer'
				
				this.Atributos.push({config:{
									 name: codigo_col,
									 fieldLabel: rec[i].data.nombre,
									 allowBlank: true,
									 anchor: '80%',
									 gwidth: 100,
									 maxLength:100,
									 renderer:function (value, p, record){
                                                if(record.data.concepto=='Total'){
                                                     return String.format('<b><font color="green">{0}</font></b>', value);
                                                }
                                                else{
                                                    return String.format('{0}', value);
                                                }
                                            
                                            }
									},
									type:'NumberField',
									filters:{pfiltro:codigo_col,type:'numeric'},
									id_grupo:1,
									egrid:false,
									grid:true,
									form:true
							});
							
				
				
				this.Atributos.push({config:{
									 name: codigo_col+'_key',
									 inputType:'hidden'
									},
									type:'Field',
									form:true
							});
					
			}
			
			this.fields.push('total');
			recText=recText+'@total#numeric'
			this.Atributos.push({config:{
                                     name: 'total',
                                     fieldLabel: 'Total',
                                      anchor: '80%',
                                     gwidth: 100,
                                     maxLength:100,
                                     renderer:function (value,p,record){
                                          
                                                   if(record.data.concepto=='Total'){
                                                     return String.format('<b><font color="red">{0}</font></b>', value);
                                                  }
                                                  else{
                                                      return String.format('<b><font color="green">{0}</font></b>', value);
                                                    
                                                  }
                                            
                                            }
                                    },
                                    type:'NumberField',
                                    filters:{pfiltro:'total',type:'numeric'},
                                    id_grupo:1,
                                    egrid:false,
                                    grid:true,
                                    form:false
                            });
			
			Phx.CP.loadingHide();
			
			this.initButtons=[this.cmbTipo,this.cmbCasaOracion,this.cmbGestion];
			Phx.vista.MovimientoDinamico.superclass.constructor.call(this,this.config);
			
			this.argumentExtraSubmit={'datos':recText};
		    
		    this.init();
		    
		    this.cmbTipo.on('select',function(cm,dat,num){
          
                   if(this.validarFiltros()){
                          this.capturaFiltros();
                   }
             },this);
        
            this.cmbCasaOracion.on('select',function(cm,dat,num){
                 if(this.validarFiltros()){
                              this.capturaFiltros();
                       }
             },this);
            
            
            this.cmbGestion.on('select',function(cm,dat,num){
               
                if(this.validarFiltros()){
                              this.capturaFiltros();
                       }
            },this);
        
        
		    
			
			this.store.baseParams={'datos':recText};			               
		
            //this.load({params:{start:0, limit:50}})
		}
		
	},
	
	  validarFiltros:function(){
        if(this.cmbCasaOracion.isValid()&& this.cmbGestion.isValid() && this.cmbTipo.isValid() ){
            return true;
        }
        else{
            return false;
        }
        
    },
	
	 onButtonAct:function(){
        if(!this.validarFiltros()){
            alert('Especifique los filtros antes')
         }
        else{
            this.store.baseParams.tipo=this.cmbTipo.getValue();
            this.store.baseParams.id_casa_oracion=this.cmbCasaOracion.getValue();
            this.store.baseParams.id_gestion=this.cmbGestion.getValue();
            Phx.vista.MovimientoDinamico.superclass.onButtonAct.call(this);
        }
    },
    
     capturaFiltros:function(combo, record, index){
        this.store.baseParams.tipo=this.cmbTipo.getValue();
        this.store.baseParams.id_casa_oracion=this.cmbCasaOracion.getValue();
        this.store.baseParams.id_gestion=this.cmbGestion.getValue();
        this.store.load({params:{start:0, limit:this.tam_pag}}); 
            
        
    },
	cmbTipo:new Ext.form.ComboBox({
                    name:'tipo',
                    fieldLabel:'Tipo',
                    allowBlank:false,
                    emptyText:'Tipo...',
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender:true,
                    value:'ingreso',
                    mode: 'local',
                    width: 70,
                    store:['ingreso','egreso']
                }),
    cmbCasaOracion:new Ext.form.ComboBox({
                fieldLabel: 'Casa de Oración',
                allowBlank: false,
                emptyText:'Casa...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/CasaOracion/listarCasaOracion',
                    id: 'id_casa_oracion',
                    root: 'datos',
                    sortInfo:{
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_casa_oracion','codigo','nombre'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'nombre'}
                }),
                valueField: 'id_casa_oracion',
                displayField: 'nombre',
                hiddenName: 'id_casa_oracion',
                triggerAction: 'all',
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:210,
                minChars:2
                }),
     cmbGestion:new Ext.form.ComboBox({
                fieldLabel: 'Gestion',
                allowBlank: false,
                emptyText:'Gestion...',
                store:new Ext.data.JsonStore(
                {
                    url: '../../sis_admin/control/Gestion/listarGestion',
                    id: 'id_gestion',
                    root: 'datos',
                    sortInfo:{
                        field: 'gestion',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_gestion','gestion'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'gestion'}
                }),
                valueField: 'id_gestion',
                triggerAction: 'all',
                displayField: 'gestion',
                hiddenName: 'id_gestion',
                mode:'remote',
                pageSize:50,
                queryDelay:500,
                listWidth:'280',
                width:80
            }),
	
	
	title:'Movimiento Económico CCB',
	ActList:'../../sis_admin/control/Movimiento/listarMovimientoDinamico',
	bdel:false,
	bsave:false,
	bnew:true,
	bedit:false,
	fwidth: 450,
	
	/*  
	 east:{
		  url:'../../../sis_mantenimiento/vista/equipo_medicion/IndicadoresMediciones.php',
		  title:'Indicadores', 
		  //height:'50%',	//altura de la ventana hijo
		  width:'50%',		//ancho de la ventana hjo
		  cls:'IndicadoresMediciones'
	} */
	    
	
		
}
)
</script>
		
		