<?php
class ci_suscripciones extends portal_ci
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
            $datos = Suscripcion::get_listado($this->s__datos_filtro);
            $cuadro->set_datos($datos);
        } else {
            $datos = Suscripcion::get_listado();
            $cuadro->set_datos($datos);
        }
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

}

?>