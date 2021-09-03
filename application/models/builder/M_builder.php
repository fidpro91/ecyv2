<?php

class M_builder extends CI_Model {

	function get_allTable()
	{
		$data = $this->db->list_tables();
		return $data;
	}

	public function get_fieldTable($name)
	{
		$data = $this->db->field_data($name);
		return $data;
	}

	public function create_menu($data)
	{
		if ($data['menu_name']) {
			$this->db->insert('ms_menu',$data);
		}
	}

	public function get_menu($parent_id='0')
	{
   		$menu = $this->db->where('menu_parent_id',$parent_id)->get('ms_menu')->result();
   		return $menu;
	}

	public function get_menu_child($parent)
	{
		$data = $this->db->where('menu_parent_id',$parent)->get('ms_menu')->result();
		$menu = [];
		foreach ($data as $key => $value) {
			$menu['text'] = $value->menu_name;
			$menu['id'] = $value->menu_id;
			$childs = $this->get_menu_child($value->menu_id);
			if ($childs) {
				$menu['childs'] = $childs;
			}
		}
		return $menu;
	}
}