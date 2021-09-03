<?php

class M_ms_potongan extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",potongan_id as id_key  from ms_potongan where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",potongan_id as id_key  from ms_potongan where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"potongan_id",
				"nama_potongan",
				"percentase",
				"nominal"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"status_potongan"=>[
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
					"nama_potongan" => "trim|required",
					"percentase" => "trim|numeric",
					"nominal" => "trim|numeric",
					"status_potongan" => "trim",

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

	public function get_ms_potongan($where)
	{
		return $this->db->get_where("ms_potongan",$where)->result();
	}
}