<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model 
{
   function __construct(){
      // Call the Model constructor
      parent::__construct();
   }

   public function get($limit=null, $start=null, $condition=null)
   {
      $this->db->select('users.id, users.user_name, users.email, users.last_login, users.group_id, users_group.group_name');
      $this->db->join('users_group', 'users.group_id=users_group.id');
      $this->db->order_by('users.id', 'ASC');

      if (!is_null($limit)) {
         if ((int)$limit) {
            $this->db->limit($limit);
         }

         if (!is_null($start)){
            $this->db->limit($limit, $start);
         }
      }

      if (is_null($condition)) {
         return $this->db->get('users');
      }else{
         return $this->db->get_where('users', $condition);
      }
   }

   public function get_id($id)
   {
      $this->db->select('users.id, users.user_name, users.email, users.last_login, users.group_id, users_group.group_name');
      $this->db->join('users_group', 'users.group_id=users_group.id');
      return $this->db->get_where('users', array('users.id'=>$id));
   }

   public function get_count($condition=null)
   {
      if (!is_null($condition)) {
         $this->db->where($condition);
      }
      $this->db->order_by('user_name', 'ASC');
      return $this->db->count_all_results('users');
   }

   public function search($column=null, $key_word=null, $limit=null, $start=null)
   {
      $this->db->select('users.id, users.user_name, users.email, users.last_login, users.group_id, users_group.group_name');
      $this->db->join('users_group', 'users.group_id=users_group.id');
      $this->db->like($column, $key_word);
      $this->db->order_by('user_name', 'ASC');

      if (!is_null($key_word)) {
         $this->db->like($column, $key_word);
      }
      
      if (!is_null($limit)) {
         $this->db->limit($limit);
      }

      if (!is_null($start)) {
         $this->db->limit($limit, $start);
      }
      return $this->db->get('users');
   }

   public function search_count($column=null, $key_word=null)
   {
      $this->db->select('users.id, users.user_name, users.email, users.last_login, users.group_id, users_group.group_name');
      $this->db->join('users_group', 'users.group_id=users_group.id');
      $this->db->like($column, $key_word);
      $this->db->order_by('user_name', 'ASC');
      return $this->db->count_all_results('users');
   }

   public function login($condition)
   {
      return $this->db->get_where('users', $condition);
   }

   public function add($data)
   {
      $this->db->insert('users', $data);
   }

   public function update($id, $data)
   {
      $this->db->where('id', $id);
      $this->db->update('users', $data);
   }

   public function delete($id)
   {
      $this->db->where('id', $id);
      $this->db->delete('users');
   }
}