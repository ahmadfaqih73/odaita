<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Fuzzy extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("pernyataan_model");
        $this->load->library('form_validation');
        $this->load->model("user_model");
        if ($this->user_model->isNotLogin()) redirect(site_url('admin/login'));
    }

    public function index()
    {
    }

    public function keanggotaan()
    {


        $data['kepuasan'] = $this->db->get('kepuasan')->result();
        $data['keanggotaan'] = $this->db->get('tb_keanggotaan')->result();
        $this->load->view('admin/fuzzy/indexKeanggotaan', $data);
    }

    public function perhitungan($code_quisioner)
    {


        $data['kepuasan'] = $this->db->get('kepuasan')->result();
        $data['perhitungan'] = $this->db->get('tb_keanggotaan')->result();

        // start awal

        $queryData = "SELECT
        ka.variabel,
        CASE WHEN ka.variabel ='Persepsi' THEN SUM(per.avr) / count(per.avr) ELSE SUM(har.avr) / count(har.avr) END as nil
        
        FROM
        tb_keanggotaan ka 
        LEFT OUTER JOIN
        (
        SELECT
        a.jenis as jns,SUM(b.skor) / COUNT(b.skor) as avr
        FROM
        kuisioner a
        INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
        
        WHERE a.code_quisioner = '" . $code_quisioner . "' AND a.jenis = 'Persepsi'
        
        GROUP BY a.id_dimensi
            )per  ON per.jns = ka.variabel
            
            
        LEFT OUTER JOIN
        (
        SELECT
        a.jenis as jns,SUM(b.skor) / COUNT(b.skor) as avr
        FROM
        kuisioner a
        INNER JOIN kepuasan b ON b.kepuasan = a.kepuasan
        
        WHERE a.code_quisioner = '" . $code_quisioner . "' AND a.jenis = 'Harapan'
        
        GROUP BY a.id_dimensi
            )har  ON har.jns = ka.variabel
            
            
            
            
        WHERE ka.tipe = 'Input'
        GROUP BY ka.variabel
        ORDER BY ka.variabel desc
            ";

        $dt = $this->db->query($queryData);

        $awal = null;
        foreach ($dt->result() as $i => $row) {
            $awal[] = $row->nil;
        }
        $data['render'] = $dt;
        $har = $awal[0];
        $per = $awal[1];

        $rul = null;
        $imp = null;

        $rulQuery = $this->db->query("SELECT * FROM tb_aturan ORDER BY id_aturan");
        foreach ($rulQuery->result() as $i => $row) {

            //HARAPAN
            $cek = null;
            if ($row->harapan == "TPG") {
                if ($har <= 0.5) {
                    $cek = 1;
                } else
                if ($har >= 0.5 && $har <= 1.5) {
                    $cek = (1.5 - $har) / (1.5 - 0.5);
                } else
                if ($har >= 1.5) {
                    $cek = 0;
                }
            } else
            if ($row->harapan == "KPG") {
                if ($har <= 0.5) {
                    $cek = 0;
                } else
                if ($har >= 0.5 && $har <= 1.5) {
                    $cek = ($har - 0.5) / (1.5 - 0.5);
                } else
                if ($har >= 1.5 && $har <= 2.5) {
                    $cek = (2.5 - $har) / (2.5 - 1.5);
                } else
                if ($har >= 2.5) {
                    $cek = 0;
                }
            } else
            if ($row->harapan == "CPG") {
                if ($har <= 1.5) {
                    $cek = 0;
                } else
                if ($har >= 1.5 && $har <= 2.5) {
                    $cek = ($har - 1.5) / (2.5 - 1.5);
                } else
                if ($har >= 2.5 && $har <= 3.5) {
                    $cek = (3.5 - $har) / (3.5 - 2.5);
                } else
                if ($har >= 3.5) {
                    $cek = 0;
                }
            } else
            if ($row->harapan == "PG") {
                if ($har <= 2.5) {
                    $cek = 0;
                } else
                if ($har >= 2.5 && $har <= 3.5) {
                    $cek = ($har - 2.5) / (3.5 - 2.5);
                } else
                if ($har >= 3.5 && $har <= 4.5) {
                    $cek = (4.5 - $har) / (4.5 - 3.5);
                } else
                if ($har >= 4.5) {
                    $cek = 0;
                }
            } else
            if ($row->harapan == "SPG") {
                if ($har <= 3.5) {
                    $cek = 0;
                } else
                if ($har >= 3.5 && $har <= 4.5) {
                    $cek = ($har - 3.5) / (4.5 - 3.5);
                } else
                if ($har >= 4.5) {
                    $cek = 1;
                }
            }


            //persepsi
            $cekp = null;
            if ($row->persepsi == "TP") {
                if ($per <= 0.5) {
                    $cekp = 1;
                } else
                if ($per >= 0.5 && $per <= 1.5) {
                    $cekp = (1.5 - $per) / (1.5 - 0.5);
                } else
                if ($per >= 1.5) {
                    $cekp = 0;
                }
            } else
            if ($row->persepsi == "KP") {
                if ($per <= 0.5) {
                    $cekp = 0;
                } else
                if ($per >= 0.5 && $per <= 1.5) {
                    $cekp = ($per - 0.5) / (1.5 - 0.5);
                } else
                if ($per >= 1.5 && $per <= 2.5) {
                    $cekp = (2.5 - $per) / (2.5 - 1.5);
                } else
                if ($per >= 2.5) {
                    $cekp = 0;
                }
            } else
            if ($row->persepsi == "CP") {
                if ($per <= 1.5) {
                    $cekp = 0;
                } else
                if ($per >= 1.5 && $per <= 2.5) {
                    $cekp = ($per - 1.5) / (2.5 - 1.5);
                } else
                if ($per >= 2.5 && $per <= 3.5) {
                    $cekp = (3.5 - $per) / (3.5 - 2.5);
                } else
                if ($per >= 3.5) {
                    $cekp = 0;
                }
            } else
            if ($row->persepsi == "P") {
                if ($per <= 2.5) {
                    $cekp = 0;
                } else
                if ($per >= 2.5 && $per <= 3.5) {
                    $cekp = ($per - 2.5) / (3.5 - 2.5);
                } else
                if ($per >= 3.5 && $per <= 4.5) {
                    $cekp = (4.5 - $per) / (4.5 - 3.5);
                } else
                if ($per >= 4.5) {
                    $cekp = 0;
                }
            } else
            if ($row->persepsi == "SP") {
                if ($per <= 3.5) {
                    $cekp = 0;
                } else
                if ($per >= 3.5 && $per <= 4.5) {
                    $cekp = ($per - 3.5) / (4.5 - 3.5);
                } else
                if ($per >= 4.5) {
                    $cekp = 1;
                }
            }

            $imp[$i]['har'] = $cek;
            $imp[$i]['per'] = $cekp;
            $imp[$i]['min'] = $cek < $cekp ? $cek : $cekp;
            $imp[$i]['rul'] = $row->pelayanan;
        }

        $data['imp'] = $imp;

        $deff = null;
        $ai = 0;
        foreach ($imp as $i => $row) {
            if ($row['min'] > 0) {
                $z = $row['min'];
                $x = 0;
                if ($row['rul'] == 'S') {
                    //coba perhitungan pertama
                    $x = ($z * 2.5) - ($z * 0.5) + (0.5);
                    if ($x >= 0.5 && $x <= 2.5) {
                    } else {

                        $x = (4.5) - ($z * 4.5) - ($z * 0.5);
                    }
                } else
                if ($row['rul'] == 'T') {
                    $x = ($z * 4.5) - ($z * 2.5) + (2.5);
                }

                $deff[$ai]['m'] = $x;
                $deff[$ai]['a1'] = $z;
                $deff[$ai]['rul'] = $row['rul'];

                $ai++;
            }
        }

        //hasil 
        $fma1 = 0;
        $fa1 = 0;
        foreach ($deff as $i => $row) {
            $fma1 += $row['m'] * $row['a1'];
            $fa1 += $row['a1'];
        }
        $z = round($fma1 / $fa1, 2);
        $data['z'] = $z;
        //pembuktian

        $data['deff'] = $deff;

        //cek hasil deffuzifikasi terhadap himpunan keanggotaan hasil

        $cekRendah = (2.5 - $z) / (2.5 - 0.5);


        if ($z >= 0.5 && $z <= 2.5)
            $cekSedang = ($z - 0.5) / (2.5 - 0.5);
        else
            $cekSedang = (4.5 - $z) / (4.5 - 2.5);

        $cekTinggi = ($z - 2.5) / (4.5 - 2.5);

        $hasil = "";

        if ($cekRendah > $cekSedang && $cekRendah > $cekTinggi)
            $hasil = "Rendah";
        else 
        if ($cekSedang > $cekRendah && $cekSedang > $cekTinggi)
            $hasil = "Sedang";
        else 
        if ($cekTinggi > $cekSedang && $cekTinggi > $cekRendah)
            $hasil = "Tinggi";

        if ($z == 0)
            $hasil = "Rendah";
        //$hasil = "rendah = " . $cekRendah ." | sedang = " . $cekSedang . " | tinggi = " . $cekTinggi;


        $qry = $this->db->query("UPDATE jawaban SET nilai = '" . $z . "',hasil = '" . $hasil . "' WHERE code_quisioner='" . $code_quisioner . "' ");

        $data['hasil'] = $hasil;

        $this->load->view('admin/fuzzy/perhitungan', $data);
    }

    public function aturan()
    {
        $data['kepuasan'] = $this->db->get('kepuasan')->result();
        $data['aturan'] = $this->db->get('tb_aturan')->result();
        $this->load->view('admin/fuzzy/indexAturan', $data);
    }

    public function storeAturan()
    {
        $post = $this->input->post();

        $data = [
            'harapan' => $post['harapan'],
            'persepsi' => $post['persepsi'],
            'pelayanan' => $post['pelayanan'],

        ];
        $qry = $this->db->insert('tb_aturan', $data);

        if ($qry) {
            $this->session->set_flashdata('success', 'Tambah data berhasil');
            redirect('admin/Fuzzy/aturan');
        }
    }

    public function storeKeanggotaan()
    {
        $post = $this->input->post();

        $data = [
            'tipe' => $post['tipe'],
            'variabel' => $post['variabel'],
            'nm_keanggotaan' => $post['nm_keanggotaan'],
            'nama_fungsi' => $post['nama_fungsi'],
            'nilai_batas_bawah' => $post['nilai_batas_bawah'],
            'nilai_batas_tengah' => $post['nilai_batas_tengah'],
            'nilai_batas_atas' => $post['nilai_batas_atas'],
        ];
        $qry = $this->db->insert('tb_keanggotaan', $data);

        if ($qry) {
            $this->session->set_flashdata('success', 'Tambah data berhasil');
            redirect('admin/Fuzzy/keanggotaan');
        }
    }
    public function hasilFuzzy()
    {

        // $this->db->join('users','users.user_id=kuisioner.user_id');
        // $this->db->group_by('kuisioner.user_id');
        // $data['responden']=$this->db->get('kuisioner')->result();
        $data['responden'] = $this->db->query("SELECT *,SUM(skor) as skor2 FROM `kuisioner` JOIN kepuasan ON kepuasan.kepuasan=kuisioner.kepuasan JOIN `users` ON users.user_id=kuisioner.user_id GROUP BY kuisioner.user_id")->result();


        $data['dimensi'] = $this->db->get('dimensi')->result();
        $this->load->view("admin/hasil/list", $data);
    }

    public function determineFuzzySet()
    {
    }

    public function getData()
    {
        $returnValue = "";
        $render = $this->db->query(
            "
            SELECT

            COUNT(nilai) as nil,hasil as lb

            FROM
            jawaban 
            GROUP BY hasil
            ORDER BY hasil
            "
        );

        foreach ($render->result() as $i => $row) {
            $returnValue .= $row->lb . "~" . $row->nil . "|";
        }

        echo $returnValue;
    }


    public function getJkel()
    {
        $returnValue = "";
        $render = $this->db->query(
            "
            SELECT

            COUNT(jenis_kelamin) as nil,jenis_kelamin as lb

            FROM
            users a
            INNER JOIN jawaban b ON a.user_id = b.user_id
            
            GROUP BY jenis_kelamin
            ORDER BY jenis_kelamin
            "
        );

        foreach ($render->result() as $i => $row) {
            $returnValue .= $row->lb . "~" . $row->nil . "|";
        }

        echo $returnValue;
    }
}
