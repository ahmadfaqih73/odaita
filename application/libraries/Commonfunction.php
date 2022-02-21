<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commonfunction
{
	/*	
		====================================================== Variable Declaration =========================================================
	*/	
	protected $CI;
	var $frm;
	
    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
    
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->library('session');
		$this->CI->load->database();
		$this->CI->load->library('FPDF','','fnpdf');
		$this->CI->load->library('PHPExcel','','excel');
		date_default_timezone_set('Asia/Makassar');

    }

	public function checkAccess($codeUser,$idFrm)
	{
		//check user access	
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$isAll = $this->CI->Mmain->qRead(
										"tb_userfrm AS a INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										WHERE a.code_user ='".$codeUser."' AND b.id_frm='".$idFrm."'",
										"a.is_add as isadd,a.is_edt as isedt,a.is_del as isdel,a.is_spec1 as acc1,a.is_spec2 as acc2","");
	
		foreach($isAll ->result() as $row)
		{
			$access=$row;
		}
		return $access;
	}
	
	public function getheader()
	{	
	
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		//get website setting
		$idUpel = $this->CI->session->userdata('id_upel');				
		$idUsub = $this->CI->session->userdata('id_usub');				
		$idJnsBidang = $this->CI->session->userdata('id_jnsbidang');				
		$codeUser = $this->CI->session->userdata('codeUser');				
		$output['ses']=$this->CI->session->all_userdata();
		$output['frmList']=$this->CI->session->userdata('frmList');
		$output['frmHead']=$this->CI->session->userdata('frmHead');
		$currentForm = $this->CI->uri->segment(1);
		//echo $currentForm;
		$cek = $this->CI->Mmain->qRead("tb_frm a INNER JOIN tb_frmgroup b ON a.id_frmgroup = b.id_frmgroup WHERE a.id_frm = '".$currentForm."' ","b.nm_frmgroup","");
		$cek = ($cek->num_rows() > 0 ? $cek->row()->nm_frmgroup : "");
		$output['currentGroup'] = $cek;
		
		//================================================================= alert access 
		$alertAccess = null;
		$checkAlertAccess = $this->CI->Mmain->qRead(
										"tb_accfrm AS a 
										INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										INNER JOIN tb_frmgroup AS c ON c.id_frmgroup = b.id_frmgroup
										WHERE a.id_acc ='".$this->CI->session->userdata['accUser']."' AND c.jns_frmgroup ='Notifikasi'
										",
										"a.code_frm as id,b.id_frm as title,b.desc_frm as notes","");
		//echo $this->CI->session->userdata['accUser'];
		$linkAlert=null;
		if($checkAlertAccess->num_rows() > 0)
		{
			foreach($checkAlertAccess->result_array() as $row){
				$alertAccess[$row['id']] = $row;
				//echo $row['id'];
			}
			
			$linkAlert = Array("FR092","FR105","FR093","FR103","FR094","FR095","FR104","FR111","FR112","FR113","FR119","FR126","FR133","FR134","FR135");
			$qArr = Array(	
							"tb_prc a WHERE a.stat_prc = 'Unapproved' AND id_upel = '".$idUpel."' ",
							"tb_prc a LEFT OUTER JOIN tb_plk k ON a.no_prc = k.no_prc WHERE CASE WHEN k.no_prc IS NULL THEN 0 ELSE 1 END = 0 AND a.id_upel = '".$idUpel."' and a.stat_prc = 'Approved' ",
							"tb_plk a WHERE a.stat_plk = 'Unapproved' AND id_upel = '".$idUpel."' ",
							"tb_mk a WHERE a.st_mk = 'Unapproved' AND id_upel = '".$idUpel."'",
							"tb_mk a WHERE NOT a.no_mk in (SELECT no_mk FROM tb_ie WHERE code_user = '".$codeUser."') AND ( (NOW() + INTERVAL 1 HOUR) >= a.tgl0_mk AND  CURDATE() <= DATE(a.tgl1_mk) AND a.st_mk = 'Approved')",
							"tb_pr a WHERE a.st_pr = 'Unapproved' AND id_upel = '".$idUpel."' ",
							"tb_kal a WHERE a.tgl_kal = CURDATE() OR (a.rec_kal ='Berulang' AND DATE_FORMAT(a.tgl_kal,'%m-%d') = DATE_FORMAT(CURDATE(),'%m-%d') ) ",
							"tb_lap a WHERE a.st_lap = 'Unapproved' AND id_upel = '".$idUpel."' AND id_jnsbidang = '".$idJnsBidang."' ",
							"tb_lap a WHERE NOT a.no_lap in (SELECT no_lap FROM tb_evi WHERE code_user = '".$codeUser."') AND ( (NOW() + INTERVAL 1 HOUR) >= a.tgl0_lap AND  CURDATE()  <= DATE(a.tgl1_lap) AND a.st_lap = 'Approved') AND id_upel = '".$idUpel."' AND id_jnsbidang = '".$idJnsBidang."' ",
							"tb_evi a WHERE a.st_evi = 'Incomplete' AND id_upel = '".$idUpel."' AND id_jnsbidang = '".$idJnsBidang."' ",
							"tb_mkm a WHERE a.st_mkm = 'Unapproved' AND id_upel = '".$idUpel."'",
							"tb_eva a WHERE a.st_eva = 'Belum diisi' AND id_upel = '".$idUpel."'",
							"tb_mkb a WHERE a.st_mkb = 'Unapproved' AND id_upel = '".$idUpel."'",
							"tb_mkb a WHERE NOT a.no_mkb in (SELECT no_mkb FROM tb_bm WHERE code_user = '".$codeUser."') AND ( (NOW() + INTERVAL 1 HOUR) >= a.tgl0_mkb AND  CURDATE() <= DATE(a.tgl1_mkb) AND a.st_mkb = 'Approved')",
							"tb_kal a WHERE a.tgl_kal = (CURDATE() + INTERVAL 1 DAY ) OR (a.rec_kal ='Berulang' AND DATE_FORMAT(a.tgl_kal,'%m-%d') = DATE_FORMAT((CURDATE() + INTERVAL 1 DAY ),'%m-%d') ) "
						
							);
							
							//FR118
							/*
							"tb_mkm a WHERE a.id_mkm IN (select id_mkm WHERE id_upel = '".$idUpel."' AND id_usub ='".$idUsub."') 
									
									AND (CURDATE() >= a.tgl0_mkm AND  CURDATE() <= a.tgl1_mkm AND a.st_mkm = 'Approved' )"
									*/
							//AND NOT a.no_mkm in (SELECT no_mkm FROM tb_lp WHERE id_upel = '".$idUpel."' AND id_usub ='".$idUsub."' ) ;
			$selArr = Array(
							"a.stat_prc",
							"a.stat_prc",
							"a.stat_plk",
							"a.id_mk",
							"a.id_mk",
							"a.st_pr",
							"a.id_kal",
							"a.id_lap",
							"a.id_lap",
							"a.id_evi",
							"a.id_mkm",
							"a.id_eva",
							"a.id_mkb",
							"a.id_mkb",
							"a.id_kal"
							);
							
			foreach($linkAlert as $i => $lbl){
				if(array_key_exists($lbl,$alertAccess)){
					$jum = $this->CI->Mmain->qRead($qArr[$i], $selArr[$i], "")->num_rows();
					if($jum>0)
					{
						//echo "select ".$selArr[$i]." from ".$qArr;
						$output['alert'][$lbl] = Array(	"title" => $lbl,"links" => $alertAccess[$lbl]['title'],"jum" => $jum,"notes" => $jum . " " . $alertAccess[$lbl]['notes'] );
					}
				}
				
			}
			
			//cek mkm
		
			if(array_key_exists("FR118",$alertAccess)){
				//echo $idUpel;
				//echo $idUsub;
				
				$cekwag=$this->CI->Mmain->qRead("
										tb_mkm a WHERE a.id_mkm IN (select id_mkm FROM tb_mkm_detail WHERE id_upel = '".$idUpel."' AND id_usub ='".$idUsub."') 
										AND ( (NOW() + INTERVAL 1 HOUR) >= a.tgl0_mkm AND  CURDATE() <= DATE(a.tgl1_mkm) ) AND a.st_mkm = 'Approved'",
										"", "");
										
				$jum=0;
				foreach($cekwag->result() as $i=>$row)
				{
					
					$jum+=$this::getWagTotal($idUpel,$idUsub,$row->no_mkm);
					
					if($jum>0)
					{
						//echo $jum;
						//echo $idUpel ." ".$idUsub;
						//echo "select ".$selArr[$i]." from ".$qArr;
						$output['alert']["FR118"] = Array(	"title" => $lbl, "links" => $alertAccess["FR118"]['title'],"jum" => $jum,"notes" => $jum . " " . $alertAccess["FR118"]['notes'] );
						$linkAlert[] = 'FR118';
					}
					//if($isLapor>0)
					
					
	
				}
				
			}
					
		}
		//echo $idUpel;
		//cek dashboard
		
		$checkDashboardAccess = $this->CI->Mmain->qRead(
										"tb_accfrm AS a 
										INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										INNER JOIN tb_frmgroup AS c ON c.id_frmgroup = b.id_frmgroup
										WHERE a.id_acc ='".$this->CI->session->userdata['accUser']."' AND c.jns_frmgroup ='Dashboard'
										",
										"a.code_frm as id,b.id_frm as title,b.desc_frm as notes","");
		$output['dashboardAccess'] = $checkDashboardAccess->num_rows() > 0 ? 1 : 0;
		
		$output['linkAlert'] = $linkAlert;
		$this->CI->load->view('adm_header',$output);
		$this->checkLogin();
			
	}
	public function checkLogin()
	{
		
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$cek=$this->CI->Mmain->qRead("tb_user WHERE code_user='".$this->CI->session->userdata('codeUser')."' AND key_user='".$this->CI->session->userdata('loginKey')."'","","")->num_rows();
		if($cek==0)
			redirect("login/logout","refresh");
	}
	
	public function getfooter()
	{	
	
		$this->CI->load->view('adm_footer');		
	}
	
	public function getFormGroup($idacc)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');		
		$qemp=$this->CI->Mmain->qRead("	tb_frm AS a 
										INNER JOIN tb_frmgroup AS b ON a.id_frmgroup = b.id_frmgroup 
										INNER JOIN tb_accfrm AS c ON a.code_frm = c.code_frm
										WHERE c.id_acc='".$idacc."' AND a.stat_frm =1 AND b.jns_frmgroup = 'Form' ORDER BY b.panel_frmgroup,b.id_frmgroup,a.is_shortcut,a.code_frm ",
										"a.code_frm as code,a.id_frm as id,a.desc_frm as descs,b.nm_frmgroup as groupnm,b.icon_frmgroup as ico,b.iconcolor_frmgroup as iclr,a.is_shortcut as iss",
										"");
										
		return $qemp;
	}
	
	
	public function getFormGroupHeader($idacc)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');												
										
		$qemp=$this->CI->Mmain->qRead("	tb_frm AS a 
										INNER JOIN tb_frmgroup AS b ON a.id_frmgroup = b.id_frmgroup 
										INNER JOIN tb_accfrm AS c ON a.code_frm = c.code_frm
										WHERE c.id_acc='".$idacc."' AND a.stat_frm =1 AND b.jns_frmgroup = 'Form' GROUP BY b.nm_frmgroup ORDER BY b.panel_frmgroup,b.id_frmgroup,a.code_frm ",
										"b.nm_frmgroup as groupnm,b.icon_frmgroup as ico,b.iconcolor_frmgroup as iclr",
										"");
		return $qemp;
	}
	
	
	public function createCbofromDb($cboTb,$cboSel,$cboWhere,$cboDef,$isdis="",$cusname="txt[]",$placeholder="",$cboAdd=null)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
		
		if($cusname=="")
			$cusname="txt[]";
		$cboemp="<select name=$cusname class='form-control' $isdis>";
		
		
		if($placeholder=="" || $placeholder <> "no")
		{
			if($placeholder == "")
			$placeholder="Pilih Data";
		
			$opt=null;
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
				$opt .= " data-".$add."='Pilih Data' ";
			}
			$cboemp.="	<option  data-opt='Pilih Data' $opt value=''  selected>".$placeholder."</option>";
		}
			
			
			
		foreach($qemp->result() as $row)
		{
			$opt = isset($row->opt) ? " data-opt='".$row->opt."' " : "";
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
					$opt .= " data-".$add."='".$row->$add."' ";
			}
			
			$isdef="";
			if($row->nm==$cboDef || $row->id==$cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$row->id."' $opt $isdef>".$row->nm."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	public function createCbofromDb2($cboTb,$cboSel,$cboWhere,$cboDef,$isdis="",$cusname="txt[]",$placeholder="",$cboAdd=null)
	{
		//init modal
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
		
		if($cusname=="")
			$cusname="txt[]";
		$cboemp="<select name=$cusname class='form-control mulselect' $isdis>";
		
		
		if($placeholder=="" || $placeholder <> "no")
		{
			if($placeholder == "")
			$placeholder="Pilih Data";
		
			$opt=null;
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
				$opt .= " data-".$add."='Pilih Data' ";
			}
			$cboemp.="	<option  data-opt='Pilih Data' $opt value=''  selected>".$placeholder."</option>";
		}
			
			
			
		foreach($qemp->result() as $row)
		{
			$opt = isset($row->opt) ? " data-opt='".$row->opt."' " : "";
			if($cboAdd <> null)
			{
				foreach($cboAdd as $i => $add)
					$opt .= " data-".$add."='".$row->$add."' ";
			}
			
			$isdef="";
			if($row->nm==$cboDef || $row->id==$cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$row->id."' $opt $isdef>".$row->nm."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
		
	
	public function createCbo($cboid,$cboval,$cboDef,$isdis="",$cusname="txt[]",$placeholder="")
	{
		//init modal
		
		if($cusname=="")
			$cusname="txt[]";
		$cboemp="<select name=$cusname class='form-control' $isdis>";
		
		if($placeholder=="" || $placeholder <> "no")
		{
			if($placeholder == "")
			$placeholder="Pilih Data";
			
			$cboemp.="	<option  data-opt='Pilih Data' value='' selected>".$placeholder."</option>";
		}
		
		
			
		for($i=0;$i<count($cboid);$i++)
		{
			$isdef="";
			if($cboval[$i]==$cboDef || $cboid[$i]==$cboDef)	
				$isdef="selected";
			$cboemp.="<option value='".$cboid[$i]."' $isdef >".$cboval[$i]."</option>";
		}
		$cboemp.="</select>";
		return $cboemp;
	}
	
	

	public function createMulCbofromDb($cboTb,$cboSel,$cboWhere,$cboDef,$nmdef="txt[]")
	{
			
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,$cboWhere);
			$cboemp="<select multiple='multiple' name=$nmdef class='form-control' size=8>";
			foreach($qemp->result() as $row)
			{
				$isdef="";
				if(is_array($cboDef))
				{
					foreach($cboDef as $isi)
					{
						if($row->nm==$isi || $row->id==$isi)
						{
							$isdef="selected";
							break;
						}
					}
				}
				else
				if($row->nm==$cboDef || $row->id==$cboDef)
				{
					$isdef="selected";
				}
				$cboemp.="<option value='".$row->id."' $isdef  >".$row->nm."</option>";
			}
			$cboemp.="</select>";
		return $cboemp;
	}
	
	
	
	public function createRadio($cboid,$cboval,$count,$cboDef="",$id="")
	{
			//init modal
			$cboemp=" 
                   ";
			for($i=0;$i<count($cboid);$i++)
			{
				$chk="";
				if($cboDef==$cboid[$i])
				$chk="checked"	;
				$cboemp.=" <label><input type='radio' name=txt[$count] class='flat-red' value='".$cboid[$i]."' $id $chk>&nbsp;$cboval[$i]</label>&nbsp;";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function addViewCount($formName)
	{
			//init modal
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			$visitorIp=$_SERVER['REMOTE_ADDR'];
			$saveVal=Array(
							"",
							date("Y-m-d h:i:s"),
							$visitorIp,
							$formName
							);
			$this->CI->Mmain->qIns("tb_viewcount",$saveVal);
	}
	public function getUserAccess($userAccess="", $formName="")
	{
		
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		if($userAccess == "")			
			$userAccess = $this->CI->session->userdata('accUser');
		
		if($formName == "")
			$formName = $this->CI->uri->segment(1);
		
		$access = $this->CI->Mmain->qRead(
										"tb_accfrm AS a 
										INNER JOIN tb_frm AS b ON a.code_frm = b.code_frm 
										WHERE a.id_acc ='".$userAccess."' 
										AND b.id_frm='".$formName."'",
										"",
										"");
		//echo $formName;
		return $access;
		
	}
	public function filtering($viewLink,$accessQuery,$postData,$bahanCari,$qArr,$noYear=0,$mnu="",$isModerator=0,$lnk="")
	{
		
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$tambahan="";
		$op="";
		$col="";
		
		if($postData==1)
		{
			//$bahanCari=$this->input->post('txt');
			$fld=$qArr;
			
			//$col="in";
			for($a=0;$a<count($bahanCari);$a++)
			{
				if($bahanCari[$a]<>"")
				{
					
					$op = ( $accessQuery == "" && $tambahan == "" ? " WHERE " : " AND ");
									
					if($mnu=="doc" && $a==6)
					{
						
						$tambahan.=" ".$op.$fld[$a]." > ".$bahanCari[$a]." ";
					}
					else
					{
						$tambahan.=" ".$op.$fld[$a]." = '".$bahanCari[$a]."' ";
					}
				}
			}
			//echo $tambahan;
			//$accessQuery.=$tambahan;
	
		}
			
		
		//filtering
		for($i=date("Y");$i>=2019;$i--)
		{
			$thnArr[]=$i;
		}
		
		//echo $tambahan;
	if($noYear==0)
	{
		$cbothn=$this->createCbo($thnArr,$thnArr,$bahanCari[0],"id='cboFilYear'","","no");
		$cbobln=$this->createCbo(Array("01","02","03","04","05","06","07","08","09","10","11","12"),
		Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"),$bahanCari[1],"id='cboFilMonth'","","Pilih Bulan");
		$cbotgl="<input type='text' class='form-control dtp' data-date-format='yyyy-mm-dd' id='txttanggal ' name=txt[] value='".$bahanCari[2]."' placeholder='Pilih Tanggal' readonly autocomplete='off'>";
		
		$userAccessTemp = $this->getUserAccess();
		$isModerator = $userAccessTemp->num_rows() > 0 ? $userAccessTemp->row()->is_spec2 : 0;
		//echo $isModerator;
		//$output['isall']=$access->isadd;
		
		if($isModerator==0)
		{
			$cboupel=$this->createCbofromDb("tb_upel WHERE id_upel='".$bahanCari[3]."' OR nm_upel='".$bahanCari[3]."'  ","id_upel as id,nm_upel as nm","",$bahanCari[3],"id='cboupel'","","Pilih Unit Pelaksana");
			$cbousub=$this->createCbofromDb("tb_usub WHERE id_usub='".$bahanCari[4]."' OR nm_usub='".$bahanCari[4]."' ","id_usub as id,nm_usub as nm,id_upel as opt","",$bahanCari[4],"id='cbousub'","","Pilih Sub Unit Pelaksana");
			$cbobidang=$this->createCbofromDb("tb_jnsbidang WHERE id_jnsbidang='".$bahanCari[5]."'","id_jnsbidang as id,nm_jnsbidang as nm","",$bahanCari[5],"id='cbobidang'","","Pilih Bidang");
		}
		else
		if($isModerator==1)
		{
			
			$cboupel=$this->createCbofromDb("tb_upel ","id_upel as id,nm_upel as nm","",$bahanCari[3],"id='cboupel'","","Pilih Unit Pelaksana");
			$cbousub=$this->createCbofromDb("tb_usub ","id_usub as id,nm_usub as nm,id_upel as opt","",$bahanCari[4],"id='cbousub'","","Pilih Sub Unit Pelaksana");
			$cbobidang=$this->createCbofromDb("tb_jnsbidang ","id_jnsbidang as id,nm_jnsbidang as nm","",$bahanCari[5],"id='cbobidang'","","Pilih Bidang");
		}
		if(!isset($bahanCari[6]))
			$bahanCari[6]="";
		if(!isset($bahanCari[7]))
			$bahanCari[7]="";
		
		if($mnu=="sg")
		{
			$cbobidang.=$this->createCbofromDb("tb_mitra ","id_mitra as id,nm_mitra as nm","",$bahanCari[6],"id='cbojkeg'","","Pilih Mitra");
		}
		else
		if($mnu=="izin")
		{
			$cbobidang.=$this->createCbofromDb("tb_mitra ","id_mitra as id,nm_mitra as nm","",$bahanCari[6],"id='cbojkeg'","","Pilih Mitra");
			$cbobidang.=$this->createCbo(array(0,1,2),array("Waiting approval","Approved","Rejected"),$bahanCari[7],"","","Pilih Status Izin");
		}
		else
		if($mnu=="rec")
		{
			$tambahrec="";
			if($isModerator==0)
			{
				$tambahrec = " WHERE b.id_jnsbidang = '".$bahanCari[5]."'";
			}
			
			
			$cbothn=$this->createCbofromDb("tb_rec GROUP BY  YEAR(act_rec) ORDER BY  YEAR(act_rec) DESC"," YEAR(act_rec) as id, YEAR(act_rec) as nm","",$bahanCari[0],"id='cboFilYear'","","no");
			$cbobidang.=$this->createCbofromDb("tb_jnsrec a INNER JOIn tb_detjnsrec b ON a.id_jnsrec = b.id_jnsrec ".$tambahrec,"a.id_jnsrec as id,a.nm_jnsrec as nm","",$bahanCari[6],"id='cbo'","","Pilih Jenis Rekaman");
		}
		else
		if($mnu=="keg")
		{
			$tambahkeg="";
			if($isModerator==0)
			{
				$tambahkeg = " WHERE b.id_jnsbidang = '".$bahanCari[5]."'";
			}
			$cbobidang.=$this->createCbofromDb("tb_jnskeg a INNER JOIN tb_detjnskeg b ON a.id_jnskeg = b.id_jnskeg  ".$tambahkeg,"a.id_jnskeg as id,a.nm_jnskeg as nm","",$bahanCari[6],"id='cbo'","","Pilih Jenis Kegiatan");
		}
		else
		if($mnu=="dkm")
		{
		
			//$cbobidang.=$this->createCbo(array(""),array("Manual","Prosedur","Instruksi Kerja","Formulir","Lampiran"),$bahanCari[6],"","","Pilih Level Dokumen");
			
			$cbobidang .= $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[6],"id='cboJenisFil'","","Pilih Jenis");
		}
		else
		if($mnu=="kecelakaan")
		{
			
		}
		else
		if($mnu=="soc")
		{
			
			//$cbobidang.=$this->createCbofromDb("tb_jnskeg  ","id_jnskeg as id,nm_jnskeg as nm","",$bahanCari[6],"id='cbo'","","Pilih Jenis Kegiatan");
			$cbobidang.=$this->createCbofromDb("tb_jnssoc","id_jnssoc as id,nm_jnssoc as nm","",$bahanCari[6],"id='cbo'","","Pilih Jenis Potensi Bahaya");
		}
		else
		if($mnu=="doc")
		{
			$cbobidang.=$this->createCbo(array(1,2,3,4,5),array("Manual","Prosedur","Instruksi Kerja","Formulir","Lampiran"),$bahanCari[6],"","","Pilih Level Dokumen");
			
		}
		else
		if($mnu=="ptamu")
		{
			$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
		}
		else
		if($mnu=="ppaket")
		{
			$cbobidang.=$this->createCbo(Array("Paket","Surat","Proposal"),Array("Paket","Surat","Proposal"),$bahanCari[6],"","","Pilih Jenis Penerimaan");
		}
		else
		if($mnu=="spatrol")
		{
			$cbobidang=$this->createCbo(	array("Pagi","Sore","Malam"),
												array("Pagi","Sore","Malam"),$bahanCari[5],"","","Pilih Shift");
		}
		else
		if($mnu=="pemeriksa")
		{
			$cbobidang.=$this->CI->fn->createCbofromDb("tb_mitra","id_mitra as id,nm_mitra as nm","",$bahanCari[5],"","","Pilih pelaksana");
			$cbobidang.=$this->CI->fn->createCbo(Array(1,0),Array("100%","Belum"),$bahanCari[6],"","","Pilih Prestasi");
		}
		else
		if($mnu=="an")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
			$cbobidang = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboJenisFil'","","Pilih Jenis Stakeholder");
			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_tlst","nm_tlst as id, nm_tlst as nm","",$bahanCari[6],"id='cboTingkatFil'","","Pilih Tingkat");
			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_unsur ORDER BY nm_uns ","nm_uns as id, nm_uns as nm, jns_uns as opt","",$bahanCari[7],"id='cboUnsurFil'","","Pilih Unsur");
			
			$cbobidang .= $this->CI->fn->createCbo(
												Array("Primer","Sekunder 1","Sekunder 2","Sekunder 3","Laten 1","Laten 2","Laten 3"),
												Array("Primer","Sekunder 1","Sekunder 2","Sekunder 3","Laten 1","Laten 2","Laten 3"),
												$bahanCari[8],"id='cboKlasFil'","","Pilih Klasifikasi");
			
			$cbobidang .= $this->CI->fn->createCbo(Array("Menolak","Netral","Mendukung"),Array("Menolak","Netral","Mendukung"),$bahanCari[9],"","","Pilih Sikap");
		}	
		else
		if($mnu=="prc")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
			$cbobidang = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboJenisFil'","","Pilih Jenis Stakeholder");
			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_tlst","nm_tlst as id, nm_tlst as nm","",$bahanCari[6],"id='cboTingkatFil'","","Pilih Tingkat");
			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_unsur ORDER BY nm_uns ","nm_uns as id, nm_uns as nm, jns_uns as opt","",$bahanCari[7],"id='cboUnsurFil'","","Pilih Unsur");
			
			$cbobidang .= $this->CI->fn->createCbo(
												Array("Isu","Berita","Kejadian"),
												Array("Isu","Berita","Kejadian"),
												$bahanCari[8],"id='cboJnsFil'","","Pilih Sumber Informasi");
												
			$cbobidang .= $this->CI->fn->createCbo(Array("Menolak","Netral","Mendukung"),Array("Menolak","Netral","Mendukung"),$bahanCari[9],"","","Pilih Sikap");
			
			$cbobidang .= $this->CI->fn->createCbofromDb(
											"tb_prc a INNER JOIN tb_st b ON a.id_st = b.id_st GROUP BY a.id_st ORDER BY nm_st ",
											"b.id_st as id, nm_st as nm, jns_st as opt,id_upel as opt2,id_uns as opt3,jab_st as opt4,ins_st as opt5  ",
											"",
											$bahanCari[10],
											"id='cboFilStPrc' style='width: 100%' ",
											"txt[]",
											"Pilih Stakeholder",
											Array("opt2","opt3","opt4","opt5"));
											
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[11],"id='cboTs'","","Pilih Tema Strategis");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan ","id_har as id,nm_har as nm,jns_har as opt","",$bahanCari[12],"id='cboHarPress'","","Pilih Topik");
			
			
			$cbobidang .= $this->CI->fn->createCbo(
												Array("Lanjut ke Pelaksanaan","Telah Dilaksanakan"),
												Array("Lanjut ke Pelaksanaan","Telah Dilaksanakan"),
												$bahanCari[13],"id='cboFilAksiPrc'","","Pilih Aksi");
			
											
		//	$cbobidang .= $this->CI->fn->createCbo(Array("Waiting for Approval","Approved","Rejected"),Array("Waiting for Approval","Approved","Rejected"),$bahanCari[10],"","","Pilih Status Approval");
		}	
		else
		if($mnu=="plk")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
			$cbobidang = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboJenisFil'","","Pilih Jenis Stakeholder");
			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_tlst","nm_tlst as id, nm_tlst as nm","",$bahanCari[6],"id='cboTingkatFil'","","Pilih Tingkat");
			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_unsur ORDER BY nm_uns ","nm_uns as id, nm_uns as nm, jns_uns as opt","",$bahanCari[7],"id='cboUnsurFil'","","Pilih Unsur");
			
			$cbobidang .= $this->CI->fn->createCbo(
												Array("Primer","Sekunder 1","Sekunder 2","Sekunder 3","Laten 1","Laten 2","Laten 3"),
												Array("Primer","Sekunder 1","Sekunder 2","Sekunder 3","Laten 1","Laten 2","Laten 3"),
												$bahanCari[8],"id='cboKlasFil'","","Pilih Klasifikasi");
			
			$cbobidang .= $this->CI->fn->createCbo(Array("Menolak","Netral","Mendukung"),Array("Menolak","Netral","Mendukung"),$bahanCari[9],"","","Pilih Sikap");
			
			$cbobidang .= $this->CI->fn->createCbofromDb(
											"tb_prc a INNER JOIN tb_st b ON a.id_st = b.id_st GROUP BY a.id_st ORDER BY nm_st ",
											"b.id_st as id, nm_st as nm, jns_st as opt,id_upel as opt2,id_uns as opt3,jab_st as opt4,ins_st as opt5  ",
											"",
											$bahanCari[10],
											"id='cboFilStPrc' style='width: 100%' ",
											"txt[]",
											"Pilih Stakeholder",
											Array("opt2","opt3","opt4","opt5"));
											
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[11],"id='cboTs'","","Pilih Tema Strategis");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan ","id_har as id,nm_har as nm,jns_har as opt","",$bahanCari[12],"id='cboHarPress'","","Pilih Topik");
			
		}	
		else
		if($mnu=="mk")
		{
		
			
			$cboupel =  $this->CI->fn->createCbofromDb("tb_emp WHERE code_user in (select code_user from tb_mk) ","code_user as id,nm_emp as nm","",$bahanCari[3],"id='cboEmp'","","Pilih Pengunggah");
			
			$cbousub =  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[4],"id='cboTs'","","Pilih Tema Strategis");
			
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","id_har as id,nm_har as nm","",$bahanCari[5],"id='cboHar'","","Pilih Topik");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_medsos","id_medsos as id,nm_medsos as nm","",$bahanCari[6],"id='cboMedsos'","","Pilih Jenis Media Sosial");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_jt","id_jt as id,nm_jt as nm,id_medsos as opt","",$bahanCari[7],"id='cboJt'","","Pilih Jenis Target");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mk  GROUP BY judul_mk ORDER BY tgl0_mk ","judul_mk as id,judul_mk as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mk,'%m') as opt3,YEAR(tgl0_mk) as opt4","",$bahanCari[8],"id='cboFilJudulmk'","","Pilih Judul",Array("opt2","opt3","opt4"));
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Approved","Unapproved"),Array("Approved","Unapproved"),$bahanCari[9],"id='cboSt'","","Pilih Status");
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Aktif","Tidak Aktif"),Array("Aktif","Tidak Aktif"),$bahanCari[10],"id='cboStAktif'","","Pilih Status Pelaporan");
			
			//$cbobidang="";
		}	
		else
		if($mnu=="mkb")
		{
		
			
			//$cbothn=$this->createCbo($thnArr,$thnArr,$bahanCari[0],"id='cboFilYear'","","no");
			
			$cbothn =  $this->CI->fn->createCbofromDb("tb_mkb GROUP BY YEAR(tgl0_mkb) ","YEAR(tgl0_mkb) as id,YEAR(tgl0_mkb) as nm","",$bahanCari[0],"id='cboFilYear'","","no");
			
			$cboupel =  $this->CI->fn->createCbofromDb("tb_emp WHERE code_user in (select code_user from tb_mkb) ","code_user as id,nm_emp as nm","",$bahanCari[3],"id='cboEmp'","","Pilih Pengunggah");
			
			$cbousub =  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[4],"id='cboTs'","","Pilih Tema Strategis");
			
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","id_har as id,nm_har as nm","",$bahanCari[5],"id='cboHar'","","Pilih Topik");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_medsos","id_medsos as id,nm_medsos as nm","",$bahanCari[6],"id='cboMedsos'","","Pilih Jenis Media");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_jt","id_jt as id,nm_jt as nm,id_medsos as opt","",$bahanCari[7],"id='cboJtMkb'","","Pilih Jenis Target");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mkb GROUP BY judul_mkb ORDER BY tgl0_mkb  ","judul_mkb as id,judul_mkb as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mkb,'%m') as opt3,YEAR(tgl0_mkb) as opt4","",$bahanCari[8],"id='cboFilJudulmkb'","","Pilih Judul",Array("opt2","opt3","opt4"));
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Approved","Unapproved"),Array("Approved","Unapproved"),$bahanCari[9],"id='cboSt'","","Pilih Status");
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Aktif","Tidak Aktif"),Array("Aktif","Tidak Aktif"),$bahanCari[10],"id='cboStAktif'","","Pilih Status Pelaporan");
			
			//$cbobidang="";
		}	
		else
		if($mnu=="mkm")
		{
		
			
			$cboupel =  $this->CI->fn->createCbofromDb("tb_emp WHERE code_user in (select code_user from tb_mkm) ","code_user as id,nm_emp as nm","",$bahanCari[3],"id='cboEmp'","","Pilih Pengunggah");
			
			$cbousub =  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[4],"id='cboTs'","","Pilih Tema Strategis");
			
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","id_har as id,nm_har as nm","",$bahanCari[5],"id='cboHar'","","Pilih Topik");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mkm GROUP BY judul_mkm ORDER BY tgl0_mkm ","judul_mkm as id,judul_mkm as nm,DATE_FORMAT(tgl0_mkm,'%m') as opt3,YEAR(tgl0_mkm) as opt4","",$bahanCari[6],"id='cboFilJudulmkm'","","Pilih Judul",Array("opt3","opt4"));
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Approved","Unapproved"),Array("Approved","Unapproved"),$bahanCari[7],"id='cboSt'","","Pilih Status");
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Aktif","Tidak Aktif"),Array("Aktif","Tidak Aktif"),$bahanCari[8],"id='cboStAktif'","","Pilih Status Pelaporan");
			
			//$cbobidang="";
		}	
		else
		if($mnu=="pr")
		{
			
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[5],"id='cboTs'","","Pilih Tema Strategis");
			
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[6],"id='cboJenisPress'","","Pilih Jenis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan ","id_har as id,nm_har as nm,jns_har as opt","",$bahanCari[7],"id='cboHarPress'","","Pilih Topik");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_pr","judul_pr as id,judul_pr as nm,id_har as opt,0 as opt2,DATE_FORMAT(tgl_pr,'%m') as opt3,YEAR(tgl_pr) as opt4","",$bahanCari[8],"id='cboFilJudulPress'","","Pilih Judul",Array("opt2","opt3","opt4"));
			//$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mk","judul_mk as id,judul_mk as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mk,'%m') as opt3,YEAR(tgl0_mk) as opt4","",$bahanCari[8],"id='cboFilJudulmk'","","Pilih Judul",Array("opt2","opt3","opt4"));
		
			
			$cbobidang .= $this->CI->fn->createCbofromDb(
											"tb_anal a INNER JOIN tb_st b ON a.id_st = b.id_st  WHERE jns_st = 'Internal' GROUP BY a.id_st ORDER BY nm_st ",
											"b.id_st as id, nm_st as nm, jns_st as opt,id_upel as opt2,id_uns as opt3,jab_st as opt4,ins_st as opt5  ",
											"",
											$bahanCari[9],
											"id='cboFilNaraInPress' style='width: 100%' ",
											"txt[]",
											"Pilih Narasumber Internal",
											Array("opt2","opt3","opt4","opt5"));
											
			
			$cbobidang .= $this->CI->fn->createCbofromDb(
											"tb_anal a INNER JOIN tb_st b ON a.id_st = b.id_st  WHERE jns_st = 'Eksternal' GROUP BY a.id_st ORDER BY nm_st ",
											"b.id_st as id, nm_st as nm, jns_st as opt,id_upel as opt2,id_uns as opt3,jab_st as opt4,ins_st as opt5  ",
											"",
											$bahanCari[10],
											"id='cboFilNaraExPress' style='width: 100%' ",
											"txt[]",
											"Pilih Narasumber External",
											Array("opt2","opt3","opt4","opt5"));
											
			$cbobidang .= $this->CI->fn->createCbo(Array("Approved","Unapproved"),Array("Approved","Unapproved"),$bahanCari[11],"id='cboStat' ","txt[]","Pilih Status");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_emp WHERE code_user in (select code_user from tb_pr)","code_user as id,nm_emp as nm","",$bahanCari[12],"id='cboEmp'","","Pilih Pengunggah");
											
			//$cbobidang="";
		}	
		else
		if($mnu=="lap")
		{
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_bag","id_bag as id,nm_bag as nm,id_jnsbidang as opt","",$bahanCari[6],"id='cboBag'","","Pilih Bagian");
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[7],"id='cboTs'","","Pilih Tema Strategis");
			
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[8],"id='cboJenisPress'","","Pilih Jenis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan ","id_har as id,nm_har as nm,jns_har as opt","",$bahanCari[9],"id='cboHarPress'","","Pilih Topik");
									
			$cbobidang .= $this->CI->fn->createCbo(Array("Approved","Unapproved"),Array("Approved","Unapproved"),$bahanCari[10],"id='cboStat' ","txt[]","Pilih Status");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_emp WHERE code_user in (select code_user from tb_lap)","code_user as id,nm_emp as nm","",$bahanCari[11],"id='cboEmp'","","Pilih Pengunggah");
											
			//$cbobidang="";
		}	
		else
		if($mnu=="evi")
		{
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_bag","id_bag as id,nm_bag as nm,id_jnsbidang as opt","",$bahanCari[6],"id='cboBag'","","Pilih Bagian");
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[7],"id='cboTs'","","Pilih Tema Strategis");
			
			
			$cbobidang .=  $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[8],"id='cboJenisPress'","","Pilih Jenis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan ","id_har as id,nm_har as nm,jns_har as opt","",$bahanCari[9],"id='cboHarPress'","","Pilih Topik");
									
			$cbobidang .= $this->CI->fn->createCbo(Array("Completed","Incomplete"),Array("Approved","Unapproved"),$bahanCari[10],"id='cboStat' ","txt[]","Pilih Status");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_emp WHERE code_user in (select code_user from tb_evi)","code_user as id,nm_emp as nm","",$bahanCari[11],"id='cboEmp'","","Pilih Pengunggah");
											
			//$cbobidang="";
		}
		else
		if($mnu=="kal")
		{
						
			$cbobidang =  $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboFilJenisKal'","","Pilih Jenis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_kal GROUP BY acara_kal","acara_kal as id,acara_kal as nm,jns_kal as opt,DATE_FORMAT(tgl_kal,'%m') as opt2","",$bahanCari[6],"id='cboFilAcaraKal'","","Pilih Acara",Array("opt2"));
	
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_emp a INNER JOIN tb_kal b ON a.code_user = b.code_user WHERE NOT a.code_user = 'USR00001' GROUP BY a.code_user ","a.code_user as id,nm_emp as nm,a.id_upel as opt,a.id_usub as opt2","",$bahanCari[7],"id='cboFilterEmp'","","Pilih Pengunggah",Array("opt2"));
											
			//$cbobidang="";
		}	
		else
		if($mnu=="ie")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
		//	$cbobidang = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboJenisFil'","","Pilih Jenis Stakeholder");
			
			//$cbobidang .= $this->CI->fn->createCbofromDb("tb_tlst","nm_tlst as id, nm_tlst as nm","",$bahanCari[6],"id='cboTingkatFil'","","Pilih Tingkat");
			
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_emp WHERE NOT code_user = 'USR00001' ","code_user as id,nm_emp as nm,id_upel as opt,id_usub as opt2","",$bahanCari[5],"id='cboFilterEmp'","","Pilih Pengunggah",Array("opt2"));
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[6],"id='cboTs'","","Pilih Tema Strategis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","id_har as id,nm_har as nm","",$bahanCari[7],"id='cboHar'","","Pilih Topik");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_medsos","id_medsos as id,nm_medsos as nm","",$bahanCari[8],"id='cboMedsos'","","Pilih Jenis Media Sosial");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_jt","id_jt as id,nm_jt as nm,id_medsos as opt","",$bahanCari[9],"id='cboJt'","","Pilih Jenis Target");
		
			///$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mk","judul_mk as id,judul_mk as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mk,'%m') as opt3,YEAR(tgl0_mk) as opt4","",$bahanCari[10],"id='cboJudulmk'","","Pilih Judul",Array("opt2","opt3","opt4"));
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mk","judul_mk as id,judul_mk as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mk,'%m') as opt3,YEAR(tgl0_mk) as opt4","",$bahanCari[10],"id='cboFilJudulmk'","","Pilih Judul",Array("opt2","opt3","opt4"));
		
			$cbobidang .=  $this->CI->fn->createCbo(Array("Aktif","Tidak Aktif"),Array("Aktif","Tidak Aktif"),$bahanCari[11],"id='cboSt'","","Pilih Status");
			//$cbobidang="";
		}	
		else
		if($mnu=="bm")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
		//	$cbobidang = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboJenisFil'","","Pilih Jenis Stakeholder");
			
			//$cbobidang .= $this->CI->fn->createCbofromDb("tb_tlst","nm_tlst as id, nm_tlst as nm","",$bahanCari[6],"id='cboTingkatFil'","","Pilih Tingkat");
			
			$cbothn =  $this->CI->fn->createCbofromDb("tb_mkb GROUP BY YEAR(tgl0_mkb) ","YEAR(tgl0_mkb) as id,YEAR(tgl0_mkb) as nm","",$bahanCari[0],"id='cboFilYear'","","no");
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_emp WHERE NOT code_user = 'USR00001' AND code_user in (select code_user from tb_bm )","code_user as id,nm_emp as nm,id_upel as opt,id_usub as opt2","",$bahanCari[5],"id='cboFilterEmp'","","Pilih Pengunggah",Array("opt2"));
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[6],"id='cboTs'","","Pilih Tema Strategis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","id_har as id,nm_har as nm","",$bahanCari[7],"id='cboHar'","","Pilih Topik");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_medsos","id_medsos as id,nm_medsos as nm","",$bahanCari[8],"id='cboMedsos'","","Pilih Jenis Media");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_jt","id_jt as id,nm_jt as nm,id_medsos as opt","",$bahanCari[9],"id='cboJt'","","Pilih Jenis Target");
		
			///$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mk","judul_mk as id,judul_mk as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mk,'%m') as opt3,YEAR(tgl0_mk) as opt4","",$bahanCari[10],"id='cboJudulmk'","","Pilih Judul",Array("opt2","opt3","opt4"));
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mkb","judul_mkb as id,judul_mkb as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mkb,'%m') as opt3,YEAR(tgl0_mkb) as opt4","",$bahanCari[10],"id='cboFilJudulmkb'","","Pilih Judul",Array("opt2","opt3","opt4"));
		
			$cbobidang .=  $this->CI->fn->createCbo(Array("Aktif","Tidak Aktif"),Array("Aktif","Tidak Aktif"),$bahanCari[11],"id='cboSt'","","Pilih Status");
			//$cbobidang="";
		}	
		else
		if($mnu=="lp")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
		//	$cbobidang = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[5],"id='cboJenisFil'","","Pilih Jenis Stakeholder");
			
			//$cbobidang .= $this->CI->fn->createCbofromDb("tb_tlst","nm_tlst as id, nm_tlst as nm","",$bahanCari[6],"id='cboTingkatFil'","","Pilih Tingkat");
			
			$cbobidang =  $this->CI->fn->createCbofromDb("tb_emp WHERE NOT code_user = 'USR00001' ","code_user as id,nm_emp as nm,id_upel as opt,id_usub as opt2","",$bahanCari[5],"id='cboFilterEmp'","","Pilih Pengunggah",Array("opt2"));
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_impact","id_impact as id,nm_impact as nm","",$bahanCari[6],"id='cboTs'","","Pilih Tema Strategis");
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","id_har as id,nm_har as nm","",$bahanCari[7],"id='cboHar'","","Pilih Topik");
		
			///$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mk","judul_mk as id,judul_mk as nm,id_medsos as opt,id_jt as opt2,DATE_FORMAT(tgl0_mk,'%m') as opt3,YEAR(tgl0_mk) as opt4","",$bahanCari[10],"id='cboJudulmk'","","Pilih Judul",Array("opt2","opt3","opt4"));
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_mkm","judul_mkm as id,judul_mkm as nm,DATE_FORMAT(tgl0_mkm,'%m') as opt3,YEAR(tgl0_mkm) as opt4","",$bahanCari[8],"id='cboFilJudulmkm'","","Pilih Judul",Array("opt3","opt4"));
		
			$cbobidang .=  $this->CI->fn->createCbo(Array("Aktif","Tidak Aktif"),Array("Aktif","Tidak Aktif"),$bahanCari[9],"id='cboSt'","","Pilih Status");
			//$cbobidang="";
		}	
		else
		if($mnu=="brt")
		{
			//$cbobidang.=$this->createCbofromDb("tb_jnsptamu","id_jnsptamu as id,nm_jnsptamu as nm","",$bahanCari[6],"","","Pilih Jenis Keperluan");
			//echo $bahanCari[4];
			
			$cbobidang = $this->CI->fn->createCbofromDb(
											"tb_anal a INNER JOIN tb_st b ON a.id_st = b.id_st  WHERE b.id_uns = 'UN020' GROUP BY a.id_st ORDER BY nm_st ",
											"ins_st as id, ins_st as nm, jab_st as opt, ins_st as opt2 ",
											"",
											$bahanCari[5],
											"id='cboFilterMediaSt' style='width: 100%' ",
											"txt[5]",
											"Pilih Media",
											Array("opt2"));
										

			$cbobidang .= $this->CI->fn->createCbofromDb("tb_mediatier",
									"id_mediatier as id,nm_mediatier as nm","",$bahanCari[6],"id='cboJenisBeritaFil'","txt[6]","Pilih Level Media");
			
			$cbobidang .= $this->CI->fn->createCbo(Array("Online","Cetak"),Array("Online","Cetak"),$bahanCari[7],"id='cboJenisBeritaFil'","txt[7]","Pilih Jenis Media");
			
			
			$cbobidang .=  $this->CI->fn->createCbofromDb("tb_harapan WHERE jns_har = 'Eksternal'","nm_har as id,nm_har as nm","",$bahanCari[11],"id='cboHar'","txt[11]","Pilih Topik");
			$cbobidang .= $this->CI->fn->createCbofromDb(
											"tb_anal a INNER JOIN tb_st b ON a.id_st = b.id_st  GROUP BY a.id_st ORDER BY nm_st ",
											"a.id_st as id, nm_st as nm, jab_st as opt, ins_st as opt2 ",
											"",
											$bahanCari[8],
											"id='cboFilterNaraSt' style='width: 100%' ",
											"txt[8]",
											"Pilih Narasumber",
											Array("opt2"));
												
			$cbobidang .= $this->CI->fn->createCbo(Array("Rilis","Non Rilis"),Array("Rilis","Non Rilis"),$bahanCari[9],"id='cboPlacement'","txt[9]","Pilih Placement");
			
			$cbobidang .= $this->CI->fn->createCbo(Array("Untuk menjadi perhatian","Perlu segera ditindaklanjuti","Aman"),
			Array("Untuk menjadi perhatian","Perlu segera ditindaklanjuti","Aman"),$bahanCari[10],"id='cboStatusFil'","txt[10]","Pilih Status");
		
		}	
		else
		if($mnu=="eva")
		{

			
			$cbobidang .= $this->CI->fn->createCbofromDb("tb_st","id_st as id, nm_st as nm","",$bahanCari[6],"id='cboStFil'","","Pilih Stakeholder");
			$isi = 
			
			$cbobidang .= $this->CI->fn->createCbo(Array(1,2,3,4,5),Array(1,2,3,4,5),$bahanCari[7],"id='cboRateFil'","","Pilih Rating");
			$cbobidang .= $this->CI->fn->createCbo(Array("Belum diisi","Sudah diisi"),Array("Belum diisi oleh Stakeholder","Sudah diisi oleh Stakeholder"),$bahanCari[8],"id='cboStEva'","","Pilih Status Pengisian");
		}	
		else
		if(count($bahanCari)==7)
		{
			
			$cbobidang.=$this->createCbofromDb("tb_jnskeg","id_jnskeg as id,nm_jnskeg as nm","",$bahanCari[6],"id='cbojkeg'","","Pilih Jenis Kegiatan");
		}
		else
		if(count($bahanCari)==8 && $mnu<>"rec")
		{
			
			$cbobidang.=$this->createCbo(array(1,2,3),array("Unsafe Action","Unsafe Condition","Nearmiss"),$bahanCari[6],"","","Pilih Jenis Laporan");
			$cbobidang.=$this->createCbo(array(1,2,3),array("K3","Lingkungan","Keamanan"),$bahanCari[7],"","","Pilih Jenis Lingkup");
			$cbobidang.=$this->createCbo(array(0,1,2),array("Laporan belum ditutup","Laporan ditutup","Laporan tidak benar"),$bahanCari[7],"","","Pilih Status");
		//$cbobidang.=$this->createCbofromDb("tb_jnskeg","id_jnskeg as id,nm_jnskeg as nm","",$bahanCari[6],"id='cbojkeg'","","Pilih Jenis Kegiatan");
		}
		/*
		else
		if(count($bahanCari)==9)
		{
					
			$cbobidang.=$this->createCbofromDb("tb_mitra ","id_mitra as id,nm_mitra as nm","",$bahanCari[6],"id='cbojkeg'","","Pilih Mitra");
			$cbobidang.=$this->createCbo(array(0,1,2),array("Waiting approval","Approved","Rejected"),$bahanCari[7],"","","Pilih Status Izin");
		//$cbobidang.=$this->createCbofromDb("tb_jnskeg","id_jnskeg as id,nm_jnskeg as nm","",$bahanCari[6],"id='cbojkeg'","","Pilih Jenis Kegiatan");
		}
		*/
	}
	else
	if($mnu=="infokontak")
	{
		$cbothn="";
		$cbobln="";
		$cbotgl="";
		$cboupel="";
		$cbousub="";
		$cbobidang=$this->CI->fn->createCbofromDb("tb_daerahikkd","id_daerahikkd as id,nm_daerahikkd as nm","",$bahanCari[0],"id='cbodaerahikkd'","","Pilih Daerah");
		$cbobidang.=$this->CI->fn->createCbofromDb("tb_instansiikkd","id_instansiikkd as id,nm_instansiikkd as nm","",$bahanCari[1],"id='cboinstansiikkd'","","Pilih Instansi");

	}
	else
	if($mnu=="komitmen")
	{
		$cbothn=$this->createCbofromDb("tb_komitmen ORDER BY tahun_komitmen DESC","tahun_komitmen as id,tahun_komitmen as nm","",$bahanCari[0],"id='cbokomitmen'","","Pilih Tahun");
		$cbobln="";
		$cbotgl="";
		$cboupel="";
		$cbousub="";
		$cbobidang="";
	}
	else
	if($mnu=="st")
	{
		
		$cbothn = $this->CI->fn->createCbo(Array("Eksternal","Internal"),Array("Eksternal","Internal"),$bahanCari[0],"id='cboJenisFil'","","Pilih Jenis");
		$cbobln = $this->CI->fn->createCbofromDb("tb_tlst","id_tlst as id, nm_tlst as nm","",$bahanCari[1],"","","Pilih Tingkat");
		$cbotgl = $this->CI->fn->createCbofromDb("tb_unsur ORDER BY nm_uns ","id_uns as id, nm_uns as nm, jns_uns as opt","", $bahanCari[2],"id='cboUnsurFil'","","Pilih Unsur");
		
		$cboupel=$this->CI->fn->createCbo(Array("Aktif","Nonaktif"),Array("Aktif","Nonaktif"),$bahanCari[3],"id='cboStatusFil'","","Pilih Status");
		$cbousub="";
		$cbobidang="";
	}
	else
	{
		$cbothn="";
		$cbobln="";
		$cbotgl="";
		$cboupel=$this->createCbofromDb("tb_upel","id_upel as id,nm_upel as nm","",$bahanCari[0],"id='cboupel'","","Pilih Unit Pelaksana");
		$cbousub=$this->createCbofromDb("tb_usub WHERE id_upel = '".$bahanCari[0]."'  ","id_usub as id,nm_usub as nm","",$bahanCari[1],"id='cbousub'","","Pilih Sub Unit Pelaksana");
		$cbobidang=$this->createCbofromDb("tb_jnsbidang a INNER JOIN tb_detjnsbidang b ON a.id_jnsbidang = b.id_jnsbidang WHERE b.id_upel = '".$bahanCari[0]."' ","a.id_jnsbidang as id,a.nm_jnsbidang as nm","",$bahanCari[2],"id='cbobidang'","","Pilih Bidang");
	}
		return Array($tambahan,"	<div class='panel collapse ".$col."' id='search-collapse''>
								<div class='panel-body '>".$cbothn.$cbobln.$cbotgl.$cboupel.$cbousub.$cbobidang."<br>
									<button class='btn btn-success btn-flat'>Apply</button>
									<a href='".site_url().$viewLink.$lnk."' class='btn btn-danger btn-flat'>Reset</a>
								</div>
							</div>");
	}
	
	//export to PDF
	public function exporttoPDF($pdfHeader,$pdfTitle,$widthArr,$renderTemp)
	{
		
		$pdf = $this->CI->fnpdf;
		$pdf->AddPage("L","Legal");
		
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,7,'Laporan '.$pdfTitle,0,1,'C');
		$pdf->Ln();
		if($renderTemp->num_rows()>0)
		{
			$height=5;
			$width=25;
					
		//$pdf->Image(base_url()."assets/images/logo.png",12,5,20);
		//$pdf->Image(base_url()."assets/images/approved.png",140,30,-200);
		
		//header
		
		//sub header
		
		$pdf->SetFont('Arial','',6);
		
		//echo count($pdfHeader);
		$i=0;
		foreach($pdfHeader as $label)
		{
			
			if($i<count($pdfHeader))
			{
				$nextLine=0;
				if($i==count($pdfHeader)-1)
					$nextLine=1;
				$pdf->Cell($widthArr[$i],$height,$label,1,$nextLine,'C');
			}
			$i++;
			
		}
		foreach($renderTemp->result() as $row)
		{
			
				$i=0;
				foreach($row as $label)
				{
					if($i<count($pdfHeader))
					{
						$nextLine=0;
						if($i==count($pdfHeader)-1)
							$nextLine=1;
						$pdf->Cell($widthArr[$i],$height,$label,1,$nextLine,'C');
					}
					$i++;
				}
			
		}
		
			
		}
		else
		{
			
				$pdf->Cell(0,0,"No data",1,0,'C');
		}
		
		$pdf->Output("I");
	}

	//export to Excel
	public function exporttoExcel($excelHeader,$excelTitle,$widthArr,$renderTemp)
	{
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		$rowArr=Array(
						"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
						"AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
						"BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
						"CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ",
						"DA","DB","DC","DD","DE","DF","DG","DH","DI","DJ","DK","DL","DM","DN","DO","DP","DQ","DR","DS","DT","DU","DV","DW","DX","DY","DZ"
					);
		
		if($renderTemp->num_rows()>0)
		{
			//echo $renderTemp->num_rows();		
			
			$objPHPExcel->getActiveSheet()->setCellValue($rowArr[0].'1', $excelTitle);
			$i=0;
			foreach($excelHeader as $label)
			{
							
				$objPHPExcel->getActiveSheet()->setCellValue($rowArr[$i].'3', $label);
				
				$objPHPExcel->getActiveSheet()->getColumnDimension($rowArr[$i])->setAutoSize(true);
				$i++;
			}
			
			$excelRow=4;
			foreach($renderTemp->result() as $row)
			{
				//if($excelRow<=600)
				//{
					$i=0;
					foreach($row as $label)
					{
						if($i<count($excelHeader))
						{
							$objPHPExcel->getActiveSheet()->setCellValue($rowArr[$i].$excelRow, $label);
						}
						$i++;
					}
					
					$excelRow++;
				//}
			}
			
			$styleArray = array(
			'alignment' => array(
                'horizontal' =>  PHPExcel_Style_Alignment::HORIZONTAL_CENTER ,
                'vertical' =>  PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			  )
			);
			$batas=$excelRow;
			$objPHPExcel->getActiveSheet()->getStyle('A3:'.$rowArr[$i-1].$batas)->applyFromArray($styleArray);
			// Rename sheet
			$objPHPExcel->getActiveSheet()->setTitle($excelTitle);


	
			
		}
		else
		{
			
			$objPHPExcel->getActiveSheet()->setCellValue('A1', "No data");
		}
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		//header('Content-Type: application/pdf');
		header('Content-Disposition: attachment;filename="'.$excelTitle."_".Date("Y-m-d").'.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		
		//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
		$objWriter->save('php://output');
		
	}
	
	public function readExcel($fileName, $fileLocation)
	{
		
		//$objPHPExcel = new PHPExcel();
		
		$inputFileName = $fileLocation . $fileName;

		//  Read your Excel workbook
		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch(Exception $e) {
			die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		}

		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();

		//  Loop through each row of the worksheet in turn
		$xlsData = null;
		for ($row = 1; $row <= $highestRow; $row++){ 
			//  Read a row of data into an array
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
											NULL,
											TRUE,
											FALSE);
			$xlsData[] = $rowData[0];
				//echo implode("<br>",$rowData[0])."<hr>"; 
			//  Insert row data array into your database of choice here
		}
		return $xlsData;
	}
	//print PDF SIngle File export to PDF
	public function printPDF($pdfHeader,$pdfTitle,$widthArr,$renderTemp,$from,$pic)
	{
		if($renderTemp->num_rows()>0)
		{
			$wid=174;
			$widPartial=58;
			$widLeft=35;
			$height=7;
			$row=$renderTemp->row();
			$coor=explode(",",$row->coordinate);
			$lat=$coor[0];
			$latdms=$this->DDtoDMS($lat);
			$lng=$coor[1];
			$lngdms=$this->DDtoDMS($lng);
		
					
			$pdf = $this->CI->fnpdf;
			$pdf->AddPage("L","A5");
			$pdf->SetMargins(0.4,0.2,0.2,0.2);
			$pdf->SetAutoPageBreak(False);
			$pdf->SetTextColor(255,255,255);
			$pdf->Image(base_url()."assets/upload/".$from."/".$pic,0,0,232);
			//$pdf->Image(base_url()."assets/images/approved.png",140,30,-200);
			
			//header
			$pdf->SetFillColor(200);
			$pdf->Rect(0, 113, 232, 36, 'F');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,7,"",0,1,'C');
			
			$pdf->SetY(-35);
			
			//sub header
			
			$pdf->SetFont('Arial','',9);
			$pdf->SetFillColor(0,0,0);
			$pdf->Cell($widLeft,35,"Map",1,0,'C');
			$pdf->Cell($wid,$height,$row->address,1,1,'C');
			
			$pdf->Cell($widLeft,$height,"",0,0,'C');
			$pdf->Cell($widPartial,$height,"",1,0,'C');
			$pdf->Cell($widPartial,$height," Decimal",1,0,'C');
			$pdf->Cell($widPartial,$height," DMS",1,1,'C');
			
			//latitude
			$pdf->Cell($widLeft,$height,"",0,0,'C');
			$pdf->Cell($widPartial,$height,"Latitude",1,0,'C');
			$pdf->Cell($widPartial,$height,$lat,1,0,'C');
			$pdf->Cell($widPartial,$height,$latdms['deg']." ".$latdms['min']."'".$latdms['sec']."''",1,1,'C');
			//longitude
			$pdf->Cell($widLeft,$height,"",0,0,'C');
			$pdf->Cell($widPartial,$height,"Longitude",1,0,'C');
			$pdf->Cell($widPartial,$height,$lng,1,0,'C');
			$pdf->Cell($widPartial,$height,$lngdms['deg']." ".$lngdms['min']."'".$lngdms['sec']."''",1,1,'C');
			//date
			
			$pdf->Cell($widLeft,$height,"",0,0,'C');
			$pdf->Cell($wid,$height,$row->tgl,1,1,'C');
			//echo count($pdfHeader);
	
			
			
			$pdf->Output("I");
			
		}
	}
	
	//check file extension
	public function checkExtension($filename,$folderName,$viewLink,$id="")
	{
		$retVal="";
		
		$ext=strtolower(substr($filename,strlen($filename)-3,3));
					
		if($ext=="pdf")
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' >".$filename."</a>";
		else
		if($ext=="jpg" || $ext=="png" || $ext=="bmp" || $ext=="gif" || strtolower(substr($filename,strlen($filename)-4,4))=="jpeg"  || strtolower(substr($filename,strlen($filename)-4,4))=="jfif")
		{
			//$retVal="<a data-toggle='tooltip' title='Open File ".$filename."' href='".base_url().$viewLink."/printPDF/".$id."/".$filename."' target='_blank'><img src='".base_url().$folderName.$filename."' width='200px'></a>";
			$retVal="<a data-toggle='tooltip' title='Open File ".$filename."' href='".base_url().$folderName.$filename."' target='_blank'><img src='".base_url().$folderName.$filename."' width='200px'></a>";
			
		}
		else
		if($ext=="mkv" || $ext=="mp4" || $ext=="flv" || $ext=="bmp" || $ext=="mov" )
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' title='Putar ".$filename."' class='fa fa-film fa-2x' >&nbsp;</a>";
		else
		if($ext=="xls" || strtolower(substr($filename,strlen($filename)-4,4))=="xlsx"  )
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' >".$filename."</a>";
		else
		if($ext=="doc" || strtolower(substr($filename,strlen($filename)-4,4))=="docx"  )
			$retVal="<a target='_blank' href='".base_url().$folderName.$filename."' >".$filename."</a>";
		
		return $retVal;
	}
	
	public function checkAge($codeUser)
	{
		$retVal=0;
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$empData=$this->CI->Mmain->qRead("tb_emp WHERE code_user='".$codeUser."'","tgllhr_emp","")->row();
		$empAge=date("Y")-substr($empData->tgllhr_emp,0,4);
		if($empAge>56)
		{
			$this->CI->Mmain->qUpdPart2(	"tb_emp  ",
								"st_emp='0' ",
								" code_user='".$codeUser."'  "
								);
			$retVal=1;
		}
		else
		{
			$retVal=0;
		}
		return $retVal;
	}
	
	public function getAccess($codeUser,$formName)
	{
		$retVal=0;
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$accessData=$this->CI->Mmain->qRead("
											tb_accfrm a
											INNER JOIN tb_user b ON a.id_acc = b.id_acc
											INNER JOIN tb_frm c ON c.code_frm = c.code_frm
											WHERE b.code_user='".$codeUser."' AND c.id_frm = '".$formName."' ","","")->row();
		
		return $accessData;
	}
	
	public function generateDocumentNumber($tb,$numField,$dateField,$identifier,$upel="",$bidang="")
	{
		$no="";
		$upel=($upel=="" ? $this->CI->session->userdata('id_upel') : $upel );
		$bidang=($bidang=="" ? $this->CI->session->userdata('id_jnsbidang') : $bidang );
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$notemp=$this->CI->Mmain->qRead($tb." WHERE id_upel='".$upel."' AND NOT ".$numField." ='' AND SUBSTR(".$dateField.",1,4)='".date("Y")."' ORDER BY substr(".$numField.",1,4) DESC LIMIT 1 ","","");
		if($notemp->num_rows()>0)
		{
			$no=sprintf("%04s",substr($notemp->row()->$numField,1,4)+1);
			$nm_upel="";
			$nm_jnsbidang="";
			$cekupel=$this->CI->Mmain->getid($upel,"tb_upel","id_upel","nm_upel");
			if($cekupel<>"")
			{
			
				$nm_upel="/".$cekupel;
				$cekjnsbidang=$this->CI->Mmain->getid($bidang,"tb_jnsbidang","id_jnsbidang","nm_jnsbidang");
				if($cekjnsbidang<>"")
					$nm_jnsbidang="/".$cekjnsbidang;
			}
			$no.=".".$identifier.$nm_upel.$nm_jnsbidang."/".date("Y");
		}
		else
		{
			
			$nm_upel="";
			$nm_jnsbidang="";
			$cekupel=$this->CI->Mmain->getid($upel,"tb_upel","id_upel","nm_upel");
			if($cekupel<>"")
			{
			
				$nm_upel="/".$cekupel;
				$cekjnsbidang=$this->CI->Mmain->getid($bidang,"tb_jnsbidang","id_jnsbidang","nm_jnsbidang");
				if($cekjnsbidang<>"")
					$nm_jnsbidang="/".$cekjnsbidang;
			}
			$no="0001.".$identifier.$nm_upel.$nm_jnsbidang."/".date("Y");
			
		}
		
		return $no;
	}
	
	public function generateDocumentNumberwithoutBidang($tb,$numField,$dateField,$identifier,$upel="",$bidang="")
	{
		$no="";
		$upel=($upel=="" ? $this->CI->session->userdata('id_upel') : $upel );
		$bidang=($bidang=="" ? $this->CI->session->userdata('id_jnsbidang') : $bidang );
		$this->CI->load->database();
		$this->CI->load->model('Mmain');
		$notemp=$this->CI->Mmain->qRead($tb." WHERE id_upel='".$upel."' AND NOT ".$numField." ='' AND YEAR(".$dateField.")=YEAR(CURDATE()) ORDER BY substr(".$numField.",1,4) DESC LIMIT 1 ","","");
		
		if($notemp->num_rows()>0)
		{
			$no=sprintf("%04s",substr($notemp->row()->$numField,0,4)+1);
			$nm_upel="";
			$nm_jnsbidang="";
			$cekupel=$this->CI->Mmain->getid($upel,"tb_upel","id_upel","nm_upel");
			if($cekupel<>"")
			{
			
				$nm_upel="/".$cekupel;
			
			}
			$no.=".".$identifier.$nm_upel."/".date("Y");
		}
		else
		{
			
			$nm_upel="";
			$nm_jnsbidang="";
			$cekupel=$this->CI->Mmain->getid($upel,"tb_upel","id_upel","nm_upel");
			if($cekupel<>"")
			{
			
				$nm_upel="/".$cekupel;
			}
			$no="0001.".$identifier.$nm_upel."/".date("Y");
			
		}
		
		return $no;
	}
	
	
	function DMStoDD($deg,$min,$sec)
	{

		// Converting DMS ( Degrees / minutes / seconds ) to decimal format
		return $deg+((($min*60)+($sec))/3600);
	}    

	function DDtoDMS($dec)
	{
		// Converts decimal format to DMS ( Degrees / minutes / seconds ) 
		$vars = explode(".",$dec);
		$deg = $vars[0];
		$tempma = "0.".$vars[1];

		$tempma = $tempma * 3600;
		$min = floor($tempma / 60);
		$sec = $tempma - ($min*60);

		return array("deg"=>$deg,"min"=>$min,"sec"=>$sec);
	}  
	
	public function createCheckboxfromDB($cboTb,$cboSel,$chkName,$cboDef = null)
	{
			//init modal
			$cboemp=" 
                   ";
			if($cboDef <> null)
				if(!is_array($cboDef))
					$cboDef = explode(",",$cboDef);
				
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,"");
			
			foreach($qemp->result() as $row)
			{
				$chk="";
				if($cboDef <> null)
				foreach($cboDef as $def)
				{
				if($def == $row->nm || $def == $row->id )
					$chk="checked"	;
					
				}
			
			
				$opt = isset($row->opt) ? " data-opt='".$row->opt."' " : "";
			
				$cboemp.=" 	<div class='checkbox chk' $opt>
							<label style='margin-left:20px'>
								<input type='checkbox' name=$chkName  value='".$row->id."' $chk>&nbsp;".$row->nm."&nbsp;
							</label>
							</div>";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function createButtonCheckboxfromDB($cboTb,$cboSel,$chkName,$cboDef = null,$chkClass2=null,$chkClass=null,$chkId=null,$chkIdDet=null)
	{
		//echo "<script>alert('".$chkId."')</script>";
			//init modal
			$cboemp=" 
                   ";
			if($cboDef <> null)
				if(!is_array($cboDef))
					$cboDef = explode(",",$cboDef);
				
			$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,"");
		
			foreach($qemp->result() as $row)
			{
				$chk="";	
				$act="";
				$isc=0;
				if($cboDef <> null)
					foreach($cboDef as $def)
					{
						if($def == $row->nm || $def == $row->id )
						{
							$chk="checked";
							$act="active";
						}
					}
			
			
				$opt = isset($row->opt) ? " data-opt='".$row->opt."' " : "";
			
				$cboemp.=" 	
			

				<div class='chk btn-group $chkClass' $opt data-toggle='buttons' $chkId>
							<label style='margin:5px' class='btn btn-default $act'>
								<input type='checkbox' name=$chkName  value='".$row->id."' $chk $opt $chkId>&nbsp;".$row->nm."&nbsp;							
							</label>
							</div>";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function createButtonCheckbox($chkItemId,$chkVal,$chkName,$cboDef = null,$chkClass=null,$chkID=null,$cboAdd=null)
	{
			//init modal
			$cboemp=" 
                   ";
			if($cboDef <> null)
				if(!is_array($cboDef))
					$cboDef = explode(",",$cboDef);
				
			//$qemp=$this->CI->Mmain->qRead($cboTb,$cboSel,"");
		
			foreach($chkItemId as $i => $row)
			{
				$chk="";	
				$act="";
				$isc=0;
				if($cboDef <> null)
					foreach($cboDef as $def)
					{
						if($def == $chkVal[$i] || $def == $row )
						{
							$chk="checked";
							$act="active";
						}
					}
			
			
				$opt =  " data-opt='".$row."' ";
				
				
				if($cboAdd <> null)
				{
					$opt .= " data-nil='".$cboAdd[$i]."' ";
				}
			
				$cboemp.=" 	
			

				<div class='chk btn-group $chkClass' $opt data-toggle='buttons' $chkID>
							<label style='margin:5px' class='btn btn-default $act'>
								<input type='checkbox' name=$chkName  value='".$row."' $chk $opt $chkID>&nbsp;".$chkVal[$i]."&nbsp;							
							</label>
							</div>";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	
	public function createCheckbox($idArr,$valArr,$chkName,$cboDef = null)
	{
			//init modal
			$cboemp=" 
                   ";
			if($cboDef <> null)
				if(!is_array($cboDef))
					$cboDef = explode(",",$cboDef);
				
			
			foreach($idArr as $i => $row)
			{
				$chk="";
				if($cboDef <> null)
				foreach($cboDef as $def)
				{
				if($def == $row || $def == $valArr[$i] )
					$chk="checked"	;
					
				}
			
				$cboemp.=" 	<div class='checkbox'>
							<label style='margin-left:20px'>
								<input type='checkbox' name=$chkName  value='".$row."' $chk>&nbsp;".$valArr[$i]."&nbsp;
							</label>
							</div>";
			}
			
			$cboemp.="";
		return $cboemp;
	}
	
	public function getMonthName($M)
	{
		$M = sprintf("%02s",$M);
		switch($M)
		{
			case "01" : return "Januari"; break;
			case "02" : return "Februari"; break;
			case "03" : return "Maret"; break;
			case "04" : return "April"; break;
			case "05" : return "Mei"; break;
			case "06" : return "Juni"; break;
			case "07" : return "Juli"; break;
			case "08" : return "Agustus"; break;
			case "09" : return "September"; break;
			case "10" : return "Oktober"; break;
			case "11" : return "November"; break;
			case "12" : return "Desember"; break;
		}
	}
	
	public function checkWag($idUpel,$idUsub,$no)
	{
		
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			
			$cekWag = $this->CI->Mmain->qRead("tb_wg a WHERE id_upel = '".$idUpel."' AND id_usub='".$idUsub."' ORDER BY id_wg",
												"GROUP_CONCAT(id_wg) AS wag");
				$isLapor=0;
				if($cekWag->num_rows() > 0)
				{
						$wag = explode(",",$cekWag->row()->wag);///explode(",",$cekWag->row()->wag);
						asort($wag);
						$wagTemp = "('".implode("','",$wag)."')";
						$wag = implode(",",$wag);
						
							//$row->no = $wag;//implode(",",$wag);
						$cekLapor =  $this->CI->Mmain->qRead("tb_lp WHERE wag_lp in ".$wagTemp."  AND no_mkm ='".$no."' ORDER BY wag_lp ",
						"GROUP_CONCAT(wag_lp) as wag","");
						
						$isLapor=0;
						if($cekLapor->num_rows() > 0)
						{
							$lp = 	explode(",",$cekLapor->row()->wag);
							asort($lp);
							$lp = implode(",",$lp);
							$isLapor = $wag == $lp ? 1 : 0;
							//$row->no = $wag."|".$lp;
							
							//$isOwner= $access->acc1==1 ? 1 : 0;
							
						}
						
				}
				
				return $isLapor;
	}
	
		public function getWagTotal($idUpel,$idUsub,$no)
		{
		
			$this->CI->load->database();
			$this->CI->load->model('Mmain');
			
				
			$wag = $this->CI->Mmain->qRead("tb_wg WHERE id_upel = '".$idUpel."' AND id_usub = '".$idUsub."' ","")->num_rows();
			$lp = $this->CI->Mmain->qRead("tb_lp WHERE wag_lp in (SELECT id_wg from tb_wg WHERE id_upel = '".$idUpel."' AND id_usub = '".$idUsub."') AND no_mkm = '".$no."' ")->num_rows();
			return $wag-$lp;
		}
		
		
	public function converttoOrderedItem($id,$ord,$link,$jum)
	{
		
		$tempOrder="";
		if($ord == 1 )
		$tempOrder = "<a class='btn btn-default btn-flat btn-xs' disabled><i class='fa fa-chevron-up fa-xs'></i></a>&nbsp;&nbsp;";
		else
		$tempOrder = "<a href='".$link.$id."/".$ord."/up'  class='btn btn-success btn-flat btn-xs'><i class='fa fa-chevron-up fa-xs'></i></a>&nbsp;&nbsp;";
		
		$tempOrder .= $ord ;
					
					
		if($ord == $jum )
		$tempOrder .= "&nbsp;&nbsp;<a href='#' class='btn btn-default btn-flat btn-xs' disabled><i class='fa fa-chevron-down fa-xs'></i></a>" ;
		else
		$tempOrder .= "&nbsp;&nbsp;<a href='".$link.$id."/".$ord."/down' class='btn btn-danger btn-flat btn-xs'><i class='fa fa-chevron-down fa-xs'></i></a>" ;
				
		return $tempOrder;
	}
	
	}
	
	

?>