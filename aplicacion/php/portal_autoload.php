<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class portal_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'portal_ci' => 'extension_toba/componentes/portal_ci.php',
		'portal_cn' => 'extension_toba/componentes/portal_cn.php',
		'portal_datos_relacion' => 'extension_toba/componentes/portal_datos_relacion.php',
		'portal_datos_tabla' => 'extension_toba/componentes/portal_datos_tabla.php',
		'portal_ei_arbol' => 'extension_toba/componentes/portal_ei_arbol.php',
		'portal_ei_archivos' => 'extension_toba/componentes/portal_ei_archivos.php',
		'portal_ei_calendario' => 'extension_toba/componentes/portal_ei_calendario.php',
		'portal_ei_codigo' => 'extension_toba/componentes/portal_ei_codigo.php',
		'portal_ei_cuadro' => 'extension_toba/componentes/portal_ei_cuadro.php',
		'portal_ei_esquema' => 'extension_toba/componentes/portal_ei_esquema.php',
		'portal_ei_filtro' => 'extension_toba/componentes/portal_ei_filtro.php',
		'portal_ei_firma' => 'extension_toba/componentes/portal_ei_firma.php',
		'portal_ei_formulario' => 'extension_toba/componentes/portal_ei_formulario.php',
		'portal_ei_formulario_ml' => 'extension_toba/componentes/portal_ei_formulario_ml.php',
		'portal_ei_grafico' => 'extension_toba/componentes/portal_ei_grafico.php',
		'portal_ei_mapa' => 'extension_toba/componentes/portal_ei_mapa.php',
		'portal_servicio_web' => 'extension_toba/componentes/portal_servicio_web.php',
		'portal_comando' => 'extension_toba/portal_comando.php',
		'portal_modelo' => 'extension_toba/portal_modelo.php',
		'ci_login' => 'login/ci_login.php',
		'cuadro_autologin' => 'login/cuadro_autologin.php',
		'pant_login' => 'login/pant_login.php',
		'portal_autoload' => 'portal_autoload.php',
		'Clasificacion'=>'consultas/Clasificacion.php',
		'Categoria'=>'consultas/Categoria.php',
		'Departamento'=>'consultas/Departamento.php',
		'Escuela'=>'consultas/Escuela.php',
		'Localidad'=>'consultas/Localidad.php',
		'Pagina'=>'consultas/Pagina.php',
		'Pais'=>'consultas/Pais.php',
		'Persona'=>'consultas/Persona.php',
		'portal_tablas'=>'consultas/portal_tablas.php',
		'Provincia'=>'consultas/Provincia.php',
		'Publicacion'=>'consultas/Publicacion.php',
		'Suscripcion'=>'consultas/Suscripcion.php',
		'Tipos_dato'=>'consultas/Tipo_dato.php',
	);
}
?>