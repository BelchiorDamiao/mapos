<?php

class Insumos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idInsumos', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->like('codDeBarra', $where);
            $this->db->or_like('descricao', $where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->where('idInsumos', $id);
        $this->db->limit(1);

        return $this->db->get('insumos')->row();
    }

    public function add($table, $data)
    {
        
		$this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function updateEstoque($produto, $quantidade, $operacao = '-')
    {
        $sql = "UPDATE insumos set estoque = estoque $operacao ? WHERE idInsumos = ?";

        return $this->db->query($sql, [$quantidade, $produto]);
    }
}
