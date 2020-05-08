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
			t_c.codigo || ' - ' || t_pt.denominacion as denominacion,
			t_pt1.denominacion as estado,
			t_c.codigo,
			t_c.denominacion,
			t_c.descripcion,
			t_c.suscripciones
		FROM
			categorias as t_c,
			param_tipos as t_pt,
			param_tipos as t_pt1
		WHERE t_c.id_tipo_categoria = t_pt.id AND  t_c.id_tipo_estado = t_pt1.id
		ORDER BY descripcion";
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