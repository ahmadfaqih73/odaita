<?php


class Registration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model("user_model");
        // $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('admin/registrasi');
    }

    public function store(){
        $post=$this->input->post(); 
        $data=[
            'username'=>$post["username"],
            'nama_lengkap'=>$post["nama_lengkap"],
            'email '=>$post["email"],
            'password'=>$post["password"],
            'alamat'=>$post["alamat"],
            'jenis_kelamin '=>$post["jenis_kelamin"],
            'phone'=>$post["phone"]
        ] ;

        $qry=$this->db->insert('users',$data);

        if($qry){
            $this->session->set_flashdata('success', 'Registrasi berhasil');
            redirect('admin/login');
        }

    

    }
}
