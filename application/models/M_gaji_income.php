<?php

class M_gaji_income extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",gaji_income_id as id_key  from gaji_income where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",gaji_income_id as id_key  from gaji_income where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"gaji_income_id",
				"gaji_id",
				"gaji_income_note",
				"gaji_income_nominal"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"gaji_id" => "trim|integer",
					"gaji_income_note" => "trim",
					"gaji_income_nominal" => "trim|numeric",

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

	public function get_gaji_income($where)
	{
		return $this->db->get_where("gaji_income",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("gaji_income",$where)->row();
	}
}