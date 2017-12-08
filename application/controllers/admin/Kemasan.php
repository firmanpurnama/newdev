<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kemasan extends CI_Controller 
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

   var $id_kemasan;
   var $nama_kemasan;
   var $isi;

   var $sidebar_main_menu;
   var $sidebar_menu;

   public function __construct()
   {
      parent::__construct();
      date_default_timezone_set('Asia/Jakarta');
      $this->my_lib->cekAuth();
      $this->sidebar_main_menu = $this->my_lib->sidebar_main_menu();
      $this->sidebar_menu = $this->my_lib->sidebar_menu();
      $this->load->model(array('kemasan_model'));
      $this->content_header = "kemasan";
      $this->breadcrumb = array(array('url'=>'admin/kemasan', 'title'=>'Kemasan'));
   }

   public function index($page=NULL)
   {
      $this->set_default_limit();
      if (!is_null($page)  and is_int($page)) {
         $this->get_default_limit();
         $this->set_default_start($page);
         $rslt = $this->kemasan_model->get($this->default_limit, $this->default_start)->result();
      }else{
         $rslt = $this->kemasan_model->get()->result();
      }

      //paging
      $num_row = $this->jenis_model->get_count();
      $this->paging($num_row, $page);

      $data['kemasan'] = $rslt;
      $this->my_template->admin_template('admin/kemasan/index', $data);
   }

   public function search($page=null)
   {
      array_push($this->breadcrumb, array('url'=>'admin/kemasan/search', 'title'=>'Search'));
      $column = array('nama_kemasan', 'detail');
      $result = array();
      
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
      }

      $data['kemasan'] = $result;
      $this->my_template->admin_template('admin/kemasan/index', $data);
   }

   public function detail($id)
   {
      array_push($this->breadcrumb, array('url'=>'admin/kemasan/detail/'.$id, 'title'=>'Detail'));
      $data['jenis'] = $this->jenis_model->get_id($id)->row();
      $this->my_template->admin_template('admin/jenis/detail', $data);
   }

   public function add()
   {
      array_push($this->breadcrumb, array('url'=>'admin/jenis/add', 'title'=>'Add'));
      $this->action_form = base_url('admin/kemasan/save');
      $this->my_template->admin_template('admin/kemasan/form', false);
   }

   public function update($id)
   {
      array_push($this->breadcrumb, array('url'=>'admin/kemasan/update/'.$id, 'title'=>'Update'));
      $this->action_form = base_url('admin/kemasan/save/'.$id);
      $result = $this->jenis_model->get_id($id)->row();
      $this->id_jenis = $result->id;
      $this->nama_jenis = $result->nama_jenis;
      $this->detail = $result->detail;
      $this->my_template->admin_template('admin/kemasan/form', false);
   }

   public function save($id=null)
   {
      $config = array(
            array('field'=>'nama_kemasan', 'label'=>'nama kemasan', 'rules'=>'required')
         );
      $this->form_validation->set_rules($config);
      if ($this->form_validation->run() == TRUE){
         $data_in = array(
               'nama_kemasan'=>$this->input->post('nama_kemasan'),
               'detail'=>$this->input->post('detail')
               'tanggal'=>date("Y-m-d H:i:s"),
            );
         if (is_null($id)){
            $this->kemasan_model->add($data_in);
         }else{
            $this->kemasan_model->update($id, $data_in);
         }
         redirect('admin/kemasan');
      }else{
         $this->nama_jenis = $this->input->post('nama_kemasan');
         $this->isi = $this->input->post('isi');
         $this->error_msg = validation_errors(); // validasi error
      }

      if (is_null($id)){
         array_push($this->breadcrumb, array('url'=>'admin/kemasan/Add', 'title'=>'Add'));
         $this->action_form = base_url('admin/kemasan/save/');
      }else{
         array_push($this->breadcrumb, array('url'=>'admin/kemasan/update/'.$id, 'title'=>'Update'));
         $this->action_form = base_url('admin/kemasan/save/'.$id);
      }

      $this->my_template->admin_template('admin/kemasan/form', $data);
   }

   public function delete($id)
   {
      $this->jenis_model->delete($id);
      redirect('admin/kemasan');
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