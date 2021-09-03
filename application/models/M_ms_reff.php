<?php

class M_ms_reff extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns)." from ms_reff where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns)." from ms_reff where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"reff_id",
				"reff_code",
				"reff_name",
				"reff_active",
				"refcat_id"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"reff_code" => "trim",
					"reff_name" => "trim|required",
					"reff_active" => "trim|required",
					"refcat_id" => "trim|integer|required",

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
}