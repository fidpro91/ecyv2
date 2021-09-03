<?php

class M_cicilan_pinjaman extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",cicilan_id as id_key  from cicilan_pinjaman where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",cicilan_id as id_key  from cicilan_pinjaman where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"cicilan_id",
				"pinjaman_id",
				"cicilan_no",
				"cicilan_date",
				"qty_cicilan",
				"jml_cicilan"=>[
					"custom"=> function($a) {
						return convert_currency($a);
					}
				],
				"cicilan_note",
				"user_created",
				"created_at"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"pinjaman_id" => "trim|integer|required",
					"cicilan_no" => "trim|required",
					"cicilan_date" => "trim|required",
					"qty_cicilan" => "trim|integer|required",
					"jml_cicilan" => "trim|numeric|required",
					"cicilan_note" => "trim",
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

	public function get_cicilan_pinjaman($where)
	{
		return $this->db->get_where("cicilan_pinjaman",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("cicilan_pinjaman",$where)->row();
	}

	public function get_pinjaman($where)
	{
		$this->db->where($where,null);
		return $this->db->join("employee e","e.emp_id = p.emp_id")
						->select("p.*,p.pinjaman_no as label,e.emp_no,e.emp_name")
						->limit(25)
						->get("pinjaman_pegawai p")
						->result();
	}
}