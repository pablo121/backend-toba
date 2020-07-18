<?php
class Suscripcion
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_categoria'])) {
			$where[] = "id_categoria = ".quote($filtro['id_categoria']);
		}
		if (isset($filtro['id_persona'])) {
			$where[] = "id_persona = ".quote($filtro['id_persona']);
		}
		if (isset($filtro['activo'])) {
			$where[] = "activo = ".quote($filtro['activo']);
		}
		$sql = "SELECT
			t_s.id,
			t_c.descripcion as id_categoria_nombre,
			t_p.nombre as id_persona_nombre,
			t_s.activo,
			t_s.fecha_baja,
			t_s.fecha_operacion
		FROM
			suscripciones as t_s,
			categorias as t_c,
			personas as t_p
		WHERE
				t_s.id_categoria = t_c.id
			AND  t_s.id_persona = t_p.id";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}


    function get_descripciones($id = null)    {
        // TODO: Implement get_descripciones() method.
    }

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>