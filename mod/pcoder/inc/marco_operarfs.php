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
				<div id="cuadro_entrada_path_operacion_elemento">
					<div class="col-md-12">
						<label for="path_operacion_elemento"><?php echo $MULTILANG_PCODER_Ubicacion; ?>:</label><br>
						<div class="input-group">
						  <span class="input-group-addon"><i class="fa fa-hdd-o fa-fw"></i></span>
						  <input type="text" name="path_operacion_elemento" id="path_operacion_elemento" class="form-control btn-block input-mini btn-xs" readonly>
						</div>
						<br>					
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
						<div id="cuadro_entrada_marco_explorador">
							<label for="marco_explorador_creacionarchivo"><?php echo $MULTILANG_PCODER_Explorar; ?>:</label>					
							<div id="marco_explorador_creacionarchivo" class="explorador_archivos_mini"></div>
						</div>
				</div>
				<div class="col-md-6">
					
						<div id="cuadro_entrada_operacion_fs">
							<label for="operacion_fs"><?php echo $MULTILANG_PCODER_Operacion; ?>:</label>
							<select id="operacion_fs" size="1" class="form-control btn-primary">
								<option value="CrearArchivo"><?php echo $MULTILANG_PCODER_CrearArchivo; ?></option>
								<option value="CrearCarpeta"><?php echo $MULTILANG_PCODER_CrearCarpeta; ?></option>
								<option value="EditarPermisos"><?php echo $MULTILANG_PCODER_EditarPermisos; ?></option>
								<option value="SubirArchivo"><?php echo $MULTILANG_PCODER_SubirArchivo; ?></option>
								<option value="EliminarElemento"><?php echo $MULTILANG_PCODER_EliminarElemento; ?></option>
							</select>
						</div>

						<div id="cuadro_entrada_nombre_elemento">
							<label for="nombre_elemento"><?php echo $MULTILANG_PCODER_Nombre; ?>:</label>
							<input type="text" name="nombre_elemento" id="nombre_elemento" class="form-control btn-block input-mini btn-xs">
						</div>

						<div id="cuadro_entrada_permisos_elemento">
							<label for="permisos_elemento"><?php echo $MULTILANG_PCODER_Permisos; ?> (octal):</label>
							<input type="text" name="permisos_elemento" id="permisos_elemento" class="form-control btn-block input-mini btn-xs">
							<label for="propietario_elemento"><?php echo $MULTILANG_PCODER_Propietario; ?>:</label>
							<input type="text" name="propietario_elemento" id="propietario_elemento" class="form-control btn-block input-mini btn-xs">
						</div>

				</div>
			</div>

<script language="JavaScript">
function EjecutarOperacionFS()
	{
		//Toma los valores de parametros de la ventana de operaciones FS, valida y hace el llamado a la operacion
		var path_operacion_elemento=document.getElementById("path_operacion_elemento").value;
		var operacion_fs=document.getElementById("operacion_fs").value;
		var nombre_elemento=document.getElementById("nombre_elemento").value;
		
		//CREAR ARCHIVO
			if (operacion_fs=="CrearArchivo")
				{
					ResultadoOperacion=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCODER_CrearArchivo&PCODER_ElementoFS="+path_operacion_elemento+"/"+nombre_elemento);
					if (ResultadoOperacion==1)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Finalizado, MULTILANG_PCODER_ElementoCreado);
							//Recarga la lista de archivos en el explorador para reflejar el nuevo elemento
							ExplorarPath();
							//Oculta el marco de operaciones FS
							$('#myModalOPERARFS').modal('hide');
						}
					if (ResultadoOperacion==-1)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Error, MULTILANG_PCODER_ElementoExiste);
						}
					if (ResultadoOperacion==-2)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Error, MULTILANG_PCODER_ElementoNoCreado);
						}
				}

		//CREAR CARPETA
			if (operacion_fs=="CrearCarpeta")
				{
					ResultadoOperacion=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCODER_CrearCarpeta&PCODER_ElementoFS="+path_operacion_elemento+"/"+nombre_elemento);
					if (ResultadoOperacion==1)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Finalizado, MULTILANG_PCODER_ElementoCreado);
							//Recarga la lista de archivos en el explorador para reflejar el nuevo elemento
							ExplorarPath();
							//Oculta el marco de operaciones FS
							$('#myModalOPERARFS').modal('hide');
						}
					if (ResultadoOperacion==-1)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Error, MULTILANG_PCODER_ElementoExiste);
						}
					if (ResultadoOperacion==-2)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Error, MULTILANG_PCODER_ElementoNoCreado);
						}
				}

		//EDITAR PERMISOS
			if (operacion_fs=="EditarPermisos")
				{
					ResultadoOperacion=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCODER_EditarPermisos&PCODER_ElementoFS="+path_operacion_elemento);
					if (ResultadoOperacion==1)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Finalizado, MULTILANG_PCODER_ElementoCreado);
							//Recarga la lista de archivos en el explorador para reflejar el nuevo elemento
							ExplorarPath();
							//Oculta el marco de operaciones FS
							$('#myModalOPERARFS').modal('hide');
						}
					if (ResultadoOperacion==-1)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Error, MULTILANG_PCODER_ElementoExiste);
						}
					if (ResultadoOperacion==-2)
						{
							PCOJS_MostrarMensaje(MULTILANG_PCODER_Error, MULTILANG_PCODER_ElementoNoCreado);
						}
				}
	}

function OperacionFS_CrearArchivo()
	{
		//Presenta el cuadro de dialogo
		$('#myModalOPERARFS').css('z-index', '500');	//Asigna un index inferior a los dialogos emergentes de resultado
		$('#myModalOPERARFS').modal('show');
		
		//Asigna valores por defecto a algunos campos y controles
		document.getElementById('nombre_elemento').value='';
		document.getElementById('operacion_fs').value='CrearArchivo';
		document.getElementById('permisos_elemento').value=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPermisosArchivo&PCODER_archivo="+document.getElementById('nombre_elemento').value);
		document.getElementById('propietario_elemento').value=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPropietarioArchivo&PCODER_archivo="+document.getElementById('nombre_elemento').value);

		//Oculta o muestra elementos necesarios segun la operacion
		$('#operacion_fs').attr("disabled", true);
		$("#cuadro_entrada_path_operacion_elemento").show();
		$("#cuadro_entrada_marco_explorador").show();
		$("#cuadro_entrada_operacion_fs").show();
		$("#cuadro_entrada_nombre_elemento").show();
		$("#cuadro_entrada_permisos_elemento").hide();
	}

function OperacionFS_CrearCarpeta()
	{
		//Presenta el cuadro de dialogo
		$('#myModalOPERARFS').css('z-index', '500');	//Asigna un index inferior a los dialogos emergentes de resultado
		$('#myModalOPERARFS').modal('show');
		
		//Asigna valores por defecto a algunos campos y controles
		document.getElementById('nombre_elemento').value='';
		document.getElementById('operacion_fs').value='CrearCarpeta';
		document.getElementById('permisos_elemento').value=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPermisosArchivo&PCODER_archivo="+document.getElementById('nombre_elemento').value);
		document.getElementById('propietario_elemento').value=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPropietarioArchivo&PCODER_archivo="+document.getElementById('nombre_elemento').value);

		//Oculta o muestra elementos necesarios segun la operacion
		$('#operacion_fs').attr("disabled", true);
		$("#cuadro_entrada_path_operacion_elemento").show();
		$("#cuadro_entrada_marco_explorador").show();
		$("#cuadro_entrada_operacion_fs").show();
		$("#cuadro_entrada_nombre_elemento").show();
		$("#cuadro_entrada_permisos_elemento").hide();
	}

function OperacionFS_EditarPermisos()
	{
		//Presenta el cuadro de dialogo
		$('#myModalOPERARFS').css('z-index', '500');	//Asigna un index inferior a los dialogos emergentes de resultado
		$('#myModalOPERARFS').modal('show');
		
		//Asigna valores por defecto a algunos campos y controles
		document.getElementById('nombre_elemento').value=UltimaCarpetaSeleccionada+UltimoArchivoSeleccionado;
		document.getElementById('operacion_fs').value='EditarPermisos';
		document.getElementById('permisos_elemento').value=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPermisosArchivo&PCODER_archivo="+document.getElementById('nombre_elemento').value);
		document.getElementById('propietario_elemento').value=PCO_ObtenerContenidoAjax(0,"index.php","PCO_Accion=PCOMOD_ObtenerPropietarioArchivo&PCODER_archivo="+document.getElementById('nombre_elemento').value);

		//Oculta o muestra elementos necesarios segun la operacion
		$('#operacion_fs').attr("disabled", true);
		$("#cuadro_entrada_path_operacion_elemento").show();
		$("#cuadro_entrada_marco_explorador").hide();
		$("#cuadro_entrada_operacion_fs").show();
		$("#cuadro_entrada_nombre_elemento").hide();
		$("#cuadro_entrada_permisos_elemento").show();
	}

</script>

    <?php 
        $barra_herramientas_modal='
        <button OnClick="EjecutarOperacionFS();" type="button" class="btn btn-success"><i class="fa fa-check fa-fw"></i> '.$MULTILANG_PCODER_Aceptar.'</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> '.$MULTILANG_PCODER_Cancelar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>';
        cerrar_dialogo_modal($barra_herramientas_modal);
