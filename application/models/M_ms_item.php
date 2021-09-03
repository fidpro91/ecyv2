<?php

class M_ms_item extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",item_id as id_key  from ms_item where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",item_id as id_key  from ms_item where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"item_id",
				"item_code",
				"item_name",
				"item_desc",
				"item_active",
				"comodity_id",
				"classification_id",
				"item_unitofitem",
				"item_package",
				"is_formularium",
				"is_generic",
				"jns",
				"item_name_generic",
				"qty_packtounit",
				"hna",
				"atc_ood"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"item_code" => "trim|required",
					"item_name" => "trim|required",
					"item_desc" => "trim",
					"item_active" => "trim|required",
					"comodity_id" => "trim|integer",
					"classification_id" => "trim|integer",
					"item_unitofitem" => "trim",
					"item_package" => "trim",
					"is_formularium" => "trim",
					"is_generic" => "trim",
					"jns" => "trim",
					"item_name_generic" => "trim",
					"qty_packtounit" => "trim",
					"hna" => "trim",
					"atc_ood" => "trim",

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

	public function get_ms_item($where)
	{
		return $this->db->get_where("ms_item",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_item",$where)->row();
	}

	public function get_autocomplete($term)
	{
		$this->db->where("lower(item_name) like lower('%".$term."%')",null);

		return $this->db->select("*,item_name as label")->limit(25)->get("ms_item")->result();
	}
}