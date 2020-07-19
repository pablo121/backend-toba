<?php
class Categoria implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_tipo_categoria'])) {
			$where[] = "id_tipo_categoria = ".quote($filtro['id_tipo_categoria']);
		}
		if (isset($filtro['id_tipo_estado'])) {
			$where[] = "id_tipo_estado = ".quote($filtro['id_tipo_estado']);
		}
		if (isset($filtro['id_padre'])) {
			$where[] = "id_padre = ".quote($filtro['id_padre']);
		}
		if (isset($filtro['codigo'])) {
			$where[] = "codigo ILIKE ".quote("%{$filtro['codigo']}%");
		}
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['suscripciones'])) {
			$where[] = "suscripciones = ".quote($filtro['suscripciones']);
		}
		$sql = "SELECT
			t_c.id,
			t_pt.denominacion as categoria,
			t_pt1.denominacion as estado,
			t_c.codigo,
			t_c.denominacion,
			t_c.descripcion,
			t_c.suscripciones,
			t_c.orden,
			t_c.principal,
			t_c.imagen_portada,
			t_padre.id as id_padre,
			case when id_padre is null then 'PRINCIPAL'
				else t_padre.denominacion
			end as seccion_padre
		FROM categorias as t_c
		INNER JOIN param_tipos as t_pt ON (t_c.id_tipo_categoria = t_pt.id)
		INNER JOIN param_tipos as t_pt1 On (t_c.id_tipo_estado = t_pt1.id)
		LEFT JOIN categorias t_padre ON (t_padre.id=t_c.id_padre)
		ORDER BY t_c.orden, t_c.denominacion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
	{
		$sql = "SELECT id,  codigo || ' - ' ||  denominacion as denominacion FROM categorias ORDER BY descripcion";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>