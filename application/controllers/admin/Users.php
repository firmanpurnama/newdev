<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller 
{
   var $content_header;
   var $default_limit = 10;
   var $default_start = 0;
   var $start_page = 0;
   var $end_page = 1;
   var $number_page = 1;
   var $show_page = 10;

   var $action_form;
   var $error_msg;
   var $keyword;
   var $condition;
   var $breadcrumb;

   var $user_name;
   var $user_email;
   var $user_group_name;
   var $user_group_id;

   var $sidebar_main_menu;
   var $sidebar_menu;

   public function __construct()
   {
      parent::__construct();
      $this->my_lib->cekAuth();
      $this->sidebar_main_menu = $this->my_lib->sidebar_main_menu();
      $this->sidebar_menu = $this->my_lib->sidebar_menu();
      $this->load->model(array('users_model','group_model'));
      $this->content_header = "Users";
      $this->breadcrumb = array(array('url'=>'admin/users', 'title'=>'Users'));
   }

   public function index($page=null)
   {
      $this->set_default_limit();
      if (is_null($page)) {
         $rslt = $this->users_model->get()->result();
      }else{
         $this->get_default_limit();
         $this->set_default_start($page);
         $rslt = $this->users_model->get($this->default_limit, $this->default_start)->result();
      }

      //paging
      $num_row = $this->users_model->get_count();
      $this->paging($num_row, $page);
      
      /*
      $this->load->helper('cookie');
      set_cookie('coba_cookies', 'ini dia', '3600', base_url(), 'admin/users');
      echo "qqq ".get_cookie('coba_cookies');
      delete_cookie('test_cookie', base_url(), 'admin/users');
      */
      $data['users'] = $rslt;
      $this->my_template->admin_template('admin/user/index', $data);
   }

   public function search($page=null)
   {
      array_push($this->breadcrumb, array('url'=>'admin/users/search', 'title'=>'Search'));

      $config = array(
            array('field'=>'search', 'label'=>'search', 'rules'=>'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE) {
         $this->condition = "user_name = ".$this->keyword." OR email = ".$this->keyword;
         $this->set_keyword();
      }else{
         $this->error_msg = validation_errors();
      }
      $this->get_keword();
      
      if (is_null($page)) {
         $rslt = $this->users_model->get(null, $page, $this->condition)->result();
      }else{
         $this->set_default_start($page);
         $rslt = $this->users_model->get($this->default_limit, $this->default_start, $this->condition)->result();
      }
      
      $data['users'] = $rslt;
      $this->my_template->admin_template('admin/user/index', $data);
   }

   public function detail($id)
   {
      array_push($this->breadcrumb, array('url'=>'admin/users/detail/'.$id, 'title'=>'Detail'));
      $data['user'] = $this->users_model->get($id)->row();
      $this->my_template->admin_template('admin/user/detail', $data);
   }

   public function add()
   {
      array_push($this->breadcrumb, array('url'=>'admin/users/add', 'title'=>'Add'));
      $this->action_form = base_url('admin/users/save');
      $data['user_groups'] = $this->group_model->get()->result();
      $this->my_template->admin_template('admin/user/form', $data);
   }
   
   public function update($id)
   {
      array_push($this->breadcrumb, array('url'=>'admin/users/update/'.$id, 'title'=>'Update'));
      $this->action_form = base_url('admin/users/save/'.$id);
      $data['user_groups'] = $this->group_model->get()->result();
      $rslt = $this->users_model->get_id($id)->row();
      if (count($rslt) > 0) {
         $this->user_name = $rslt->user_name;
         $this->user_email = $rslt->email;
         $this->user_group_name = $rslt->group_name;
         $this->user_group_id = $rslt->group_id;
      }
      //$data['user'] = $rslt;
      $data['form_action'] = base_url('admin/users/save/'.$id);
      $this->my_template->admin_template('admin/user/form', $data);
   }

   public function save($id=null)
   {
      $config = array(
            array('field'=>'user_name', 'label'=>'user name', 'rules'=>'required'),
            array('field'=>'email', 'label'=>'email', 'rules'=>'required'),
            array('field'=>'group_id', 'label'=>'group name', 'rules'=>'required')
         );   

      if (is_null($id) or !empty($this->input->post('passwd'))){
         array_push($config, array('field' => 'passwd', 'label' => 'Password', 'rules' => 'required'));
         array_push($config, array('field' => 'cpasswd', 'label' => 'Confirmation Password', 'rules' => 'required|matches[passwd]'));
      }

      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE){
         $data_in['user_name'] = $this->input->post('user_name');
         $data_in['email'] = $this->input->post('email');
         $data_in['group_id'] = $this->input->post('group_id');

         if (is_null($id) or !empty($this->input->post('passwd'))){
            $data_in['passwd'] = md5($this->input->post('passwd'));
            $data_in['en_passwd'] = $this->encryption->encrypt($this->input->post('passwd'));
         }

         if (is_null($id)){
            $this->users_model->add($data_in);
         }else{
            $this->users_model->update($id, $data_in);
         }
         redirect('admin/users');
      }else{
         $this->user_group_id = $this->input->post('group_id');
         $this->user_name = $this->input->post('user_name');
         $this->user_email = $this->input->post('email');
         $this->error_msg = validation_errors();
      }

      if (is_null($id)){
         array_push($this->breadcrumb, array('url'=>'admin/users/Add', 'title'=>'Add'));
         $this->action_form = base_url('admin/users/save/');
      }else{
         array_push($this->breadcrumb, array('url'=>'admin/users/update/'.$id, 'title'=>'Update'));
         $this->action_form = base_url('admin/users/save/'.$id);
      }

      $data['user_groups'] = $this->group_model->get()->result();
      $this->my_template->admin_template('admin/user/form', $data);
   }

   public function delete($id)
   {
      $this->users_model->delete($id);
      redirect('admin/users');
   }

   public function set_default_limit()
   {
      if (!empty($this->input->post('default_limit'))) {
         $this->session->set_flashdata('default_limit', $this->input->post('search'), 300);
         //set_cookie('default_limit', $this->input->post('default_limit'), '3600', base_url(), 'admin/main_menu');
      }
   }

   public function get_default_limit()
   {
      if ($this->session->has_userdata('default_limit')) {
         $this->default_limit = $this->default_limit = $this->session->flashdata('default_limit');
      }
   }

   public function delete_default_limit()
   {
      if ($this->session->has_userdata('default_limit')) {
         $this->session->default_limit('default_limit');
      }
   }

   public function set_default_start($page)
   {
      if ($this->session->has_userdata('default_limit')) {
         $this->default_limit = $this->default_limit = $this->session->flashdata('default_limit');
      }
      $this->default_start = ($page - 1) * $this->default_limit;
   }

   public function set_keyword()
   {
      if (!empty($this->input->post('search'))) {
         $this->session->set_flashdata('keyword', $this->input->post('search'), 300);
         //$this->session->set_userdata('keyword', $this->input->post('search'));
      }
   }

   public function get_keword()
   {
      if ($this->session->has_userdata('keyword')) {
         $this->keyword = $this->session->flashdata('keyword');
         //$this->keyword = $this->session->userdata('keyword');
      }
   }

   public function delete_keyword()
   {
      if ($this->session->has_userdata('keyword')) {
         $this->session->unset_userdata('keyword');
      }
   }

   public function paging($num_row, $page)
   {
      $this->number_page = ceil($num_row / $this->default_limit);
      if (!is_null($page)){
         $this->start_page = $page - $this->show_page;
         $this->end_page = ($page - 1) + $this->show_page;
      }else{
         $this->end_page = ($this->start_page - 1) + $this->show_page;
      }

      if ($this->start_page < 1) {
         $this->start_page = 1;
      }

      if ($this->end_page > $this->number_page) {
         $end_page = $this->number_page;
      }
   }
}