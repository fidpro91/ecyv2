<?php

class M_pinjaman_pegawai extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",pinjaman_id as id_key,e.emp_no,e.emp_name from pinjaman_pegawai p
				join employee e on p.emp_id = e.emp_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",pinjaman_id as id_key from pinjaman_pegawai p
				join employee e on p.emp_id = e.emp_id
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"pinjaman_no",
				"pinjaman_date",
				"emp_no",
				"emp_name",
				"nominal_pinjaman"=>[
					"custom"=> function($a) {
						return convert_currency($a);
					}
				],
				"tenor_pinjaman",
				"bunga_pinjaman",
				"cicilan_perbulan"=>[
					"custom"=> function($a) {
						return convert_currency($a);
					}
				],
				"jml_kali_cicilan",
				"status_lunas",
				"pinjaman_note",
				// "user_id",
				// "created_at"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"emp_id" => "trim|integer|required",
					"pinjaman_no" => "trim",
					"pinjaman_date" => "trim|required",
					"nominal_pinjaman" => "trim|numeric|required",
					"tenor_pinjaman" => "trim|integer|required",
					"cicilan_perbulan" => "trim|numeric|required",
					"jml_kali_cicilan" => "trim|integer",
					"status_lunas" => "trim",
					"pinjaman_note" => "trim",
					"user_id" => "trim|integer",
					"bunga_pinjaman" => "trim|numeric",
					"created_at" => "trim",
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

	public function get_pinjaman_pegawai($where)
	{
		return $this->db->get_where("pinjaman_pegawai",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("pinjaman_pegawai",$where)->row();
	}
}