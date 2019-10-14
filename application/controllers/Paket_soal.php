<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_soal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_soal_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'paket_soal/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'paket_soal/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'paket_soal/index.html';
            $config['first_url'] = base_url() . 'paket_soal/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Paket_soal_model->total_rows($q);
        $paket_soal = $this->Paket_soal_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'paket_soal_data' => $paket_soal,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Paket Soal',
            'konten' => 'paket_soal/paket_soal_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Paket_soal_model->get_by_id($id);
        if ($row) {
            $data = array(
		'paket_soal_id' => $row->paket_soal_id,
		'paket_soal' => $row->paket_soal,
		'batch_id' => $row->batch_id,
		'user_id_tambah' => $row->user_id_tambah,
		'waktu_tambah' => $row->waktu_tambah,
		'user_id_ubah' => $row->user_id_ubah,
		'waktu_ubah' => $row->waktu_ubah,
		'status_paket' => $row->status_paket,
	    );
            $this->load->view('paket_soal/paket_soal_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_soal'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Paket Soal',
            'konten' => 'paket_soal/paket_soal_form',
            'button' => 'Create',
            'action' => site_url('paket_soal/create_action'),
	    'paket_soal_id' => set_value('paket_soal_id'),
	    'paket_soal' => set_value('paket_soal'),
	    'batch_id' => set_value('batch_id'),
	    // 'user_id_tambah' => set_value('user_id_tambah'),
	    // 'waktu_tambah' => set_value('waktu_tambah'),
	    // 'user_id_ubah' => set_value('user_id_ubah'),
	    // 'waktu_ubah' => set_value('waktu_ubah'),
	    'status_paket' => set_value('status_paket'),
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
		'paket_soal' => $this->input->post('paket_soal',TRUE),
		'batch_id' => $this->input->post('batch_id',TRUE),
		// 'user_id_tambah' => $this->input->post('user_id_tambah',TRUE),
		// 'waktu_tambah' => $this->input->post('waktu_tambah',TRUE),
		// 'user_id_ubah' => $this->input->post('user_id_ubah',TRUE),
		// 'waktu_ubah' => $this->input->post('waktu_ubah',TRUE),
		'status_paket' => $this->input->post('status_paket',TRUE),
	    );

            $this->Paket_soal_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('paket_soal'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Paket_soal_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Paket Soal',
                'konten' => 'paket_soal/paket_soal_form',
                'button' => 'Update',
                'action' => site_url('paket_soal/update_action'),
		'paket_soal_id' => set_value('paket_soal_id', $row->paket_soal_id),
		'paket_soal' => set_value('paket_soal', $row->paket_soal),
		'batch_id' => set_value('batch_id', $row->batch_id),
		// 'user_id_tambah' => set_value('user_id_tambah', $row->user_id_tambah),
		// 'waktu_tambah' => set_value('waktu_tambah', $row->waktu_tambah),
		// 'user_id_ubah' => set_value('user_id_ubah', $row->user_id_ubah),
		// 'waktu_ubah' => set_value('waktu_ubah', $row->waktu_ubah),
		'status_paket' => set_value('status_paket', $row->status_paket),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_soal'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('paket_soal_id', TRUE));
        } else {
            $data = array(
		'paket_soal' => $this->input->post('paket_soal',TRUE),
		'batch_id' => $this->input->post('batch_id',TRUE),
		'user_id_tambah' => $this->input->post('user_id_tambah',TRUE),
		'waktu_tambah' => $this->input->post('waktu_tambah',TRUE),
		'user_id_ubah' => $this->input->post('user_id_ubah',TRUE),
		'waktu_ubah' => $this->input->post('waktu_ubah',TRUE),
		'status_paket' => $this->input->post('status_paket',TRUE),
	    );

            $this->Paket_soal_model->update($this->input->post('paket_soal_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('paket_soal'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Paket_soal_model->get_by_id($id);

        if ($row) {
            $this->Paket_soal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('paket_soal'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_soal'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('paket_soal', 'paket soal', 'trim|required');
	$this->form_validation->set_rules('batch_id', 'batch id', 'trim|required');
	// $this->form_validation->set_rules('user_id_tambah', 'user id tambah', 'trim|required');
	// $this->form_validation->set_rules('waktu_tambah', 'waktu tambah', 'trim|required');
	// $this->form_validation->set_rules('user_id_ubah', 'user id ubah', 'trim|required');
	// $this->form_validation->set_rules('waktu_ubah', 'waktu ubah', 'trim|required');
	$this->form_validation->set_rules('status_paket', 'status paket', 'trim|required');

	$this->form_validation->set_rules('paket_soal_id', 'paket_soal_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Paket_soal.php */
/* Location: ./application/controllers/Paket_soal.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-14 13:20:42 */
/* https://jualkoding.com */