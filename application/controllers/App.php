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
			$password = $this->input->post('password');

			$hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';
			//$cek_user = $this->db->query("SELECT * FROM users WHERE username='$username' and password='$password' ");
			if (password_verify($password, $hashed)) {
				// foreach ($cek_user->result() as $row) {
					
                //     if ($row->level == 'dokter') {
				// 		$d = $this->db->get_where('dokter', array('id_dokter'=>$row->id_x))->row();
						
                //         $sess_data['nama'] = $d->nama_lengkap;
                //         $sess_data['foto'] = $d->foto;
                //     } else if ($row->level == 'pasien') {
                //         $d = $this->db->get_where('pasien', array('id_pasien'=>$row->id_x))->row();
                //         $sess_data['nama'] = $d->nama_lengkap;
                //         $sess_data['foto'] = $d->foto;
                //     }

				// 	$sess_data['id_user'] = $row->id_user;
				// 	$sess_data['username'] = $row->username;
				// 	$sess_data['level'] = $row->level;
				// 	$this->session->set_userdata($sess_data);
				// }
				// print_r($this->session->userdata());
				// exit;
				$sess_data['username'] = $username;
				$this->session->set_userdata($sess_data);

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
		$this->session->unset_userdata('kode_pelanggan');
		session_destroy();
		redirect('app');
	}

	function logout_admin()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('foto');
		session_destroy();
		redirect('app/login');
	}

	
}
