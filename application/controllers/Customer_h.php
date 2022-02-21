<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_h extends CI_Controller {

	
		public function __construct()
		{
			parent::__construct();
			$this->load->model("customer_model");
			if($this->customer_model->isNotLogin()) redirect(site_url('admin/login'));
		}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->db->join('dimensi','dimensi.id_dimensi=pernyataan.id_dimensi');
		$data['pernyataan']=$this->db->get('pernyataan')->result();
		$this->load->view('pages/customer',$data);
	}

	public function addQuisioner()
	{
		$post=$this->input->post();
		//$code=rand();
		$code = date("ymdhis").$this->session->userdata('userId');
		for($i=0;$i<sizeof($post['id_pernyataan']);$i++){
			$kepuasan=$_POST['kepuasan'.$i];
			$id_dimensi=$_POST['id_dimensi'.$i];

			$data=[
				'id_pernyataan'=>$post['id_pernyataan'][$i],
				'user_id'=>$this->session->userdata('userId'),
				'id_dimensi'=>$id_dimensi,
				'kepuasan'=>$kepuasan,
				'created_at'=>date('Y-m-d H:i:s'),
				'code_quisioner'=>$code,
				'jenis'=>'Harapan'
			];

			$qry= $this->db->insert('kuisioner',$data);
		}

		$dataJawaban=[
			'user_id'=>$this->session->userdata('userId'),
			'tanggal'=>date('Y-m-d H:i:s'),
			'kritik'=>$post['kritik'],
			'code_quisioner'=>$code
		];
		$this->db->insert('jawaban',$dataJawaban);

		$this->session->set_flashdata('success','<div class="alert alert-success" role="alert">
		Terimakasih sudah mengisi kuisioner
	  </div>');
		redirect('customer_h');
	}

}
