<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barang_model extends CI_Model 
{
   private $defaultLimit = 10;
   private $defaultStart = 0;
   function __construct(){
      // Call the Model constructor
      parent::__construct();
   }

   public function get($limit=null, $start=null, $condition=null)
   {
      $this->db->select('barang.*, jenis.nama_jenis, jenis.detail as detail_jenis, kemasan.nama_kemasan, kemasan.isi');
      $this->db->join('jenis', 'jenis.id=barang.jenis');
      $this->db->join('kemasan', 'kemasan.id=barang.kemasan');
      $this->db->order_by('product_name', 'ASC');
      
      if (!is_null($limit) or !is_null($start)) {
         if (!is_null($limit)) {
            $this->defaultLimit = $limit;
         }

         if (!is_null($start)) {
            $this->defaultStart = $start;
         }
         $this->db->limit($this->defaultLimit, $this->defaultStart);
      }
      
      if (is_null($condition)) {
         return $this->db->get('barang');
      }else{
         return $this->db->get_where('barang', $condition);
      }
   }

   public function get_count($condition=null)
   {
      $this->db->select('barang.*, jenis.nama_jenis, jenis.detail as detail_jenis, kemasan.nama_kemasan, kemasan.isi');
      $this->db->join('jenis', 'jenis.id=barang.jenis');
      $this->db->join('kemasan', 'kemasan.id=barang.kemasan');

      if (!is_null($condition)) {
         $this->db->where($condition);
      }
      $this->db->order_by('product_name', 'ASC');
      return $this->db->count_all_results('barang');
   }

   public function search($column=null, $key_word=null, $limit=null, $start=null)
   {
      $this->db->select('barang.*, jenis.nama_jenis, jenis.detail as detail_jenis, kemasan.nama_kemasan, kemasan.isi');
      $this->db->join('jenis', 'jenis.id=barang.jenis');
      $this->db->join('kemasan', 'kemasan.id=barang.kemasan');

      if (!is_null($key_word)) {
         if (!is_null($column)){
            if (!is_array($column)){
               $this->db->like($column, $key_word);
            }else{
               foreach ($column as $key => $val) {
                  $this->db->like($val, $key_word);
               }
            }
         }
      }
      
      if (!is_null($limit) or !is_null($start)) {
         if (!is_null($limit)) {
            $this->defaultLimit = $limit;
         }

         if (!is_null($start)) {
            $this->defaultStart = $start;
         }
         $this->db->limit($this->defaultLimit, $this->defaultStart);
      }
      return $this->db->get('barang');
   }

   public function search_count($column=null, $key_word=null)
   {
      $this->db->select('barang.*, jenis.nama_jenis, jenis.detail as detail_jenis, kemasan.nama_kemasan, kemasan.isi');
      $this->db->join('jenis', 'jenis.id=barang.jenis');
      $this->db->join('kemasan', 'kemasan.id=barang.kemasan');
      $this->db->like($column, $key_word);
      return $this->db->count_all_results('barang');
   }

   public function get_id($id)
   {
      return $this->db->get_where('barang', array('id'=>$id));
   }

   public function add($data)
   {
      $this->db->insert('barang', $data);
   }

   public function update($id, $data)
   {
      $this->db->where('id', $id);
      $this->db->update('barang', $data);
   }

   public function delete($id)
   {
      $this->db->where('id', $id);
      $this->db->delete('barang');
   }
}