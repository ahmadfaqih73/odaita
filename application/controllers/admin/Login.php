<?php


class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->library('form_validation');
    }

    public function index()
    {
        // tampilkan halaman login
        $this->load->model("user_model");
        if ($this->user_model->isNotLogin()) {
            $this->load->view("admin/login_page.php");
            if ($this->input->post()) {
                if ($this->user_model->doLogin()){
                    if($this->session->userdata('role')=='admin'){
                        redirect(site_url('index.php'));
                    } else{
                        redirect('customer_h');
                    }
                };
            }
        } else {
            redirect(site_url('index.php'));
        }
        // // jika form login disubmit


        // }


    }

    public function logout()
    {
        // hancurkan semua sesi
        $this->session->sess_destroy();
        redirect(site_url('admin/login'));
    }
}
