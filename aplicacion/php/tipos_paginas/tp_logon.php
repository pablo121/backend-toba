<?php

/**
 * Tipo de p�gina pensado para pantallas de login, presenta un logo y un pie de p�gina b�sico
 * 
 * @package SalidaGrafica
 */
class tp_logon extends toba_tp_logon {

/*    function barra_superior() {
        echo "<div id='barra-superior' class='barra-superior-login'>\n";
    }
*/
    /*function pre_contenido() {
        echo "<div class='login-titulo'>" . toba_recurso::imagen_proyecto("logo.png", true);
        echo "<div>version " . toba::proyecto()->get_version() . "</div>";
        echo "</div>";
        echo "\n<div align='center' class='cuerpo'>\n";
    }*/

    function footer() {
        echo '<div class="col-md-4 col-md-offset-4">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.0.0
				</div>
					Desarrollado por <strong> <a href="#" class="footer_skin"> Ministerio de Educaci&oacuten - La Rioja</a>.</strong> 2020
			</div>';

    }
 
}