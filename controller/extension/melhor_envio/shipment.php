<?php
class ControllerExtensionMelhorEnvioShipment extends Controller {
    private const TYPE = 'shipping_';
    private const NAME = 'melhor_envio';
    private const CODE = self::TYPE . self::NAME;
    private const EXTENSION = 'extension/melhor_envio/shipment';
    private const MODEL = 'model_extension_melhor_envio_shipment';

    private $store_id = '';
    private $servico = '';
    private $cep_destino = '';
    private $currency_code = '';
    private $order_products = array();

    public function index() {
        $data = $this->load->language(self::EXTENSION);

        $this->document->addScript('https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js');

        $order_id = filter_input(INPUT_GET, 'order_id');

        if ($order_id) {
            $data['melhor_envio'] = array();

            $this->load->model(self::EXTENSION);
            $melhor_envio_info = $this->{self::MODEL}->getMelhorEnvioByOrderId($order_id);

            if ($melhor_envio_info) {
                $data['melhor_envio'] = array(
                    'melhor_envio_id' => $melhor_envio_info['melhor_envio_id'],
                    'order_id' => $melhor_envio_info['order_id'],
                    'id' => $melhor_envio_info['id'],
                    'status' => $melhor_envio_info['status'],
                );
            }

            return $this->load->view(self::EXTENSION, $data);
        }
    }

    public function cart() {
        $this->load->language(self::EXTENSION);

        $json = array();

        $order_id = filter_input(INPUT_POST, 'order_id');

        $this->load->model(self::EXTENSION);
        $order_info = $this->{self::MODEL}->getOrderByOrderId($order_id);

        if (!$order_info) {
            $json['error'] = array(
                'message' => $this->language->get('error_not_found_order_id')
            );
        }

        if (!isset($json['error'])) {
            if (!preg_match("/melhor_envio/i", strtolower($order_info['shipping_code']))) {
                $json['error'] = array(
                    'message' => $this->language->get('error_not_shipping_code')
                );
            }
        }

        // if (!isset($json['error'])) {
        //     if (
        //         !isset($this->request->post['order_nfe_key'])
        //         || empty($this->request->post['order_nfe_key'])
        //     ) {
        //         $json['error'] = array(
        //             'message' => $this->language->get('error_required_nfe_key')
        //         );
        //     }
        // }

        if (!isset($json['error'])) {
            $order_products = $this->{self::MODEL}->getOrderProductByOrderId($order_id);

            /**
             * Produtos
             */
            $products = array();

            foreach ($order_products as $order_product) {
                $products[] = array(
                    'name' => $order_product['name'] . ' | ' . $order_product['model'],
                    'unitary_value' => floatval(number_format($this->currency->convert($order_product['price'], $order_info['currency_code'], 'BRL'), 2)),
                    'quantity' => intval($order_product['quantity']),
                );
            }

            /**
             * Serviço
             */
            $shipping_code = $order_info['shipping_code'];
            $shipping_code_parts = explode('.', $shipping_code);
            $service = $shipping_code_parts[2] ?? $shipping_code_parts[1];

            /**
             * Subtotal do pedido
             */
            $this->load->model('sale/order');
            $order_totals = $this->model_sale_order->getOrderTotals($order_id);

            $sub_total = array_filter($order_totals, function($item) {
                return $item['code'] == 'sub_total';
            });

            /**
             * Volumes
             */
            $this->servico = $service;
            $this->subtotal = floatval($sub_total[0]['value']);
            $this->order_products = $order_products;

            $this->store_id = $order_info['store_id'];
            $this->cep_destino = $order_info['shipping_postcode'];
            $this->currency_code = $order_info['currency_code'];

            $volumes = $this->volumes();

            /**
             * Remetente
             */
            $from = array(
                'name' => $this->config->get(self::CODE . '_remetente_nome'),
                'phone' => $this->config->get(self::CODE . '_remetente_telefone'),
                'email' => $this->config->get(self::CODE . '_remetente_email'),
                'company_document' => $this->config->get(self::CODE . '_remetente_cnpj'),
                'state_register' => $this->config->get(self::CODE . '_remetente_ie'),
                'postal_code' => $this->config->get(self::CODE . '_remetente_cep'),
                'address' => $this->config->get(self::CODE . '_remetente_endereco'),
                'number' => $this->config->get(self::CODE . '_remetente_numero'),
                'complement' => $this->config->get(self::CODE . '_remetente_complemento'),
                'district' => $this->config->get(self::CODE . '_remetente_bairro'),
                'city' => $this->config->get(self::CODE . '_remetente_cidade'),
                'state_abbr' => $this->config->get(self::CODE . '_remetente_uf'),
                'country_id' => 'BR',
                'note' => $this->config->get(self::CODE . '_remetente_nota'),
                'agencia' => $this->config->get(self::CODE . '_remetente_agencia'),
                'cnae' => $this->config->get(self::CODE . '_remetente_cnae'),
            );

            /**
             * Destinatário
             */
            $custom_field_razao_social = $this->config->get(self::CODE . '_custom_field_razao_social');
            $custom_field_cnpj = $this->config->get(self::CODE . '_custom_field_cnpj');
            $custom_field_cpf = $this->config->get(self::CODE . '_custom_field_cpf');

            $custom_field = json_decode($order_info['custom_field'], true);
            $shipping_custom_field = json_decode($order_info['shipping_custom_field'], true);

            $document = $custom_field[$custom_field_cpf] ?? null;
            $company_document = $custom_field[$custom_field_cnpj] ?? null;

            if (
                isset($custom_field[$custom_field_razao_social])
                && !empty($custom_field[$custom_field_razao_social])
            ) {
                $to_name = $custom_field[$custom_field_razao_social];
            } else {
                $to_name = trim($order_info['shipping_firstname']) . ' ' . trim($order_info['shipping_lastname']);
            }

            $custom_field_numero = $this->config->get(self::CODE . '_custom_field_numero');
            $custom_field_complemento = $this->config->get(self::CODE . '_custom_field_complemento');

            $to_note = filter_input(INPUT_POST, 'note') ?? '';

            $to = array(
                'name' => $to_name,
                'phone' => $order_info['telephone'],
                'email' => $order_info['email'],
                'document' => $document,
                'company_document' => $company_document,
                'postal_code' => $this->cep_destino,
                'address' => $order_info['shipping_address_1'],
                'number' => $shipping_custom_field[$custom_field_numero] ?? '',
                'complement' => $shipping_custom_field[$custom_field_complemento] ?? '',
                'district' => $order_info['shipping_address_2'],
                'city' => $order_info['shipping_city'],
                'state_abbr' => $order_info['shipping_zone_code'],
                'country_id' => 'BR',
                'note' => $to_note,
            );

            /**
             * Adicionais
             */
            $prefix = $this->config->get(self::CODE . '_prefixo');

            if (!empty($prefix)) {
                $tag = "{$prefix}-{$order_id}";
            } else {
                $tag = $order_id;
            }

            $insurance = filter_input(INPUT_POST, 'order_insurance') ?? 0;
            $nfe_key = preg_replace("/[^0-9]/", '', $this->request->post['order_nfe_key'] ?? '');

            $options = array(
                'insurance_value' => $insurance == 1 ? floatval($sub_total[0]['value']) : 0,
                'receipt' => !!$this->config->get(self::CODE . '_aviso_recebimento'),
                'own_hand' => !!$this->config->get(self::CODE . '_mao_propria'),
                'reverse' => false,
                'invoice' => array(
                    'key' => $nfe_key,
                ),
                'tags' => array(
                    'tag' => $tag,
                )
            );

            /**
             * Dados organizados para
             * solicitação de envio
             */
            $dados = array();

            $chave = $this->config->get(self::CODE . '_chave');
            $dados['chave'] = $chave[$order_info['store_id']];
            $dados['debug'] = $this->config->get(self::CODE . '_debug');
            $dados['sandbox'] = $this->config->get(self::CODE . '_sandbox');
            $dados['token'] = $this->config->get(self::CODE . '_token');

            $dados['service'] = $service;

            $dados['from'] = array_filter($from);
            $dados['to'] = array_filter($to);

            $dados['products'] = array_filter($products);
            $dados['volumes'] = array_filter($volumes);
            $dados['options'] = $options;

            require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');

            $melhor_envio = new MelhorEnvio();
            $melhor_envio->setParams($dados);

            $response = $melhor_envio->setAddCart();

            if (isset($response->id)) {
                $melhor_envio_id = $this->{self::MODEL}->addMelhorEnvio(
                    array(
                        'order_id' => $order_id,
                        'id' => $response->id,
                        'status' => $response->status,
                    )
                );

                $json['success'] = true;
                $json['melhor_envio_id'] = $melhor_envio_id;
            } elseif (isset($response->error)) {
                $json['error'] = array(
                    'message' => (string) $response->error
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function remove() {
        $this->load->language(self::EXTENSION);

        $json = array();

        $melhor_envio_id = filter_input(INPUT_GET, 'melhor_envio_id', FILTER_SANITIZE_NUMBER_INT) ?? '';

        $this->load->model(self::EXTENSION);
        $melhor_envio_info = $this->{self::MODEL}->getMelhorEnvioByMelhorEnvioId($melhor_envio_id);

        if (!$melhor_envio_info) {
            $json['error'] = array(
                'message' => $this->language->get('error_not_found_me_id')
            );
        }

        if (!isset($json['error'])) {
            $id = $melhor_envio_info['id'];

            $dados = array();

            $chave = $this->config->get(self::CODE . '_chave');
            $dados['chave'] = $chave[$melhor_envio_info['store_id']];
            $dados['debug'] = $this->config->get(self::CODE . '_debug');
            $dados['sandbox'] = $this->config->get(self::CODE . '_sandbox');
            $dados['token'] = $this->config->get(self::CODE . '_token');
            $dados['id'] = $id;

            require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');

            $melhor_envio = new MelhorEnvio();
            $melhor_envio->setParams($dados);

            $response = (array) $melhor_envio->setRemoveCart();

            if ($response) {
                $status = '';

                $result = (array) $melhor_envio->getTracking();

                if (isset($result[$id])) {
                    $details = (array) $result[$id];

                    $status = $details['status'];
                }

                if (
                    $status == 'pending'
                    || $status == 'canceled'
                    || isset($response['message'])
                ) {
                    $this->{self::MODEL}->delMelhorEnvio($melhor_envio_id);

                    $json['success'] = true;
                } else {
                    $json['error'] = array(
                        'message' => $this->language->get('error_remove_cart'),
                    );
                }
            } else {
                $json['error'] = array(
                    'message' => $this->language->get('error_remove_cart'),
                );
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function preview() {
        $this->load->language(self::EXTENSION);

        $melhor_envio_id = filter_input(INPUT_GET, 'melhor_envio_id', FILTER_SANITIZE_NUMBER_INT) ?? '';

        $this->load->model(self::EXTENSION);
        $melhor_envio_info = $this->{self::MODEL}->getMelhorEnvioByMelhorEnvioId($melhor_envio_id);

        if (!$melhor_envio_info) {
            die($this->language->get('error_not_found_me_id'));
        }

        $dados = array();

        $chave = $this->config->get(self::CODE . '_chave');
        $dados['chave'] = $chave[$melhor_envio_info['store_id']];
        $dados['debug'] = $this->config->get(self::CODE . '_debug');
        $dados['sandbox'] = $this->config->get(self::CODE . '_sandbox');
        $dados['token'] = $this->config->get(self::CODE . '_token');
        $dados['id'] = $melhor_envio_info['id'];

        require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');

        $melhor_envio = new MelhorEnvio();
        $melhor_envio->setParams($dados);

        $response = (array) $melhor_envio->getPreview();

        if (isset($response['url'])) {
            $this->response->redirect($response['url']);
        } elseif (isset($response['error'])) {
            echo $response['error'];
        }
    }

    public function tracking() {
        $data = $this->load->language(self::EXTENSION);

        $melhor_envio_id = filter_input(INPUT_GET, 'melhor_envio_id', FILTER_SANITIZE_NUMBER_INT) ?? '';

        $this->load->model(self::EXTENSION);
        $melhor_envio_info = $this->{self::MODEL}->getMelhorEnvioByMelhorEnvioId($melhor_envio_id);

        if (!$melhor_envio_info) {
            $data['error'] = $this->language->get('error_not_found_me_id');
        }

        if (!isset($data['erro'])) {
            $id = $melhor_envio_info['id'];

            $dados = array();

            $chave = $this->config->get(self::CODE . '_chave');
            $dados['chave'] = $chave[$melhor_envio_info['store_id']];
            $dados['debug'] = $this->config->get(self::CODE . '_debug');
            $dados['sandbox'] = $this->config->get(self::CODE . '_sandbox');
            $dados['token'] = $this->config->get(self::CODE . '_token');
            $dados['id'] = $id;

            require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');

            $melhor_envio = new MelhorEnvio();
            $melhor_envio->setParams($dados);

            $response = (array) $melhor_envio->getTracking();

            if (isset($response[$id])) {
                $details = (array) $response[$id];
                $status = $details['status'];

                switch ($status) {
                    case 'pending':
                        $status_message = $this->language->get('text_status_pending');

                        break;
                    case 'released':
                        $status_message = $this->language->get('text_status_released');

                        break;
                    case 'posted':
                        $status_message = $this->language->get('text_status_posted');

                        break;
                    case 'delivered':
                        $status_message = $this->language->get('text_status_delivered');

                        break;
                    case 'canceled':
                        $status_message = $this->language->get('text_status_canceled');

                        break;
                    case 'undelivered':
                        $status_message = $this->language->get('text_status_undelivered');

                        break;
                }

                $data['id'] = $details['id'];
                $data['tracking'] = $details['tracking'];
                $data['status_message'] = $status_message;
                $data['date_formated'] = $status_message;

                $this->{self::MODEL}->editMelhorEnvio(
                    array(
                        'melhor_envio_id' => $melhor_envio_id,
                        'status' => $status,
                    )
                );
            } elseif (isset($response['error'])) {
                $data['error'] = $response['error'];
            } else {
                $data['error'] = $this->language->get('error_tracking');
            }
        }

        $this->response->setOutput($this->load->view('extension/' . self::NAME . '/tracking', $data));
    }

    private function itens() {
        $i = 0;
        $itens = array();

        foreach ($this->order_products as $product) {
            if (!$product['shipping']) {
                continue;
            }

            if (
                $product['width'] <= 0
                || $product['height'] <= 0
                || $product['length'] <= 0
                || $product['weight'] <= 0
            ) {
                return array();
            }

            $quantidade = $product['quantity'];
            $peso_unitario = $this->weight->convert($product['weight'] / $quantidade, $product['weight_class_id'], $this->weight_class_id);

            $largura = $this->length->convert($product['width'], $product['length_class_id'], $this->length_class_id);
            $comprimento = $this->length->convert($product['length'], $product['length_class_id'], $this->length_class_id);
            $altura = $this->length->convert($product['height'], $product['length_class_id'], $this->length_class_id);

            $peso_unitario = number_format($peso_unitario, 3, '.', '');
            $largura = number_format($largura, 2, '.', '');
            $altura = number_format($altura, 2, '.', '');
            $comprimento = number_format($comprimento, 2, '.', '');

            $itens[$i]['id'] = $product['product_id'];
            $itens[$i]['weight'] = (float) $peso_unitario;
            $itens[$i]['width'] = (float) $largura;
            $itens[$i]['height'] = (float) $altura;
            $itens[$i]['length'] = (float) $comprimento;
            $itens[$i]['quantity'] = (float) $quantidade;

            if ($this->config->get(self::CODE . '_valor_segurado')) {
                $preco = number_format($this->currency->convert($product['price'], $this->currency_code, 'BRL'), 2);

                $itens[$i]['insurance_value'] = (float) $preco;
            }

            $i++;
        }

        return $itens;
    }

    private function volumes() {
        $chave = $this->config->get(self::CODE . '_chave');
        $chave = $chave[$this->store_id];
        $debug = $this->config->get(self::CODE . '_debug');
        $sandbox = $this->config->get(self::CODE . '_sandbox');
        $token = $this->config->get(self::CODE . '_token');
        $cep_origem = $this->config->get(self::CODE . '_remetente_cep');
        $aviso_recebimento = !!$this->config->get(self::CODE . '_aviso_recebimento');
        $mao_propria = !!$this->config->get(self::CODE . '_mao_propria');

        $dados = array();

        $dados['chave'] = $chave;
        $dados['debug'] = $debug;
        $dados['sandbox'] = $sandbox;
        $dados['token'] = $token;
        $dados['from_postal_code'] = $cep_origem;
        $dados['to_postal_code'] = $this->cep_destino;
        $dados['products'] = $this->itens();
        $dados['receipt'] = $aviso_recebimento;
        $dados['own_hand'] = $mao_propria;
        $dados['services'] = $this->servico;

        require_once(DIR_SYSTEM . 'library/melhor-envio/melhor_envio.php');
        $melhor_envio = new MelhorEnvio();
        $melhor_envio->setParams($dados);

        $response = $melhor_envio->getCalculate();

        if (isset($response->packages)) {
            $volumes = array();

            $packages = $response->packages;

            foreach ($packages as $package) {
                array_push($volumes, array(
                    'height' => $package->dimensions->height,
                    'width' => $package->dimensions->width,
                    'length' => $package->dimensions->length,
                    'weight' => $package->weight,
                ));
            }

            return $volumes;
        }

        return array();
    }
}
