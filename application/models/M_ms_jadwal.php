<?php

class M_ms_jadwal extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",jadwal_id as id_key  from ms_jadwal where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",jadwal_id as id_key  from ms_jadwal where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"jadwal_id",
				"keterangan_jadwal",
				"jam_masuk",
				"jam_pulang",
				"shift"=>[
					"custom"=>	function($a){
						foreach (get_dataShift() as $key => $value) {
							if ($value['id'] == $a) {
								return $value['text'];
								break;
							}
						}
					}
				],
				"jadwal_active"=>[
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
					"keterangan_jadwal" => "trim|required",
					"jam_masuk" => "trim|required",
					"jam_pulang" => "trim|required",
					"shift" => "trim|required",
					"jadwal_active" => "trim|required",

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

	public function get_ms_jadwal($where)
	{
		return $this->db->get_where("ms_jadwal",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_jadwal",$where)->row();
	}
}