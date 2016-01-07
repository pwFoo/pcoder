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

    // VENTANA ALMACENAMIENTO
	
        abrir_dialogo_modal("VentanaAlmacenamiento",$MULTILANG_PCODER_Estado);
?>

        <div id="progreso_marco_guardar">
			<div class="progress">
				<div class="progress-bar progress-bar-striped active progress-bar-info" role="progressbar" aria-valuenow="100" style="width: 100%">
					<i class="fa fa-circle-o-notch fa-fw fa-spin"></i> <?php echo $MULTILANG_PCODER_Guardando; ?>
				</div>
			</div>
        </div>

        <div align="center" id="finalizado_marco_guardar">
			<i class="fa fa-save fa-fw fa-2x"></i> <?php echo $MULTILANG_PCODER_Guardar; ?> <?php echo $MULTILANG_PCODER_Finalizado; ?> !!!
        </div>

<?php        
        $barra_herramientas_modal='
        <div id="boton_marco_guardar">
			<button type="button" class="btn btn-default" data-dismiss="modal">'.$MULTILANG_PCODER_Cerrar.' {<i class="fa fa-keyboard-o"></i> Esc}</button>
		</div>';
        cerrar_dialogo_modal($barra_herramientas_modal);
