<?php

class M_master_gaji_karyawan extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from master_gaji_karyawan mgk
					join employee e on mgk.emp_id = e.emp_id
				 where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from master_gaji_karyawan mgk
					join employee e on mgk.emp_id = e.emp_id
					 where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"id",
				"emp_name"=>["label"=>"Pegawai"],
				"gaji_pokok"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"status"=>[
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
										"emp_id" => "trim|integer",
					"gaji_pokok" => "trim|numeric",
					"status" => "trim",

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

	public function get_master_gaji_karyawan($where)
	{
		return $this->db->get_where("master_gaji_karyawan",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("master_gaji_karyawan",$where)->row();
	}

	public function get_employee($where,$select,$limit)
	{
		return	$this->db->where($where)
						 ->select($select)
						 ->limit($limit)
						 ->join("ms_gaji_pokok gp","gp.jabatan_id=e.position_id","left")
						 ->join("ms_jabatan mj","mj.id_jabatan=e.position_id","left")
						 ->get("employee e")->result();
	}
}