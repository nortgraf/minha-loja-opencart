<?php
class ControllerExtensionItauShoplineSearch extends Controller {
    private $error = array();

    public function index() {
        $data = $this->load->language('extension/itau_shopline/search');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->document->addStyle('//cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css');
        $this->document->addStyle('view/javascript/bootstrap/css/bootstrap-glyphicons.css');
        $this->document->addScript('//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js');
        $this->document->addScript('//cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/itau_shopline/search', 'user_token=' . $this->session->data['user_token'], true)
        );

        $this->load->model('extension/payment/itau_shopline');
        $transactions = $this->model_extension_payment_itau_shopline->getTransactions();

        $data['transactions'] = array();

        foreach ($transactions as $transaction) {
            $action = array();

            switch ($transaction['tippag']) {
                case '00':
                    $tipo = $this->language->get('text_nao_escolhido');
                    break;
                case '01':
                    $tipo = $this->language->get('text_tef_cdc');
                    break;
                case '02':
                    $tipo = $this->language->get('text_boleto');
                    break;
                case '03':
                    $tipo = $this->language->get('text_credito');
                    break;
            }

            switch ($transaction['sitpag']) {
                case '00':
                    $situacao = $this->language->get('text_pago');
                    break;
                case '01':
                    $situacao = $this->language->get('text_nao_finalizado');
                    break;
                case '02':
                    $situacao = $this->language->get('text_erro_sonda');
                    break;
                case '03':
                    $situacao = $this->language->get('text_erro_pedido');
                    break;
                case '04':
                    $situacao = $this->language->get('text_gerado');
                    break;
                case '05':
                    $situacao = $this->language->get('text_compensando');
                    break;
                case '06':
                    $situacao = $this->language->get('text_nao_compensado');
                    break;
            }

            $action[] = array(
                'name' => 'button-excluir',
                'title' => $this->language->get('button_excluir'),
                'icon' => 'fa fa-trash-o',
                'class' => 'btn btn-danger',
                'id' => $transaction['order_itaushopline_id']
            );

            if ($transaction['sitpag'] != '00') {
                $action[] = array(
                    'name' => 'button-sonda',
                    'title' => $this->language->get('button_sonda'),
                    'icon' => 'fa fa-refresh',
                    'class' => 'btn btn-info',
                    'id' => $transaction['order_id']
                );
            }

            $data['transactions'][] = array(
                'itaushopline_id' => $transaction['order_itaushopline_id'],
                'order_id' => $transaction['order_id'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($transaction['date_added'])),
                'customer' => $transaction['customer'],
                'tipo' => $tipo,
                'data_pagamento' => (!empty($transaction['dtpag'])) ? $this->convertDate($transaction['dtpag']) : '',
                'valor' => $transaction['valor'],
                'autorizacao' => $transaction['codaut'],
                'nsu' => $transaction['numid'],
                'situacao' => $situacao,
                'view' => $this->url->link('sale/order/info', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . $transaction['order_id'], true),
                'action' => $action
            );
        }

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/itau_shopline/search', $data));
    }

    public function excluir() {
        $json = array();

        $this->load->language('extension/itau_shopline/search');

        if ($this->user->hasPermission('modify', 'extension/itau_shopline/search')) {
            if (isset($this->request->get['itaushopline_id'])) {
                $itaushopline_id = $this->request->get['itaushopline_id'];

                $this->load->model('extension/payment/itau_shopline');

                $this->model_extension_payment_itau_shopline->deleteTransaction($itaushopline_id);

                $json['message'] = $this->language->get('text_excluida');
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function consultar() {
        $json = array();

        $this->load->language('extension/itau_shopline/search');

        if ($this->user->hasPermission('modify', 'extension/itau_shopline/search')) {
            if (isset($this->request->get['order_id'])) {
                $order_id = (int) $this->request->get['order_id'];

                $resposta = $this->getConsultar($order_id);
                if ($resposta) {
                    $situacao = $resposta['sitpag'];
                    if (!empty($situacao)) {
                        $dados['valor'] = $resposta['valor'];
                        $dados['tippag'] = $resposta['tippag'];
                        $dados['sitpag'] = $resposta['sitpag'];
                        $dados['dtpag'] = $resposta['dtpag'];
                        $dados['codaut'] = $resposta['codaut'];
                        $dados['numid'] = $resposta['numid'];
                        $dados['compvend'] = $resposta['compvend'];
                        $dados['tipcart'] = $resposta['tipcart'];
                        $dados['order_id'] = $order_id;

                        $this->load->model('extension/payment/itau_shopline');

                        switch($situacao){
                            case '00':
                                $this->model_extension_payment_itau_shopline->editTransaction($dados);
                                $json['message'] = $this->language->get('text_pago');
                                break;
                            case '01':
                                $this->model_extension_payment_itau_shopline->editTransaction($dados);
                                $json['message'] = $this->language->get('text_nao_finalizado');
                                break;
                            case '02':
                                $json['message'] = $this->language->get('text_erro_sonda');
                                break;
                            case '03':
                                $this->model_extension_payment_itau_shopline->editTransaction($dados);
                                $json['message'] = $this->language->get('text_erro_pedido');
                                break;
                            case '04':
                                $this->model_extension_payment_itau_shopline->editTransaction($dados);
                                $json['message'] = $this->language->get('text_gerado');
                                break;
                            case '05':
                                $this->model_extension_payment_itau_shopline->editTransaction($dados);
                                $json['message'] = $this->language->get('text_compensando');
                                break;
                            case '06':
                                $this->model_extension_payment_itau_shopline->editTransaction($dados);
                                $json['message'] = $this->language->get('text_nao_compensado');
                                break;
                        }
                    }
                } else {
                    $json['error'] = $this->language->get('error_sonda');
                }
            } else {
                $json['error'] = $this->language->get('error_warning');
            }
        } else {
            $json['error'] = $this->language->get('error_permission');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    private function convertDate($date) {
        $pattern = '/(\d{2})(\d{2})(\d{4})/';
        preg_match($pattern, $date, $result);
        return $result[1] . '/' . $result[2] . '/' . $result[3];
    }

    private function getConsultar($order_id) {
        $codemp = strtoupper(trim($this->config->get('payment_itau_shopline_codigo_site')));
        $remover = array($this->config->get('payment_itau_shopline_prefixo'), $this->config->get('payment_itau_shopline_sufixo'));
        $pedido = str_replace($remover, '', $order_id);
        $chave_criptografia = strtoupper(trim($this->config->get('payment_itau_shopline_chave_criptografia')));

        $this->load->model('extension/payment/itau_shopline');
        $store_id = $this->model_extension_payment_itau_shopline->getStoreID($order_id);

        require_once(DIR_SYSTEM . 'library/itau_shopline/itau.php');
        $itau = new Itau();

        $chave = $this->config->get('payment_itau_shopline_chave');
        $dados['chave'] = $chave[$store_id];
        $dados['debug'] = $this->config->get('payment_itau_shopline_debug');
        $dados['dc'] = $itau->consulta($codemp, $pedido, '1', $chave_criptografia);

        require_once(DIR_SYSTEM . 'library/itau_shopline/shopline.php');
        $shopline = new Shopline();
        $shopline->setParametros($dados);
        $resposta = $shopline->getSonda();

        if (($resposta) && isset($resposta->Valor)) {
            return array(
                'valor' => $resposta->Valor,
                'tippag' => $resposta->tipPag,
                'sitpag' => $resposta->sitPag,
                'dtpag' => $resposta->dtPag,
                'codaut' => $resposta->codAut,
                'numid' => $resposta->numId,
                'compvend' => $resposta->compVend,
                'tipcart' => $resposta->tipCart
            );
        } else {
            return false;
        }
    }
}