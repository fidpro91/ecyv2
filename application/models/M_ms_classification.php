<?php

class M_ms_classification extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",classification_id as id_key  from ms_classification where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",classification_id as id_key  from ms_classification where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"classification_id",
				"classification_code",
				"classification_name",
				"classification_active",
				"modul_id",
				"classification_level",
				"classification_parent",
				"classification_islast",
				"profit_margin"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"classification_code" => "trim",
					"classification_name" => "trim|required",
					"classification_active" => "trim|required",
					"modul_id" => "trim|integer",
					"classification_level" => "trim|integer",
					"classification_parent" => "trim|integer",
					"classification_islast" => "trim",
					"profit_margin" => "trim|integer",

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

	public function get_ms_classification($where)
	{
		return $this->db->get_where("ms_classification",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_classification",$where)->row();
	}
}