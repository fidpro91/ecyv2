<?php

class M_ms_supplier extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",supplier_id as id_key  from ms_supplier where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",supplier_id as id_key  from ms_supplier where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"supplier_id",
				"supplier_code",
				"supplier_name",
				"supplier_address",
				"supplier_phone",
				"supplier_contact",
				"supplier_active",
				"jenis_supplier"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"supplier_code" => "trim|required",
					"supplier_name" => "trim",
					"supplier_address" => "trim",
					"supplier_phone" => "trim",
					"supplier_contact" => "trim",
					"supplier_active" => "trim",
					"jenis_supplier" => "trim",

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

	public function get_ms_supplier($where)
	{
		return $this->db->get_where("ms_supplier",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_supplier",$where)->row();
	}
}