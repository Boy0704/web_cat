<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'user/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'user/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'user/index.html';
            $config['first_url'] = base_url() . 'user/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->User_model->total_rows($q);
        $user = $this->User_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'user_data' => $user,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'user/user_list',
            'konten' => 'user/user_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->User_model->get_by_id($id);
        if ($row) {
            $data = array(
		'user_id' => $row->user_id,
		'nama_lengkap' => $row->nama_lengkap,
		'email' => $row->email,
		'alamat' => $row->alamat,
		'no_hp' => $row->no_hp,
		'username' => $row->username,
		'password' => $row->password,
		'akses' => $row->akses,
	    );
            $this->load->view('user/user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'user/user_form',
            'konten' => 'user/user_form',
            'button' => 'Create',
            'action' => site_url('user/create_action'),
	    'user_id' => set_value('user_id'),
	    'nama_lengkap' => set_value('nama_lengkap'),
	    'email' => set_value('email'),
	    'alamat' => set_value('alamat'),
	    'no_hp' => set_value('no_hp'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
	    'akses' => set_value('akses'),
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
		'alamat' => $this->input->post('alamat',TRUE),
		'no_hp' => $this->input->post('no_hp',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
		'akses' => $this->input->post('akses',TRUE),
	    );

            $this->User_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'user/user_form',
                'konten' => 'user/user_form',
                'button' => 'Update',
                'action' => site_url('user/update_action'),
		'user_id' => set_value('user_id', $row->user_id),
		'nama_lengkap' => set_value('nama_lengkap', $row->nama_lengkap),
		'email' => set_value('email', $row->email),
		'alamat' => set_value('alamat', $row->alamat),
		'no_hp' => set_value('no_hp', $row->no_hp),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
		'akses' => set_value('akses', $row->akses),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('user_id', TRUE));
        } else {
            $data = array(
		'nama_lengkap' => $this->input->post('nama_lengkap',TRUE),
		'email' => $this->input->post('email',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'no_hp' => $this->input->post('no_hp',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
		'akses' => $this->input->post('akses',TRUE),
	    );

            $this->User_model->update($this->input->post('user_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('user'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $this->User_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('no_hp', 'no hp', 'trim|required');
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
	$this->form_validation->set_rules('akses', 'akses', 'trim|required');

	$this->form_validation->set_rules('user_id', 'user_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-06 04:36:30 */
/* https://jualkoding.com */