<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{
    public function is_valid_token($token)
    {
        // Verifique se o token existe na tabela de tokens
        $this->db->where('token', $token);
        $query = $this->db->get('tblmulti_pipeline_api_tokens');
        return $query->num_rows() > 0;
    }

    public function get_all_tokens()
{
    $this->db->select('*');
    $this->db->from('tblmulti_pipeline_api_tokens'); // Usando o nome correto da tabela
    $query = $this->db->get();
    return $query->result();
}
}