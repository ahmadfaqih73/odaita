<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assurance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("pernyataan_model");
        $this->load->library('form_validation');
        $this->load->model("user_model");
        if($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
        
        
    }

    public function index()
    {
        // $data["users"] = $this->user_model->getAll();
        $data["pernyataan"] = $this->pernyataan_model->get_assurance();
        $this->load->view("admin/assurance/list", $data);
    }

    public function add()
    {
        $this->load->view("admin/assurance/new_form");
    }

    public function store(){
        $post=$this->input->post(); 
        $data=[
            'id_dimensi'=>$post["id_dimensi"],
            'kode_kriteria'=>$post["kode_kriteria"],
            'pernyataan'=>$post["pernyataan"],
        ] ;

        $qry=$this->db->insert('pernyataan',$data);

        if($qry){
            $this->session->set_flashdata('success', 'Tambah data berhasil');
            redirect('admin/Assurance');
        }

    

    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('admin/assurance'); //???????????    
        $pernyataan = $this->pernyataan_model;
 
        $data["pernyataan"] = $pernyataan->getById($id);
        if (!$data["pernyataan"]) show_404();
        
        $this->load->view("admin/assurance/edit", $data);
    }

    public function edit_data($id = null)
    {
        $pernyataan = $this->pernyataan_model;
        $pernyataan->update();
        -$this->session->set_flashdata('success', 'Data berhasil Diedit');

        redirect('admin/Assurance');
    }

    public function delete($id=null)
    {
        if (!isset($id)) show_404();
        
        if ($this->pernyataan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus');
            redirect(site_url('admin/assurance')); 
        }
        
        
        
    }
}