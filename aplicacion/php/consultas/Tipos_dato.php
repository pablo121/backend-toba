<?php
class Tipos_dato
{
    public function get_listado($filtro = array())
	{
        $where = array();
        if (isset($filtro['id_clasificacion'])) {
            $where[] = "id_clasificacion = ".quote($filtro['id_clasificacion']);
        }
		$sql = "SELECT
                    t_pt.id,
                    t_pt.denominacion,
                    t_pc.id || ' - ' || t_pc.denominacion as clasificacion
                    
                FROM
                    param_tipos as t_pt,
                    param_clasificacion as t_pc
                WHERE t_pt.id_clasificacion = t_pc.id
                ORDER BY denominacion";

        if (count($where)>0) {
            $sql = sql_concatenar_where($sql, $where);
        }
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripciones($id = null)
	{
	    $where = '';
	    if ($id != null)
	        $where= ' WHERE id_clasificacion='.quote($id);
		$sql = "SELECT id, denominacion FROM param_tipos $where ORDER BY denominacion";
		return toba::db('portal')->consultar($sql);
	}

    public function get_descripcion($id)
    {
        // TODO: Implement get_descripcion() method.
    }
}
?>