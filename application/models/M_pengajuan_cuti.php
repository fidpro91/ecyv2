<?php

class M_pengajuan_cuti extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from pengajuan_cuti pc
				join ms_cuti ct on pc.cuti_id = ct.cuti_id
				join employee e on e.emp_id = pc.emp_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",id as id_key from pengajuan_cuti pc
				join ms_cuti ct on pc.cuti_id = ct.cuti_id
				join employee e on e.emp_id = pc.emp_id 
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"no_pengajuan",
				"cuti_name"=>["label"=>"jenis cuti"],
				"emp_name"=>["label"=>"nama pegawai"],
				"cuti_date_start",
				"cuti_date_end",
				"jml_cuti",
				"cuti_keterangan",
				// "user_id",
				// "user_approved",
				// "created_at",
				"berkas_cuti"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"no_pengajuan" => "trim|required",
					"cuti_id" => "trim|integer|required",
					"emp_id" => "trim|integer|required",
					// "cuti_date_start" => "trim|required",
					// "cuti_date_end" => "trim|required",
					"jml_cuti" => "trim|integer|required",
					"cuti_keterangan" => "trim",
					// "user_id" => "trim|integer",
					// "user_approved" => "trim|integer",
					"berkas_cuti" => "trim",

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

	public function get_pengajuan_cuti($where)
	{
		return $this->db->get_where("pengajuan_cuti",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("pengajuan_cuti",$where)->row();
	}

	public function hitung_cuti($where)
	{
		$data = $this->db->select("emp_id,pc.cuti_id,sum(coalesce(jml_cuti,0)) as total_cuti,(cuty_qty-coalesce(sum(jml_cuti),0)) as sisa_cuti")
						->join("ms_cuti mc","mc.cuti_id = pc.cuti_id")
						->group_by("emp_id,pc.cuti_id")
						->get_where("pengajuan_cuti pc",$where)
						->row();
		if (!isset($data)) {
			$data = $this->db->select("0 as total_cuti,cuty_qty as sisa_cuti")
							 ->get_where("ms_cuti mc",["cuti_id"=>$where["mc.cuti_id"]])
							 ->row();
		}
		return $data;
	}
}