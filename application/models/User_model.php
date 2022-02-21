<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $_table = "users";

    public $user_id;
    public $username;
    public $nama_lengkap;
    public $email;
    
    public $password;
    public $alamat;
    public $jenis_kelamin;
    public $phone;

    public function rules()
    {
        return [
            ['field' => 'username',
            'label' => 'Username',
            'rules' => 'required'],

            ['field' => 'nama_lengkap',
            'label' => 'Nama_lengkap',
            'rules' => 'required'],

            ['field' => 'email',
            'label' => 'Email',
            'rules' => 'required'],

            ['field' => 'password',
            'label' => 'Password',
            'rules' => 'required'],
            
            ['field' => 'alamat',
            'label' => 'Alamat',
            'rules' => 'required'],

            ['field'=> 'jenis_kelamin',
            'label' => 'Jenis_kelamin',
            'rules' => 'required'],

            ['field' => 'phone',
            'label' => 'Phone',
            'rules' => 'numeric']
        ];
    }

    public function getAll()
    {
        return $this->db->get($this->_table)->result();
    }
    
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["user_id" => $id])->row();
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
        $this->user_id= $post["user_id"];
        $this->username = $post["username"];
        $this->nama_lengkap = $post["nama_lengkap"];
        $this->email = $post["email"];
        $this->password = $post["password"];
        $this->alamat = $post["alamat"];
        $this->jenis_kelamin = $post["jenis_kelamin"];
        $this->phone = $post["phone"];
        return $this->db->update($this->_table, $this, array('user_id' => $post['user_id']));
    }

    public function delete($id)
    {
        return $this->db->delete($this->_table, array("user_id" => $id));
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
                // login sukses !
                $this->session->set_userdata(['user_logged' => $user]);
                $this->session->set_userdata(['role' => 'admin']);
                $this->session->set_userdata(['userId' => $user->user_id]);
                $this->session->set_userdata(['username' => $user->username]);
                $this->_updateLastLogin($user->user_id);
                return true;
            }else{
                $this->session->set_userdata(['user_logged' => $user]);
                $this->session->set_userdata(['role' => 'user']);
                $this->session->set_userdata(['userId' => $user->user_id]);
                $this->session->set_userdata(['username' => $user->username]);
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

