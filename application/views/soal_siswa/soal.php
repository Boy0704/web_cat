<?php 
	$banyak_soal = $jumlah_soal->result();
	$first = $jumlah_soal->row();
	$next = $jumlah_soal->next_row();

	// echo $first->butir_soal_id.'<br>';
	// echo $next->butir_soal_id.'<br>';
	//  exit;

	$user_id = $this->session->userdata('id_user');
	$soal_id = $this->uri->segment(3);
	$paket_soal_id = $this->uri->segment(4);
	$skor_id = $this->uri->segment(5);
	$ambil_jam_mulai = $this->db->get_where('skor', array('skor_id'=>$skor_id))->row()->waktu_mulai;

	$mapel_id = $this->db->get_where('soal', array('soal_id'=>$soal_id))->row()->mapel_id;

	$minutes_to_add = $this->db->query("SELECT pg.pengaturan FROM pengaturan as pg, mapel as mp where mp.mapel_kategori=pg.pengaturan_id and mp.mapel_id='$mapel_id' ")->row()->pengaturan;
	$date = date_create($ambil_jam_mulai);
	date_add($date, date_interval_create_from_date_string($minutes_to_add.' minutes'));
	$jam_mulai = date_format($date, 'H:i:s');

	// echo $jam_mulai; exit;

	// $minutes_to_add = 90;
 //    $time = new DateTime();
 //    $time->setTimezone(new DateTimeZone('Asia/Jakarta'));
 //    $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
 //    $timestamp = $jam_mulai;
    // echo $timestamp; exit;
	// print_r($banyak_soal); exit;
 ?>
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-info">
		  <div class="panel-heading"> 
		  Soal Online | <b><?php echo $nama_soal ?></b>

		  <b id="clockdiv" class="label label-success" style="font-size: 12pt; margin-left: 30px;"><span class="hours"></span> : <span class="minutes"></span> : <span class="seconds"></span></b>
	  

		  <a href="app/aksi_mulai_ujian/<?php echo $paket_soal_id.'/'.$soal_id.'/'.$user_id.'/'.$skor_id ?>">
		  	<b class="label label-success" style="font-size: 12pt; margin-left: 30px;">Selesai</b>
		  </a>

		 

		  </div>
		  <div class="panel-body">
		  	<div id="soal"></div>
		  </div>
		</div>
		
	</div>


	<div class="col-md-4">
		<div class="panel panel-info">
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

		//load soal pertama
		$.get('app/ambil_soal_ujian/<?php echo $first->butir_soal_id ?>/1', function(data) {
			$('#soal').html(data);

			//hidden previous
			// $('.previous').attr('style', 'display: none;');

			//berikan 
			// $('.next > a').attr('id', 'pager<?php echo $next->butir_soal_id; ?>');
			// $('.next > a').css('color', 'red');

			//ragu-ragu
			$('input:checkbox').change(
		    function(){
		        if ($(this).prop('checked', true)) {
		            console.log('checked');
		            $('#btn_soal<?php echo $first->butir_soal_id ?>').attr('class', 'btn btn-warning');
		        }
		    });

			//ketika klik jawaban	
			klik_jawaban();
		});
		
		<?php
		$no = 1;
		foreach ($banyak_soal as $row) {
		 ?>
		$('#btn_soal<?php echo $row->butir_soal_id ?>, #pager<?php echo $row->butir_soal_id ?>').click(function() {
			// alert('Klik ID'+ <?php echo $row->butir_soal_id ?>);

			$.ajax({
				url: 'app/ambil_soal_ujian/<?php echo $row->butir_soal_id ?>/<?php echo $no; ?>',
				type: 'GET'
			})
			.done(function(respon) {
				console.log("success");
				$('#soal').html(respon);

				//ragu-ragu
				$('input:checkbox').change(
			    function(){
			        if ($(this).prop('checked', true)) {
			            console.log('checked');
			            $('#btn_soal<?php echo $row->butir_soal_id ?>').attr('class', 'btn btn-warning');
			        }
			    });
				
				//ketika klik jawaban	
				klik_jawaban();
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		});

		<?php $no++; } ?>

		function klik_jawaban(butir_soal_id) {
			$('input[name=jwb]').click(function() {
				//cek bobot jawaban
				var bobot = $(this).attr('nilai');
				var butir_soal_id = $(this).attr('butir_soal_id');
				var jawaban = $(this).val();
				var soal_id = '<?php echo $soal_id ?>';
				var skor_id = '<?php echo $skor_id ?>';
				var user_id = '<?php echo $user_id ?>';
				console.log(bobot+' - '+jawaban+' - '+butir_soal_id+' - '+soal_id+' - '+user_id);
				console.log('mulai bobot jawaban');
				$.ajax({
					url: 'app/simpan_jawaban/'+user_id+'/'+skor_id+'/'+soal_id+'/'+butir_soal_id+'/'+bobot,
					type: 'POST',
					dataType: 'html',
					data: {jawaban: jawaban},
				})
				.done(function() {
					console.log("success simpan bobot");
					$('#btn_soal'+butir_soal_id).attr('class', 'btn btn-success');
				})
				.fail(function() {
					console.log("error simpan bobot");
				})
				.always(function() {
					console.log("complete simpan bobot");
				});

			});
		}

	});

	var i = 10;
  var date = new Date();
  var month = date.getMonth()+1; if (month < 10) { month = "0"+month; }
  var day = date.getDate(); if (day < 10) { day = "0"+day; }
  var tanggal  = date.getFullYear()+'-'+month+'-'+day;
  var time = '<?php echo $jam_mulai; ?>';
  var deadline = tanggal+' '+ time +' GMT+07:00';
  function time_remaining(endtime){
  	var t = Date.parse(endtime) - Date.parse(new Date());
  	var seconds = Math.floor( (t/1000) % 60 );
  	var minutes = Math.floor( (t/1000/60) % 60 );
  	var hours = Math.floor( (t/(1000*60*60)) % 24 );
  	var days = Math.floor( t/(1000*60*60*24) );
  	return {'total':t, 'days':days, 'hours':hours, 'minutes':minutes, 'seconds':seconds};
  }
  function run_clock(id,endtime){
  	var clock = document.getElementById(id);

  	// get spans where our clock numbers are held
  	// var days_span = clock.querySelector('.days');
  	var hours_span = clock.querySelector('.hours');
  	var minutes_span = clock.querySelector('.minutes');
  	var seconds_span = clock.querySelector('.seconds');

  	function update_clock(){
  		var t = time_remaining(endtime);

  		// update the numbers in each part of the clock
  		if(t.total<=0){
        // days_span.innerHTML = t.days;
    		hours_span.innerHTML = ('00').slice(-2);
    		minutes_span.innerHTML = ('00').slice(-2);
    		seconds_span.innerHTML = ('00').slice(-2);

          document.getElementsByTagName("h1")[0].classList.remove("blink");
          document.getElementById('text').innerHTML= "<br /> Mereload Halaman";
          document.getElementById('reload_page').innerHTML= i;
          if (i == 0) {
            clearInterval(timeinterval);
            window.location="<?php echo base_url() ?>app/aksi_mulai_ujian/<?php echo $paket_soal_id.'/'.$soal_id.'/'.$user_id.'/'.$skor_id ?>";
          }
        i--;
      }else {
        // days_span.innerHTML = t.days;
    		hours_span.innerHTML = ('0' + t.hours).slice(-2);
    		minutes_span.innerHTML = ('0' + t.minutes).slice(-2);
    		seconds_span.innerHTML = ('0' + t.seconds).slice(-2);
      }
  	}
  	update_clock();
  	var timeinterval = setInterval(update_clock,1000);
  }
  run_clock('clockdiv',deadline);

	
</script>