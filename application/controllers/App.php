<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	
	public function index()
	{
        if ($this->session->userdata('id_user') == '') {
            redirect('app/login');
        }
		$data = array(
			'konten' => 'home',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }
    
    public function konsultasi()
	{
		$data = array(
			'konten' => 'konsultasi',
            'judul_page' => 'Konsultasi',
		);
		$this->load->view('v_index', $data);
    }
    
    public function cek_jantung()
	{
		$data = array(
			'konten' => 'cek_jantung',
            'judul_page' => 'Cek Jantung',
		);
		$this->load->view('v_index', $data);
    }
    
    public function profil()
	{
		$data = array(
			'konten' => 'profil',
            'judul_page' => 'Profil User',
		);
		$this->load->view('v_index', $data);
    }
	

	public function login()
	{
		if ($this->input->post() == NULL) {
			$this->load->view('login');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$cek_user = $this->db->query("SELECT * FROM users WHERE username='$username' and password='$password' ");
			if ($cek_user->num_rows() == 1) {
				foreach ($cek_user->result() as $row) {
					
                    if ($row->level == 'dokter') {
						$d = $this->db->get_where('dokter', array('id_dokter'=>$row->id_x))->row();
						
                        $sess_data['nama'] = $d->nama_lengkap;
                        $sess_data['foto'] = $d->foto;
                    } else if ($row->level == 'pasien') {
                        $d = $this->db->get_where('pasien', array('id_pasien'=>$row->id_x))->row();
                        $sess_data['nama'] = $d->nama_lengkap;
                        $sess_data['foto'] = $d->foto;
                    }

					$sess_data['id_user'] = $row->id_user;
					$sess_data['username'] = $row->username;
					$sess_data['level'] = $row->level;
					$this->session->set_userdata($sess_data);
				}
				// print_r($this->session->userdata());
				// exit;
				redirect('app/profil');
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
