<?php

class M_dashboard extends CI_Model {

	public function get_info_header()
	{
		$data['persentase_masuk'] = $this->db->query("
				SELECT (count(DISTINCT e.emp_id)*30)jml_karyawan,sum(if(ap.emp_absen_code,1,0))total_masuk FROM employee e 
				LEFT JOIN absensi_pegawai ap ON e.absen_code = ap.emp_absen_code AND ap.absen_type = '2'
				WHERE emp_active = 't' 
			")->row();
		$data['persentase_masuk'] = ceil(($data['persentase_masuk']->total_masuk/$data['persentase_masuk']->jml_karyawan)*100);
		return $data;
	}
}
?>