<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Group_menu_model extends CI_Model 
{
   function __construct(){
      // Call the Model constructor
      parent::__construct();
   }

   public function get($limit=null, $start=null, $condition=null)
   {
      $this->db->select('group_menu.*, users_group.group_name, main_menu.main_menu_name, main_menu.link, main_menu.menu_type');
      $this->db->join('users_group', 'group_menu.group_id=users_group.id', 'LEFT');
      $this->db->join('main_menu', 'group_menu.main_menu_id=main_menu.id', 'LEFT');
      
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
      $this->db->order_by('group_menu.group_id', 'ASC');
      return $this->db->get('group_menu');
   }

   public function get_count($condition=null)
   {
      $this->db->select('group_menu.*, users_group.group_name, main_menu.main_menu_name');
      $this->db->join('users_group', 'group_menu.group_id=users_group.id', 'LEFT');
      $this->db->join('main_menu', 'group_menu.main_menu_id=main_menu.id', 'LEFT');

      if (!is_null($condition)) {
         $this->db->where($condition);
      }
      return $this->db->count_all_results('group_menu');
   }

   public function search($column=null, $key_word=null, $limit=null, $start=null)
   {
      $this->db->select('group_menu.*, users_group.group_name, main_menu.main_menu_name');
      $this->db->join('users_group', 'group_menu.group_id=users_group.id', 'LEFT');
      $this->db->join('main_menu', 'group_menu.main_menu_id=main_menu.id', 'LEFT');
      
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
      return $this->db->get('group_menu');
   }

   public function add($data)
   {
      $this->db->insert('group_menu', $data);
   }

   public function update($group_id, $data)
   {
      $this->db->where('group_id', $group_id);
      $this->db->update('group_menu', $data);
   }

   public function delete($group_id)
   {
      $this->db->where('group_id', $group_id);
      $this->db->delete('group_menu');
   }
}
