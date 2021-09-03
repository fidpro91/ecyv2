<?php

class M_profil_company extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",profil_id as id_key  from profil_company where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",profil_id as id_key  from profil_company where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"profil_id",
				"nama_profil",
				"email_profil",
				"fax_profil",
				"phone_profil",
				"alamat_profil",
				"logo_profil"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"nama_profil" => "trim|required",
					"email_profil" => "trim",
					"fax_profil" => "trim",
					"phone_profil" => "trim|required",
					"alamat_profil" => "trim|required",
					"logo_profil" => "trim",

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

	public function get_profil_company($where)
	{
		return $this->db->get_where("profil_company",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("profil_company",$where)->row();
	}
}