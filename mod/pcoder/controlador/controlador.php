<?php
	/*
	   PCODER (Editor de Codigo en la Nube)
	   Sistema de Edicion de Codigo basado en PHP
	   Copyright (C) 2013  John F. Arroyave Gutiérrez
						   unix4you2@gmail.com
						   www.practico.org

	 This program is free software: you can redistribute it and/or modify
	 it under the terms of the GNU General Public License as published by
	 the Free Software Foundation, either version 3 of the License, or
	 (at your option) any later version.

	 This program is distributed in the hope that it will be useful,
	 but WITHOUT ANY WARRANTY; without even the implied warranty of
	 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 GNU General Public License for more details.

	 You should have received a copy of the GNU General Public License
	 along with this program.  If not, see <http://www.gnu.org/licenses/>
	*/


	// 1. Llama al modelo, encargado de abstraer las operaciones de consulta a BD
	//require($ruta_modelos.'modelo.php');
	// 2. Pasa los datos generados por una funcion existente en el modelo a un variable independiente
	//$registros = getAuditoria();
	// 3. Llama a la vista, encargada de presentar los datos genericos entregados desde el modelo
	//require($ruta_vistas.'vista.php');


function PCODER_cargar_archivo($PCODER_archivo)
    {
        global $PCODER_extension,$PCODERcontenido_archivo,$PCODER_TamanoElemento,$PCODER_TipoElemento,$PCODER_FechaElemento;
        global $PCODER_Modos,$PCODER_ModoEditor,$PCODER_NombreArchivo,$PCODER_TokenEdicion;
        
        //Obtiene la extension del archivo
        $PCODER_partes_extension = explode(".",$PCODER_archivo);
        $PCODER_extension = $PCODER_partes_extension[count($PCODER_partes_extension)-1];

        //Obtiene el nombre del archivo para el titulo de ventana
        $PCODER_PartesNombreArchivo=explode(DIRECTORY_SEPARATOR,$PCODER_archivo);
        $PCODER_NombreArchivo = $PCODER_PartesNombreArchivo[count($PCODER_PartesNombreArchivo)-1];

        //Identifica el tipo de documento a ser aplicado segun la extension del archivo
        $PCODER_ModoEditor='';
        for ($i=0;$i<count($PCODER_Modos) && $PCODER_ModoEditor=='';$i++)
            {
               if(strpos($PCODER_Modos[$i]["Extensiones"], $PCODER_extension) !== false)
                    $PCODER_ModoEditor=$PCODER_Modos[$i]["Nombre"];
            }

        //Carga y Escapa el contenido del archivo
        $PCODERcontenido_original_archivo=@file_get_contents($PCODER_archivo);
        $PCODERcontenido_archivo=@htmlspecialchars($PCODERcontenido_original_archivo);

        //Cargar otras caracteristicas del archivo
        $PCODER_TamanoElemento=@round(filesize($PCODER_archivo)/1024);
        $PCODER_TipoElemento=@filetype($PCODER_archivo);
        $PCODER_FechaElemento=@date("d F Y H:i:s", @filemtime($PCODER_archivo));

        //Define un Token con el antes y despues
        $PCODER_TokenEdicion=md5($PCODER_archivo.$PCODER_TamanoElemento.$PCODER_FechaElemento.$PCODERcontenido_original_archivo);

        //DOCS: http://stackoverflow.com/questions/15186558/loading-a-html-file-into-ace-editor-pre-tag
        //DOCS: <pre id="editor"><INTE ? php echo htmlentities(file_get_contents($input_dir."abc.html")); ? ></pre>
        //$PCODERcontenido_archivo=@htmlspecialchars(addslashes($PCODERcontenido_archivo));
    }



function PCODER_guardar_archivo($PCODER_archivo,$PCODER_contenido_archivo)
    {





    }


/* ################################################################## */
/* ################################################################## */
    function abrir_dialogo_modal($identificador,$titulo="",$estilo_modal="")
        {
            /*
            Procedure: abrir_modal
            Crea un dialogo modal que puede ser activado luego por un anchor <a>

            Variables de entrada:

            titulo - Nombre de la ventana a visualizar en la parte superior.
            tipo_panel - Recibe el tipo de panel bootstrap a crear: 

            * panel-primary,panel-success,panel-info,panel-warning,panel-danger
            * col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-
            * Otros asociados a clases de bootstrap
            
            Ver tambien:
            <cerrar_modal>
            */
            echo '
                <div class="modal fade '.$estilo_modal.'" id="'.$identificador.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">'.$titulo.'</h4>
                            </div>
                            <div class="modal-body mdl-primary">';
        }



/* ################################################################## */
/* ################################################################## */
	function cerrar_dialogo_modal($contenido_piepagina)
	  {
		/*
			Function: cerrar_modal
			Cierra los espacios de trabajo por <abrir_modal>	

			Ver tambien:
			<abrir_modal>	
		*/
        echo '
                            </div>
                            <div class="modal-footer">
                                '.$contenido_piepagina.'
                            </div>
                        </div>
                    </div>
                </div>';
	  }



/* ################################################################## */
/* ################################################################## */
/*
    Function: mensaje
    Funcion generica para la presentacion de mensajes.  Ver variables para personalizacion.

    Variables de entrada:

        titulo - Texto que aparece en resaltado como encabezado del texto.  Acepta modificadores HTML.
        texto - Mensaje completo a desplegar en formato de texto normal.  Acepta modificadores HTML.
        icono - Formato Awesome Fonts o Iconos de Bootstrap
        ancho - Ancho del espacio de trabajo definido en pixels o porcentaje sobre el contenedor principal.
        estilo - Especifica el punto donde sera publicado el mensaje para definir la hoja de estilos correspondiente.
*/
	function mensaje($titulo,$texto,$DEPRECATED_ancho="",$icono,$estilo)
	  {
        global $MULTILANG_PCODER_Cerrar;
        echo '<div class="'.$estilo.'" role="alert">
                <i class="'.$icono.' pull-left"></i>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">'.$MULTILANG_PCODER_Cerrar.'</span></button>
                <strong>'.$titulo.'</strong><br>'.$texto.'
            </div>';
	  }
