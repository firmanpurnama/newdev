<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu extends CI_Controller 
{
   var $content_header;
   var $default_limit = 15;
   var $default_start = 0;
   var $start_page = 1;
   var $end_page = 1;
   var $number_page = 1;
   var $show_page = 10;

   var $action_form;
   var $error_msg;
   var $keyword;
   var $condition;
   var $breadcrumb;

   var $menu_name;
   var $menu_link;
   var $menu_order;
   var $main_menu_id;
   var $backend;
   var $frontend;

   public function __construct()
   {
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      $this->my_lib->cekAuth();
      $this->load->model(array('main_menu_model','menu_model'));
      $this->content_header = "Menu";
      $this->breadcrumb = array(array('url'=>'admin/menu', 'title'=>'Menu'));
   }

   public function index($page=NULL)
   {
      $this->set_default_limit();
      if (!is_null($page)  and is_int($page)) {
         $this->get_default_limit();
         $this->set_default_start($page);
         $rslt = $this->menu_model->get($this->default_limit, $this->default_start)->result();
      }else{
         $rslt = $this->menu_model->get()->result();
      }

      //paging
      $num_row = $this->menu_model->get_count();
      $this->paging($num_row, $page);

      $data['menus'] = $rslt;
      $this->my_template->admin_template('admin/menu/index', $data);
   }

   public function search($page=null)
   {
      array_push($this->breadcrumb, array('url'=>'admin/menu/search', 'title'=>'Search'));
      $column = 'main_menu_name';
      
      $config = array(
            array('field'=>'search', 'label'=>'search', 'rules'=>'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE){
         $this->set_keyword();
      }else{
         $this->error_msg = validation_errors();
      }
      $this->get_keword();

      if (!is_null($page) and is_int($page)) {
         $this->set_default_start($page);
      }

      if (!empty($this->keyword)){
         $result = $this->menu_model->search($column, $this->keyword, $this->default_limit, $this->default_start)->result();
      }else{
         $result = array();
      }

      $data['menus'] = $result;
      $this->my_template->admin_template('admin/menu/index', $data);
   }

   public function detail($id)
   {
      array_push($this->breadcrumb, array('url'=>'admin/menu/detail/'.$id, 'title'=>'Detail'));
      $data['menu'] = $this->menu_model->get_id($id)->row();
      $this->my_template->admin_template('admin/menu/detail', $data);
   }

   public function add()
   {
      array_push($this->breadcrumb, array('url'=>'admin/menu/add', 'title'=>'Add'));
      $condition = array('menu_type'=>0);
      $data['main_menu'] = $this->main_menu_model->get(null, null, $condition)->result();
      $this->action_form = base_url('admin/menu/save');
      $this->my_template->admin_template('admin/menu/form', $data);
   }

   public function update($id)
   {
      array_push($this->breadcrumb, array('url'=>'admin/menu/update/'.$id, 'title'=>'Update'));
      $condition = array('menu_type'=>0);
      $data['main_menu'] = $this->main_menu_model->get(null, null, $condition)->result();
      $this->action_form = base_url('admin/menu/save/'.$id);
      $result = $this->menu_model->get_id($id)->row();
      $this->menu_name = $result->menu_name;
      $this->menu_link = $result->menu_link;
      $this->menu_order = $result->menu_order;
      $this->main_menu_id = $result->main_menu_id;
      $this->backend = $result->back_end;
      $this->frontend = $result->front_end;
      $this->my_template->admin_template('admin/menu/form', $data);
   }

   public function save($id=null)
   {
      $config = array(
            array('field'=>'menu_name', 'label'=>'menu name', 'rules'=>'required'),
            array('field'=>'menu_link', 'label'=>'menu link', 'rules'=>'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE){
         $data_in = array(
               'menu_name'=>$this->input->post('menu_name'),
               'menu_link'=>$this->input->post('menu_link'),
               'menu_order'=>$this->input->post('menu_order'),
               'main_menu_id'=>$this->input->post('main_menu_id'),
               'back_end'=>$this->input->post('back_end'),
               'front_end'=>$this->input->post('front_end')
            );
         if (is_null($id)){
            $this->menu_model->add($data_in);
         }else{
            $this->menu_model->update($id, $data_in);
         }
         redirect('admin/menu');
      }else{
         $this->menu_name = $this->input->post('menu_name');
         $this->menu_link = $this->input->post('menu_link');
         $this->menu_order = $this->input->post('menu_order');
         $this->main_menu_id = $this->input->post('main_menu_id');
         $this->backend = $this->input->post('back_end');
         $this->frontend = $this->input->post('front_end');
         $this->error_msg = validation_errors();
      }

      if (is_null($id)){
         array_push($this->breadcrumb, array('url'=>'admin/menu/Add', 'title'=>'Add'));
         $this->action_form = base_url('admin/main_menu/save/');
      }else{
         array_push($this->breadcrumb, array('url'=>'admin/menu/update/'.$id, 'title'=>'Update'));
         $this->action_form = base_url('admin/menu/save/'.$id);
      }

      $this->my_template->admin_template('admin/menu/form', $data);
   }

   public function delete($id)
   {
      $this->menu_model->delete($id);
      redirect('admin/menu');
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