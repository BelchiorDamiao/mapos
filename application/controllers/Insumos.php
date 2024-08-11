<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Insumos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('insumos_model');
        $this->data['menuInsumos'] = 'Insumos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar insumos.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('insumos/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->insumos_model->count('insumos');
        if($pesquisa) {
            $this->data['configuration']['suffix'] = "?pesquisa={$pesquisa}";
            $this->data['configuration']['first_url'] = base_url("index.php/insumos")."\?pesquisa={$pesquisa}";
        }

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->insumos_model->get('insumos', '*', $pesquisa, $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'insumos/insumos';

        return $this->layout();
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aInsumos')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar insumos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';
		echo $this->input->post('preco');
        if ($this->form_validation->run('insumos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            
            $preco = $this->input->post('preco');
            $preco = str_replace(',', '', $preco);
            $data = [
               
                'nomeInsumo' => set_value('nome'),
                
                'valorInsumo' => $preco
            ];
			
            if ($this->insumos_model->add('insumos', $data) == true) {
                $this->session->set_flashdata('success', 'Produto adicionado com sucesso!');
                log_info('Adicionou um insumo');
                redirect(site_url('insumos/adicionar/'));
            } else {
               // $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured.</p></div>';
            }
        }
        $this->data['view'] = 'insumos/adicionarInsumo';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eInsumos')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar insumos.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('insumos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
          
            $preco = $this->input->post('preco');
            $preco = str_replace(',', '', $preco);
            $data = [
               
                'nomeInsumo' => $this->input->post('nome'),
               
                'valorInsumo' => $preco
            ];

            if ($this->insumos_model->edit('insumos', $data, 'idInsumos', $this->input->post('idInsumos')) == true) {
                $this->session->set_flashdata('success', 'Insumo editado com sucesso!');
                log_info('Alterou um insumo. ID: ' . $this->input->post('idInsumos'));
                redirect(site_url('insumos/editar/') . $this->input->post('idInsumos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>An Error Occured</p></div>';
            }
        }

        $this->data['result'] = $this->Insumos_model->getById($this->uri->segment(3));

        $this->data['view'] = 'insumos/editarInsumo';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar insumos.');
            redirect(base_url());
        }

        $this->data['result'] = $this->insumos_model->getById($this->uri->segment(3));

        if ($this->data['result'] == null) {
            $this->session->set_flashdata('error', 'Insumo não encontrado.');
            redirect(site_url('insumos/editar/') . $this->input->post('idInsumos'));
        }

        $this->data['view'] = 'insumos/visualizarInsumo';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dProduto')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir insumos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir produto.');
            redirect(base_url() . 'index.php/insumos/gerenciar/');
        }

       
        $this->insumos_model->delete('insumos', 'idInsumos', $id);

        log_info('Removeu um insumo. ID: ' . $id);

        $this->session->set_flashdata('success', 'Insumo excluido com sucesso!');
        redirect(site_url('insumos/gerenciar/'));
    }

 
}
