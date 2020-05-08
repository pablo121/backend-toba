<?php
class ci_personas extends portal_ci
{
	protected $s__datos_filtro;


	//---- Filtro -----------------------------------------------------------------------

	function conf__filtro(toba_ei_formulario $filtro)
	{
		if (isset($this->s__datos_filtro)) {
			$filtro->set_datos($this->s__datos_filtro);
		}
	}

	function evt__filtro__filtrar($datos)
	{
		if (array_no_nulo($datos)) {
			$this->s__datos_filtro = $datos;
		} else { 
			toba::notificacion()->agregar('El filtro no posee valores');
		}
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//---- Cuadro -----------------------------------------------------------------------

	function conf__cuadro(toba_ei_cuadro $cuadro)
	{
        if (isset($this->s__datos_filtro)) {
            $datos = Persona::get_listado($this->s__datos_filtro);
            $cuadro->set_datos($datos);
        } else {
            $datos = Persona::get_listado();
            $cuadro->set_datos($datos);
        }
	}
}

?>