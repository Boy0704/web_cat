<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaturan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'pengaturan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'pengaturan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'pengaturan/index.html';
            $config['first_url'] = base_url() . 'pengaturan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Pengaturan_model->total_rows($q);
        $pengaturan = $this->Pengaturan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pengaturan_data' => $pengaturan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Pengaturan Aplikasi',
            'konten' => 'pengaturan/pengaturan_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Pengaturan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'pengaturan_id' => $row->pengaturan_id,
		'pengaturan' => $row->pengaturan,
	    );
            $this->load->view('pengaturan/pengaturan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengaturan'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Pengaturan Aplikasi',
            'konten' => 'pengaturan/pengaturan_form',
            'button' => 'Create',
            'action' => site_url('pengaturan/create_action'),
	    'pengaturan_id' => set_value('pengaturan_id'),
	    'pengaturan' => set_value('pengaturan'),
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
		'pengaturan' => $this->input->post('pengaturan',TRUE),
	    );

            $this->Pengaturan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pengaturan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Pengaturan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Pengaturan Aplikasi',
                'konten' => 'pengaturan/pengaturan_form',
                'button' => 'Update',
                'action' => site_url('pengaturan/update_action'),
		'pengaturan_id' => set_value('pengaturan_id', $row->pengaturan_id),
		'pengaturan' => set_value('pengaturan', $row->pengaturan),
	    );
            $this->load->view(v_index, $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengaturan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('pengaturan_id', TRUE));
        } else {
            $data = array(
		'pengaturan' => $this->input->post('pengaturan',TRUE),
	    );

            $this->Pengaturan_model->update($this->input->post('pengaturan_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pengaturan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Pengaturan_model->get_by_id($id);

        if ($row) {
            $this->Pengaturan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pengaturan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pengaturan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('pengaturan', 'pengaturan', 'trim|required');

	$this->form_validation->set_rules('pengaturan_id', 'pengaturan_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Pengaturan.php */
/* Location: ./application/controllers/Pengaturan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-05 04:49:32 */
/* https://jualkoding.com */