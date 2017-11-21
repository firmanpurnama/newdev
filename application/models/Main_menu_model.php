<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main_menu_model extends CI_Model 
{
   function __construct(){
      // Call the Model constructor
      parent::__construct();
   }

   public function get($limit=null, $start=null, $condition=null)
   {
      if (!is_null($limit)) {
         if ((int)$limit) {
            $this->db->limit($limit);
         }

         if (!is_null($start)){
            $this->db->limit($limit, $start);
         }
      }

      if (is_null($condition)) {
         return $this->db->get('main_menu');
      }else{
         return $this->db->get_where('main_menu', $condition);
      }
   }

   public function get_id($id=null)
   {
      return $this->db->get_where('main_menu', array('id'=>$id));
   }

   public function get_count($condition=null)
   {
      if (!is_null($condition)) {
         $this->db->where($condition);
      }
      return $this->db->count_all_results('main_menu');
   }

   public function search($column=null, $key_word=null, $limit=null, $start=null)
   {
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
      return $this->db->get('main_menu');
   }

   public function search_count($column=null, $key_word=null)
   {
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
      return $this->db->count_all_results('main_menu');
   }

   public function add($data)
   {
      $this->db->insert('main_menu', $data);
   }

   public function update($id, $data)
   {
      $this->db->where('id', $id);
      $this->db->update('main_menu', $data);
   }

   public function delete($id)
   {
      $this->db->where('id', $id);
      $this->db->delete('main_menu');
   }
}