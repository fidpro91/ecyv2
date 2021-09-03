<?php

class M_pengajuan_lembur extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from pengajuan_lembur pl 
				join employee e on e.emp_id = pl.emp_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from pengajuan_lembur pl
				join employee e on e.emp_id = pl.emp_id
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"lembur_no"=>['label'=>'No Lembur'],
				"emp_no"=>['label'=>'Kode Pegawai'],
				"emp_name"=>['label'=>'Nama'],
				"lembur_date"=>['label'=>'Tanggal'],
				"lembur_start"=>['label'=>'Jam Mulai'],
				"lembur_end"=>['label'=>'Jam Selesai'],
				"lembur_task"=>['label'=>'Tugas Lembur'],
				"time_qty",
				/*"user_created",
				"approved_by",
				"created_at"*/
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"lembur_no" => "trim|required",
					"emp_id" => "trim|integer|required",
					"lembur_date" => "trim|required",
					"lembur_start" => "trim|required",
					"lembur_end" => "trim|required",
					"lembur_task" => "trim|required",
					/*"time_qty" => "trim|numeric",
					"user_created" => "trim|integer",
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

	public function get_pengajuan_lembur($where)
	{
		return $this->db->get_where("pengajuan_lembur",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("pengajuan_lembur",$where)->row();
	}
}