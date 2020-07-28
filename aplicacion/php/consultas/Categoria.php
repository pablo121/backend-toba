<?php
class Categoria implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_tipo_categoria'])) {
			$where[] = "t_c.id_tipo_categoria = ".quote($filtro['id_tipo_categoria']);
		}
		if (isset($filtro['id_tipo_estado'])) {
			$where[] = "t_c.id_tipo_estado = ".quote($filtro['id_tipo_estado']);
		}
		if (isset($filtro['id_padre'])) {
			$where[] = "t_c.id_padre = ".quote($filtro['id_padre']);
		}
		if (isset($filtro['codigo'])) {
			$where[] = "t_c.codigo ILIKE ".quote("%{$filtro['codigo']}%");
		}
		if (isset($filtro['denominacion'])) {
			$where[] = "t_c.denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['suscripciones'])) {
			$where[] = "t_c.suscripciones = ".quote($filtro['suscripciones']);
		}
		if (isset($filtro['portada']) && $filtro['portada']==1) {
			$where[] = "t_c.portada = true";
		}
		$sql = "SELECT
			t_c.id,
			t_padre.denominacion || '->' || t_pt.denominacion as categoria_completa,
			t_pt.denominacion as categoria,
			t_pt1.denominacion as estado,
			t_c.codigo,
			t_c.denominacion,
			t_c.descripcion,
			t_c.suscripciones,
			t_c.orden,
			t_c.portada,
			t_c.imagen_portada,
			t_ub.denominacion as ubicacion,
			t_padre.id as padre,
			case when t_c.id_padre is null then 'PRINCIPAL'
				else t_padre.denominacion
			end as seccion_padre
		FROM categorias as t_c
		INNER JOIN param_tipos as t_pt ON (t_c.id_tipo_categoria = t_pt.id)
		INNER JOIN param_tipos as t_pt1 On (t_c.id_tipo_estado = t_pt1.id)
		INNER JOIN param_tipos as t_ub On (t_c.id_ubicacion = t_ub.id)
		LEFT JOIN categorias t_padre ON (t_padre.id=t_c.id_padre)
		ORDER BY t_pt.denominacion asc, t_c.orden, t_c.denominacion";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
	{
		$sql = "SELECT id, denominacion FROM categorias ORDER BY denominacion asc";
		return toba::db('portal')->consultar($sql);
	}  
	
	function get_secciones_hijas($id)
	{
		$where = ' WHERE id_padre = '.quote($id);
		$sql = "SELECT id, denominacion FROM categorias $where ORDER BY denominacion asc";
		return toba::db('portal')->consultar($sql);
	}
	function get_secciones_ppal($id = null)
	{
		$sql = "SELECT id, denominacion FROM categorias where id_tipo_categoria= 'PRI' ORDER BY denominacion asc";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>
