<?php

class M_dinas_luar extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_dinas as id_key from dinas_luar dl
				join employee e on dl.emp_id = e.emp_id where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_dinas as id_key  from dinas_luar dl
				join employee e on dl.emp_id = e.emp_id where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"tanggal_dinas",
				"no_dinas",
				"emp_no",
				"emp_name",
				"tanggal_mulai_dinas",
				"tanggal_selesai_dinas",
				"alat_transportasi",
				"tujuan_dinas",
				"anggaran_biaya"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"pemberi_tugas",
				"keterangan_tugas",
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"no_dinas" => "trim|required",
					"tanggal_dinas" => "trim|required",
					"tanggal_mulai_dinas" => "trim|required",
					"tanggal_selesai_dinas" => "trim|required",
					"alat_transportasi" => "trim|required",
					"tujuan_dinas" => "trim|required",
					"anggaran_biaya" => "trim|numeric|required",
					"emp_id" => "trim|integer|required",
					"pemberi_tugas" => "trim|required",
					"keterangan_tugas" => "trim|required",
					"user_created" => "trim|integer",

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

	public function get_dinas_luar($where)
	{
		return $this->db->get_where("dinas_luar",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("dinas_luar",$where)->row();
	}
}