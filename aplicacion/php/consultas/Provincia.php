<?php
class Provincia implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['id_pais'])) {
			$where[] = "id_pais = ".quote($filtro['id_pais']);
		}
		$sql = "SELECT
			t_pp.id,
			t_pp.denominacion,
			t_pp1.denominacion as pais
		FROM
			param_provincias as t_pp,
			param_paises as t_pp1
		WHERE
				t_pp.id_pais = t_pp1.id
		ORDER BY denominacion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

	function get_descripciones($id = null)
	{
        $where = '';
        if ($id != null)
            $where= ' WHERE id_pais ='.quote($id);
		$sql = "SELECT id, denominacion FROM param_provincias $where ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}
    function get_provincias($id)
    {
        $where = '';
        if ($id != null)
            $where= ' WHERE id_pais ='.quote($id);
        $sql = "SELECT id, denominacion FROM param_provincias $where ORDER BY denominacion";
        return toba::db('portal')->consultar($sql);
    }

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>