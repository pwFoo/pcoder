<?php
	/*
	   PCODER (Editor de Codigo en la Nube)
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

	//Habilita o deshabilita el modo de depuracion de la aplicacion
	$ModoDepuracion=1;
    if ($ModoDepuracion==1)
        {
            ini_set("display_errors", 1);
            error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_DEPRECATED | E_STRICT | E_USER_DEPRECATED | E_USER_ERROR | E_USER_WARNING); //Otras disponibles | E_PARSE | E_CORE_ERROR | E_CORE_WARNING |
        }

    //Incluye archivo inicial de configuracion
	include_once("inc/configuracion.php");

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

    //Incluye librerias basicas de trabajo
    @require('inc/variables.php');
    @require('inc/conexiones.php');
    @require('inc/comunes.php');
    @require('inc/comunes_bd.php');

    //Incluye idioma espanol, o sobreescribe vbles por configuracion de usuario
    include("idiomas/es.php");
    include("idiomas/".$IdiomaPredeterminado.".php");
    // FIN BLOQUE BASICO DE INCLUSION ##################################

	//Genera la conexion inicial del sistema para preferencias en standalone
	if ($PCO_PCODER_StandAlone==1)
		{
			$ConexionPDO=PCO_NuevaConexionBD($MotorBD,$PuertoBD,$BaseDatos,$ServidorBD,$UsuarioBD,$PasswordBD);
		}

    // Establece la zona horaria por defecto para la aplicacion
    date_default_timezone_set("America/Bogota");

    // Datos de fecha, hora y direccion IP para algunas operaciones
    $PCO_PCODER_FechaOperacion=date("Ymd");
    $PCO_PCODER_FechaOperacionGuiones=date("Y-m-d");
    $PCO_PCODER_HoraOperacion=date("His");
    $PCO_PCODER_HoraOperacionPuntos=date("H:i");
    $PCO_PCODER_DireccionAuditoria=$_SERVER ['REMOTE_ADDR'];

	// Establece version actual del sistema
	$PCO_PCODER_VersionActual = file("inc/version_actual.txt");
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
        $PCODER_archivo = "demos/demo.php";
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

	// Clase para exploracion de archivos
	include_once("lib/phpFileTree/php_file_tree.php");

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
?>
 <!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
	<title>{P}</title>
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
            background: #272727;  /* 002a36 | BFBFBF | 888888 | 272727 | 000000 */
            overflow-x: hidden;
            overflow-y: hidden;
        }

		/* Personalizacion del estilo bootstrap para el alto del menu */
			.navbar-nav > li > a, .navbar-brand {
				padding-top:0px !important; padding-bottom:0 !important;
				height: 30px;
			}
			.navbar {min-height:30px !important;}
		/*Adicion de clase para el alto de menu*/
			.navbar-xs { min-height:30px; height: 30px; }
			.navbar-xs .navbar-brand{ padding: 0px 12px;font-size: 16px;line-height: 30px; }
			.navbar-xs .navbar-nav > li > a {  padding-top: 0px; padding-bottom: 0px; line-height: 30px; }
    </style>

    <!-- Agrega archivos necesarios para el Explorador en arbol de directorios -->
    <link href="lib/phpFileTree/styles/default/default.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="lib/phpFileTree/php_file_tree.js" type="text/javascript"></script>
    
    <!-- jQuery -->
	<script type="text/javascript" src="../../inc/jquery/jquery-2.1.0.min.js"></script>
</head>
<body>

		<?php
			//Incluye algunos marcos del aplicativo
			include_once ("inc/barra_menu.php");
			include_once ("inc/mensajes_error.php");
			include_once ("inc/marco_preferencias.php");
			include_once ("inc/marco_acerca.php");
			include_once ("inc/marco_guardar.php");
			include_once ("inc/marco_teclado.php");
		?>



		<div class="row">
			<div class="col-md-2" style="margin:0px; padding:0px;" id="panel_izquierdo">
				<div algin="center">
				<?php
					include_once ("inc/panel_izquierdo.php");
				?>
				</div>
			</div>
			<div class="col-md-8" style="margin:0px;" id="panel_editor_codigo">
				<form name="form_archivo_editado" action="index.php" method="POST" target="frame_almacenamiento" style="visibility: hidden; display:inline; height: 0px; border-width: 0px; width: 0px; padding: 0; margin: 0;">
					<textarea id="PCODER_AreaTexto" name="PCODER_AreaTexto" style="visibility:hidden; display:none;"><?php echo $PCODERcontenido_archivo; ?></textarea>
					<input name="PCODER_TokenEdicion" type="hidden" value="<?php echo $PCODER_TokenEdicion; ?>">
					<input name="PCODER_archivo" type="hidden" value="<?php echo $PCODER_archivo; ?>">
					<input type="Hidden" name="Presentar_FullScreen" value="<?php echo $Presentar_FullScreen; ?>">
					<input type="Hidden" name="Precarga_EstilosBS" value="<?php echo $Precarga_EstilosBS; ?>">
					<input type="Hidden" name="PCO_ECHO" value="0"> <!-- Determina si la respuesta debe ser con o sin eco -->
					<input name="PCO_Accion" type="hidden" value="PCOMOD_GuardarArchivo">
				</form>
				<div id="editor_codigo" style="display:block; width:100%; height:100vh;" width="100%" height="100vh"></div>
			</div>
			<div class="col-md-2" style="margin:0px; padding:0px;" id="panel_derecho">
				<?php
					include_once ("inc/panel_derecho.php");
				?>
			</div>
		</div>

		<?php
			//Incluye algunos marcos del aplicativo
			include_once ("inc/barra_estado.php");
		?>


    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="../../inc/bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Carga editor ACE y sus extensiones -->
	<script src="../../inc/ace/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
	<script src="../../inc/ace/src-min-noconflict/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>

    <!-- Funciones propias de PCoder -->
    <script type="text/javascript" src="inc/pcoder_func.min.js"></script>

    <!-- Inicializaciones JS para PCoder -->
    <script type="text/javascript" src="inc/pcoder_init.min.js"></script>

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

    <?php
        // Estadisticas de uso anonimo con GABeacon
        $PrefijoGA='<img src="https://ga-beacon.appspot.com/';
        $PosfijoGA='/PCoder/'.$PCO_Accion.'?pixel" border=0 ALT=""/>';
        // Este valor indica un ID generico de GA UA-847800-9 No edite esta linea sobre el codigo
        // Para validar que su ID es diferente al generico de seguimiento.  En lugar de esto cambie
        // su valor a traves del panel de configuracion con el entregado como ID de GoogleAnalytics
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

