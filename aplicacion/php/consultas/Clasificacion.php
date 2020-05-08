<?php
class Clasificacion implements portal_tablas
{
	 function get_listado($filtro=array())
	{
		$sql = "SELECT
			t_pc.id,
			t_pc.denominacion
		FROM
			param_clasificacion as t_pc
		ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
	{
		$sql = "SELECT id, denominacion FROM param_clasificacion ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>