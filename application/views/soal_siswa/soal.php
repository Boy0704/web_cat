<?php 
	$banyak_soal = $jumlah_soal->result();
	// print_r($banyak_soal); exit;
 ?>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
		  <div class="panel-heading"> Soal Online</div>
		  <div class="panel-body">
		  	<div id="soal"></div>
		  </div>
		</div>
		
	</div>


	<div class="col-md-4">
		<div class="panel panel-default">
		  <div class="panel-heading">Navigasi Soal</div>
		  <div class="panel-body">
		  	<?php 
			$no = 1;
			foreach ($banyak_soal as $row) {
			 ?>
			<button class="btn btn-default" style="width: 50px; margin-right: 5px; margin-bottom: 5px;" id="btn_soal<?php echo $row->butir_soal_id ?>"><?php echo $no; ?></button>
			<?php $no++; } ?>
		  </div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		
		<?php 
		foreach ($banyak_soal as $row) {
		 ?>
		$('#btn_soal<?php echo $row->butir_soal_id ?>').click(function() {
			// alert('Klik ID'+ <?php echo $row->butir_soal_id ?>);
			$.ajax({
				url: 'app/ambil_soal_ujian/<?php echo $row->butir_soal_id ?>',
				type: 'GET'
			})
			.done(function(respon) {
				console.log("success");
				$('#soal').html(respon);
				
				//ketika klik jawaban	
				$('input[name=jwb]').click(function() {
					//cek bobot jawaban
					var bobot = $(this).attr('nilai');
				});
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});

		<?php } ?>

	});
</script>