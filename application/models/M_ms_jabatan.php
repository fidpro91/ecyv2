<?php

class M_ms_jabatan extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_jabatan as id_key from ms_jabatan where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id_jabatan as id_key from ms_jabatan where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"id_jabatan",
				"kode_jabatan",
				"nama_jabatan",
				"jabatan_aktif"=>[
						"label"=>"Status",
						"custom"=> function($a) {
							if ($a == 't') {
            					$condition = ["class"=>"label-primary","text"=>"Aktif"];
	            			}else{
	            				$condition = ["class"=>"label-danger","text"=>"Non Aktif"];
	            			}
	            			return label_status($condition);
						}
					]
				];
		return $col;
	}

	public function rules()
	{
		$data = [
					"kode_jabatan" => "trim|required",
					"nama_jabatan" => "trim|required",
					"jabatan_aktif" => "trim",

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

	public function get_jabatan($where)
	{
		return $this->db->get_where("ms_jabatan",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_jabatan",$where)->row();
	}
}