<?php
class ControllerExtensionPaymentItauShopline extends Controller {
    const TYPE = 'payment_';
    const NAME = 'itau_shopline';
    const CODE = self::TYPE . self::NAME;

    private $error = array();

    public function index() {
        $data = $this->load->language('extension/payment/itau_shopline');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (
            $this->request->server['REQUEST_METHOD'] == 'POST'
            && $this->validate()
        ) {
            $this->model_setting_setting->editSetting(self::CODE, $this->formatFields());

            $this->update();

            $this->session->data['success'] = $this->language->get('text_success');

            if (isset($this->request->post['save_stay']) && ($this->request->post['save_stay'] = 1)) {
                $this->response->redirect($this->url->link('extension/payment/itau_shopline', 'user_token=' . $this->session->data['user_token'], true));
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

        $erros = array(
            'warning',
            'chave',
            'stores',
            'customer_groups',
            'codigo_site',
            'chave_criptografia',
            'vencimento',
            'expirar',
            'observacao1',
            'observacao2',
            'observacao3',
            'razao',
            'cnpj',
            'cpf',
            'numero_fatura',
            'complemento_fatura',
            'titulo',
            'texto_botao',
            'codigo_css'
        );

        foreach ($erros as $erro) {
            if (isset($this->error[$erro])) {
                $data['error_' . $erro] = $this->error[$erro];
            } else {
                $data['error_' . $erro] = '';
            }
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/payment/itau_shopline', 'user_token=' . $this->session->data['user_token'], true),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('extension/payment/itau_shopline', 'user_token=' . $this->session->data['user_token'], true);

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true);

        include_once(DIR_SYSTEM . 'library/itau_shopline/versao.php');

        $library = DIR_SYSTEM . 'library/itau_shopline/shopline.php';
        if (is_file($library)) {
            if (!is_readable($library)) {
                @chmod($library, 0644);
            }
        }

        $library = DIR_SYSTEM . 'library/itau_shopline/itau.php';
        if (is_file($library)) {
            if (!is_readable($library)) {
                @chmod($library, 0644);
            }
        }

        $url_key = substr(sha1(time()), -30);

        $codigo_css = <<<'EOT'
#itau_shopline {
  border-style: dashed !important;
  border-width: 2px !important;
  border-color: #777777 !important;
  padding: 10px !important;
  margin-bottom: 10px !important;
  color: #777777 !important;
}
#itau_shopline p {
  margin: 10px !important;
}
#itau_shopline a {
  padding: 10px !important;
  background-color: #777777 !important;
  color: #ffffff !important;
  text-decoration: none !important;
  text-align: center !important;
  font-weight: bold !important;
  font-family: Arial !important;
}
#itau_shopline a:hover {
    background-color: #999999 !important;
}
EOT;

        $campos = array(
            'chave' => array(0),
            'stores' => array(0),
            'customer_groups' => array(0),
            'total' => '',
            'geo_zone_id' => '',
            'status' => '',
            'sort_order' => '',
            'codigo_site' => '',
            'chave_criptografia' => '',
            'url_key' => $url_key,
            'email_notificacao' => '0',
            'vencimento' => '2',
            'expirar' => '60',
            'observacao1' => '',
            'observacao2' => '',
            'observacao3' => '',
            'prefixo' => '',
            'sufixo' => '',
            'debug' => '',
            'situacao_aguardando_id' => '',
            'situacao_gerado_id' => '',
            'situacao_compensando_id' => '',
            'situacao_nao_compensado_id' => '',
            'situacao_pago_id' => '',
            'situacao_cancelado_id' => '',
            'custom_razao_id' => '',
            'razao_coluna' => '',
            'custom_cnpj_id' => '',
            'cnpj_coluna' => '',
            'custom_cpf_id' => '',
            'cpf_coluna' => '',
            'custom_numero_id' => '',
            'numero_fatura_coluna' => '',
            'custom_complemento_id' => '',
            'complemento_fatura_coluna' => '',
            'titulo' => 'Itaú Shopline',
            'imagem' => '',
            'instrucoes_id' => '',
            'texto_botao' => 'Confirmar pedido',
            'codigo_css' => $codigo_css
        );

        foreach ($campos as $campo => $valor) {
            if (isset($this->request->post[$campo])) {
                $data[$campo] = $this->request->post[$campo];
            } else {
                $data[$campo] = !is_null($this->config->get(self::CODE . '_' . $campo)) ? $this->config->get(self::CODE . '_' . $campo) : $valor;
            }
        }

        $data['store_default'] = $this->config->get('config_name');
        $this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();

        $this->load->model('customer/customer_group');
        $data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['url_retorno'] = str_replace(array('http://', 'https://'), '', HTTP_CATALOG);
        $data['linha_comando'] = 'curl -s "' . HTTPS_CATALOG .'index.php?route=extension/payment/itau_shopline_cron&key=';

        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->load->model('tool/image');

        if (
            isset($this->request->post['imagem'])
            && is_file(DIR_IMAGE . $this->request->post['imagem'])
        ) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post['imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get('imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get('imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

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

        $this->load->model('extension/payment/itau_shopline');
        $data['columns'] = $this->model_extension_payment_itau_shopline->getOrderColumns();

        $this->load->model('catalog/information');
        $data['informations'] = $this->model_catalog_information->getInformations();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/itau_shopline', $data));
    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/payment/itau_shopline')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $chave = array_filter($this->request->post['chave']);
        if (empty($chave)) {
            $this->error['chave'] = $this->language->get('error_chave');
        }

        if (empty($this->request->post['stores'])) {
            $this->error['stores'] = $this->language->get('error_stores');
        }

        if (empty($this->request->post['customer_groups'])) {
            $this->error['customer_groups'] = $this->language->get('error_customer_groups');
        }

        $erros = array(
            'titulo',
            'texto_botao',
            'codigo_css'
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post[$erro]))) {
                $this->error[$erro] = $this->language->get('error_obrigatorio');
            }
        }

        $erros_observacoes = array(
            'observacao1',
            'observacao2',
            'observacao3'
        );

        foreach ($erros_observacoes as $erro) {
            if (strlen($this->request->post[$erro]) > 60) {
                $this->error[$erro] = $this->language->get('error_observacao');
            }
        }

        $erros_campos = array(
            'razao',
            'cnpj',
            'cpf'
        );

        foreach ($erros_campos as $erro) {
            if ($this->request->post['custom_' . $erro . '_id'] == 'C') {
                if (!(trim($this->request->post[$erro . '_coluna']))) {
                    $this->error[$erro] = $this->language->get('error_campos_coluna');
                }
            }
        }

        if ($this->request->post['custom_numero_id'] == 'C') {
            if (!(trim($this->request->post['numero_fatura_coluna']))) {
                $this->error['numero_fatura'] = $this->language->get('error_campos_coluna');
            }
        }

        if ($this->request->post['custom_complemento_id'] == 'C') {
            if (!(trim($this->request->post['complemento_fatura_coluna']))) {
                $this->error['complemento_fatura'] = $this->language->get('error_campos_coluna');
            }
        }

        if (strlen($this->request->post['codigo_site']) == 26) {
            if (!preg_match('/^[A-Z0-9]+$/', $this->request->post['codigo_site'])) {
                $this->error['codigo_site'] = $this->language->get('error_codigo_site');
            }
        } else {
            $this->error['codigo_site'] = $this->language->get('error_codigo_site');
        }

        if (strlen($this->request->post['chave_criptografia']) == 16) {
            if (!preg_match('/^[A-Za-z0-9]+$/', $this->request->post['chave_criptografia'])) {
                $this->error['chave_criptografia'] = $this->language->get('error_chave_criptografia');
            }
        } else {
            $this->error['chave_criptografia'] = $this->language->get('error_chave_criptografia');
        }

        if (strlen($this->request->post['vencimento']) >= 1) {
            if (!preg_match('/^[0-9]+$/', $this->request->post['vencimento'])) {
                $this->error['vencimento'] = $this->language->get('error_vencimento');
            }
        } else {
            $this->error['vencimento'] = $this->language->get('error_vencimento');
        }

        if (strlen($this->request->post['expirar']) >= 1) {
            if (!preg_match('/^[0-9]+$/', $this->request->post['expirar'])) {
                $this->error['expirar'] = $this->language->get('error_expirar');
            }
        } else {
            $this->error['expirar'] = $this->language->get('error_expirar');
        }

        if (
            $this->error
            && !isset($this->error['warning'])
        ) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        return !$this->error;
    }

    public function install(){
        $this->load->model('extension/payment/itau_shopline');
        $this->model_extension_payment_itau_shopline->install();
    }

    public function uninstall() {
        $this->load->model('extension/payment/itau_shopline');
        $this->model_extension_payment_itau_shopline->uninstall();

        $this->load->model('user/user_group');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/itau_shopline/log');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/itau_shopline/log');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', 'extension/itau_shopline/search');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', 'extension/itau_shopline/search');
    }

    public function update() {
        $library = DIR_SYSTEM . 'library/itau_shopline/cripto.php';
        if (is_file($library)) {
            @unlink($library);
        }

        $this->load->model('extension/payment/itau_shopline');
        $this->model_extension_payment_itau_shopline->update();

        if (!$this->user->hasPermission('modify', 'extension/itau_shopline/search')) {
            $this->load->model('user/user_group');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/itau_shopline/log');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/itau_shopline/log');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/itau_shopline/search');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/itau_shopline/search');
        }
    }

    private function formatFields() {
        $valores = array_values($this->request->post);

        $chaves = array_map(function($field) {
            return self::CODE . '_' . $field;
        }, array_keys($this->request->post));

        return array_combine($chaves, $valores);
    }
}
