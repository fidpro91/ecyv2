<?php

class M_receiving extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",rec_id as id_key  from receiving where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",rec_id as id_key  from receiving where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"rec_id",
				"rec_num",
				"rec_date",
				"rec_type",
				"rec_taxes",
				"rec_stamp",
				"discount_total",
				"status",
				"pay_type",
				"supplier_id",
				"user_id",
				"item_status",
				"ppn",
				"total_receiving"];
		return $col;
	}

	public function rules()
	{
		$data = [
										"rec_num" => "trim|required",
					"rec_date" => "trim|required",
					"rec_type" => "trim|integer|required",
					"rec_taxes" => "trim",
					// "rec_stamp" => "trim|integer",
					// "discount_type" => "trim|integer",
					"discount_total" => "trim",
					// "status" => "trim|integer",
					"pay_type" => "trim|required",
					"supplier_id" => "trim|integer|required",
					// "user_id" => "trim|integer",
					// "item_status" => "trim|integer",
					"ppn" => "trim",
					"total_receiving" => "trim",

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

	public function get_receiving($where)
	{
		return $this->db->get_where("receiving",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("receiving",$where)->row();
	}
}