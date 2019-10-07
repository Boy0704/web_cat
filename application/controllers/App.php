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
    	$userid = 1;
    	$data = array(
    		'userid' => $userid,
    		'query' => $this->db->get('batch'),
    		'judul_page' => 'List Batch',
            'konten' => 'soal_siswa/list_batch',
    	);
    	$this->load->view('v_index', $data);
    }

    public function paket_soal($batch_id)
    {
    	$userid = 1;
    	$data = array(
    		'userid' => $userid,
    		'query' => $this->db->get_where('paket_soal', array('batch_id'=>base64_decode($batch_id))),
    		'judul_page' => 'Paket Soal',
            'konten' => 'soal_siswa/paket_soal',
    	);
    	$this->load->view('v_index', $data);
    }

    public function list_soal($paket_soal_id)
    {
    	$userid = 1;
    	$paket_soal_id = base64_decode($paket_soal_id);
    	$data = array(
    		'userid' => $userid,
    		'query' => $this->db->query("SELECT soal.soal,soal.soal_id FROM item_soal,soal where item_soal.soal_id=soal.soal_id and item_soal.paket_soal_id='$paket_soal_id' "),
    		'judul_page' => 'List Soal',
            'konten' => 'soal_siswa/list_soal',
    	);
    	$this->load->view('v_index', $data);
    }
    
    public function soal_siswa($soal_id)
    {
    	$userid = 1;
    	$this->db->order_by('butir_soal_id', 'RANDOM');
    	$this->db->select('butir_soal_id');
    	$data = array(
    		'userid' => $userid,
    		'jumlah_soal' => $this->db->get_where('butir_soal',array('soal_id'=>$soal_id)),
    		'judul_page' => 'Soal Ujian',
            'konten' => 'soal_siswa/soal',
    	);
    	$this->load->view('v_index', $data);
    }

    public function ambil_soal_ujian($butir_soal_id, $no_soal)
    {
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
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban1 ?>" ><?php echo $ambil->jawaban1 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban2 == '') { } else {
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban2 ?>" ><?php echo $ambil->jawaban2 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban3 == '') { } else {
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban3 ?>" ><?php echo $ambil->jawaban3 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban4 == '') { } else {
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban4 ?>" ><?php echo $ambil->jawaban4 ?></label>
					    </div>
						<?php } ?>
						<?php 
		    			if ($ambil->jawaban5 == '') { } else {
		    			?>
		    			<div class="radio">
					      <label><input type="radio" name="jwb" nilai="<?php echo $ambil->bobot_jawaban5 ?>" ><?php echo $ambil->jawaban5 ?></label>
					    </div>
						<?php } ?>
						
					</form>
		    	</div>
    		</div>
    	</div>
    	
    	<?php
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
