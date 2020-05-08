<?php
class Pagina implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_categoria'])) {
			$where[] = "id_categoria = ".quote($filtro['id_categoria']);
		}
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['descripcion'])) {
			$where[] = "descripcion ILIKE ".quote("%{$filtro['descripcion']}%");
		}
		$sql = "SELECT
			t_p.id,
			t_c.descripcion as id_categoria_nombre,
			t_p.denominacion,
			t_p.descripcion
		FROM
			paginas as t_p,
			categorias as t_c
		WHERE
				t_p.id_categoria = t_c.id
		ORDER BY descripcion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
    {
        // TODO: Implement get_descripciones() method.
    }

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}

?>