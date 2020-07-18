<?php
class Tipos extends Tipos_dato{
    public function get_categorias(){
	    $filtro=array('id_clasificacion'=>2);
	    return self::get_listado($filtro);
    }
    public function get_estados_grales(){
        $filtro=array('id_clasificacion'=>1);
        return self::get_listado($filtro);
    }
    
    public function get_estados_publicaciones(){
        $filtro=array('id_clasificacion'=>3);
        return self::get_listado($filtro);
    }
}
?>