<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_model extends CI_Model
{
    private $_table = "jawaban";
    
    public $id_jawaban;
    public $user_id;
    public $tanggal;
    public $kritik;
    
    public $list_jawaban;
  


    public function rules()
    {
        return
        [

            ['field' => 'id_jawaban',
            'label' => 'Id_jawaban',
            'rules' => 'required'],

            ['field' => 'username',
            'label' => 'Username',
            'rules' => 'required'],

            ['field' => 'tanggal',
            'label' => 'Tanggal',
            'rules' => 'required'],
            

            ['field' => 'kritik',
            'label' => 'Kritik',
            'rules' => 'required'],

            ['field' => 'code_quisioner',
            'label' => 'Code Kuisioner',
            'rules' => 'required'],

            ['field' => 'nilai',
            'label' => 'Nilai',
            'rules' => 'required'],

            ['field' => 'hasil',
            'label' => 'Hasil',
            'rules' => 'required'],

            
        ];
    }

    
   

    public function jawaban()
    {
       // $this->db->select('*');
        //$this->db->from('jawaban');
        //$this->db->join('users', 'users.user_id = jawaban.user_id');
        $queryRender = $this->db->query("
        SELECT
        j.id_jawaban,
        u.username,
        j.tanggal,
        j.kritik,
        j.code_quisioner,
        CASE WHEN NOT kh.avr IS NULL THEN kh.avr ELSE 0 END AS 'Harapan',
        CASE WHEN NOT kp.avr IS NULL THEN kp.avr ELSE 0 END AS 'Persepsi',
        j.nilai,
        j.hasil

        FROM
        jawaban j 
        INNER JOIN users u ON j.user_id = u.user_id
        LEFT OUTER JOIN 
        (
            SELECT
            code_quisioner as id,SUM(b.skor) / COUNT(b.skor) as avr
            FROM
          
            kuisioner a
            INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
        
            WHERE a.jenis = 'Harapan'
        
            GROUP BY code_quisioner
            
        )kh ON kh.id = j.code_quisioner
        
        
        LEFT OUTER JOIN 
        (
            SELECT
            code_quisioner as id,SUM(b.skor) / COUNT(b.skor) as avr
            FROM
          
            kuisioner a
            INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
        
            WHERE a.jenis = 'Persepsi'
        
            GROUP BY code_quisioner
            
        )kp ON kp.id = j.code_quisioner
        ");
        return $queryRender->result();
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
        $this->jawaban = $post["jawaban"];
   
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

