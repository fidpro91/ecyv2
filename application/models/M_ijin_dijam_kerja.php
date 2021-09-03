<?php

class M_ijin_dijam_kerja extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from ijin_dijam_kerja ij
				join employee e on e.emp_id = ij.emp_id
				 where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key  from ijin_dijam_kerja ij 
				join employee e on e.emp_id = ij.emp_id 
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				//"id",
				//"emp_id",
				"no_ijin"=>['label'=>'No Izin'],
				"emp_name"=>["label"=>"nama pegawai"],
				"ijin_date"=>['label'=>'Tanggal'],
				"ijin_checkout"=>['label'=>'Keluar'],
				"ijin_checkin"=>['label'=>'Masuk'],
				"duration"=>['label'=>'Durasi'],
				"ijin_note"=>['label'=>'Catatan Izin'],
				//"user_created",
				//"created_at",
				"approved_by"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"emp_id" => "trim|integer|required",
					"no_ijin" => "trim|required",
					"ijin_date" => "trim|required",
					"ijin_checkout" => "trim|required",
					// "ijin_checkin" => "trim",
					// "duration" => "trim|numeric",
					"ijin_note" => "trim|required",
					/*"user_created" => "trim|integer",
					"approved_by" => "trim|integer",*/
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

	public function get_ijin_dijam_kerja($where)
	{
		return $this->db->get_where("ijin_dijam_kerja",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("ijin_dijam_kerja",$where)->row();
	}
}