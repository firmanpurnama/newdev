<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_group extends CI_Controller 
{
   var $content_header;
   var $default_limit = 10;
   var $default_start = 0;
   var $start_page = 1;
   var $end_page = 1;
   var $number_page = 1;
   var $group_name;
   var $key_word = null;
   var $gid;
   var $action_form;
   var $error_msg;
   public function __construct()
   {
      parent::__construct();
      $this->my_lib->cekAuth();
      //$this->code_start = $this->benchmark->mark('code_start');
      $this->load->helper('cookie');
      if (get_cookie('search')) {
         $this->key_word = get_cookie('search');
      }

      if (get_cookie('limit')) {
         $this->default_limit = get_cookie('limit');
      }

      $this->load->model('group_model');
      $this->content_header = "User Group";
   }

   public function index($page=null)
   {
      $this->output->enable_profiler(TRUE);
      $this->dc('search'); //buang cookie
            
      //set_cookie
      if ($this->input->post('limit')) {
         set_cookie('limit', $this->input->post('limit'), '3600');
      }

      if (!is_null($page)) {
         $result = $this->group_model->get($this->default_limit, $this->default_start)->result();
      }else{
         $result = $this->group_model->get()->result();
      }

      //paging
      $np = $this->page_num();
      $this->paging($page, $np);

      $data['user_groups'] = $result;
      $this->my_template->admin_template('admin/user_group/index', $data);
   }

   public function detail($id)
   {
      $this->dc('search'); //buang cookie
      $this->dc('limit'); //buang cookie

      $result = $this->group_model->get_id($id)->row();
      $this->gid = $result->id;
      $this->group_name = $result->group_name;

      $this->my_template->admin_template('admin/user_group/detail');
   }

   public function search($page=null)
   {
      //set_cookie
      if ($this->input->post('search')) {
         set_cookie('search', $this->input->post('search'), '3600');
      }

      if ($this->input->post('limit')) {
         set_cookie('limit', $this->input->post('limit'), '3600');
      }

      //paging
      $np = $this->page_num_search($column=null, $key_word=null);
      $this->paging($page, $np);

      if (!is_null($this->key_word)) {
         if (!is_null($page)) {
            $result = $this->group_model->search('group_name', $this->key_word, $this->default_limit, $this->default_start)->result();
         }else{
            $result = $this->group_model->search('group_name', $this->key_word)->result();
         }
      }

      $data['user_groups'] = $result;
      $this->my_template->admin_template('admin/user_group/search', $data);
   }

   public function add()
   {
      $this->dc('search'); //buang cookie
      $this->dc('limit'); //buang cookie

      $this->action_form = base_url('admin/Users_group/save');
      $this->my_template->admin_template('admin/user_group/form');
   }

   public function edit($id)
   {
      $result = $this->group_model->get_id($id)->row();
      $this->gid = $result->id;
      $this->group_name = $result->group_name;

      $this->action_form = base_url('admin/Users_group/save/'.$id);
      $this->my_template->admin_template('admin/user_group/form');
   }

   public function save($id=null)
   {
      $config = array(
            array('field'=>'group_name', 'label'=>'group name', 'rules'=>'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE) {
         $dataIn = array('group_name' => $this->input->post('group_name'));
         if (is_null($id)) {
            $this->group_model->add($dataIn);
         }else{
            $this->group_model->update($id, $dataIn);
         }
         redirect('admin/Users_group');
      }else{
         $this->group_name = $this->input->post('group_name');
         $this->error_msg = validation_errors();
      }

      if (is_null($id)){
         $this->action_form = base_url('admin/Users_group/save/');
      }else{
         $this->action_form = base_url('admin/Users_group/save/'.$id);
         $result = $this->group_model->get_id($id)->row();
         $this->gid = $result->id;
         $this->group_name = $result->group_name;
      }
      
      $this->my_template->admin_template('admin/user_group/form');
   }

   public function delete($id)
   {
      $this->group_model->delete($id);
      redirect('admin/Users_group');
   }
   
   public function dc($cookie_name)
   {
      if (get_cookie('limit') !== null) {
         delete_cookie($cookie_name);
      }
   }

   public function page_num($condition=null)
   {
      if (is_null($condition)) {
         $num_row = $this->group_model->get_count();
      }else{
         $num_row = $this->group_model->get_count($condition);
      }
      
      return ceil($num_row/$this->default_limit);
   }

   public function page_num_search($column=null, $key_word=null)
   {
      $num_row = $this->user_group->search_count($column, $key_word);
      return ceil($num_row/$this->default_limit);
   }

   public function paging($page=null, $num_rows)
   {
      if (!is_null($page)) {
         $this->default_start = ($page - 1) * $this->default_limit;
         $this->start_page = $page;
         $this->end_page = $this->default_start;
      }

      if ($this->end_page > $num_rows) {
         $this->end_page = $num_rows;
         $this->start_page = $num_rows - $this->default_limit;
      }

      if ($this->start_page < 1 ){
         $this->start_page = 1;
      }
   }
}