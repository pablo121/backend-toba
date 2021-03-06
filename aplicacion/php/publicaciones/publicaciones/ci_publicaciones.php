<?php
class ci_publicaciones extends portal_ci
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
            $datos = Publicacion::get_listado($this->s__datos_filtro);
            $cuadro->set_datos($datos);
        } else {
            $datos = Publicacion::get_listado();
            $cuadro->set_datos($datos);
        }
	}

	function evt__cuadro__seleccion($datos)
	{
		$this->dep('datos')->cargar($datos);
		$this->set_pantalla('pant_edicion');
	}

	//---- Formulario -------------------------------------------------------------------

	function conf__formulario(toba_ei_formulario $form)
	{
		if ($this->dep('datos')->esta_cargada()) {
			$datos = $this->dep('datos')->tabla('publicaciones')->get();
			
			if($datos['path'] != null ){
				$datos['path_aux'] = $datos['path'];
				$datos['path'] = 'Imagen portada';
			}
			
			$form->set_datos($datos);
		} else {
			$this->pantalla()->eliminar_evento('eliminar');
		}
	}

	function evt__formulario__modificacion($datos)
	{
		//ei_arbol($datos);
		if($datos['usuario']=='')
			$datos['usuario']=toba::usuario()->get_id();

		if($datos['path'] != 'Imagen portada'){
			if (is_array($datos['path']))
				$datos['path'] = base64_encode(file_get_contents($datos['path']['tmp_name']));
			else
				$datos['path'] = $datos['path_aux'];
		}

		$this->dep('datos')->tabla('publicaciones')->set($datos);
	}

	function resetear()
	{
		$this->dep('datos')->resetear();
		$this->set_pantalla('pant_seleccion');
	}

	//---- EVENTOS CI -------------------------------------------------------------------

	function evt__agregar()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__volver()
	{
		$this->resetear();
	}

	function evt__eliminar()
	{
		$this->dep('datos')->eliminar_todo();
		$this->resetear();
	}

	function evt__guardar()
	{
		$this->dep('datos')->sincronizar();
		$this->resetear();
	}

}

?>