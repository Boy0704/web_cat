<?php 
	$butir_soal_id = $this->uri->segment(3);
	$data = $this->db->get_where('butir_soal', array('butir_soal_id'=>$butir_soal_id))->row();
 ?>
<form action="app/ubah_butir_soal/<?php echo $butir_soal_id ?>" method="POST">

<div class="row">
	<div class="form-group">
		<div class="col-md-12">
			<h4>Pertanyaan</h4>
			<textarea class="form-control textarea_editor" name="pertanyaan"><?php echo $data->pertanyaan ?></textarea>
		</div>
	</div>
</div>
<!-- <hr> -->
<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 1</h4>
			<textarea class="form-control textarea_editor" name="jawaban1"><?php echo $data->jawaban1 ?></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 1</h4>
			<input type="number" class="form-control" name="bobot_jawaban1" value="<?php echo $data->bobot_jawaban1 ?>">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 2</h4>
			<textarea class="form-control textarea_editor" name="jawaban2"><?php echo $data->jawaban2 ?></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 2</h4>
			<input type="number" class="form-control" name="bobot_jawaban2" value="<?php echo $data->bobot_jawaban2 ?>">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 3</h4>
			<textarea class="form-control textarea_editor" name="jawaban3"><?php echo $data->jawaban3 ?></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 3</h4>
			<input type="number" class="form-control" name="bobot_jawaban3" value="<?php echo $data->bobot_jawaban3 ?>">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 4</h4>
			<textarea class="form-control textarea_editor" name="jawaban4"><?php echo $data->jawaban4 ?></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 4</h4>
			<input type="number" class="form-control" name="bobot_jawaban4" value="<?php echo $data->bobot_jawaban4 ?>">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 5</h4>
			<textarea class="form-control textarea_editor" name="jawaban5"><?php echo $data->jawaban5 ?></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 5</h4>
			<input type="number" class="form-control" name="bobot_jawaban5" value="<?php echo $data->bobot_jawaban5 ?>">
		</div>
	</div>
</div>
<button type="submit" class="btn btn-primary">Terapkan Perubahan</button> 
<!-- | <a href="soal" class="btn btn-info">kembali</a> -->
</form>