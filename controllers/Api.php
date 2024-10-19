<?php
// Caminho: /public_html/modules/multi_pipeline/controllers/Api.php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends Admin_controller // Mudança para estender Admin_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->model('Lead_model');
        $this->load->library('form_validation');
        $this->load->helper('admin'); // Carregar o helper admin
    }

    public function add_lead()
    {
        // Autenticação
        $token = $this->input->get_request_header('Authorization');
        if (!$this->Api_model->is_valid_token($token)) {
            $this->output->set_status_header(401);
            echo json_encode(['status' => 'error', 'message' => 'Autenticação inválida', 'code' => 401]);
            return;
        }

        // Validação de dados
        $this->form_validation->set_rules('name', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('pipeline_id', 'Pipeline ID', 'required|integer');
        $this->form_validation->set_rules('stage_id', 'Stage ID', 'required|integer');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('source', 'Fonte', 'required');

        // Validação dos campos opcionais
        $this->form_validation->set_rules('title', 'Título', 'trim');
        $this->form_validation->set_rules('company', 'Empresa', 'trim');
        $this->form_validation->set_rules('description', 'Descrição', 'trim');
        $this->form_validation->set_rules('country', 'País', 'trim');
        $this->form_validation->set_rules('zip', 'CEP', 'trim');
        $this->form_validation->set_rules('city', 'Cidade', 'trim');
        $this->form_validation->set_rules('state', 'Estado', 'trim');
        $this->form_validation->set_rules('address', 'Endereço', 'trim');
        $this->form_validation->set_rules('assigned', 'Atribuído a', 'trim');
        $this->form_validation->set_rules('phonenumber', 'Telefone', 'trim');
        $this->form_validation->set_rules('is_public', 'Público', 'trim');
        $this->form_validation->set_rules('lead_value', 'Valor do Lead', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $this->output->set_status_header(400);
            echo json_encode(['status' => 'error', 'message' => validation_errors(), 'code' => 400]);
            return;
        }

        // Adicionar lead
        $lead_data = [
            'name' => $this->input->post('name'),
            'title' => $this->input->post('title'),
            'company' => $this->input->post('company'),
            'description' => $this->input->post('description'),
            'country' => $this->input->post('country'),
            'zip' => $this->input->post('zip'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'address' => $this->input->post('address'),
            'assigned' => $this->input->post('assigned'),
            'status' => $this->input->post('status'),
            'source' => $this->input->post('source'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website'),
            'phonenumber' => $this->input->post('phonenumber'),
            'is_public' => $this->input->post('is_public'),
            'lead_value' => $this->input->post('lead_value'),
            'stage_id' => $this->input->post('stage_id'),
            'pipeline_id' => $this->input->post('pipeline_id'),
        ];

        $lead_id = $this->Lead_model->add($lead_data);
        if ($lead_id) {
            echo json_encode(['status' => 'success', 'message' => ' Lead adicionado com sucesso', 'lead_id' => $lead_id]);
        } else {
            $this->output->set_status_header( 500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar lead', 'code' => 500]);
        }
    }

    public function add_token()
    {
        // Verificar se o usuário está logado e tem permissão
        if (!is_admin()) {
            access_denied('Adicionar Token API');
        }
    
        // Capturar os dados do formulário
        $data = $this->input->post();
    
        // Adicionar o user_id do usuário atual
        $data['user_id'] = get_staff_user_id();
    
        // Validação dos dados
        $this->form_validation->set_rules('name', 'Nome do Token', 'required|trim');
    
        if ($this->form_validation->run() == FALSE) {
            // Se a validação falhar, redirecionar de volta com erro
            set_alert('danger', _l('form_validation_error'));
            redirect(admin_url('multi_pipeline/api/manage_tokens'));
        } else {
            // Se a validação passar, adicionar o token
            $token_id = $this->Api_model->add_token($data);
    
            if ($token_id) {
                set_alert('success', _l('token_added_successfully'));
            } else {
                set_alert('danger', _l('error_adding_token'));
            }
    
            redirect(admin_url('multi_pipeline/api/manage_tokens'));
        }
    }

    public function test_add_token()
    {
        $token_data = [
            'name' => 'Test Token',
            'user' => 1, // ID do usuário, por exemplo
            'token' => bin2hex(random_bytes(16)), // Gera um token aleatório
        ];

        $result = $this->Api_model->add_token($token_data);
        if ($result) {
            echo "Token adicionado com sucesso! ID: " . $result;
        } else {
            echo "Erro ao adicionar token.";
        }
    }

    public function manage_tokens() {
        $data['tokens'] = $this->Api_model->get_tokens();
        $this->load->view('manage_tokens', $data);
    }
}