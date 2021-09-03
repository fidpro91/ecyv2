<?php

class M_sp_employee extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",sp_id as id_key from sp_employee se 
				join employee e on se.employee_id = e.emp_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",sp_id as id_key from sp_employee se 
				join employee e on se.employee_id = e.emp_id 
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"sp_date",
				"sp_no",
				"emp_no"=>["label"=>"kode pegawai"],
				"emp_name"=>["label"=>"nama pegawai"],
				"type_offense"=>[
							"label"=>"jenis pelanggaran",
							"custom"=>function($a){
								if ($a == 1) {
									$txt = "RINGAN";
								}elseif ($a == 2) {
									$txt = "SEDANG";
								}else{
									$txt = "BERAT";
								}
								return $txt;
							},
						],
				"sp_type"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"employee_id" => "trim|integer|required",
					"sp_no" => "trim|required",
					"sp_date" => "trim|required",
					"sp_note" => "trim|required",
					"type_offense" => "trim|integer|required",
					"sp_type" => "trim|required",
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

	public function get_sp_employee($where)
	{
		return $this->db->get_where("sp_employee",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("sp_employee",$where)->row();
	}
}