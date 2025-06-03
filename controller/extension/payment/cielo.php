<?php
class ControllerExtensionPaymentCielo extends Controller {
    private $error = array();

    public function index() {
        $data = $this->load->language('extension/payment/cielo');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_cielo', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/payment/cielo', 'user_token=' . $this->session->data['user_token'], true));
            } else {
                $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
            }
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['user_token'] = $this->session->data['user_token'];

        $erros = array(
            'warning',
            'chave',
            'stores',
            'customer_groups',
            'merchant_id',
            'soft_descriptor',
            'razao',
            'cnpj',
            'cpf',
            'numero_entrega',
            'complemento_entrega',
            'titulo'
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
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/cielo', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link('extension/payment/cielo', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        include_once(DIR_SYSTEM . 'library/cielo/versao.php');

        $lib = DIR_SYSTEM . 'library/cielo/cielo.php';
        if (is_file($lib)) {
            if (!is_readable($lib)) {
                chmod($lib, 0644);
            }
        }

        $campos = array(
            'chave' => array(0),
            'stores' => array(0),
            'customer_groups' => array(0),
            'total' => '',
            'geo_zone_id' => '',
            'status' => '',
            'sort_order' => '',
            'merchant_id' => '',
            'soft_descriptor' => '',
            'antifraude' => '',
            'debug' => '',
            'desconto_credito' => '',
            'desconto_debito' => '',
            'desconto_boleto' => '',
            'desconto_extension' => '',
            'situacao_pendente_id' => '',
            'situacao_pago_id' => '',
            'situacao_negado_id' => '',
            'situacao_cancelado_id' => '',
            'situacao_nao_finalizado_id' => '',
            'situacao_autorizado_id' => '',
            'custom_razao_id' => '',
            'razao_coluna' => '',
            'custom_cnpj_id' => '',
            'cnpj_coluna' => '',
            'custom_cpf_id' => '',
            'cpf_coluna' => '',
            'custom_numero_id' => '',
            'numero_entrega_coluna' => '',
            'custom_complemento_id' => '',
            'complemento_entrega_coluna' => '',
            'titulo' => '',
            'imagem' => '',
            'one_checkout' => ''
        );

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                if (isset($this->request->post['payment_cielo_'.$campo])) {
                    $data['payment_cielo_'.$campo] = $this->request->post['payment_cielo_'.$campo];
                } else if ($this->config->get('payment_cielo_'.$campo)) {
                    $data['payment_cielo_'.$campo] = $this->config->get('payment_cielo_'.$campo);
                } else {
                    $data['payment_cielo_'.$campo] = $valor;
                }
            } else {
                if (isset($this->request->post['payment_cielo_'.$campo])) {
                    $data['payment_cielo_'.$campo] = $this->request->post['payment_cielo_'.$campo];
                } else {
                    $data['payment_cielo_'.$campo] = $this->config->get('payment_cielo_'.$campo);
                }
            }
        }

        $data['url_retorno'] = HTTPS_CATALOG . 'index.php?route=extension/payment/cielo/cupom';
        $data['url_notificacao'] = HTTPS_CATALOG . 'index.php?route=extension/payment/cielo/notificacao';
        $data['url_status'] = HTTPS_CATALOG . 'index.php?route=extension/payment/cielo/status';

        $data['store_default'] = $this->config->get('config_name');
        $this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();

        $this->load->model('customer/customer_group');
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('setting/extension');
        $totals = $this->model_setting_extension->getInstalled('total');
        foreach ($totals as $key => $code) {
            $this->load->language('extension/total/' . $code);
            $data['totals'][] = array(
                'name' => $this->language->get('heading_title'),
                'code' => $code
            );
        }

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

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

        $this->load->model('extension/payment/cielo');
        $data['columns'] = $this->model_extension_payment_cielo->getColumns();

        $this->load->model('tool/image');
        if (isset($this->request->post['payment_cielo_imagem']) && is_file(DIR_IMAGE . $this->request->post['payment_cielo_imagem'])) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['payment_cielo_imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get('payment_cielo_imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('payment_cielo_imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }
        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $this->update();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/cielo', $data));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/cielo')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $chave = array_filter($this->request->post['payment_cielo_chave']);
        if (empty($chave)) {
            $this->error['chave'] = $this->language->get('error_chave');
        }

        if (empty($this->request->post['payment_cielo_stores'])) {
            $this->error['stores'] = $this->language->get('error_stores');
        }

        if (empty($this->request->post['payment_cielo_customer_groups'])) {
            $this->error['customer_groups'] = $this->language->get('error_customer_groups');
        }

        if (strlen($this->request->post['payment_cielo_merchant_id']) != 36) {
            $this->error['merchant_id'] = $this->language->get('error_merchant_id');
        }

        if (strlen($this->request->post['payment_cielo_soft_descriptor']) <= 13) {
            if (!preg_match('/^[A-Z0-9]+$/', $this->request->post['payment_cielo_soft_descriptor'])) {
                $this->error['soft_descriptor'] = $this->language->get('error_soft_descriptor');
            }
        } else {
            $this->error['soft_descriptor'] = $this->language->get('error_soft_descriptor');
        }

        $erros_campos = array(
            'razao',
            'cnpj',
            'cpf'
        );

        foreach ($erros_campos as $erro) {
            if ($this->request->post['payment_cielo_custom_'.$erro.'_id'] == 'N') {
                if (!(trim($this->request->post['payment_cielo_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros_campos_numero = array(
            'numero_entrega'
        );

        if ($this->request->post['payment_cielo_custom_numero_id'] == 'N') {
            foreach ($erros_campos_numero as $erro) {
                if (!(trim($this->request->post['payment_cielo_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros_campos_complemento = array(
            'complemento_entrega'
        );

        if ($this->request->post['payment_cielo_custom_complemento_id'] == 'N') {
            foreach ($erros_campos_complemento as $erro) {
                if (!(trim($this->request->post['payment_cielo_'.$erro.'_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        $erros = array(
            'titulo'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post['payment_cielo_'.$erro]))) {
                $this->error[$erro] = $this->language->get('error_'.$erro);
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    public function uninstall() {
        $this->load->model('user/user_group');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/cielo/log');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/cielo/log');
    }

    public function update() {
        if (!$this->user->hasPermission('modify', 'extension/cielo/log')) {
            $this->load->model('user/user_group');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/cielo/log');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/cielo/log');
        }
    }
}