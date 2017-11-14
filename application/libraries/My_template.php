<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class My_template {
   protected $_ci;
   function __construct()
   {
      $this->_ci =&get_instance();
   }

   function admin_template($template, $data=null)
   {
      $data['_adminHeader']=$this->_ci->load->view('admin/header', $data, true);
      $data['_adminSideBar']=$this->_ci->load->view('admin/side_bar', $data, true);
      $data['_adminContentHeader']=$this->_ci->load->view('admin/content_header', $data, true);
      $data['_adminContent']=$this->_ci->load->view($template, $data, true);
      $this->_ci->load->view('templates/admin_template', $data);
   }

   function login($template, $data=null)
   {
      $data['_userLogin']=$this->_ci->load->view($template, $data, true);
      $this->_ci->load->view($template, $data);
   }

   function site_template($tempHeader, $template, $data=null)
   {
      $data['_siteHeader']=$this->_ci->load->view('site/'.$tempHeader, $data, true);
      $data['_siteContent']=$this->_ci->load->view($template, $data, true);
      $data['_siteFooter']=$this->_ci->load->view('site/footer', $data, true);
      $this->_ci->load->view('templates/site_template', $data);
   }
}
