<?php

class M_tunjangan_tetap_karyawan extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from tunjangan_tetap_karyawan where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from tunjangan_tetap_karyawan where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"id",
				"emp_id",
				"tunjangan_id",
				"nominal_tunjangan",
				"status"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"emp_id" => "trim|integer",
					"tunjangan_id" => "trim|integer",
					"nominal_tunjangan" => "trim|numeric",
					"status" => "trim",

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

	public function get_tunjangan_tetap_karyawan($where)
	{
		return $this->db->get_where("tunjangan_tetap_karyawan",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("tunjangan_tetap_karyawan",$where)->row();
	}
}