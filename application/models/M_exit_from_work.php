<?php

class M_exit_from_work extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",ex_id as id_key  from exit_from_work wr
				join employee e on wr.emp_id = e.emp_id 
				 where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",ex_id as id_key  from exit_from_work wr
				join employee e on wr.emp_id = e.emp_id 
				 where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"ex_id",
				"emp_no"=>["label"=>"kode pegawai"],
				"emp_name"=>["label"=>"nama pegawai"],
				"date_ex"=>["label"=>"Tanggal Keluar"],
				"ex_type"=>[
							"label"=>"Cara Keluar",
							"custom"=>function($a){
								if ($a == 1) {
									$txt = "<label class='label label-warning'>Keluar</label>";
								}else{
									$txt = "<label class='label label-danger'>PHK</label>";
								}
								return $txt;
							},
						],
				"ex_note"=>["label"=>"Catatan"],
				//"user_created",
				//"created_at"
			];
		return $col;
	}

	public function rules()
	{
		$data = [
										"emp_id" => "trim|integer|required",
					"date_ex" => "trim|required",
					"ex_type" => "trim|integer",
					"ex_note" => "trim",
					"user_created" => "trim|integer",
					
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

	public function get_exit_from_work($where)
	{
		return $this->db->get_where("exit_from_work",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("exit_from_work",$where)->row();
	}
}