<?php
class Persona implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['apellido'])) {
			$where[] = "apellido ILIKE ".quote("%{$filtro['apellido']}%");
		}
		if (isset($filtro['documento'])) {
			$where[] = "documento ILIKE ".quote("%{$filtro['documento']}%");
		}
		if (isset($filtro['id_localidad'])) {
			$where[] = "id_localidad = ".quote($filtro['id_localidad']);
		}
		$sql = "SELECT
			t_p.id,
			t_p.apellido,
			t_p.nombre,
			t_p.documento,
			t_p.email,
			t_p.telefono,
			t_p.empresa_cel,
			t_p.celular,
			t_pl.denominacion as id_localidad_nombre
		FROM
			personas as t_p	LEFT OUTER JOIN param_localidades as t_pl ON (t_p.id_localidad = t_pl.id)
		ORDER BY nombre";
		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
		{
			$sql = "SELECT id, nombre FROM personas ORDER BY nombre";
			return toba::db('portal')->consultar($sql);
		}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>