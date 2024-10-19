<?php
// Caminho: /public_html/modules/multi_pipeline/models/Api_model.php
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

public function add_token($data)
{
    // Adiciona o user_id ao array de dados
    $data['user_id'] = $this->session->userdata('user_id'); // Supondo que você armazena o ID do usuário na sessão
    $this->db->insert('tblmulti_pipeline_api_tokens', $data); // Insere os dados na tabela
    return $this->db->insert_id(); // Retorna o ID do token adicionado
}

public function get_tokens() {
    $this->db->select('*');
    $this->db->from('tblmulti_pipeline_api_tokens');
    $query = $this->db->get();
    return $query->result();
}

public function save_token($token, $name) {
    $data = array(
        'token' => $token,
        'name' => $name
    );
    $this->db->insert('tblmulti_pipeline_api_tokens', $data);
    return $this->db->affected_rows() > 0;
}
}
