<?php
class Localidad implements portal_tablas
{
	function get_listado($filtro=array())
	{
		$where = array();
		if (isset($filtro['id_pcia'])) {
			$where[] = "id_pcia = ".quote($filtro['id_pcia']);
		}
		if (isset($filtro['denominacion'])) {
			$where[] = "denominacion ILIKE ".quote("%{$filtro['denominacion']}%");
		}
		if (isset($filtro['id_dpto'])) {
			$where[] = "id_dpto = ".quote($filtro['id_dpto']);
		}
		$sql = "SELECT
			t_l.id,
			t_l.denominacion,
			t_d.denominacion as dpto,
			t_p.denominacion as pcia,
			t_pa.denominacion as pais
		FROM param_localidades as t_l	
		INNER JOIN param_departamentos as t_d ON t_l.id_dpto=t_d.id
		INNER JOIN param_provincias as t_p ON (t_d.id_pcia = t_p.id)
		INNER JOIN param_paises as t_pa ON (t_p.id_pais = t_pa.id)
		ORDER BY t_pa.denominacion,t_p.denominacion,t_d.denominacion,t_l.denominacion";

		if (count($where)>0) {
			$sql = sql_concatenar_where($sql, $where);
		}
		return toba::db('portal')->consultar($sql);
	}

    function get_descripciones($id = null)
	{
		$sql = "SELECT id, denominacion FROM param_localidades ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}
	function get_localidades($id)
	{
		 $where= ' WHERE id_dpto ='.quote($id);
		$sql = "SELECT id, denominacion FROM param_localidades $where ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>