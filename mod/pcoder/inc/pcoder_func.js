
        function CambiarFuenteEditor(tamano)
            {
                //Cambia la fuente del editor al tamano recibido
                editor.setFontSize(tamano);
            }
        function CambiarTemaEditor(tema)
            {
                //Cambia la apariencia grafica del editor
                editor.setTheme(tema);
            }
        function CambiarModoEditor(modo)
            {
                var ModoFiltrado = modo.replace(/_/g, " ");
                ModoFiltrado = ModoFiltrado.toLowerCase();
                //Cambia el modo de sintaxis y errores resaltado por el editor
                editor.getSession().setMode(ModoFiltrado);
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
						editor.gotoLine(linea, 1, true);
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
				//Oculta mensaje de guardar finalizado y presenta el de guardando
				$('#progreso_marco_guardar').show();
				$('#finalizado_marco_guardar').hide();
				$('#boton_marco_guardar').hide();
				//Presenta la ventana informativa sobre el proceso de almacenamiento
				$('#VentanaAlmacenamiento').modal('show');
                //Metodo estandar, envia todo sobre el iframe para evitar recargar la pagina
                document.form_archivo_editado.submit();
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
 
        function PCODER_CargarArchivo(archivo)
            {
                //Oculta el modal de seleccion del archivo
                $('button#boton_navegador_archivos').click();
                //Carga la nueva ventana con el archivo, Reemplaza metodo anterior
                PCO_VentanaPopup('index.php?PCO_Accion=PCOMOD_CargarPcoder&Presentar_FullScreen=1&Precarga_EstilosBS=1&PCODER_archivo='+archivo,'{P} '+archivo,'toolbar=no, location=no, directories=0, directories=no, status=no, location=no, menubar=no ,scrollbars=no, resizable=yes, fullscreen=no, titlebar=no, width=1024, height=700');
            }

        function AjustarPanelesLaterales()
            {
				//Redimensiona, ajusta y aplica clases al editor segun el estado de visualizacion las barras laterales
				ancho_panel_editor=12-panel_izquierdo-panel_derecho; //Actualiza segun los anchos de cada panel

				//Remueve las clases tipicas de los paneles y aplica las nuevas
				$("#panel_izquierdo").removeClass("col-md-2");
				$("#panel_derecho").removeClass("col-md-2");
				//Si el valor es cero entonces se ocultan sino agrega la clase
				if(panel_izquierdo==0)
					$("#panel_izquierdo").hide();
				else
					$("#panel_izquierdo").addClass("col-md-"+panel_izquierdo);
				if(panel_derecho==0)
					$("#panel_derecho").hide();
				else
					$("#panel_derecho").addClass("col-md-"+panel_derecho);

				//Remueve las clases tipicas del editor de codigo y aplica la nueva
				$("#panel_editor_codigo").removeClass("col-md-8"); //Cuando estan los dos paneles activos
				$("#panel_editor_codigo").removeClass("col-md-10"); //Cuando esta un solo panel activo
				$("#panel_editor_codigo").addClass("col-md-"+ancho_panel_editor);
			}
		function ActivarPanelIzquierdo()
			{
				panel_izquierdo=2;
				$("#panel_izquierdo").show();
				$("#panel_izquierdo").removeClass("col-md-0");
				$("#panel_izquierdo").addClass("col-md-"+panel_izquierdo);
				AjustarPanelesLaterales();
			}
		function ActivarPanelDerecho()
			{
				panel_derecho=2;
				$("#panel_derecho").show();
				$("#panel_derecho").removeClass("col-md-0");
				$("#panel_derecho").addClass("col-md-"+panel_derecho);
				AjustarPanelesLaterales();
			}
		function DesactivarPanelIzquierdo()
			{
				panel_izquierdo=0;
				$("#panel_izquierdo").removeClass("col-md-2");
				$("#panel_izquierdo").hide();
				AjustarPanelesLaterales();
			}
		function DesactivarPanelDerecho()
			{
				panel_derecho=0;
				$("#panel_derecho").removeClass("col-md-2");
				$("#panel_derecho").hide();
				AjustarPanelesLaterales();
			}
        function RedimensionarEditor()
            {
				//Obtiene las dimensiones actuales de la ventana de edicion y algunos objetos
				var alto_ventana = $(window).height();
				var alto_documento = $(document).height();
				var alto_contenedor_editor = $("#editor_codigo").height();
				var alto_contenedor_menu = $("#contenedor_menu").height();
				var alto_contenedor_barra_estado = $("#contenedor_barra_estado").height();
				var alto_contenedor_mensajes_error = $("#contenedor_mensajes_error").height();
				var alto_barra_lateral_izquierda = $("#barra_lateral_izquierda").height();
				
				//Modifica el ALTO DEL EDITOR
				var porcentaje_barrasmenuyestado=(alto_contenedor_menu+alto_contenedor_barra_estado+alto_contenedor_mensajes_error)*100/alto_ventana;
				var porcentaje_final=100-porcentaje_barrasmenuyestado;
				var alto_final=alto_ventana-alto_contenedor_menu-alto_contenedor_barra_estado-alto_contenedor_mensajes_error;
				//$('#editor_codigo').height( alto_final ).css({ });			//Asignacion en pixeles
				$('#editor_codigo').height( porcentaje_final+"vh" ).css({ });	//Asignacion en porcentaje
				AjustarPanelesLaterales();
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
				//Presenta la barra de carga que deberia ocultarse automaticamente en el OnLoad del Iframe
				$('#progreso_marco_explorador').show();
				
				//Se encarga de actualizar el path de navegacion de acuerdo al valor del combo
				$('#iframe_marco_explorador').attr('src', 'explorador.php?PCO_PCODER_Accion=PCOMOD_ExplorarPath&PathExploracion='+path_exploracion_archivos.value);
			}


        function ActualizarBarraEstado()
            {
				//Actualiza la barra de estado del editor
				var NroLineasDocumento=editor.session.getLength();
				var NroCaracteresDocumento=editor.session.getValue().length;
				//Actualiza los contenedores con la informacion de estado
				$("#NroLineasDocumento").html("<?php echo $MULTILANG_PCODER_Lineas; ?>: "+NroLineasDocumento);
				$("#NroCaracteresDocumento").html("<?php echo $MULTILANG_PCODER_Caracteres; ?>: "+NroCaracteresDocumento);
				$("#TipoDocumento").html("<?php echo $MULTILANG_PCODER_Tipo; ?>: <?php echo $PCODER_TipoElemento; ?>");
				$("#TamanoDocumento").html("<?php echo $MULTILANG_PCODER_Tamano; ?>: <b><?php echo $PCODER_TamanoElemento; ?> Kb</b>");
				$("#FechaModificadoDocumento").html("<?php echo $MULTILANG_PCODER_Modificado; ?>: <b><?php echo $PCODER_FechaElemento; ?></b>");
				$("#RutaDocumento").html("<i class='fa fa-hdd-o text-info'> <?php echo $PCODER_archivo; ?></i>");

				//Llama periodicamente la rutina de actualizacion de la barra
				window.setTimeout(ActualizarBarraEstado, 1500);
			}
