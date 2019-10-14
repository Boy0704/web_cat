<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Soal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Soal_model');
        $this->load->library('form_validation');
    }

    public function detail_soal($soal_id)
    {
        $data = array(
            'konten' => 'soal/detail_soal',
            'judul_page' => 'Detail Soal',
        );
        $this->load->view('v_index', $data);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'soal/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'soal/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'soal/index.html';
            $config['first_url'] = base_url() . 'soal/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Soal_model->total_rows($q);
        $soal = $this->Soal_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'soal_data' => $soal,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Daftar Soal',
            'konten' => 'soal/soal_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Soal_model->get_by_id($id);
        if ($row) {
            $data = array(
		'soal_id' => $row->soal_id,
		'mapel_id' => $row->mapel_id,
		'soal' => $row->soal,
	    );
            $this->load->view('soal/soal_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('soal'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Daftar Soal',
            'konten' => 'soal/soal_form',
            'button' => 'Create',
            'action' => site_url('soal/create_action'),
	    'soal_id' => set_value('soal_id'),
	    'mapel_id' => set_value('mapel_id'),
	    'soal' => set_value('soal'),
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
		'mapel_id' => $this->input->post('mapel_id',TRUE),
		'soal' => $this->input->post('soal',TRUE),
	    );

            $this->Soal_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('soal'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Soal_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Daftar Soal',
                'konten' => 'soal/soal_form',
                'button' => 'Update',
                'action' => site_url('soal/update_action'),
		'soal_id' => set_value('soal_id', $row->soal_id),
		'mapel_id' => set_value('mapel_id', $row->mapel_id),
		'soal' => set_value('soal', $row->soal),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('soal'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('soal_id', TRUE));
        } else {
            $data = array(
		'mapel_id' => $this->input->post('mapel_id',TRUE),
		'soal' => $this->input->post('soal',TRUE),
	    );

            $this->Soal_model->update($this->input->post('soal_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('soal'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Soal_model->get_by_id($id);

        if ($row) {
            $this->Soal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('soal'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('soal'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('mapel_id', 'mapel id', 'trim|required');
	$this->form_validation->set_rules('soal', 'soal', 'trim|required');

	$this->form_validation->set_rules('soal_id', 'soal_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Soal.php */
/* Location: ./application/controllers/Soal.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-14 13:53:34 */
/* https://jualkoding.com */