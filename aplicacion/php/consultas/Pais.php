<?php
class Pais implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		$sql = "SELECT
			t_pp.id,
			t_pp.denominacion
		FROM
			param_paises as t_pp
		ORDER BY denominacion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}
 
	function get_descripciones($id = null)
	{
		$sql = "SELECT id, denominacion FROM param_paises ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>