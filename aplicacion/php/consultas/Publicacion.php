<?php
class Publicacion implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_tipo_estado'])) {
			$where[] = "id_tipo_estado = ".quote($filtro['id_tipo_estado']);
		}
		if (isset($filtro['titulo'])) {
			$where[] = "titulo ILIKE ".quote("%{$filtro['titulo']}%");
		}
		if (isset($filtro['fecha_publicacion'])) {
			$where[] = "fecha_publicacion = ".quote($filtro['fecha_publicacion']);
		}
		if (isset($filtro['id_categoria'])) {
			$where[] = "id_categoria = ".quote($filtro['id_categoria']);
		}
		if (isset($filtro['usuario'])) {
			$where[] = "usuario ILIKE ".quote("%{$filtro['usuario']}%");
		}
		$sql = "SELECT
			t_p.id,
			t_pt.denominacion as tipo_estado,
			t_p.titulo,
			t_p.descripcion,
			t_p.cuerpo,
			t_p.fecha_publicacion,
			t_c.descripcion as categoria,
			t_p.fecha_operacion,
			t_p.usuario,
			t_p.tag
		FROM
			publicaciones as t_p,
			param_tipos as t_pt,
			categorias as t_c
		WHERE
				t_p.id_tipo_estado = t_pt.id
			AND  t_p.id_categoria = t_c.id
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