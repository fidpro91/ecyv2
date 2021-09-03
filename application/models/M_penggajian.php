<?php

class M_penggajian extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",gaji_id as id_key  from penggajian pg
				join employee e on pg.emp_id = e.emp_id 
				join ms_jabatan mj on e.position_id = mj.id_jabatan 
				where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",gaji_id as id_key  from penggajian pg
				join employee e on pg.emp_id = e.emp_id 
				join ms_jabatan mj on e.position_id = mj.id_jabatan 
				where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_gaji($where = "")
	{
		$data = $this->db->query("
				select *,x.keterangan as value from (
					SELECT 'Gaji Pokok' as keterangan,nominal FROM ms_gaji_pokok
					UNION 
					SELECT tunjangan,nominal FROM ms_tunjangan
				)x
				where 0=0 $where
				")->result();
		return $data;
	}

	public function get_gaji_potongan($where = "")
	{
		$data = $this->db->query("
				select *,x.keterangan as value from (
					SELECT nama_potongan as keterangan,nominal FROM ms_potongan
					UNION 
					SELECT concat('CICILAN HUTANG_',pinjaman_no),cicilan_perbulan FROM pinjaman_pegawai
					where (status_lunas is null or status_lunas = 'f')
				)x
				where 0=0 $where
				")->result();
		return $data;
	}

	public function get_komponen_gaji($id)
	{
		$data['terima'] = $this->db->query("
				select * from (
					SELECT 'Gaji Pokok' as keterangan,if(gp.gp_type='harian',30,1)qty,coalesce(mg.gaji_pokok,gp.nominal)nominal FROM employee e 
					LEFT JOIN master_gaji_karyawan mg on e.emp_id = mg.emp_id
					LEFT JOIN ms_gaji_pokok gp on gp.jabatan_id = e.position_id
					where e.emp_id = $id
					UNION 
					SELECT tunjangan,if(jenis_tunjangan='Harian',30,1),nominal FROM ms_tunjangan
					where jenis_tunjangan != 'Tahunan'
				)x
				")->result_array();

		$data['potongan'] = $this->db->query("
				select * from (
					SELECT nama_potongan as keterangan,nominal FROM ms_potongan
					UNION 
					SELECT concat('CICILAN HUTANG_',pinjaman_no),cicilan_perbulan FROM pinjaman_pegawai
					where (status_lunas is null or status_lunas = 'f') and emp_id = $id
				)x
				")->result_array();
		return $data;
	}

	public function get_column()
	{
		$col = [
				// "gaji_id",
				"gaji_no",
				"emp_no",
				"emp_name",
				"nama_jabatan",
				"gaji_date_start",
				"gaji_date_end",
				"date_qty",
				"gaji_month",
				// "emp_id",
				"gaji_brutto"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"gaji_potongan"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"gaji_netto"=>[
						"custom"=> function($a) {
	            			return convert_currency($a);
						}
					],
				"gaji_note",
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"gaji_no" => "trim",
					"gaji_date_start" => "trim",
					"gaji_date_end" => "trim",
					"date_qty" => "trim|integer",
					"gaji_month" => "trim",
					"emp_id" => "trim|integer",
					"gaji_note" => "trim",
					"gaji_brutto" => "trim|numeric",
					"gaji_potongan" => "trim|numeric",
					"gaji_netto" => "trim|numeric",
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

	public function get_penggajian($where)
	{
		return $this->db->get_where("penggajian",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("penggajian",$where)->row();
	}
}