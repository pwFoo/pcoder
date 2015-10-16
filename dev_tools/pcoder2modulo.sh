#!/bin/bash

#   PCODER (Editor de Codigo en la Nube)
#   Copyright (C) 2015  John F. Arroyave Gutiérrez
#                       unix4you2@gmail.com
#                       www.practico.org

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>

# Mensajes de inicio e introduccion al script
#	clear
	echo "               _                                    "
	echo "              (_  _ _  _  _  _     _ _|_ _  _| _  _ "
	echo "              (_ | | ||_)(_|(_||_|(/_ | (_|(_|(_)|  "
	echo "                      |       |                     "
	echo "-----------------------------------------------------------------"
	echo "Esta utilidad genera un nuevo paquete de distribucion de PCoder  "
	echo "Cualquier archivo existente con el mismo nombre sera sobreescrito"
	echo "-----------------------------------------------------------------"

	FECHA=$(date)  # Obtengo la fecha y hora actual

# Obtengo la ruta de ejecucion del script
	SCRIPT=$(readlink -f "$0")
	SCRIPTPATH=`dirname "$SCRIPT"`
	# Me ubico en la ruta del script y subo dos niveles
	cd $SCRIPTPATH
	cd ..

#Incluye la compresion de archivos CSS y JS
	source dev_tools/cssjs2min.sh

#Incluye el archivo que ajusta todos los permisos previa generacion del zip
	source dev_tools/chmod2zip.sh

# PARAMETROS BASICOS DEL EMPAQUETADO
	#Lista de archivos y carpetas a empaquetar (relativos a la raiz y separados por espacio)
	ListaArchivos=" INSTALL README.md mod "
	#Nombre del archivo resultante
	NombreArchivo="PCoder-ModuloPractico";
	Version=`head -n 1 mod/pcoder/inc/version_actual.txt`
	Extension=".zip"

# Pregunta por continuar o abortar
	echo ""
	echo "Version detectada     : " $Version
	echo "Nombre del empaquetado: " $NombreArchivo$Version$Extension
	echo "Fecha de empaquetado  : " $FECHA
	echo ""
	echo "Presione [Enter] para continuar o [Ctrl+C] para abortar"
#	read -p "" vble
	echo "-----------------------------------------------------------------"

# Variables de trabajo adicionales
	oldIFS=$IFS  # conserva el separador de campo
	IFS=$'\n'  # nuevo separador de campo, el caracter fin de línea
	Espacio=" " # Usado en concatenaciones
	Slash="/" # Usado en concatenaciones
	Guion="-" # Usado en concatenaciones

#[ArchivosExcluidos] Separados por espacio. Residen en alguna carpeta a comprimir pero deben evitarse
ListaExcluidos=" pcoder.sqlite3 TODO "

# Banderas para la compresion
	Comando="zip "
	NivelCompresion=" -9 " # -9 (mejor)
	VerDetalles="  " # -v  (v)erbose
	Recursividad=" -r "
	Exclusion=" -x "
	ProbarIntegridad=" -T "

#Procesa si el formato es ZIP (identificado por el comando)
	if [ $Comando == "zip " ]; then
		rm ${SCRIPTPATH}${Slash}${NombreArchivo}${Guion}${Version}${Extension}
		ComandoFinal=${Comando}${NivelCompresion}${VerDetalles}${Recursividad}${Exclusion}${ListaExcluidos}${ProbarIntegridad}${Espacio}${SCRIPTPATH}${Slash}${NombreArchivo}${Guion}${Version}${Extension}${Espacio}${ListaArchivos}
		eval ${ComandoFinal}
	fi

# Presenta resultados, restablece variables y termina
	IFS=$old_IFS  # restablece el separador de campo predeterminado
	echo "-----------------------------------------------------------------"
	echo "Presione [Enter] para finalizar. "
#	read -p "" vble
	exit 0  # Finalizo ejecucion normal del script
