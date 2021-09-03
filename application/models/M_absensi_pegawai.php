<?php

class M_absensi_pegawai extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",absen_id as id_key from absensi_pegawai ap 
				join employee e on e.absen_code = ap.emp_absen_code
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",absen_id as id_key from absensi_pegawai ap 
				join employee e on e.absen_code = ap.emp_absen_code
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				// "absen_id",
				"emp_absen_code",
				"emp_name",
				"absen_date",
				"check_in",
				"check_out",
				"late_duration"=>[
						"custom" => function($a){
							return (($a)?$a:0)." Menit";
						}
					],
				"absen_type"=>[
						"custom" => function($a){
							if ($a==1) {
								$txt = "<label class='label label-default'>CUTI/IJIN</label>";
							}elseif ($a==2) {
								$txt = "<label class='label label-success'>MASUK</label>";
							}elseif ($a==3) {
								$txt = "<label class='label label-info'>LEMBUR</label>";
							}elseif ($a==4) {
								$txt = "<label class='label label-danger'>LIBUR</label>";
							}elseif ($a==5) {
								$txt = "<label class='label label-danger'>ALPA</label>";
							}
							return $txt;
						}
					],/*
				"user_created",
				"created_at"*/];
		return $col;
	}

	public function rules()
	{
		$data = [
					"emp_absen_code" => "trim|required",
					"absen_date" => "trim|required",
					"check_in" => "trim|required",
					"check_out" => "trim|required",
					// "late_duration" => "trim|numeric",
					"absen_type" => "trim|required",
					// "user_created" => "trim|integer",
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

	public function get_absensi_pegawai($where)
	{
		return $this->db->get_where("absensi_pegawai",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("absensi_pegawai",$where)->row();
	}
}