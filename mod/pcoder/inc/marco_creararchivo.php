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
	
	abrir_dialogo_modal("myModalCREARARCHIVO",$MULTILANG_PCODER_OperacionesFS); ?>

			<div class="row">
				<div class="col-lg-6">

						<label for="path_creacion"><?php echo $MULTILANG_PCODER_Ubicacion; ?></label>					
						<input type="text" name="path_operacion_elemento" id="path_operacion_elemento" class="form-control btn-block input-mini btn-xs" readonly>
						<div id="marco_explorador_creacionarchivo" class="explorador_archivos_mini"></div>
					
				</div>
				<div class="col-lg-6">
						<label for="operacion_fs"><?php echo $MULTILANG_PCODER_Operacion; ?></label>
						<select id="operacion_fs" size="1" class="form-control btn-primary">
							<option value="0"><?php echo $MULTILANG_PCODER_CrearArchivo; ?></option>
							<option value="0"><?php echo $MULTILANG_PCODER_CrearCarpeta; ?></option>
							<option value="0"><?php echo $MULTILANG_PCODER_EditarPermisos; ?></option>
							<option value="0"><?php echo $MULTILANG_PCODER_SubirArchivo; ?></option>
							<option value="0"><?php echo $MULTILANG_PCODER_EliminarElemento; ?></option>
						</select>
				</div>
			</div>

			<hr>
			<div class="row">
				<div class="col-lg-6">
						<label for="modo_archivo"><?php echo $MULTILANG_PCODER_LenguajeProg; ?></label>
						<select id="modo_archivo" size="1" class="form-control btn-info" onchange="CambiarModoEditor(this.value)">
							  <?php
								//Presenta los lenguajes disponibles
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
				</div>
				<div class="col-lg-6">
						<label for="modo_invisibles"><?php echo $MULTILANG_PCODER_VerCaracteres; ?></label>
						<select id="modo_invisibles" size="1" class="form-control btn-default" onchange="CaracteresInvisiblesEditor(this.value)">
							<option value="0"><?php echo $MULTILANG_PCODER_No; ?></option>
							<option value="1"><?php echo $MULTILANG_PCODER_Si; ?></option>
						</select>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-6">
						<label for="verificacion_sintaxis"><?php echo $MULTILANG_PCODER_RevisarSintaxis; ?></label>
						<select id="verificacion_sintaxis" size="1" class="form-control btn-success" onchange="VerificarSintaxisEditor(this.value)">
							<option value="0"><?php echo $MULTILANG_PCODER_No; ?></option>
							<option value="1"><?php echo $MULTILANG_PCODER_Si; ?></option>
						</select>
				</div>
				<div class="col-lg-6">
					<!--
						<label for="verificacion_autocompletado"><?php echo $MULTILANG_PCODER_RevisarSintaxis; ?></label>
						<select id="verificacion_autocompletado" size="1" class="form-control btn-success" onchange="VerificarAutocompletadoEditor(this.value)">
							<option value="0"><?php echo $MULTILANG_PCODER_No; ?></option>
							<option value="1"><?php echo $MULTILANG_PCODER_Si; ?></option>
						</select>
					-->
				</div>
			</div>
    <?php 
        $barra_herramientas_modal='
        <button type="button" class="btn btn-default" data-dismiss="modal">'.$MULTILANG_PCODER_Cerrar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
