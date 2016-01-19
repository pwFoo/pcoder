
function CambiarFuenteEditor(tamano)
	{
		//Cambia la fuente del editor al tamano recibido
		editor.setFontSize(tamano);
		try
			{
				EditorClonado.setFontSize(tamano);
			}
		catch(error) {}
	}
function CambiarTemaEditor(tema)
	{
		//Cambia la apariencia grafica del editor
		editor.setTheme(tema);
		try
			{
				EditorClonado.setTheme(tema);
			}
		catch(error) {}
	}
function CambiarModoEditor(modo)
	{
		var ModoFiltrado = modo.replace(/_/g, " ");
		ModoFiltrado = ModoFiltrado.toLowerCase();
		//Cambia el modo de sintaxis y errores resaltado por el editor
		editor.getSession().setMode(ModoFiltrado);
		try
			{
				EditorClonado.getSession().setMode(ModoFiltrado);
			}
		catch(error) {}
	}
function CaracteresInvisiblesEditor(estado)
	{
		//Cambia el modo del editor para mostrar (true) u ocultar (false) los caracteres invisibles
		if (estado==0)
			editor.setShowInvisibles(false);
		else
			editor.setShowInvisibles(true);
	}
function VerificarSintaxisEditor(estado)
	{
		//Cambia el la verificacion de sintaxis del editor
		if (estado==0)
			editor.session.setOption("useWorker", false);
		else
			editor.session.setOption("useWorker", true);
	}
function VerificarAutocompletadoEditor(estado)
	{
		//Cambia el la verificacion de sintaxis del editor
		if (estado==0)
			{
				 editor.session.setOption("enableBasicAutocompletion", false);
				 editor.session.setOption("enableSnippets", false);
				 editor.session.setOption("enableLiveAutocompletion", false);
			}
		else
			{
				editor.session.setOption("enableBasicAutocompletion", true);
				editor.session.setOption("enableSnippets", true);
				editor.session.setOption("enableLiveAutocompletion", true);
			}
	}
function IntercambiarEstadoCaracteresInvisibles()
	{
		//InterCambia el modo del editor para mostrar (true) u ocultar (false) los caracteres invisibles segun su estado actual
		if (editor.getShowInvisibles()==true)
			editor.setShowInvisibles(false);
		else
			editor.setShowInvisibles(true);
	}
function ActualizarTituloEditor(titulo)
	{
		//Cambia el titulo presentado en la ventada del editor
		document.title = titulo;
		$(document).attr('title',titulo);
	}
function SaltarALinea()
	{
		//Salta a una linea especifica del editor
		var linea = document.getElementById("linea_salto").value;
		//Valida que se tenga un valor de linea y que este en un rango valido
		if (linea!="" && linea>0)
			{
				editor.gotoLine(linea, 0, true);
				document.getElementById("linea_salto").value="";			
			}
	}
function AvisoAlmacenamiento()
	{
		//$('#VentanaAlmacenamiento').modal('show');
		//Oculta mensaje de guardando y presenta el mensaje de guardar finalizado
		$('#progreso_marco_guardar').hide();
		$('#finalizado_marco_guardar').show();
		$('#boton_marco_guardar').show();
	}
function Guardar()
	{
		//Solamente guarda si no se trata del archivo demo
		if (document.form_archivo_editado.PCODER_archivo.value != "demos/demo.txt")
			{
				//Oculta mensaje de guardar finalizado y presenta el de guardando
				$('#progreso_marco_guardar').show();
				$('#finalizado_marco_guardar').hide();
				$('#boton_marco_guardar').hide();
				//Presenta la ventana informativa sobre el proceso de almacenamiento
				$('#VentanaAlmacenamiento').modal('show');
				//Metodo estandar, envia todo sobre el iframe para evitar recargar la pagina
				document.form_archivo_editado.submit();
			}
	}
function PCO_VentanaPopup(theURL,winName,features)
	{ 
		window.open(theURL,winName,features);
	}
function PCO_AgregarElementoDiv(marco,elemento)
	{
		//carga dinamicamente objetos html a marcos
		var capa = document.getElementById(marco);
		var zona = document.createElement("NuevoElemento");
		zona.innerHTML = elemento;
		capa.appendChild(zona);
	}



//###################################################################################################################
//###################################################################################################################
//###################################################################################################################
//###################################################################################################################
function PCODER_ObtenerContenidoAjax(PCO_ASINCRONICO,PCO_URL,PCO_PARAMETROS)
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
			{   // codigo for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
		else
			{   // codigo for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}

		//funcion que se llama cada vez que cambia la propiedad readyState
		xmlhttp.onreadystatechange=function()
			{
				//readyState 4: peticion finalizada y respuesta lista
				//status 200: OK
				if (xmlhttp.readyState===4 && xmlhttp.status===200)
					{
						contenido_recibido=xmlhttp.responseText;
						contenido_recibido = contenido_recibido.trim();
						//Cuando es asincronico devuelve la respuesta cuando este lista
						if(PCO_ASINCRONICO==1)
							return contenido_recibido;
					}
			};

		/* open(metodo, url, asincronico)
		* metodo: post o get
		* url: localizacion del archivo en el servidor
		* asincronico: comunicacion asincronica true o false.*/
		if(PCO_ASINCRONICO==1)
			xmlhttp.open("POST",PCO_URL,true);
		else
			xmlhttp.open("POST",PCO_URL,false);

		//establece el header para la respuesta
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		//enviamos las variables al archivo get_combo2.php
		//xmlhttp.send();
		xmlhttp.send(PCO_PARAMETROS);
		
		//Cuando la solicitud es asincronica devuelve el resultado al momento de llamado
		if(PCO_ASINCRONICO==0)
			return contenido_recibido;
	}
function PCODER_DesactivarPanelIzquierdo()
	{
		AnchoPanelIzquierdo=0;
		$("#panel_izquierdo").removeClass("col-md-2");
		$("#panel_izquierdo").hide();
		PCODER_RecalcularMaquetacion();
	}
function PCODER_DesactivarPanelDerecho()
	{
		AnchoPanelDerecho=0;
		$("#panel_derecho").removeClass("col-md-2");
		$("#panel_derecho").hide();
		PCODER_RecalcularMaquetacion();
	}
function PCODER_RecalcularPanelesLaterales()  //AjustarPanelesLaterales();
	{
		//Redimensiona, ajusta y aplica clases al editor segun el estado de visualizacion las barras laterales
		AnchoPanelCentral=12-AnchoPanelIzquierdo-AnchoPanelDerecho; //Actualiza segun los anchos de cada panel

		//Remueve las clases tipicas de los paneles y aplica las nuevas
		$("#panel_izquierdo").removeClass("col-md-2");
		$("#panel_derecho").removeClass("col-md-2");
		
		//Si el valor es cero entonces se ocultan sino agrega la clase
		if(AnchoPanelIzquierdo==0)
			$("#panel_izquierdo").hide();
		else
			$("#panel_izquierdo").addClass("col-md-"+AnchoPanelIzquierdo);
		if(AnchoPanelDerecho==0)
			$("#panel_derecho").hide();
		else
			$("#panel_derecho").addClass("col-md-"+AnchoPanelDerecho);

		//Remueve las clases tipicas del editor de codigo y aplica la nueva
		$("#panel_central").removeClass("col-md-8"); //Cuando estan los dos paneles activos
		$("#panel_central").removeClass("col-md-10"); //Cuando esta un solo panel activo
		$("#panel_central").removeClass("col-md-12"); //Cuando esta un solo panel activo
		$("#panel_central").addClass("col-md-"+AnchoPanelCentral);
	}
function PCODER_ActivarPanelIzquierdo()
	{
		AnchoPanelIzquierdo=2;
		$("#panel_izquierdo").show();
		$("#panel_izquierdo").removeClass("col-md-0");
		$("#panel_izquierdo").addClass("col-md-"+AnchoPanelIzquierdo);
		PCODER_RecalcularMaquetacion();
	}	
function PCODER_ActivarPanelDerecho()
	{
		AnchoPanelDerecho=2;
		$("#panel_derecho").show();
		$("#panel_derecho").removeClass("col-md-0");
		$("#panel_derecho").addClass("col-md-"+AnchoPanelDerecho);
		PCODER_RecalcularMaquetacion();
	}
function PCODER_RecalcularPanelesEditores()
	{
		//Define el ALTO Y ANCHO DE LOS EDITORES segun la disposicion visual (splits) y el tamano del panel_central_medio
		var AltoDisponible_Editores = $("#panel_central_medio").height();
		var AnchoDisponible_Editores = $("#panel_central_medio").width();

		//Establece tamanos especificos para los editores segun la disposicion visual (splits) y deja visible el editor clonado
		if(ListaArchivos[IndiceArchivoActual].VistaSplit=="H")
			{
				AltoDisponible_Editores=Math.round(AltoDisponible_Editores/2)-2;
				$("#panel_editor_clonado").show();
			}
			
		if(ListaArchivos[IndiceArchivoActual].VistaSplit=="V")
			{
				AnchoDisponible_Editores=Math.round(AnchoDisponible_Editores/2)-2;
				$("#panel_editor_clonado").show();
			}

		//Reasigna los anchos y altos a los paneles por defecto
		AltoEditorReal = AltoDisponible_Editores;
		AnchoEditorReal = AnchoDisponible_Editores;
		AltoEditorClonado = AltoDisponible_Editores;
		AnchoEditorClonado = AnchoDisponible_Editores;
		
		//Si no hay divisiones pone en ceros el editor clonado y ademas oculta el marco que lo contiene
		if(ListaArchivos[IndiceArchivoActual].VistaSplit=="")
			{
				AltoEditorClonado = 0;
				AnchoEditorClonado = 0;
				$("#panel_editor_clonado").hide();
			}
		
		$('#editor_codigo').height( AltoEditorReal+"px" ).css({ });	//Asignacion en porcentaje
		$('#editor_codigo').width( AnchoEditorReal+"px" ).css({ });	//Asignacion en porcentaje
		$('#editor_clonado').height( AltoEditorClonado+"px" ).css({ });	//Asignacion en porcentaje
		$('#editor_clonado').width( AnchoEditorClonado+"px" ).css({ });	//Asignacion en porcentaje
		
		//Actualiza el tamano de los editores segun las nuevas dimensiones
		editor.resize();
		try
			{
				EditorClonado.resize();
			}
		catch(error)
			{
				//document.getElementById("demo").innerHTML = err.message;
			}
	}
function PCODER_DividirPantalla_NO()
	{
		//Ejecuta la operacion si ya no esta dividido
		if (ListaArchivos[IndiceArchivoActual].VistaSplit!="")
			{
				ListaArchivos[IndiceArchivoActual].VistaSplit="";
				//Actualiza el editor
				PCODER_RecalcularMaquetacion();
			}
	}
function PCODER_DividirPantalla_Horizontal()
	{
		//Ejecuta la operacion si ya no esta dividido
		if (ListaArchivos[IndiceArchivoActual].VistaSplit!="H")
			{
				ListaArchivos[IndiceArchivoActual].VistaSplit="H";
				ClonarPropiedadesEditor();
				//Actualiza el editor
				PCODER_RecalcularMaquetacion();
			}
	}
function PCODER_DividirPantalla_Vertical()
	{
		//Ejecuta la operacion si ya no esta dividido
		if (ListaArchivos[IndiceArchivoActual].VistaSplit!="V")
			{
				ListaArchivos[IndiceArchivoActual].VistaSplit="V";
				ClonarPropiedadesEditor();
				//Actualiza el editor
				PCODER_RecalcularMaquetacion();
			}
	}

function PCODER_RecalcularMaquetacion()   //RedimensionarEditor();
	{
		PCODER_RecalcularPanelesLaterales();

		//Obtiene las dimensiones actuales de la ventana de edicion y algunos objetos
		var AltoVentana = $(window).height();
		var AnchoVentana = $(window).width();
		var AltoDocumento = $(document).height();
		var AnchoDocumento = $(document).width();

		//Obtiene el alto de los diferentes marcos que componen el aplicativo
		var alto_panel_superior = $("#panel_superior").height();
		var alto_panel_central_superior = $("#panel_central_superior").height();
		var alto_panel_central_inferior = $("#panel_central_inferior").height();
		var alto_panel_inferior = $("#panel_inferior").height();

		//Modifica el ALTO DEL PANEL CENTRAL MEDIO
		var PorcentajeOcupacion_PanelesAplicativo = ( alto_panel_superior + alto_panel_central_superior + alto_panel_central_inferior + alto_panel_inferior ) * 100 / AltoVentana;
		var PorcentajeFinal_PanelCentralMedio = 100 - PorcentajeOcupacion_PanelesAplicativo;
		$('#panel_central_medio').height( PorcentajeFinal_PanelCentralMedio+"vh" ).css({ });
		
		PCODER_RecalcularPanelesEditores();
	}
function IntercambiarPantallaCompleta()
	{
		if (!document.fullscreenElement &&    // alternative standard method
		  !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
			if (document.documentElement.requestFullscreen) {
			  document.documentElement.requestFullscreen();
			} else if (document.documentElement.msRequestFullscreen) {
			  document.documentElement.msRequestFullscreen();
			} else if (document.documentElement.mozRequestFullScreen) {
			  document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullscreen) {
			  document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
			}
		} else {
			if (document.exitFullscreen) {
			  document.exitFullscreen();
			} else if (document.msExitFullscreen) {
			  document.msExitFullscreen();
			} else if (document.mozCancelFullScreen) {
			  document.mozCancelFullScreen();
			} else if (document.webkitExitFullscreen) {
			  document.webkitExitFullscreen();
			}
		}
	}
function AumentarTamanoFuente()
	{
		tamano=editor.getFontSize();
		tamano = tamano.substring(0, tamano.length-2); //Elimina las letras de px al final
		tamano=parseInt(tamano)+2;
		CambiarFuenteEditor(tamano+"px");
	}
function DisminuirTamanoFuente()
	{
		tamano=editor.getFontSize();
		tamano = tamano.substring(0, tamano.length-2); //Elimina las letras de px al final
		tamano=parseInt(tamano)-2;
		CambiarFuenteEditor(tamano+"px");
	}
function ExplorarPath()
	{
		//Inicializa el explorador de archivos
		$(document).ready( function() {
			$('#marco_explorador').fileTree({ root: path_exploracion_archivos.value, script: '../../inc/jquery/plugins/jquery.fileTree-1.01/connectors/jqueryFileTree.php' }, function(archivo_seleccionado) {
				//alert(file);
				//PCODER_CargarArchivo('[link]');
				PCODER_CargarArchivo(archivo_seleccionado);
			});

		});
	}
function ActualizarBarraEstado()
	{
		//Actualiza ademas las posiciones del cursor sobre el arreglo de archivos abiertos
		posicion_cursor=editor.getCursorPosition();
		ListaArchivos[IndiceArchivoActual].LineaActual=posicion_cursor.row;
		ListaArchivos[IndiceArchivoActual].ColumnaActual=posicion_cursor.column;

		//Actualiza la barra de estado del editor
		var NroLineasDocumento=editor.session.getLength();
		var NroCaracteresDocumento=editor.session.getValue().length;
		//Actualiza los contenedores con la informacion de estado
		$("#NroLineasDocumento").html(MULTILANG_PCODER_Linea +": " + (ListaArchivos[IndiceArchivoActual].LineaActual+1) +" / "+NroLineasDocumento);
		$("#NroColumnaDocumento").html(MULTILANG_PCODER_Columna +": "+ (ListaArchivos[IndiceArchivoActual].ColumnaActual+1));
		$("#NroCaracteresDocumento").html(MULTILANG_PCODER_Caracteres +": "+NroCaracteresDocumento);
		$("#TipoDocumento").html(MULTILANG_PCODER_Tipo +": "+ListaArchivos[IndiceArchivoActual].TipoDocumento);
		$("#TamanoDocumento").html(MULTILANG_PCODER_Tamano +": <b>"+ListaArchivos[IndiceArchivoActual].TamanoDocumento+" Kb</b>");
		$("#FechaModificadoDocumento").html(MULTILANG_PCODER_Modificado +": <b>"+ListaArchivos[IndiceArchivoActual].FechaModificadoDocumento+"</b>");
		
		//Llama periodicamente la rutina de actualizacion de la barra
		window.setTimeout(ActualizarBarraEstado, 1000);
	}
function AgregarNuevoTextarea(nombre_formulario,nombre_textarea,valor_predeterminado)
	{
		//contenedor.innerHTML = '<textarea name="pepe" rows="5" cols="30"></textarea>';
		elemento_textarea = document.createElement('textarea');
		elemento_textarea.cols = 1;
		elemento_textarea.rows = 1;
		elemento_textarea.name = nombre_textarea;
		elemento_textarea.id = nombre_textarea;	
		elemento_textarea.value = valor_predeterminado;
		nombre_formulario.appendChild(elemento_textarea);
	} 


function PCODER_CambiarArchivoActual(IndiceRecibido,VieneDesdeApertura)
	{
		//Si viene en valor 1 se trata de una apertura de archivo, por lo que no se requiere guardar valores previos.  Si viene en 0 se trata de un cambio de archivo desde la barra y guarda valores previos.
		if(VieneDesdeApertura==0)
			document.getElementById("PCODER_AreaTexto"+IndiceArchivoActual).value=editor.getSession().getValue();
		
		//Actualiza el Textarea y formulario base del editor
		document.form_archivo_editado.PCODER_archivo.value=ListaArchivos[IndiceRecibido].RutaDocumento;
		document.form_archivo_editado.PCODER_TokenEdicion.value=ListaArchivos[IndiceRecibido].TokenEdicion;
		document.form_archivo_editado.PCODER_AreaTexto.value=document.getElementById("PCODER_AreaTexto"+IndiceRecibido).value;
		//Actualiza el editor ACE y sus propiedades
		editor.setValue(document.getElementById("PCODER_AreaTexto"+IndiceRecibido).value);
		editor.focus();											//Establece el foco al editor
		editor.gotoLine(ListaArchivos[IndiceRecibido].LineaActual+1, ListaArchivos[IndiceRecibido].ColumnaActual, false);							//Ubica cursor en la linea,columna,sin animacion
		editor.scrollToLine(ListaArchivos[IndiceRecibido].LineaActual+1, true, false, function () {});	//Desplaza archivo hasta la linea, sin centrarla en pantalla, sin animacion
		editor.clearSelection();
		ActualizarTituloEditor("{P} "+ListaArchivos[IndiceRecibido].NombreArchivo);
		//Actualiza el modo de editor solamente si ha cambiado desde el archivo anterior
		if (ListaArchivos[IndiceArchivoActual].ModoEditor!=ListaArchivos[IndiceRecibido].ModoEditor)
			CambiarModoEditor("ace/mode/"+ListaArchivos[IndiceRecibido].ModoEditor);
		
		//Actualiza el indice del archivo de trabajo actual
		IndiceArchivoActual=IndiceRecibido;
		
		//Verifica permisos de escritura en cada cargue de archivo para saber si presenta o no mensaje de advertencia
		ValorPermisosRW=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_VerificarPermisosRW&PCODER_archivo="+ListaArchivos[IndiceRecibido].RutaDocumento);
		if(ValorPermisosRW==0 && ListaArchivos[IndiceRecibido].RutaDocumento!='demos/demo.txt')
			contenedor_mensajes_superior.innerHTML = '<div class="alert alert-warning btn-xs" role="alert" style="margin: 0px; padding: 5px;" ><i class="fa fa-warning"></i> '+'<b>' + MULTILANG_PCODER_ErrorRW + '</b>. ' + MULTILANG_PCODER_Estado + '=' + ListaArchivos[IndiceRecibido].PermisosArchivo+'</div>';
		else
			contenedor_mensajes_superior.innerHTML = '';

		//Despues de haber agregado el archivo al arreglo procede a presentarlo en las pestanas
		ActualizarPestanasArchivos();
	}

function PCODER_CerrarArchivo(IndiceRecibido)
	{
		//Limpia todos los campos del vector
		ListaArchivos[IndiceRecibido].TipoDocumento="";
		ListaArchivos[IndiceRecibido].TamanoDocumento="";
		ListaArchivos[IndiceRecibido].FechaModificadoDocumento="";
		ListaArchivos[IndiceRecibido].RutaDocumento="";
		ListaArchivos[IndiceRecibido].TokenEdicion="";
		ListaArchivos[IndiceRecibido].ModoEditor="";
		ListaArchivos[IndiceRecibido].NombreArchivo="";
		ListaArchivos[IndiceRecibido].LineaActual="";
		ListaArchivos[IndiceRecibido].PermisosRW="";
		ListaArchivos[IndiceRecibido].PermisosArchivo="";
		ListaArchivos[IndiceRecibido].VistaSplit="";

		//Verifica si se trata del archivo actual, si es asi entonces se mueve al primero.Si es el primero entonces se mueve al demo
		if(IndiceRecibido==1)
			IndiceArchivoActual=0;
		else
			{
				if(IndiceRecibido==IndiceArchivoActual)
					IndiceArchivoActual=1;
			}

		ActualizarPestanasArchivos();
		//Se asegura de corregir tamano del editor cuando se actualizan las pestanas

		PCODER_CambiarArchivoActual(IndiceArchivoActual,1);
	}

function PCODER_CerrarArchivoActual()
	{
		PCODER_CerrarArchivo(IndiceArchivoActual);
	}

function PCODER_BuscarArchivoAbierto(path_archivo)
	{
		Encontrado=-1;
		//Determina si el archivo ya esta abierto o no (dentro del arreglo)
		//Retorna -1 si no es encontrado o el indice en caso de existir
		for (i=0;i<IndiceAperturaArchivo;i++)
			{
				if(ListaArchivos[i].RutaDocumento==path_archivo)
					Encontrado=i;
			}
		//Retorna el estado de variable si fue o no encontrado el archivo
		return Encontrado;
	}

function ActualizarPestanasArchivos()
	{
		var HayArchivosAbiertos=0;
		//Limpia el marco de pestanas
		lista_contenedor_archivos.innerHTML = "";

		//Recorre arreglo de archivos y regenera las pestanas
		for (i=1;i<IndiceAperturaArchivo;i++)
			{
				//Si se trata del primer archivo lo pone como activo en la barra
				ComplementoClase='';
				if (IndiceArchivoActual==i)
					ComplementoClase='class="active"';
				//Agrega el elemento simepre y cuando no sea vacio
				if (ListaArchivos[i].NombreArchivo!="")
					{
						//Construye datos para el ToolTip
						ComplementoTooltip='<i class=\'fa fa-hdd-o\'></i> '+ListaArchivos[i].RutaDocumento+'<br>';
						ComplementoTooltip+='<i class=\'fa fa-key\'></i> '+'Permisos (CHMOD): '+ListaArchivos[i].PermisosArchivo+'<br>';
						//Pestana con nombre de archivo
						lista_contenedor_archivos.innerHTML = lista_contenedor_archivos.innerHTML + '<li '+ComplementoClase+' ><a data-toggle="tooltip" data-html="true" data-placement="bottom" title="'+ComplementoTooltip+'" style="cursor:pointer;" OnClick="PCODER_CambiarArchivoActual('+i+',0);"><i class="fa fa-file-text-o fa-inactive"></i> '+ListaArchivos[i].NombreArchivo+'</a></li>';
						//Boton para cerrar el archivo
						lista_contenedor_archivos.innerHTML = lista_contenedor_archivos.innerHTML + '<li ><a data-toggle="tab" style="cursor:pointer; margin-right: 10px;" OnClick="PCODER_CerrarArchivo('+i+');"><i class="fa fa-times"></i></a></li>';								
						HayArchivosAbiertos=1;
					}

				//Actualiza el Tooltip asociado a la pestana agregada
				RecargarToolTipsEnlaces();
			}
		//Si encuentra archivos abiertos actualiza el tamaño de la barra con pestanas de archivos, sino la pone en cero
		if(HayArchivosAbiertos==1)
			$('#contenedor_archivos').height( "auto" ).css({ });
		else
			$('#contenedor_archivos').height( "0px" ).css({ });

		//Se asegura de corregir tamano del editor cuando se carga un archivo
		PCODER_RecalcularMaquetacion();
	}

function PCODER_CargarArchivo(path_archivo)
	{
		if (typeof path_archivo == 'undefined') path_archivo="demos/demo.txt";
		
		//Determina si el archivo ya ha sido abierto o no
		BusquedaArchivoAbierto=-1;
		if(IndiceAperturaArchivo>0)
			BusquedaArchivoAbierto=PCODER_BuscarArchivoAbierto(path_archivo);

		//Graba el estado del editor cuando se abre un nuevo archivo y no se trata del demo
		if(IndiceAperturaArchivo!=0)
			document.getElementById("PCODER_AreaTexto"+IndiceArchivoActual).value=editor.getSession().getValue();

		if (BusquedaArchivoAbierto==-1)
			{
				//Busca algunos datos del archivo
				ValorTipoElemento=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerTipoElemento&PCODER_archivo="+path_archivo);
				ValorTamanoDocumento=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerTamanoDocumento&PCODER_archivo="+path_archivo);
				ValorFechaModificadoDocumento=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerFechaElemento&PCODER_archivo="+path_archivo);
				ValorTokenEdicion=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerTokenEdicion&PCODER_archivo="+path_archivo);
				ValorModoEditor=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerModoEditor&PCODER_archivo="+path_archivo);
				ValorNombreArchivo=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerNombreArchivo&PCODER_archivo="+path_archivo);
				ValorContenidoArchivo=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerContenidoArchivo&PCODER_archivo="+path_archivo);
				ValorPermisosRW=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_VerificarPermisosRW&PCODER_archivo="+path_archivo);
				ValorPermisosArchivo=PCODER_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPermisosArchivo&PCODER_archivo="+path_archivo);
				ValorVistaSplit=""; //Valor inicial de la vista dividida (sin dividir)

				//Agrega nuevo elemento al arreglo
				ListaArchivos[IndiceAperturaArchivo] = { TipoDocumento: ValorTipoElemento, TamanoDocumento: ValorTamanoDocumento, FechaModificadoDocumento: ValorFechaModificadoDocumento, RutaDocumento: path_archivo, TokenEdicion: ValorTokenEdicion, ModoEditor: ValorModoEditor, NombreArchivo: ValorNombreArchivo, LineaActual: 1, ColumnaActual: 0 , PermisosRW: ValorPermisosRW, PermisosArchivo: ValorPermisosArchivo, VistaSplit: ValorVistaSplit};
				
				//Crea dinamicamente el textarea con el numero de indice y con su valor predeterminado
				AgregarNuevoTextarea(document.form_textareas_archivos,"PCODER_AreaTexto"+IndiceAperturaArchivo,ValorContenidoArchivo);
				
				//Actualiza los indices de posiciones en el vector
				IndiceUltimoArchivoAbierto=IndiceAperturaArchivo;
				IndiceArchivoActual=IndiceAperturaArchivo;
				IndiceAperturaArchivo++;

				//Actualiza todo el editor con el archivo recier cargado
				PCODER_CambiarArchivoActual(IndiceArchivoActual,1);
				CambiarModoEditor("ace/mode/"+ListaArchivos[IndiceArchivoActual].ModoEditor); //Hace cambio forzado de tipo de editor cuando se abre un nuevo archivo
			}
		else
			{
				PCODER_CambiarArchivoActual(BusquedaArchivoAbierto,0);
			}
	}


//##############################################################
//###              INICIALIZACION DE VARIABLES               ###
//##############################################################
var ListaArchivos = new Array();								//Contiene la lista de los archivos cargados
var IndiceAperturaArchivo=0;									//Posicion del arreglo sobre la que se desea guardar datos al abrir un archivo
var IndiceUltimoArchivoAbierto=IndiceAperturaArchivo;			//Posicion del arreglo que contiene el ultimo archivo abierto
var IndiceArchivoActual=IndiceAperturaArchivo;					//Posicion del arreglo con los datos del archivo actual
var ValorModoEditor;
AnchoPanelIzquierdo=0;
AnchoPanelDerecho=0;

//Evento que quita la barra de progreso de carga para el explorador cada que finaliza el cargue de su IFrame
$('#iframe_marco_explorador').load(function(){
	$('#progreso_marco_explorador').hide();
});

//Incluye extension de lenguaje para ACE
ace.require("ace/ext/language_tools");
// Crea el editor
editor = ace.edit("editor_codigo");
editor.getSession().setUseWorker(true); //Llevar a false para evitar el error 404 para "worker-php.js Failed to load resource: the server responded with a status of 404 (Not Found)"
editor.resize(true);


//Inicia el primer archivo del arreglo (como demo.txt)
PCODER_CargarArchivo();


// Inicia el editor de codigo con las opciones predeterminadas
CambiarFuenteEditor("13px");
CambiarTemaEditor("ace/theme/ambiance");  //tomorrow_night|twilight|eclipse|ambiance|ETC


//Activa la autocompletacion de codigo y los snippets
editor.setOptions({
	enableBasicAutocompletion: true,
	enableSnippets: true,
	enableLiveAutocompletion: true
});
editor.setAnimatedScroll(true);

//Elimina la visualizacion de margen de impresion
editor.setShowPrintMargin(0);
CaracteresInvisiblesEditor(0);


//En cada evento de cambio actualiza el textarea
editor.getSession().on('change', function(){
  document.getElementById("PCODER_AreaTexto").value=editor.getSession().getValue();
});

//Ajusta tamano del editor en cada cambio de tamano de la ventana
$( window ).resize(function() {
	PCODER_RecalcularMaquetacion();
});


// CAPTURA DE EVENTOS DE TECLADO #############################################################
//Captura el evento de Ctrl+S para guardar el archivo
$(window).bind('keydown', function(event) {
	if (event.ctrlKey || event.metaKey) {
		switch (String.fromCharCode(event.which).toLowerCase()) {
		case 's':  //<-- Cambiar para otras letras ;)
			event.preventDefault();
			Guardar();
			break;
		}
	}
});



//Genera una nueva sesion del editor ACE
function ClonarSesionEditor(session)
	{
		var s = new ace.EditSession(session.getDocument(), session.getMode());
		s.$foldData = session.$cloneFoldData();
		return s;
	}

//Toma las propiedades del editor principal y las copia en el editor clonado
function ClonarPropiedadesEditor()
	{
		EditorClonado.setAnimatedScroll(editor.getAnimatedScroll());
		EditorClonado.setBehavioursEnabled(editor.getBehavioursEnabled());
		EditorClonado.setOverwrite(editor.getOverwrite());
		EditorClonado.setPrintMarginColumn(editor.getPrintMarginColumn());
		EditorClonado.setScrollSpeed(editor.getScrollSpeed());
		EditorClonado.setShowInvisibles(editor.getShowInvisibles());
		EditorClonado.setShowPrintMargin(editor.getShowPrintMargin());
		EditorClonado.setWrapBehavioursEnabled(editor.getWrapBehavioursEnabled());
		EditorClonado.setTheme(editor.getTheme());
		EditorClonado.setFontSize(editor.getFontSize());
		
		//Modo de resaltado
		ModoClonado="ace/mode/"+ListaArchivos[IndiceArchivoActual].ModoEditor;
		var ModoFiltrado = ModoClonado.replace(/_/g, " ");
		ModoFiltrado = ModoFiltrado.toLowerCase();
		//Cambia el modo de sintaxis y errores resaltado por el editor
		EditorClonado.getSession().setMode(ModoFiltrado);

		//Evita el chequeo de sintaxis en el editor auxiliar
		EditorClonado.getSession().setUseWorker(false);
	}
	
//Clona el editor hacia uno nuevo para permitir los split
var NuevaSessionEditor = editor.getSession();
var editor_actual = document.getElementById("editor_codigo");
var parent = editor_actual.parentNode;

var clone = editor_actual.cloneNode();
var EditorClonado = ace.edit("editor_clonado");
EditorClonado.setSession( ClonarSesionEditor(NuevaSessionEditor) );

// FUNCIONES DE INICIALIZACION ###############################################################
	ExplorarPath();
	PCODER_RecalcularMaquetacion();
	window.setTimeout(ActualizarBarraEstado, 1000);
