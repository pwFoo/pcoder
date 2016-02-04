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

    // EXPLORADOR DE ARCHIVOS
	?>
		<div id="contenedor_explorador_archivos" style="margin-left:17px;">
			<select id="path_exploracion_archivos" size="1" class="form-control btn-primary btn-xs" onchange="ExplorarPath()">
				<option value="<?php echo $PCO_PCODER_RaizExploracionArchivos; ?>">     PATH: [<?php echo $PCO_PCODER_RaizExploracionArchivos; ?>] (<?php echo $MULTILANG_PCODER_Predeterminado; ?>)</option>
				<optgroup label="<?php echo $MULTILANG_PCODER_Comunes; ?>">
					<option value="/">[/] <?php echo $MULTILANG_PCODER_PathDisco; ?></option>
					<option value="<?php echo $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR; ?>">[<?php echo $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR; ?>] <?php echo $MULTILANG_PCODER_PathFull; ?></option>
				</optgroup>
			</select>

			<div id="marco_operaciones_archivos" class="row" style="margin-top:5px; margin-bottom:10px;">
				<div class="col-md-12" align="center">
					<button OnClick="OperacionFS_CrearArchivo();" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_CrearArchivo; ?>"><i class="fa fa-file fa-fw"></i></button>
					<button OnClick="OperacionFS_CrearCarpeta();" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_CrearCarpeta; ?>"><i class="fa fa-folder fa-fw"></i></button>
					<button OnClick="OperacionFS_EditarPermisos();" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_EditarPermisos; ?>"><i class="fa fa-lock fa-fw"></i></button>
					<button class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_SubirArchivo; ?>"><i class="fa fa-upload fa-fw"></i></button>
					<button class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_RecargarExplorador; ?>"><i class="fa fa-refresh fa-fw"></i></button>
					<button class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="<?php echo $MULTILANG_PCODER_EliminarElemento; ?>"><i class="fa fa-trash fa-fw"></i></button>
				</div>
			</div>
			
			<div id="marco_explorador" class="explorador_archivos"></div>
		</div>
		

		
