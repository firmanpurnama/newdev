<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test extends CI_Controller 
{
   var $code_start;
   var $code_end;
   var $code_finish;
   public function __construct()
   {
      parent::__construct();
      $this->code_start = $this->benchmark->mark('code_start');
      $this->load->model('users_model');
   }

   public function index()
   {
      $this->output->enable_profiler(TRUE);
      /*$this->code_end = $this->benchmark->mark('code_end');
      $this->code_finish = $this->benchmark->elapsed_time('code_start', 'code_end');*/
      $this->my_template->admin_template('admin/admin_default');
   }

   public function baca()
   {
      $this->load->helper('directory');
      $this->load->helper('file');
      $this->load->helper('text');

      $map = directory_map('./assets/upload/');
      $string = read_file('./assets/upload/test.doc');
      //$string = read_file('./assets/upload/install_config.txt');
      //var_dump($string);
      //echo $string;
      echo ascii_to_entities($string);
   }
}