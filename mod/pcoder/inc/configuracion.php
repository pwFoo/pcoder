<?php
/*
=====================================================================
   PBROWSER (Practico Browser)
   Sistema Simple de Navegacion por Proxy basado en PHP
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

	/*	Define si PCoder se ejecuta en modo StandAlone (Independiente)
		para cualquier proyecto o servidor o como un modulo de Practico
		Posibles Valores:  1=StandAlone   0=Modulo de Practico       */
	$PCO_PCODER_StandAlone=1;
	
	
	
	
	/*	Define el Path inicial sobre el cual el usuario puede navegar
		por el sistema de archivos del servidor para editarlos
		Posibles valores:	../../../   -> Raiz Instalacion PCoder cuando es independiente o Raiz de Practico si esta como modulo
							.			-> Directorio Actual de PCoder (generalmente sobre mod/pcoder)
							../../		-> Raiz de PCoder (Donde reside LICENSE, AUTHORS, Etc)

	*/
	$PCO_PCODER_RaizExploracionArchivos="../../";

                //echo @php_file_tree($_SERVER['DOCUMENT_ROOT'], "http://example.com/?file=[link]/");
                //echo @php_file_tree(".", "javascript:alert('You clicked on [link]');");
                //echo @php_file_tree(".", "javascript:alert('You clicked on [link]');",$PCODER_ExtensionesPermitidas);
                //$PCODER_ExtensionesPermitidas = array("txt", "php", "inc", "css", "txt");
                // ../../../=RaizInstalacionPCoder  /=RaizServidor


	$ZonaHoraria='America/Bogota';
	$IdiomaPredeterminado='es';
	$CodigoGoogleAnalytics='UA-847800-9';

