<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model
{
    private $_table = "pernyataan";

    public $user_id;
    public $kode_kriteria;
    public $dimensi;
    public $pernyataan; 
    public $persepsi;
   

    public function rules()
    {
        return [
            ['field' => 'kode_kriteria',
            'label' => 'Kode_kriteria',
            'rules' => 'required'],

            ['field' => 'dimensi',
            'label' => 'Dimensi',
            'rules' => 'required'],

            ['field' => 'pernyataan',
            'label' => 'Pernyataan',
            'rules' => 'required'],

            ['field' => 'persepsi',
            'label' => 'Persepsi',
            'rules' => 'required'],
            
           
        ];
    }

    public function get_customer()
    {
        // return $this->db->get($this->_table)->result();
        // return $this->db->get_where('pernyataan', array('id_dimensi' => '1'));
        return $this->db->get_where($this->_table, ["id_dimensi" => '1'])->result();
    }

    public function get_reliability()
    {
        return $this->db->get_where($this->_table, ["id_dimensi" => '2'])->result();
    }
    public function get_responsivenes()
    {
        return $this->db->get_where($this->_table, ["id_dimensi" => '3'])->result();
    }
    public function get_assurance()
    {
        return $this->db->get_where($this->_table, ["id_dimensi" => '4'])->result();
    }
    public function get_emphaty()
    {
        return $this->db->get_where($this->_table, ["id_dimensi" => '5'])->result();
    }
    


    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }



    public function save()
    {
        $post = $this->input->post();
        
        $this->username = $post["username"];
        $this->nama_lengkap = $post["nama_lengkap"];
        $this->email = $post["email"];
        $this->password = $post["password"];
        $this->alamat = $post["alamat"];
        $this->jenis_kelamin = $post["jenis_kelamin"];
        $this->phone = $post["phone"]; 
        return $this->db->insert($this->_table, $this);
    }

    public function update()
    {
        $post = $this->input->post();
        $this->id_dimensi = $post["id_dimensi"];
        $this->kode_kriteria = $post["kode_kriteria"];
        $this->pernyataan = $post["pernyataan"];
   
        return $this->db->update($this->_table, $this, array('id' => $post['id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("id" => $id));
    }


    

    public function doLogin(){
		$post = $this->input->post();

        // cari user berdasarkan email dan username
        $this->db->where('email', $post["email"])
                ->or_where('username', $post["email"]);
        $user = $this->db->get($this->_table)->row();

        // jika user terdaftar
        if($user){
            // // periksa password-nya
            // $isPasswordTrue = password_verify($post["password"], $user->password);
            // periksa role-nya
            $isAdmin = $user->role == "admin";

            // jika password benar dan dia admin
            if( $isAdmin){ 
                // login sukses yay!
                $this->session->set_userdata(['user_logged' => $user]);
                $this->_updateLastLogin($user->user_id);
                return true;
            }
        }
        
        // login gagal
		return false;
    }

    public function isNotLogin(){
        return $this->session->userdata('user_logged') === null;
    }

    private function _updateLastLogin($user_id){
        $sql = "UPDATE {$this->_table} SET last_login=now() WHERE user_id={$user_id}";
        $this->db->query($sql);
    }


}

