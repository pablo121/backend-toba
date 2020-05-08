<?php
interface portal_tablas{
	public function get_listado($filtro=array());
	public function get_descripciones($id = null);
	public function get_descripcion($id);
}
?>