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

    // PREFERENCIAS
	
	abrir_dialogo_modal("myModalOPERARFS",$MULTILANG_PCODER_OperacionesFS); ?>

			<div class="row">
				<div class="col-md-12">
					<label for="path_operacion_elemento"><?php echo $MULTILANG_PCODER_Ubicacion; ?>:</label><br>
					<div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-hdd-o fa-fw"></i></span>
					  <input type="text" name="path_operacion_elemento" id="path_operacion_elemento" class="form-control btn-block input-mini btn-xs" readonly>
					</div>
					<br>					
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
						<label for="marco_explorador_creacionarchivo"><?php echo $MULTILANG_PCODER_Explorar; ?>:</label>					
						<div id="marco_explorador_creacionarchivo" class="explorador_archivos_mini"></div>
				</div>
				<div class="col-md-6">
						<label for="operacion_fs"><?php echo $MULTILANG_PCODER_Operacion; ?>:</label>
						<select id="operacion_fs" size="1" class="form-control btn-primary">
							<option value="CrearArchivo"><?php echo $MULTILANG_PCODER_CrearArchivo; ?></option>
							<option value="CrearCarpeta"><?php echo $MULTILANG_PCODER_CrearCarpeta; ?></option>
							<option value="EditarPermisos"><?php echo $MULTILANG_PCODER_EditarPermisos; ?></option>
							<option value="SubirArchivo"><?php echo $MULTILANG_PCODER_SubirArchivo; ?></option>
							<option value="EliminarElemento"><?php echo $MULTILANG_PCODER_EliminarElemento; ?></option>
						</select>

						<label for="path_creacion"><?php echo $MULTILANG_PCODER_Nombre; ?>:</label>
					    <input type="text" name="nombre_elemento" id="nombre_elemento" class="form-control btn-block input-mini btn-xs">

				</div>
			</div>


    <?php 
        $barra_herramientas_modal='
        <button OnClick="EjecutarOperacionFS();" type="button" class="btn btn-success"><i class="fa fa-check fa-fw"></i> '.$MULTILANG_PCODER_Aceptar.'</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> '.$MULTILANG_PCODER_Cancelar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
