<?php

class M_ms_tunjangan extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",tunjangan_id as id_key  from ms_tunjangan where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",tunjangan_id as id_key  from ms_tunjangan where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				///"tunjangan_id",
				"tunjangan"=>["label"=>"Tunjangan"],
				"nominal"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"jenis_tunjangan"=>["label"=>"Jenis Tunjangan"],
				"status_tunjangan"=>[
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
					"tunjangan" => "trim|required",
					"nominal" => "trim|required|numeric",
					"jenis_tunjangan" => "trim",
					"status_tunjangan" => "trim",

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

	public function get_ms_tunjangan($where)
	{
		return $this->db->get_where("ms_tunjangan",$where)->result();
	}
}