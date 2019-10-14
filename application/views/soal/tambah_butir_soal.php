<?php 
	$soal_id = $this->uri->segment(3);
 ?>
<form action="app/tambah_butir_soal/<?php echo $soal_id ?>" method="POST">

<div class="row">
	<div class="form-group">
		<div class="col-md-12">
			<h4>Pertanyaan</h4>
			<textarea class="form-control textarea_editor" name="pertanyaan"></textarea>
		</div>
	</div>
</div>
<!-- <hr> -->
<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 1</h4>
			<textarea class="form-control textarea_editor" name="jawaban1"></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 1</h4>
			<input type="number" class="form-control" name="bobot_jawaban1" value="">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 2</h4>
			<textarea class="form-control textarea_editor" name="jawaban2"></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 2</h4>
			<input type="number" class="form-control" name="bobot_jawaban2" value="">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 3</h4>
			<textarea class="form-control textarea_editor" name="jawaban3"></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 3</h4>
			<input type="number" class="form-control" name="bobot_jawaban3" value="">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 4</h4>
			<textarea class="form-control textarea_editor" name="jawaban4"></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 4</h4>
			<input type="number" class="form-control" name="bobot_jawaban4" value="">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<div class="col-md-9">
			<h4>Jawaban 5</h4>
			<textarea class="form-control textarea_editor" name="jawaban5"></textarea>
		</div>
		<div class="col-md-3">
			<h4>Bobot Jawaban 5</h4>
			<input type="number" class="form-control" name="bobot_jawaban5" value="">
		</div>
	</div>
</div>
<button type="submit" class="btn btn-primary">Simpan</button> 
<!-- | <a href="soal" class="btn btn-info">kembali</a> -->
</form>