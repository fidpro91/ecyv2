<?php

class M_ms_hari_libur extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",libur_id as id_key  from ms_hari_libur where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",libur_id as id_key  from ms_hari_libur where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"libur_id",
				"nama_libur",
				"tanggal",
				"jenis_libur"=>[
						"label"=>"Status",
						"custom"=> function($a) {
							if ($a == '1') {
            					$condition = ["class"=>"label-primary","text"=>"Hari Libur"];
	            			}else{
	            				$condition = ["class"=>"label-success","text"=>"Cuti Bersama"];
	            			}
	            			return label_status($condition);
						}
					],
				"keterangan"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"nama_libur" => "trim|required",
					"tanggal" => "trim|required",
					"jenis_libur" => "trim|integer|required",
					"keterangan" => "trim",

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

	public function get_ms_hari_libur($where)
	{
		return $this->db->get_where("ms_hari_libur",$where)->result();
	}
}