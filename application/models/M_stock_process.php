<?php

class M_stock_process extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",stockprocess_id as id_key  from stock_process where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",stockprocess_id as id_key  from stock_process where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"stock_id",
				"item_id",
				"own_id",
				"unit_id",
				"date_trans",
				"date_act",
				"trans_num",
				"trans_type",
				"fk_id",
				"stock_before",
				"debet",
				"kredit",
				"stock_after",
				"item_price",
				"total_price",
				"desc",
				"stockprocess_id",
				"po_id",
				"sale_id",
				"type_act"];
		return $col;
	}

	public function rules()
	{
		$data = [
					"stock_id" => "trim|integer|required",
					"item_id" => "trim|integer|required",
					"own_id" => "trim|integer",
					"unit_id" => "trim|integer",
					"date_trans" => "trim",
					"date_act" => "trim",
					"trans_num" => "trim",
					"trans_type" => "trim|integer",
					"fk_id" => "trim|integer",
					"stock_before" => "trim|integer",
					"debet" => "trim|integer",
					"kredit" => "trim|integer",
					"stock_after" => "trim|integer",
					"item_price" => "trim",
					"total_price" => "trim",
					"desc" => "trim",
					"po_id" => "trim|integer",
					"sale_id" => "trim|integer",
					"type_act" => "trim|integer",

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

	public function get_stock_process($where)
	{
		return $this->db->get_where("stock_process",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("stock_process",$where)->row();
	}
}