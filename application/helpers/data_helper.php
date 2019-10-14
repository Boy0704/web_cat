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