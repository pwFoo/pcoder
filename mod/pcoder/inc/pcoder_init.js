
		//##############################################################
		//###              INICIALIZACION DE VARIABLES               ###
		//##############################################################
		panel_izquierdo=0;
        panel_derecho=0;

		//Evento que quita la barra de progreso de carga para el explorador cada que finaliza el cargue de su IFrame
		$('#iframe_marco_explorador').load(function(){
			$('#progreso_marco_explorador').hide();
		});

		//Incluye extension de lenguaje para ACE
		ace.require("ace/ext/language_tools");
        // Crea el editor
        editor = ace.edit("editor_codigo");
        editor.getSession().setUseWorker(true); //Llevar a false para evitar el error 404 para "worker-php.js Failed to load resource: the server responded with a status of 404 (Not Found)"
        
        //Actualiza el editor con el valor cargado inicialmente en el textarea
        editor.setValue(document.getElementById("PCODER_AreaTexto").value);

        // Inicia el editor de codigo con las opciones predeterminadas
        ActualizarTituloEditor("<?php echo '{P} '.$PCODER_NombreArchivo; ?>");
        CambiarFuenteEditor("14px");
        CambiarTemaEditor("ace/theme/ambiance");  //tomorrow_night|twilight|eclipse|ambiance|ETC
        CambiarModoEditor("ace/mode/<?php echo $PCODER_ModoEditor; ?>");
        
        
        
        //Activa la autocompletacion de codigo y los snippets
		editor.setOptions({
			enableBasicAutocompletion: true,
			enableSnippets: true,
			enableLiveAutocompletion: true
		});
        
        //Elimina la visualizacion de margen de impresion
        editor.setShowPrintMargin(0);
        CaracteresInvisiblesEditor(0);
        editor.clearSelection();
        
        
        //En cada evento de cambio actualiza el textarea
        editor.getSession().on('change', function(){
          document.getElementById("PCODER_AreaTexto").value=editor.getSession().getValue();
        });

        //Ajusta tamano del editor en cada cambio de tamano de la ventana
        $( window ).resize(function() {
			RedimensionarEditor();
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

		// FUNCIONES DE INICIALIZACION ###############################################################
			ExplorarPath();
			RedimensionarEditor();
			window.setTimeout(ActualizarBarraEstado, 2000);
