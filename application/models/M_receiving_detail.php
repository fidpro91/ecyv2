<?php

class M_receiving_detail extends CI_Model {

	public function get_data($sLimit,$sWhere,$sOrder,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",recdet_id as id_key  from receiving_detail where 0=0 $sWhere $sOrder $sLimit
			")->result_array();
		return $data;
	}

	public function get_total($sWhere,$aColumns)
	{
		$data = $this->db->query("
				select ".implode(',', $aColumns).",recdet_id as id_key  from receiving_detail where 0=0 $sWhere
			")->num_rows();
		return $data;
	}

	public function get_column()
	{
		$col = [
				"recdet_id",
				"rec_id",
				"item_id",
				"batch_num",
				"expired_date",
				"item_pack",
				"qty_pack",
				"item_unit",
				"qty_unit",
				"unit_per_pack",
				"price_pack",
				"price_total",
				"disc_percent",
				"disc_value",
				"disc_extra",
				"price_item",
				"hpp",
				"price_bruto_item",
				"funds_id"];
		return $col;
	}

	public function get_column_multiple()
	{
		$col = [
				"item_id",
				"item_pack",
				"item_unit",
				"expired_date",
				"qty_pack",
				"unit_per_pack",
				"price_pack",
				"disc_percent",
				"disc_value",
				"price_total",
			];
		return $col;
	}

	public function rules()
	{
		$data = [
					"rec_id" => "trim|integer|required",
					"item_id" => "trim|integer",
					"batch_num" => "trim",
					"expired_date" => "trim",
					"item_pack" => "trim",
					"qty_pack" => "trim|integer",
					"item_unit" => "trim",
					"qty_unit" => "trim|integer",
					"unit_per_pack" => "trim|integer",
					"price_pack" => "trim",
					"price_total" => "trim",
					"disc_percent" => "trim",
					"disc_value" => "trim",
					"disc_extra" => "trim",
					"qty_stock" => "trim|integer",
					"qty_retur" => "trim|integer",
					"price_item" => "trim",
					"hpp" => "trim",
					"price_bruto_item" => "trim",
					"funds_id" => "trim|integer",

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

	public function get_receiving_detail($where)
	{
		return $this->db->get_where("receiving_detail",$where)->result();
	}

	public function find_one($where)
	{
		return $this->db->get_where("receiving_detail",$where)->row();
	}
}