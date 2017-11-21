<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller 
{
   var $content_header;
   var $error_msg;
   var $breadcrumb;
   public function __construct()
   {
      parent::__construct();
      $this->load->model('users_model');
      $this->content_header = "Welcome Admin";
      $this->breadcrumb = array(array('url'=>'admin/auth', 'title'=>'Admin'));
   }

   public function index(){
      date_default_timezone_set('Asia/Jakarta');
      array_push($this->breadcrumb, array('url'=>'auth/logout', 'title'=>'Logout'));
      
      $config = array(
               array('field' => 'email', 'label' => 'email', 'rules' => 'required'),
               array('field' => 'passwd', 'label' => 'Password', 'rules' => 'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE) {
         $email = $this->input->post('email');
         $passwd = $this->input->post('password');
         //echo md5($passwd); die();
         $kondisi = array('email'=>$email, 'passwd'=>md5($passwd));
         $rslt = $this->users_model->login($kondisi);

         if ($rslt->num_rows() != 0){
            $user = $rslt->row();
            $data_session = array(
                  'user_id' => $user->id,
                  'user_name' => $user->user_name,
                  'user_email' => $user->email,
                  'user_group' => $user->group_id,
                  'user_last_login' => $user->last_login
               );
            $this->session->set_userdata($data_session);

            $data = array('last_login'=> date('Y-m-d H:i:s'));
            $this->users_model->update($user->id, $data);
            //redirect('admin/users');
         }else{
            $this->error_msg = 'salah user name atau password';
         }
      }else{
         $this->error_msg = validation_errors();
      }

      if ($this->session->userdata('user_id') == ''){
         $this->my_template->login('admin/login');
      }else{
         $this->my_template->admin_template('admin/admin_default', false);
      }
   }

   public function logout(){
      $this->session->sess_destroy();
      //redirect('admin/auth');
      $this->my_template->login('admin/login');
   }
}