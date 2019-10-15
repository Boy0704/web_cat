<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mapel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mapel_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'mapel/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'mapel/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'mapel/index.html';
            $config['first_url'] = base_url() . 'mapel/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Mapel_model->total_rows($q);
        $mapel = $this->Mapel_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'mapel_data' => $mapel,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Mata Pelajaran',
            'konten' => 'mapel/mapel_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Mapel_model->get_by_id($id);
        if ($row) {
            $data = array(
		'mapel_id' => $row->mapel_id,
		'mapel' => $row->mapel,
		'mapel_kategori' => $row->mapel_kategori,
		'operator' => $row->operator,
		'nilai_lulus' => $row->nilai_lulus,
	    );
            $this->load->view('mapel/mapel_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mapel'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Mata Pelajaran',
            'konten' => 'mapel/mapel_form',
            'button' => 'Create',
            'action' => site_url('mapel/create_action'),
	    'mapel_id' => set_value('mapel_id'),
	    'mapel' => set_value('mapel'),
	    'mapel_kategori' => set_value('mapel_kategori'),
	    'operator' => set_value('operator'),
	    'nilai_lulus' => set_value('nilai_lulus'),
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
		'mapel' => $this->input->post('mapel',TRUE),
		'mapel_kategori' => $this->input->post('mapel_kategori',TRUE),
		'operator' => $this->input->post('operator',TRUE),
		'nilai_lulus' => $this->input->post('nilai_lulus',TRUE),
	    );

            $this->Mapel_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('mapel'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Mapel_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Mata Pelajaran',
                'konten' => 'mapel/mapel_form',
                'button' => 'Update',
                'action' => site_url('mapel/update_action'),
		'mapel_id' => set_value('mapel_id', $row->mapel_id),
		'mapel' => set_value('mapel', $row->mapel),
		'mapel_kategori' => set_value('mapel_kategori', $row->mapel_kategori),
		'operator' => set_value('operator', $row->operator),
		'nilai_lulus' => set_value('nilai_lulus', $row->nilai_lulus),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mapel'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('mapel_id', TRUE));
        } else {

            // print_r($_POST); exit();

            $data = array(
		'mapel' => $this->input->post('mapel',TRUE),
		'mapel_kategori' => $this->input->post('mapel_kategori',TRUE),
		'operator' => $this->input->post('operator',TRUE),
		'nilai_lulus' => $this->input->post('nilai_lulus',TRUE),
	    );

            $this->Mapel_model->update($this->input->post('mapel_id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('mapel'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Mapel_model->get_by_id($id);

        if ($row) {
            $this->Mapel_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('mapel'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('mapel'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('mapel', 'mapel', 'trim|required');
	$this->form_validation->set_rules('mapel_kategori', 'mapel kategori', 'trim|required');
	$this->form_validation->set_rules('operator', 'operator', 'trim|required');
	$this->form_validation->set_rules('nilai_lulus', 'nilai lulus', 'trim|required');

	$this->form_validation->set_rules('mapel_id', 'mapel_id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Mapel.php */
/* Location: ./application/controllers/Mapel.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2019-10-05 04:58:31 */
/* https://jualkoding.com */