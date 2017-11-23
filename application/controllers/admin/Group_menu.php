<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group_menu extends CI_Controller 
{
   var $content_header;
   var $default_limit = 15;
   var $default_start = 0;
   var $start_page = 1;
   var $end_page = 1;
   var $number_page = 1;
   var $show_page = 10;

   var $sidebar_main_menu;
   var $sidebar_menu;

   var $action_form;
   var $error_msg;
   var $keyword;
   var $condition;
   var $breadcrumb;

   var $group_id;
   var $main_menu_id;

   public function __construct()
   {
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      $this->my_lib->cekAuth();
      $this->sidebar_main_menu = $this->my_lib->sidebar_main_menu();
      $this->sidebar_menu = $this->my_lib->sidebar_menu();
      $this->load->model(array('group_menu_model','main_menu_model','group_model'));
      $this->content_header = "Group Menu";
      $this->breadcrumb = array(array('url'=>'admin/group_menu', 'title'=>'Group Menu'));
   }

   public function index($page=null)
   {
      $this->set_default_limit();
      if (!is_null($page)  and is_int($page)) {
         $this->get_default_limit();
         $this->set_default_start($page);
         $rslt = $this->group_menu_model->get($this->default_limit, $this->default_start)->result();
      }else{
         $rslt = $this->group_menu_model->get()->result();
      }

      $data['group_menu'] = $rslt;
      $this->my_template->admin_template('admin/group_menu/index', $data);
   }

   public function add()
   {
      array_push($this->breadcrumb, array('url'=>'admin/group_menu/add', 'title'=>'Add'));
      $data['groups'] = $this->group_model->get()->result();
      $data['main_menu'] = $this->main_menu_model->get(null, null, array('menu_type'=>1))->result();
      $this->action_form = base_url('admin/group_menu/save');
      $this->my_template->admin_template('admin/group_menu/form', $data);
   }

   public function update($group_id)
   {
      $this->group_id = $group_id;
      array_push($this->breadcrumb, array('url'=>'admin/group_menu/update', 'title'=>'Update'));
      $data['groups'] = $this->group_model->get()->result();
      $data['main_menu'] = $this->main_menu_model->get(null, null, array('menu_type'=>1))->result();
      $data['group_menu'] = $this->group_menu_model->get(null,null,array('group_id'=>$group_id))->result();
      $this->action_form = base_url('admin/group_menu/save/'.$group_id);
      $this->my_template->admin_template('admin/group_menu/form', $data);
   }

   public function save($group_id=null)
   {
      $config = array(
            array('field'=>'group_id', 'label'=>'user group', 'rules'=>'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE){
         if (count($this->input->post('ck_main_menu') > 0)){
            if ($this->group_menu_model->get_count(array('group_id' => $this->input->post('group_id'))) > 0) {
               $this->group_menu_model->delete($this->input->post('group_id'));
            }

            foreach ($this->input->post('ck_main_menu') as $key => $value) {
               $data_in = array(
                     'group_id'=>$this->input->post('group_id'),
                     'main_menu_id'=>$value
                  );
               $this->group_menu_model->add($data_in);
            }
            redirect('admin/group_menu');
         }else{
            $this->error_msg = "pilih menu";
         }
      }else{
         $this->error_msg = validation_errors();
      }

      $data['groups'] = $this->group_model->get()->result();
      $data['main_menu'] = $this->main_menu_model->get(null, null, array('menu_type'=>1))->result();
      
      if (!is_null($group_id)){
         array_push($this->breadcrumb, array('url'=>'admin/group_menu/update', 'title'=>'Update'));
         $this->action_form = base_url('admin/group_menu/save/'.$group_id);
      }else{
         array_push($this->breadcrumb, array('url'=>'admin/group_menu/update', 'title'=>'Add'));
         $data['group_menu'] = $this->group_menu_model->get(null,null,array('group_id'=>$group_id))->result();
         $this->action_form = base_url('admin/group_menu/save/');
      }
      $this->my_template->admin_template('admin/group_menu/form', $data);
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