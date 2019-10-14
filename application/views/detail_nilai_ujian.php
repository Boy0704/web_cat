<?php 
$sql = "
	SELECT
		us.nama_lengkap, ps.paket_soal, sk.waktu_mulai, sk.waktu_selesai
	FROM
		skor AS sk,
		user AS us,
		paket_soal AS ps 
	WHERE
		sk.user_id = us.user_id 
		AND sk.paket_soal_id = ps.paket_soal_id
		and sk.paket_soal_id = '$paket_soal_id'
		and sk.user_id='$user_id'
		and sk.skor_id='$skor_id'
";
$header = $this->db->query($sql)->row();
// print_r($sql);exit();
 ?>

<div class="row" style="margin-left: 10px;">
	<table class="table">
		<tr>
			<th>Nama Lengkap</th>
			<td>:</td>
			<td><b><?php echo $header->nama_lengkap ?></b></td>
		</tr>
		<tr>
			<th>Paket Soal</th>
			<td>:</td>
			<td><b><?php echo $header->paket_soal ?></b></td>
		</tr>
		<tr>
			<th>Jam Mulai</th>
			<td>:</td>
			<td><b><?php echo $header->waktu_mulai ?></b></td>
		</tr>
		<tr>
			<th>Jam Mulai</th>
			<td>:</td>
			<td><b><?php echo $header->waktu_selesai ?></b></td>
		</tr>
	</table>
</div>
<!-- <hr> -->
<!-- <center><h3>Jawaban Anda</h3></center> -->
<table class="table table-bordered">
	<tr>
		<td>No.</td>
		<th>Nama Soal</th>
		<th>Nilai</th>
		<th>Target</th>
		<th>Keterangan</th>
	</tr>
	<?php
	$total = 0;
	$no = 1;
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
		and sd.skor_id='$skor_id'
		and sd.user_id='$user_id'

		GROUP BY sd.soal_id
	";
	$data = $this->db->query($sql);
	foreach ($data->result() as $row) {
	 ?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $row->mapel.' - '.$row->soal ?></td>
		<td><?php echo $row->total_nilai ?></td>
		<td><?php echo $row->nilai_lulus ?></td>
		<td>
			<?php 
			if ($row->total_nilai >= $row->nilai_lulus) {
			 ?>
			<span class="label label-success">LULUS</span>
			<?php 
			} else {
			 ?>
			<span class="label label-danger">TIDAK LULUS</span>
			<?php } ?>
		</td>
	</tr>
<?php $no++; $total = $total+$row->total_nilai; } ?>
	<tr>
		<th colspan="2">Total Nilai</th>
		<th colspan="3"><?php echo $total ?></th>
	</tr>
</table>