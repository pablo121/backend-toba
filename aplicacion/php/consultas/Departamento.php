<?php
class Departamento implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['id_pcia'])) {
			$where[] = "id_pcia = ".quote($filtro['id_pcia']);
		}
		$sql = "SELECT
			t_pd.id,
			t_pd.denominacion,
			t_pp.denominacion as pcia
		FROM
			param_departamentos as t_pd,
			param_provincias as t_pp
		WHERE
				t_pd.id_pcia = t_pp.id
		ORDER BY denominacion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
	{
		$sql = "SELECT id, denominacion FROM param_departamentos ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

	function get_departamentos($id)
	{
        $where= ' WHERE id_pcia ='.quote($id);
		$sql = "SELECT id, denominacion FROM param_departamentos $where ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}
	function get_departamentos_lr()
	{
        $where= ' WHERE id_pcia =1';
		$sql = "SELECT id, denominacion FROM param_departamentos $where ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>