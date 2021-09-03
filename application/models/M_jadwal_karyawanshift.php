<?php

class M_jadwal_karyawanshift extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",jadwalkarywawan_id as id_key from jadwal_karyawanshift j 
				join employee e on j.emp_id = e.emp_id
				join ms_jadwal mj on j.jadwal_id = mj.jadwal_id
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",jadwalkarywawan_id as id_key from jadwal_karyawanshift j 
				join employee e on j.emp_id = e.emp_id
				join ms_jadwal mj on j.jadwal_id = mj.jadwal_id
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				// "jadwalkarywawan_id",
				"emp_no"=>['label'=>'Kode Pegawai'],
				"emp_name"=>['label'=>'Nama Pegawai'],
				"tanggal",
				"keterangan_jadwal",
				"jam_masuk",
				"jam_pulang",
				];
		return $col;
	}

	public function get_column_multi()
	{
		$col = [
				"employee_code",
				"emp_id",
				"jadwal_id"
			];
		return $col;
	}
	public function rules()
	{
		$data = [
					"emp_id" => "trim|integer|required",
					"tanggal" => "trim|required",
					"jadwal_id" => "trim|integer|required",

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

	public function get_jadwal_karyawanshift($where)
	{
		return $this->db->get_where("jadwal_karyawanshift",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("jadwal_karyawanshift",$where)->row();
	}

	public function get_jadwal($select="",$where = array())
	{
		if ($select) {
			$this->db->select($select);
		}
		return $this->db->get_where("ms_jadwal",$where)->result();
	}
}