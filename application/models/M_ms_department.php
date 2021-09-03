<?php

class M_ms_department extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",department_id as id_key  from ms_department where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",department_id as id_key  from ms_department where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"department_id",
				"department_code"=>['label'=>'kode departemen'],
				"department_name"=>['label'=>'Nama departemen'],
				"department_active"=>[
						"label"=>"Status",
						"custom"=> function($a) {
							if ($a == 't') {
            					$condition = ["class"=>"label-primary","text"=>"Aktif"];
	            			}else{
	            				$condition = ["class"=>"label-danger","text"=>"Non Aktif"];
	            			}
	            			return label_status($condition);
						}
					],
				"department_div"=>['label'=>'Divisi'],
				"department_sect"=>['label'=>'Sektor'],
				"department_subsect"=>['label'=>'Sub Sektor'],
				"kelompok",
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"department_code" => "trim|required",
					"department_name" => "trim|required",
					"department_active" => "trim|required",
					"department_div" => "trim",
					"department_sect" => "trim",
					"department_subsect" => "trim",
					"kelompok" => "trim",
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

	public function get_ms_department($where)
	{
		return $this->db->select("*,concat(department_code,'/',department_name,'/',coalesce(department_div,''),'/',coalesce(department_sect,''),'/',coalesce(department_subsect,''))as nama_deparment")->get_where("ms_department",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ms_department",$where)->row();
	}
}