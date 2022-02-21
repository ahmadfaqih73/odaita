<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model"); 
        $this->load->library('form_validation');
        $this->load->model("user_model");
        if($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
        
        
    }

    public function index()
    {
        $data["users"] = $this->user_model->getAll();
        $this->load->view("admin/user/list", $data);
    }

    public function add()
    {
        $user = $this->user_model; 
        $validation = $this->form_validation;
        $validation->set_rules($user->rules());

        if ($validation->run()) {
            $user->save();
            $this->session->set_flashdata('success', 'Berhasil disimpan');
        }

        $this->load->view("admin/registrasi");
    }

    public function edit($id = null)
    {
        if (!isset($id)) redirect('admin/users'); 
        $user = $this->user_model;
 
        $data["user"] = $user->getById($id);
        if (!$data["user"]) show_404();
        
        $this->load->view("admin/user/edit_form", $data);
    }

    public function edit_data()
    {
        $user = $this->user_model;
        $user->update();
        $this->session->set_flashdata('success', 'Data berhasil Diedit');

        redirect('admin/Users');
    }

    public function delete($id=null)
    {
        if (!isset($id)) show_404();
        
        if ($this->user_model->delete($id)) {
            redirect(site_url('admin/users')); 
        }
        
        
        
    }
}