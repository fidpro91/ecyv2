<?php

class M_ms_region extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",reg_code as id_key  from ms_region where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",reg_code as id_key  from ms_region where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"reg_code",
				"reg_name",
				"reg_level",
				"reg_parent",
				"reg_active"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"reg_code" => "trim|required",
					"reg_name" => "trim|required",
					"reg_level" => "trim|integer|required",
					"reg_parent" => "trim",
					"reg_active" => "trim|required",

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

	public function get_ms_region($where)
	{
		return $this->db->get_where("ms_region",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_region",$where)->row();
	}
}