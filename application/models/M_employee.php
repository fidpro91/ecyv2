<?php

class M_employee extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",emp_id as id_key from employee e
				left join ms_department md on e.unit_id=md.department_id
				left join ms_jabatan mj on mj.id_jabatan = e.position_id
				 where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",emp_id as id_key from employee e
				left join ms_department md on e.unit_id=md.department_id
				left join ms_jabatan mj on mj.id_jabatan = e.position_id 
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$this->load->model("m_ms_region");
		$col = [
				//"emp_id",
				"emp_photo"=>["label"=>"Foto",
						"custom"=> function($a) {
	            			return '<img height="80%" width="80%" src="'.(isset($a)?base_url("assets/uploads/photo_pegawai/$a"):base_url("assets/images/no-photo.jpeg")).'"/>';
						}],
				"emp_no"=>["label"=>"No Pegawai"],
				"absen_code"=>["label"=>"kode checklog"],
				"emp_noktp"=>["label"=>"No KTP"],
				"emp_nokk"=>["label"=>"No KK"],
				"emp_name"=>["label"=>"Nama"],
				"emp_sex"=>["label"=>"Jenis Kelamin"],
				"emp_born"=>["label"=>"Tempat Lahir"],
				"emp_birthdate"=>["label"=>"Tgl Lahir"],
				"emp_status"=>["label"=>"Status Perkawinan"],
				"emp_couple"=>["label"=>"Nama Pasangan"],
				"emp_phone"=>["label"=>"No Telp"],
				"emp_mail"=>["label"=>"E-mail"],
				"emp_address"=>["label"=>"Alamat"],
				"alamat_domisili",
				"emp_resident"=>["label"=>"Kelurahan",
						"custom"=> function($a) {
							$rs = $this->m_ms_region->find_one(["reg_code"=>$a]);
	            			return isset($rs)?$rs->reg_name:null;
						}],
				"emp_district"=>["label"=>"Kecamatan",
						"custom"=> function($a) {
							$rs = $this->m_ms_region->find_one(["reg_code"=>$a]);
	            			return isset($rs)?$rs->reg_name:null;
						}],
				"emp_city"=>["label"=>"Kota",
						"custom"=> function($a) {
							$rs = $this->m_ms_region->find_one(["reg_code"=>$a]);
	            			return isset($rs)?$rs->reg_name:null;
						}],
				"emp_prov"=>["label"=>"Provinsi",
						"custom"=> function($a) {
							$rs = $this->m_ms_region->find_one(["reg_code"=>$a]);
	            			return isset($rs)?$rs->reg_name:null;
						}],
				"emp_npwp"=>["label"=>"NPWP"],
				"tahun_masuk"=>["label"=>"Tahun Masuk"],
				"department_name"=>["label"=>"Departemen"],
				"nama_jabatan"=>["label"=>"Jabatan"],
				"agama"=>["label"=>"Agama"],
				"pendidikan"=>["label"=>"Pendidikan Terakhir"],
				"jurusan_pendidikan",
				"no_bpjs_kesehatan",
				"no_bpjs_ketenagakerjaan",
				"no_kpa",
				"anak"=>["label"=>"jumlah anak"],
				"emp_active"=>[
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
					// "emp_id" => "trim|integer|required",
					"emp_no" => "trim|required",
					"emp_noktp" => "trim",
					"emp_nokk" => "trim",
					"emp_name" => "trim|required",
					"emp_sex" => "trim|required",
					"emp_birthdate" => "trim",
					"emp_status" => "trim",
					"emp_couple" => "trim",
					"emp_phone" => "trim",
					"emp_address" => "trim",
					"emp_resident" => "trim",
					"emp_district" => "trim",
					"emp_city" => "trim",
					"emp_prov" => "trim",
					"emp_npwp" => "trim",
					"tahun_masuk" => "trim",
					"unit_id" => "trim|integer",
					"position_id" => "trim|integer",
					"agama" => "trim",
					"pendidikan" => "trim",
					"emp_active" => "trim",
					"emp_type" => "trim",
					"absen_code" => "trim",
					"alamat_domisili" => "trim",
					"no_bpjs_kesehatan" => "trim",
					"no_bpjs_ketenagakerjaan" => "trim",
					"no_kpa" => "trim",
					"jurusan_pendidikan" => "trim",
					"catatan" => "trim",
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

	public function get_employee($where="",$select = "",$limit = "")
	{
		if ($limit) {
			$this->db->limit($limit);
		}
		if ($select) {
			$this->db->select($select);
		}
		if (is_array($where)) {
			$data =$this->db->get_where("employee",$where)->result();
		}else{
			$data = $this->db->where($where,null)
							 ->get("employee")
							 ->result();
		}
		return $data;
	}
}