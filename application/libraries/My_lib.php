<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_lib
{
	protected $_ci;
	var $pattern = "/.gif|.jpg|.jpeg|.png|.ico|.mp3|.mp4|.mpeg|.ogg|.pdf|.webm|.GIF|.JPG|.JPEG|.PNG|.ICO|.MP3|.MP4|.MPEG|.OGG|.PDF|.WEBM$/";
	var $allowedYypes = 'gif|jpg|jpeg|png|ico|mp3|mp4|mpeg|ogg|pdf|webm|GIF|JPG|JPEG|PNG|ICO|MP3|MP4|MPEG|OGG|PDF|WEBM';
	var $uploadPath  = './assets/upload/images';

	function __construct()
	{
		$this->_ci =&get_instance();
	}
	
	function cekAuth()
	{
		if ($this->_ci->session->userdata('user_id') == ''){
			redirect('admin/auth');
		}
	}

	function sidebar_main_menu()
	{
		$this->_ci->load->model('group_menu_model');
		return $this->_ci->group_menu_model->get(null, null, array('group_id'=>$this->_ci->session->userdata('user_group')))->result();
	}

	function sidebar_menu()
	{
		$this->_ci->load->model('menu_model');
		return $this->_ci->menu_model->get(null, null, array('menu.back_end'=>1))->result();
	}

	function main_menu()
	{
		$this->_ci->load->model('main_menu_model');
		$where = array('front_end' => 1);
		return $this->_ci->main_menu_model->getWhere($where);
	}

	function sub_menu()
	{
		$this->_ci->load->model('menu_model');
		$condition = array('front_end'=>1);
		return $this->_ci->menu_model->getWhere($condition);
	}

	function fileType($fileName){
		if (preg_match($this->pattern, $fileName, $matches,PREG_OFFSET_CAPTURE)) {
			$ext = $matches[0][0];
			if ((strtolower($ext) == ".gif")or(strtolower($ext) == ".jpg")or(strtolower($ext) == ".jpeg")or(strtolower($ext) == ".png")or(strtolower($ext) == ".gif")or(strtolower($ext) == ".ico")){
				return 0;
			}elseif ((strtolower($ext)==".mp3")or(strtolower($ext)==".mp4")or(strtolower($ext)==".mpeg")or(strtolower($ext)==".mpg")or(strtolower($ext)==".ogg")or(strtolower($ext)==".webm")or(strtolower($ext)==".mkv")) {
				return 1;
			}else{
				return 2;
			}
		}
	}

	function header()
	{
		$this->_ci->load->model('setting_model');
		$header = $this->_ci->setting_model->get(array('keyword'=>'header'));
      	return $header->row();
	}

	function footer()
	{
		$this->_ci->load->model('setting_model');
		$footer = $this->_ci->setting_model->get(array('keyword'=>'footer','parent_id !='=>NULL));
		return $footer->result();
	}

	function main_footer()
	{
		$this->_ci->load->model('setting_model');
		$main_footer = $this->_ci->setting_model->get(array('keyword'=>'footer','parent_id'=>NULL));
		return $main_footer->row();
	}

	function service_title()
	{
		$this->_ci->load->model('setting_model');
		$result = $this->_ci->setting_model->get(array('keyword'=>'service','parent_id'=>NULL));
		$main = $result->row();
		if(count($main)){
			return $main->title;
		}else{
			return "Service default";
		}
	}

	function recent_post()
	{
		//$this->_ci->load->model('main_content_model');
		$this->_ci->db->select('main_content.*, menu.menu_name, main_menu.main_menu_name');
		$this->_ci->db->join('menu', 'main_content.menu_id=menu.id');
		$this->_ci->db->join('main_menu', 'main_content.main_menu_id=main_menu.id');
		$this->_ci->db->order_by('main_content.id', 'ASC');
		$this->_ci->db->limit(10, 0);
		return $this->_ci->db->get('main_content')->result();
	}

	function services()
	{
		$this->_ci->load->model('setting_model');
		$services = $this->_ci->setting_model->get(array('keyword'=>'service','parent_id !='=>NULL));
		return $services->result();
	}

	function uploadFile($inputFileName, $fileName, $i=NULL)
	{
		date_default_timezone_set('Asia/Jakarta');    
		$this->_ci->load->library('upload');
		$newname = "";
		if (preg_match($this->pattern, $fileName, $matches,PREG_OFFSET_CAPTURE)) 
		{
			$ext = $matches[0][0];
			$oldname = str_replace($ext, "", $fileName);

			if ($i!==NULL) {
				$newname = 'bin_'.date("Ymd_His")."-".$i.$ext;
				$_FILES['userFile']['name'] = $_FILES[$inputFileName]['name'][$i];
	            $_FILES['userFile']['type'] = $_FILES[$inputFileName]['type'][$i];
	            $_FILES['userFile']['tmp_name'] = $_FILES[$inputFileName]['tmp_name'][$i];
	            $_FILES['userFile']['error'] = $_FILES[$inputFileName]['error'][$i];
	            $_FILES['userFile']['size'] = $_FILES[$inputFileName]['size'][$i];
        	}else{
				$newname = 'bin_'.date("Ymd_His").$ext;
        		$_FILES['userFile']['name'] = $_FILES[$inputFileName]['name'];
	            $_FILES['userFile']['type'] = $_FILES[$inputFileName]['type'];
	            $_FILES['userFile']['tmp_name'] = $_FILES[$inputFileName]['tmp_name'];
	            $_FILES['userFile']['error'] = $_FILES[$inputFileName]['error'];
	            $_FILES['userFile']['size'] = $_FILES[$inputFileName]['size'];
        	}

			$config = array(
				'file_name'     => $newname,
				'upload_path'   => $this->uploadPath,
				'allowed_types' => $this->allowedYypes,
				'overwrite'     => 1,
				'max_size'     => '99999999'
			);
			$this->_ci->upload->initialize($config);
			if ( ! $this->_ci->upload->do_upload('userFile')) 
			{
				return array('error' => $this->_ci->upload->display_errors());
				//return "0";
			} else {
				// Continue processing the uploaded data
				$this->_ci->upload->data();
				return $newname;
			}
		} else {
			return "0";
		}
	}

	public function hapusFile($nmFile)
	{
		$dir = set_realpath('assets/upload/images');
		//$dir = $_SERVER['DOCUMENT_ROOT']."/assets/images/";
		unlink($dir.$nmFile);
	}

	public function kirimEmail($emailFrom=NULL, $nameSender=NULL, $emailTo=NULL, $nameRecipient=NULL, $subject=NULL, $message=NULL)
	{
		$this->_ci->load->library('email');
		$config['protocol']    = 'smtp';
		$config['smtp_crypto'] = 'ssl';
		$config['smtp_port']    = '465';
		$config['smtp_timeout'] = '7';
		$config['charset'] = 'iso-8859-1';
		$config['newline'] = "\r\n";
		$config['crlf'] = "\r\n";
		$config['mailtype'] = 'text'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not
		$config['useragent'] = "CodeIgniter";
		$config['mailpath'] = "/usr/bin/sendmail";
		$config['wordwrap'] = TRUE;
		$config['smtp_host'] = 'mail.psistaging.net';
		$config['smtp_user'] = 'buattest@psistaging.net';
		$config['smtp_pass'] = 'p45sw0rd';
		//$config['protocol'] = 'sendmail';
		//$config['mailpath'] = '/usr/sbin/sendmail';
		//$config['smtp_port'] = '25';

		$this->_ci->email->initialize($config);
		$this->_ci->email->from($emailFrom, $nameSender);
		$this->_ci->email->to($emailTo, $nameRecipient);
		$this->_ci->email->subject($subject);
		$this->_ci->email->message($message);

		if($this->_ci->email->send()) {
			return 1;
		} else {
			return show_error($this->_ci->email->print_debugger());
			//return 0;
		}
	}
}