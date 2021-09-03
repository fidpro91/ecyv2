<?php

class M_ms_cuti extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",cuti_id as id_key  from ms_cuti where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",cuti_id as id_key  from ms_cuti where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"cuti_id",
				"cuti_name"=>['label'=>'Jenis Cuti'],
				"cuty_qty"=>['label'=>'Jumlah'],
				"cuti_note"=>['label'=>'Keterangan'],
				"cuti_status"=>["label"=>"status",
								"custom"=>function($a){
									if($a=='t'){
										$condition =["class"=>"label-primary","text"=>"Aktif"];
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
										"cuti_name" => "trim|required",
					"cuty_qty" => "trim|integer|required",
					"cuti_note" => "trim",
					"cuti_status" => "trim|required",

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

	public function get_ms_cuti($where)
	{
		return $this->db->get_where("ms_cuti",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_cuti",$where)->row();
	}
}