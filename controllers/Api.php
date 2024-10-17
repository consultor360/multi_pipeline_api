<?php
// Caminho: /public_html/modules/multi_pipeline/controllers/Api.php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->model('Lead_model');
        $this->load->library('form_validation');
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
            echo json_encode(['status' => 'success', 'message' => 'Lead adicionado com sucesso', 'lead_id' => $lead_id]);
        } else {
            $this->output->set_status_header( 500);
            echo json_encode(['status' => 'error', 'message' => 'Erro ao adicionar lead', 'code' => 500]);
        }
    }
}