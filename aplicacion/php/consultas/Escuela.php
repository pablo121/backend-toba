<?php
class Escuela implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['cue'])) {
			$where[] = "cue ILIKE ".quote("%{$filtro['cue']}%");
		}
		if (isset($filtro['id_localidad'])) {
			$where[] = "id_localidad = ".quote($filtro['id_localidad']);
		}
		$sql = "SELECT
			t_e.id,
			t_e.denominacion,
			t_e.cue,
			t_e.lat,
			t_e.lng,
			t_e.nro_institucion,
			t_e.barrio,
			t_e.direccion,
			t_e.telefono,
			t_e.email,
			t_pl.denominacion as id_localidad_nombre
		FROM
			escuelas as t_e,
			param_localidades as t_pl
		WHERE
				t_e.id_localidad = t_pl.id
		ORDER BY denominacion";
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