<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Menu_model extends CI_Model 
{
   function __construct(){
      // Call the Model constructor
      parent::__construct();
   }

   public function get($limit=null, $start=null, $condition=null)
   {
      $this->db->select('menu.*, main_menu.main_menu_name');
      $this->db->join('main_menu', 'menu.main_menu_id=main_menu.id', 'LEFT');
      
      if (!is_null($condition)) {
         $this->db->where($condition);
      }
      
      if (!is_null($limit)) {
         if ((int)$limit) {
            $this->db->limit($limit);
         }

         if (!is_null($start)){
            $this->db->limit($limit, $start);
         }
      }

      return $this->db->get('menu');
   }

   public function get_id($id=null)
   {
      $this->db->select('menu.*, main_menu.main_menu_name');
      $this->db->join('main_menu', 'menu.main_menu_id=main_menu.id', 'LEFT');
      $this->db->where('id', $id);
      return $this->db->get('menu');
   }

   public function get_count($condition=null)
   {
      $this->db->select('menu.*, main_menu.main_menu_name');
      $this->db->join('main_menu', 'menu.main_menu_id=main_menu.id', 'LEFT');

      if (!is_null($condition)) {
         $this->db->where($condition);
      }

      return $this->db->count_all_results('menu');
   }

   public function search($column=null, $key_word=null, $limit=null, $start=null)
   {
      $this->db->select('menu.*, main_menu.main_menu_name');
      $this->db->join('main_menu', 'menu.main_menu_id=main_menu.id', 'LEFT');

      if (!is_null($key_word)) {
         if (is_array($column)){
            foreach ($column as $key => $col) {
               if ($key == 0) {
                  $this->db->like($col, $key_word);
               }else{
                  $this->db->or_like($col, $key_word);
               }
            }
         }else{
            $this->db->like($column, $key_word);
         }
      }
      
      if (!is_null($limit)) {
         $this->db->limit($limit);
      }

      if (!is_null($start)) {
         $this->db->limit($limit, $start);
      }
      return $this->db->get('menu');
   }

   public function search_count($column=null, $key_word=null)
   {
      $this->db->select('menu.*, main_menu.main_menu_name');
      $this->db->join('main_menu', 'menu.main_menu_id=main_menu.id', 'LEFT');
      
      if (!is_null($key_word)) {
         if (is_array($column)){
            foreach ($column as $key => $col) {
               if ($key == 0) {
                  $this->db->like($col, $key_word);
               }else{
                  $this->db->or_like($col, $key_word);
               }
            }
         }else{
            $this->db->like($column, $key_word);
         }
      }
      return $this->db->count_all_results('menu');
   }

   public function add($data)
   {
      $this->db->insert('menu', $data);
   }

   public function update($id, $data)
   {
      $this->db->where('id', $id);
      $this->db->update('menu', $data);
   }

   public function delete($id)
   {
      $this->db->where('id', $id);
      $this->db->delete('menu');
   }
}