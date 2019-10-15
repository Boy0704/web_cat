<?php 
$nama_soal = $this->db->query("SELECT soal.soal, mapel.mapel, mapel.nilai_lulus FROM mapel, soal where soal.mapel_id=mapel.mapel_id and soal.soal_id='$soal_id' ")->row();
 ?>

<div class="row">
	<table class="table">
		<tr>
			<th>Soal</th>
			<td>:</td>
			<td><b><?php echo $nama_soal->soal.' - '.$nama_soal->mapel ?></b></td>
		</tr>
		<tr>
			<th>Target Kelulusan</th>
			<td>:</td>
			<td><b><?php echo $nama_soal->nilai_lulus; ?></b></td>
		</tr>
		<tr>
			<th>Nama</th>
			<td>:</td>
			<td><b><?php echo $this->session->userdata('nama'); ?></b></td>
		</tr>
	</table>
</div>
<hr>
<center><h3>Jawaban Anda</h3></center>
<table class="table table-bordered">
	<tr>
		<td>No.</td>
		<th>Soal</th>
		<th>Jawaban</th>
		<th>Jawaban benar</th>
	</tr>
	<?php
	$no = 1;
	foreach ($data->result() as $row) {
	 ?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $row->pertanyaan ?></td>
		<td><?php echo $row->jawaban ?></td>
		<td><?php echo $row->nilai ?></td>
	</tr>
<?php $no++; } ?>
</table>