<?php
class ControllerExtensionModuleValidacao extends Controller {
    private $error = array();

    public function index() {
        $data = $this->load->language('extension/module/validacao');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('module_validacao', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/module/validacao', 'user_token=' . $this->session->data['user_token'], true));
            } else {
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
            }
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $erros = array(
            'warning',
            'msg_cnpj',
            'msg_cpf',
            'msg_cpf_existe',
            'msg_nascimento',
            'msg_maior_18_anos',
            'msg_celular',
            'msg_bairro',
            'msg_numero'
        );

        foreach ($erros as $erro) {
            if (isset($this->error[$erro])) {
                $data['error_'.$erro] = $this->error[$erro];
            } else {
                $data['error_'.$erro] = '';
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/validacao', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/module/validacao', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

        $data['user_token'] = $this->session->data['user_token'];

        $data['versao'] = '3.3.5';

        $campos = array(
            'cpf_existe' => '',
            'maior_18_anos' => '',
            'remover_placeholder' => '',
            'cep_correios' => '',
            'cep_primeiro' => '',
            'cep_html' => '',
            'razao_social_id' => '',
            'cnpj_id' => '',
            'cpf_id' => '',
            'nascimento_id' => '',
            'celular_id' => '',
            'numero_id' => '',
            'complemento_id' => '',
            'msg_cnpj' => 'O CNPJ não é válido!',
            'msg_cpf' => 'O CPF não é válido!',
            'msg_cpf_existe' => 'O CPF já está cadastrado!',
            'msg_nascimento' => 'A data de nascimento não é válida!',
            'msg_maior_18_anos' => 'Você deve ter no mínimo 18 anos!',
            'msg_celular' => 'O celular não é válido!',
            'msg_bairro' => 'O bairro deve ter entre 3 e 128 caracteres!',
            'msg_numero' => 'O Número não é válido!'
        );

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                if (isset($this->request->post['module_validacao_'.$campo])) {
                    $data['module_validacao_'.$campo] = $this->request->post['module_validacao_'.$campo];
                } else if ($this->config->get('module_validacao_'.$campo)) {
                    $data['module_validacao_'.$campo] = $this->config->get('module_validacao_'.$campo);
                } else {
                    $data['module_validacao_'.$campo] = $valor;
                }
            } else {
                if (isset($this->request->post['module_validacao_'.$campo])) {
                    $data['module_validacao_'.$campo] = $this->request->post['module_validacao_'.$campo];
                } else {
                    $data['module_validacao_'.$campo] = $this->config->get('module_validacao_'.$campo);
                }
            }
        }

        $data['custom_fields'] = array();
        $this->load->model('customer/custom_field');
        $custom_fields = $this->model_customer_custom_field->getCustomFields();
        foreach ($custom_fields as $custom_field) {
            $data['custom_fields'][] = array(
                'custom_field_id' => $custom_field['custom_field_id'],
                'name' => $custom_field['name'],
                'type' => $custom_field['type'],
                'location' => $custom_field['location']
            );
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/validacao', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/validacao')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $erros = array(
            'msg_cnpj',
            'msg_cpf',
            'msg_cpf_existe',
            'msg_nascimento',
            'msg_maior_18_anos',
            'msg_celular',
            'msg_bairro',
            'msg_numero'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post['module_validacao_'.$erro]))) {
                $this->error[$erro] = $this->language->get('error_obrigatorio');
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }
}