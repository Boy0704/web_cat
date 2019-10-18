<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	
	public function index()
	{
        if ($this->session->userdata('username') == '') {
            redirect('app/login');
        }
		$data = array(
			'konten' => 'home',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function list_batch()
    {
    	$userid = $this->session->userdata('id_user');
    	$data = array(
    		'userid' => $userid,
    		'query' => $this->db->query("SELECT * FROM batch, akses_batch where batch.batch_id=akses_batch.batch_id and akses_batch.user_id=$userid GROUP BY batch.batch_id "),
    		'judul_page' => 'List Batch',
            'konten' => 'soal_siswa/list_batch',
    	);
    	$this->load->view('v_index', $data);
    }

    public function paket_soal($batch_id)
    {
    	$userid = $this->session->userdata('id_user');
    	$batchid = base64_decode($batch_id);
    	$data = array(
    		'userid' => $userid,
    		// 'query' => $this->db->get_where('akses_batch', array('batch_id'=>base64_decode($batch_id))),
    		'query' => $this->db->query("SELECT * FROM akses_batch, paket_soal where akses_batch.paket_soal_id=paket_soal.paket_soal_id and akses_batch.batch_id='$batchid' and akses_batch.user_id='$userid' "),
    		'judul_page' => 'Paket Soal',
            'konten' => 'soal_siswa/paket_soal',
    	);
    	$this->load->view('v_index', $data);
    }

    public function list_soal($paket_soal_id)
    {
    	$userid = $this->session->userdata('id_user');
    	$paket_soal_id = base64_decode($paket_soal_id);
    	$data = array(
    		'userid' => $userid,
    		'paket_soal_id' => $paket_soal_id,
    		'query' => $this->db->query("SELECT soal.soal,soal.soal_id FROM item_soal,soal where item_soal.soal_id=soal.soal_id and item_soal.paket_soal_id='$paket_soal_id' "),
    		'judul_page' => 'List Soal',
            'konten' => 'soal_siswa/list_soal',
    	);
    	$this->load->view('v_index', $data);
    }

    public function mulai_ujian($paket_soal_id,$soal_id)
    {
    	$userid = $this->session->userdata('id_user');
    	$data = array(
    		'userid' => $userid,
    		'paket_soal_id' => $paket_soal_id,
    		'soal_id'=> $soal_id,
    		'judul_page' => 'Mulai Ujian',
            'konten' => 'soal_siswa/mulai_ujian',
    	);
    	$this->load->view('v_index', $data);
    }

    public function aksi_mulai_ujian($paket_soal_id, $soal_id, $userid, $skor_id=null)
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$waktu_mulai = date('Y-m-d H:i:s');
    	//cek apakah ada soal yang belum selesai
    	if ($skor_id == null) {
    		$this->db->insert('skor', array('user_id'=>$userid,'paket_soal_id'=>$paket_soal_id,'waktu_mulai'=>$waktu_mulai,'status'=>0));
    		$insert_id = $this->db->insert_id();
    		redirect('app/soal_siswa/'.$soal_id.'/'.$paket_soal_id.'/'.$insert_id);

    	} else {

    		

    		//cek soal berikutnya

    		$sql = "
			  SELECT
					item_soal.soal_id 
				FROM
					item_soal,skor
				WHERE 
						item_soal.paket_soal_id=skor.paket_soal_id
						and
					 skor.paket_soal_id = '$paket_soal_id'
					 AND
					 skor.user_id='$userid'
					 and
					item_soal.soal_id  NOT IN (
					SELECT
						DISTINCT(skor_detail.soal_id)
					FROM
						skor_detail,
						skor 
					WHERE
					skor_detail.skor_id = skor.skor_id 
					AND skor.paket_soal_id='$paket_soal_id' and skor_detail.user_id='$userid')
			  ";

			//cek soal_id baru
			$cek_soal_id_bru = $this->db->query($sql);
			error_reporting(0);
			$soal_id_bru = $this->db->query($sql)->row()->soal_id;

			//cek apakah soal sudah tidak ada lagi
			if ($cek_soal_id_bru->num_rows() == 0) {
				$this->db->where('skor_id', $skor_id);
    			$this->db->update('skor', array('status'=> 1, 'waktu_selesai'=>$waktu_mulai));

    			//hapus akses batch ujian
    			$get_paket_soal_id = $this->db->get_where('skor', array('skor_id'=>$skor_id))->row()->paket_soal_id;
    			$get_batch_id = $this->db->get_where('paket_soal', array('paket_soal_id'=>$get_paket_soal_id))->row()->batch_id;
    			$get_id_x = $this->db->query("SELECT id_x FROM akses_batch where user_id='$userid' and paket_soal_id='$get_paket_soal_id' ")->row()->id_x;
    			// echo $skor_id.'<br>';
    			// echo $get_paket_soal_id.'<br>';
    			// echo $get_batch_id.'<br>';
    			// echo $userid.'<br>';
    			// echo $get_id_x.'<br>';
    			// exit;
    			$this->db->where('id_x', $get_id_x);
    			$this->db->delete('akses_batch');

				?>
				<script type="text/javascript">
					alert("Selamat anda telah menyelesaikan Ujian dengan baik");
					window.location="<?php echo base_url('app/ujian_selesai'); ?>"
				</script>
				<?php
				
			} else {
				// $this->db->insert('skor', array('user_id'=>$userid,'paket_soal_id'=>$paket_soal_id,'waktu_mulai'=>$waktu_mulai,'status'=>0));
    // 			$insert_id = $this->db->insert_id();
				redirect('app/soal_siswa/'.$soal_id_bru.'/'.$paket_soal_id.'/'.$skor_id);
			}
    	}
    }
    
    public function soal_siswa($soal_id)
    {
    	$rw_nm_soal = $this->db->query("SELECT a.soal,b.paket_soal  FROM soal as a, paket_soal as b, item_soal as c where c.paket_soal_id=b.paket_soal_id and c.soal_id=a.soal_id and c.soal_id='$soal_id' ")->row();
    	$nama_soal = $rw_nm_soal->soal.' - '.$rw_nm_soal->paket_soal;


    	$userid = $this->session->userdata('id_user');
    	$this->db->order_by('butir_soal_id', 'RANDOM');
    	$this->db->select('butir_soal_id');
    	$data = array(
    		'userid' => $userid,
    		'nama_soal' => $nama_soal,
    		'jumlah_soal' => $this->db->get_where('butir_soal',array('soal_id'=>$soal_id)),
    		'judul_page' => 'Soal Ujian',
            'konten' => 'soal_siswa/soal',
    	);
    	$this->load->view('v_index', $data);
    }


    
    public function simpan_jawaban($user_id, $skor_id, $soal_id, $butir_soal_id, $bobot)
    {
    	date_default_timezone_set('Asia/Jakarta');
    	$jawaban = $this->input->post('jawaban');
    	$cekjawaban = $this->db->get_where('skor_detail', array('user_id'=>$user_id,'soal_id'=>$soal_id,'butir_soal_id'=>$butir_soal_id));
    	if ($cekjawaban->num_rows() == 1) {
    		$data = array(
	    		'nilai' => $bobot,
	    		'jawaban' => $jawaban,
	    		'waktu' => date("Y-m-d H:i:s", mktime(date("H")+1, date("i"), date("s"), date("m"), date("d"), date("Y")))
	    	);
	    	$this->db->where('user_id', $user_id);
	    	$this->db->where('soal_id', $soal_id);
	    	$this->db->where('butir_soal_id', $butir_soal_id);
	    	$this->db->update('skor_detail', $data);
    	} elseif ($cekjawaban->num_rows() == 0) {
    		$data = array(
	    		'user_id' => $user_id,
	    		'skor_id' => $skor_id,
	    		'soal_id' => $soal_id,
	    		'butir_soal_id' => $butir_soal_id,
	    		'nilai' => $bobot,
	    		'jawaban' => $jawaban,
	    		'waktu' => date('Y-m-d H:i:s')
	    	);
	    	$this->db->insert('skor_detail', $data);
    	} 
    }

    public function rangking_siswa()
    {
    	$data = array(
    		'judul_page' => 'Rangking Siswa',
            'konten' => 'rangking_siswa',
    	);
    	$this->load->view('v_index', $data);
    }

    public function detail_rangking_siswa($batch_id)
    {
    	$data = array(
    		'judul_page' => 'Rangking Siswa',
            'konten' => 'detail_rangking_siswa',
    	);
    	$this->load->view('v_index', $data);
    }

    public function detail_nilai_ujian($skor_id, $user_id,$paket_soal_id)
    {
    	$data = array(
    		'skor_id'=>$skor_id,
    		'user_id'=>$user_id,
    		'paket_soal_id'=>$paket_soal_id,
    		'judul_page' => 'Detail Nilai Ujian Siswa',
            'konten' => 'detail_nilai_ujian',
    	);
    	$this->load->view('v_index', $data);
    }


    public function akses_batch($batch_id)
    {
    	if ($_POST) {
    		$userid = $this->input->post('userid');
    		$cekbatch = $this->db->get_where('akses_batch',array('user_id'=>$userid,'batch_id'=>$batch_id));
    		if ($cekbatch->num_rows() == 0) {
    			//select paket
    			$paket = $this->db->get_where('paket_soal', array('batch_id'=>$batch_id));
    			foreach ($paket->result() as $value) {
    				// echo $value->paket_soal_id;
    				$this->db->insert('akses_batch', array('user_id'=>$userid,'batch_id'=>$batch_id,'paket_soal_id'=>$value->paket_soal_id));
    			}

    			// exit;
    			
    			redirect('app/akses_batch/'.$batch_id,'refresh');
    		} else {
    			#tidak melakukan apapun
    		}
    	} else {
    		$data = array(
	    		'judul_page' => 'Akses Batch',
	            'konten' => 'batch/akses_batch',
	    	);
	    	$this->load->view('v_index', $data);
    	}
    }

    public function delete_akses_batch($user_id,$batch_id)
    {
    	$this->db->where('user_id', $user_id);
    	$this->db->delete('akses_batch');
    	redirect('app/akses_batch/'.$batch_id,'refresh');
    }

    public function ambil_soal_ujian($butir_soal_id, $no_soal)
    {
    	$select = "";
    	$user_id = $this->session->userdata('id_user');
    	$ambil = $this->db->get_where('butir_soal', array('butir_soal_id'=>$butir_soal_id))->row();
    	?>
    	<div style="font-size: 12pt; font-family: Arial">
    		<div  style="float: left; margin-right: 5px;">
    			<b><?php echo $no_soal ?>. </b>
    		</div>
    		<div>
    			<div>
		    		<?php echo $ambil->pertanyaan ?>
		    	</div><br>
		    	<div>
		    		<form>
		    			<?php 
		    			if ($ambil->jawaban1 == '') { } else {
		    				if (select_jawaban($butir_soal_id, $user_id) == filter_string($ambil->jawaban1)) {
		    					$select = "checked";
		    				} else {
		    					$select = "";
		    				}
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban1 ?>" value="<?php echo filter_string($ambil->jawaban1) ?>" butir_soal_id="<?php echo $butir_soal_id ?>" <?php echo $select ?>><?php echo $ambil->jawaban1 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban2 == '') { } else {
		    				if (select_jawaban($butir_soal_id, $user_id) == filter_string($ambil->jawaban2)) {
		    					$select = "checked";
		    				} else {
		    					$select = "";
		    				}
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban2 ?>" value="<?php echo filter_string($ambil->jawaban2) ?>" butir_soal_id="<?php echo $butir_soal_id ?>" <?php echo $select ?>><?php echo $ambil->jawaban2 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban3 == '') { } else {
		    				if (select_jawaban($butir_soal_id, $user_id) == filter_string($ambil->jawaban3)) {
		    					$select = "checked";
		    				} else {
		    					$select = "";
		    				}
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban3 ?>" value="<?php echo filter_string($ambil->jawaban3) ?>" butir_soal_id="<?php echo $butir_soal_id ?>" <?php echo $select ?>><?php echo $ambil->jawaban3 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban4 == '') { } else {
		    				if (select_jawaban($butir_soal_id, $user_id) == filter_string($ambil->jawaban4)) {
		    					$select = "checked";
		    				} else {
		    					$select = "";
		    				}
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban4 ?>" value="<?php echo filter_string($ambil->jawaban4) ?>" butir_soal_id="<?php echo $butir_soal_id ?>" <?php echo $select ?>><?php echo $ambil->jawaban4 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban5 == '') { } else {
		    				if (select_jawaban($butir_soal_id, $user_id) == filter_string($ambil->jawaban5)) {
		    					$select = "checked";
		    				} else {
		    					$select = "";
		    				}
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban5 ?>" value="<?php echo filter_string($ambil->jawaban5) ?>" butir_soal_id="<?php echo $butir_soal_id ?>" <?php echo $select ?>><?php echo $ambil->jawaban5 ?></label>
					    </div>
						<?php } ?>
						
					</form>
		    	</div>
    		</div>
    		<ul class="pager">
			    <!-- <li class="previous"><a style="cursor: pointer;" id="pager">Sebelumnya</a></li> -->
			    <!-- <li><label><input type="checkbox" id="ragu" value="">Ragu-ragu</label></li> -->
			    <!-- <li class="next"><a style="cursor: pointer;" id="">Selanjutnya</a></li> -->
			</ul>
    	</div>
    	
    	<?php
    }

    public function tambah_butir_soal($soal_id)
    {
    	if ($_POST == NULL) {
    		$data = array(
				'konten' => 'soal/tambah_butir_soal',
	            'judul_page' => 'Tambah Butir Soal',
			);
			$this->load->view('v_index', $data);
    	} else {

    		$_POST['soal_id'] = $soal_id;
    		// print_r($_POST); exit;
    		$this->db->insert('butir_soal', $_POST);
    		redirect('soal/detail_soal/'.$soal_id,'refresh');
    	}
    }

    public function ubah_butir_soal($butir_soal_id)
    {
    	if ($_POST == NULL) {
    		$data = array(
				'konten' => 'soal/ubah_butir_soal',
	            'judul_page' => 'Ubah Butir Soal',
			);
			$this->load->view('v_index', $data);
    	} else {
    		$this->db->where('butir_soal_id', $butir_soal_id);
    		$this->db->update('butir_soal', $_POST);
    		redirect('app/ubah_butir_soal/'.$butir_soal_id,'refresh');
    	}
    	
	}
	
	public function hapus_butir_soal($butir_soal_id,$soal_id)
    {
		$this->db->where('butir_soal_id',$butir_soal_id);
		$this->db->delete('butir_soal');
		redirect('soal/detail_soal/'.$soal_id,'refresh');
    	
    }

    function tinymce_upload() {
        /***************************************************
		   * Only these origins are allowed to upload images *
		   ***************************************************/
		  $accepted_origins = array("http://localhost", "http://192.168.100.6", "http://jualkoding.com", "https://ujian.catinstancy.co.id");

		  /*********************************************
		   * Change this line to set the upload folder *
		   *********************************************/
		  $imageFolder = "image/soal/";

		  reset ($_FILES);
		  $temp = current($_FILES);
		  if (is_uploaded_file($temp['tmp_name'])){
		    if (isset($_SERVER['HTTP_ORIGIN'])) {
		      // same-origin requests won't set an origin. If the origin is set, it must be valid.
		      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
		        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
		      } else {
		        header("HTTP/1.1 403 Origin Denied");
		        return;
		      }
		    }

		    /*
		      If your script needs to receive cookies, set images_upload_credentials : true in
		      the configuration and enable the following two headers.
		    */
		    // header('Access-Control-Allow-Credentials: true');
		    // header('P3P: CP="There is no P3P policy."');

		    // Sanitize input
		    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		        header("HTTP/1.1 400 Invalid file name.");
		        return;
		    }

		    // Verify extension
		    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png","jpeg"))) {
		        header("HTTP/1.1 400 Invalid extension.");
		        return;
		    }

		    // Accept upload if there was no origin, or if it is an accepted origin
		    $filetowrite = $imageFolder . $temp['name'];
		    move_uploaded_file($temp['tmp_name'], $filetowrite);

		    // Respond to the successful upload with JSON.
		    // Use a location key to specify the path to the saved image resource.
		    // { location : '/your/uploaded/image/file'}
		    echo json_encode(array('location' => $filetowrite));
		  } else {
		    // Notify editor that the upload failed
		    header("HTTP/1.1 500 Server Error");
		  }
	}
	
	public function simpan_soal_paket($paket_soal_id)
	{
		$soal_id = $_POST['soal'];
		$this->db->insert('item_soal',array('paket_soal_id'=>$paket_soal_id,'soal_id'=>$soal_id));
		redirect('paket_soal');
	}

	public function login() 
	{
	// {
	// 	$options = [
	// 		'cost' => 10,
	// 	];
		
	// 	echo password_hash("admin", PASSWORD_DEFAULT, $options);

		// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
 
		// if (password_verify('admin', $hashed)) {
		// 	echo '<br>Password is valid!';
		// } else {
		// 	echo 'Invalid password.';
		// }
		// exit;
		if ($this->input->post() == NULL) {
			$this->load->view('login');
		} else {
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
			$cek_user = $this->db->query("SELECT * FROM user WHERE username='$username' and password='$password' ");
			// if (password_verify($password, $hashed)) {
			if ($cek_user->num_rows() > 0) {
				foreach ($cek_user->result() as $row) {
					
                    $sess_data['id_user'] = $row->user_id;
					$sess_data['nama'] = $row->nama_lengkap;
					$sess_data['username'] = $row->username;
					$sess_data['level'] = $row->akses;
					$this->session->set_userdata($sess_data);
				}
				// print_r($this->session->userdata());
				// exit;
				// $sess_data['username'] = $username;
				// $this->session->set_userdata($sess_data);

				redirect('app/index');
			} else {
				?>
				<script type="text/javascript">
					alert('Username dan password kamu salah !');
					window.location="<?php echo base_url('app/login'); ?>";
				</script>
				<?php
			}

		}
	}

	public function detail_paket_soal($paket_soal_id, $user_id)
	{
		$data = array(
    		'judul_page' => 'Detail Paket Soal',
            'konten' => 'detail_paket_soal',
    	);
    	$this->load->view('v_index', $data);
	}

	public function detail_jawaban_soal($soal_id,$user_id)
	{
		$sql = "SELECT * FROM skor, skor_detail, butir_soal WHERE skor.skor_id=skor_detail.skor_id and skor.user_id=skor_detail.user_id 
and skor_detail.butir_soal_id=butir_soal.butir_soal_id and skor.user_id='$user_id' and skor_detail.soal_id='$soal_id'";
		$data = array(
			'data' => $this->db->query($sql),
			'soal_id' => $soal_id,
    		'judul_page' => 'Detail Jawaban',
            'konten' => 'detail_jawaban_soal',
    	);
    	$this->load->view('v_index', $data);
	}

	public function ujian_selesai()
	{
		$data = array(
    		'judul_page' => 'Ujian yang telah selesai',
            'konten' => 'ujian_selesai',
    	);
    	$this->load->view('v_index', $data);
	}

	public function reset_siswa()
	{
		$data = array(
    		'judul_page' => 'Reset Ujian Siswa',
            'konten' => 'reset_siswa',
    	);
    	$this->load->view('v_index', $data);
	}

	public function aksi_reset($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->delete('skor');
		$this->db->where('user_id', $user_id);
		$this->db->delete('skor_detail');
		$this->db->where('user_id', $user_id);
		$this->db->delete('akses_batch');
		?>
		<script type="text/javascript">
			alert("RESET UJIAN SISWA BERHASIL .!");
			window.location="<?php echo base_url() ?>app/reset_siswa";
		</script>
		<?php
	}

	public function update_profil()
	{
		$user_id = $this->session->userdata('id_user');
		if ($_POST) {
			$nama_lengkap = $this->input->post('nama_lengkap');
			$email = $this->input->post('email');
			$alamat = $this->input->post('alamat');
			$no_hp = $this->input->post('no_hp');
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));
			if ($password == '') {
				$this->db->where('user_id', $user_id);
				$this->db->update('user', array('nama_lengkap'=>$nama_lengkap,'email'=>$email, 'alamat'=>$alamat,'no_hp'=>$no_hp, 'username' => $username));
				redirect('app/update_profil','refresh');
			} else {
				$this->db->where('user_id', $user_id);
				$this->db->update('user', array('nama_lengkap'=>$nama_lengkap,'email'=>$email, 'alamat'=>$alamat,'no_hp'=>$no_hp, 'username' => $username,'password' => $password));
				redirect('app/update_profil','refresh');
			}
		} else {
			$data = array(
				'data' => $this->db->get_where('user',array('user_id'=>$user_id)),
	    		'judul_page' => 'Update Profil',
	            'konten' => 'update_profil',
	    	);
	    	$this->load->view('v_index', $data);
		}
	}

	function logout()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('app');
	}

	

	
}
