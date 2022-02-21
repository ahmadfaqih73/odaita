<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Hasil_model"); ////?????????????
        $this->load->library('form_validation');
        $this->load->model("user_model");
        if($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
        
        
    }

    public function index()
    {   
        
        $data['kriteria']=$this->db->get('pernyataan')->result();
        $data["jawaban"] = $this->Hasil_model->jawaban();
        $this->load->view("admin/hasil/list", $data);
    }

    public function add()
    {
        $this->load->view("admin/kuisioner/new_form");
    }

    public function store()
    {
        $post=$this->input->post(); 
        $data=[
            'id_jawaban'=>$post["id_jawaban"],
            'username'=>$post["username"],
            'tanggal'=>$post["tanggal"],
            'kritik'=>$post["kritik"],
            'kritik'=>$post["Harapan"],
            'kritik'=>$post["Persepsi"],
        ] ;

        $qry=$this->db->insert('jawaban',$data);

        if($qry){
            $this->session->set_flashdata('success', 'Tambah data berhasil');
            redirect('admin/Kuisioner');
        }

    

    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('admin/kuisioner'); //???????????
       
        $jawaban = $this->jawaban_model;
        $validation = $this->form_validation;
        $validation->set_rules($jawaban->rules());

        if ($validation->run()) {
            $jawaban->update();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }

        $data["jawaban"] = $jawaban->getById($id);
        if (!$data["jawaban"]) show_404();
        
        $this->load->view("admin/kuisioner/edit_form", $data);
    }

    public function delete($id=null)
    {
        if (!isset($id)) show_404();
        
        if ($this->jawaban_model->delete($id)) {
            redirect(site_url('admin/jawaban')); //?????????/
        }
        
        
        
    }
}