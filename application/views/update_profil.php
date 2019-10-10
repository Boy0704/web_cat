<?php 
$row = $data->row();
 ?>
<div class="row" style="margin: 10px;">
	<div class="panel panel-info">
	  <div class="panel-heading"> 
	  	Ubah Profil
	  </div>
	  <div class="panel-body">
	  	<form action="" method="POST">
	  		<div class="form-group">
	  			<label>Nama Lengkap</label>
	  			<input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row->nama_lengkap ?>">
	  		</div>
	  		<div class="form-group">
	  			<label>Email</label>
	  			<input type="text" class="form-control" name="email" value="<?php echo $row->email ?>">
	  		</div>
	  		<div class="form-group">
	  			<label>Alamat</label>
	  			<textarea class="form-control" name="alamat"><?php echo $row->alamat ?></textarea>
	  		</div>
	  		<div class="form-group">
	  			<label>Username</label>
	  			<input type="text" class="form-control" name="username" value="<?php echo $row->username ?>">
	  		</div>
	  		<div class="form-group">
	  			<label>password</label>
	  			<input type="text" class="form-control" name="password" value="">
	  			<br><b>*) Kosongkan password jika tidak di rubah</b>
	  		</div>

	  		<div class="form-group">
	  			<button type="submit" class="btn btn-primary">Update</button>
	  		</div>
	  	</form>
	  </div>
	</div>
</div>