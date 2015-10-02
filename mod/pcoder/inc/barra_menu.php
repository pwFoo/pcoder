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

    // BARRA DE MENU DEL APLICATIVO
    // PARA REVISAR JQUERY-UI http://jqueryui.com/tabs/#manipulation
?>

<div id="contenedor_menu">

	<nav class="navbar navbar-default navbar-inverse" style="margin:0px; padding:0px;"> <!-- navbar-fixed-top navbar-fixed-bottom navbar-static-top navbar-inverse -->
		<div class="container-fluid">
			<!-- Logo y boton colapsable -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#barra_menu_superior" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand text-danger" href="#"><b><font color="#FFFFFF">{P}Coder</font></b></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="barra_menu_superior">
				<ul class="nav navbar-nav">

					<!-- MENU ARCHIVO -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $MULTILANG_PCODER_Archivo; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a id="boton_navegador_archivos" data-toggle="modal"  href="#NavegadorArchivos">    <i class="fa fa-folder-open fa-fw"></i> <?php echo $MULTILANG_PCODER_Abrir; ?></a></li>
							<li><a id="boton_guardar"            OnClick="Guardar();" href="#VentanaAlmacenamiento"><i class="fa fa-floppy-o fa-fw"></i> <?php echo $MULTILANG_PCODER_Guardar; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#"><i class="fa fa-times fa-fw"></i> <?php echo $MULTILANG_PCODER_Salir; ?></a></li>
						</ul>
					</li>

					<!-- MENU EDITAR -->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $MULTILANG_PCODER_Editar; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#" OnClick="Deshacer();"><i class="fa fa-undo fa-fw"></i> <?php echo $MULTILANG_PCODER_Deshacer; ?></a></li>
							<li><a href="#" OnClick="Rehacer(); "><i class="fa fa-repeat fa-fw"></i> <?php echo $MULTILANG_PCODER_Rehacer; ?></a></li>
						</ul>
					</li>
					<!--<li><a href="#">EJEMPLO ENLACE</a></li>-->

				</ul>

				<!-- FORMULARIO IR A -->
				<div class="navbar-form navbar-left">
					<input type="text" id="linea_salto" size=9 name="linea_salto" class="input-mini btn-xs btn-default" placeholder="<?php echo $MULTILANG_PCODER_SaltarLinea; ?>">
					<button class="btn btn-default btn-xs" onClick="SaltarALinea();"><?php echo $MULTILANG_PCODER_Ir; ?> <i class="fa fa-arrow-circle-right"></i></button>
				</div>

				<!-- INFORMACION DEL ARCHIVO -->
				<ul class="nav navbar-nav navbar-form navbar-right">
					<li class="btn-default btn-xs btn-info">
						&nbsp;<?php echo $MULTILANG_PCODER_Tipo; ?> <span class="badge"><?php echo $PCODER_TipoElemento; ?></span>&nbsp;<br>
						&nbsp;<?php echo $PCODER_FechaElemento; ?> <span class="badge"><?php echo $PCODER_TamanoElemento; ?> Kb</span>&nbsp;<br>
					</li>
				</ul>
					
				<ul class="nav navbar-nav navbar-right">
					<a data-toggle="modal" href="#myModalPREFERENCIAS" class="navbar-text"><i class="fa fa-wrench fa-fw"></i> <?php echo $MULTILANG_PCODER_Preferencias; ?></a>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-question-circle"></i> <?php echo $MULTILANG_PCODER_Ayuda; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a data-toggle="modal" href="#AtajosTeclado"><i class="fa fa-keyboard-o fa-fw"></i> <?php echo $MULTILANG_PCODER_AtajosTitPcoder; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a data-toggle="modal" href="#myModalACERCADEPCODER"><i class="fa fa-info-circle fa-fw"></i> <?php echo $MULTILANG_PCODER_Acerca; ?></a></li>
						</ul>
					</li>
				</ul>

			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

</div><!-- /.contenedor -->
