<?php

class M_group_access extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from group_access where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from group_access where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"group_id",
				"menu_id",
				"access_view",
				"access_write",
				"id"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"group_id" => "trim|integer",
					"menu_id" => "trim|integer",
					"access_view" => "trim",
					"access_write" => "trim",

				];
		return $data;
	}

	public function validation()
	{
		foreach ($this->rules() as $key => $value) {
			$this->form_validation->set_rules($key,$key,$value);
		}

		return $this->form_validation->run();
	}

	public function get_menu($id,$group_id)
	{
		$getMenu = $this->get_menu_access($id,$group_id);
		$data = [];
		foreach ($getMenu as $i => $value) {
			$data[$i]["id"] = "menu_".$value->menu_id;
			$data[$i]['attr'] 		= $value;
            $data[$i]["attr"]->id 	= "menu_".$data[$i]["attr"]->menu_id;
            if ($value->menu_accesed) {
            	$data[$i]["attr"]->class 	= "jstree-checked";
            }
			// $data[$i]['id'] 		= $value->menu_id;
			$data[$i]['data'] 		= $value->menu_name;
			$data[$i]['metadata'] 	= $value;
			$data[$i]['state'] 		= 'closed';
			if( !$this->get_menu_access( $value->menu_id )  ){
				$data[$i]['state'] 		= 'disabled';
			}
			$i++;
		}
		return ($data);
	}

	public function get_menu_access($id,$group_id = 0)
	{
		return $this->db->where('menu_parent_id',$id)
						->join("group_access ga","ga.menu_id = m.menu_id and ga.group_id = $group_id","left")
						->select("distinct m.*,ga.menu_id as menu_accesed",false)
						->order_by('menu_code')
						->get("ms_menu m")
						->result();
	}
}