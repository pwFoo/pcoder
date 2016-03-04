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

    //Permite WebServices propios mediante el acceso a este script en solicitudes Cross-Domain
    header('Access-Control-Allow-Origin: *');
    header('access-control-allow-credentials: true');
	header('Content-type: text/html; charset=utf-8');

    //Incluye archivo inicial de configuracion
	include_once("../../inc/configuracion.php");

    //Incluye idioma espanol, o sobreescribe vbles por configuracion de usuario
    include("../../idiomas/es.php");
    include("../../idiomas/".$IdiomaPredeterminado.".php");
    // FIN BLOQUE BASICO DE INCLUSION ##################################

    // Establece la zona horaria por defecto para la aplicacion
    date_default_timezone_set($ZonaHoraria);

    // Datos de fecha, hora y direccion IP para algunas operaciones
    $PCO_EXPLORER_FechaOperacion=date("Ymd");
    $PCO_EXPLORER_FechaOperacionGuiones=date("Y-m-d");
    $PCO_EXPLORER_HoraOperacion=date("His");
    $PCO_EXPLORER_HoraOperacionPuntos=date("H:i");
    $PCO_EXPLORER_DireccionAuditoria=$_SERVER ['REMOTE_ADDR'];

/* ################################################################## */
/* ################################################################## */


function ExplorarDirectorio($DirectorioExploracion)
	{
		if (is_dir($DirectorioExploracion)) 
			{
				if ($dh = opendir($DirectorioExploracion)) 
					{
						while (($file = readdir($dh)) !== false) 
							{
								if ($file != "." && $file != "..") 
									{
										//Determina la extension del archivo
										$Extension = preg_replace('/^.*\./', '', $file);
										
										//Imprime el archivo o directorio
										//print "<br>'{$DirectorioExploracion}/{$file}',\\n"; 
										echo '<li class="file ext_'.$Extension.'"><a>'.$file.'</a></li>';
										//Llamado recursivo a la funcion para revisar subcarpetas
										ExplorarDirectorio($DirectorioExploracion .  "/" . $file);
									}
							}
						closedir($dh);
					}
			}
	}

$DirectorioExploracion=$_REQUEST["DirectorioExploracion"];
if ($DirectorioExploracion=="")	$DirectorioExploracion=".";

//Hace el llamado inicial de exploracion
ExplorarDirectorio($DirectorioExploracion);

