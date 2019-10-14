<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Siswa_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'siswa/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'siswa/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'siswa/index.html';
            $config['first_url'] = base_url() . 'siswa/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Siswa_model->total_rows($q);
        $siswa = $this->Siswa_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'siswa_data' => $siswa,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Data Siswa',
            'konten' => 'siswa/siswa_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Siswa_model->get_by_id($id);
        if ($row) {
            $data = array(
		'user_id' => $row->user_id,
		'nama_lengkap' => $row->nama_lengkap,
		'email' => $row->email,
		'no_hp' => $row->no_hp,
		'alamat' => $row->alamat,
		'username' => $row->username,
		'password' => $row->password,
	    );
            $this->load->view('siswa/siswa_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Data Siswa',
            'konten' => 'siswa/siswa_form',
            'button' => 'Create',
            'action' => site_url('siswa/create_action'),
	    'user_id' => set_value('user_id'),
	    'nama_lengkap' => set_value('nama_lengkap'),
	    'email' => set_value('email'),
	    'no_hp' => set_value('no_hp'),
	    'alamat' => set_value('alamat'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
		'email' => $this->input->post('email',TRUE),
		'no_hp' => $this->input->post('no_hp',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'username' => $this->input->post('username',TRUE),
        'password' => md5($this->input->post('password',TRUE)),
		'akses' => 'siswa',
	    );

            $this->Siswa_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('siswa'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Siswa_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Data Siswa',
                'konten' => 'siswa/siswa_form',
                'button' => 'Update',
                'action' => site_url('siswa/update_action'),
		'user_id' => set_value('user_id', $row->user_id),
		'nama_lengkap' => set_value('nama_lengkap', $row->nama_lengkap),
		'email' => set_value('email', $row->email),
		'no_hp' => set_value('no_hp', $row->no_hp),
		'alamat' => set_value('alamat', $row->alamat),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_siswa', TRUE));
        } else {
            $data = array(
		'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
		'email' => $this->input->post('email',TRUE),
		'no_hp' => $this->input->post('no_hp',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
	    );

            $this->Siswa_model->update($this->input->post('user_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('siswa'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Siswa_model->get_by_id($id);

        if ($row) {
            $this->Siswa_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('siswa'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('siswa'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('no_hp', 'no hp', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');

	$this->form_validation->set_rules('user_id', 'user_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Siswa.php */
/* Location: ./application/controllers/Siswa.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-03 05:05:17 */
/* https://jualkoding.com */