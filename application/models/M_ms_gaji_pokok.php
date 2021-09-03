<?php

class M_ms_gaji_pokok extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_gp as id_key  from ms_gaji_pokok gp
				join ms_jabatan mj on gp.jabatan_id = mj.id_jabatan where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_gp as id_key from ms_gaji_pokok gp
				join ms_jabatan mj on gp.jabatan_id = mj.id_jabatan where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"id_gp",
				"kode_gp",
				"nama_jabatan",
				"karyawan_type",
				"nominal"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"gp_type",
				"gp_status"=>[
						"label"=>"Status",
						"custom"=> function($a) {
							if ($a == 't') {
            					$condition = ["class"=>"label-primary","text"=>"Aktif"];
	            			}else{
	            				$condition = ["class"=>"label-danger","text"=>"Non Aktif"];
	            			}
	            			return label_status($condition);
						}
					]];
		return $col;
	}

	public function rules()
	{
		$data = [
					"kode_gp" => "trim|required",
					"jabatan_id" => "trim|integer|required",
					"karyawan_type" => "trim|required",
					"nominal" => "trim|numeric|required",
					"gp_type" => "trim|required",
					"gp_status" => "trim|required",

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

	public function get_ms_gaji_pokok($where)
	{
		return $this->db->get_where("ms_gaji_pokok",$where)->result();
	}
}