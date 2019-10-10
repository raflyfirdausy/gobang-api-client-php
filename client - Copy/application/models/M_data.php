<?php

class M_data extends CI_Model{

	function select($col){
        $query = $this->db->select($col);
        return $query;
    }

    function from($table){
        $query = $this->db->from($table);
        return $query;
    }

    function order_by($col, $type){
        $query = $this->db->order_by($col, $type);
        return $query;
    }

    function limitOffset($limit = null, $offset = null){
        $query = $this->db->limit($limit, $offset);
        return $query;
    }
    
    function distinct(){
        $query = $this->db->distinct();
        return $query;
    }
    
    function getWhere($col,$kon){
        $query = $this->db->where($col,$kon);
        return $query;
	}

	function getOrWhere($col,$kon){
        $query = $this->db->or_where($col,$kon);
        return $query;
	}
	
    function getWheretbl($tabel,$col,$kon){
        $this->db->where($col,$kon);
        $query = $this->db->get($tabel);
        return $query;
    }
    
    function getData($table){
        $query = $this->db->get($table);
        return $query;
    }

    function getJoin($table,$condition,$type){
        $query = $this->db->join($table, $condition, $type);
        return $query;
    }

    function insert($table,$data){
        $query = $this->db->insert($table,$data);
        return $query;
    }

    function update($table, $data, $kondisi) {
        $query = $this->db->update($table, $data, $kondisi);
        return $query->affected_rows();
    }

    function delete($col, $condition,$table) {
        $query = $this->db->where($col, $condition);
        $query = $this->db->delete($table);
        return $query;
    }
    
    function Login($table, $where) {
        return $this->db->get_where($table, $where);
	}
	
    function count_all($table){
        return $this->db->count_all($table);
	}
	
    function count_where($table,$kon,$col){
        return $this->db->where($kon, $col)->count_all_results($table);; 
    }

    function save_batch($table,$data){
        return $this->db->insert_batch($table,$data);
    }

    function update_batch($table,$data,$id){
        return $this->db->update_batch($table,$data,$id);
	}
	
	function groupBy($col){
		$this->db->group_by($col);
	}
}
