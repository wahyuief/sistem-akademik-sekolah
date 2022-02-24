<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah_model extends CI_Model {
    private $table_name = 'sekolah';
    public function get($where = null, $searchQuery = false, $columnName = false, $columnSortOrder = false, $rowperpage = false, $start = false)
    {
        if (isset($where)) {
            $this->db->where($where);
        }

        if ($searchQuery) {
            $this->db->where($searchQuery);
        }

        if ($columnName) {
            $this->db->order_by($columnName, $columnSortOrder);
        }

        if ($rowperpage) {
            $this->db->limit($rowperpage, $start);
        }
        $this->db->where(['hapus'=>'0']);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() <= 0){
			return [];
		}
        return $query->result();
    }
    public function get_where($where)
    {
        $this->db->where($where);
        $this->db->limit(1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() <= 0){
			return [];
		}
        return $query->row();
    }
    public function save($data)
    {
        $this->db->set($data);
        $this->db->insert($this->table_name);
        return $this->db->insert_id();
    }
    public function edit($id, $data)
    {
        $this->db->where(['hapus'=>'0']);
        $this->db->where('id', $id);
        $this->db->update($this->table_name, $data);
        return $this->get_where(['id' => $id]);
    }
    public function remove($id)
    {
        $this->db->where(['sekolah_id'=>_sekolah()->id]);
        $this->db->where(['id'=>$id]);
        $this->db->update($this->table_name, ['hapus'=>'1']);
        return $this->get_where(['id'=>$id])->hapus;
    }
}