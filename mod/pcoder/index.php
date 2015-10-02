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

    // BLOQUE BASICO DE INCLUSION ######################################
    // Inicio de la sesion
    @session_start();
	// Agrega las variables de sesion
	if (!empty($_SESSION)) extract($_SESSION);

    //Permite WebServices propios mediante el acceso a este script en solicitudes Cross-Domain
    header('Access-Control-Allow-Origin: *');
	header('Content-type: text/html; charset=utf-8');

    //Incluye archivo inicial de configuracion
	include_once("configuracion.php");

	// Determina si no se trabaja en modo StandAlone y verifica entonces credenciales
	if ($PCO_PCODER_StandAlone==0)
		{
			// Valida sesion activa de Practico
			if (!isset($PCOSESS_SesionAbierta)) 
				{
					echo '<head><title>Error</title><style type="text/css"> body { background-color: #000000; color: #7f7f7f; font-family: sans-serif,helvetica; } </style></head><body><table width="100%" height="100%" border=0><tr><td align=center>&#9827; Acceso no autorizado !</td></tr></table></body>';
					die();
				}
		}

	// Configuraciones basicas del modulo
	$PCODER_raiz_modulo = "";
	$PCODER_modelos = $PCODER_raiz_modulo."modelo/";
	$PCODER_vistas = $PCODER_raiz_modulo."vista/";
	$PCODER_controladores = $PCODER_raiz_modulo."controlador/";

    //Llamar al controlador inicial de la aplicacion o modulo
    @require($PCODER_modelos.'modelo.php');
    @require($PCODER_vistas.'vista.php');
    @require($PCODER_controladores.'controlador.php');

    //Incluye idioma espanol, o sobreescribe vbles por configuracion de usuario
    include("idiomas/es.php");
    include("idiomas/".$IdiomaPredeterminado.".php");
    // FIN BLOQUE BASICO DE INCLUSION ##################################

    // Datos de fecha, hora y direccion IP para algunas operaciones
    $PCO_PCODER_FechaOperacion=date("Ymd");
    $PCO_PCODER_FechaOperacionGuiones=date("Y-m-d");
    $PCO_PCODER_HoraOperacion=date("His");
    $PCO_PCODER_HoraOperacionPuntos=date("H:i");
    $PCO_PCODER_DireccionAuditoria=$_SERVER ['REMOTE_ADDR'];

	// Establece version actual del sistema
	$PCO_PCODER_VersionActual = file("version_actual.txt");
	$PCO_PCODER_VersionActual = trim($PCO_PCODER_VersionActual[0]);
	
	// Si no hay una accion definida entonces inicia con la predeterminada
	if (@$PCO_Accion=="" || !isset($PCO_Accion))
		$PCO_Accion="PCOMOD_CargarPcoder";

    // Recupera variables recibidas para su uso como globales (equivale a register_globals=on en php.ini)
    if (!ini_get('register_globals'))
    {
        $PCO_PBROWSER_NumeroParametros = count($_REQUEST);
        $PCO_PBROWSER_NombresParametros = array_keys($_REQUEST);// obtiene los nombres de las varibles
        $PCO_PBROWSER_ValoresParametros = array_values($_REQUEST);// obtiene los valores de las varibles
        // crea las variables y les asigna el valor
        for($i=0;$i<$PCO_PBROWSER_NumeroParametros;$i++)
            {
                $$PCO_PBROWSER_NombresParametros[$i]=$PCO_PBROWSER_ValoresParametros[$i];
            }
        // Agrega ademas las variables de sesion
        if (!empty($_SESSION)) extract($_SESSION);
    }


if (@$PCOSESS_LoginUsuario=="admin" || $PCO_PCODER_StandAlone==1)
{
    //Carga el archivo recibido, si no recibe nada carga un demo
    if (@$PCODER_archivo=="")
        $PCODER_archivo = "demo.php";
    PCODER_cargar_archivo($PCODER_archivo);

    $PCODER_Mensajes=0;
    // Verifica que el archivo exista
    $existencia_ok=1;
    if (!file_exists($PCODER_archivo)) { $existencia_ok=0; $PCODER_Mensajes=1; } 
    
    // Verifica permisos de escritura
    $permisos_ok=1;
    $permisos_encontrados=@substr(sprintf('%o', fileperms($PCODER_archivo)), -4);
    if (!is_writable($PCODER_archivo) && $existencia_ok) { $permisos_ok=0; $PCODER_Mensajes=1; } 
    
    // Verifica si existe el directorio para el editor ACE
    $editor_ok=1;
    if (@!file_exists("../../inc/ace")) { $editor_ok=0; $PCODER_Mensajes=1; } 

// Main function file
include("phpFileTree/php_file_tree.php");

/* ################################################################## */
/* ################################################################## */
/*
	Function: PCOMOD_GuardarArchivo
	Almacena un archivo previamente abierto con el PCODER

	Salida:
		Archivo para edicion en pantalla
*/
if ($PCO_Accion=="PCOMOD_GuardarArchivo") 
	{
        //Guarda el archivo
        $PCODER_Respuesta = file_put_contents($PCODER_archivo, $_POST["PCODER_AreaTexto"]) or die("can't open file");
        //Vuelve a cargar el archivo para continuar con su edicion
        auditar("Modifica archivo $PCODER_archivo");
        //Continua presentando todo el editor solo si se pide el echo
        if ($PCO_ECHO==1)
            echo '
                <body>
                <form name="continuar_edicion" action="index.php" method="POST">
                    <input type="Hidden" name="PCO_Accion" value="PCOMOD_CargarPcoder">
                    <input type="Hidden" name="PCODER_archivo" value="'.$PCODER_archivo.'">
                    <input type="Hidden" name="PCODER_TokenEdicion" value="'.$PCODER_TokenEdicion.'">
                    <input type="Hidden" name="Presentar_FullScreen" value="'.@$Presentar_FullScreen.'">
                    <input type="Hidden" name="Precarga_EstilosBS" value="'.@$Precarga_EstilosBS.'">
                <script type="" language="JavaScript"> document.continuar_edicion.submit();  </script>
                </body>';
	}


/* ################################################################## */
/* ################################################################## */
/*
	Function: PCOMOD_CargarPcoder
	Abre el Practico Code Editor y carga un archivo sobre el para su edicion

    Entradas:

        Normalmente los parametros son: ?PCO_Accion=cargar_pcoder&Presentar_FullScreen=1&Precarga_EstilosBS=1
        * Comando: javascript:PCO_VentanaPopup('index.php?PCO_Accion=PCOMOD_CargarPcoder&Presentar_FullScreen=1&Precarga_EstilosBS=1','Pcoder','toolbar=no, location=no, directories=0, directories=no, status=no, location=no, menubar=no ,scrollbars=no, resizable=yes, fullscreen=no, titlebar=no, width=800, height=600');

	Salida:
		Archivo para edicion en pantalla
*/

if ($PCO_Accion=="PCOMOD_CargarPcoder") 
	{


// PARA REVISAR JQUERY-UI http://jqueryui.com/tabs/#manipulation




























?>
 <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
	<title>PCoder</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="generator" content="PCoder <?php  echo $PCO_PCODER_VersionActual; ?>" />
 	<meta name="description" content="Editor de codigo en la Nube basado en Practico Framework PHP" />
    <meta name="author" content="John Arroyave G. - {www.practico.org} - {unix4you2 at gmail.com}">
    
    <!-- CSS Core de Bootstrap -->
    <link href="../../inc/bootstrap/css/bootstrap.min.css" rel="stylesheet"  media="screen">
    <link href="../../inc/bootstrap/css/bootstrap-theme.css" rel="stylesheet"  media="screen">

    <!-- Custom Fonts -->
    <link href="../../inc/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            /*height: 100%;*/
            /*min-height: 100%;*/
            width: 100%;
            background: #888888;  /* 002a36 | BFBFBF | 888888 */
            overflow-x: hidden;
            overflow-y: hidden;
        }
        #marco_editor_codigo { 
            margin-top:34px;
        }
        #marco_explorador { 
            overflow-y: auto;
            overflow-x: auto;
        }
        #editor_codigo { 
            width: 100%; 
            height: 600px;  /*Define el tamano segun resolucion*/
        }
    </style>

    <!-- Agrega archivos necesarios para el Explorador en arbol de directorios -->
    <link href="phpFileTree/styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="phpFileTree/php_file_tree.js" type="text/javascript"></script>
    
    <!-- jQuery -->
	<script type="text/javascript" src="../../inc/jquery/jquery-2.1.0.min.js"></script>
</head>
<body style="margin:0px; padding:0px;">
 
 
 <div id="wrapper" >
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12" style="margin:0px; padding:0px;">
<!-- INICIO  DE CONTENIDOS DE APLICACION -->

	<!-- 
	#######################################################################################
	DISPOSICION PARA EDITOR  ##############################################################
	#######################################################################################  -->




<nav class="navbar navbar-default navbar-inverse  " style="margin:0px; padding:0px;"> <!-- navbar-fixed-top navbar-fixed-bottom navbar-static-top navbar-inverse -->
	<div class="container-fluid">
		<!-- Logo y boton colapsable -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra_menu_superior" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#"><b>{P}Coder</b></a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="barra_menu_superior">



			<ul class="nav navbar-nav">
				<button id="boton_navegador_archivos" class="btn btn-primary btn-xs" data-toggle="modal" href="#NavegadorArchivos" title="<?php echo $MULTILANG_PCODER_Explorar; ?>"><i class="fa fa-folder-open fa-fw"></i></button>



				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $MULTILANG_PCODER_Editar; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#" OnClick="Deshacer();"><i class="fa fa-undo fa-fw"></i> <?php echo $MULTILANG_PCODER_Deshacer; ?></a></li>
						<li><a href="#" OnClick="Rehacer(); "><i class="fa fa-repeat fa-fw"></i> <?php echo $MULTILANG_PCODER_Rehacer; ?></a></li>
						<li role="separator" class="divider"></li>
						<li><a href="#"><i class="fa fa-wrench fa-fw"></i> <?php echo $MULTILANG_PCODER_Preferencias; ?></a></li>
					</ul>
				</li>
				<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
				<li><a href="#">Link</a></li>
			</ul>
			
			<!-- FORMULARIO IR A -->
			<div class="navbar-form navbar-left">
				<input type="text" id="linea_salto" size=9 name="linea_salto" class="input-sm btn-xs btn-default" placeholder="<?php echo $MULTILANG_PCODER_SaltarLinea; ?>">
				<button class="btn btn-default btn-xs" onClick="SaltarALinea();"><?php echo $MULTILANG_PCODER_Ir; ?> <i class="fa fa-arrow-circle-right"></i></button>
			</div>
		
			
			<ul class="nav navbar-nav navbar-right">
				<!-- <li><a href="#">Link</a></li>-->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-question-circle"></i> <?php echo $MULTILANG_PCODER_Ayuda; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a data-toggle="modal" href="#AtajosTeclado"><i class="fa fa-keyboard-o"></i> <?php echo $MULTILANG_PCODER_AtajosTitPcoder; ?></a></li>
						<li role="separator" class="divider"></li>
						<li><a data-toggle="modal" href="#myModalACERCADEPCODER"><i class="fa fa-info-circle fa-fw"></i> <?php echo $MULTILANG_PCODER_Acerca; ?></a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>















	<div class="row navbar-inverse">
		<div class="col-lg-1">
			<!-- LOGO PCODER -->
			<div class="navbar-header">
				<a class="navbar-brand" href=""><img src="../../img/pcoder.png"></a>
			</div>
		</div>
		<div class="col-lg-11">

			<!-- BARRA DE HERRAMIENTAS --> 
			<div class="navbar-form navbar-left">
				<button id="boton_navegador_archivos" class="btn btn-primary btn-xs" data-toggle="modal" href="#NavegadorArchivos" title="<?php echo $MULTILANG_PCODER_Explorar; ?>"><i class="fa fa-folder-open fa-fw"></i></button>
				&nbsp;&nbsp;&nbsp;
				<button id="boton_guardar" class="btn btn-danger btn-xs" OnClick="Guardar();" href="#VentanaAlmacenamiento" title="<?php echo $MULTILANG_PCODER_Guardar; ?>"><i class="fa fa-save fa-fw"></i></button>
				&nbsp;&nbsp;&nbsp;

				
				<a class="btn btn-warning btn-xs" OnClick="if(window.confirm('<?php echo $MULTILANG_PCODER_AjusteConfirma; ?>')===true) MaximizarEditor();" title="Recargar ventana, Util despues de maximizar" ><i class="fa fa-refresh"></i> <?php echo $MULTILANG_PCODER_Ajuste; ?></a>
			</div>

			<!-- INFORMACION DEL ARCHIVO -->
			<ul class="nav navbar-nav navbar-form navbar-right">
				<li class="btn-default btn-xs btn-info">
					&nbsp;<?php echo $MULTILANG_PCODER_Tipo; ?> <span class="badge"><?php echo $PCODER_TipoElemento; ?></span>&nbsp;<br>
					&nbsp;<?php echo $PCODER_FechaElemento; ?> <span class="badge"><?php echo $PCODER_TamanoElemento; ?> Kb</span>&nbsp;<br>
				</li>
			</ul>

		</div>
	</div>


    <div class="row">
		<div class="col-lg-12">
        <?php 
            if ($PCODER_Mensajes==1) echo '<br><br>';
            //Presenta mensajes de error o informacion
            if ($existencia_ok==0)
                mensaje('<i class="fa fa-warning text-info texto-blink"></i> '.$MULTILANG_PCODER_Error.': '.$MULTILANG_PCODER_ErrorExistencia.'. '.$MULTILANG_PCODER_Cargando.'='.$PCODER_archivo, '', '', '', 'alert alert-danger alert-dismissible');
            if ($permisos_ok==0)
                {
                    mensaje('<i class="fa fa-warning text-info texto-blink"></i> '.$MULTILANG_PCODER_Error.': '.$MULTILANG_PCODER_ErrorRW.'. '.$MULTILANG_PCODER_Estado.'='.$permisos_encontrados, '', '', '', 'alert alert-warning alert-dismissible');
                }
            if ($editor_ok==0)
                {
                    mensaje('<i class="fa fa-warning text-info texto-blink"></i> '.$MULTILANG_PCODER_Error.': '.$MULTILANG_PCODER_ErrorNoACE.': '.$PCODER_archivo, '', '', '', 'alert alert-danger alert-dismissible');
                    die();
                }
        ?>
        </div>
    </div>


    <!-- EXPLORADOR DE ARCHIVOS -->
    <?php abrir_dialogo_modal("NavegadorArchivos",$MULTILANG_PCODER_Explorar.' - '.$MULTILANG_PCODER_CargarArchivo); ?>
        <i class="well well-sm btn-xs btn-block"><?php echo $MULTILANG_AyudaExplorador; ?></i>
        <div id="marco_explorador" class="embed-responsive embed-responsive-4by3">
            <?php
                //Presenta el arbol de carpetas
                //echo @php_file_tree($_SERVER['DOCUMENT_ROOT'], "http://example.com/?file=[link]/");
                //echo @php_file_tree(".", "javascript:alert('You clicked on [link]');");
                //echo @php_file_tree(".", "javascript:alert('You clicked on [link]');",$PCODER_ExtensionesPermitidas);
                //$PCODER_ExtensionesPermitidas = array("txt", "php", "inc", "css", "txt");
                echo @php_file_tree("../../../", "javascript:PCODER_CargarArchivo('[link]');");	// .=DirActual ../../=RaizPCoder ../../../=RaizInstalacionPCoder  /=RaizServidor
            ?>  
        </div>
    <?php 
        $barra_herramientas_modal='
        <button type="button" class="btn btn-default" data-dismiss="modal">'.$MULTILANG_PCODER_Cancelar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
    ?>


    <!-- ACERCA DE PCODER -->
    <?php abrir_dialogo_modal("myModalACERCADEPCODER",$MULTILANG_PCODER_Acerca); ?>
		<div align="center">
			<br><h2><b>{P}Coder </b><i>ver <?php echo $PCO_PCODER_VersionActual; ?></i></h2>
			Practico CODe EditoR<br><br>
			 Powered by <a href="http://www.practico.org/"><i>Practico Framework PHP (www.practico.org)</i></a><hr>

			   <b>Editor de C&oacute;digo en la Nube basado en PHP<br></b>
			   Copyright (C) 2015  John F. Arroyave Guti&eacute;rrez<br><br>
			<?php echo $MULTILANG_PCODER_ResumenLicencia; ?><br>
		</div>
    <?php 
        $barra_herramientas_modal='
        <button type="button" class="btn btn-default" data-dismiss="modal">'.$MULTILANG_PCODER_Cerrar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
    ?>


    <!-- EXPLORADOR DE ARCHIVOS -->
    <?php
        abrir_dialogo_modal("VentanaAlmacenamiento","");
        echo '<i class="fa fa-save fa-fw fa-2x"></i>'.$MULTILANG_PCODER_Guardar.' '.$MULTILANG_PCODER_Finalizado;
        $barra_herramientas_modal='
        <button type="button" class="btn btn-default" data-dismiss="modal">'.$MULTILANG_PCODER_Cerrar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
    ?>


    <!-- AYUDA DE TECLADO -->
    <?php abrir_dialogo_modal("AtajosTeclado",$MULTILANG_PCODER_Ayuda.': <b>'.$MULTILANG_PCODER_AtajosTitPcoder.'</b>',"modal-wide"); ?>
        <DIV style="DISPLAY: block; OVERFLOW: auto; WIDTH: 100%; POSITION: relative; HEIGHT: 600px">
            <?php Presentar_KeyBindings(); ?>
        </DIV>
    <?php 
        $barra_herramientas_modal='
        <button type="button" class="btn btn-default" data-dismiss="modal">'.$MULTILANG_PCODER_Cerrar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
    ?>

    <!-- ZONA DE EDICION -->
    <form name="form_archivo_editado" action="index.php" method="POST" target="frame_almacenamiento">
        <textarea id="PCODER_AreaTexto" name="PCODER_AreaTexto" style="visibility:hidden; display:none;"><?php echo $PCODERcontenido_archivo; ?></textarea>
        <input name="PCODER_TokenEdicion" type="hidden" value="<?php echo $PCODER_TokenEdicion; ?>">
        <input name="PCODER_archivo" type="hidden" value="<?php echo $PCODER_archivo; ?>">
        <input type="Hidden" name="Presentar_FullScreen" value="<?php echo $Presentar_FullScreen; ?>">
        <input type="Hidden" name="Precarga_EstilosBS" value="<?php echo $Precarga_EstilosBS; ?>">
        <input type="Hidden" name="PCO_ECHO" value="0"> <!-- Determina si la respuesta debe ser con o sin eco -->
        <input name="PCO_Accion" type="hidden" value="PCOMOD_GuardarArchivo">
    </form>



<!--
    <div class="row">
        <div class="row container-full">
            <div id="marco_editor_codigo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 container-full">
                <div class="form-group">
                    <div id="editor_codigo"></div>
                </div>
            </div>
        </div>
    </div>
-->

<!--
    <div class="row">
		<div class="col-lg-12">
								<div id="editor_codigo" style="display:block; width:100%; height:100vh;" width="100%" height="100vh"></div>
		</div>
    </div>
-->

    <div class="row" style="margin:0px; padding:0px;">
		<div class="col-lg-12" style="margin:0px; padding:0px;">
								<div id="editor_codigo" style="display:block; width:100%; height:100vh;" width="100%"  height="100vh"></div>
		</div>
    </div>


    <!-- CONFIGURACIONES Y UTILIDADES DEL EDITOR -->
<nav id="barra_inferior" class="navbar navbar-default navbar-fixed-bottom">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav text-inverse">

        <li class="btn-xs">
            <label for="tamano_fuente">Tamano Fuente</label>
            <select id="tamano_fuente" size="1" class="form-control btn-xs" onchange="CambiarFuenteEditor(this.value)">
              <option value="10px">10px</option>
              <option value="11px">11px</option>
              <option value="12px">12px</option>
              <option value="13px">13px</option>
              <option value="14px" selected="selected">14px</option>
              <option value="16px">16px</option>
              <option value="18px">18px</option>
              <option value="20px">20px</option>
              <option value="24px">24px</option>
            </select>
        </li>

        <li class="btn-xs">
            <label for="tema_grafico">Apariencia</label>
            <select id="tema_grafico" size="1" class="form-control btn-xs btn-primary" onchange="CambiarTemaEditor(this.value)">
              <optgroup label="Brillantes / Bright">
                  <?php
                    //Presenta los temas claros disponibles
                    for ($i=0;$i<count($PCODER_TemasBrillantes);$i++)
                        echo '<option value="ace/theme/'.$PCODER_TemasBrillantes[$i]["Valor"].'">'.$PCODER_TemasBrillantes[$i]["Nombre"].'</option>';
                  ?>
              </optgroup>
              <optgroup label="Oscuros / Dark">
                  <?php
                    //Presenta los temas claros disponibles
                    for ($i=0;$i<count($PCODER_TemasOscuros);$i++)
                        echo '<option value="ace/theme/'.$PCODER_TemasOscuros[$i]["Valor"].'">'.$PCODER_TemasOscuros[$i]["Nombre"].'</option>';
                  ?>
              </optgroup>
            </select>
        </li>

        <li class="btn-xs">
            <label for="modo_archivo">Lenguaje</label>
            <select id="modo_archivo" size="1" class="form-control btn-xs btn-info" onchange="CambiarModoEditor(this.value)">
                  <?php
                    //Presenta los temas claros disponibles
                    for ($i=0;$i<count($PCODER_Modos);$i++)
                        {
                            //Determina si el lenguaje o modo de archivo actual es la opcion a desplegar
                            $modo_seleccion='';
                            if($PCODER_Modos[$i]["Nombre"]==$PCODER_ModoEditor)
                                $modo_seleccion='SELECTED';
                            //PResenta la opcion
                            echo '<option value="ace/mode/'.$PCODER_Modos[$i]["Nombre"].'" '.$modo_seleccion.' >'.$PCODER_Modos[$i]["Nombre"].'</option>';
                        }
                  ?>
            </select>
        </li>

        <li class="btn-xs">
            <label for="modo_invisibles">Ver caracteres invisibles</label>
            <select id="modo_invisibles" size="1" class="form-control btn-xs" onchange="CaracteresInvisiblesEditor(this.value)">
                <option value="0"><?php echo $MULTILANG_PCODER_No; ?></option>
                <option value="1"><?php echo $MULTILANG_PCODER_Si; ?></option>
            </select>
        </li>

      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>











	<!-- 
	#######################################################################################
	FIN DISPOSICION PARA EDITOR ###########################################################
	#######################################################################################  -->

<!-- FIN  DE CONTENIDOS DE APLICACION -->
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /#page-wrapper -->
</div>
<!-- /#wrapper inicial -->

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="../../inc/bootstrap/js/bootstrap.min.js"></script>

    <script language="JavaScript">
        //Carga los tooltips programados en la hoja.  Por defecto todos los elementos con data-toggle=tootip
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
        })
    </script>

    <script language="JavaScript">
        //Carga los popovers programados en la hoja.  Por defecto todos los elementos con data-toggle=popover
        $(function () {
          $('[data-toggle="popover"]').popover()
        })
    </script>

    <script src="../../inc/ace/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>


    <script type="text/javascript">
        var alto_inicial_editor=0;
        function MaximizarEditor()
            {
                var offset = (navigator.userAgent.indexOf("Mac") != -1 ||
                navigator.userAgent.indexOf("Gecko") != -1 ||
                navigator.appName.indexOf("Netscape") != -1) ? 0 : 4;
                window.moveTo(-offset, -offset);
                window.resizeTo(screen.availWidth + (2 * offset), screen.availHeight + (2 * offset));
                /*
                Forma 2:
                window.moveTo(0,0);
                window.outerHeight = screen.availHeight;
                window.outerWidth = screen.availWidth;
                
                Forma 3:
                $(window).hieght();
                $(window).width();
                
                Forma 4:
                $(window).resize(function()
                {   
                    setDisplayBoardSize();
                });
                */
                //Recarga el documento se queda en ciclo... ciudado
                location.reload();
            }
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
        function ActualizarTituloEditor(titulo)
            {
                //Cambia el titulo presentado en la ventada del editor
                document.title = titulo;
                $(document).attr('title',titulo);
            }
        function SaltarALinea()
            {
                var linea = document.getElementById("linea_salto").value;
                //Salta a una linea especifica del editor
                editor.gotoLine(linea, 1, true);
                document.getElementById("linea_salto").value="";
            }
        function Deshacer()
            {
                editor.undo();
            }
        function Rehacer()
            {
                editor.redo();
            }
        function AvisoAlmacenamiento()
            {
                $('#VentanaAlmacenamiento').modal('show'); 
            }
        function Guardar()
            {
                //Metodo estandar, envia todo sobre el iframe para evitar recargar la pagina
                document.form_archivo_editado.submit();
                //Metodo con AJAX, Evita el metodo estandar enviando todo sin recargar pagina aunque inseguro en el transporte.  No usar como primera opcion
                /*
                var ValorTextArea = $('#PCODER_AreaTexto').val();
                $.ajax({                                        
                    type: "POST", 
                    url: "index.php",            
                    data: "PCODER_TokenEdicion=<?php echo $PCODER_TokenEdicion; ?>&PCODER_archivo=<?php echo $PCODER_archivo; ?>&Presentar_FullScreen=<?php echo $Presentar_FullScreen; ?>&Precarga_EstilosBS=<?php echo $Precarga_EstilosBS; ?>&PCO_Accion=PCOMOD_GuardarArchivo&PCODER_AreaTexto=" + ValorTextArea,
                    cache: false,
                    dataType: "html",            
                    success: function(data) {
                        $('#VentanaAlmacenamiento').modal('show'); 
                    }
                });*/
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
		 function PCO_ObtenerContenidoAjax(PCO_ASINCRONICO,PCO_URL,PCO_PARAMETROS)
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
        function PCODER_CargarArchivo(archivo)
            {
                //Oculta el modal de seleccion del archivo
                $('button#boton_navegador_archivos').click();
                //Carga la nueva ventana con el archivo, Reemplaza metodo anterior
                PCO_VentanaPopup('index.php?PCO_Accion=PCOMOD_CargarPcoder&Presentar_FullScreen=1&Precarga_EstilosBS=1&PCODER_archivo='+archivo,'Pcoder'+archivo,'toolbar=no, location=no, directories=0, directories=no, status=no, location=no, menubar=no ,scrollbars=no, resizable=yes, fullscreen=no, titlebar=no, width=800, height=600');
            }

        // Crea el editor
        editor = ace.edit("editor_codigo");
        editor.getSession().setUseWorker(false); //Evita el error 404 para "worker-php.js Failed to load resource: the server responded with a status of 404 (Not Found)"
        
        //Actualiza el editor con el valor cargado inicialmente en el textarea
        editor.setValue(document.getElementById("PCODER_AreaTexto").value);

        // Inicia el editor de codigo con las opciones predeterminadas
        ActualizarTituloEditor("<?php echo $PCODER_NombreArchivo.' {PCodEr}'; ?>");
        CambiarFuenteEditor("14px");
        CambiarTemaEditor("ace/theme/tomorrow_night");  //tomorrow_night|twilight|eclipse|ambiance|ETC
        CambiarModoEditor("ace/mode/<?php echo $PCODER_ModoEditor; ?>");
        CaracteresInvisiblesEditor(0);
        editor.clearSelection();
        
        //En cada evento de cambio actualiza el textarea
        editor.getSession().on('change', function(){
          document.getElementById("PCODER_AreaTexto").value=editor.getSession().getValue();
        });

        //Ajusta tamano del editor en cada cambio de tamano de la ventana
        $( window ).resize(function() {
          //RedimensionarEditor();
        });

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
                
    </script>

    <?php
        // Estadisticas de uso anonimo con GABeacon
        $PrefijoGA='<img src="https://ga-beacon.appspot.com/';
        $PosfijoGA='/Practico/'.$PCO_Accion.'?pixel" border=0 ALT=""/>';
        // Este valor indica un ID generico de GA UA-847800-9 No edite esta linea sobre el codigo
        // Para validar que su ID es diferente al generico de seguimiento.  En lugar de esto cambie
        // su valor a traves del panel de configuracion de Practico con el entregado como ID de GoogleAnalytics
        $Infijo=base64_decode("VUEtODQ3ODAwLTk=");
        echo $PrefijoGA.$Infijo.$PosfijoGA;
        if(@$CodigoGoogleAnalytics!="")
            echo $PrefijoGA.$CodigoGoogleAnalytics.$PosfijoGA;	
    ?>

<!-- Marco para recepcion de eventos generados por el boton de guardar -->
<iframe OnLoad="if (frame_almacenamiento.location.href != 'about:blank') AvisoAlmacenamiento();" height="0" width="0" name="frame_almacenamiento" id="frame_almacenamiento" src="about:blank" style="visibility:hidden; display:none"></iframe>


</body>
</html>
<?php
	} // Fin $PCO_Accion=="PCOMOD_CargarPcoder"

} //Fin permisos modulo

