<?php

class M_potongan_gaji extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",gaji_potongan_id as id_key  from potongan_gaji where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",gaji_potongan_id as id_key  from potongan_gaji where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"gaji_potongan_id",
				"gaji_id",
				"gaji_potongan_note",
				"gaji_potongan_nominal"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"gaji_id" => "trim|integer",
					"gaji_potongan_note" => "trim",
					"gaji_potongan_nominal" => "trim|numeric",

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

	public function get_potongan_gaji($where)
	{
		return $this->db->get_where("potongan_gaji",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("potongan_gaji",$where)->row();
	}
}