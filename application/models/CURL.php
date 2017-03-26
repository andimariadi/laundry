<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class CURL extends CI_Model
{
	
	public function tambah($table, $data)
	{
		return $this->db->insert($table, $data);
	}
	public function cari($table, $data)
	{
		return $this->db->get_where($table, $data);
	}
	public function cariselect($table, $select, $where, $order_by)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $this->db->get();
	}
	public function tampil($table)
	{
		$data = $this->db->get($table);
		return $data->result_array();
	}
	public function tampilselect($table, $order_by)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $data = $this->db->get();
	}
	public function edit($table, $where, $data)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}

	public function hapus($table, $data)
	{
		return $this->db->delete($table, $data);
	}
	public function like($table, $data) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->or_like($data);
		return $this->db->get();
	}
	public function likeorand($table, $data, $datas) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->or_like($data);
		$this->db->where($datas);
		return $this->db->get();
	}

	public function status($status)
	{
		$data = $this->CURL->cari('user', array('username' => $this->session->userdata('username')));
		foreach ($data->result_array() as $key):
			return $key[$status];
		endforeach;
		if($data->num_rows() <= 0) {
			$this->session->sess_destroy();
		}
	}
	public function multijoinwhere($table, $join, $where, $order_by, $select)
	{
		$this->db->select($select);
		$this->db->from($table);
		foreach ($join as $data => $value) {
			$this->db->join($data, $value, 'left');
		}
		$this->db->where($where);
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $this->db->get();
	}
	public function multijoin($table, $join, $order_by, $select)
	{
		$this->db->select($select);
		$this->db->from($table);
		foreach ($join as $data => $value) {
			$this->db->join($data, $value, 'left');
		}
		$this->db->order_by($order_by['order'], $order_by['by']);
		return $this->db->get();

	}

	public function query($query)
	{
		$query = $this->db->query($query);
		return $query->result_array();
	}
}
?>