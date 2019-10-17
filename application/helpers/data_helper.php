<?php 

function total_nilai_ujian($user_id, $soal_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('skor_detail',array('user_id'=>$user_id, 'soal_id'=>$soal_id))->result();
	$nilai = 0;
	foreach ($data as $rw) {
		$nilai = $nilai + $rw->nilai;
	}
	return $nilai;

} 

function cek_nilai_permapel($skor_id, $user_id, $mapel_id)
{
	$CI 	=& get_instance();
	$sql = "
	SELECT
	    sd.user_id,sd.soal_id ,so.soal, mp.mapel, mp.nilai_lulus, SUM(sd.nilai) as total_nilai
	FROM
	    skor_detail AS sd,
	    soal AS so,
	    mapel AS mp 
	WHERE
	    sd.soal_id = so.soal_id 
	AND so.mapel_id=mp.mapel_id
	and so.mapel_id='$mapel_id'
	and sd.skor_id='$skor_id'
	and sd.user_id='$user_id'

	GROUP BY sd.soal_id
	";
	$data = $CI->db->query($sql);
	if ($data->num_rows() == 0) {
		return 0;
	} else {
		return $CI->db->query($sql)->row()->total_nilai;
	}
	

}

function batch($batch_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('batch', array('batch_id'=>$batch_id))->row()->nama_batch;
	return $data;
}

function kat_mapel($kat)
{
	if ($kat == 'waktu_soal_muatan_lokal') {
		return 'muatan lokal';
	} elseif ($kat == 'waktu_soal_umum') {
		return 'umum';
	}
}

function mapel($mapel_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->get_where('mapel', array('mapel_id'=>$mapel_id))->row()->mapel;
	return $data;
}

function cek_status($status)
{
	if ($status == '1') {
		return "<span class=\"label label-success\">Aktif</span>";
	} elseif ($status == '0') {
		return "<span class=\"label label-danger\">Tidak Aktif</span>";
	}
}

function jawaban_benar($butir_soal_id)
{
	$CI 	=& get_instance();
	$d =$CI->db->get_where('butir_soal', array('butir_soal_id'=>$butir_soal_id))->row();
	if ($d->bobot_jawaban1 >= 4) {
		return $d->jawaban1;
	} elseif ($d->bobot_jawaban2 >= 4) {
		return $d->jawaban2;
	} elseif ($d->bobot_jawaban3 >= 4) {
		return $d->jawaban3;
	} elseif ($d->bobot_jawaban4 >= 4) {
		return $d->jawaban4;
	} elseif ($d->bobot_jawaban5 >= 4) {
		return $d->jawaban5;
	}
}

function select_jawaban($butir_soal_id, $user_id)
{
	$CI 	=& get_instance();
	$jawaban =$CI->db->get_where('skor_detail', array('butir_soal_id'=>$butir_soal_id,'user_id'=>$user_id));
	if ($jawaban->num_rows() == 0) {
		return '';
	} else {
		$j = $jawaban->row();
		return $j->jawaban;
	}
	
}

function cek_btn_soal($butir_soal_id, $user_id)
{
	$CI 	=& get_instance();
	$btn =$CI->db->get_where('skor_detail', array('butir_soal_id'=>$butir_soal_id,'user_id'=>$user_id));
	if ($btn->num_rows() == 0) {
		return 'btn btn-default';
	} else {
		return 'btn btn-success';
	}
	
}

function get_nama_soal($soal_id)
{
	$CI 	=& get_instance();
	$nm = $CI->db->get_where('soal', array('soal_id'=>$soal_id))->row()->soal;
	return $nm;
}

function get_soal_paket($paket_soal_id)
{
	$CI 	=& get_instance();
	$data = $CI->db->query("SELECT soal.soal FROM item_soal, soal where item_soal.soal_id=soal.soal_id and item_soal.paket_soal_id='$paket_soal_id' ");
	$nilai = "";
	foreach ($data->result() as $rw) {
		$nilai .= "<span class=\"label label-info\">".$rw->soal."</span> ";
	}
	return $nilai;

} 

function filter_string($n)
{
	$hasil = str_replace('"', "'", $n);
	return $hasil;
}

function cek_nilai_lulus()
{	
	$CI 	=& get_instance();
	$nilai = $CI->db->query("SELECT sum(nilai_lulus) as lulus FROM mapel ")->lulus;
	return $nilai;
}

function ket_lulus($total)
{
	if ($total >= cek_nilai_lulus()) {
		return "<span class=\"label label-success\">LULUS</span> ";
	} else {
		return "<span class=\"label label-danger\">TIDAK LULUS</span> ";
	}
}