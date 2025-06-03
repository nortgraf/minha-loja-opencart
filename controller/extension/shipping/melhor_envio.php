<?php
require_once DIR_SYSTEM . 'library/melhor-envio/engine.php';

class ControllerExtensionShippingMelhorEnvio extends Controller {
    use MelhorEnvioEngine;

    const TYPE = 'shipping_';
    const NAME = 'melhor_envio';
    const CODE = self::TYPE . self::NAME;
    const EXTENSION = 'extension/shipping/' . self::NAME;
    const EXTENSIONS = 'marketplace/extension';
    const MODEL = 'model_extension_shipping_melhor_envio';
    const PERMISSION = 'extension/' . self::NAME;

    private $error = array();

    public function index() {
        $data = $this->load->language(self::EXTENSION);

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (
            $this->request->server['REQUEST_METHOD'] == 'POST'
            && $this->validate()
        ) {
            $this->model_setting_setting->editSetting(self::CODE, $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->update();

            if (
                isset($this->request->post['save_stay'])
                && $this->request->post['save_stay'] = 1
            ) {
                $this->response->redirect($this->url->link(self::EXTENSION, 'user_token=' . $this->session->data['user_token'], true));
            } else {
                $this->response->redirect($this->url->link(self::EXTENSIONS, 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true));
            }
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        $data['requisitos'] = $this->getMelhorEnvioRequirements();

        $data['version'] = $this->getMelhorEnvioVersion();

        $latest_version = $this->getMelhorEnvioUpgrade();

        $data['upgrade'] = $latest_version ? sprintf($this->language->get('text_upgrade'), $latest_version) : '';

        $data['user_token'] = $this->session->data['user_token'];

        $erros = array(
            'warning',
            'chave',
            'stores',
            'customer_groups',
            'weight_class_id',
            'length_class_id',
            'token',
            'prefixo',
            'remetente_nome',
            'remetente_telefone',
            'remetente_email',
            'remetente_cnpj',
            'remetente_ie',
            'remetente_cep',
            'remetente_endereco',
            'remetente_numero',
            'remetente_complemento',
            'remetente_bairro',
            'remetente_cidade',
            'remetente_uf',
            'documento_obrigatorio',
            'custom_field_numero',
            'promocoes',
            'restricoes',
            'bloqueios',
            'titulo',
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
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link(self::EXTENSIONS, 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link(self::EXTENSION, 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['action'] = $this->url->link(self::EXTENSION, 'user_token=' . $this->session->data['user_token'], true);
        $data['cancel'] = $this->url->link(self::EXTENSIONS, 'user_token=' . $this->session->data['user_token'] . '&type=shipping', true);

        $data['servicos_data'] = $data[self::CODE . '_servicos'] ?? $this->servicos(true);

        $campos = array(
            'chave' => array(0),
            'stores' => array(0),
            'customer_groups' => array(0),
            'total' => '',
            'peso_minimo' => '',
            'peso_maximo' => '',
            'weight_class_id' => '',
            'length_class_id' => '',
            'tax_class_id' => '',
            'geo_zone_id' => '',
            'status' => '',
            'sort_order' => '',
            'token' => '',
            'sandbox' => '0',
            'debug' => '1',
            'prefixo' => '',
            'valor_segurado' => '1',
            'aviso_recebimento' => '0',
            'mao_propria' => '0',
            'exibir_data' => '0',
            'tipo_custo' => '',
            'custo_adicional' => '',
            'remetente_nome' => '',
            'remetente_telefone' => '',
            'remetente_email' => '',
            'remetente_cnpj' => '',
            'remetente_ie' => '',
            'remetente_cep' => '',
            'remetente_endereco' => '',
            'remetente_numero' => '',
            'remetente_complemento' => '',
            'remetente_bairro' => '',
            'remetente_cidade' => '',
            'remetente_uf' => '',
            'remetente_nota' => '',
            'remetente_agencia' => '',
            'remetente_cnae' => '',
            'custom_field_razao_social' => '',
            'custom_field_cnpj' => '',
            'custom_field_cpf' => '',
            'custom_field_numero' => '',
            'custom_field_complemento' => '',
            'servicos' => array(),
            'promocoes' => array(),
            'restricoes' => array(),
            'bloqueios' => array(),
            'titulo' => 'Melhor Envio',
            'imagem' => '',
        );

        foreach ($campos as $campo => $valor) {
            if (isset($this->request->post[self::CODE . '_' . $campo])) {
                $data[self::CODE . '_' . $campo] = $this->request->post[self::CODE . '_' . $campo];
            } else {
                $data[self::CODE . '_' . $campo] = !is_null($this->config->get(self::CODE . '_' . $campo)) ? $this->config->get(self::CODE . '_' . $campo) : $valor;
            }
        }

        $data['stores_data'][] = array(
            'store_id' => 0,
            'name' => $this->config->get('config_name')
        );

        $this->load->model('setting/store');
        $stores = $this->model_setting_store->getStores();

        foreach ($stores as $store) {
            $data['stores_data'][] = array(
                'store_id' => $store['store_id'],
                'name' => $store['name']
            );
        }

        $this->load->model('customer/customer_group');
        $data['customer_groups_data'] = $this->model_customer_customer_group->getCustomerGroups();

        $this->load->model('localisation/weight_class');
        $data['weight_classes_data'] = $this->model_localisation_weight_class->getWeightClasses();

        $this->load->model('localisation/length_class');
        $data['length_classes_data'] = $this->model_localisation_length_class->getLengthClasses();

        $this->load->model('localisation/tax_class');
        $data['tax_classes_data'] = $this->model_localisation_tax_class->getTaxClasses();

        $this->load->model('localisation/geo_zone');
        $data['geo_zones_data'] = $this->model_localisation_geo_zone->getGeoZones();

        $this->load->model('localisation/zone');
        $data['zones_data'] = $this->model_localisation_zone->getZonesByCountryId(30);

        $this->load->model('customer/custom_field');
        $data['custom_fields_data'] = $this->model_customer_custom_field->getCustomFields();

        $data['custom_field_link'] = $this->url->link('customer/custom_field', 'user_token=' . $this->session->data['user_token'], true);

        $data['descontos_data'] = array(
            'P' => $this->language->get('text_percentual'),
            'F' => $this->language->get('text_fixo'),
            'U' => $this->language->get('text_unico')
        );

        $data['categories_data'] = array();

        $this->load->model('catalog/category');
        $categories = $this->model_catalog_category->getCategories(array('sort' => 'name', 'order' => 'ASC'));

        foreach ($categories as $category) {
            $data['categories_data'][] = array(
                'category_id' => $category['category_id'],
                'name' => str_replace("'", "&#39;", $category['name'])
            );
        }

        $this->load->model('tool/image');

        if (
            isset($this->request->post[self::CODE . '_imagem'])
            && is_file(DIR_IMAGE . $this->request->post[self::CODE . '_imagem'])
        ) {
            $data['thumb'] = $this->model_tool_image->resize($this->request->post[self::CODE . '_imagem'], 100, 100);
        } elseif (is_file(DIR_IMAGE . $this->config->get(self::CODE . '_imagem'))) {
            $data['thumb'] = $this->model_tool_image->resize($this->config->get(self::CODE . '_imagem'), 100, 100);
        } else {
            $data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        }

        $data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view(self::EXTENSION, $data));
    }

    public function servicos($array = false) {
        $data = array();

        $dados = array();
        $dados['debug'] = $this->config->get(self::CODE . '_debug') ?? true;
        $dados['sandbox'] = $this->config->get(self::CODE . '_sandbox') ?? true;

        require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');

        $melhor_envio = new MelhorEnvio();
        $melhor_envio->setParams($dados);

        $servicos = $melhor_envio->getServices();

        if ($servicos) {
            foreach ($servicos as $servico) {
                $data[] = array(
                    'id' => $servico->id,
                    'transportadora' => $servico->company->name,
                    'servico' => $servico->name,
                    'descricao' => $servico->name,
                    'prazo_adicional' => '0',
                    'status' => '1',
                );
            }
        }

        if ($array) {
            return $data;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
    }

    public function agencias() {
        $json = array();

        $uf = filter_input(INPUT_GET, 'uf') ?? '';

        if (!empty($uf)) {
            $dados = array();
            $dados['debug'] = $this->config->get(self::CODE . '_debug') ?? true;
            $dados['sandbox'] = $this->config->get(self::CODE . '_sandbox') ?? true;
            $dados['state'] = $uf;

            require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');

            $melhor_envio = new MelhorEnvio();
            $melhor_envio->setParams($dados);

            $agencias = $melhor_envio->getAgencies();

            if ($agencias) {
                foreach ($agencias as $agencia) {
                    $json[] = array(
                        'id' => $agencia->id,
                        'name' => $agencia->name,
                        'address' => $agencia->address->address,
                        'district' => $agencia->address->district,
                        'city' => $agencia->address->city->city,
                    );
                }
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', self::EXTENSION)) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        $chave = array_filter($this->request->post[self::CODE . '_chave']);

        if (empty($chave)) {
            $this->error['chave'] = $this->language->get('error_chave');
        }

        if (empty($this->request->post[self::CODE . '_stores'])) {
            $this->error['stores'] = $this->language->get('error_stores');
        }

        if (empty($this->request->post[self::CODE . '_customer_groups'])) {
            $this->error['customer_groups'] = $this->language->get('error_customer_groups');
        }

        if (strlen(preg_replace('/[^0-9]/', '', $this->request->post[self::CODE . '_remetente_cep'])) != 8) {
            $this->error['remetente_cep'] = $this->language->get('error_remetente_cep');
        }

        $erros = array(
            'weight_class_id',
            'length_class_id',
            'token',
            'remetente_nome',
            'remetente_telefone',
            'remetente_email',
            'remetente_endereco',
            'remetente_numero',
            'remetente_bairro',
            'remetente_cidade',
            'remetente_uf',
            'titulo',
        );

        foreach ($erros as $erro) {
            if (!(trim($this->request->post[self::CODE . '_' . $erro]))) {
                $this->error[$erro] = $this->language->get('error_obrigatorio');
            }
        }

        $prefixo = trim($this->request->post[self::CODE . '_prefixo'] ?? '');

        if (
            !empty($prefixo)
            && preg_match('/[^A-Z]/i', $prefixo)
        ) {
            $this->error['prefixo'] = $this->language->get('error_prefixo');
        }

        $remetente_cnpj = trim($this->request->post[self::CODE . '_remetente_cnpj'] ?? '');

        if (!$this->validateCnpj($remetente_cnpj)) {
            $this->error['remetente_cnpj'] = $this->language->get('error_documento_invalido');
        }

        $remetente_ie = trim($this->request->post[self::CODE . '_remetente_ie'] ?? '');

        if (empty($remetente_ie)) {
            $this->error['remetente_ie'] = $this->language->get('error_obrigatorio');
        }

        $cpf = trim($this->request->post[self::CODE . '_custom_field_cpf']);
        $cnpj = trim($this->request->post[self::CODE . '_custom_field_cnpj']);

        if (
            empty($cpf)
            && empty($cnpj)
        ) {
            $this->error['documento_obrigatorio'] = $this->language->get('error_documento_obrigatorio');
        }

        if (!empty($this->request->post[self::CODE . '_promocoes'])) {
            $colunas = array(
                'servico',
                'descricao',
                'cep_inicial',
                'cep_final',
                'desconto',
            );

            foreach ($this->request->post[self::CODE . '_promocoes'] as $promocao) {
                foreach ($colunas as $coluna) {
                    if (
                        !isset($promocao[$coluna])
                        || utf8_strlen($promocao[$coluna]) == 0
                    ) {
                        $this->error['promocoes'] = $this->language->get('error_promocao_invalida');

                        break 2;
                    }
                }
            }
        }

        if (!empty($this->request->post[self::CODE . '_restricoes'])) {
            $colunas = array(
                'servico',
                'descricao',
                'cep_inicial',
                'cep_final',
            );

            foreach ($this->request->post[self::CODE . '_restricoes'] as $restricao) {
                foreach ($colunas as $coluna) {
                    if (
                        !isset($restricao[$coluna])
                        || utf8_strlen($restricao[$coluna]) == 0
                    ) {
                        $this->error['restricoes'] = $this->language->get('error_restricao_invalida');

                        break 2;
                    }
                }
            }
        }

        if (!empty($this->request->post[self::CODE . '_bloqueios'])) {
            $colunas = array(
                'servico',
                'category_id',
            );

            foreach ($this->request->post[self::CODE . '_bloqueios'] as $bloqueio) {
                foreach ($colunas as $coluna) {
                    if (
                        !isset($bloqueio[$coluna])
                        || utf8_strlen($bloqueio[$coluna]) == 0
                    ) {
                        $this->error['bloqueios'] = $this->language->get('error_bloqueio_invalido');

                        break 2;
                    }
                }
            }
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
        $this->load->model(self::EXTENSION);
        $this->{self::MODEL}->install();
    }

    public function uninstall() {
        /*
        $this->load->model(self::EXTENSION);
        $this->{self::MODEL}->uninstall();
        */

        $this->load->model('user/user_group');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', self::PERMISSION . '/shipment');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', self::PERMISSION . '/shipment');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'access', self::PERMISSION . '/log');
        $this->model_user_user_group->removePermission($this->user->getGroupId(), 'modify', self::PERMISSION . '/log');
    }

    public function update() {
        $this->load->model(self::EXTENSION);
        $this->{self::MODEL}->update();

        $this->load->model('user/user_group');

        if (!$this->user->hasPermission('modify', self::PERMISSION . '/shipment')) {
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', self::PERMISSION . '/shipment');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', self::PERMISSION . '/shipment');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', self::PERMISSION . '/log');
            $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', self::PERMISSION . '/log');
        }
    }

    /**
     * This file is part of Respect/Validation.
     * https://github.com/Respect/Validation/blob/master/library/Rules/Cnpj.php
     *
     * @license: https://github.com/Respect/Validation/blob/3145426472e3a6fbb5abbddc25a0cc0cf3b4e2fe/LICENSE
     */
    private function validateCnpj($input) {
        if (!is_scalar($input)) {
            return false;
        }

        // Code ported from jsfromhell.com
        $bases = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        $digits = array_map(
            'intval',
            str_split((string) preg_replace('/\D/', '', (string) $input))
        );

        if (array_sum($digits) < 1) {
            return false;
        }

        if (count($digits) !== 14) {
            return false;
        }

        $n = 0;

        for ($i = 0; $i < 12; ++$i) {
            $n += $digits[$i] * $bases[$i + 1];
        }

        if ($digits[12] != (($n %= 11) < 2 ? 0 : 11 - $n)) {
            return false;
        }

        $n = 0;

        for ($i = 0; $i <= 12; ++$i) {
            $n += $digits[$i] * $bases[$i];
        }

        $check = ($n %= 11) < 2 ? 0 : 11 - $n;

        return $digits[13] == $check;
    }
}
