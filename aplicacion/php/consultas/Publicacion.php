<?php
class Publicacion
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_tipo_estado'])) {
			$where[] = "t_p.id_tipo_estado = ".quote($filtro['id_tipo_estado']);
		}
		if (isset($filtro['id_seccion_padre'])) {
			$where[] = "t_p.id_seccion_padre = ".quote($filtro['id_seccion_padre']);
		}		 
		if (isset($filtro['titulo'])) {
			$where[] = "t_p.titulo ILIKE ".quote("%{$filtro['titulo']}%");
		}
		if (isset($filtro['fecha_publicacion'])) {
			$where[] = "t_p.fecha_publicacion = ".quote($filtro['fecha_publicacion']);
		}
		if (isset($filtro['id_categoria'])) {
			$where[] = "t_p.id_categoria = ".quote($filtro['id_categoria']);
		}
		if (isset($filtro['usuario'])) {
			$where[] = "t_p.usuario ILIKE ".quote("%{$filtro['usuario']}%");
		}
		
		$sql = "SELECT
			t_p.id,
			t_pt.denominacion as tipo_estado,
			t_p.titulo,
			t_p.descripcion,
			t_p.cuerpo,
			t_p.fecha_publicacion,
			t_c.denominacion as categoria,
			t_padre.denominacion || '->' || t_c.denominacion as categoria_completa,
			t_p.fecha_operacion,
			t_p.usuario,
			t_p.tag
		FROM publicaciones as t_p
		INNER JOIN	param_tipos as t_pt on t_p.id_tipo_estado = t_pt.id
		INNER JOIN	categorias as t_c ON t_p.id_categoria = t_c.id
		INNER JOIN	categorias as t_padre ON t_padre.id = t_c.id_padre
		ORDER BY t_p.fecha_publicacion DESC";
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